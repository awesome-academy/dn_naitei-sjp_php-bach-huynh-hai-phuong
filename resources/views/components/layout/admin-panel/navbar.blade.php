<header
    class="sticky top-0 z-10 w-full bg-background/95 shadow backdrop-blur supports-[backdrop-filter]:bg-background/60 dark:shadow-secondary">
    <div class="mx-4 sm:mx-8 flex h-14 items-center">
        <div class="flex items-center space-x-0">
            <h1 class="font-bold">{{ $title }}</h1>
        </div>
        <div class="flex flex-1 items-center justify-end gap-2">
            <x-layout.admin-panel.theme-toggle />
            <x-layout.admin-panel.user-nav />
        </div>
    </div>
</header>
