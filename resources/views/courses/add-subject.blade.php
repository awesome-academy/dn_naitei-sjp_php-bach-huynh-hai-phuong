<x-layout.admin-panel title="{{ __('course_subject.add') }}">
    <x-ui.card>
        <x-ui.card.header>
            <x-ui.card.title>{{ __('course_subject.add_subject_to_course', ['course' => $course->title ?: '?']) }}</x-ui.card.title>
        </x-ui.card.header>
        <x-ui.card.content>
            @if (count($formattedAvailableSubjects) !== 0)
                <form action="{{ route('courses.subject.add', $course->id) }}" method="POST" class="grid gap-4">
                    @csrf
                    <div class="grid gap-2">
                        <x-ui.label for="subject_id">{{ __('course_subject.subject') }}</x-ui.label>
                        <x-ui.select name="subject_id" id="subject_id" :items="$formattedAvailableSubjects"
                            defaultValue="{{ old('subject_id') }}" placeholder="{{ __('course_subject.select_subject') }}"
                            required={{ true }} />
                        @error('subject_id')
                            <p class="text-sm text-destructive line-clamp-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="grid gap-2">
                        <x-ui.label
                            for="estimated_duration_days">{{ __('course_subject.estimated_duration_days') }}</x-ui.label>
                        <x-ui.input name="estimated_duration_days" id="estimated_duration_days" type="number" required
                            value="{{ old('estimated_duration_days') }}"
                            class="[appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none" />
                        @error('estimated_duration_days')
                            <p class="text-sm text-destructive line-clamp-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <x-ui.button>{{ __('course_subject.add') }} <x-fas-plus class="size-4" /></x-ui.button>
                </form>
            @else
                <div class="flex flex-col justify-center gap-2">
                    <p class="text-sm text-muted-foreground text-center">{{ __('course_subject.no_subject_to_add') }}</p>
                    <x-ui.button tag="a" href="{{ route('courses.show', $course->id) }}" variant="link"><x-fas-arrow-left/> {{ __('course_subject.back') }}</x-ui.button>
                </div>
            @endif
        </x-ui.card.content>
    </x-ui.card>
</x-layout.admin-panel>
