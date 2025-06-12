<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Links') }}
            </h2>
            <a href="{{ route('links.create') }}"
                class="inline-block bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 transition text-sm">
                + Add New Link
            </a>
        </div>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-12">

        {{-- Page Header --}}
        <div class="mb-10 text-center">
            <h1 class="text-3xl font-bold text-gray-800 flex items-center justify-center space-x-2">
                <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M10 13a5 5 0 007.07 0l2.83-2.83a5 5 0 00-7.07-7.07l-1.41 1.41" />
                    <path d="M14 11a5 5 0 00-7.07 0l-2.83 2.83a5 5 0 007.07 7.07l1.41-1.41" />
                </svg>

                <span>My Saved Links</span>
            </h1>
            <p class="text-gray-600 mt-2">Easily manage and access your favorite resources.</p>
        </div>

        {{-- Search Bar --}}
        <div class="mb-6 flex justify-center">
            <input id="searchInput" type="text" placeholder="Search links..."
                class="w-full sm:w-3/4 md:w-1/2 px-4 py-2 border rounded shadow-sm focus:outline-none focus:ring focus:border-blue-300" />

        </div>

        {{-- Stats --}}
        <div class="mb-6 text-right text-sm text-gray-600">
            Total Links: <span class="font-semibold text-gray-800">{{ $links->count() }}</span>
        </div>
        <div id="noResultsMessage" class="text-center text-gray-500 mt-6 hidden">
            No links found matching your search.
        </div>

        {{-- Links Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach ($links as $link)
                <div
                    class="bg-white rounded-lg shadow-sm hover:shadow-md transition duration-300 p-5 flex items-start space-x-4">

                    {{-- Left: image_url or favicon --}}
                    <img src="{{ $link->image_url ?: 'https://www.google.com/s2/favicons?sz=64&domain=' . parse_url($link->url, PHP_URL_HOST) }}"
                        onerror="this.onerror=null;this.src='/images/default-favicon.png';" alt="link image"
                        class="w-12 h-12 rounded-md flex-shrink-0 object-contain" />

                    {{-- Right: content + actions --}}
                    <div class="flex flex-col flex-1 min-w-0">
                        {{-- Title --}}
                        <a href="{{ $link->url }}" target="_blank"
                            class="text-lg font-semibold text-gray-900 hover:text-blue-600 truncate">
                            {{ $link->title }}
                        </a>

                        {{-- URL --}}
                        <a href="{{ $link->url }}" target="_blank"
                            class="text-sm text-gray-500 mt-1 truncate break-words" title="{{ $link->url }}">
                            {{ \Illuminate\Support\Str::limit($link->url, 30) }}
                        </a>

                        {{-- Badges and actions --}}
                        <div class="mt-3 flex space-x-3 items-center">

                            {{-- Copy --}}
                            <button data-url="{{ $link->url }}"
                                class="copy-btn flex items-center justify-center w-20 h-8 text-gray-500 hover:text-gray-700 bg-gray-100 hover:bg-gray-200 transition rounded-md text-xs"
                                title="Copy Link" aria-label="Copy link URL">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <rect x="9" y="9" width="13" height="13" rx="2" ry="2" />
                                    <path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1" />
                                </svg>
                                Copy
                            </button>

                            {{-- Edit --}}
                            <a href="{{ route('links.edit', $link) }}"
                                class="flex items-center justify-center w-20 h-8 text-blue-600 hover:text-blue-800 transition bg-blue-100 hover:bg-blue-200 rounded-md text-xs font-medium">
                                Edit
                            </a>

                            {{-- Delete --}}
                            <form method="POST" action="{{ route('links.destroy', $link) }}"
                                onsubmit="return confirm('Delete this link?');" class="inline-block w-20">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full h-8 text-red-600 hover:text-red-800 transition bg-red-100 hover:bg-red-200 rounded-md text-xs font-medium">
                                    Delete
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>

        {{-- Footer --}}
        <footer class="mt-16 text-center text-sm text-gray-400 border-t pt-6">
            Built with ❤️ by K V M S LOKESH
        </footer>
    </div>

    <script>
        // Create a small toast container
        const toast = document.createElement('div');
        toast.style.position = 'absolute'; // Changed from fixed to absolute
        toast.style.top = '0';
        toast.style.left = '0';
        toast.style.transform = 'none'; // reset transform, will set dynamically
        toast.style.backgroundColor = 'rgba(0,0,0,0.7)';
        toast.style.color = 'white';
        toast.style.padding = '8px 12px';
        toast.style.borderRadius = '5px';
        toast.style.fontSize = '14px';
        toast.style.zIndex = '1000';
        toast.style.opacity = '0';
        toast.style.transition = 'opacity 0.3s ease-in-out';
        document.body.appendChild(toast);

        // Show toast near the clicked element
        function showToast(message, nearElement) {
            toast.textContent = message;

            if (nearElement) {
                const rect = nearElement.getBoundingClientRect();
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                const scrollLeft = window.pageXOffset || document.documentElement.scrollLeft;

                // Position toast 10px below the button, horizontally centered
                toast.style.top = (rect.bottom + scrollTop + 10) + 'px';
                toast.style.left = (rect.left + scrollLeft + rect.width / 2) + 'px';
                // toast.style.transform = 'translateX(-50%)';
            }

            toast.style.opacity = '1';

            setTimeout(() => {
                toast.style.opacity = '0';
            }, 2000);
        }

        // Search input filtering logic (unchanged)
        document.getElementById('searchInput').addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            const cards = document.querySelectorAll('.grid > div');
            let visibleCount = 0;

            cards.forEach(card => {
                const title = card.querySelector('a.text-lg')?.textContent.toLowerCase() || '';
                const url = card.querySelector('a.text-sm')?.textContent.toLowerCase() || '';

                if (title.includes(query) || url.includes(query)) {
                    card.style.display = '';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            const totalCountSpan = document.querySelector('.text-right span.font-semibold');
            totalCountSpan.textContent = visibleCount;

            const noResultsMessage = document.getElementById('noResultsMessage');
            if (visibleCount === 0) {
                noResultsMessage.classList.remove('hidden');
            } else {
                noResultsMessage.classList.add('hidden');
            }
        });

        // Copy button click event with updated toast position
        document.querySelectorAll('.copy-btn').forEach(button => {
            button.addEventListener('click', () => {
                const url = button.getAttribute('data-url');
                if (!url) return;

                if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText(url)
                        .then(() => {
                            showToast('Link copied to clipboard!', button);
                        })
                        .catch(err => {
                            showToast('Failed to copy link: ' + err, button);
                        });
                } else {
                    // Fallback for older browsers
                    const textarea = document.createElement('textarea');
                    textarea.value = url;
                    document.body.appendChild(textarea);
                    textarea.select();
                    try {
                        const successful = document.execCommand('copy');
                        if (successful) {
                            showToast('Link copied to clipboard!', button);
                        } else {
                            showToast('Failed to copy link.', button);
                        }
                    } catch (err) {
                        showToast('Failed to copy link: ' + err, button);
                    }
                    document.body.removeChild(textarea);
                }
            });
        });
    </script>


</x-app-layout>
