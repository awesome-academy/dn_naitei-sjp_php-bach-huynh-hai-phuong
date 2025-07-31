<x-layout.admin-panel title="Subjects">
    @if ($subjects->isEmpty())
        <p>{{ __('subject.no_subjects') }}</p>
    @else
        <x-ui.card class="mb-4">
            <x-ui.card.content>
                <x-ui.table>
                    <x-ui.table.header>
                        <x-ui.table.row>
                            <x-ui.table.head class="w-[200px]">{{ __('subject.title') }}</x-ui.table.head>
                            <x-ui.table.head>{{ __('subject.description') }}</x-ui.table.head>
                            <x-ui.table.head class="w-[200px] text-center">{{ __('subject.action') }}</x-ui.table.head>
                        </x-ui.table.row>
                    </x-ui.table.header>
                    <x-ui.table.body>
                        @foreach ($subjects as $subject)
                            <x-ui.table.row>
                                <x-ui.table.cell class="relative">
                                    <p class="absolute left-2 top-1/2 right-2 -translate-y-1/2 line-clamp-1"
                                        title="{{ $subject->title ?: '?' }}">{{ $subject->title ?: '?' }}</p>
                                </x-ui.table.cell>
                                <x-ui.table.cell class="relative">
                                    <p class="absolute left-2 top-1/2 right-2 -translate-y-1/2 line-clamp-1">
                                        {{ $subject->description ?: '?' }}</p>
                                </x-ui.table.cell>
                                <x-ui.table.cell class="flex items-center justify-center gap-2">
                                    <x-ui.button href="{{ route('subjects.edit', $subject) }}" tag="a"
                                        class="size-9 rounded-full" variant="outline"><x-fas-edit
                                            class="size-4" /></x-ui.button>
                                    <x-ui.alert-dialog title="{{ __('alert.confirm') }}"
                                        description="{{ __('subject.subject_delete_warning') }}">
                                        <x-slot:trigger>
                                            <x-ui.button class="size-9 rounded-full" variant="destructive"
                                                @click="modalOpen = true">
                                                <x-fas-trash-can class="size-4" />
                                            </x-ui.button>
                                        </x-slot:trigger>
                                        <x-slot:actions>
                                            <x-ui.button @click="modalOpen = false">{{ __('alert.cancel') }}</x-ui.button>
                                            <form action="{{ route('subjects.destroy', $subject->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <x-ui.button variant="destructive" @click="modalOpen = false"
                                                    type="submit">{{ __('alert.delete') }}</x-ui.button>
                                            </form>
                                        </x-slot:actions>
                                    </x-ui.alert-dialog>
                                </x-ui.table.cell>
                            </x-ui.table.row>
                        @endforeach
                    </x-ui.table.body>
                </x-ui.table>
            </x-ui.card.content>
        </x-ui.card>
    @endif
    {{ $subjects->links('components.ui.pagination') }}
</x-layout.admin-panel>
