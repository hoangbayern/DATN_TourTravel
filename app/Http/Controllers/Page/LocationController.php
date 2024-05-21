<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class LocationController extends Controller
{
    public function index(Request $request, $id)
    {
        // Lấy Location và eager load các tours
        $location = Location::where('id', $id)
            ->with('tours')
            ->first();
        $locations = Location::all();

        // Nếu không tìm thấy location, bạn có thể trả về một thông báo lỗi hoặc chuyển hướng
        if (!$location) {
            return redirect()->back()->with('error', 'Location not found');
        }

        // Lấy các tours liên quan
        $tours = $location->tours;

        // Áp dụng các điều kiện lọc từ request
        if ($request->key_tour) {
            $tours = $tours->filter(function($tour) use ($request) {
                return stripos($tour->t_title, $request->key_tour) !== false;
            });
        }

        if ($request->t_start_date) {
            $startDate = date('Y-m-d', strtotime($request->t_start_date));
            $tours = $tours->filter(function($tour) use ($startDate) {
                return $tour->t_start_date >= $startDate;
            });
        }

        if ($request->t_end_date) {
            $endDate = date('Y-m-d', strtotime($request->t_end_date));
            $tours = $tours->filter(function($tour) use ($endDate) {
                return $tour->t_end_date <= $endDate;
            });
        }

        if ($request->price) {
            $price = explode('-', $request->price);
            $tours = $tours->filter(function($tour) use ($price) {
                return $tour->t_price_adults >= $price[0] && $tour->t_price_adults <= $price[1];
            });
        }

        $Ct = now()->format('Y-m-d');
        $tours = $tours->filter(function($tour) use ($Ct) {
            return $tour->t_start_date > $Ct && $tour->t_end_date >= $Ct && $tour->t_status == 1;
        });

        // Chuyển đổi kết quả thành collection để có thể paginate
        $tours = $tours->sortBy('t_status')->values();

        // Tạo một collection paginator thủ công
        $perPage = NUMBER_PAGINATION_PAGE; // Đặt số mục trên mỗi trang
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $tours->slice(($currentPage - 1) * $perPage, $perPage);
        $paginatedTours = new LengthAwarePaginator($currentItems, $tours->count(), $perPage, $currentPage);

        // Chuẩn bị dữ liệu và truyền vào view
        $viewData = [
            'tours' => $paginatedTours,
            'locations' => $locations,
        ];

        return view('page.location.index', $viewData);
    }

}
