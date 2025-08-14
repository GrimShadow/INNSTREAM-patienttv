<?php

namespace App\Services;

use App\Models\Template;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TemplateService
{
    /**
     * Create a new template from HTML content.
     */
    public function createTemplate(array $data, string $htmlContent): Template
    {
        // Create a temporary path for the HTML file
        $tempPath = 'templates/temp-' . time() . '.html';
        
        $template = Template::create([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'category' => $data['category'] ?? 'general',
            'type' => $data['type'] ?? 'spa',
            'status' => 'published', // Set to published so it shows in the gallery
            'tags' => $data['tags'] ?? [],
            'compatibility' => $data['compatibility'] ?? ['tv', 'tablet', 'mobile'],
            'html_file_path' => $tempPath,
            'created_by' => $data['created_by'] ?? 1,
        ]);

        // Save the HTML content
        $template->saveHtmlContent($htmlContent);

        // Generate thumbnail
        $template->generateThumbnail();

        // Parse and extract components, styles, and scripts
        $this->parseTemplateContent($template, $htmlContent);

        return $template;
    }

    /**
     * Update an existing template.
     */
    public function updateTemplate(Template $template, array $data, ?string $htmlContent = null): Template
    {
        $template->update([
            'name' => $data['name'] ?? $template->name,
            'description' => $data['description'] ?? $template->description,
            'category' => $data['category'] ?? $template->category,
            'tags' => $data['tags'] ?? $template->tags,
            'compatibility' => $data['compatibility'] ?? $template->compatibility,
            'updated_by' => $data['updated_by'] ?? null,
        ]);

        if ($htmlContent) {
            $template->saveHtmlContent($htmlContent);
            $this->parseTemplateContent($template, $htmlContent);
        }

        return $template;
    }

    /**
     * Parse HTML content and extract components, styles, and scripts.
     */
    private function parseTemplateContent(Template $template, string $htmlContent): void
    {
        // Extract CSS styles
        $styles = $this->extractStyles($htmlContent);
        
        // Extract JavaScript
        $scripts = $this->extractScripts($htmlContent);
        
        // Extract components structure
        $components = $this->extractComponents($htmlContent);

        $template->update([
            'styles' => $styles,
            'scripts' => $scripts,
            'components' => $components,
        ]);
    }

    /**
     * Extract CSS styles from HTML content.
     */
    private function extractStyles(string $htmlContent): array
    {
        $styles = [];
        
        // Extract <style> tags
        preg_match_all('/<style[^>]*>(.*?)<\/style>/s', $htmlContent, $matches);
        
        foreach ($matches[1] as $index => $styleContent) {
            $styles[] = [
                'type' => 'internal',
                'content' => trim($styleContent),
                'order' => $index,
            ];
        }

        // Extract external stylesheets
        preg_match_all('/<link[^>]*rel=["\']stylesheet["\'][^>]*href=["\']([^"\']+)["\'][^>]*>/i', $htmlContent, $matches);
        
        foreach ($matches[1] as $index => $href) {
            $styles[] = [
                'type' => 'external',
                'href' => $href,
                'order' => count($styles) + $index,
            ];
        }

        return $styles;
    }

    /**
     * Extract JavaScript from HTML content.
     */
    private function extractScripts(string $htmlContent): array
    {
        $scripts = [];
        
        // Extract <script> tags
        preg_match_all('/<script[^>]*>(.*?)<\/script>/s', $htmlContent, $matches);
        
        foreach ($matches[1] as $index => $scriptContent) {
            if (trim($scriptContent)) {
                $scripts[] = [
                    'type' => 'internal',
                    'content' => trim($scriptContent),
                    'order' => $index,
                ];
            }
        }

        // Extract external scripts
        preg_match_all('/<script[^>]*src=["\']([^"\']+)["\'][^>]*>/i', $htmlContent, $matches);
        
        foreach ($matches[1] as $index => $src) {
            $scripts[] = [
                'type' => 'external',
                'src' => $src,
                'order' => count($scripts) + $index,
            ];
        }

        return $scripts;
    }

    /**
     * Extract component structure from HTML content.
     */
    private function extractComponents(string $htmlContent): array
    {
        $components = [];
        
        // Extract main sections
        preg_match_all('/<div[^>]*class=["\'][^"\']*(?:card|section|widget|component)[^"\']*["\'][^>]*>(.*?)<\/div>/s', $htmlContent, $matches);
        
        foreach ($matches[0] as $index => $componentHtml) {
            $components[] = [
                'type' => 'section',
                'html' => $componentHtml,
                'order' => $index,
            ];
        }

        // Extract navigation elements
        preg_match_all('/<nav[^>]*>(.*?)<\/nav>/s', $htmlContent, $matches);
        
        foreach ($matches[0] as $index => $navHtml) {
            $components[] = [
                'type' => 'navigation',
                'html' => $navHtml,
                'order' => count($components) + $index,
            ];
        }

        // Extract header elements
        preg_match_all('/<header[^>]*>(.*?)<\/header>/s', $htmlContent, $matches);
        
        foreach ($matches[0] as $index => $headerHtml) {
            $components[] = [
                'type' => 'header',
                'html' => $headerHtml,
                'order' => count($components) + $index,
            ];
        }

        return $components;
    }

    /**
     * Generate a preview URL for a template.
     */
    public function generatePreviewUrl(Template $template): string
    {
        return route('template.preview', $template->id);
    }

    /**
     * Deploy a template to multiple displays.
     */
    public function deployTemplate(Template $template, array $displayIds, array $config = []): array
    {
        $deployments = [];
        
        foreach ($displayIds as $displayId) {
            $deployment = $template->deployToDisplay($displayId, $config);
            $deployments[] = $deployment;
        }

        return $deployments;
    }

    /**
     * Create a template from the healthcare example.
     */
    public function createHealthcareTemplate(): Template
    {
        $htmlContent = $this->getHealthcareTemplateHtml();
        
        return $this->createTemplate([
            'name' => 'Healthcare Patient Portal',
            'description' => 'Complete patient care interface with navigation, notifications, and multiple views',
            'category' => 'healthcare',
            'type' => 'spa',
            'tags' => ['healthcare', 'patient', 'portal', 'medical', 'interactive'],
            'compatibility' => ['tv', 'tablet'],
        ], $htmlContent);
    }

    /**
     * Get the healthcare template HTML content.
     */
    private function getHealthcareTemplateHtml(): string
    {
        return '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Healthcare Patient Portal</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background: url("https://images.unsplash.com/photo-1500964757637-c85e8a162699?q=80&w=1503&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D") no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            color: white;
            overflow: hidden;
            position: relative;
        }

        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.4);
            z-index: 1;
        }

        .container {
            height: 100vh;
            display: flex;
            flex-direction: column;
            padding: 20px;
            position: relative;
            z-index: 2;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 30px;
            margin-bottom: 30px;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            margin-left: 0;
            margin-right: 0;
        }

        .logo {
            display: flex;
            align-items: center;
            font-size: 28px;
            font-weight: 300;
        }

        .logo::before {
            content: "⚕";
            font-size: 32px;
            margin-right: 12px;
            color: white;
        }

        .weather-time {
            display: flex;
            align-items: center;
            gap: 20px;
            font-size: 18px;
        }

        .main-content {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 30px;
            flex: 1;
            margin-bottom: 30px;
        }

        .card {
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            display: flex;
            flex-direction: column;
        }

        .card h2 {
            font-size: 24px;
            font-weight: 500;
            margin-bottom: 20px;
        }

        .bottom-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 30px;
        }

        .nav-buttons {
            display: flex;
            gap: 15px;
        }

        .nav-button {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            border-radius: 18px;
            padding: 20px 35px;
            color: white;
            font-size: 18px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-button.active {
            background: #4A90E2;
        }

        .nav-button:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="container">
        <header class="header">
            <div class="logo">HealthCare</div>
            <div class="weather-time">
                <div class="weather">22°C</div>
                <div class="datetime">Tue, 7th March 5:35pm</div>
            </div>
        </header>

        <main class="main-content">
            <div class="card">
                <h2>My Wellness Goals</h2>
                <div class="progress-text">2/3 Completed</div>
                <div class="goal-section">
                    <h3>Today\'s Goal</h3>
                    <div class="goal-text">Walk the length of the hallway</div>
                </div>
            </div>

            <div class="card">
                <h2>Caring for Me</h2>
                <div class="care-team-grid">
                    <div class="care-member primary-doctor">
                        <div class="care-avatar doctor">DR</div>
                        <div class="care-info">
                            <h4>Dr. Audrey Johnson <span class="primary-badge">PRIMARY</span></h4>
                            <div class="role">Attending Physician</div>
                            <div class="specialty">Pediatrics</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <h2>Coming Up Next</h2>
                <div class="events-list">
                    <div class="event-item next">
                        <div class="event-info">
                            <div class="event-title">Physical Therapy</div>
                            <div class="event-label">Rehabilitation Center</div>
                        </div>
                        <div class="event-time">6:15 PM</div>
                    </div>
                </div>
            </div>
        </main>

        <nav class="bottom-nav">
            <div class="nav-buttons">
                <button class="nav-button active">My Care</button>
                <button class="nav-button">My Stay</button>
                <button class="nav-button">Live TV</button>
                <button class="nav-button">Entertainment</button>
            </div>
        </nav>
    </div>

    <script>
        function updateTime() {
            const now = new Date();
            const options = { 
                weekday: "short", 
                day: "numeric", 
                month: "short",
                hour: "numeric",
                minute: "2-digit"
            };
            const timeString = now.toLocaleDateString("en-US", options);
            document.querySelector(".datetime").textContent = timeString;
        }

        updateTime();
        setInterval(updateTime, 60000);
    </script>
</body>
</html>';
    }
} 