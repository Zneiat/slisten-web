@extends('layouts.app')

@section('title', '阅览 ID: ' . $post->id)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-11">
            <div class="panel panel-app">
                <div class="panel-body">
                    <div class="post-view">
                        <div class="panel-title-line"><span class="title">阅览 ID: {{ $post->id }}</span></div>
                        <div class="post-content">
                            {!! clean($post->content) !!}
                        </div>
                        <div class="post-content-bottom">
                            <sapn class="post-sign">{{ $post->getFullSign() }}</sapn>
                        </div>
                        <div class="post-comments">
                            <div class="panel-title-line"><span class="title">答复</span></div>
                            <div class="comment-list">
                                <div class="comment-items-wrap" style="display: block"></div>
                                <div class="comment-list-loading">
                                    <div class="loading-spinner"><svg viewBox="25 25 50 50"><circle cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle></svg></div>
                                </div>
                            </div>
                            <div class="comment-send">
                                <form class="comment-send-form" method="POST" action="{{ route('api_user_message_send') }}" onsubmit="return false;">
                                    <div class="form-group">
                                        <textarea id="content" name="content" class="form-control" style="display: none;"></textarea>
                                        <input type="hidden" name="post_id" value="{{ $post->id }}" style="display: none;">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn-app submit-btn">发送</button>
                                    </div>
                                </form>
                                <div class="comment-send-form-loading" style="display: none;">
                                    <div class="loading-spinner"><svg viewBox="25 25 50 50"><circle cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle></svg></div>
                                </div>
                            </div>
                        </div>
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
            app.postViewPage.init();
            app.postViewPage.loadComments(JSON.parse($('#comments_json').html()));
        });
    </script>
    <script id="comments_json" type="application/json">
        {!! $comments->toJson() !!}
    </script>
@endpush