@extends('themes.basic.layouts.single')
@section('title', translate('Blog categories', 'blog'))
@section('content')
    <div class="section section-start">
        <x-ad alias="blog_page_top" @class('ad-728x90 mb-5') />
        <div class="container">
            <div class="section-inner">
                <div class="row g-4">
                    <div class="col-12 col-xl-6 m-auto">
                        <div class="card-v">
                            <h4 class="card-v-title mb-4">{{ translate('Categories', 'blog') }}</h4>
                            <div class="categories">
                                @forelse ($blogCategories as $blogCategory)
                                    <a href="{{ route('blog.category', $blogCategory->slug) }}"
                                        class="category link link-secondary">
                                        <span class="category-title">{{ $blogCategory->name }}</span>
                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                @empty
                                    <span class="text-muted">{{ translate('No categories found', 'blog') }}</span>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <x-ad alias="blog_page_bottom" @class('ad-728x90 mt-5') />
        </div>
    </div>
@endsection
