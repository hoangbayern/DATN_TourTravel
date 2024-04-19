<?php

namespace App\Http\Controllers\Page;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateInfoAccountRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Models\User;
use App\Models\BookTour;
use App\Models\Tour;
use Mail;

class AccountController extends Controller
{
//    public function __construct(BookTour $bookTour)
//    {
//        view()->share([
//            'status' => $bookTour::STATUS,
//            'classStatus' => $bookTour::CLASS_STATUS,
//        ]);
//    }
    //
    public function infoAccount()
    {
        $user = Auth::guard('users')->user();
        return view('page.auth.account', compact('user'));
    }

    public function updateInfoAccount(UpdateInfoAccountRequest $request)
    {
        \DB::beginTransaction();
        try {
            $user =  User::find(Auth::guard('users')->user()->id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->address = $request->address;

            if (isset($request->images) && !empty($request->images)) {
                $image = upload_image('images');
                if ($image['code'] == 1)
                    $user->avatar = $image['name'];
            }

            $user->save();
            \DB::commit();
            return redirect()->back()->with('success', 'Cập nhật thành công.');
        } catch (\Exception $exception) {
            \DB::rollBack();
            return redirect()->back()->with('error', 'Đã xảy ra lỗi không thể cập nhật tài khoản');
        }
    }

    public function changePassword()
    {
        return view('page.auth.change_password');
    }

    public function postChangePassword(ChangePasswordRequest $request)
    {
        \DB::beginTransaction();
        try {
            $user =  User::find(Auth::guard('users')->user()->id);
            $user->password = bcrypt($request->password);
            $user->save();
            \DB::commit();
            Auth::guard('users')->logout();
            return redirect()->route('page.user.account')->with('success', 'Đổi mật khẩu thành công.');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Đã xảy ra lỗi không thể đổi mật khẩu');
        }
    }
}
