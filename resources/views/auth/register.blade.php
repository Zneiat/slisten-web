@extends('layouts.app')

@section('title', '注册')

@section('content')
<div class="container">
    <div class="row auth-panel-wrap-app">
        <div class="col-md-4">
            <div class="panel panel-app">
                <div class="panel-title-line"><span class="title">注册</span></div>

                <div class="panel-body">
                    <form class="auth-form-app" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                            <input id="username" name="username" placeholder="昵称" type="text" class="form-control" value="{{ old('username') }}" autocomplete="off" required autofocus>
                            @if ($errors->has('username'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('username') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <input id="password" name="password" placeholder="密码" type="password" class="form-control" required>
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <input id="password-confirm" name="password_confirmation" placeholder="再次输入密码" type="password" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn-app submit-btn">
                                注册
                            </button>

                            <div class="pull-right">
                                <a href="{{ route('login') }}" class="btn-app btn-link">
                                    注册过了？
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
