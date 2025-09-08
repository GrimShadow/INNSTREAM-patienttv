<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('category')->default('general'); // welcome, info, events, weather, etc.
            $table->string('thumbnail_path')->nullable(); // Path to preview image
            $table->string('html_file_path'); // Path to the HTML file
            $table->json('configuration')->nullable(); // Template configuration/settings
            $table->json('components')->nullable(); // Component structure and data
            $table->json('styles')->nullable(); // CSS styles and theming
            $table->json('scripts')->nullable(); // JavaScript functionality
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->enum('type', ['spa', 'component', 'layout'])->default('spa');
            $table->string('version')->default('1.0.0');
            $table->json('tags')->nullable(); // Array of tags for categorization
            $table->json('compatibility')->nullable(); // Compatible display types
            $table->integer('usage_count')->default(0); // How many times used
            $table->decimal('rating', 3, 2)->nullable(); // Average rating
            $table->integer('rating_count')->default(0); // Number of ratings
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            
            $table->index(['category', 'status']);
            $table->index(['type', 'status']);
            // Note: JSON columns like 'tags' cannot have regular indexes in MySQL
            // Use JSON path indexes or generated columns if needed for searching
        });

        Schema::create('template_deployments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_id')->constrained()->onDelete('cascade');
            $table->string('display_id'); // Reference to display/channel
            $table->enum('status', ['pending', 'deploying', 'active', 'failed', 'removed'])->default('pending');
            $table->timestamp('deployed_at')->nullable();
            $table->timestamp('scheduled_at')->nullable();
            $table->json('deployment_config')->nullable(); // Custom configuration for this deployment
            $table->text('error_message')->nullable();
            $table->foreignId('deployed_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            
            $table->index(['display_id', 'status']);
            $table->index('scheduled_at');
        });

        Schema::create('template_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_id')->constrained()->onDelete('cascade');
            $table->string('version');
            $table->string('html_file_path');
            $table->json('configuration')->nullable();
            $table->json('components')->nullable();
            $table->json('styles')->nullable();
            $table->json('scripts')->nullable();
            $table->text('changelog')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['template_id', 'version']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('template_versions');
        Schema::dropIfExists('template_deployments');
        Schema::dropIfExists('templates');
    }
}; 