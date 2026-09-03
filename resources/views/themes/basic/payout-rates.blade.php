@extends('themes.basic.layouts.single')
@section('title', translate('Payout Rates', 'payout rates'))
@section('content')
    <div class="section">
        {{-- <x-ad alias="other_pages_top" @class('ad-728x90 mb-5') /> --}}
        <div class="container">
            <div class="section-inner">
                <div class="section-body">
                    @if ($themeSettings->payout_rates_page->features)
                        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4 mb-5">
                            <div class="col">
                                <div class="payout">
                                    <div class="card-v">
                                        <div class="payout-icon">
                                            <div class="payout-icon-bg">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="181.21" height="160.45"
                                                    viewBox="0 0 181.21 160.45">
                                                    <g id="Group_10418" data-name="Group 10418"
                                                        transform="translate(-492.076 -642.292)">
                                                        <g id="Group_10365" data-name="Group 10365"
                                                            transform="translate(-77 -25.818)">
                                                            <path id="Path_8782" data-name="Path 8782"
                                                                d="M81.844,38.4C92.563,9.5,95.2-2.212,111.847.341c13.518,2.072,18.191,11.5,29.712,31.057,2.508,4.259.474,9.1,5.565,13.982,27.076,25.989-11.362,49.211-43.561,46.2-1.525-.143-16.854,5.826-19.286,4.452-9.233-5.207-11.321-26.046-11.321-26.046a26.3,26.3,0,0,1,.388-5.581c.293-1.85-1.681-3.534-2.154-6.232-.267-1.568,1.3-4.152-.615-5.763C60.19,43.648,35.241,39.185,17.266,44.189c-22.5,3.947-10.995,29.107-16.7,56.2s33.174,35.884,51.469,21.03c10.154-8.243,30.389-25.88,25.264-36.779-4.813-3.755-3.829-9.907-4.344-14.653C71.724,58.718,65.22,41.834,81.844,38.4Z"
                                                                transform="translate(598.002 668.11) rotate(13)"
                                                                fill="#f7faff" />
                                                            <path id="Path_8783" data-name="Path 8783"
                                                                d="M49.56,28.384C59.019,6.558,79.352-1.671,94.042.257,105.177,1.717,113.507,4,121.165,17.422c1.418,2.487.818,7.324,2.413,12.94.819,2.888,3.075,7.038,5.214,8.8,16.844,13.839.11,32.814-21.346,37.687-8.662,1.967-21.131-6.141-29.513-6.814-3.542-.283-4.97-6.31-9.313-8.574-.7-.367,1.836,1.18,1.233.309C67.88,58.967,60.387,50.5,60.387,50.5a35.318,35.318,0,0,1-4.992-5.838c-1.958-3.274-3.155-8.66-6.657-10.143-11.2-4.746-29.357-1.959-39.3-.467-19.856,2.981-1.41,19.351-6.444,39.809S49.125,108.9,57.782,84.539c.3-.839,1.389-7.653,8.3-11.159,5.477,2.5,15.98-2.894,11.324-3.469a51.968,51.968,0,0,0-6.861-7.136C61.728,51,51.518,44.909,49.56,28.384Z"
                                                                transform="matrix(0.974, -0.225, 0.225, 0.974, 580.526, 715.78)"
                                                                fill="#d2e5ff" opacity="0.22" />
                                                        </g>
                                                    </g>
                                                </svg>
                                            </div>
                                            <div class="icon">
                                                <svg fill="url(#linear-gradient)" version="1.1" id="Capa_1"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 200.439 200.439"
                                                    xml:space="preserve">
                                                    <defs>
                                                        <linearGradient id="linear-gradient" x1="0.5" x2="0.5"
                                                            y2="1" gradientUnits="objectBoundingBox">
                                                            <stop offset="0" stop-color="var(--primary_color)" />
                                                            <stop offset="1" stop-color="var(--secondary_color)" />
                                                        </linearGradient>
                                                    </defs>
                                                    <g>
                                                        <path
                                                            d="M96.452,177.904c-44.912,0-81.451-36.54-81.451-81.453C15.001,51.539,51.54,15,96.452,15 c44.913,0,81.453,36.539,81.453,81.451c0,4.143,3.357,7.5,7.5,7.5c4.143,0,7.5-3.357,7.5-7.5C192.905,43.268,149.637,0,96.452,0 C43.269,0,0.001,43.268,0.001,96.451c0,53.185,43.268,96.453,96.451,96.453c4.143,0,7.5-3.357,7.5-7.5 C103.952,181.262,100.595,177.904,96.452,177.904z" />
                                                        <path
                                                            d="M96.454,147.66c-28.236,0-51.209-22.973-51.209-51.209c0-28.236,22.973-51.209,51.209-51.209 c28.235,0,51.207,22.973,51.207,51.209c0,4.143,3.357,7.5,7.5,7.5c4.143,0,7.5-3.357,7.5-7.5c0-36.508-29.7-66.209-66.207-66.209 c-36.508,0-66.209,29.701-66.209,66.209c0,36.508,29.701,66.209,66.209,66.209c4.143,0,7.5-3.357,7.5-7.5 C103.954,151.018,100.597,147.66,96.454,147.66z" />
                                                        <path
                                                            d="M198.243,187.637l-25.295-25.304l13.336-13.337c1.849-1.849,2.602-4.527,1.985-7.069c-0.616-2.542-2.512-4.579-5.002-5.376 l-54.837-17.557c-2.675-0.855-5.604-0.146-7.591,1.84c-1.986,1.986-2.695,4.915-1.839,7.59l17.562,54.834 c0.798,2.491,2.835,4.386,5.377,5.002c0.585,0.142,1.178,0.211,1.766,0.211c1.965,0,3.88-0.773,5.304-2.197l13.332-13.333 l25.293,25.302c1.465,1.465,3.385,2.197,5.305,2.197c1.919,0,3.838-0.731,5.303-2.195 C201.17,195.315,201.171,190.566,198.243,187.637z M147.097,166.972l-9.368-29.251l29.253,9.365L147.097,166.972z" />
                                                        <path
                                                            d="M108.147,83.102c0,2.762,2.238,5,5,5c2.762,0,5-2.238,5-5c0-8.666-7.135-15.943-16.693-17.859v-2.174c0-2.762-2.238-5-5-5 c-2.762,0-5,2.238-5,5v2.174c-9.559,1.916-16.693,9.193-16.693,17.859c0,8.661,7.135,15.935,16.693,17.851v16.361 c-3.915-1.366-6.693-4.25-6.693-7.507c0-2.762-2.238-5-5-5c-2.762,0-5,2.238-5,5c0,8.662,7.135,15.937,16.693,17.853v2.177 c0,2.762,2.238,5,5,5c2.762,0,5-2.238,5-5v-2.177c9.559-1.916,16.693-9.191,16.693-17.853c0-8.666-7.135-15.943-16.693-17.859 V75.588C105.368,76.956,108.147,79.843,108.147,83.102z M84.76,83.102c0-3.259,2.778-6.146,6.693-7.514v15.019 C87.538,89.24,84.76,86.356,84.76,83.102z M108.147,109.807c0,3.257-2.778,6.141-6.693,7.507v-15.021 C105.368,103.661,108.147,106.548,108.147,109.807z" />
                                                    </g>
                                                </svg>
                                            </div>
                                        </div>
                                        <h4 class="payout-title">
                                            {{ translate('Pay per Download', 'payout rates') }}
                                        </h4>
                                        <p class="payout-text text-muted">
                                            {{ translate('Make money with every single unique download of your file, without any limitations or restrictions.', 'payout rates') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="payout">
                                    <div class="card-v">
                                        <div class="payout-icon">
                                            <div class="payout-icon-bg">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="181.21" height="160.45"
                                                    viewBox="0 0 181.21 160.45">
                                                    <g id="Group_10418" data-name="Group 10418"
                                                        transform="translate(-492.076 -642.292)">
                                                        <g id="Group_10365" data-name="Group 10365"
                                                            transform="translate(-77 -25.818)">
                                                            <path id="Path_8782" data-name="Path 8782"
                                                                d="M81.844,38.4C92.563,9.5,95.2-2.212,111.847.341c13.518,2.072,18.191,11.5,29.712,31.057,2.508,4.259.474,9.1,5.565,13.982,27.076,25.989-11.362,49.211-43.561,46.2-1.525-.143-16.854,5.826-19.286,4.452-9.233-5.207-11.321-26.046-11.321-26.046a26.3,26.3,0,0,1,.388-5.581c.293-1.85-1.681-3.534-2.154-6.232-.267-1.568,1.3-4.152-.615-5.763C60.19,43.648,35.241,39.185,17.266,44.189c-22.5,3.947-10.995,29.107-16.7,56.2s33.174,35.884,51.469,21.03c10.154-8.243,30.389-25.88,25.264-36.779-4.813-3.755-3.829-9.907-4.344-14.653C71.724,58.718,65.22,41.834,81.844,38.4Z"
                                                                transform="translate(598.002 668.11) rotate(13)"
                                                                fill="#f7faff" />
                                                            <path id="Path_8783" data-name="Path 8783"
                                                                d="M49.56,28.384C59.019,6.558,79.352-1.671,94.042.257,105.177,1.717,113.507,4,121.165,17.422c1.418,2.487.818,7.324,2.413,12.94.819,2.888,3.075,7.038,5.214,8.8,16.844,13.839.11,32.814-21.346,37.687-8.662,1.967-21.131-6.141-29.513-6.814-3.542-.283-4.97-6.31-9.313-8.574-.7-.367,1.836,1.18,1.233.309C67.88,58.967,60.387,50.5,60.387,50.5a35.318,35.318,0,0,1-4.992-5.838c-1.958-3.274-3.155-8.66-6.657-10.143-11.2-4.746-29.357-1.959-39.3-.467-19.856,2.981-1.41,19.351-6.444,39.809S49.125,108.9,57.782,84.539c.3-.839,1.389-7.653,8.3-11.159,5.477,2.5,15.98-2.894,11.324-3.469a51.968,51.968,0,0,0-6.861-7.136C61.728,51,51.518,44.909,49.56,28.384Z"
                                                                transform="matrix(0.974, -0.225, 0.225, 0.974, 580.526, 715.78)"
                                                                fill="#d2e5ff" opacity="0.22" />
                                                        </g>
                                                    </g>
                                                </svg>
                                            </div>
                                            <div class="icon">
                                                <svg fill="url(#linear-gradient)" version="1.1"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"
                                                    xml:space="preserve">
                                                    <defs>
                                                        <linearGradient id="linear-gradient" x1="0.5" x2="0.5"
                                                            y2="1" gradientUnits="objectBoundingBox">
                                                            <stop offset="0" stop-color="var(--primary_color)" />
                                                            <stop offset="1" stop-color="var(--secondary_color)" />
                                                        </linearGradient>
                                                    </defs>
                                                    <g id="map-location">
                                                        <path class="st0"
                                                            d="M18.3,4.4C17.4,1.8,14.9,0,12,0C8.8,0,6.1,2.3,5.4,5.3L0,3v17.2l8,3.4l8-3l8,3.4V6.8L18.3,4.4z M9,14.4
                                                                        c1.2,1.4,2.3,2.2,2.4,2.3l0.7,0.6l0.6-0.6c0.3-0.3,0.7-0.7,1.1-1c0.4-0.4,0.8-0.8,1.2-1.2v4.3l-6,2.3V14.4z M12,2
                                                                        c2.6,0,4.8,2.1,4.8,4.8c0,1.9-0.8,3.4-1.8,4.7l0,0l0,0c-0.8,1-1.7,1.9-2.6,2.7c-0.1,0.1-0.3,0.3-0.4,0.4c-1.8-1.6-4.8-5-4.8-7.8
                                                                        C7.2,4.1,9.4,2,12,2z M2,6l3.3,1.4c0.2,1.5,0.9,3,1.7,4.4V21l-5-2.1V6z M22,21l-5-2.1v-6.7c1-1.5,1.8-3.2,1.8-5.4L22,8.2V21z" />
                                                        <circle class="st0" cx="12" cy="7" r="2" />
                                                    </g>
                                                </svg>
                                            </div>
                                        </div>
                                        <h4 class="payout-title">
                                            {{ translate('All countries are counted', 'payout rates') }}
                                        </h4>
                                        <p class="payout-text text-muted">
                                            {{ translate('You will get paid for your downloads, no matter which country your file gets downloaded from.', 'payout rates') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="payout">
                                    <div class="card-v">
                                        <div class="payout-icon">
                                            <div class="payout-icon-bg">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="181.21" height="160.45"
                                                    viewBox="0 0 181.21 160.45">
                                                    <g id="Group_10418" data-name="Group 10418"
                                                        transform="translate(-492.076 -642.292)">
                                                        <g id="Group_10365" data-name="Group 10365"
                                                            transform="translate(-77 -25.818)">
                                                            <path id="Path_8782" data-name="Path 8782"
                                                                d="M81.844,38.4C92.563,9.5,95.2-2.212,111.847.341c13.518,2.072,18.191,11.5,29.712,31.057,2.508,4.259.474,9.1,5.565,13.982,27.076,25.989-11.362,49.211-43.561,46.2-1.525-.143-16.854,5.826-19.286,4.452-9.233-5.207-11.321-26.046-11.321-26.046a26.3,26.3,0,0,1,.388-5.581c.293-1.85-1.681-3.534-2.154-6.232-.267-1.568,1.3-4.152-.615-5.763C60.19,43.648,35.241,39.185,17.266,44.189c-22.5,3.947-10.995,29.107-16.7,56.2s33.174,35.884,51.469,21.03c10.154-8.243,30.389-25.88,25.264-36.779-4.813-3.755-3.829-9.907-4.344-14.653C71.724,58.718,65.22,41.834,81.844,38.4Z"
                                                                transform="translate(598.002 668.11) rotate(13)"
                                                                fill="#f7faff" />
                                                            <path id="Path_8783" data-name="Path 8783"
                                                                d="M49.56,28.384C59.019,6.558,79.352-1.671,94.042.257,105.177,1.717,113.507,4,121.165,17.422c1.418,2.487.818,7.324,2.413,12.94.819,2.888,3.075,7.038,5.214,8.8,16.844,13.839.11,32.814-21.346,37.687-8.662,1.967-21.131-6.141-29.513-6.814-3.542-.283-4.97-6.31-9.313-8.574-.7-.367,1.836,1.18,1.233.309C67.88,58.967,60.387,50.5,60.387,50.5a35.318,35.318,0,0,1-4.992-5.838c-1.958-3.274-3.155-8.66-6.657-10.143-11.2-4.746-29.357-1.959-39.3-.467-19.856,2.981-1.41,19.351-6.444,39.809S49.125,108.9,57.782,84.539c.3-.839,1.389-7.653,8.3-11.159,5.477,2.5,15.98-2.894,11.324-3.469a51.968,51.968,0,0,0-6.861-7.136C61.728,51,51.518,44.909,49.56,28.384Z"
                                                                transform="matrix(0.974, -0.225, 0.225, 0.974, 580.526, 715.78)"
                                                                fill="#d2e5ff" opacity="0.22" />
                                                        </g>
                                                    </g>
                                                </svg>
                                            </div>
                                            <div class="icon">
                                                <svg fill="url(#linear-gradient)" viewBox="0 0 24 24"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <defs>
                                                        <linearGradient id="linear-gradient" x1="0.5"
                                                            x2="0.5" y2="1"
                                                            gradientUnits="objectBoundingBox">
                                                            <stop offset="0" stop-color="var(--primary_color)" />
                                                            <stop offset="1" stop-color="var(--secondary_color)" />
                                                        </linearGradient>
                                                    </defs>
                                                    <path
                                                        d="M5,22a4,4,0,0,0,3.858-3h6.284a4.043,4.043,0,1,0,2.789-4.837L14.816,8.836a4,4,0,1,0-5.63,0L6.078,14.166A3.961,3.961,0,0,0,5,14a4,4,0,0,0,0,8Zm14-6a2,2,0,1,1-2,2A2,2,0,0,1,19,16ZM12,4a2,2,0,1,1-2,2A2,2,0,0,1,12,4ZM10.922,9.834A3.961,3.961,0,0,0,12,10a3.909,3.909,0,0,0,1.082-.168l3.112,5.323A4,4,0,0,0,15.142,17H8.858a3.994,3.994,0,0,0-1.044-1.838ZM5,16a2,2,0,1,1-2,2A2,2,0,0,1,5,16Z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <h4 class="payout-title">
                                            {{ str_replace('{referral_percentage}', $settings->earnings->referrals->percentage, translate('{referral_percentage} per referral', 'payout rates')) }}
                                        </h4>
                                        <p class="payout-text text-muted">
                                            {{ str_replace('{referral_percentage}', $settings->earnings->referrals->percentage, translate('Refer a friend to us and earn up to {referral_percentage} of what they make, increase your earning potential.', 'payout rates')) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="rates">
                        @foreach ($payoutRates as $payoutRate)
                            <div class="rate">
                                <img src="{{ asset($payoutRate->flag) }}"
                                    alt="{{ $payoutRate->country ? $payoutRate->country->name : translate('All Other Countries', 'payout rates') }}"
                                    class="rate-img">
                                <div class="rate-info">
                                    <h4>{{ $payoutRate->country ? $payoutRate->country->name : translate('All Other Countries', 'payout rates') }}
                                    </h4>
                                    <p class="mb-0">
                                        {{ translate('per 1000 downloads', 'payout rates') }}
                                    </p>
                                </div>
                                <div class="rate-prices">
                                    <div class="rate-price">
                                        <svg fill="url(#linear-gradient)" height="800px" width="800px" version="1.1"
                                            id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 396 396"
                                            xml:space="preserve">
                                            <defs>
                                                <linearGradient id="linear-gradient" x1="0.5" x2="0.5"
                                                    y2="1" gradientUnits="objectBoundingBox">
                                                    <stop offset="0" stop-color="var(--primary_color)" />
                                                    <stop offset="1" stop-color="var(--secondary_color)" />
                                                </linearGradient>
                                            </defs>
                                            <path
                                                d="M390,190.762h-47.635v-48.824c0-4.142-3.357-7.5-7.5-7.5h-16.932V46.346c0-5.523-4.478-10-10-10H10c-5.523,0-10,4.477-10,10
                                 v191.182c0,5.523,4.477,10,10,10h103.467c-1.99,11.434-6.269,30.326-14.881,49.079c-1.422,3.096-1.169,6.703,0.67,9.571
                                 c1.839,2.868,5.011,4.603,8.418,4.603h70.528v26.272c0,4.142,3.357,7.5,7.5,7.5h107.975v9.101c0,3.313,2.687,6,6,6H390
                                 c3.314,0,6-2.687,6-6V196.762C396,193.448,393.314,190.762,390,190.762z M178.202,141.938v85.591H20V56.346h277.934v78.091H185.702
                                 C181.56,134.438,178.202,137.795,178.202,141.938z M293.677,329.553H193.202v-8.709h59.583v0.704c0,4.143,3.357,7.5,7.5,7.5
                                 c4.143,0,7.5-3.357,7.5-7.5v-0.704h25.892V329.553z M293.677,196.762v109.082H193.202V149.438h134.163v41.324h-27.688
                                 C296.363,190.762,293.677,193.448,293.677,196.762z M384,347.654h-78.323v-7.065h33.162v0.597c0,3.314,2.686,6,6,6
                                 c3.313,0,6-2.686,6-6v-0.597H384V347.654z M384,328.588h-78.323V221.827H384V328.588z M384,209.827h-78.323v-7.065H384V209.827z" />
                                        </svg>

                                        <div>
                                            <div class="text-secondary">
                                                <span>{{ priceSymbol($payoutRate->amount) }}</span>
                                            </div>
                                            <p class="mb-0">{{ translate('for All Devices', 'payout rates') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        {{-- <x-ad alias="other_pages_bottom" @class('ad-728x90 mt-5') /> --}}
    </div>
    @if ($themeSettings->payout_rates_page->withdrawal_methods_section && $withdrawalMethods->count() > 0)
        <div class="section">
            <div class="container">
                <div class="section-inner">
                    <div class="section-header">
                        <h2 class="section-title">{{ translate('Withdrawal Methods', 'home page') }}</h2>
                    </div>
                    <div class="section-body">
                        <div class="swiper-container">
                            <div class="swiper swiper-brands">
                                <div class="swiper-wrapper align-items-center">
                                    @foreach ($withdrawalMethods as $withdrawalMethod)
                                        <div class="swiper-slide">
                                            <div class="brand">
                                                <img src="{{ asset($withdrawalMethod->logo) }}"
                                                    alt="{{ $withdrawalMethod->name }}" />
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="swiper-actions">
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-button-next"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/swiper/swiper-bundle.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/swiper/swiper-bundle.min.js') }}"></script>
    @endpush
@endsection
