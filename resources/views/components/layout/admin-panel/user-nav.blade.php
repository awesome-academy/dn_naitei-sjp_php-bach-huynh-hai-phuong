@if (auth()->check())
    <div x-data="{
        dropdownOpen: false
    }" class="relative"
    >
        <x-ui.button @click="dropdownOpen = true" variant="outline" class="h-8 w-8 rounded-full">
            <x-fas-paw class="h-[1.2rem] w-[1.2rem]" />
        </x-ui.button>

        <div x-show="dropdownOpen" @click.away="dropdownOpen=false" x-transition:enter="ease-out duration-200"
            x-transition:enter-start="-translate-y-2" x-transition:enter-end="translate-y-0"
            class="absolute z-50 top-0 right-0 translate-y-9" x-cloak>
            <div
                class="bg-popover text-popover-foreground overflow-x-hidden overflow-y-auto rounded-md border p-1 shadow-md min-w-[12rem]">
                <div class="px-2 py-1.5 text-sm font-medium">
                    <div class="flex flex-col space-y-1">
                        <p class="text-sm font-medium leading-none">{{ auth()->user()->name }}</p>
                        <p class="text-xs leading-none text-muted-foreground">
                            {{ auth()->user()->email }}
                        </p>
                    </div>
                </div>
                <div class="bg-border -mx-1 my-1 h-px"></div>
                <a
                    class="hover:bg-accent hover:text-accent-foreground focus:bg-accent focus:text-accent-foreground cursor-pointer relative flex items-center gap-4 rounded-sm px-2 py-1.5 text-sm outline-hidden select-none">
                    <x-far-user class="h-3 w-3" />
                    <span class="truncate">{{ __('layout.dashboard') }}</span>
                </a>
                <a
                    class="hover:bg-accent hover:text-accent-foreground focus:bg-accent focus:text-accent-foreground cursor-pointer relative flex items-center gap-4 rounded-sm px-2 py-1.5 text-sm outline-hidden select-none">
                    <x-far-user class="h-3 w-3" />
                    <span class="truncate">{{ __('layout.account') }}</span>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button
                        class="hover:bg-accent hover:text-accent-foreground focus:bg-accent focus:text-accent-foreground cursor-pointer relative flex items-center gap-4 rounded-sm px-2 py-1.5 text-sm outline-hidden select-none w-full">
                        <x-fas-sign-out-alt class="h-3 w-3" />
                        <span class="truncate">{{ __('layout.sign_out') }}</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
@else
    <x-ui.button variant="outline" class="h-8 w-8 rounded-full">
        <x-fas-paw class="h-[1.2rem] w-[1.2rem]" />
    </x-ui.button>
@endif
