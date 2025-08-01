<x-layout.admin-panel title="Courses">
    @if ($courses->isEmpty())
        <p>{{ __('course.no_courses') }}</p>
    @else
        <ul class="grid grid-cols-3 gap-4 mb-4">
            @foreach ($courses as $course)
                <li>
                    <x-ui.card class="p-0">
                        <x-ui.card.content class="p-0 relative">
                            <a class="block aspect-video relative" href="{{ route('courses.show', $course->id) }}">
                                <img src="{{ asset('/storage/' . $course->featured_image) }}" alt="{{ $course->title }}"
                                    class="absolute inset-0 w-full h-full object-cover object-top rounded-t-xl">
                            </a>
                            <x-courses.course-status-badge :status="$course->status->value" class="absolute top-4 right-4" />
                            <div class="p-4">
                                <a class="text-lg font-bold line-clamp-1" title="{{ $course->title }}"
                                    href="{{ route('courses.show', $course->id) }}">{{ $course->title }}</a>
                            </div>
                        </x-ui.card.content>
                    </x-ui.card>
                </li>
            @endforeach
        </ul>
    @endif
    {{ $courses->links('components.ui.pagination') }}
</x-layout.admin-panel>
