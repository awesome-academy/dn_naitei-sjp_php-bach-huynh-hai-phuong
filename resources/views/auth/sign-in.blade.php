<x-layout.auth>
    <x-slot:title>{{ __('auth.sign_in') }}</x-slot:title>
    <div class="flex flex-col gap-6">
        <x-ui.card class="overflow-hidden p-0">
            <x-ui.card.content class="grid p-0 md:grid-cols-2">
                <form class="p-6 md:p-8" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="flex flex-col gap-6">
                        <div class="flex flex-col items-center text-center">
                            <h1 class="text-2xl font-bold">{{ __('auth.welcome_back') }}</h1>
                            <p class="text-muted-foreground text-balance">
                                {{ __('auth.login_to_app', ['app_name' => config('app.name')]) }}
                            </p>
                        </div>
                        <div class="grid gap-3">
                            <x-ui.label for="email">{{ __('auth.email') }}</x-ui.label>
                            <x-ui.input id="email" name="email" type="email" placeholder="m@example.com"
                                value="{{ old('email') }}" required />
                            @error('email')
                                <p class="text-sm text-destructive line-clamp-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="grid gap-3">
                            <div class="flex items-center">
                                <x-ui.label for="password">{{ __('auth.password') }}</x-ui.label>
                                <a href="#" class="ml-auto text-sm underline-offset-2 hover:underline">
                                    {{ __('auth.forgot_password') }}
                                </a>
                            </div>
                            <x-ui.input id="password" name="password" type="password" required />
                        </div>
                        <x-ui.button type="submit" class="w-full">
                            {{ __('auth.login') }}
                        </x-ui.button>
                        <div
                            class="after:border-border relative text-center text-sm after:absolute after:inset-0 after:top-1/2 after:z-0 after:flex after:items-center after:border-t">
                            <span class="bg-card text-muted-foreground relative z-10 px-2">
                                {{ __('auth.or_continue_with') }}
                            </span>
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            <x-ui.button variant="outline" type="button" class="w-full">
                                <x-fab-apple />
                                <span class="sr-only">{{ __('auth.login_with', ['platform' => 'Apple']) }}</span>
                            </x-ui.button>
                            <x-ui.button variant="outline" type="button" class="w-full">
                                <x-fab-google />
                                <span class="sr-only">{{ __('auth.login_with', ['platform' => 'Google']) }}</span>
                            </x-ui.button>
                            <x-ui.button variant="outline" type="button" class="w-full">
                                <x-fab-meta />
                                <span class="sr-only">{{ __('auth.login_with', ['platform' => 'Meta']) }}</span>
                            </x-ui.button>
                        </div>
                        <div class="text-center text-sm">
                            {{ __('auth.no_account') }}
                            <a href="#" class="underline underline-offset-4">
                                {{ __('auth.sign_up') }}
                            </a>
                        </div>
                    </div>
                </form>
                <div class="bg-muted relative hidden md:block">
                    <img src="{{ asset('images/GXSWcazW8AAUQ4C.jpg') }}" alt="{{ __('auth.image') }}"
                        class="absolute inset-0 h-full w-full object-cover dark:brightness-[0.2] dark:grayscale" />
                </div>
            </x-ui.card.content>
        </x-ui.card>
        <div
            class="text-muted-foreground *:[a]:hover:text-primary text-center text-xs text-balance *:[a]:underline *:[a]:underline-offset-4">
            {{ __('auth.agree_terms') }} <a href="#">{{ __('auth.terms') }}</a>
            {{ __('auth.and') }} <a href="#">{{ __('auth.privacy') }}</a>.
        </div>
    </div>
</x-layout.auth>
