<form action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}" method="POST"
    enctype="multipart/form-data" class="space-y-4">

    @if (isset($user))
        @method('PUT')
    @endif

    @csrf

    <div class="space-y-4">
        <div class="space-y-2">
            <x-ui.label for="email">{{ __('user.email') }}</x-ui.label>
            @if (isset($user))
                <x-ui.input type="text" name="email" id="email" type="email" disabled
                    value="{{ old('email') ?? ($user?->email ?? '') }}" />
            @else
                <x-ui.input type="text" name="email" id="email" type="email" required
                    value="{{ old('email') ?? '' }}" />
            @endif
            @error('email')
                <p class="text-sm text-destructive line-clamp-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="space-y-2">
            <x-ui.label for="name">{{ __('user.name') }}</x-ui.label>
            <x-ui.input type="text" name="name" id="name" required
                value="{{ old('name') ?? ($user?->name ?? '') }}" />
            @error('name')
                <p class="text-sm text-destructive line-clamp-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="space-y-2">
            <x-ui.label for="password">{{ __('user.password') }}</x-ui.label>
            @if (isset($user))
                <x-ui.input type="text" name="password" id="password" type="password"
                    value="{{ old('password') ?? '' }}" />
            @else
                <x-ui.input type="text" name="password" id="password" type="password" required
                    value="{{ old('password') ?? '' }}" />
            @endif
            @error('password')
                <p class="text-sm text-destructive line-clamp-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    @if (isset($user))
        <x-ui.button type="submit" class="w-full">{{ __('user.update_user') }} <x-fas-edit /></x-ui.button>
    @else
        <x-ui.button type="submit" class="w-full">{{ __('user.create_user') }} <x-fas-plus /></x-ui.button>
    @endif
</form>
