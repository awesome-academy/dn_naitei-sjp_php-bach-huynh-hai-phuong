<x-layout.admin-panel title="{{ __('course.show_course') }}">
    <div class="grid grid-cols-[300px_1fr_300px] gap-6">
        <div>
            @isset($course->featured_image)
                <img src="{{ asset('/storage/' . $course->featured_image) }}" alt="{{ $course->title }}"
                    class="aspect-video object-cover w-full rounded-lg">
            @else
                <div class="aspect-video w-full rounded-lg flex items-center justify-center">
                    <x-fas-paw class="size-16 text-muted-foreground" />
                </div>
            @endisset
        </div>
        <div>
            <h1 title="{{ $course->title ?: 'Title' }}" class="text-3xl font-bold line-clamp-2">
                {{ $course->title ?: 'Title' }}
            </h1>
            <p class="text-sm text-muted-foreground">{{ $course->description ?: 'Description' }}</p>
            <div class="flex gap-2 mt-2">
                <x-ui.button class="w-30 rounded-full" tag="a"
                    href="{{ route('courses.edit', $course->id) }}">{{ __('course.edit') }} <x-fas-edit /></x-ui.button>
                <x-ui.alert-dialog title="{{ __('alert.confirm') }}"
                    description="{{ __('alert.warning', ['resource' => 'course']) }}">
                    <x-slot:trigger>
                        <x-ui.button class="w-30 rounded-full" variant="destructive" @click="modalOpen = true">
                            {{ __('course.delete') }} <x-fas-trash-can />
                        </x-ui.button>
                    </x-slot:trigger>
                    <x-slot:actions>
                        <x-ui.button @click="modalOpen = false">{{ __('course.cancel') }}</x-ui.button>
                        <form action="{{ route('courses.destroy', $course->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <x-ui.button variant="destructive" @click="modalOpen = false"
                                type="submit">{{ __('course.delete') }}</x-ui.button>
                        </form>
                    </x-slot:actions>
                </x-ui.alert-dialog>
            </div>

        </div>
        <div>
            <div class="flex flex-col justify-center gap-2">
                <h2 class="text-lg font-semibold">{{ __('course.course_details') }}</h2>
                <p class="text-sm text-muted-foreground"><span
                        class="font-semibold">{{ __('course.started_at') }}:</span>
                    {{ $courseDetails['started_at'] }}
                </p>
                <p class="text-sm text-muted-foreground"><span
                        class="font-semibold">{{ __('course.finished_at') }}:</span>
                    {{ $courseDetails['finished_at'] }}</p>
                <p class="text-sm text-muted-foreground"><span
                        class="font-semibold">{{ __('course.created_at') }}:</span>
                    {{ $courseDetails['created_at'] }}</p>
                <p class="text-sm text-muted-foreground"><span
                        class="font-semibold">{{ __('course.updated_at') }}:</span>
                    {{ $courseDetails['updated_at'] }}</p>
                <p class="text-sm text-muted-foreground"><span class="font-semibold">{{ __('course.status') }}:</span>
                    <x-ui.course-status-badge :status="$courseDetails['status']" />
                </p>
            </div>
        </div>
    </div>
</x-layout.admin-panel>
