@extends('layouts.app')

@section('content')
<div class="container">
    <div class="home-wrap-app">
        <div class="col-md-8">
            <div class="home-actions-app row">
                <div class="col-md-4">
                    <a class="home-action-item-app" href="{{ route('user_write') }}">
                        <i class="zmdi zmdi-edit"></i>
                        <span class="home-action-label">写信</span>
                    </a>
                </div>
                <div class="col-md-4">
                    <a class="home-action-item-app" href="{{ route('user_home') }}">
                        <i class="zmdi zmdi-comments"></i>
                        <span class="home-action-label">答复</span>
                    </a>
                </div>
                <div class="col-md-4">
                    <a class="home-action-item-app">
                        <i class="zmdi zmdi-help"></i>
                        <span class="home-action-label">说明</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
