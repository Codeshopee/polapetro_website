<?php

namespace App\Console\Commands;

use App\Models\ContactMessage;
use Illuminate\Console\Command;
use Carbon\Carbon;

class CleanupOldContacts extends Command
{
    protected $signature = 'contacts:cleanup {--days=365}';
    protected $description = 'Clean up old contact messages older than specified days';

    public function handle()
    {
        $days = $this->option('days');
        $cutoffDate = Carbon::now()->subDays($days);

        $deletedCount = ContactMessage::where('created_at', '<', $cutoffDate)->delete();

        $this->info("Deleted {$deletedCount} contact messages older than {$days} days.");

        return Command::SUCCESS;
    }
}
