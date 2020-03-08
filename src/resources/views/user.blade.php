@extends('layouts.app')

@section('content')

<div class="container">
    <div class=" justify-content-center">
        <div class="row" style="height: 120;">
            <div class="col-12">
                <div class="card-body row">
                    <div class="col-4">
                        <img class="" height="120" src="{{ $user->profile }}">
                    </div>
                    <div class="col-4 d-flex align-items-center">
                        <h3 class="card-title">{{ $user->user_name }}</h3>
                    </div>
                    <div class="col-4 d-flex align-items-center">
                        <h3 class="card-title">{{ $good }}</h3>
                    </div>
                </div>
            </div>
        </div>

        @isset($bbs)
        <div class="row col-12 justify-content-center">
            
            @foreach ($bbs as $d)
            <div class="col-4" style="padding: 0;">
                <img class="img-fluid " width="100%" src="data:image/png;base64,{{ $d->image }}" >
            </div>
            @endforeach
        </div>
        @endisset
    </div>
</div>

@endsection
