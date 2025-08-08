<x-layout.admin-panel title="{{ __('task.reports') }}: {{ $task->title }}">
    <x-ui.button tag="a" href="{{ url()->previous() }}" variant="link" class="mb-2">
        <x-fas-arrow-left />
        {{ __('task.back') }}
    </x-ui.button>
    <div class="mb-4">
        @forelse ($userTasks as $userTask)
            <x-ui.card>
                <x-ui.card.content>
                    <div class="flex gap-4 items-center justify-between">
                        <div class="flex gap-4 w-60">
                            <div class="flex items-center justify-center size-10 rounded-full bg-accent"><x-fas-paw
                                    class="size-4" /></div>
                            <div>
                                <p class="text-sm font-bold">{{ $userTask->user->name }}</p>
                                <p class="text-sm text-muted-foreground">{{ $userTask->user->email }}</p>
                            </div>
                        </div>
                        <div class="border grow p-2 rounded-md">
                            <h3 class="text-sm font-bold">{{ __('task.lasted_report') }}:</h3>
                            <p class="text-sm line-clamp-1 ml-4">- {{ $userTask->lastedReport->report_content }}</p>
                            <p class="text-sm line-clamp-1 ml-4">- {{ $userTask->lastedReport->report_at }}</p>
                            <p class="text-sm font-bold">{{ __('task.task_status') }}: <x-ui.badge
                                    variant="{{ $userTask->is_done ? 'default' : 'outline' }}">{{ $userTask->is_done ? __('task.done') : __('task.learning') }}</x-ui.badge>
                            </p>
                        </div>
                        <x-ui.button class="size-10 rounded-full" variant="outline" tag="a"
                            href="{{ route('tasks.reports.user_task', ['task' => $task->id, 'user' => $userTask->user->id]) }}">
                            <x-fas-arrow-right />
                        </x-ui.button>
                    </div>
                </x-ui.card.content>
            </x-ui.card>
        @empty
            <p class="text-sm text-muted-foreground text-center">{{ __('task.reports_empty') }}</p>
        @endforelse
    </div>
    {{ $userTasks->links('components.ui.pagination') }}
</x-layout.admin-panel>
