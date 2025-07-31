<div x-data="{ open: false }" data-slot="collapsible">
    <x-ui.button @click="open = !open" data-slot="collapsible-trigger" class="justify-between w-full h-10"
        variant="ghost">
        {{ $trigger ?? 'Toggle' }} <x-fas-chevron-down class="size-4 transition-transform duration-300"
            ::class="{ 'rotate-180': open }" />
    </x-ui.button>
    <div x-show="open" x-collapse data-slot="collapsible-content" class="text-sm">
        {{ $slot }}
    </div>
</div>
