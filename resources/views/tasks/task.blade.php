@php
    $isEdit = isset($task) && $task instanceof \App\Models\Task;
@endphp

<x-layout.admin-panel title="{{ $isEdit ? __('task.edit_task') : __('task.create_task') }}">
    <x-ui.card>
        <x-ui.card.header>
            <x-ui.card.title>{{ $isEdit ? __('task.edit_task') : __('task.create_task') }}</x-ui.card.title>
        </x-ui.card.header>
        <x-ui.card.content>
            @if ($isEdit)
                <x-form.task-form :id="$task->id" :title="$task->title" :description="$task->description" :course="$course"
                    :subject="$subject" />
            @else
                <x-form.task-form :course="$course" :subject="$subject" />
            @endif
        </x-ui.card.content>
    </x-ui.card>
</x-layout.admin-panel>
