<x-layout.root :title="$title">
    <div class="bg-muted flex min-h-svh flex-col items-center justify-center p-6 md:p-10">
        <div class="w-full max-w-sm md:max-w-3xl">
            {{ $slot }}
        </div>
    </div>
</x-layout.root>
