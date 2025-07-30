<x-layout.root :title="$title">
    <x-layout.admin-panel.sidebar />
    <main x-data
        class="min-h-[calc(100vh_-_56px)] bg-zinc-50 dark:bg-zinc-900 transition-[margin-left] ease-in-out duration-300 ml-72"
        :class="{ 'ml-72': $store.sidebar.isOpen, 'ml-[90px]': ! $store.sidebar.isOpen }">
        <div>
            <x-layout.admin-panel.navbar :title="$title" />
            <div class="container pt-8 pb-8 px-4 sm:px-8 mx-auto">{{ $slot }}</div>
        </div>
    </main>
    <footer class="transition-[margin-left] ease-in-out duration-300 ml-72"
        :class="{ 'ml-72': $store.sidebar.isOpen, 'ml-[90px]': ! $store.sidebar.isOpen }">
        <x-layout.admin-panel.footer />
    </footer>
</x-layout.root>
