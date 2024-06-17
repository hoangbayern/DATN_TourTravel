<?php

namespace App\Http\Controllers\Page;

use App\Models\Location;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tour;
use App\Models\User;
use App\Models\BookTour;
use App\Http\Requests\BookTourRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class TourController extends Controller
{
    //
    public function index(Request $request)
    {
        $tours = Tour::with('user');
        $locations = Location::all();

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
            'tours' => $tours,
            'locations' => $locations,
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
        $tour = Tour::find($id);
        $numberUser = $request->b_number_adults + $request->b_number_children + $request->b_number_child6 + $request->b_number_child2;
        if (($tour->t_number_registered + $numberUser) > $tour->t_number_guests) {
            return redirect()->back()->with('error', 'Số lượng người đăng ký đã vượt quá giới hạn');
        }

        if ($request->b_number_adults == 0 && $request->b_number_children == 0 && $request->b_number_child6 == 0 && $request->b_number_child2 ==0) {
            return redirect()->back()->with('error', 'Nhập số lượng người đi');
        }

        if ($request->b_number_adults == 0 && ($request->b_number_children > 0 || $request->b_number_child6 > 0 || $request->b_number_child2 > 0)) {
            return redirect()->back()->with('error', 'Trẻ nhỏ phải kèm người lớn đi cùng');
        }

        \DB::beginTransaction();
        try {
            $params = $request->except(['_token']);
            $user = Auth::guard('users')->user();
            $params['b_tour_id'] = $id;
            $params['b_user_id'] = $user->id;
            $params['b_status'] = 1;
            $params['b_price_adults'] = $tour->t_price_adults - ($tour->t_price_adults * $tour->t_sale / 100);
            $params['b_price_children'] = $tour->t_price_children - ($tour->t_price_children * $tour->t_sale / 100);
            $params['b_price_child6'] = ($tour->t_price_children - ($tour->t_price_children * $tour->t_sale / 100)) * 50 / 100;
            $params['b_price_child2'] = ($tour->t_price_children - ($tour->t_price_children * $tour->t_sale / 100)) * 25 / 100;
            $book = BookTour::create($params);
            if ($book) {
                $tour->t_follow = $tour->t_follow + $numberUser;
                $tour->save();
            }
            \DB::commit();

            $mail = $user->email;
            if ($mail) {
                Mail::send('emailtn', compact('book', 'tour', 'user'), function ($email) use ($mail) {
                    $email->subject('Thông tin xác nhận đơn Booking');
                    $email->to($mail);
                });
            } else {
                throw new \Exception('Invalid email address');
            }
            return redirect()->route('page.home')->with('success', 'Cám ơn bạn đã đặt tour chúng tôi sẽ liên hệ sớm để xác nhận.');
        } catch (\Exception $exception) {
            \DB::rollBack();
            return redirect()->back()->with('error', 'Đã xảy ra lỗi khi lưu dữ liệu');
        }
    }

    public function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data))
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }

    public function bookTourMomo(Request $request, $id)
    {
        $tour = Tour::find($id);

        $numberUser = $request->b_number_adults + $request->b_number_children + $request->b_number_child6 + $request->b_number_child2;

        if (($tour->t_number_registered + $numberUser) > $tour->t_number_guests) {
            return redirect()->back()->with('error', 'Số lượng người đăng ký đã vượt quá giới hạn');
        }

        if ($request->b_number_adults == 0 && $request->b_number_children == 0 && $request->b_number_child6 == 0 && $request->b_number_child2 ==0) {
            return redirect()->back()->with('error', 'Nhập số lượng người đi');
        }

        if ($request->b_number_adults == 0 && ($request->b_number_children > 0 || $request->b_number_child6 > 0 || $request->b_number_child2 > 0)) {
            return redirect()->back()->with('error', 'Trẻ nhỏ phải kèm người lớn đi cùng');
        }

        // Calculate prices
        $priceAdults = $tour->t_price_adults - ($tour->t_price_adults * $tour->t_sale / 100);
        $priceChildren = $tour->t_price_children - ($tour->t_price_children * $tour->t_sale / 100);
        $priceChild6 = $priceChildren * 50 / 100;
        $priceChild2 = $priceChildren * 25 / 100;

        $amount = ($priceAdults * $request->b_number_adults) + ($priceChildren * $request->b_number_children) + ($priceChild6 * $request->b_number_child6) + ($priceChild2 * $request->b_number_child2);

        // Save temporary booking information
        $params = $request->except(['_token']);
        $user = Auth::guard('users')->user();
        $params['b_tour_id'] = $id;
        $params['b_user_id'] = $user->id;
        $params['b_status'] = 0; // Pending status
        $params['b_price_adults'] = $priceAdults;
        $params['b_price_children'] = $priceChildren;
        $params['b_price_child6'] = $priceChild6;
        $params['b_price_child2'] = $priceChild2;
        $book = BookTour::create($params);

        // Prepare MoMo payment request
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
        $orderInfo = "Thanh toán qua MoMo";
        $orderId = time() . "";
        $redirectUrl = route('momo.callback', ['id' => $book->id]); // IPN callback URL
        $ipnUrl = route('momo.callback', ['id' => $book->id]); // IPN callback URL
        $extraData = "";

        $requestId = time() . "";
        $requestType = "payWithATM";

        // Before sign HMAC SHA256 signature
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        $data = array(
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            "storeId" => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        );

        $result = $this->execPostRequest($endpoint, json_encode($data));

        $jsonResult = json_decode($result, true);  // Decode json

        return redirect()->away($jsonResult['payUrl']);
    }

    public function handleMomoCallback(Request $request, $id)
    {
        \DB::beginTransaction();
        try {
            $book = BookTour::find($id);
            if (!$book) {
                throw new \Exception('Booking not found');
            }

            // Verify the MoMo payment here by checking the request parameters

            if ($request->resultCode == 0) {
                // Payment successful
                $book->b_status = 3; // Update status to successful
                $book->save();

                $tour = $book->tour;
                $numberUser = $book->b_number_adults + $book->b_number_children + $book->b_number_child6 + $book->b_number_child2;
                $tour->t_number_registered = $tour->t_number_registered + $numberUser;
                $tour->save();

                $user = $book->user;
                $mail = $user->email;
                if ($mail) {
                    Mail::send('emailtn', compact('book', 'tour', 'user'), function ($email) use ($mail) {
                        $email->subject('Thông tin xác nhận đơn Booking');
                        $email->to($mail);
                    });
                } else {
                    throw new \Exception('Invalid email address');
                }

                \DB::commit();

                return redirect()->route('page.home')->with('success', 'Cám ơn bạn đã đặt tour chúng tôi sẽ liên hệ sớm để xác nhận.');
            } else {
                throw new \Exception('Payment failed');
            }
        } catch (\Exception $exception) {
            \DB::rollBack();
            return redirect()->route('page.home')->with('error', 'Đã xảy ra lỗi khi lưu dữ liệu');
        }
    }



    public function loi()
    {
        return redirect()->back()->with('error', 'Số lượng người đăng ký đã vượt quá giới hạn');
    }
}
