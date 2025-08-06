<x-layout.admin-panel title="Trainees">
    <x-ui.button variant="link" tag="a" href="{{ route('courses.trainees.index', $course->id) }}" class="mb-4">
        <x-fas-arrow-left /> {{ __('course.trainee') }}
    </x-ui.button>
    @if ($availableTrainees->isEmpty())
        <p>{{ __('course.no_trainees') }}</p>
    @else
        <ul class="grid gap-2 mb-4">
            @foreach ($availableTrainees as $trainee)
                <li>
                    <x-ui.card class="p-0">
                        <x-ui.card.content class="p-4 grid grid-cols-[20px_1fr_100px] gap-2 hover:bg-accent items-center">
                            <x-fas-user-cog class="size-5" />
                            <p>
                                {{ $trainee->name }}
                            </p>
                            <div class="flex gap-2 items-center">
                                <form method="POST" action="{{ route('courses.trainees.add', $course->id) }}">
                                    @csrf
                                    <input type="hidden" value="{{ $trainee->id }}" name="trainee_id" />
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
    {{ $availableTrainees->links('components.ui.pagination') }}
</x-layout.admin-panel>
