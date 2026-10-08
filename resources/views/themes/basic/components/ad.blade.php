@if ($code)
    @if ($alias != 'head_code')
        <div class="ad">
            <div {{ $attributes }}>
                {!! $code !!}
            </div>
        </div>
    @else
        {!! $code !!}
    @endif
@endif
