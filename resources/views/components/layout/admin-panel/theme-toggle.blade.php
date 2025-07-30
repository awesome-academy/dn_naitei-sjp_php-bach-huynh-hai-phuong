<x-ui.button variant="outline" size="icon" class="size-8 rounded-full" x-data @click="$store.theme.toggle()">
    <x-far-sun class="h-[1.2rem] w-[1.2rem] rotate-0 scale-100 transition-all dark:-rotate-90 dark:scale-0" />
    <x-far-moon class="absolute h-[1.2rem] w-[1.2rem] rotate-90 scale-0 transition-all dark:rotate-0 dark:scale-100" />
    <span class="sr-only">{{ __('layout.toggle_theme') }}</span>
</x-ui.button>
