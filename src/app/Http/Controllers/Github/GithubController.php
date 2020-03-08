<?php

namespace App\Http\Controllers\Github;

use App\User;
use App\Http\Controllers\Controller;
use Auth;
use Socialite;
use Illuminate\Http\Request;

class GithubController extends Controller
{
    public function top(Request $request)
    {
        $token = $request->session()->get('github_token', null);

        try {
            $user = Socialite::driver('github')->userFromToken($token);
        } catch (\Exception $e) {
            return redirect('login/github');
        }
        
        // ユーザ登録 or 取得
        $user = User::firstOrCreate([
            'github_id'=> $user->id,
            'profile'=> $user->avatar,
            'user_name' => $user->nickname
        ]);

        Auth::login($user);
        return redirect('/');
    }
}