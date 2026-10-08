@if ($settings->actions->language_menu)
    <div class="drop-down languages" data-dropdown data-dropdown-position="top">
        <div class="drop-down-btn">
            <div class="language-img">
                <img src="{{ asset($activeLanguage->flag) }}" alt="{{ $activeLanguage->name }}" />
            </div>
            <span>{{ $activeLanguage->name }}</span>
            <i class="fa fa-angle-down ms-2"></i>
        </div>
        <div class="drop-down-menu">
            @foreach ($languages as $language)
                <a href="{{ localizationUrl($language->code) }}"
                    class="drop-down-item {{ $activeLanguage->code == $language->code ? 'active' : '' }}">
                    <div class="language-img">
                        <img src="{{ asset($language->flag) }}" alt="{{ $language->name }}" />
                    </div>
                    <span>{{ $language->name }}</span>
                </a>
            @endforeach
        </div>
    </div>
@endif
