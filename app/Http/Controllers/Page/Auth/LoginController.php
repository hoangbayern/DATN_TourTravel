<?php

namespace App\Http\Controllers\Page\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        //$this->middleware('guest')->except('logout');
        $this->user = $user;
    }

    public function login()
    {
        if (Auth::guard('users')->check()) {
            return redirect()->back();
        }

        return view('page.auth.login');
    }

    public function postLogin(LoginRequest $request)
    {
        $data = $request->except('_token');
        $user = $this->user->getInfoEmail($data['email']);

        if (!$user) {
            return redirect()->back()->with('error', 'Thông tin tài khoản không tồn tại');
        }

        if (Auth::guard('users')->attempt($data)) {
            return redirect()->route('page.home')->with('success', 'Đăng nhập thành công.');
        }
        return redirect()->back()->with('error', 'Đăng nhập thất bại.');
    }

    public function logout()
    {
        Auth::guard('users')->logout();
        return redirect()->route('page.home');
    }

    public function getGoogleSignInUrl()
    {
        return Socialite::driver('google')->redirect();
    }

    public function loginCallback(Request $request)
    {
        try {
            $state = $request->input('state');

            parse_str($state, $result);
            $googleUser = Socialite::driver('google')->stateless()->user();

            $user = User::where('email', $googleUser->email)->first();
            if ($user) {
                \auth()->login($googleUser);
                throw new \Exception(__('google sign in email existed'));
            }
            $user = User::create(
                [
                    'email' => $googleUser->email,
                    'name' => $googleUser->name,
                    'google_id'=> $googleUser->id,
                    'password'=> Hash::make('12345678'),
                ]
            );
            Auth::login($user);
            return redirect()->route('page.home')->with('success', 'Đăng nhập thành công.');
        } catch (\Exception $exception) {
            return view('page.auth.login');
        }
    }
}
