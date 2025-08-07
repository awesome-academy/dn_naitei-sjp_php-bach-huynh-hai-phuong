<x-ui.alert-dialog title="{{ __('alert.confirm') }}"
    description="{{ $isToStartMode ? __('course.course_start_warning') : __('course.course_finish_warning') }}">
    <x-slot:trigger>
        @if ($isToStartMode)
            <x-ui.button class="w-30 rounded-full" variant="secondary" @click="modalOpen = true">
                {{ __('course.start') }} <x-fas-hourglass-start />
            </x-ui.button>
        @else
            <x-ui.button class="w-30 rounded-full" variant="destructive" @click="modalOpen = true">
                {{ __('course.finish') }} <x-fas-hourglass-end />
            </x-ui.button>
        @endif
    </x-slot:trigger>
    <x-slot:actions>
        <x-ui.button @click="modalOpen = false">{{ __('alert.cancel') }}</x-ui.button>
        <form action="{{ $isToStartMode ? route('courses.start', $courseId) : route('courses.finish', $courseId) }}"
            method="POST">
            @csrf
            <x-ui.button variant="destructive" @click="modalOpen = false"
                type="submit">{{ __('alert.ok') }}</x-ui.button>
        </form>
    </x-slot:actions>
</x-ui.alert-dialog>
