@use(\App\View\Components\Ui\Button)

@php
    $baseStyle = Button::BASE_STYLE;
    $variantStyle = Button::VARIANT_STYLES[$variant];
    $sizeStyle = Button::SIZE_STYLES[$size];

    $class = "$baseStyle $variantStyle $sizeStyle";
@endphp

<{{ $tag }} data-slot="button" role="button" {{ $attributes->twMerge($class) }}>
    {{ $slot }}
</{{ $tag }}>
