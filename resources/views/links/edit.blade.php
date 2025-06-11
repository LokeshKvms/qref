<x-app-layout>
    <div class="max-w-md mx-auto py-10">
        <form method="POST" action="{{ route('links.update', $link) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" name="title" value="{{ old('title', $link->title) }}"
                       class="mt-1 block w-full border border-gray-300 rounded px-3 py-2" required>
                @error('title')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">URL</label>
                <input type="url" name="url" value="{{ old('url', $link->url) }}"
                       class="mt-1 block w-full border border-gray-300 rounded px-3 py-2" required>
                @error('url')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Optional Image URL</label>
                <input type="url" name="image_url" value="{{ old('image_url', $link->image_url) }}"
                       class="mt-1 block w-full border border-gray-300 rounded px-3 py-2">
                <p class="text-sm text-gray-500">Leave blank to use site favicon</p>
                @error('image_url')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Update Link
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
