@php
    $isEdit = isset($course) && $course instanceof \App\Models\Course;
@endphp

<x-layout.admin-panel title="{{ $isEdit ? __('course.edit_course') : __('course.create_course') }}">
    <x-ui.card>
        <x-ui.card.header>
            <x-ui.card.title>{{ $isEdit ? __('course.edit_course') : __('course.create_course') }}</x-ui.card.title>
        </x-ui.card.header>
        <x-ui.card.content>
            @if ($isEdit)
                <x-form.course-form :id="$course->id" :title="$course->title" :description="$course->description"
                    :featuredImage="$course->featured_image" />
            @else
                <x-form.course-form />
            @endif
        </x-ui.card.content>
    </x-ui.card>
</x-layout.admin-panel>
