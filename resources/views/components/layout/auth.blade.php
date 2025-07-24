<x-layout.root>
    <x-slot:title>{{ $title ?? 'Authenticate' }}</x-slot:title>
    <div>
        {{ $slot }}
    </div>
</x-layout.root>