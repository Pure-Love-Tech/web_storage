@extends('backend.layouts.form')
@section('section', admin_trans('Earnings'))
@section('title', admin_trans('Add Payout Rate'))
@section('container', 'container-max-lg')
@section('back', route('admin.earnings.payout-rates.index'))
@section('content')
    <div class="card">
        <div class="card-body">
            <form id="vironeer-submited-form" action="{{ route('admin.earnings.payout-rates.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="vironeer-file-preview-box mb-3 bg-light p-4 text-center">
                    <div class="file-preview-box mb-3 d-none">
                        <img id="filePreview" src="#" class="rounded-3" width="100px" height="100px">
                    </div>
                    <button id="selectFileBtn" type="button" class="btn btn-secondary mb-2"><i
                            class="fas fa-camera me-2"></i>{{ admin_trans('Choose Country Flag') }}</button>
                    <input id="selectedFileInput" type="file" name="flag" accept=".png, .jpg, .jpeg, .svg" hidden
                        required>
                    <small class="text-muted d-block">{{ admin_trans('Allowed (PNG, JPG, JPEG, SVG)') }}</small>
                </div>
                <div class="mb-4">
                    <label class="form-label">{{ admin_trans('Country') }}</label>
                    <select name="country_id" class="form-select select2" required>
                        <option></option>
                        <option value="0">{{ admin_trans('** All Other Countries **') }}</option>
                        @foreach (countries() as $country)
                            <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                {{ $country->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-2">
                    <label class="form-label">{{ admin_trans('Rate per 1000 downloads') }}
                    </label>
                    <div class="custom-input-group input-group">
                        <input type="text" name="amount" class="form-control input-price" placeholder="0.00"
                            value="{{ old('amount') }}" required>
                        <span class="input-group-text"><strong>{{ $settings->currency->code }}</strong></span>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/jquery/jquery.priceformat.min.js') }}"></script>
    @endpush
@endsection
