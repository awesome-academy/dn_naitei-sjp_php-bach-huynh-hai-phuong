<x-layout.admin-panel title="{{ isset($user) ? __('user.edit_user') : __('user.create_user') }}">
    <x-ui.card>
        <x-ui.card.header>
            <x-ui.card.title>{{ isset($user) ? __('user.edit_user') : __('user.create_user') }}</x-ui.card.title>
        </x-ui.card.header>
        <x-ui.card.content>
            <x-form.user-form :user="$user ?? null" />
        </x-ui.card.content>
    </x-ui.card>
</x-layout.admin-panel>
