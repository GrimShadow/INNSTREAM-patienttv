@php
use Illuminate\Support\Facades\Storage;
@endphp

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
                <flux:modal.trigger name="upload-template-modal">
                    <flux:button variant="filled" icon="arrow-up-tray">
                        {{ __('Upload Template') }}
                    </flux:button>
                </flux:modal.trigger>
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
                        @if($template->thumbnail_url)
                            <!-- Custom Thumbnail -->
                            <img src="{{ $template->thumbnail_url }}" 
                                 alt="{{ $template->name }}" 
                                 class="w-full h-full object-cover rounded-lg">
                        @else
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
                        @endif
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

            <div class="flex justify-between items-center mt-6 pt-6 border-t border-neutral-200 dark:border-neutral-700">
                <div>
                    <flux:button variant="danger" icon="trash" onclick="deleteTemplate()" id="delete-template-btn">
                        {{ __('Delete Template') }}
                    </flux:button>
                </div>
                <div class="flex space-x-3">
                    <flux:modal.close>
                        <flux:button variant="subtle">{{ __('Close') }}</flux:button>
                    </flux:modal.close>
                    <flux:button variant="primary">{{ __('Apply to Displays') }}</flux:button>
                </div>
            </div>
        </div>
    </flux:modal>

    <!-- Template Upload Modal -->
    <flux:modal name="upload-template-modal" class="max-w-4xl">
        <div class="p-6">
            <div class="mb-6">
                <flux:heading size="lg">{{ __('Upload Template') }}</flux:heading>
                <flux:subheading>{{ __('Upload a complete SPA template with HTML, CSS, and JavaScript files') }}</flux:subheading>
            </div>

            <form id="template-upload-form" method="POST" action="/templates/upload" enctype="multipart/form-data">
                @csrf
                <!-- Debug: Show CSRF token -->
                <div style="display: none;" id="csrf-debug">
                    CSRF Token: {{ csrf_token() }}
                </div>
                <div class="grid gap-6 md:grid-cols-2">
                    <!-- Template Information -->
                    <div class="space-y-4">
                        <flux:heading size="base">{{ __('Template Information') }}</flux:heading>
                        
                        <div>
                            <flux:field>
                                <flux:label for="upload-name">{{ __('Template Name') }}</flux:label>
                                <flux:input id="upload-name" name="name" placeholder="Enter template name" required />
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label for="upload-description">{{ __('Description') }}</flux:label>
                                <flux:textarea id="upload-description" name="description" placeholder="Describe your template" rows="3"></flux:textarea>
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label for="upload-category">{{ __('Category') }}</flux:label>
                                <flux:select id="upload-category" name="category" required>
                                    <option value="">{{ __('Select Category') }}</option>
                                    <option value="welcome">{{ __('Welcome Screens') }}</option>
                                    <option value="info">{{ __('Hotel Information') }}</option>
                                    <option value="healthcare">{{ __('Healthcare') }}</option>
                                    <option value="dining">{{ __('Dining & Events') }}</option>
                                    <option value="weather">{{ __('Weather & News') }}</option>
                                    <option value="entertainment">{{ __('Entertainment') }}</option>
                                    <option value="spa">{{ __('Spa & Wellness') }}</option>
                                    <option value="general">{{ __('General') }}</option>
                                </flux:select>
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label for="upload-type">{{ __('Template Type') }}</flux:label>
                                <flux:select id="upload-type" name="type" required>
                                    <option value="spa">{{ __('Single Page Application') }}</option>
                                    <option value="component">{{ __('Component') }}</option>
                                    <option value="layout">{{ __('Layout') }}</option>
                                </flux:select>
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label for="upload-thumbnail">{{ __('Template Thumbnail') }}</flux:label>
                                <flux:input type="file" id="upload-thumbnail" name="thumbnail" accept=".png,.jpg,.jpeg,.gif,.svg" />
                                <flux:description>{{ __('Preview image for the template (optional)') }}</flux:description>
                            </flux:field>
                        </div>
                    </div>

                    <!-- File Uploads -->
                    <div class="space-y-4">
                        <flux:heading size="base">{{ __('Template Files') }}</flux:heading>
                        
                        <div>
                            <flux:field>
                                <flux:label for="upload-html">{{ __('HTML File') }} <span class="text-red-500">*</span></flux:label>
                                <flux:input type="file" id="upload-html" name="html_file" accept=".html,.htm" required />
                                <flux:description>{{ __('Main HTML file for your template') }}</flux:description>
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label for="upload-css">{{ __('CSS File') }}</flux:label>
                                <flux:input type="file" id="upload-css" name="css_file" accept=".css" />
                                <flux:description>{{ __('Stylesheet for your template (optional)') }}</flux:description>
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label for="upload-js">{{ __('JavaScript File') }}</flux:label>
                                <flux:input type="file" id="upload-js" name="js_file" accept=".js" />
                                <flux:description>{{ __('JavaScript functionality (optional)') }}</flux:description>
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label for="upload-assets">{{ __('Assets') }}</flux:label>
                                <flux:input type="file" id="upload-assets" name="assets[]" multiple accept=".png,.jpg,.jpeg,.gif,.svg,.ico" />
                                <flux:description>{{ __('Images and other assets (optional)') }}</flux:description>
                            </flux:field>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label for="upload-tags">{{ __('Tags') }}</flux:label>
                                <flux:input id="upload-tags" name="tags" placeholder="healthcare, patient, tv, interactive" />
                                <flux:description>{{ __('Comma-separated tags for categorization') }}</flux:description>
                            </flux:field>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-neutral-200 dark:border-neutral-700">
                    <flux:modal.close>
                        <flux:button variant="subtle">{{ __('Cancel') }}</flux:button>
                    </flux:modal.close>
                    <flux:button type="submit" variant="primary" id="upload-submit-btn">
                        {{ __('Upload Template') }}
                    </flux:button>
                </div>
            </form>
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
                    
                    console.log('🔍 DEBUG: Template object keys:', Object.keys(template));
                    console.log('🔍 DEBUG: Template preview_url:', template.preview_url);
                    
                    // Store template data for actions
                    console.log('Template object:', template);
                    console.log('Template preview_url:', template.preview_url);
                    currentTemplateUrl = template.preview_url;
                    currentTemplateData = template;
                    console.log('Set currentTemplateUrl to:', currentTemplateUrl);
                    
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
                    console.log('About to start setTimeout for iframe loading');
                    setTimeout(() => {
                        console.log('Loading iframe with URL:', template.preview_url);
                        previewContent.innerHTML = `
                            <iframe 
                                src="${template.preview_url}" 
                                class="w-full h-full border-0 rounded-lg"
                                title="${template.name} Preview"
                                style="background: #fff;"
                                sandbox="allow-scripts allow-same-origin allow-forms allow-popups"
                                loading="lazy">
                            </iframe>
                        `;
                        
                        // Add error handling for iframe
                        const iframe = previewContent.querySelector('iframe');
                        iframe.onload = function() {
                            console.log('Iframe loaded successfully');
                        };
                        iframe.onerror = function() {
                            console.error('Iframe failed to load');
                            previewContent.innerHTML = `
                                <div class="h-full w-full flex items-center justify-center text-white">
                                    <div class="text-center">
                                        <div class="text-lg text-red-500">Failed to load template preview</div>
                                        <div class="text-sm text-gray-400 mt-2">Please try again</div>
                                    </div>
                                </div>
                            `;
                        };
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
        
        console.log('🔧 Template preview script loaded - version 2.0');
        
        function openFullScreenPreview() {
            console.log('Fullscreen button clicked, currentTemplateUrl:', currentTemplateUrl);
            if (currentTemplateUrl) {
                console.log('Opening fullscreen preview:', currentTemplateUrl);
                window.open(currentTemplateUrl, '_blank', 'width=1920,height=1080,scrollbars=yes,resizable=yes');
            } else {
                console.error('No template URL available for fullscreen preview');
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

        // Template Upload Form Handler
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('template-upload-form');
            if (!form) return;
            
            form.addEventListener('submit', function(e) {
                console.log('Form submit event triggered');
                e.preventDefault();
                e.stopPropagation();
                console.log('Form submission prevented, starting AJAX upload');
                
                const formData = new FormData(this);
                const submitBtn = document.getElementById('upload-submit-btn');
                const originalText = submitBtn.textContent;
                
                // Show loading state
                submitBtn.disabled = true;
                submitBtn.textContent = 'Uploading...';
                
                // Process tags - send as array
                const tagsInput = formData.get('tags');
                if (tagsInput) {
                    const tags = tagsInput.split(',').map(tag => tag.trim()).filter(tag => tag);
                    // Remove the old tags field and add each tag as a separate field
                    formData.delete('tags');
                    tags.forEach((tag, index) => {
                        formData.append(`tags[${index}]`, tag);
                    });
                }
                
                // Get CSRF token from meta tag or form
                let csrfToken = document.querySelector('meta[name="csrf-token"]');
                let tokenValue = null;
                
                if (csrfToken) {
                    tokenValue = csrfToken.getAttribute('content');
                    console.log('CSRF token from meta tag:', tokenValue);
                } else {
                    // Fallback: get from form input
                    const formToken = document.querySelector('input[name="_token"]');
                    if (formToken) {
                        tokenValue = formToken.value;
                        console.log('CSRF token from form input:', tokenValue);
                    }
                }
                
                console.log('CSRF token element:', csrfToken);
                console.log('CSRF token value:', tokenValue);
                
                if (!tokenValue) {
                    alert('CSRF token not found. Please refresh the page and try again.');
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                    return;
                }
                
                // Add CSRF token to FormData (required for multipart requests)
                formData.append('_token', tokenValue);
                
                console.log('Making fetch request to /templates/upload');
                fetch('/templates/upload', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': tokenValue
                    }
                })
            .then(response => {
                console.log('Response status:', response.status);
                console.log('Response headers:', response.headers);
                
                // Always get the response text first to see what we're getting
                return response.text().then(text => {
                    console.log('Response text:', text.substring(0, 500));
                    
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status} - ${text.substring(0, 200)}`);
                    }
                    
                    // Try to parse as JSON
                    try {
                        return JSON.parse(text);
                    } catch (e) {
                        console.error('JSON parse error:', e);
                        console.log('Full response text:', text);
                        throw new Error('Response is not valid JSON: ' + text.substring(0, 200));
                    }
                });
            })
            .then(data => {
                if (data.success) {
                    alert('Template uploaded successfully!');
                    // Close modal
                    document.querySelector('[data-flux-modal-close]').click();
                    // Reset form
                    document.getElementById('template-upload-form').reset();
                    // Reload page to show new template
                    window.location.reload();
                } else {
                    alert('Upload failed: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Upload error:', error);
                alert('Upload failed: ' + error.message);
            })
            .finally(() => {
                // Reset button state
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            });
            
            return false; // Prevent default form submission
            });
        });
        
        // Global variable to store current template ID
        let currentTemplateId = null;
        
        // Update openTemplateModal to store the template ID
        function openTemplateModal(templateId) {
            currentTemplateId = templateId;
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
                    console.log('🔍 DEBUG: Template object keys:', Object.keys(template));
                    console.log('🔍 DEBUG: Template preview_url:', template.preview_url);
                    currentTemplateUrl = template.preview_url;
                    currentTemplateData = template;
                    console.log('Set currentTemplateUrl to:', currentTemplateUrl);
                    
                    // Update modal content with template data
                    document.getElementById('modal-title').textContent = template.name;
                    document.getElementById('modal-subtitle').textContent = template.description || 'Template details and preview';
                    
                    // Update template features
                    const featuresContainer = document.getElementById('template-features');
                    featuresContainer.innerHTML = '';
                    data.features.forEach(feature => {
                        const featureDiv = document.createElement('div');
                        featureDiv.className = 'flex items-center space-x-2 text-sm text-neutral-600 dark:text-neutral-300';
                        featureDiv.innerHTML = `
                            <svg class="h-4 w-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span>${feature}</span>
                        `;
                        featuresContainer.appendChild(featureDiv);
                    });
                    
                    // Load template preview
                    const previewContainer = document.getElementById('template-preview-content');
                    previewContainer.innerHTML = `
                        <div class="h-full w-full flex items-center justify-center text-white">
                            <div class="text-center">
                                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-white mx-auto mb-4"></div>
                                <div class="text-lg">Loading template preview...</div>
                            </div>
                        </div>
                    `;
                    
                    // Load the iframe after a brief delay to show loading state
                    console.log('About to start setTimeout for iframe loading');
                    setTimeout(() => {
                        console.log('Loading iframe with URL:', template.preview_url);
                        previewContainer.innerHTML = `
                            <iframe 
                                src="${template.preview_url}" 
                                class="w-full h-full border-0 rounded-lg"
                                title="${template.name} Preview"
                                style="background: #fff;"
                                sandbox="allow-scripts allow-same-origin allow-forms allow-popups"
                                loading="lazy">
                            </iframe>
                        `;
                        
                        // Add error handling for iframe
                        const iframe = previewContainer.querySelector('iframe');
                        iframe.onload = function() {
                            console.log('Iframe loaded successfully');
                        };
                        iframe.onerror = function() {
                            console.error('Iframe failed to load');
                            previewContainer.innerHTML = `
                                <div class="h-full w-full flex items-center justify-center text-white">
                                    <div class="text-center">
                                        <div class="text-lg text-red-500">Failed to load template preview</div>
                                        <div class="text-sm text-gray-400 mt-2">Please try again</div>
                                    </div>
                                </div>
                            `;
                        };
                    }, 500);
                    
                    // Show the modal
                    document.getElementById('template-modal-trigger').click();
                })
                .catch(error => {
                    console.error('Error loading template:', error);
                    alert('Error loading template: ' + error.message);
                });
        }
        
        // Delete template function
        function deleteTemplate() {
            if (!currentTemplateId) {
                alert('No template selected');
                return;
            }
            
            if (!confirm('Are you sure you want to delete this template? This action cannot be undone and will remove all associated files.')) {
                return;
            }
            
            // Show loading state
            const deleteBtn = document.getElementById('delete-template-btn');
            const originalText = deleteBtn.textContent;
            deleteBtn.disabled = true;
            deleteBtn.textContent = 'Deleting...';
            
            fetch(`/templates/${currentTemplateId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    alert('Template deleted successfully!');
                    // Close modal
                    document.querySelector('[data-flux-modal-close]').click();
                    // Reload page to remove deleted template
                    window.location.reload();
                } else {
                    alert('Delete failed: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Delete error:', error);
                alert('Delete failed: ' + error.message);
            })
            .finally(() => {
                // Reset button state
                deleteBtn.disabled = false;
                deleteBtn.textContent = originalText;
            });
        }
    </script>
</x-layouts.app>


