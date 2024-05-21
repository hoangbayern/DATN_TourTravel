<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;


    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->middleware('guest')->except('logout');
        $this->user = $user;
    }

    public function login()
    {
        if (\Auth::check()) {
            return redirect()->back();
        }

        return view('admin.auth.login');
    }

    /**
     * Xử lý thực hiện đăng nhập trang admin
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postLogin(LoginRequest $request)
    {
        $data = $request->except('_token');
        $user = $this->user->getInfoEmail($data['email']);

        if (!$user) {
            return redirect()->back()->with('danger', 'Thông tin tài khoản không tồn tại');
        }

        if (Auth::attempt($data)) {
            return redirect()->route('admin.home');
        }
        return redirect()->back()->with('danger', 'Đăng nhập thất bại.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }

//    public function getGoogleSignInUrl()
//    {
//            return Socialite::driver('google')->redirect();
//    }
//
//    public function loginCallback(Request $request)
//    {
//        try {
//            $user = Socialite::driver('google')->user();
//        } catch (\Exception $exception) {
//            return redirect()->route('admin.login');
//        }
//
//        $existingUser = User::where('email', $user->email)->first();
//        if ($existingUser) {
//            \auth()->login($existingUser, true);
//        } else {
//            $newUser = new User();
//            $newUser->name = $user->name;
//            $newUser->email = $user->email;
//            $newUser->password = Hash::make('12345678');
//            $newUser->avatar = $user->avatar;
//            $newUser->save();
//            \auth()->login($newUser, true);
//        }
//        return redirect()->route('admin.home');
//    }
}
