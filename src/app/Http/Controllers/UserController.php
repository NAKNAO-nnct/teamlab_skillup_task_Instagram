<?php
namespace App\Http\Controllers;
use App\User;
use Auth;
class UserController extends Controller
{
    public function index()
    {
        // 認証ユーザの取得
        $user = Auth::user();

        return var_dump($user->github_id);
        
    }
}