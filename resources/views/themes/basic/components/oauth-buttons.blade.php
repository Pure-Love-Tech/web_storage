@if ($oauthProviders->count() > 0)
    <div class="login-with mt-3">
        <div class="login-with-divider">
            <span>{{ translate('Or', 'auth') }}</span>
        </div>
        <div class="row g-3">
            @foreach ($oauthProviders as $oauthProvider)
                <div class="{{ $oauthProviders->count() > 1 ? 'col-lg-12 col-xl-6' : 'col-12' }}">
                    <a href="{{ route('oauth.login', $oauthProvider->alias) }}"
                        class="btn btn-{{ $oauthProvider->alias }} btn-md w-100 text-center">
                        <i class="{{ $oauthProvider->icon }} me-2"></i>
                        {{ translate("Sign in With {$oauthProvider->name}", 'auth') }}
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endif
