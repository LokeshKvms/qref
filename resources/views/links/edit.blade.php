@php
    $allTags = \App\Models\Tag::all();
@endphp

<x-app-layout>
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">

    <div class="max-w-md mx-auto py-10">
        <div
            class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-md px-10 pb-10 pt-4 shadow-sm">
            <form method="POST" action="{{ route('links.update', $link) }}" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Title --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Title</label>
                    <input type="text" name="title" value="{{ old('title', $link->title) }}"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded text-sm focus:outline-none focus:ring focus:border-blue-400"
                        required>
                    @error('title')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- URL --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">URL</label>
                    <input type="url" name="url" value="{{ old('url', $link->url) }}"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded text-sm focus:outline-none focus:ring focus:border-blue-400"
                        required>
                    @error('url')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Optional Image URL --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Optional Image
                        URL</label>
                    <input type="url" name="image_url" value="{{ old('image_url', $link->image_url) }}"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded text-sm focus:outline-none focus:ring focus:border-blue-400">
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Leave blank to use site favicon</p>
                    @error('image_url')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tags --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tags</label>
                    <select id="tags" name="tags[]" multiple placeholder="Select or add tags...">
                        @foreach ($allTags as $tag)
                            <option value="{{ $tag->id }}"
                                {{ collect(old('tags', $link->tags->pluck('id')->toArray()))->contains($tag->id) ? 'selected' : '' }}>
                                {{ $tag->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Submit --}}
                <div>
                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition">
                        Update Link
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
    <script>
        new TomSelect("#tags", {
            persist: false,
            createOnBlur: true,
            create: true,
            plugins: ['remove_button'],
            maxItems: null,
        });
    </script>
</x-app-layout>
