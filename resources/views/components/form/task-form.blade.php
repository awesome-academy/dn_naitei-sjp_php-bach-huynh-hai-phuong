<form
    action="{{ isset($id) ? route('tasks.update', $id) : route('courses.tasks.store', ['course' => $course->id, 'subject' => $subject->id]) }}"
    method="POST" enctype="multipart/form-data" class="space-y-4">

    @if (isset($id))
        @method('PUT')
    @endif

    @csrf

    <div class="space-y-4">
        <div class="space-y-2">
            <x-ui.label for="title">{{ __('task.title') }}</x-ui.label>
            <x-ui.input type="text" name="title" id="title" required
                value="{{ old('title') ?? ($title ?? '') }}" />
            @error('title')
                <p class="text-sm text-destructive line-clamp-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="space-y-2">
            <x-ui.label for="description">{{ __('task.description') }}</x-ui.label>
            <x-ui.textarea name="description" id="description" required
                value="{{ old('description') ?? ($description ?? '') }}"></x-ui.textarea>
            @error('description')
                <p class="text-sm text-destructive line-clamp-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    @if (isset($id))
        <x-ui.button type="submit" class="w-full">{{ __('task.update_task') }} <x-fas-edit /></x-ui.button>
    @else
        <x-ui.button type="submit" class="w-full">{{ __('task.create_task') }} <x-fas-plus /></x-ui.button>
    @endif
</form>
