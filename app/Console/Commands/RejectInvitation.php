<?php

namespace App\Console\Commands;

use App\Models\Trainer;
use Illuminate\Console\Command;

class RejectInvitation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invitations:reject';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this command to change the state of trainer invite after one day no response';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $pendingInvitations = Trainer::where('status', 'pending')
            ->where('created_at', '<=', now()->day(1)) // Check if the invitation was created more than 10 seconds
            ->get();

        foreach ($pendingInvitations as $invitation) {
            $invitation->status = 'no response';
            $invitation->save();
        }

        $this->info('Rejected invitations: ' . $pendingInvitations->count());
    }
}
