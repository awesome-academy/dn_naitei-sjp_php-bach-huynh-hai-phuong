<x-layout.admin-panel title="{{ __('user.users') }}">
    @if ($users->isEmpty())
        <p>{{ __('user.no_users') }}</p>
    @else
        <x-ui.card class="mb-4">
            <x-ui.card.content>
                <x-ui.table>
                    <x-ui.table.header>
                        <x-ui.table.row>
                            <x-ui.table.head class="w-[200px]">{{ __('user.name') }}</x-ui.table.head>
                            <x-ui.table.head>{{ __('user.email') }}</x-ui.table.head>
                            <x-ui.table.head class="w-[200px] text-center">{{ __('user.action') }}</x-ui.table.head>
                        </x-ui.table.row>
                    </x-ui.table.header>
                    <x-ui.table.body>
                        @foreach ($users as $user)
                            <x-ui.table.row>
                                <x-ui.table.cell class="relative">
                                    <p class="absolute left-2 top-1/2 right-2 -translate-y-1/2 line-clamp-1"
                                        title="{{ $user->name }}">{{ $user->name }}</p>
                                </x-ui.table.cell>
                                <x-ui.table.cell class="relative">
                                    <p class="absolute left-2 top-1/2 right-2 -translate-y-1/2 line-clamp-1">
                                        {{ $user->email }}</p>
                                </x-ui.table.cell>
                                <x-ui.table.cell class="flex items-center justify-center gap-2">
                                    <x-ui.button href="{{ route('users.edit', $user->id) }}" tag="a"
                                        class="size-9 rounded-full" variant="outline"><x-fas-edit
                                            class="size-4" /></x-ui.button>
                                </x-ui.table.cell>
                            </x-ui.table.row>
                        @endforeach
                    </x-ui.table.body>
                </x-ui.table>
            </x-ui.card.content>
        </x-ui.card>
    @endif
    {{ $users->links('components.ui.pagination') }}
</x-layout.admin-panel>
