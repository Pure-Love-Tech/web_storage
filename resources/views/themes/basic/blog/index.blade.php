@extends('themes.basic.layouts.single')
@section('title', translate('Blog', 'blog'))
@section('content')
    <div class="section section-start">
        <x-ad alias="blog_page_top" @class('ad-728x90 mb-5') />
        <div class="container">
            <div class="section-inner">
                <div class="row g-4">
                    <div class="col-12 col-xl-8">
                        @if ($blogArticles->count() > 0)
                            <div class="row row-cols-1 row-cols-md-2 g-4">
                                @foreach ($blogArticles as $post)
                                    <div class="col">
                                        @include('themes.basic.partials.blog-post', [
                                            'post' => $post,
                                        ])
                                    </div>
                                @endforeach
                            </div>
                            {{ $blogArticles->links() }}
                        @else
                            <div class="card-v">{{ translate('No articles found', 'blog') }}</div>
                        @endif
                    </div>
                    @include('themes.basic.blog.includes.sidebar')
                </div>
            </div>
        </div>
        <x-ad alias="blog_page_bottom" @class('ad-728x90 mt-5') />
    </div>
@endsection
