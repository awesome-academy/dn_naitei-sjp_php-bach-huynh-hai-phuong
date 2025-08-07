<x-ui.alert-dialog title="{{ __('alert.confirm') }}"
    description="{{ $isToStartMode ? __('course_subject.subject_start_warning') : __('course_subject.subject_finish_warning') }}">
    <x-slot:trigger>
        <x-ui.button class="size-9 rounded-full" variant="{{ $isToStartMode ? 'secondary' : 'destructive' }}"
            @click="modalOpen = true">
            @if ($isToStartMode)
                <x-fas-hourglass-start class="size-4" />
            @else
                <x-fas-hourglass-end class="size-4" />
            @endif
        </x-ui.button>
    </x-slot:trigger>
    <x-slot:actions>
        <x-ui.button @click="modalOpen = false">{{ __('alert.cancel') }}</x-ui.button>
        <form
            action="{{ $isToStartMode ? route('courses.subject.start', ['course' => $courseId, 'subject' => $subjectId]) : route('courses.subject.finish', ['course' => $courseId, 'subject' => $subjectId]) }}"
            method="POST">
            @csrf
            <x-ui.button variant="destructive" @click="modalOpen = false"
                type="submit">{{ __('alert.ok') }}</x-ui.button>
        </form>
    </x-slot:actions>
</x-ui.alert-dialog>
