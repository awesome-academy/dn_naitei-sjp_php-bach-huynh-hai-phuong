<x-layout.admin-panel title="Supervisors">
    <div class="flex items-center justify-between mb-4">
        <x-ui.button variant="link" tag="a" href="{{ route('courses.show', $course->id) }}">
            <x-fas-arrow-left /> {{ __('course.course') }}: {{ $course->title }}
        </x-ui.button>
        <x-ui.button tag="a" href="{{ route('courses.supervisors.create', $course->id) }}">{{ __('course.add_supervisor') }}
            <x-fas-plus /></x-ui.button>
    </div>
    @if ($supervisors->isEmpty())
        <p>{{ __('course.no_supervisors') }}</p>
    @else
        <ul class="grid gap-2 mb-4">
            @foreach ($supervisors as $supervisor)
                <li>
                    <x-ui.card class="p-0">
                        <x-ui.card.content class="p-4 grid grid-cols-[20px_1fr_100px] gap-2 hover:bg-accent items-center">
                            <x-fas-user-secret class="size-5" />
                            <p>
                                {{ $supervisor->name }}
                            </p>
                            <div class="flex gap-2 items-center">
                                <x-ui.alert-dialog title="{{ __('alert.confirm') }}"
                                    description="{{ __('course.supervisor_delete_warning') }}">
                                    <x-slot:trigger>
                                        <x-ui.button class="size-9 rounded-full" variant="destructive"
                                            @click="modalOpen = true">
                                            <x-fas-trash-can class="size-4" />
                                        </x-ui.button>
                                    </x-slot:trigger>
                                    <x-slot:actions>
                                        <x-ui.button @click="modalOpen = false">{{ __('alert.cancel') }}</x-ui.button>
                                        <form
                                            action="{{ route('courses.supervisors.remove', ['course' => $course->id, 'supervisor' => $supervisor->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <x-ui.button variant="destructive" @click="modalOpen = false"
                                                type="submit">{{ __('alert.delete') }}</x-ui.button>
                                        </form>
                                    </x-slot:actions>
                                </x-ui.alert-dialog>
                            </div>
                        </x-ui.card.content>
                    </x-ui.card>
                </li>
            @endforeach
        </ul>
    @endif
    {{ $supervisors->links('components.ui.pagination') }}
</x-layout.admin-panel>
