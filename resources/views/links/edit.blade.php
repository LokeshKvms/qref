<x-app-layout>
    <div class="max-w-md mx-auto py-10">
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-md px-10 pb-10 pt-4 shadow-sm">
            <form method="POST" action="{{ route('links.update', $link) }}" class="space-y-4">
                @csrf
                @method('PUT')

                {{-- Title --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Title</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <!-- Pencil Icon -->
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5h6m2 0a2 2 0 012 2v2m-2-4l-9.293 9.293a1 1 0 01-.707.293H6a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707L14 5z" />
                            </svg>
                        </span>
                        <input type="text" name="title" value="{{ old('title', $link->title) }}"
                            class="w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded text-sm focus:outline-none focus:ring focus:border-blue-400"
                            required>
                    </div>
                    @error('title')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- URL --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">URL</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <!-- Link Icon -->
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.828 10.172a4 4 0 015.656 5.656l-2.828 2.828a4 4 0 01-5.656-5.656m-4.242-4.242a4 4 0 015.656 0m-5.656 5.656a4 4 0 010-5.656l2.828-2.828a4 4 0 015.656 0" />
                            </svg>
                        </span>
                        <input type="url" name="url" value="{{ old('url', $link->url) }}"
                            class="w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded text-sm focus:outline-none focus:ring focus:border-blue-400"
                            required>
                    </div>
                    @error('url')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Image URL --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Optional Image
                        URL</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <!-- Image Icon -->
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5zm16 0L10 14l-4-4-3 3v5h16V5z" />
                            </svg>
                        </span>
                        <input type="url" placeholder="Optional Link" name="image_url" value="{{ old('image_url', $link->image_url) }}"
                            class="w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded text-sm focus:outline-none focus:ring focus:border-blue-400">
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Leave blank to use site favicon</p>
                    @error('image_url')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit --}}
                <div>
                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded focus:outline-none transition">
                        Update Link
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
