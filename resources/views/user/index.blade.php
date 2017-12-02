@extends('layouts.app')

@section('title', '答复')

@section('content')
    <div class="container">
    <div class="row">
        <div class="col-md-10">
            <div class="panel panel-app">
                <div class="panel-title-line"><span class="title">答复</span></div>

                <div class="panel-body">
                    <div class="post-list">
                        @foreach ($posts as $post)
                            <div class="post-item" data-id="{{ $post->id }}">
                                <div class="post-short-content">
                                    {!! str_limit(strip_tags($post->contentDecrypted), $limit = 150, $end = '...') !!}
                                </div>
                                <div class="post-actions">
                                    <a href="{{ route('post_view', ['id' => $post->id]) }}" target="_blank" class="btn-app post-read-more-btn">全文阅览</a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{ $posts->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection