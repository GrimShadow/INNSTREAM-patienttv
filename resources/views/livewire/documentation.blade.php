<div class="h-screen bg-gray-50 flex overflow-hidden">
    <!-- Left Sidebar - Categories (Fixed) -->
    <div class="w-72 bg-white border-r border-gray-200 flex-shrink-0 flex flex-col shadow-sm">
                        <div class="p-6 flex-shrink-0">
                    <div class="mb-6">
                        <h2 class="text-xl font-bold text-gray-900">Documentation</h2>
                        <p class="text-sm text-gray-600 mt-1">Learn how to use INNSTREAM Patient TV</p>
                    </div>
                    
                    <!-- Search Bar -->
                    <div class="mb-6">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input 
                                type="text" 
                                wire:model.live.debounce.300ms="searchQuery"
                                wire:keyup.enter="search"
                                placeholder="Search documentation..."
                                class="block w-full pl-10 pr-10 py-3 border border-gray-200 rounded-lg text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50 focus:bg-white transition-colors"
                            >
                            @if($searchQuery)
                                <button 
                                    wire:click="clearSearch"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600"
                                >
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
        <div class="flex-1 overflow-y-auto px-4 pb-6">
            <nav class="space-y-1">
                @foreach($sections as $key => $section)
                    <button
                        wire:click="loadContent('{{ $key }}')"
                        class="w-full text-left px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 {{ $currentSection === $key ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-500' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}"
                    >
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0">
                                @if($section['icon'] === 'play-circle')
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                @elseif($section['icon'] === 'computer-desktop')
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                @elseif($section['icon'] === 'document-text')
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                @elseif($section['icon'] === 'tv')
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                @elseif($section['icon'] === 'code-bracket')
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                                    </svg>
                                @elseif($section['icon'] === 'wrench-screwdriver')
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655-5.653a2.548 2.548 0 010-3.586l.653-.653a2.548 2.548 0 013.586 0l5.653 4.655M15.12 8.412l3.653-3.653a2.548 2.548 0 000-3.586l-.653-.653a2.548 2.548 0 00-3.586 0L10.412 4.88"></path>
                                    </svg>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold">{{ $section['title'] }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">{{ $section['description'] }}</p>
                            </div>
                        </div>
                    </button>
                @endforeach
            </nav>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0">
        <!-- Header (Fixed) -->
        <div class="bg-white border-b border-gray-200 px-8 py-6 flex-shrink-0">
            <div class="max-w-4xl">
                <h1 class="text-3xl font-bold text-gray-900">
                    {{ $sections[$currentSection]['title'] ?? 'Documentation' }}
                </h1>
                <p class="text-lg text-gray-600 mt-2">
                    {{ $sections[$currentSection]['description'] ?? '' }}
                </p>
            </div>
        </div>

        <!-- Content with Right Sidebar -->
        <div class="flex-1 flex min-h-0">
                                <!-- Main Content (Scrollable) -->
                    <div class="flex-1 px-8 py-8 overflow-y-auto">
                        <div class="max-w-4xl">
                            @if($showSearchResults)
                                <!-- Search Results -->
                                <div class="mb-8">
                                    <div class="flex items-center justify-between mb-6">
                                        <h1 class="text-2xl font-bold text-gray-900">
                                            Search Results for "{{ $searchQuery }}"
                                        </h1>
                                        <button 
                                            wire:click="clearSearch"
                                            class="text-sm text-gray-500 hover:text-gray-700"
                                        >
                                            Clear Search
                                        </button>
                                    </div>
                                    
                                    @if(count($searchResults) > 0)
                                        <div class="space-y-6">
                                            @foreach($searchResults as $result)
                                                <div class="bg-white rounded-lg border border-gray-200 p-6">
                                                    <div class="flex items-center justify-between mb-4">
                                                        <h3 class="text-lg font-semibold text-gray-900">
                                                            {{ $result['title'] }}
                                                        </h3>
                                                        <button 
                                                            wire:click="loadContent('{{ $result['section'] }}')"
                                                            class="text-sm text-blue-600 hover:text-blue-800 font-medium"
                                                        >
                                                            View Section →
                                                        </button>
                                                    </div>
                                                    <p class="text-sm text-gray-600 mb-4">{{ $result['description'] }}</p>
                                                    
                                                    <div class="space-y-2">
                                                        @foreach($result['matches'] as $match)
                                                            <div class="text-sm text-gray-700 bg-gray-50 rounded p-3">
                                                                <span class="text-xs text-gray-500 font-mono">Line {{ $match['line'] }}:</span>
                                                                <div class="mt-1">{!! $match['highlighted'] !!}</div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="text-center py-12">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                            </svg>
                                            <h3 class="mt-2 text-sm font-medium text-gray-900">No results found</h3>
                                            <p class="mt-1 text-sm text-gray-500">Try searching with different keywords.</p>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <!-- Regular Documentation Content -->
                                <div class="prose prose-lg max-w-none" id="documentation-content">
                                    {!! $content !!}
                                </div>
                            @endif
                        </div>
                    </div>

            <!-- Right Sidebar - Table of Contents (Fixed) -->
            @if(count($headings) > 0 && !$showSearchResults)
                <div class="w-72 bg-white border-l border-gray-200 flex-shrink-0 flex flex-col">
                    <div class="p-6 flex-shrink-0">
                        <h3 class="text-sm font-semibold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                            </svg>
                            On this page
                        </h3>
                    </div>
                    <div class="flex-1 overflow-y-auto px-6 pb-6">
                        <div class="pr-4">
                            <ul class="space-y-1" id="toc-nav">
                                @foreach($headings as $heading)
                                    <li>
                                        <a
                                            href="#{{ $heading['id'] }}"
                                            class="block border-l-2 border-transparent pl-4 py-1.5 text-sm text-gray-600 hover:border-blue-500 hover:text-gray-900 hover:bg-blue-50 transition-all duration-200 rounded-r-md toc-link"
                                            data-level="{{ $heading['level'] }}"
                                            data-id="{{ $heading['id'] }}"
                                            style="padding-left: {{ ($heading['level'] - 1) * 16 + 16 }}px;"
                                        >
                                            {{ $heading['text'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <style>
.prose {
    color: rgb(55 65 81);
}

.prose h1,
.prose h2,
.prose h3,
.prose h4,
.prose h5,
.prose h6 {
    color: rgb(17 24 39);
    font-weight: 600;
}

.prose h1 {
    font-size: 2.25rem;
    line-height: 2.5rem;
    margin-bottom: 1rem;
}

.prose h2 {
    font-size: 1.875rem;
    line-height: 2.25rem;
    margin-top: 2rem;
    margin-bottom: 1rem;
    border-bottom: 1px solid rgb(229 231 235);
    padding-bottom: 0.5rem;
}

.prose h3 {
    font-size: 1.5rem;
    line-height: 2rem;
    margin-top: 1.5rem;
    margin-bottom: 0.75rem;
}

.prose p {
    margin-bottom: 1rem;
    line-height: 1.75;
}

.prose ul,
.prose ol {
    margin-bottom: 1rem;
    padding-left: 1.5rem;
}

.prose li {
    margin-bottom: 0.5rem;
}

.prose code {
    background-color: rgb(243 244 246);
    padding: 0.125rem 0.25rem;
    border-radius: 0.25rem;
    font-size: 0.875rem;
    font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
}

.prose pre {
    background-color: rgb(17 24 39);
    color: rgb(243 244 246);
    padding: 1rem;
    border-radius: 0.5rem;
    overflow-x: auto;
    margin-bottom: 1rem;
}

.prose pre code {
    background-color: transparent;
    padding: 0;
    color: inherit;
}

.prose blockquote {
    border-left: 4px solid rgb(59 130 246);
    padding-left: 1rem;
    margin: 1rem 0;
    font-style: italic;
    color: rgb(107 114 128);
}

.prose table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 1rem;
}

.prose th,
.prose td {
    border: 1px solid rgb(229 231 235);
    padding: 0.75rem;
    text-align: left;
}

.prose th {
    background-color: rgb(249 250 251);
    font-weight: 600;
}

/* Dark mode styles */
.dark .prose {
    color: rgb(209 213 219);
}

.dark .prose h1,
.dark .prose h2,
.dark .prose h3,
.dark .prose h4,
.dark .prose h5,
.dark .prose h6 {
    color: rgb(243 244 246);
}

.dark .prose h2 {
    border-bottom-color: rgb(75 85 99);
}

.dark .prose code {
    background-color: rgb(31 41 55);
    color: rgb(209 213 219);
}

.dark .prose pre {
    background-color: rgb(17 24 39);
}

.dark .prose blockquote {
    border-left-color: rgb(59 130 246);
    color: rgb(156 163 175);
}

.dark .prose th {
    background-color: rgb(31 41 55);
}

.dark .prose th,
.dark .prose td {
    border-color: rgb(75 85 99);
}

/* Table of Contents Active State */
.toc-link.active {
    color: rgb(17 24 39) !important; /* text-gray-900 */
    font-weight: 600 !important;
    border-left-color: rgb(59 130 246) !important; /* Blue-500 border */
    background-color: rgb(239 246 255) !important; /* Blue-50 background */
}

/* Smooth scrolling for anchor links */
html {
    scroll-behavior: smooth;
}

/* Add IDs to headings for anchor links */
.prose h1[id],
.prose h2[id],
.prose h3[id],
.prose h4[id],
.prose h5[id],
.prose h6[id] {
    scroll-margin-top: 2rem;
}
    </style>

    <script>
        let scrollHandler = null;

        // Make initializeTOC available globally
        window.initializeTOC = function initializeTOC() {
            // Add IDs to headings in the content
            const content = document.getElementById('documentation-content');
            if (!content) {
                return;
            }

            const headings = content.querySelectorAll('h1, h2, h3, h4, h5, h6');
            
            headings.forEach(heading => {
                if (!heading.id) {
                    const text = heading.textContent.trim();
                    const id = text.toLowerCase()
                        .replace(/[^a-zA-Z0-9\s-]/g, '')
                        .replace(/\s+/g, '-');
                    heading.id = id;
                }
            });

            // Remove existing event listeners by cloning links
            const existingLinks = document.querySelectorAll('.toc-link');
            existingLinks.forEach(link => {
                link.replaceWith(link.cloneNode(true));
            });

            // Smooth scrolling for TOC links
            const tocLinks = document.querySelectorAll('.toc-link');
            
            tocLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href').substring(1);
                    const targetElement = document.getElementById(targetId);
                    if (targetElement) {
                        targetElement.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Scroll tracking for active TOC item
            function updateActiveTOCItem() {
                const headings = document.querySelectorAll('#documentation-content h1, #documentation-content h2, #documentation-content h3, #documentation-content h4, #documentation-content h5, #documentation-content h6');
                const tocLinks = document.querySelectorAll('.toc-link');
                
                // Try multiple possible scroll containers - target the main content area
                let scrollContainer = document.querySelector('.flex-1.px-6.py-8.overflow-y-auto') ||
                                    document.querySelector('.flex-1.overflow-y-auto') ||
                                    document.querySelector('.overflow-y-auto') ||
                                    document.querySelector('[class*="overflow-y-auto"]') ||
                                    document.querySelector('.flex-1') ||
                                    document.querySelector('main') ||
                                    document.body;
                
                if (!scrollContainer || headings.length === 0) {
                    return;
                }
                
                let currentHeading = null;
                const scrollPosition = scrollContainer.scrollTop + 100;

                // Find the current heading based on scroll position
                for (let i = 0; i < headings.length; i++) {
                    const heading = headings[i];
                    const headingRect = heading.getBoundingClientRect();
                    const containerRect = scrollContainer.getBoundingClientRect();
                    const headingTop = headingRect.top - containerRect.top + scrollContainer.scrollTop;
                    
                    if (headingTop <= scrollPosition) {
                        currentHeading = heading;
                    } else {
                        break;
                    }
                }

                // Remove active class from all links
                tocLinks.forEach(link => {
                    link.classList.remove('active');
                });

                // Add active class to current heading link
                if (currentHeading && currentHeading.id) {
                    const activeLink = document.querySelector(`.toc-link[href="#${currentHeading.id}"]`);
                    if (activeLink) {
                        activeLink.classList.add('active');
                    }
                }
            }

            // Remove existing scroll listener
            if (scrollHandler) {
                document.removeEventListener('scroll', scrollHandler);
                window.removeEventListener('scroll', scrollHandler);
            }
            
            // Create new handler with throttling for better performance
            let scrollTimeout;
            scrollHandler = function() {
                if (scrollTimeout) {
                    clearTimeout(scrollTimeout);
                }
                scrollTimeout = setTimeout(updateActiveTOCItem, 10);
            };
            
            // Try multiple scroll containers - target the main content area
            const scrollContainer = document.querySelector('.flex-1.px-6.py-8.overflow-y-auto') ||
                                  document.querySelector('.flex-1.overflow-y-auto') ||
                                  document.querySelector('.overflow-y-auto') || 
                                  document.querySelector('[class*="overflow-y-auto"]') ||
                                  document.querySelector('.flex-1') ||
                                  document.querySelector('main') ||
                                  document.body;
            
            if (scrollContainer) {
                scrollContainer.addEventListener('scroll', scrollHandler);
                
                // Also listen to window scroll as backup
                window.addEventListener('scroll', scrollHandler);
            } else {
                // Fallback to window scroll
                window.addEventListener('scroll', scrollHandler);
            }
            
            // Initial update with a delay to ensure content is loaded
            setTimeout(updateActiveTOCItem, 200);
        }



        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            initializeTOC();
        });

        // Re-initialize when Livewire updates the content (only once)
        let hasInitialized = false;
        document.addEventListener('livewire:updated', function() {
            if (!hasInitialized) {
                setTimeout(initializeTOC, 100);
                hasInitialized = true;
            }
        });
    </script>
</div>