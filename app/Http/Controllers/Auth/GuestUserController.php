<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class GuestUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(): RedirectResponse
    {
        // ランダムで一意の文字列
        $unique_str = Str::uuid();
        // ランダムなパスワード
        $random_password = Str::random(16);

        // ゲストユーザー詳細情報を設定
        $user = User::create([
            'name' => 'ゲストユーザー',
            'email' => $unique_str . '@example.com',
            'url_name' => $unique_str,
            'password' => Hash::make($random_password),
        ]);

        // ゲストユーザーを作成
        event(new Registered($user));

        // 作成したゲストユーザーでログイン
        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
