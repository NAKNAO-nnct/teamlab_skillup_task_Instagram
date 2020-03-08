@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            @isset($users)
            @foreach ($users as $user)
                <div class="card">
                    <a href="/user/{{ $user->github_id }}" class="card-body row">
                        <div class="col-5">
                            <img class="" height="120" src="{{ $user->profile }}">
                        </div>
                        <div class="col-5 d-flex align-items-center">
                            <h3 class="card-title">{{ $user->user_name }}</h3>
                        </div>
                    </a>
                </div>
                <br>
            @endforeach
            @endisset

        </div>
    </div>
</div>

@endsection
