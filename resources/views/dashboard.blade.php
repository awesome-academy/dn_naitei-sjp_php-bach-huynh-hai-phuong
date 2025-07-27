<x-layout.dashboard>
    @if (auth()->check())
        <p>Welcome, {{ auth()->user()->name }}!</p>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-ui.button type="submit" variant="destructive">Logout</x-ui.button>
        </form>
    @else
        <p>Please log in to access your account.</p>
    @endif
</x-layout.dashboard>
