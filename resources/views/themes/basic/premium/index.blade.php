@extends('themes.basic.layouts.single')
@section('title', translate('Premium membership', 'premium'))
@section('content')
    <div class="section">
        <x-ad alias="other_pages_top" @class('ad-728x90 mb-5') />
        <div class="container">
            <div class="section-inner">
                <div class="section-header">
                    <h2 class="section-title">{{ translate('Our Plans', 'premium') }}</h2>
                    <p class="section-text text-muted lead">
                        {{ translate('premium membership plans description', 'premium') }}</p>
                </div>
                <div class="section-body">
                    <div class="plans">
                        <div
                            class="row row-cols-1 row-cols-md-2 row-cols-lg-3 justify-content-center align-items-center g-3">
                            @foreach ($plans as $plan)
                                <div class="col">
                                    <div class="plan {{ $plan->isPremium() ? 'premium' : '' }}">
                                        @auth
                                            @if ($plan->id == subscription()->plan->id)
                                                <div class="plan-badge">{{ translate('Your Plan', 'premium') }}</div>
                                            @endif
                                        @endauth
                                        <div class="plan-header">
                                            <h4 class="plan-header-title">
                                                @if ($plan->isPremium())
                                                    <i class="fa-solid fa-crown"></i>
                                                @endif
                                                <span>{{ $plan->name }}</span>
                                            </h4>
                                            <p class="plan-header-text">{{ $plan->short_description }}</p>
                                        </div>
                                        <div class="plan-body">
                                            <div class="plan-features">
                                                <div class="plan-feature">
                                                    {{ translate('Storage Space', 'premium') }}
                                                    <span>{{ $plan->storageSpaceFormatted() }}</span>
                                                </div>
                                                <div class="plan-feature">
                                                    {{ translate('Maximum file size', 'premium') }}
                                                    <span>{{ $plan->maxFileSizeFormatted() }}</span>
                                                </div>
                                                <div class="plan-feature">
                                                    {{ translate('Download waiting time', 'premium') }}
                                                    <span>{{ $plan->downloadWaitingTimeFormatted() }}</span>
                                                </div>
                                                <div class="plan-feature">
                                                    {{ translate('No download Captcha', 'premium') }}
                                                    <span>
                                                        @if ($plan->download_captcha)
                                                            <i class="fa fa-times"></i>
                                                        @else
                                                            <i class="fa fa-check"></i>
                                                        @endif
                                                    </span>
                                                </div>
                                                <div class="plan-feature">
                                                    {{ translate('No Advertisements', 'premium') }}
                                                    <span>
                                                        @if ($plan->advertisements)
                                                            <i class="fa fa-times"></i>
                                                        @else
                                                            <i class="fa fa-check"></i>
                                                        @endif
                                                    </span>
                                                </div>
                                                <div class="plan-feature">
                                                    {{ translate('When are your files deleted?', 'premium') }}
                                                    @if ($plan->file_expiry_days)
                                                        <span>{{ str(translate('{expiry_days} after last download', 'premium'))->replace('{expiry_days}', $plan->fileExpiryDaysFormatted()) }}</span>
                                                    @else
                                                        <span>{{ $plan->fileExpiryDaysFormatted() }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="plan-footer">
                                            @if ($plan->isPremium())
                                                <button class="btn btn-light btn-md radius radius-md w-100 text-primary"
                                                    data-link="#choosePlan">{{ translate('Choose', 'premium') }}</button>
                                            @endif
                                            @if ($plan->isForUsers() && !auth()->user())
                                                <a href="{{ route('register') }}"
                                                    class="btn btn-secondary btn-md radius radius-md w-100">{{ translate('Sign Up', 'auth') }}</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div id="choosePlan" class="choose-plan">
                        <h3 class="choose-plan-title text-center">
                            <i class="fa fa-lock text-success me-2"></i>
                            <span>{{ translate('Payments are 100% secure', 'premium') }}</span>
                        </h3>
                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-3 justify-content-center">
                            @foreach ($premiumPlans as $premiumPlan)
                                <div class="col">
                                    <div class="pricing">
                                        <div class="pricing-header">
                                            <div class="pricing-duration">
                                                @if ($premiumPlan->interval == 1)
                                                    {{ $premiumPlan->interval . ' ' . translate('day', 'premium') }}
                                                @else
                                                    {{ $premiumPlan->interval . ' ' . translate('days', 'premium') }}
                                                @endif
                                            </div>
                                            <div class="pricing-amount">{{ priceSymbol($premiumPlan->price) }}</div>
                                        </div>
                                        <div class="pricing-body">
                                            <form action="{{ route('premium.subscribe') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="plan_id" value="{{ $premiumPlan->id }}">
                                                @foreach ($paymentGateways as $paymentGateway)
                                                    <button class="pricing-btn w-100" name="payment_method"
                                                        value="{{ $paymentGateway->id }}">
                                                        <img src="{{ asset($paymentGateway->logo) }}"
                                                            alt="{{ $paymentGateway->name }}" />
                                                    </button>
                                                @endforeach
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <x-ad alias="other_pages_bottom" @class('ad-728x90 mt-5') />
    </div>
@endsection
