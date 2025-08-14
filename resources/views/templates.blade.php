<x-layouts.app :title="__('Templates')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <!-- Navigation Tabs -->
        <flux:navbar scrollable>
            <flux:navbar.item href="{{ route('template-management') }}" :current="request()->routeIs('template-management')">Overview</flux:navbar.item>
            <flux:navbar.item href="{{ route('template-ui') }}">UI</flux:navbar.item>
            <flux:navbar.item href="{{ route('templates') }}">Templates</flux:navbar.item>
        </flux:navbar>

        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <div>
                <flux:heading size="xl" level="1">{{ __('Template Gallery') }}</flux:heading>
                <flux:subheading class="mt-1">{{ __('Browse and preview hotel TV display templates') }}</flux:subheading>
            </div>
            <div class="flex items-center gap-3">
                <flux:button variant="filled" icon="funnel">
                    {{ __('Filter') }}
                </flux:button>
                <flux:button variant="primary" icon="plus">
                    {{ __('Create Template') }}
                </flux:button>
            </div>
        </div>

        <!-- Search and Categories -->
        <div class="flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <flux:input placeholder="Search templates..." class="w-64" icon="magnifying-glass" />
                <select class="rounded-lg border border-neutral-200 bg-white px-3 py-2 text-sm dark:border-neutral-700 dark:bg-neutral-900 dark:text-white">
                    <option value="all">{{ __('All Categories') }}</option>
                    <option value="welcome">{{ __('Welcome Screens') }}</option>
                    <option value="info">{{ __('Hotel Information') }}</option>
                    <option value="dining">{{ __('Dining & Events') }}</option>
                    <option value="weather">{{ __('Weather & News') }}</option>
                    <option value="entertainment">{{ __('Entertainment') }}</option>
                </select>
            </div>
            <div class="flex items-center gap-2">
                <flux:text class="text-sm text-neutral-500 dark:text-neutral-400">{{ $templates->total() }} {{ __('templates') }}</flux:text>
            </div>
        </div>

        <!-- Template Grid -->
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @forelse($templates as $template)
            <div class="group cursor-pointer overflow-hidden rounded-xl border border-neutral-200 bg-white transition-all hover:shadow-lg dark:border-neutral-700 dark:bg-neutral-900" 
                 data-template-id="{{ $template->id }}"
                 style="cursor: pointer;">
                                <div class="relative aspect-video overflow-hidden bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-blue-950 dark:to-indigo-900">
                    <!-- Template Preview -->
                    <div class="absolute inset-4 rounded-lg bg-black overflow-hidden">
                        <!-- TV Frame Preview -->
                        <div class="w-full h-full flex items-center justify-center">
                            <div class="relative w-full h-full max-w-sm max-h-48 mx-auto">
                                <!-- TV Frame -->
                                <div class="w-full h-full bg-gray-900 rounded-lg border-2 border-gray-700 shadow-lg overflow-hidden">
                                    <!-- TV Screen -->
                                    <div class="w-full h-full bg-black relative">
                                        <!-- Template Content Preview -->
                                        <div class="w-full h-full transform scale-75 origin-top-left">
                                            @if($template->category === 'healthcare')
                                                <!-- Healthcare Template Preview -->
                                                <div class="w-full h-full bg-gradient-to-br from-blue-900 to-blue-700 p-2">
                                                    <div class="flex items-center justify-between mb-2">
                                                        <div class="text-white text-xs font-semibold">⚕ HealthCare</div>
                                                        <div class="text-white text-xs">22°C</div>
                                                    </div>
                                                    <div class="grid grid-cols-3 gap-1 mb-2">
                                                        <div class="bg-white bg-opacity-20 rounded p-1">
                                                            <div class="text-white text-xs font-semibold">My Wellness</div>
                                                            <div class="text-white text-xs opacity-75">2/3 Completed</div>
                                                        </div>
                                                        <div class="bg-white bg-opacity-20 rounded p-1">
                                                            <div class="text-white text-xs font-semibold">Caring for Me</div>
                                                            <div class="text-white text-xs opacity-75">Dr. Johnson</div>
                                                        </div>
                                                        <div class="bg-white bg-opacity-20 rounded p-1">
                                                            <div class="text-white text-xs font-semibold">Coming Up</div>
                                                            <div class="text-white text-xs opacity-75">6:15 PM</div>
                                                        </div>
                                                    </div>
                                                    <div class="flex justify-center space-x-1">
                                                        <div class="bg-blue-500 text-white text-xs px-2 py-1 rounded">My Care</div>
                                                        <div class="bg-white bg-opacity-20 text-white text-xs px-2 py-1 rounded">My Stay</div>
                                                    </div>
                                                </div>
                                            @elseif($template->category === 'welcome')
                                                <!-- Welcome Template Preview -->
                                                <div class="w-full h-full bg-gradient-to-br from-green-900 to-green-700 p-2">
                                                    <div class="text-center text-white">
                                                        <div class="text-lg mb-1">🏨</div>
                                                        <div class="text-xs font-semibold">Welcome to Grand Hotel</div>
                                                        <div class="text-xs opacity-75">Your comfort is our priority</div>
                                                    </div>
                                                </div>
                                            @elseif($template->category === 'dining')
                                                <!-- Dining Template Preview -->
                                                <div class="w-full h-full bg-gradient-to-br from-red-900 to-red-700 p-2">
                                                    <div class="text-center text-white">
                                                        <div class="text-lg mb-1">🍽️</div>
                                                        <div class="text-xs font-semibold">Dining & Events</div>
                                                        <div class="text-xs opacity-75">Restaurant Guide</div>
                                                    </div>
                                                </div>
                                            @else
                                                <!-- Generic Template Preview -->
                                                <div class="w-full h-full bg-gradient-to-br from-gray-900 to-gray-700 p-2">
                                                    <div class="text-center text-white">
                                                        <div class="text-lg mb-1">📺</div>
                                                        <div class="text-xs font-semibold">{{ $template->name }}</div>
                                                        <div class="text-xs opacity-75">{{ $template->category_display_name }}</div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Hover Overlay -->
                    <div class="absolute inset-0 bg-black/20 opacity-0 transition-opacity group-hover:opacity-100"></div>
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 transition-opacity group-hover:opacity-100">
                        <flux:button variant="primary" size="sm" icon="eye">
                            {{ __('Preview') }}
                        </flux:button>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <flux:heading size="base">{{ $template->name }}</flux:heading>
                            <flux:text class="text-sm text-neutral-500 dark:text-neutral-400">{{ $template->description }}</flux:text>
                        </div>
                        <div class="flex items-center space-x-2">
                            @if($template->usage_count > 100)
                                <span class="rounded-full bg-green-100 px-2 py-1 text-xs text-green-800 dark:bg-green-900 dark:text-green-200">{{ __('Popular') }}</span>
                            @elseif($template->rating > 4.5)
                                <span class="rounded-full bg-blue-100 px-2 py-1 text-xs text-blue-800 dark:bg-blue-900 dark:text-blue-200">{{ __('Highly Rated') }}</span>
                            @else
                                <span class="rounded-full bg-gray-100 px-2 py-1 text-xs text-gray-800 dark:bg-gray-900 dark:text-gray-200">{{ __('New') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mt-3 flex items-center justify-between">
                        <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">{{ __('Used in') }} {{ $template->usage_count }} {{ __('displays') }}</flux:text>
                        <div class="flex items-center space-x-1">
                            @if($template->rating)
                                <svg class="h-4 w-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <flux:text class="text-xs">{{ number_format($template->rating, 1) }}</flux:text>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <svg class="mx-auto h-12 w-12 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <flux:heading size="lg" class="mt-4">{{ __('No templates found') }}</flux:heading>
                <flux:text class="mt-2 text-neutral-500 dark:text-neutral-400">{{ __('Try adjusting your search or filter criteria') }}</flux:text>
            </div>
            @endforelse


        </div>

        <!-- Load More Button -->
        <div class="flex justify-center">
            <flux:button variant="filled" class="px-8">
                {{ __('Load More Templates') }}
            </flux:button>
        </div>
    </div>

    <!-- Hidden Modal Trigger -->
    <flux:modal.trigger name="template-preview" id="template-modal-trigger" style="display: none;">
        <button></button>
    </flux:modal.trigger>

    <!-- Template Preview Modal -->
    <flux:modal name="template-preview" class="max-w-7xl">
        <div class="p-6">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <flux:heading size="lg" id="modal-title">{{ __('Template Preview') }}</flux:heading>
                    <flux:subheading id="modal-subtitle">{{ __('Template details and preview') }}</flux:subheading>
                </div>
                <div class="flex items-center gap-3">
                    <flux:button variant="filled" icon="arrows-pointing-out" onclick="openFullScreenPreview()">
                        {{ __('Full Screen') }}
                    </flux:button>
                    <flux:button variant="filled" icon="pencil-square">
                        {{ __('Customize') }}
                    </flux:button>
                    <flux:button variant="primary" icon="plus" onclick="useTemplate()">
                        {{ __('Use Template') }}
                    </flux:button>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-3">
                <!-- Large Preview Area -->
                <div class="lg:col-span-2">
                    <flux:heading size="base" class="mb-3">{{ __('Template Preview') }}</flux:heading>
                    <div class="aspect-video overflow-hidden rounded-xl border border-neutral-200 bg-black dark:border-neutral-700">
                        <div id="template-preview-content" class="h-full w-full">
                            <!-- Content will be dynamically inserted here -->
                        </div>
                    </div>
                </div>

                <!-- Template Details -->
                <div class="space-y-6">
                    <div>
                        <flux:heading size="base">{{ __('Template Features') }}</flux:heading>
                        <div id="template-features" class="mt-2 space-y-2">
                            <!-- Features will be dynamically inserted here -->
                        </div>
                    </div>

                    <div>
                        <flux:heading size="base">{{ __('Usage Statistics') }}</flux:heading>
                        <div class="mt-2 grid grid-cols-2 gap-4">
                            <div class="rounded-lg border border-neutral-200 p-3 dark:border-neutral-700">
                                <flux:text class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('Active Displays') }}</flux:text>
                                <flux:heading size="lg" id="usage-count">156</flux:heading>
                            </div>
                            <div class="rounded-lg border border-neutral-200 p-3 dark:border-neutral-700">
                                <flux:text class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('User Rating') }}</flux:text>
                                <div class="flex items-center space-x-1">
                                    <flux:heading size="lg" id="rating">4.8</flux:heading>
                                    <svg class="h-4 w-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <flux:heading size="base">{{ __('Compatible Displays') }}</flux:heading>
                        <div class="mt-2 space-y-2 text-sm text-neutral-600 dark:text-neutral-300">
                            <div class="flex items-center space-x-2">
                                <svg class="h-4 w-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span>{{ __('Samsung Smart TVs') }}</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <svg class="h-4 w-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span>{{ __('LG WebOS Displays') }}</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <svg class="h-4 w-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span>{{ __('Sony Professional Displays') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-6 pt-6 border-t border-neutral-200 dark:border-neutral-700">
                <flux:modal.close>
                    <flux:button variant="subtle">{{ __('Close') }}</flux:button>
                </flux:modal.close>
                <flux:button variant="primary">{{ __('Apply to Displays') }}</flux:button>
            </div>
        </div>
    </flux:modal>

    <script>
        // Add event delegation for template card clicks
        document.addEventListener('DOMContentLoaded', function() {
            document.addEventListener('click', function(e) {
                const templateCard = e.target.closest('[data-template-id]');
                if (templateCard) {
                    const templateId = templateCard.getAttribute('data-template-id');
                    openTemplateModal(templateId);
                }
            });
        });
        
        function openTemplateModal(templateId) {
            console.log('Opening template modal for ID:', templateId);
            
            // Fetch template data from the server
            fetch(`/templates/${templateId}/data`)
                .then(response => {
                    console.log('Response status:', response.status);
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Template data received:', data);
                    const template = data.template;
                    const features = data.features;
                    
                    // Store template data for actions
                    currentTemplateUrl = template.preview_url;
                    currentTemplateData = template;
                    
                    // Update modal content
                    document.getElementById('modal-title').textContent = template.name;
                    document.getElementById('modal-subtitle').textContent = template.description;
                    document.getElementById('usage-count').textContent = template.usage_count;
                    document.getElementById('rating').textContent = template.rating || 'N/A';
                    
                    // Update features list
                    const featuresContainer = document.getElementById('template-features');
                    featuresContainer.innerHTML = features.map(feature => 
                        `<div class="flex items-start space-x-2">
                            <svg class="h-4 w-4 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-sm">${feature}</span>
                        </div>`
                    ).join('');
                    
                    // Update preview content with actual template preview
                    const previewContent = document.getElementById('template-preview-content');
                    previewContent.innerHTML = `
                        <div class="h-full w-full flex items-center justify-center text-white">
                            <div class="text-center">
                                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-white mx-auto mb-4"></div>
                                <div class="text-lg">Loading template preview...</div>
                            </div>
                        </div>
                    `;
                    
                    // Load the iframe after a brief delay to show loading state
                    setTimeout(() => {
                        previewContent.innerHTML = `
                            <iframe 
                                src="${template.preview_url}" 
                                class="w-full h-full border-0 rounded-lg"
                                title="${template.name} Preview"
                                style="background: #000;">
                            </iframe>
                        `;
                    }, 500);
                    
                    // Open modal
                    console.log('Opening modal...');
                    document.getElementById('template-modal-trigger').click();
                })
                .catch(error => {
                    console.error('Error fetching template data:', error);
                    alert('Failed to load template details');
                });
        }
        
        // Store current template data for actions
        let currentTemplateUrl = '';
        let currentTemplateData = null;
        
        function openFullScreenPreview() {
            if (currentTemplateUrl) {
                window.open(currentTemplateUrl, '_blank', 'width=1920,height=1080,scrollbars=yes,resizable=yes');
            }
        }
        
        function useTemplate() {
            console.log('Use Template clicked, currentTemplateData:', currentTemplateData);
            if (currentTemplateData) {
                // Store template data in sessionStorage for the UI editor
                sessionStorage.setItem('selectedTemplate', JSON.stringify(currentTemplateData));
                console.log('Template data stored in sessionStorage');
                
                // Also pass template ID as URL parameter as fallback
                const templateId = currentTemplateData.id;
                window.location.href = '{{ route("template-ui") }}?template_id=' + templateId;
            } else {
                alert('Template data not available');
            }
        }
    </script>
</x-layouts.app>

