<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Socialite;

use App\Models\User;
use App\Models\Performance;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Google認証画面にリダイレクトして認証
     * @return mixed
     */
    public function GoogleLogin()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Googleからのコールバック
     * @return mixed
     */
    public function handleGoogleCallback()
    {
        $google_user = Socialite::driver('google')->user();

        $user = User::updateOrCreate([
            'uid' => $google_user->getId()
        ],[
            'name' => $google_user->getName(),
            'avatar' => $google_user->getAvatar(),
        ]);

        Performance::firstOrCreate([
            'user_id' => $user->id
        ]);

        \Auth::login($user);
        return redirect('/');
    }

    /**
     * ログアウト
     */
    public function logout()
    {
        \Auth::logout();
        return redirect('/');
    }
}
