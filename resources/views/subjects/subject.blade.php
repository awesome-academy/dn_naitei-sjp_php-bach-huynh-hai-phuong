@php
    $isEdit = isset($subject) && $subject instanceof \App\Models\Subject;
@endphp

<x-layout.admin-panel title="{{ $isEdit ? __('subject.edit_subject') : __('subject.create_subject') }}">
    <x-ui.card>
        <x-ui.card.header>
            <x-ui.card.title>{{ $isEdit ? __('subject.edit_subject') : __('subject.create_subject') }}</x-ui.card.title>
        </x-ui.card.header>
        <x-ui.card.content>
            @if ($isEdit)
                <x-form.subject-form :id="$subject->id" :title="$subject->title" :description="$subject->description" />
            @else
                <x-form.subject-form />
            @endif
        </x-ui.card.content>
    </x-ui.card>
</x-layout.admin-panel>
