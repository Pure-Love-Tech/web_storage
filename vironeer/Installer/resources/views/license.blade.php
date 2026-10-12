@extends('vironeer::layouts.app')
@section('title', admin_trans('License'))
@section('content')
    <div class="vironeer-steps-body">
        <p class="vironeer-form-info-text">
            {{ admin_trans('As part of protecting our products we are building our systems to validate the license for every customer, the license means your purchase code.') }}
        </p>
        <div class="mb-4">
            <form action="" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">{{ admin_trans('Purchase Code') }} : <span class="required">*</span></label>
                    <input type="text" name="purchase_code" class="form-control form-control-md"
                        placeholder="{{ admin_trans('Enter your purchase code') }}" autocomplete="off" autofocus required>
                </div>
                <button class="btn btn-primary btn-md">{{ admin_trans('Continue') }}<i
                        class="fas fa-arrow-right ms-2"></i></button>
            </form>
        </div>
        <div class="vironeer-links">
            <h6 class="mb-3">
                {{ admin_trans('Follow the links below to learn more about licenses and how you can get it') }} :</h6>
            <li class="mb-1">
                <a target="_blank"
                    href="https://codecanyon.net/licenses/standard">{{ admin_trans('What The License Mean') }}?</a>
            </li>
            <li class="mb-1">
                <a target="__blank"
                    href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-">{{ admin_trans('Where Is My Purchase Code') }}?</a>
            </li>
            <li class="mb-0">
                <a target="_blank"
                    href="https://codecanyon.net/user/vironeer/portfolio">{{ admin_trans('Where I Can Bought a License') }}?</a>
            </li>
        </div>
    </div>
@endsection
