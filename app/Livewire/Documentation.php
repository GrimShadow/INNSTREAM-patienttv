<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;

class Documentation extends Component
{
    public $currentSection = 'getting-started';
    public $searchQuery = '';
    public $searchResults = [];
    public $showSearchResults = false;

    public $sections = [
        'getting-started' => [
            'title' => 'Getting Started',
            'icon' => 'play-circle',
            'description' => 'Quick start guide and overview',
        ],
        'display-management' => [
            'title' => 'Display Management',
            'icon' => 'computer-desktop',
            'description' => 'Managing Android TV displays',
        ],
        'templates' => [
            'title' => 'Templates',
            'icon' => 'document-text',
            'description' => 'Creating and managing templates',
        ],
        'channels' => [
            'title' => 'Channels',
            'icon' => 'tv',
            'description' => 'Content channels and scheduling',
        ],
        'websocket-api' => [
            'title' => 'WebSocket API',
            'icon' => 'code-bracket',
            'description' => 'API documentation and integration',
        ],
        'troubleshooting' => [
            'title' => 'Troubleshooting',
            'icon' => 'wrench-screwdriver',
            'description' => 'Common issues and solutions',
        ],
    ];

    public function loadContent($section)
    {
        $this->currentSection = $section;
        $this->showSearchResults = false;
        
        // Call JavaScript function to reinitialize TOC
        $this->js('setTimeout(() => { if (window.initializeTOC) window.initializeTOC(); }, 100);');
    }

    public function search()
    {
        if (empty($this->searchQuery)) {
            $this->searchResults = [];
            $this->showSearchResults = false;
            return;
        }

        $this->searchResults = [];
        $query = strtolower($this->searchQuery);

        foreach ($this->sections as $key => $section) {
            $content = $this->getContentForSection($key);
            $contentLower = strtolower($content);
            
            if (str_contains($contentLower, $query)) {
                // Find matching lines
                $lines = explode("\n", $content);
                $matchingLines = [];
                
                foreach ($lines as $lineNumber => $line) {
                    if (str_contains(strtolower($line), $query)) {
                        $matchingLines[] = [
                            'line' => $lineNumber + 1,
                            'content' => trim($line),
                            'highlighted' => $this->highlightSearchTerm($line, $query)
                        ];
                    }
                }
                
                if (!empty($matchingLines)) {
                    $this->searchResults[] = [
                        'section' => $key,
                        'title' => $section['title'],
                        'description' => $section['description'],
                        'matches' => $matchingLines
                    ];
                }
            }
        }
        
        $this->showSearchResults = true;
    }

    public function clearSearch()
    {
        $this->searchQuery = '';
        $this->searchResults = [];
        $this->showSearchResults = false;
    }

    private function getContentForSection($section)
    {
        $filePath = resource_path("docs/{$section}.md");
        if (file_exists($filePath)) {
            return file_get_contents($filePath);
        }
        return '';
    }

    private function highlightSearchTerm($text, $query)
    {
        return preg_replace('/(' . preg_quote($query, '/') . ')/i', '<mark class="bg-yellow-200 px-1 rounded">$1</mark>', $text);
    }

    public function getContent()
    {
        $filePath = resource_path("docs/{$this->currentSection}.md");
        if (file_exists($filePath)) {
            return file_get_contents($filePath);
        }

        return "# Section Not Found\n\nThe requested documentation section could not be found.";
    }

    public function getHeadings()
    {
        $content = $this->getContent();
        $headings = [];
        
        // Extract headings from markdown content
        preg_match_all('/^(#{1,6})\s+(.+)$/m', $content, $matches, PREG_SET_ORDER);
        
        foreach ($matches as $match) {
            $level = strlen($match[1]);
            $text = trim($match[2]);
            $id = strtolower(preg_replace('/[^a-zA-Z0-9\s-]/', '', $text));
            $id = preg_replace('/\s+/', '-', $id);
            
            $headings[] = [
                'level' => $level,
                'text' => $text,
                'id' => $id
            ];
        }
        
        return $headings;
    }

    public function render()
    {
        return view('livewire.documentation', [
            'sections' => $this->sections,
            'currentSection' => $this->currentSection,
            'content' => Str::markdown($this->getContent()),
            'headings' => $this->getHeadings(),
        ])->layout('layouts.documentation');
    }
}
