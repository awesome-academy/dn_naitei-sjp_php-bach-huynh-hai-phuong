@use(\App\View\Components\Ui\Badge)

@php
    $baseStyle = Badge::BASE_STYLE;
    $variantStyle = Badge::VARIANT_STYLES[$variant];

    $class = "$baseStyle $variantStyle";
@endphp

<span data-slot="badge" {{ $attributes->twMerge($class) }}>
    {{ $slot }}
</span>
