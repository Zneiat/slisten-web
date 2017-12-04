@extends('layouts.app')

@section('title', '写信')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10">
            <div class="panel panel-app">
                <div class="panel-title-line"><span class="title">写信</span></div>

                <div class="panel-body">
                    <form class="write-form" method="POST" action="{{ route('api_user_write') }}" onsubmit="return false;" style="display: none;">
                        <div class="form-group">
                            <textarea id="content" name="content" class="form-control" style="display: none;"></textarea>
                        </div>

                        <div class="form-group">
                            <input id="sign" name="sign" placeholder="署名（留空匿名）" autocomplete="off" type="text" class="form-control">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn-app submit-btn">投递</button>
                        </div>
                    </form>
                    <div class="write-form-loading">
                        <div class="loading-spinner"><svg viewBox="25 25 50 50"><circle cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle></svg></div>
                        <div class="loading-text">加载中...</div>
                    </div>
                    <div class="write-form-success" style="display: none;">
                        <div class="big-ico"><i class="zmdi zmdi-check"></i></div>
                        <div class="success-text"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
    <link href="{{ asset('css/simditor.css') }}" rel="stylesheet">
@endpush
@push('scripts')
    <script src="{{ asset('js/simditor.js') }}"></script>
    <script src="{{ asset('js/simditor-autosave.js') }}"></script>
    <script>
        $(document).ready(function () {
            app.writePage.init();
        });
    </script>
@endpush