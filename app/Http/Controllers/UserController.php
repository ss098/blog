<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Hash;

class UserController extends Controller
{
    // 登录
    public function login(Request $request)
    {
        $column = $request->input('email');
        $password = $request->input('password');

        $user = User::where('email', $column)->orWhere('name', $column)->first();

        if (empty($user)) {
            return [
                'success' => false,
                'message' => [
                    '登录失败'
                ]
            ];
        }

        if (Hash::check($password, $user->password)) {
            $token = str_random(32);

            $user->token = $token;
            $user->save();

            return [
                'success' => true,
                'user' => [
                    'token' => $token,
                    'name' => $user->name
                ]
            ];
        } else {
            return [
                'success' => false,
                'message' => [
                    '登录失败'
                ]
            ];
        }
    }

    public function password(Request $request) {
        return Hash::make($request->input('password'));
    }
}
