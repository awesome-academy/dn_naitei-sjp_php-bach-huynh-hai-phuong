<x-layout.root>
    <x-slot:title>{{ $title ?? 'Dashboard' }}</x-slot:title>
    <div class="flex justify-center items-center">
        {{ $slot }}
    </div>
</x-layout.root>