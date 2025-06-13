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
            <h1 id="clearFiltersBtn"
                class="text-3xl font-bold text-gray-800 flex items-center justify-center space-x-2 transition-transform duration-300 hover:scale-105 cursor-pointer group">

                <svg class="h-8 w-8 text-blue-600 transition-transform duration-500 group-hover:rotate-[360deg]"
                    fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round"
                    stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
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
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6" id="linksContainer">
            @foreach ($links as $link)
                <div class="link-card bg-white rounded-lg shadow-md hover:shadow-lg transition duration-300 p-5 flex items-start space-x-4"
                    data-tags="{{ implode(',', $link->tags->pluck('id')->toArray()) }}">

                    {{-- Left: image_url or favicon --}}
                    <img src="{{ $link->image_url ?: 'https://www.google.com/s2/favicons?sz=64&domain=' . parse_url($link->url, PHP_URL_HOST) }}"
                        onerror="this.onerror=null;this.src='/images/default-favicon.png';" alt="link image"
                        class="w-12 h-12 rounded-md flex-shrink-0 object-contain" />

                    {{-- Right: content + actions --}}
                    <div class="flex flex-col flex-1 min-w-0">
                        <div class="flex justify-between items-start">
                            {{-- Title --}}
                            <a href="{{ $link->url }}" target="_blank"
                                class="text-lg font-semibold text-gray-900 hover:text-blue-600 truncate">
                                {{ Str::title($link->title) }}
                            </a>

                            {{-- Tags --}}
                            <div class="flex flex-wrap justify-end gap-1 ml-3">
                                @foreach ($link->tags as $tag)
                                    <button type="button"
                                        class="tag-badge bg-gray-200 text-gray-700 hover:bg-blue-200 hover:text-blue-700 text-xs px-2 py-0.5 rounded"
                                        data-tag-id="{{ $tag->id }}">
                                        {{ $tag->name }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        {{-- URL --}}
                        <a href="{{ $link->url }}" target="_blank"
                            class="text-sm text-gray-500 mt-1 truncate break-words" title="{{ $link->url }}">
                            {{ \Illuminate\Support\Str::limit($link->url, 40) }}
                        </a>

                        {{-- Badges and actions --}}
                        <div class="mt-3 flex space-x-3 items-center">
                            <button data-url="{{ $link->url }}"
                                class="copy-btn flex items-center justify-center w-20 h-8 text-gray-500 hover:text-gray-700 bg-gray-100 hover:bg-gray-200 transition rounded-md text-xs"
                                title="Copy Link">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <rect x="9" y="9" width="13" height="13" rx="2" ry="2" />
                                    <path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1" />
                                </svg>
                                Copy
                            </button>

                            <a href="{{ route('links.edit', $link) }}"
                                class="flex items-center justify-center w-20 h-8 text-blue-600 hover:text-blue-800 transition bg-blue-100 hover:bg-blue-200 rounded-md text-xs font-medium">
                                Edit
                            </a>

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
        <footer class="mt-16 text-center text-sm text-gray-800 border-t pt-6">
            Built with ❤️ by K V M S LOKESH
        </footer>

        {{-- <div x-data="{ showText: true, lastY: window.scrollY }" x-init="window.addEventListener('scroll', () => {
            showText = window.scrollY < lastY || window.scrollY < 100;
            lastY = window.scrollY;
        });" class="fixed bottom-6 right-6 z-50">
            <a href="{{ route('links.create') }}"
                class="flex items-center bg-blue-600 text-white rounded-full shadow-lg hover:bg-blue-700 transition-all duration-300 overflow-hidden whitespace-nowrap"
                :class="showText ? 'px-4 py-4' : 'px-3 py-3'">

                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>

                <span class="ml-2 text-sm font-medium inline-flex items-center overflow-hidden whitespace-nowrap"
                    x-bind:style="showText
                        ?
                        'opacity: 1; width: 80px; padding-left: 0.5rem; padding-right: 0.5rem; transition: width 300ms ease, opacity 300ms ease, padding 300ms ease;' :
                        'opacity: 0; width: 0; padding-left: 0; padding-right: 0; transition: width 300ms ease, opacity 300ms ease, padding 300ms ease;'"
                    aria-hidden="true">
                    Add Link
                </span>


            </a>
        </div> --}}
    </div>

    <script>
        const toast = document.createElement('div');
        toast.style.position = 'absolute';
        toast.style.top = '0';
        toast.style.left = '0';
        toast.style.transform = 'none';
        toast.style.backgroundColor = 'rgba(0,0,0,0.7)';
        toast.style.color = 'white';
        toast.style.padding = '8px 12px';
        toast.style.borderRadius = '5px';
        toast.style.fontSize = '14px';
        toast.style.zIndex = '1000';
        toast.style.opacity = '0';
        toast.style.transition = 'opacity 0.3s ease-in-out';
        document.body.appendChild(toast);

        function showToast(message, nearElement) {
            toast.textContent = message;

            if (nearElement) {
                const rect = nearElement.getBoundingClientRect();
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                const scrollLeft = window.pageXOffset || document.documentElement.scrollLeft;

                toast.style.top = (rect.bottom + scrollTop + 10) + 'px';
                toast.style.left = (rect.left + scrollLeft + rect.width / 2) + 'px';
            }

            toast.style.opacity = '1';

            setTimeout(() => {
                toast.style.opacity = '0';
            }, 2000);
        }

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

        let activeTagId = null; // Track currently selected tag filter
        const searchInput = document.getElementById('searchInput');
        const cards = document.querySelectorAll('.link-card');
        const totalCountSpan = document.querySelector('.text-right span.font-semibold');
        const noResultsMessage = document.getElementById('noResultsMessage');

        function filterCards() {
            const query = searchInput.value.toLowerCase().trim();

            let visibleCount = 0;
            cards.forEach(card => {
                const tags = card.dataset.tags.split(',');
                const tagMatch = !activeTagId || tags.includes(activeTagId);

                if (tagMatch) {
                    const title = card.querySelector('a.text-lg')?.textContent.toLowerCase() || '';
                    const url = card.querySelector('a.text-sm')?.textContent.toLowerCase() || '';

                    if (title.includes(query) || url.includes(query)) {
                        card.style.display = '';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                } else {
                    card.style.display = 'none';
                }
            });

            totalCountSpan.textContent = visibleCount;
            if (visibleCount === 0) {
                noResultsMessage.classList.remove('hidden');
            } else {
                noResultsMessage.classList.add('hidden');
            }
        }

        searchInput.addEventListener('input', filterCards);

        document.querySelectorAll('.tag-badge').forEach(badge => {
            badge.addEventListener('click', () => {
                const clickedTagId = badge.dataset.tagId;

                // Toggle active tag filter on/off
                if (activeTagId === clickedTagId) {
                    activeTagId = null;
                } else {
                    activeTagId = clickedTagId;
                }

                filterCards();
            });
        });

        document.getElementById('clearFiltersBtn').addEventListener('click', () => {
            activeTagId = null;
            searchInput.value = '';

            cards.forEach(card => {
                card.style.display = '';
            });

            totalCountSpan.textContent = cards.length;
            noResultsMessage.classList.add('hidden');
        });
    </script>


</x-app-layout>
