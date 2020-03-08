<?php
namespace App\Http\Controllers;
use App\User;
use App\Model\Bbs;
use Auth;
class UserController extends Controller
{
    public function index()
    {
        // 認証ユーザの取得
        $user = Auth::user();

        return var_dump($user->github_id);
        
    }

    // idのユーザ情報
    public function userPageId($id) {
        $user = User::where('github_id', $id)->get()[0];

        $bbs = Bbs::where('github_id', $id)->latest()->get();

        // いいねの総数
        $good_sum = 0;
        foreach ($bbs as $b) {
            $good_sum += count(explode(',', $b->favorite_github_id)) - 1;
        }

        return view('user', ["user"=> $user, "bbs" => $bbs, "good" => $good_sum]);
    }
}