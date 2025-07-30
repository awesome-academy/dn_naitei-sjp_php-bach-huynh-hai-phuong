<div x-data="{ modalOpen: false }"
    @keydown.escape.window="modalOpen = false"
>
    {{ $trigger }}
    <template x-teleport="body">
        <div x-show="modalOpen" class="fixed z-9999 inset-0 flex items-center justify-center">
            <div
                x-show="modalOpen"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-300"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                @click="modalOpen=false"
                class="absolute inset-0 bg-black/50"
            ></div>
            <div
                x-trap.inert.noscroll="modalOpen"
                 x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="relative w-full py-6 bg-background px-7 sm:max-w-lg sm:rounded-lg border shadow-lg grid gap-4"
            >
            <div class="flex flex-col gap-2 text-center sm:text-left">
                <h1 class="text-lg font-semibold">{{ $title }}</h1>
                <p class="text-muted-foreground text-sm">{{ $description }}</p>
            </div>
                <div class="flex justify-end gap-2">
                    {{ $actions }}
                </div>
            </div>
        </div>
    </template>
</div>
