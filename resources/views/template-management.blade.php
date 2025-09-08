<x-layouts.app :title="__('Template Management')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        
        <!-- Navigation -->
        <div class="flex items-center justify-between">

            <flux:navbar scrollable>
                <flux:navbar.item href="{{ route('template-management') }}" :current="request()->routeIs('template-management')">Overview</flux:navbar.item>
                <flux:navbar.item href="{{ route('template-ui') }}">UI</flux:navbar.item>
                <flux:navbar.item href="{{ route('templates') }}">Templates</flux:navbar.item>
            </flux:navbar>

            <div class="flex items-center gap-3">
                <flux:button variant="filled" icon="arrow-path" class="bg-blue-600 hover:bg-blue-700">
                    {{ __('Refresh Status') }}
                </flux:button>
                <flux:modal.trigger name="deploy-template-modal">
                    <flux:button variant="primary" icon="plus">
                        {{ __('Deploy Template') }}
                    </flux:button>
                </flux:modal.trigger>
            </div>
        </div>

        <!-- Template Statistics -->
        <div class="grid auto-rows-min gap-4 md:grid-cols-4">
            <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="flex items-center justify-between">
                    <div>
                        <flux:subheading class="text-neutral-500 dark:text-neutral-400">{{ __('Active Templates') }}</flux:subheading>
                        <flux:heading size="lg" class="mt-1 text-blue-600 dark:text-blue-400">{{ $activeTemplates }}</flux:heading>
                    </div>
                    <div class="h-2 w-2 rounded-full bg-blue-500"></div>
                </div>
            </div>
            <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="flex items-center justify-between">
                    <div>
                        <flux:subheading class="text-neutral-500 dark:text-neutral-400">{{ __('Deployed Displays') }}</flux:subheading>
                        <flux:heading size="lg" class="mt-1 text-green-600 dark:text-green-400">{{ $deployedDisplays }}</flux:heading>
                    </div>
                    <div class="h-2 w-2 rounded-full bg-green-500"></div>
                </div>
            </div>
            <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="flex items-center justify-between">
                    <div>
                        <flux:subheading class="text-neutral-500 dark:text-neutral-400">{{ __('Updates Pending') }}</flux:subheading>
                        <flux:heading size="lg" class="mt-1 text-orange-600 dark:text-orange-400">{{ $pendingUpdates }}</flux:heading>
                    </div>
                    <div class="h-2 w-2 rounded-full bg-orange-500"></div>
                </div>
            </div>
            <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="flex items-center justify-between">
                    <div>
                        <flux:subheading class="text-neutral-500 dark:text-neutral-400">{{ __('Failed Deployments') }}</flux:subheading>
                        <flux:heading size="lg" class="mt-1 text-red-600 dark:text-red-400">{{ $failedDeployments }}</flux:heading>
                    </div>
                    <div class="h-2 w-2 rounded-full bg-red-500"></div>
                </div>
            </div>
        </div>

        <!-- Filters and Search -->
        <div class="flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <flux:input placeholder="Search templates..." class="w-64" icon="magnifying-glass" />
                <select class="w-40 rounded-lg border border-neutral-200 bg-white px-3 py-2 text-sm dark:border-neutral-700 dark:bg-neutral-900 dark:text-white">
                    <option value="all">{{ __('All Templates') }}</option>
                    <option value="welcome">{{ __('Welcome') }}</option>
                    <option value="info">{{ __('Hotel Info') }}</option>
                    <option value="events">{{ __('Events') }}</option>
                    <option value="weather">{{ __('Weather') }}</option>
                </select>
                <select class="w-40 rounded-lg border border-neutral-200 bg-white px-3 py-2 text-sm dark:border-neutral-700 dark:bg-neutral-900 dark:text-white">
                    <option value="all">{{ __('All Status') }}</option>
                    <option value="active">{{ __('Active') }}</option>
                    <option value="updating">{{ __('Updating') }}</option>
                    <option value="failed">{{ __('Failed') }}</option>
                </select>
            </div>
        </div>

        <!-- Active Templates Table -->
        <div class="relative overflow-hidden rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-900">
            <div class="flex items-center justify-between border-b border-neutral-200 p-6 dark:border-neutral-700">
                <div>
                    <flux:heading size="base">{{ __('Active Template Deployments') }}</flux:heading>
                    <flux:subheading>{{ __('Templates currently deployed to hotel displays') }}</flux:subheading>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="border-b border-neutral-200 bg-neutral-50 dark:border-neutral-700 dark:bg-neutral-800">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider dark:text-neutral-400">
                                {{ __('Template') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider dark:text-neutral-400">
                                {{ __('Assigned Rooms') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider dark:text-neutral-400">
                                {{ __('Status') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider dark:text-neutral-400">
                                {{ __('Last Updated') }}
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-neutral-500 uppercase tracking-wider dark:text-neutral-400">
                                {{ __('Actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                        @forelse($deployments as $deployment)
                        <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900/20">
                                        <svg class="h-5 w-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <flux:text class="text-sm font-medium">{{ $deployment->template->name }}</flux:text>
                                        <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">{{ $deployment->template->description ?: 'No description' }}</flux:text>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-wrap gap-1 max-w-xs">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-neutral-100 text-neutral-800 dark:bg-neutral-700 dark:text-neutral-200">
                                        Display {{ $deployment->display_id }}
                                    </span>
                                </div>
                                <flux:text class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">1 display</flux:text>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-2">
                                    <div class="h-2 w-2 rounded-full bg-green-500"></div>
                                    <flux:text class="text-sm text-green-600 dark:text-green-400">{{ ucfirst($deployment->status) }}</flux:text>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <flux:text class="text-sm">{{ $deployment->deployed_at ? $deployment->deployed_at->diffForHumans() : 'Never' }}</flux:text>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <flux:button variant="subtle" size="sm" icon="eye" onclick="window.open('{{ route('template.preview', $deployment->template->id) }}', '_blank')">
                                        {{ __('Preview') }}
                                    </flux:button>
                                    <flux:button variant="subtle" size="sm" icon="cog-6-tooth">
                                        {{ __('Manage') }}
                                    </flux:button>
                                    <flux:button variant="subtle" size="sm" icon="trash" class="text-red-600 hover:text-red-700" onclick="removeTemplateFromDisplay({{ $deployment->id }}, '{{ $deployment->template->name }}', '{{ $deployment->display_id }}')">
                                        {{ __('Remove') }}
                                    </flux:button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="text-neutral-500 dark:text-neutral-400">
                                    <svg class="mx-auto h-12 w-12 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-neutral-900 dark:text-neutral-100">No active deployments</h3>
                                    <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">Get started by deploying a template to your displays.</p>
                                    <div class="mt-4">
                                        <flux:modal.trigger name="deploy-template-modal">
                                            <flux:button variant="primary">
                                                {{ __('Deploy Template') }}
                                            </flux:button>
                                        </flux:modal.trigger>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="grid gap-6 lg:grid-cols-2">
            <!-- Recent Template Updates -->
            <div class="rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-900">
                <div class="border-b border-neutral-200 p-6 dark:border-neutral-700">
                    <flux:heading size="base">{{ __('Recent Activity') }}</flux:heading>
                    <flux:subheading>{{ __('Latest template deployment activity') }}</flux:subheading>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @forelse($recentActivity as $activity)
                        <div class="flex items-center space-x-3">
                            @if($activity->status === 'active')
                                <div class="flex-shrink-0 h-2 w-2 rounded-full bg-green-500"></div>
                            @elseif($activity->status === 'failed')
                                <div class="flex-shrink-0 h-2 w-2 rounded-full bg-red-500"></div>
                            @else
                                <div class="flex-shrink-0 h-2 w-2 rounded-full bg-neutral-400"></div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <flux:text class="text-sm font-medium">Template {{ ucfirst($activity->status) }}</flux:text>
                                <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">{{ $activity->template->name }} • Display {{ $activity->display_id }}</flux:text>
                            </div>
                            <flux:text class="text-xs text-neutral-500 dark:text-neutral-400">{{ $activity->created_at->diffForHumans() }}</flux:text>
                        </div>
                        @empty
                        <div class="text-center py-4">
                            <flux:text class="text-sm text-neutral-500 dark:text-neutral-400">No recent activity</flux:text>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Template Performance -->
            <div class="rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-900">
                <div class="border-b border-neutral-200 p-6 dark:border-neutral-700">
                    <flux:heading size="base">{{ __('Template Performance') }}</flux:heading>
                    <flux:subheading>{{ __('Most popular and effective templates') }}</flux:subheading>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @forelse($templatePerformance as $item)
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <flux:text class="text-sm font-medium">{{ $item->name }}</flux:text>
                                <div class="flex items-center mt-1">
                                    <div class="flex-1 bg-neutral-200 rounded-full h-2 dark:bg-neutral-700">
                                        @php
                                            $maxDeployments = $templatePerformance->max('deployments_count');
                                            $percentage = $maxDeployments > 0 ? ($item->deployments_count / $maxDeployments) * 100 : 0;
                                        @endphp
                                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                    </div>
                                    <flux:text class="text-xs text-neutral-500 dark:text-neutral-400 ml-2">{{ $item->deployments_count }}</flux:text>
                                </div>
                            </div>
                            <div class="ml-4 text-right">
                                <flux:text class="text-sm font-medium">{{ number_format($percentage, 0) }}%</flux:text>
                                <svg class="w-4 h-4 text-neutral-400 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h8"/>
                                </svg>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4">
                            <flux:text class="text-sm text-neutral-500 dark:text-neutral-400">No template performance data</flux:text>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Deploy Template Modal -->
    <flux:modal name="deploy-template-modal" class="max-w-4xl">
        <div class="p-6">
            <div class="mb-6">
                <flux:heading size="lg">{{ __('Deploy Template') }}</flux:heading>
                <flux:subheading>{{ __('Select a template and displays to deploy to') }}</flux:subheading>
            </div>

            <form id="deployForm" method="POST" action="{{ route('templates.deploy') }}">
                @csrf
                <div class="space-y-6">
                    <!-- Template Selection -->
                    <div>
                        <flux:field>
                            <flux:label for="template_id">{{ __('Select Template') }}</flux:label>
                            <flux:select id="template_id" name="template_id" required>
                                <option value="">{{ __('Choose a template...') }}</option>
                                @foreach(\App\Models\Template::where('status', 'published')->get() as $template)
                                    <option value="{{ $template->id }}">{{ $template->name }}</option>
                                @endforeach
                            </flux:select>
                            <flux:description>{{ __('Choose which template to deploy') }}</flux:description>
                        </flux:field>
                    </div>

                    <!-- Display Selection -->
                    <div>
                        <flux:field>
                            <flux:label>{{ __('Select Displays') }}</flux:label>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <flux:button type="button" variant="subtle" size="sm" onclick="selectAllDisplays()">
                                        {{ __('Select All') }}
                                    </flux:button>
                                    <flux:button type="button" variant="subtle" size="sm" onclick="deselectAllDisplays()">
                                        {{ __('Deselect All') }}
                                    </flux:button>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 max-h-64 overflow-y-auto border border-neutral-200 rounded-lg p-4 dark:border-neutral-700">
                                    @foreach(\App\Models\Display::where('online', true)->get() as $display)
                                        <label class="flex items-center space-x-3 p-2 rounded-lg hover:bg-neutral-50 dark:hover:bg-neutral-800 cursor-pointer">
                                            <input type="checkbox" name="display_ids[]" value="{{ $display->id }}" class="display-checkbox rounded border-neutral-300 text-blue-600 focus:ring-blue-500">
                                            <div class="flex-1 min-w-0">
                                                <div class="text-sm font-medium text-neutral-900 dark:text-neutral-100">{{ $display->name ?: 'Display ' . $display->id }}</div>
                                                <div class="text-xs text-neutral-500 dark:text-neutral-400">
                                                    {{ $display->location ?: 'Unknown Location' }}
                                                    @if($display->room)
                                                        • Room {{ $display->room }}
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <div class="h-2 w-2 rounded-full bg-green-500"></div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            <flux:description>{{ __('Select which displays to deploy the template to') }}</flux:description>
                        </flux:field>
                    </div>

                    <!-- Deployment Configuration -->
                    <div>
                        <flux:field>
                            <flux:label for="deployment_config">{{ __('Deployment Configuration') }}</flux:label>
                            <flux:textarea id="deployment_config" name="deployment_config" rows="3" placeholder='{"auto_refresh": true, "refresh_interval": 300}'></flux:textarea>
                            <flux:description>{{ __('Optional JSON configuration for this deployment') }}</flux:description>
                        </flux:field>
                    </div>

                    <!-- Schedule Deployment -->
                    <div>
                        <flux:field>
                            <flux:label for="scheduled_at">{{ __('Schedule Deployment') }}</flux:label>
                            <flux:input type="datetime-local" id="scheduled_at" name="scheduled_at" />
                            <flux:description>{{ __('Leave empty to deploy immediately') }}</flux:description>
                        </flux:field>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-neutral-200 dark:border-neutral-700">
                    <flux:modal.close>
                        <flux:button variant="subtle">
                            {{ __('Cancel') }}
                        </flux:button>
                    </flux:modal.close>
                    <flux:button type="submit" variant="primary" id="deployButton">
                        {{ __('Deploy Template') }}
                    </flux:button>
                </div>
            </form>
        </div>
    </flux:modal>

    <script>

        function selectAllDisplays() {
            document.querySelectorAll('.display-checkbox').forEach(checkbox => {
                checkbox.checked = true;
            });
        }

        function deselectAllDisplays() {
            document.querySelectorAll('.display-checkbox').forEach(checkbox => {
                checkbox.checked = false;
            });
        }

        function removeTemplateFromDisplay(deploymentId, templateName, displayId) {
            if (confirm(`Are you sure you want to remove the template "${templateName}" from Display ${displayId}?\n\nThis will clear the template from the display and mark the deployment as removed.`)) {
                // Show loading state
                const removeButton = event.target.closest('button');
                const originalContent = removeButton.innerHTML;
                removeButton.innerHTML = '<span class="animate-spin">⟳</span> Removing...';
                removeButton.disabled = true;

                fetch(`/templates/deployments/${deploymentId}/remove`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Template removed successfully!');
                        // Refresh the page to show updated deployments
                        window.location.reload();
                    } else {
                        alert('Failed to remove template: ' + (data.message || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to remove template: ' + error.message);
                })
                .finally(() => {
                    removeButton.innerHTML = originalContent;
                    removeButton.disabled = false;
                });
            }
        }

        // Handle form submission
        document.getElementById('deployForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const selectedDisplays = Array.from(document.querySelectorAll('.display-checkbox:checked')).map(cb => cb.value);
            
            if (selectedDisplays.length === 0) {
                alert('Please select at least one display to deploy to.');
                return;
            }

            // Add display IDs to form data
            formData.delete('display_ids[]');
            selectedDisplays.forEach(id => {
                formData.append('display_ids[]', id);
            });

            // Show loading state
            const deployButton = document.getElementById('deployButton');
            const originalText = deployButton.textContent;
            deployButton.textContent = 'Deploying...';
            deployButton.disabled = true;

            fetch('{{ route("templates.deploy") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Template deployed successfully!');
                    // Refresh the page to show updated deployments (this will close the modal)
                    window.location.reload();
                } else {
                    alert('Deployment failed: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Deployment failed: ' + error.message);
            })
            .finally(() => {
                deployButton.textContent = originalText;
                deployButton.disabled = false;
            });
        });
    </script>
</x-layouts.app>
