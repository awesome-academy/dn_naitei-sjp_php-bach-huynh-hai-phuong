<form action="{{ isset($id) ? route('courses.update', $id) : route('courses.store') }}" method="POST"
    enctype="multipart/form-data" class="space-y-4">
    @if (isset($id))
        @method('PUT')
    @endif
    @csrf
    <div class="grid grid-cols-2 gap-2">
        <div class="space-y-4">
            <div class="space-y-2">
                <x-ui.label for="title">{{ __('course.title') }}</x-ui.label>
                <x-ui.input type="text" name="title" id="title" required value="{{ old('title') ?? $title ?? '' }}" />
                @error('title')
                    <p class="text-sm text-destructive line-clamp-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="space-y-2">
                <x-ui.label for="description">{{ __('course.description') }}</x-ui.label>
                <x-ui.textarea name="description" id="description" required
                    value="{{ old('description') ?? $description ?? '' }}"></x-ui.textarea>
                @error('description')
                    <p class="text-sm text-destructive line-clamp-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div x-data="{ imagePreview: '{{ $featuredImage ? asset('storage/' . $featuredImage) : '' }}' }"
            class="space-y-2">
            <x-ui.label for="featured_image">{{ __('course.featured_image') }}</x-ui.label>
            <input x-ref="imageInput" type="file" name="featured_image" id="featured_image" accept="image/*" hidden @if (!isset($id)) required @endif @change="
                            const file = $event.target.files[0];
                            if (file) {
                                const reader = new FileReader();
                                reader.onload = e => imagePreview = e.target.result;
                                reader.readAsDataURL(file);
                            }
                        " />
            <div @click="$refs.imageInput.click()"
                class="aspect-video rounded-xl overflow-hidden relative cursor-pointer flex items-center justify-center">
                <img x-show="imagePreview" :src="imagePreview" alt="Image Preview"
                    class="w-full h-full object-cover object-top" />
                <x-fas-paw x-show="! imagePreview" class="size-16 text-muted-foreground" />
                <div class="absolute inset-0 bg-popover-foreground opacity-0 hover:opacity-30 transition-opacity"></div>
            </div>
            @error('featured_image')
                <p class="text-sm text-destructive line-clamp-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    @if (isset($id))
        <x-ui.button type="submit" class="w-full">{{ __('course.update_course') }} <x-fas-edit /></x-ui.button>
    @else
        <x-ui.button type="submit" class="w-full">{{ __('course.create_course') }} <x-fas-plus /></x-ui.button>
    @endif
</form>
