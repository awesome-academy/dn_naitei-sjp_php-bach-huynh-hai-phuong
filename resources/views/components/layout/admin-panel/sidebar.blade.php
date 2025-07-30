<aside x-data :class="{ 'w-72': $store.sidebar.isOpen, 'w-[90px]': !$store.sidebar.isOpen }"
    class="fixed top-0 left-0 z-20 h-screen translate-x-0 transition-[width] ease-in-out duration-300 w-72">
    <div class="absolute top-[12px] -right-[16px] z-20">
        <x-ui.button class="rounded-md w-8 h-8" variant="outline" size="icon" @click="$store.sidebar.toggle()">
            <x-fas-chevron-left class="h-4 w-4 transition-transform ease-in-out duration-300 rotate-0" ::class="{ 'rotate-0': $store.sidebar.isOpen, 'rotate-180': !$store.sidebar.isOpen }" />
        </x-ui.button>
    </div>
    <div class="relative h-full flex flex-col px-3 py-4 overflow-y-auto shadow-md dark:shadow-zinc-800">
        <x-ui.button tag="a" variant="link" href="/"
            class="transition-transform ease-in-out duration-300 mb-1 flex items-center gap-2 translate-x-0" ::class="{ 'translate-x-0': $store.sidebar.isOpen, 'translate-x-1': !$store.sidebar.isOpen }">
            <x-fas-book-reader class="w-6 h-6 mr-1" />
            <h1 class="font-bold text-lg whitespace-nowrap transition-[transform,opacity,display] ease-in-out duration-300 translate-x-0 opacity-100"
                :class="{
                    'translate-x-0 opacity-100': $store.sidebar.isOpen,
                    '-translate-x-96 opacity-0 hidden': !$store.sidebar.isOpen,
                }">
                {{ config('app.name') }}
            </h1>
        </x-ui.button>
        <x-layout.admin-panel.menu />
    </div>
</aside>
