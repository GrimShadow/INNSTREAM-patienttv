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
        Schema::create('iptv_channels', function (Blueprint $table) {
            $table->id();
            $table->integer('channel_number')->nullable();
            $table->string('channel_name');
            $table->string('channel_logo')->nullable();
            $table->enum('protocol', ['http', 'https', 'rtmp', 'rtsp', 'udp', 'hls', 'dash']);
            $table->text('stream_address');
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->string('head_end_assignment')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iptv_channels');
    }
};
