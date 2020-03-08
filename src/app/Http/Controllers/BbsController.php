<?php

   namespace App\Http\Controllers;

   use Illuminate\Http\Request;
   use App\Model\Bbs;
   use Auth;


   class BbsController extends Controller
   {
       // Indexページの表示
       public function index() {

           $bbs = Bbs::all(); // 全データの取り出し
           return view('bbs.index', ["bbs" => $bbs]); // bbs.indexにデータを渡す
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
                    'mimes:jpeg,png',
               ],
               'caption' => 'max:200',
            ]);

            // 画像をbase64 encode
            $image = base64_encode(file_get_contents($request->image->getRealPath()));

            // DB挿入処理
            $insert_data = json_decode("
               {
                   'image': $image,
                   'caption': $caption
               }
            ");

            var_dump($insert_data);

            Bbs::insert([
                'github_id' => Auth::github_id(),
                'favorite_github_id' => '',
                'contents' => $insert_data
            ]);

            return view('/');
       }
   }