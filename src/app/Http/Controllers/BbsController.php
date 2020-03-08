<?php

   namespace App\Http\Controllers;

   use Illuminate\Http\Request;
   use App\Model\Bbs;
   use App\User;
   use Auth;


   class BbsController extends Controller
   {
        // Indexページの表示
        public function index(Request $request) {
                // ページパラメーター
                $page = $request->all();
                if (!isset($page['p'])){
                    $page['p'] = '1';
                }

                // github idのデータを取得
                // $bbs = Bbs::where('github_id', Auth::user()->github_id)->get();
                $bbs = Bbs::orderBy('article_id', 'desc')->skip(((int)$page['p'] - 1 )* 10)->take(10)->get();

                foreach ($bbs as $b) {
                    $user = User::where('github_id', $b->github_id)->get();
                    $b["user_name"] = $user[0]->user_name;
                    $b["favorite"] = explode(',', $b->favorite_github_id);
                }

                
                // ページボタングラグ
                $flags = [
                    'next' => FALSE,
                    'back' => FALSE
                ];

                $all_bbs = count($bbs);
                if (count(Bbs::orderBy('article_id', 'desc')->skip(((int)$page['p'] - 1 )* 10)->get()) > 10) {
                    $flags['next'] = TRUE;
                }
                if ((int)$page['p'] > 1) {
                    $flags['back'] = TRUE;
                }
                

                return view('article', ["bbs" => $bbs, "page" => (int)$page['p'], "flag" => $flags]);
        }

        // idの画像を表示
        public function viewId($id) {
            $bbs = Bbs::where('article_id', $id)->get();
            
            $user = User::where('github_id', $bbs[0]->github_id)->get();
            $bbs[0]["user_name"] = $user->user_name;
            $bbs[0]["favorite"] = explode(',', $b->favorite_github_id);
            return view('article', ["bbs" => $bbs]);
        }

        // 投稿処理
        public function upload(Request $request) {
            // 値チェック
            $this->validate($request, [
                'file' => [
                    // 必須
                    'required',
                    // アップロードされたファイルであること
                    'file',
                    // 画像ファイルであること
                    'image',
                    // MIMEタイプを指定
                    'mimes:jpeg,png,gif',
                ],
                'caption' => 'max:200',
            ]);

            // 画像をbase64 encode
            $image = base64_encode(file_get_contents($request->file->getRealPath()));

            $caption = $request->caption;

            Bbs::insert([
                'github_id' => Auth::user()->github_id,
                'favorite_github_id' => '',
                'image' => $image,
                'caption' => $caption
            ]);

            return redirect('/');
        }

        // いいね
        public function good($id) {
            // きじ取得
            $bbs = Bbs::where('article_id', $id)->get()[0];

            // 良いね推した人
            $user = Auth::user()->github_id;

            // 良いねした人のリスト化
            $bbs_good = explode(',', $bbs->favorite_github_id);

            // 良いねしていれば外す
            $bbs_good_user = array_search($user, $bbs_good);
            if ($bbs_good_user !== FALSE) {
                unset($bbs_good[$bbs_good_user]);
                $bbs_good = array_values($bbs_good);
            }else {
                array_push($bbs_good, $user);
            }

            $bbs_good = implode(",", $bbs_good);

            Bbs::where('article_id', $id)->update([
                'favorite_github_id' => $bbs_good
            ]);

            return back();
        }

        // いいねした人リスト返す
        public function goodUserList($id) {
            // きじ取得
            $bbs = Bbs::where('article_id', $id)->get()[0];

            // 良いねした人のリスト化
            $bbs_good = explode(',', $bbs->favorite_github_id);

            // idからユーザ名に変換する
            $users = [];

            foreach ($bbs_good as $b) {
                try{
                    $user = User::where('github_id', $b)->get()[0];
                    array_push($users, $user);
                }catch(\Exception $e){}
            }
            return view('goodlist', ["users" => $users]);
        }

        // 削除処理
        public function delete($id) {
            // 投稿した人と削除する人が同じか確認
            $bbs_user = Bbs::where('article_id', $id)->get()[0]->github_id;
            $user = Auth::user()->github_id;

            // 削除
            if (strcmp($bbs_user, $user) == 0){
                Bbs::where('article_id', $id)->delete();
            }

            return redirect('/');
        }
   }