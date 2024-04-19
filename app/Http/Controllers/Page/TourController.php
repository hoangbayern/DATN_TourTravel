<?php

namespace App\Http\Controllers\Page;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tour;
use App\Models\User;
use App\Models\BookTour;
use App\Http\Requests\BookTourRequest;
use Illuminate\Support\Facades\Auth;
use Mail;

class TourController extends Controller
{
    public function index(Request $request)
    {
        $tours = Tour::with('user');

        if ($request->key_tour) {
            $tours->where('t_title', 'like', '%' . $request->key_tour . '%');
        }

        if ($request->t_start_date) {
            $startDate = date('Y-m-d', strtotime($request->t_start_date));
            $tours->where('t_start_date', '>=', $startDate);
        }

        if ($request->t_end_date) {
            $endDate = date('Y-m-d', strtotime($request->t_end_date));
            $tours->where('t_end_date', '<=', $endDate);
        }

        if ($request->price) {
            $price = explode('-', $request->price);
            $tours->whereBetween('t_price_adults', [$price[0], $price[1]]);
        }

        $Ct= now()->format('Y-m-d');
        $tours = $tours->orderBy('t_status')
	    ->where('t_start_date','>',$Ct)
        ->where('t_end_date','>=',$Ct)
        ->where('t_status',1)
        ->paginate(NUMBER_PAGINATION_PAGE);

        $viewData = [
            'tours' => $tours
        ];
        return view('page.tour.index', $viewData);
    }

    public function detail(Request $request, $id)
    {
        $tour = Tour::with(['comments' => function ($query) use ($id) {
            $query->with(['user', 'replies' => function ($q) {
                $q->with('user')->limit(10);
            }])->where('cm_tour_id', $id)->where('cm_status', '1')->limit(20)->orderByDesc('id');
        }])->find($id);

        if (!$tour) {
            return redirect()->back()->with('error', 'Dữ liệu không tồn tại');
        }
        $tours = Tour::where('t_location_id', $tour->t_location_id)->where('id', '<>', $id)->orderBy('id')->limit(NUMBER_PAGINATION_PAGE)->get();

        return view('page.tour.detail', compact('tour', 'tours'));
    }

    public function bookTour(Request $request, $id, $slug)
    {
        if (!Auth::guard('users')->check()) {
            return redirect()->back()->with('error', 'Vui lòng đăng nhập để đặt tour');
        }
        $tour = Tour::find($id);

        if (!$tour) {
            return redirect()->back()->with('error', 'Dữ liệu không tồn tại');
        }
        $user =  User::find(Auth::guard('users')->user()->id);

        return view('page.tour.book', compact('tour', 'user'));
    }

    public function postBookTour(BookTourRequest $request, $id)
    {

    }
    public function loi()
    {
        return redirect()->back()->with('error', 'Số lượng người đăng ký đã vượt quá giới hạn');
    }
}
