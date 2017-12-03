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
                            <div class="post-item{{ $isAdmin && $post->isAdminHasRead() ? ' admin-has-read' : '' }}" data-id="{{ $post->id }}">
                                <div class="post-short-content">
                                    {!! str_limit(strip_tags($post->contentDecrypted), $limit = 150, $end = '...') !!}
                                    <span class="post-sign">{{ $post->getFullSign() }}</span>
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
@push('scripts')
    <script>
        $(document).ready(function () {
            @if($isAdmin)
            $('.post-list .post-item .post-read-more-btn').click(function (e) {
                $(e.target).parents('.post-item').addClass('admin-has-read');
            });
            @endif
        });
    </script>
@endpush