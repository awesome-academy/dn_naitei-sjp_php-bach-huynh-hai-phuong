<div x-data class="overflow-y-auto">
    <nav class="mt-8 h-[100%-40px] w-full">
        <ul class="flex flex-col min-h-[calc(100vh-32px-40px-32px)] space-y-1 items-start px-2">
            @foreach ($menuList as $menuGroup)
                <li class="w-full{{ $menuGroup['groupLabel'] ? ' pt-5' : '' }}">
                    @if ($menuGroup['groupLabel'])
                        <p class="text-sm font-medium text-muted-foreground px-4 pb-2 max-w-[248px] truncate"
                            x-show="$store.sidebar.isOpen" title="{{ __($menuGroup['groupLabel']) }}"
                        >
                            {{ __($menuGroup['groupLabel']) }}
                        </p>
                        <div class="w-full flex justify-center items-center pb-2" x-show="! $store.sidebar.isOpen"
                            title="{{ __($menuGroup['groupLabel']) }}">
                            <x-fas-ellipsis class="h-5 w-5" />
                        </div>
                    @else
                        <p class="pb-2"></p>
                    @endif

                    @foreach ($menuGroup['menu'] as $menu)
                        @php
                            $isCreate = Str::endsWith(request()->url(), '/create');

                            if ($isCreate) {
                                $isActive = request()->url() === url($menu['href']);
                            } else {
                                $isActive = Str::startsWith(request()->url(), url($menu['href']));
                            }
                        @endphp

                        <div class="w-full">
                            <x-ui.button tag="a" href="{{ $menu['href'] }}"
                                variant="{{ $isActive ? 'secondary' : 'ghost' }}" class="w-full justify-start h-10 mb-1"
                                title="{{ __($menu['label']) }}"
                            >
                                <span class="mr-4" :class="{ 'mr-4': $store.sidebar.isOpen }">
                                    <x-dynamic-component :component="$menu['icon']" class="h-5 w-5" />
                                </span>
                                <p class="max-w-[200px] truncate translate-x-0 opacity-100"
                                    :class="{
                                        'translate-x-0 opacity-100': $store.sidebar.isOpen,
                                        '-translate-x-96 opacity-0': ! $store.sidebar.isOpen,
                                    }"
                                >
                                    {{ __($menu['label']) }}
                                </p>
                            </x-ui.button>
                        </div>
                    @endforeach
                </li>
            @endforeach
            <li class="w-full grow flex items-end">
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <x-ui.button type="submit" variant="outline" class="w-full justify-center h-10 mt-5"
                        title="Sign out"
                    >
                        <span class="mr-4" :class="{ 'mr-4': $store.sidebar.isOpen }">
                            <x-fas-sign-out-alt class="h-5 w-5" />
                        </span>
                        <p class="whitespace-nowrap opacity-100"
                            :class="{ 'opacity-100': $store.sidebar.isOpen, 'opacity-0 hidden': ! $store.sidebar.isOpen }">
                            {{ __('layout.sign_out') }}
                        </p>
                    </x-ui.button>
                </form>
            </li>
        </ul>
    </nav>
</div>
