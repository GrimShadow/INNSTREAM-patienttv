<?php

namespace App\Console\Commands;

use App\Models\Template;
use App\Models\User;
use App\Services\TemplateService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class AddTemplateCommand extends Command
{
    protected $signature = 'template:add 
                            {name : Template name}
                            {--description= : Template description}
                            {--category=healthcare : Template category}
                            {--type=spa : Template type (spa, component, layout)}
                            {--tags= : Comma-separated tags}
                            {--html-file= : Path to HTML file}
                            {--html-content= : HTML content as string}';

    protected $description = 'Add a new template to the library';

    public function __construct(
        private TemplateService $templateService
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $name = $this->argument('name');
        $description = $this->option('description') ?: $this->ask('Template description');
        $category = $this->option('category');
        $type = $this->option('type');
        $tags = $this->option('tags') ? explode(',', $this->option('tags')) : [];
        $htmlFile = $this->option('html-file');
        $htmlContent = $this->option('html-content');

        // Get HTML content
        if ($htmlFile) {
            if (!file_exists($htmlFile)) {
                $this->error("HTML file not found: {$htmlFile}");
                return 1;
            }
            $htmlContent = file_get_contents($htmlFile);
        } elseif (!$htmlContent) {
            $this->error('Either --html-file or --html-content must be provided');
            return 1;
        }

        // Get or create a user for the template
        $user = User::first();
        if (!$user) {
            $this->error('No users found in the database. Please create a user first.');
            return 1;
        }

        try {
            // Create template data
            $templateData = [
                'name' => $name,
                'description' => $description,
                'category' => $category,
                'type' => $type,
                'tags' => $tags,
                'compatibility' => ['tv', 'tablet'],
                'status' => 'published',
                'created_by' => $user->id,
            ];

            // Create the template
            $template = $this->templateService->createTemplate($templateData, $htmlContent);

            $this->info("✅ Template '{$name}' created successfully!");
            $this->info("📁 Template ID: {$template->id}");
            $this->info("📂 HTML file: {$template->html_file_path}");
            $this->info("🖼️  Thumbnail: {$template->thumbnail_path}");
            $this->info("🔗 Preview URL: " . route('template.preview', $template));

            return 0;
        } catch (\Exception $e) {
            $this->error("❌ Failed to create template: " . $e->getMessage());
            return 1;
        }
    }
} 