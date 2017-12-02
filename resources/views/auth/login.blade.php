@extends('layouts.app')

@section('title', '登录')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-app">
                <div class="panel-title-line"><span class="title">登录</span></div>

                <div class="panel-body">
                    <form class="auth-form-app" method="POST" action="{{ route('login') }}">
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
                           <div class="checkbox">
                               <label>
                                   <input type="checkbox" name="remember"> 记住我
                               </label>
                           </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn-app submit-btn">
                                登录
                            </button>

                            <div class="pull-right">
                                <a href="{{ route('password.request') }}" class="btn-app btn-link">
                                    忘记密码？
                                </a>
                                <a href="{{ route('register') }}" class="btn-app btn-link">
                                    还未注册？
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
