@extends('themes.basic.layouts.single')
@section('title', $page->title)
@section('description', $page->short_description)
@section('content')
    <div class="section section-start">
        <x-ad alias="other_pages_top" @class('ad-728x90 mb-5') />
        <div class="container">
            <div class="section-inner">
                <div class="section-header">
                    <h2 class="section-title text-capitalize mb-0">{{ $page->title }}</h2>
                </div>
                <div class="section-body">
                    {!! $page->content !!}
                </div>
            </div>
        </div>
        <x-ad alias="other_pages_bottom" @class('ad-728x90 mt-5') />
    </div>
@endsection
