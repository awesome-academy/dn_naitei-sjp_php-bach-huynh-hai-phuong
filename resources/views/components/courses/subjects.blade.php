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
                        <div class="flex items-center gap-2"><span class="font-bold">{{ $subject->title ?: '?' }}</span>
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
                            <div>
                                <x-ui.button class="size-9 rounded-full" variant="destructive">
                                    <x-fas-trash-can class="size-4" />
                                </x-ui.button>
                            </div>
                        </div>
                    </div>
                </x-ui.collapsible>
            </x-ui.card.content>
        </x-ui.card>
    @empty
        <p class="text-sm text-muted-foreground text-center">{{ __('course_subject.subject_empty') }}</p>
    @endforelse
</div>
<x-ui.button class="w-full mt-4">{{ __('course_subject.add') }} <x-fas-plus class="size-4" /></x-ui.button>
