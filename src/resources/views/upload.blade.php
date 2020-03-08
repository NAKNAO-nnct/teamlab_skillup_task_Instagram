@extends('layouts.app')

@section('content')
<div class="container">
    <!-- <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div> -->
    
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
            

    <!-- フォーム -->
    <form action="{{ url('upload') }}" method="POST" enctype="multipart/form-data">

        <!-- アップロードした画像。なければ表示しない -->
        @isset ($filename)
        <div>
            <img src="{{ asset('storage/' . $filename) }}">
        </div>
        @endisset

        <label for="photo">画像ファイル:</label>
        <input type="file" class="form-control" name="file">
        <br>
        キャプション<input type="text" name="caption" id="caption">
        
        <hr>
        {{ csrf_field() }}
        <button class="btn btn-success"> Upload </button>
    </form>
</div>
@endsection
