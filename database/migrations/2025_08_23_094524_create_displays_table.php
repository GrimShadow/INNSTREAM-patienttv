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
        Schema::create('displays', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('make')->nullable();
            $table->string('model')->nullable();
            $table->boolean('online')->default(false);
            $table->string('ip_address')->nullable();
            $table->string('mac_address')->nullable();
            $table->string('app_version')->nullable();
            $table->string('os')->nullable();
            $table->string('version')->nullable();
            $table->string('firmware_version')->nullable();
            $table->text('last_message')->nullable();
            $table->foreignId('template_id')->nullable()->constrained()->onDelete('set null');
            $table->string('location')->nullable();
            $table->string('floor')->nullable();
            $table->string('room')->nullable();
            $table->enum('status', ['online', 'offline', 'powered_off', 'maintenance'])->default('offline');
            $table->timestamp('last_seen_at')->nullable();
            $table->text('configuration')->nullable();
            $table->text('capabilities')->nullable();
            $table->timestamps();

            // Add indexes for better performance
            $table->index(['template_id']);
            $table->index(['status', 'online']);
            $table->index(['last_seen_at']);
            $table->index(['floor', 'location']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('displays');
    }
};
