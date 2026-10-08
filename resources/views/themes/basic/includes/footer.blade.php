<footer class="footer mt-auto">
    @if ($footerMenuLinks->count() > 0)
        <div class="footer-bg">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="1923.842"
                height="905.936" viewBox="0 0 1923.842 905.936">
                <g id="Group_10344" data-name="Group 10344" transform="translate(0 -5892.75)">
                    <path id="Path_8764" data-name="Path 8764"
                        d="M-3.842,33.8S482,212.357,962,212.357,1918.6,36.7,1918.6,36.7L1920,888H0Z"
                        transform="translate(3.842 5859.429)" class="fill-secondary" opacity=".2" />
                    <path id="Path_8762" data-name="Path 8762"
                        d="M0-30.34S482,225.867,962,225.867,1920-30.34,1920-30.34V875.6H0Z"
                        transform="translate(3.842 5923.089)" class="fill-secondary" />
                </g>
            </svg>
        </div>
        <div class="footer-inner">
            <div class="footer-content">
                <div class="container">
                    <div class="row row-cols-2 row-cols-lg-4 gx-4 gy-5">
                        @foreach ($footerMenuLinks as $footerMenuLink)
                            @if ($footerMenuLink->children->count() > 0)
                                <div class="col">
                                    <h3 class="footer-title">{{ $footerMenuLink->name }}</h3>
                                    <div class="footer-links">
                                        @foreach ($footerMenuLink->children as $child)
                                            <a href="{{ $child->link }}" class="footer-link">{{ $child->name }}</a>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <div class="col">
                                    <a href="{{ $footerMenuLink->link }}"
                                        class="footer-link">{{ $footerMenuLink->name }}</a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="footer-copyright {{ $footerMenuLinks->count() < 1 ? 'bg-secondary' : '' }}">
        <div class="container">
            <p class="mb-0">&copy; <span data-year></span>
                {{ $settings->general->site_name }} - {{ translate('All rights reserved') }}.</p>
        </div>
    </div>
</footer>
