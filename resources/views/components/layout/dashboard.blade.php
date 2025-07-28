<x-layout.root>
    <x-slot:title>{{ $title ?? 'Dashboard' }}</x-slot:title>
    <div>
        {{ $slot }}
    </div>
</x-layout.root>
