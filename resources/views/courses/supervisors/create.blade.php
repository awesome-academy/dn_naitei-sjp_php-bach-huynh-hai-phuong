<x-layout.admin-panel title="Supervisors">
    <x-ui.button variant="link" tag="a" href="{{ route('courses.supervisors.index', $course->id) }}" class="mb-4">
        <x-fas-arrow-left /> {{ __('course.supervisor') }}
    </x-ui.button>
    @if ($availableSupervisors->isEmpty())
        <p>{{ __('course.no_supervisors') }}</p>
    @else
        <ul class="grid gap-2 mb-4">
            @foreach ($availableSupervisors as $supervisor)
                <li>
                    <x-ui.card class="p-0">
                        <x-ui.card.content class="p-4 grid grid-cols-[20px_1fr_100px] gap-2 hover:bg-accent items-center">
                            <x-fas-user-secret class="size-5" />
                            <p>
                                {{ $supervisor->name }}
                            </p>
                            <div class="flex gap-2 items-center">
                                <form method="POST" action="{{ route('courses.supervisors.add', $course->id) }}">
                                    @csrf
                                    <input type="hidden" value="{{ $supervisor->id }}" name="supervisor_id" />
                                    <x-ui.button class="size-9 rounded-full" type="submit">
                                        <x-fas-plus class="size-4" />
                                    </x-ui.button>
                                </form>
                            </div>
                        </x-ui.card.content>
                    </x-ui.card>
                </li>
            @endforeach
        </ul>
    @endif
    {{ $availableSupervisors->links('components.ui.pagination') }}
</x-layout.admin-panel>
