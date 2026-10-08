<div class="note note-warning mt-3">
    <h5>{{ admin_trans('Ready pages') }}</h5>
    @if ($settings->actions->blog_status)
        <li class="mb-1"><strong>{{ admin_trans('Blog') }}</strong> : <a href="{{ route('blog.index') }}"
                target="_blank">{{ route('blog.index') }}</a>
        </li>
    @endif
    @if (licenseType(2))
        <li class="mb-1"><strong>{{ admin_trans('Premium') }}</strong> : <a href="{{ route('premium.index') }}"
                target="_blank">{{ route('premium.index') }}</a>
        </li>
    @endif
    @if ($settings->actions->payout_rates_page)
        <li class="mb-1"><strong>{{ admin_trans('Payout Rates') }}</strong> : <a href="{{ route('payout-rates') }}"
                target="_blank">{{ route('payout-rates') }}</a>
        </li>
    @endif
    @if ($settings->actions->payment_proof_page)
        <li class="mb-1"><strong>{{ admin_trans('Payment Proof') }}</strong> : <a
                href="{{ route('payment-proof') }}" target="_blank">{{ route('payment-proof') }}</a>
        </li>
    @endif
    @if ($settings->actions->contact_page)
        <li><strong>{{ admin_trans('Contact') }}</strong> : <a href="{{ route('contact') }}"
                target="_blank">{{ route('contact') }}</a>
        </li>
    @endif
</div>
