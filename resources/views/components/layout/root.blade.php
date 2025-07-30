<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-roboto relative" id="root" x-data :class="{ 'dark': $store.theme.isDark }">
    @if (session('notification'))
        <x-ui.card class="absolute z-1000 top-4 right-1/2 translate-x-1/2 w-80 bg-popover shadow-md"
            x-data="{ show: false }" x-init="setTimeout(() => show = true, 50); setTimeout(() => show = false, 4050)"
            x-show="show" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-2"
            style="display: none;"
        >
            <x-ui.card.content>
                <x-ui.button type="button" @click="show = false" class="absolute top-2 right-2" variant="ghost">
                    <x-fas-xmark class="size-4 text-muted-foreground" />
                </x-ui.button>
                <div class="space-y-2">
                    <x-ui.label>{{ __('layout.notification') }}</x-ui.label>
                    <p class="text-sm text-muted-foreground line-clamp-2">{{ session('notification') }}</p>
                </div>
            </x-ui.card.content>
        </x-ui.card>
    @endif
    {{ $slot }}
</body>

</html>
