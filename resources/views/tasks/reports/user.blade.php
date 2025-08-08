@use(App\Models\Enums\ReportType)

<x-layout.admin-panel title="{{ __('task.reports') }}: {{ $task->title }}">
    <div class="flex justify-between mb-2">
        <x-ui.button tag="a" href="{{ url()->previous() }}" variant="link">
            <x-fas-arrow-left />
            {{ __('task.back') }}
        </x-ui.button>
        @if (!$task->is_done)
            <x-ui.alert-dialog title="{{ __('alert.confirm') }}" description="{{ __('task.mark_as_done_warning') }}">
                <x-slot:trigger>
                    <x-ui.button variant="ghost" @click="modalOpen = true">
                        {{ __('task.mark_as_done') }} <x-fas-check />
                    </x-ui.button>
                </x-slot:trigger>
                <x-slot:actions>
                    <x-ui.button @click="modalOpen = false">{{ __('alert.cancel') }}</x-ui.button>
                    <form action="{{ route('tasks.reports.done', ['task' => $task->id, 'user' => $user->id]) }}"
                        method="POST">
                        @csrf
                        <x-ui.button variant="destructive" @click="modalOpen = false"
                            type="submit">{{ __('alert.continue') }}</x-ui.button>
                    </form>
                </x-slot:actions>
            </x-ui.alert-dialog>
        @endif
    </div>

    <div class="grid grid-cols-2 gap-4">
        <x-ui.card>
            <x-ui.card.header>
                <x-ui.card.title>
                    {{ __('task.user') }}
                </x-ui.card.title>
            </x-ui.card.header>
            <x-ui.card.content>
                <p class="text-sm line-clamp-1"><span class="font-bold">{{ __('task.name') }}:
                    </span>{{ $user->name }}</p>
                <p class="text-sm line-clamp-1"><span class="font-bold">{{ __('task.email') }}:
                    </span>{{ $user->email }}</p>
            </x-ui.card.content>
        </x-ui.card>
        <x-ui.card>
            <x-ui.card.header>
                <x-ui.card.title>
                    {{ __('task.task') }}
                </x-ui.card.title>
            </x-ui.card.header>
            <x-ui.card.content>
                <p class="text-sm line-clamp-1"><span class="font-bold">{{ __('task.title') }}:
                    </span>{{ $task->title }}</p>
                <p class="text-sm line-clamp-1"><span class="font-bold">{{ __('task.status') }}: </span><x-ui.badge
                        variant="{{ $task->is_done ? 'default' : 'outline' }}">{{ $task->is_done ? __('task.done') : __('task.learning') }}</x-ui.badge>
                </p>
            </x-ui.card.content>
        </x-ui.card>
    </div>
    @if (!$task->is_done)
        <x-ui.card class="mt-4">
            <x-ui.card.header>
                <x-ui.card.title>
                    {{ __('task.comment') }}
                </x-ui.card.title>
            </x-ui.card.header>
            <x-ui.card.content>
                <form class="space-y-4"
                    action="{{ route('tasks.reports.comment', ['task' => $task->id, 'user' => $user->id]) }}"
                    method="POST">
                    @csrf
                    <div class="space-y-2">
                        <x-ui.label for="report_content">{{ __('task.report_content') }}</x-ui.label>
                        <x-ui.textarea name="report_content" id="report_content" required
                            value="{{ old('report_content') }}"></x-ui.textarea>
                        @error('report_content')
                            <p class="text-sm text-destructive line-clamp-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div type="submit" class="flex justify-end">
                        <x-ui.button>{{ __('task.report_submit') }}</x-ui.button>
                    </div>
                </form>
            </x-ui.card.content>
        </x-ui.card>
    @endif
    <section>
        <div
            class="after:border-border relative text-center text-base after:absolute after:inset-0 after:top-1/2 after:z-0 after:flex after:items-center after:border-t my-2">
            <span class="bg-zinc-50 dark:bg-zinc-900 text-muted-foreground relative z-10 px-2">
                {{ __('task.reports') }}
            </span>
        </div>
        <div class="grid gap-2 mb-4">
            @forelse ($reports as $report)
                <x-ui.card>
                    <x-ui.card.content>
                        @if ($report->report_type == ReportType::REPORT)
                            <div class="flex items-start gap-4">
                                <div class="size-10 rounded-full bg-accent flex items-center justify-center">
                                    <x-fas-paw class="size-6" />
                                </div>
                                <div class="space-x-1">
                                    <div class="space-x-3">
                                        <span class="font-bold text-sm">{{ $report->sender->name }}</span>
                                        <span
                                            class="text-muted-foreground text-sm">{{ $report->report_at->diffForHumans() }}</span>
                                        <x-ui.badge variant="outline">{{ __('task.report') }}</x-ui.badge>
                                    </div>
                                    <p class="text-sm">{{ $report->report_content }}</p>
                                </div>
                            </div>
                        @else
                            <div class="flex items-start justify-end gap-4">
                                <div class="space-x-1">
                                    <div class="space-x-3">
                                        <x-ui.badge variant="default">{{ __('task.comment') }}</x-ui.badge>
                                        <span
                                            class="text-muted-foreground text-sm">{{ $report->report_at->diffForHumans() }}</span>
                                        <span class="font-bold text-sm">{{ $report->sender->name }}</span>
                                    </div>
                                    <p class="text-right text-sm">{{ $report->report_content }}</p>
                                </div>
                                <div class="size-10 rounded-full bg-accent flex items-center justify-center">
                                    <x-fas-user-secret class="size-6" />
                                </div>
                            </div>
                        @endif
                    </x-ui.card.content>
                </x-ui.card>
            @empty
                <p class="text-sm text-muted-foreground text-center">{{ __('task.reports_empty') }}</p>
            @endforelse
        </div>
        {{ $reports->links('components.ui.pagination') }}
    </section>
</x-layout.admin-panel>
