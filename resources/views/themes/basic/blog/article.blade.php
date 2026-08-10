@extends('themes.basic.layouts.single')
@section('title', $blogArticle->title)
@section('description', $blogArticle->short_description)
@section('og_image', asset($blogArticle->image))
@section('hide_header', true)
@section('content')
    <div class="section section-start">
        <div class="container">
            <div class="section-inner">
                <div class="row g-4">
                    <div class="col-12 col-xl-8">
                        <div class="row row-cols-1 g-4">
                            <div class="col">
                                <div class="blog-post v2 p-4">
                                    <div class="blog-post-header">
                                        <img src="{{ asset($blogArticle->image) }}" alt="{{ $blogArticle->title }}"
                                            class="blog-post-img">
                                    </div>
                                    <div class="blog-post-body px-0">
                                        <a class="blog-post-title text-normal">
                                            <h5>{{ $blogArticle->title }}</h5>
                                        </a>
                                        <div class="post-meta mb-3">
                                            <div class="post-meta-item">
                                                <i class="far fa-user"></i>
                                                <span>{{ $blogArticle->admin->name }}</span>
                                            </div>
                                            <div class="post-meta-item">
                                                <i class="fa-regular fa-calendar"></i>
                                                <time>{{ dateFormat($blogArticle->created_at) }}</time>
                                            </div>
                                        </div>
                                        <x-ad alias="blog_article_top" @class('ad-728x90 mb-3') />
                                        <div class="blog-content">
                                            {!! $blogArticle->content !!}
                                        </div>
                                        <x-ad alias="blog_article_bottom" @class('ad-728x90 mb-3') />
                                        <div class="mt-2">
                                            @include('themes.basic.partials.share-buttons', [
                                                'link' => url()->current(),
                                            ])
                                        </div>
                                    </div>
                                    <div class="blog-post-footer px-0">
                                        <div class="comments">
                                            <h5 class="comments-title">
                                                <i class="far fa-comments me-2"></i>{{ translate('Comments', 'blog') }}
                                                ({{ $blogArticleComments->count() }})
                                            </h5>
                                            @forelse ($blogArticleComments as $blogArticleComment)
                                                <div class="comment">
                                                    <div class="comment-img">
                                                        <img src="{{ asset($blogArticleComment->user->avatar) }}"
                                                            alt="{{ $blogArticleComment->user->name }}">
                                                    </div>
                                                    <div class="comment-info">
                                                        <div class="d-flex flex-column">
                                                            <h6 class="comment-title mb-1">
                                                                {{ $blogArticleComment->user->name }}</h6>
                                                            <time
                                                                class="comment-time text-muted mb-2">{{ dateFormat($blogArticleComment->created_at) }}</time>
                                                        </div>
                                                        <p class="comment-text mb-0 text-muted">{!! replace_br($blogArticleComment->comment) !!}</p>
                                                    </div>
                                                </div>
                                            @empty
                                                <span
                                                    class="text-muted">{{ translate('No comments found', 'blog') }}</span>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="blog-side">
                                    <div class="card-v">
                                        @auth
                                            <h4 class="blog-side-title mb-4">{{ translate('Leave a comment', 'blog') }}</h4>
                                            <form action="{{ route('blog.article', $blogArticle->slug) }}" method="POST">
                                                @csrf
                                                <div class="mb-3">
                                                    <textarea name="comment" class="form-control" rows="6" placeholder="{{ translate('Your comment', 'blog') }}"
                                                        required></textarea>
                                                </div>
                                                <x-captcha />
                                                <button
                                                    class="btn btn-primary btn-md radius radius-md">{{ translate('Publish', 'blog') }}</button>
                                            </form>
                                        @else
                                            <span class="text-muted text-center">
                                                {{ translate('Login or create account to leave comments', 'blog') }}
                                            </span>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('themes.basic.blog.includes.sidebar')
                </div>
            </div>
        </div>
    </div>
@endsection
