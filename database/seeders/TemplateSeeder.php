<?php

namespace Database\Seeders;

use App\Models\Template;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first() ?? User::factory()->create();

        $templates = [
            [
                'name' => 'Welcome Screen',
                'description' => 'Guest greeting and room information display',
                'category' => 'welcome',
                'type' => 'spa',
                'tags' => ['welcome', 'guest', 'room', 'hotel'],
                'compatibility' => ['tv', 'tablet'],
                'status' => 'published',
                'usage_count' => 156,
                'rating' => 4.8,
                'rating_count' => 45,
            ],
            [
                'name' => 'Hotel Information',
                'description' => 'Services, amenities, and local information',
                'category' => 'info',
                'type' => 'spa',
                'tags' => ['info', 'services', 'amenities', 'hotel'],
                'compatibility' => ['tv', 'tablet'],
                'status' => 'published',
                'usage_count' => 89,
                'rating' => 4.6,
                'rating_count' => 32,
            ],
            [
                'name' => 'Dining & Events',
                'description' => 'Restaurant menus and daily events',
                'category' => 'dining',
                'type' => 'spa',
                'tags' => ['dining', 'events', 'restaurant', 'menu'],
                'compatibility' => ['tv', 'tablet'],
                'status' => 'published',
                'usage_count' => 42,
                'rating' => 4.9,
                'rating_count' => 18,
            ],
            [
                'name' => 'Weather Display',
                'description' => 'Local weather and forecast information',
                'category' => 'weather',
                'type' => 'spa',
                'tags' => ['weather', 'forecast', 'local'],
                'compatibility' => ['tv', 'tablet'],
                'status' => 'published',
                'usage_count' => 78,
                'rating' => 4.7,
                'rating_count' => 28,
            ],
            [
                'name' => 'Entertainment Hub',
                'description' => 'Streaming services and media guide',
                'category' => 'entertainment',
                'type' => 'spa',
                'tags' => ['entertainment', 'streaming', 'media'],
                'compatibility' => ['tv', 'tablet'],
                'status' => 'published',
                'usage_count' => 134,
                'rating' => 4.5,
                'rating_count' => 52,
            ],
            [
                'name' => 'Minimalist Welcome',
                'description' => 'Clean and simple welcome design',
                'category' => 'welcome',
                'type' => 'spa',
                'tags' => ['minimalist', 'clean', 'simple'],
                'compatibility' => ['tv', 'tablet'],
                'status' => 'published',
                'usage_count' => 67,
                'rating' => 4.4,
                'rating_count' => 23,
            ],
        ];

        foreach ($templates as $templateData) {
            $template = Template::create([
                ...$templateData,
                'created_by' => $user->id,
                'html_file_path' => 'templates/' . Str::slug($templateData['name']) . '.html',
                'configuration' => [
                    'theme' => 'default',
                    'auto_refresh' => true,
                    'refresh_interval' => 300,
                ],
                'components' => [
                    [
                        'type' => 'header',
                        'content' => $templateData['name'],
                        'order' => 1,
                    ],
                ],
                'styles' => [
                    [
                        'type' => 'internal',
                        'content' => 'body { font-family: Arial, sans-serif; }',
                        'order' => 1,
                    ],
                ],
                'scripts' => [
                    [
                        'type' => 'internal',
                        'content' => 'console.log("Template loaded");',
                        'order' => 1,
                    ],
                ],
            ]);

            // Create a placeholder HTML file
            $this->createPlaceholderHtml($template);
        }
    }

    /**
     * Create a placeholder HTML file for the template.
     */
    private function createPlaceholderHtml(Template $template): void
    {
        $html = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>' . $template->name . '</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            text-align: center;
            max-width: 600px;
        }
        h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        p {
            font-size: 1.2rem;
            opacity: 0.9;
        }
        .template-info {
            margin-top: 2rem;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>' . $template->name . '</h1>
        <p>' . $template->description . '</p>
        <div class="template-info">
            <p><strong>Category:</strong> ' . $template->category_display_name . '</p>
            <p><strong>Type:</strong> ' . ucfirst($template->type) . '</p>
            <p><strong>Status:</strong> ' . ucfirst($template->status) . '</p>
        </div>
    </div>
    <script>
        console.log("Template: ' . $template->name . ' loaded successfully");
    </script>
</body>
</html>';

        // Save the HTML content
        $template->saveHtmlContent($html);
    }
} 