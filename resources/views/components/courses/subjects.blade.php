@use(App\Models\Enums\CourseSubjectStatus)
@use(App\Models\Enums\CourseStatus)

<div
    class="after:border-border relative text-center text-sm after:absolute after:inset-0 after:top-1/2 after:z-0 after:flex after:items-center after:border-t my-4">
    <span class="bg-zinc-50 dark:bg-zinc-900 text-muted-foreground relative z-10 px-2 text-2xl font-medium">
        {{ __('course_subject.subject_list') }}
    </span>
</div>
<div class="grid gap-4">
    @forelse ($subjects as $subject)
        <x-ui.card>
            <x-ui.card.content>
                <x-ui.collapsible>
                    <x-slot:trigger>
                        <div class="flex items-center gap-2"><span class="font-bold">{{ $subject->sort_order }}.
                                {{ $subject->title ?: '?' }}</span>
                            <x-courses.subject-status-badge :status="$subject->status" />
                        </div>
                    </x-slot:trigger>
                    <div class="ml-3 border-l border-border p-3">
                        <div class="space-y-2">
                            <div>
                                <span class="font-bold">{{ __('course_subject.description') }}:</span>
                                <p class="text-muted-foreground">
                                    {{ $subject->description ?: __('course_subject.no_description') }}
                                </p>
                            </div>
                            <p class="text-muted-foreground">
                                <span class="font-bold">{{ __('course_subject.estimated_days') }}:</span>
                                {{ $subject->estimated_duration_days }}
                            </p>
                            <p class="text-muted-foreground">
                                <span class="font-bold">{{ __('course_subject.started_at') }}:</span>
                                {{ $subject->started_at }}
                            </p>
                            <p class="text-muted-foreground">
                                <span class="font-bold">{{ __('course_subject.finished_at') }}:</span>
                                {{ $subject->finished_at }}
                            </p>
                        </div>
                        <div class="w-full border-t border-border my-3"></div>
                        <div class="flex items-center justify-between gap-2">
                            <span class="font-bold">{{ __('course_subject.action') }}:</span>
                            <div class="flex gap-2 items-center">
                                @if($course->status == CourseStatus::STARTED)
                                    <x-courses.change-subject-status :courseId="$course->id" :subjectId="$subject->id"
                                        :isToStartMode="$subject->status == CourseSubjectStatus::NOT_STARTED->value" />
                                @endif
                                <x-ui.button tag="a"
                                    href="{{ route('courses.tasks.create', ['course' => $course->id, 'subject' => $subject->id]) }}"
                                    class="size-9 rounded-full" variant="outline">
                                    <x-fas-plus class="size-4" />
                                </x-ui.button>
                                <x-ui.alert-dialog title="{{ __('alert.confirm') }}"
                                    description="{{ __('course_subject.subject_delete_warning') }}">
                                    <x-slot:trigger>
                                        <x-ui.button class="size-9 rounded-full" variant="destructive"
                                            @click="modalOpen = true">
                                            <x-fas-trash-can class="size-4" />
                                        </x-ui.button>
                                    </x-slot:trigger>
                                    <x-slot:actions>
                                        <x-ui.button @click="modalOpen = false">{{ __('alert.cancel') }}</x-ui.button>
                                        <form
                                            action="{{ route('courses.subject.remove', ['course' => $course->id, 'subject' => $subject->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <x-ui.button variant="destructive" @click="modalOpen = false"
                                                type="submit">{{ __('alert.delete') }}</x-ui.button>
                                        </form>
                                    </x-slot:actions>
                                </x-ui.alert-dialog>
                            </div>
                        </div>
                        <div class="w-full border-t border-border my-3"></div>
                        <div class="space-y-2">
                            <span class="font-bold">{{ __('task.task_list') }}:</span>
                            @forelse ($subject->tasks as $task)
                                <x-ui.collapsible>
                                    <x-slot:trigger>
                                        {{ $task['sort_order'] }}. {{ $task['title'] ?: __('task.no_title') }}
                                    </x-slot:trigger>
                                    <div class="ml-3 border-l border-border p-3">
                                        <div class="text-muted-foreground"
                                            x-data="{ expanded: false, text: '{{ $task['description'] ?: __('task.no_description') }}', limit: 300 }">
                                            <span class="font-bold block">{{ __('task.task_description') }}:</span>
                                            <p class="inline"
                                                x-text="expanded ? text : text.length > limit ? text.slice(0, limit) + '...' : text">
                                            </p>
                                            <button x-show="text.length > limit" @click="expanded = !expanded"
                                                x-text="expanded ? 'Less' : 'More'" class="text-blue-500"></button>
                                        </div>
                                        <div class="w-full border-t border-border my-3"></div>
                                        <div class="flex items-center justify-between gap-2">
                                            <span class="font-bold">{{ __('task.action') }}:</span>
                                            <div class="flex gap-2 items-center">
                                                <x-ui.button tag="a" href="{{ route('tasks.reports.user_tasks', ['task' => $task['id']]) }}"
                                                    class="size-9 rounded-full" variant="outline">
                                                    <x-fas-eye class="size-4" />
                                                </x-ui.button>
                                                <x-ui.button tag="a" href="{{ route('tasks.edit', ['task' => $task['id']]) }}"
                                                    class="size-9 rounded-full" variant="outline">
                                                    <x-fas-edit class="size-4" />
                                                </x-ui.button>
                                                <x-ui.alert-dialog title="{{ __('alert.confirm') }}"
                                                    description="{{ __('task.task_delete_warning') }}">
                                                    <x-slot:trigger>
                                                        <x-ui.button class="size-9 rounded-full" variant="destructive"
                                                            @click="modalOpen = true">
                                                            <x-fas-trash-can class="size-4" />
                                                        </x-ui.button>
                                                    </x-slot:trigger>
                                                    <x-slot:actions>
                                                        <x-ui.button
                                                            @click="modalOpen = false">{{ __('alert.cancel') }}</x-ui.button>
                                                        <form action="{{ route('tasks.destroy', $task['id']) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <x-ui.button variant="destructive" @click="modalOpen = false"
                                                                type="submit">{{ __('alert.delete') }}</x-ui.button>
                                                        </form>
                                                    </x-slot:actions>
                                                </x-ui.alert-dialog>
                                            </div>
                                        </div>
                                    </div>
                                </x-ui.collapsible>
                            @empty
                                <p class="text-sm text-muted-foreground text-center">{{ __('task.task_empty') }}</p>
                            @endforelse
                        </div>
                    </div>
                </x-ui.collapsible>
            </x-ui.card.content>
        </x-ui.card>
    @empty
        <p class="text-sm text-muted-foreground text-center">{{ __('course_subject.subject_empty') }}</p>
    @endforelse
</div>
