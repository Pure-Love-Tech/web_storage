@extends('themes.basic.layouts.single')
@section('title', translate('Contact Us', 'pages'))
@section('content')
    <div class="section section-start">
        <div class="container">
            <div class="section-inner">
                <div class="section-header">
                    <h2 class="section-title text-capitalize mb-0">{{ translate('Contact Us', 'pages') }}</h2>
                </div>
                <div class="section-body">
                    <form action="{{ route('contact') }}" method="POST">
                        @csrf
                        <div class="row row-cols-1 row-cols-lg-3 g-3 mb-3">
                            <div class="col">
                                <label class="form-label">{{ translate('Name', 'forms') }} : <span
                                        class="required">*</span></label>
                                <input type="text" name="name" class="form-control form-control-md radius radius-md"
                                    value="{{ auth()->user()->name ?? old('name') }}" required />
                            </div>
                            <div class="col">
                                <label class="form-label">{{ translate('Email address', 'forms') }} : <span
                                        class="required">*</span></label>
                                <input type="email" name="email" class="form-control form-control-md radius radius-md"
                                    value="{{ auth()->user()->email ?? old('email') }}" required />
                            </div>
                            <div class="col">
                                <label class="form-label">{{ translate('Subject', 'forms') }} : <span
                                        class="required">*</span></label>
                                <input type="text" name="subject" class="form-control form-control-md radius radius-md"
                                    value="{{ old('subject') }}" required />
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ translate('Message', 'forms') }} : <span
                                    class="required">*</span></label>
                            <textarea type="text" name="message"class="form-control radius" rows="8" required>{{ old('message') }}</textarea>
                        </div>
                        <x-captcha />
                        <button class="btn btn-primary btn-md radius radius-md"><i
                                class="far fa-paper-plane me-2"></i>{{ translate('Send', 'pages') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
