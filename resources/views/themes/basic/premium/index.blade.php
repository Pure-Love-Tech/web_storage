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
                                {{-- {{ $plan }} --}}
                                <div class="col">
                                    <div class="plan {{ $plan->isSubscriptionPlan() ? 'premium' : '' }}">
                                        @auth
                                            @if (subscription()?->plan?->id == $plan->id)
                                                <div class="plan-badge">
                                                    {{ translate('Your Plan', 'premium') }}
                                                </div>
                                            @endif
                                        @endauth

                                        <div class="plan-header">
                                            <h4 class="plan-header-title">
                                                @if ($plan->isSubscriptionPlan())
                                                    <i class="fa-solid fa-crown"></i>
                                                @endif

                                                <span>{{ $plan->name == 'Users' ? 'Basic' : $plan->name }}</span>
                                            </h4>

                                            <p class="plan-header-text">
                                                {{ $plan->short_description }}
                                            </p>
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

                                                @php
                                                    $fileExpiryText = $plan->file_expiry_days
                                                        ? str(
                                                            translate('{expiry_days} after last download', 'premium'),
                                                        )->replace('{expiry_days}', $plan->fileExpiryDaysFormatted())
                                                        : $plan->fileExpiryDaysFormatted();
                                                @endphp

                                                <div class="plan-feature d-flex flex-column align-items-start">
                                                    <label class="mb-1">
                                                        {{ translate('When are your files deleted?', 'premium') }}
                                                    </label>

                                                    <small>
                                                        {{ $fileExpiryText }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="plan-footer">
                                            @if ($plan->isSubscriptionPlan())
                                                <button type="button"
                                                    class="btn btn-light btn-md radius radius-md w-100 text-primary choose-plan-btn"
                                                    data-plan-id="{{ $plan->id }}">
                                                    {{ translate('Choose', 'premium') }}
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div id="choosePlan" class="choose-plan" style="display: none;">
                        <h3 class="choose-plan-title text-center">
                            <i class="fa fa-lock text-success me-2"></i>
                            <span>{{ translate('Payments are 100% secure', 'premium') }}</span>
                        </h3>
                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-3 justify-content-center">
                            @foreach ($premiumPlans as $premiumPlan)
                                {{-- {{ $premiumPlan }} --}}
                                <div class="col premium-plan-item" data-plan-id="{{ $premiumPlan->plan_id }}"
                                    style="display: none;">
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
                                                <input type="hidden" name="premium_id" value="{{ $premiumPlan->id }}">
                                                <input type="hidden" name="plan_id" value="{{ $premiumPlan->plan_id }}">
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
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                const choosePlanSection = document.getElementById('choosePlan');
                const buttons = document.querySelectorAll('.choose-plan-btn');
                const premiumPlanItems = document.querySelectorAll('.premium-plan-item');

                buttons.forEach(function(button) {

                    button.addEventListener('click', function() {

                        const selectedPlanId = this.dataset.planId;

                        premiumPlanItems.forEach(function(item) {

                            if (item.dataset.planId === selectedPlanId) {
                                item.style.display = '';
                            } else {
                                item.style.display = 'none';
                            }

                        });

                        choosePlanSection.style.display = '';

                        choosePlanSection.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });

                    });

                });

            });
        </script>
    @endpush
@endsection
