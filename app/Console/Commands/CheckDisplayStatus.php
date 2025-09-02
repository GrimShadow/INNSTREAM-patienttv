<?php

namespace App\Console\Commands;

use App\Models\Display;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckDisplayStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'displays:check-status {--timeout=60 : Timeout in seconds for marking displays as offline}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check display status and mark offline displays that haven\'t sent heartbeat';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $timeoutSeconds = (int) $this->option('timeout');
        $timeoutMinutes = $timeoutSeconds / 60;

        $this->info("Checking display status (timeout: {$timeoutSeconds}s / {$timeoutMinutes}m)...");

        // Find displays that are marked as online but haven't sent a heartbeat recently
        $offlineThreshold = now()->subSeconds($timeoutSeconds);

        $offlineDisplays = Display::where('online', true)
            ->where('last_seen_at', '<', $offlineThreshold)
            ->get();

        if ($offlineDisplays->isEmpty()) {
            $this->info('All displays are online.');

            return 0;
        }

        $this->warn("Found {$offlineDisplays->count()} display(s) that appear to be offline:");

        foreach ($offlineDisplays as $display) {
            $lastSeen = $display->last_seen_at->diffForHumans();

            $this->line("  - Display ID {$display->id} ({$display->name}) - Last seen: {$lastSeen}");

            // Mark display as offline
            $display->update([
                'online' => false,
                'status' => 'offline',
                'last_message' => "Display marked offline - no heartbeat for {$timeoutSeconds}s",
            ]);

            // Broadcast the disconnection event
            broadcast(new \App\Events\DisplayDisconnected($display));

            Log::info('Display marked as offline due to timeout', [
                'display_id' => $display->id,
                'name' => $display->name,
                'last_seen_at' => $display->last_seen_at,
                'timeout_seconds' => $timeoutSeconds,
            ]);
        }

        $this->info("Marked {$offlineDisplays->count()} display(s) as offline.");

        return 0;
    }
}
