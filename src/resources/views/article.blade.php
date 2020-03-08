@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <!-- エラーメッセージ。なければ表示しない -->
            @if ($errors->any())
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Error</strong>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            
            @isset($bbs)
            @foreach ($bbs as $d)
                
                <div class="card">
                    <div class="card-header row ">
                        <div class="col-9">
                            <a href="/user/{{ $d->github_id }}">{{ $d->user_name }}</a>
                        </div>
                        @auth
                            @if ($d->user_name == Auth::user()->user_name)
                            <div class="col-3 text-right">
                                <a href="/article/{{ $d->article_id }}/delete" class="btn btn-danger btn-sm">削除</a>
                            </div>
                            @endif
                        @endauth
                    </div>
                    <div class="card-body">  
                        <img src="data:image/png;base64,{{ $d->image }}" class="img-responsive" width="100%">
                        <hr>
                        <div class="row">
                            <div class="col-7">
                                {{ $d->caption }}
                            </div>
                            
                            <div class="col-5 text-right">
                                @auth
                                    @php
                                        $good_flag=FALSE
                                    @endphp
                                    @foreach ($d->favorite as $f)
                                        @if ($f == Auth::user()->github_id)
                                            @php
                                                $good_flag=TRUE
                                            @endphp
                                        @endif
                                    @endforeach

                                    @if ($good_flag == TRUE)
                                        <a href="/article/{{ $d->article_id }}/good" class="btn btn-success btn-sm">いいね</a>
                                    @else
                                        
                                        <a href="/article/{{ $d->article_id }}/good" class="btn btn-outline-info btn-sm">いいね</a>
                                    @endif
                                @endauth
                                @guest
                                    <button class="btn btn-outline-info btn-sm" disabled>いいね</button>
                                @endguest
                                <br>
                                <a href="/article/{{ $d->article_id }}/good/list" class="card-link">いいねしたユーザ</a>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
            @endforeach
            @endisset

        </div>
        <div class="row col-12 text-center">
            <div class="col-6">
                @if ($flag['back'])
                <a href="/?p={{ $page - 1 }}" class="btn btn-outline-info btn-lg">戻る</a>
                @endif
            </div>
            <div class="col-6">
                @if ($flag['next'])
                <a href="/?p={{ $page + 1 }}" class="btn btn-outline-success btn-lg">進む</a>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
