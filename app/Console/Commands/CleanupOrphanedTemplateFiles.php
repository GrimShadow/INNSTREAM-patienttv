<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\Template;

class CleanupOrphanedTemplateFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'templates:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up orphaned template files that are no longer referenced in the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting cleanup of orphaned template files...');
        
        // Get all template IDs from database
        $existingTemplateIds = Template::pluck('id')->toArray();
        $this->info('Found ' . count($existingTemplateIds) . ' templates in database: ' . implode(', ', $existingTemplateIds));
        
        // Get all template directories in storage
        $templateDirs = Storage::disk('local')->directories('templates');
        $this->info('Found ' . count($templateDirs) . ' template directories in storage');
        
        $deletedCount = 0;
        
        foreach ($templateDirs as $dir) {
            // Extract template ID from directory path (e.g., "templates/4" -> "4")
            $templateId = basename($dir);
            
            // Skip if it's not a numeric ID (like "infocomm")
            if (!is_numeric($templateId)) {
                $this->warn("Skipping non-numeric directory: {$dir}");
                continue;
            }
            
            // Check if template exists in database
            if (!in_array($templateId, $existingTemplateIds)) {
                $this->warn("Template ID {$templateId} not found in database, deleting directory: {$dir}");
                
                // Delete the entire directory
                if (Storage::disk('local')->deleteDirectory($dir)) {
                    $this->info("✓ Deleted directory: {$dir}");
                    $deletedCount++;
                } else {
                    $this->error("✗ Failed to delete directory: {$dir}");
                }
            } else {
                $this->info("Template ID {$templateId} exists in database, keeping directory: {$dir}");
            }
        }
        
        // Also clean up public storage
        $publicTemplateDirs = Storage::disk('public')->directories('templates');
        $this->info('Found ' . count($publicTemplateDirs) . ' template directories in public storage');
        
        foreach ($publicTemplateDirs as $dir) {
            $templateId = basename($dir);
            
            if (!is_numeric($templateId)) {
                continue;
            }
            
            if (!in_array($templateId, $existingTemplateIds)) {
                $this->warn("Template ID {$templateId} not found in database, deleting public directory: {$dir}");
                
                if (Storage::disk('public')->deleteDirectory($dir)) {
                    $this->info("✓ Deleted public directory: {$dir}");
                    $deletedCount++;
                } else {
                    $this->error("✗ Failed to delete public directory: {$dir}");
                }
            }
        }
        
        $this->info("Cleanup completed! Deleted {$deletedCount} orphaned template directories.");
        
        return Command::SUCCESS;
    }
}