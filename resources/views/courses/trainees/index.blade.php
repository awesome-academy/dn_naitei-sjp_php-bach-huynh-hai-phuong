<x-layout.admin-panel title="Trainees">
    <div class="flex items-center justify-between mb-4">
        <x-ui.button variant="link" tag="a" href="{{ route('courses.show', $course->id) }}">
            <x-fas-arrow-left /> {{ __('course.course') }}: {{ $course->title }}
        </x-ui.button>
        <x-ui.button tag="a" href="{{ route('courses.trainees.create', $course->id) }}">{{ __('course.add_trainee') }}
            <x-fas-plus /></x-ui.button>
    </div>
    @if ($trainees->isEmpty())
        <p>{{ __('course.no_trainees') }}</p>
    @else
        <ul class="grid gap-2 mb-4">
            @foreach ($trainees as $trainee)
                <li>
                    <x-ui.card class="p-0">
                        <x-ui.card.content class="p-4 grid grid-cols-[20px_1fr_0.5fr_100px] gap-2 hover:bg-accent items-center">
                            <x-fas-user-cog class="size-5" />
                            <p>
                                {{ $trainee->name }}
                            </p>
                            @if (optional($trainee->pivot)->is_active)
                                <x-ui.badge variant="outline">{{ __('course.trainee_active') }}</x-ui.badge>
                            @else
                                <x-ui.badge variant="destructive">{{ __('course.trainee_deactive') }}</x-ui.badge>
                            @endif
                            <div class="flex gap-2 items-center">
                                <x-ui.alert-dialog title="{{ __('alert.confirm') }}"
                                    description="{{ __('course.trainee_delete_warning') }}">
                                    <x-slot:trigger>
                                        <x-ui.button class="size-9 rounded-full" variant="destructive"
                                            @click="modalOpen = true">
                                            <x-fas-trash-can class="size-4" />
                                        </x-ui.button>
                                    </x-slot:trigger>
                                    <x-slot:actions>
                                        <x-ui.button @click="modalOpen = false">{{ __('alert.cancel') }}</x-ui.button>
                                        <form
                                            action="{{ route('courses.trainees.remove', ['course' => $course->id, 'trainee' => $trainee->id]) }}"
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
    {{ $trainees->links('components.ui.pagination') }}
</x-layout.admin-panel>
