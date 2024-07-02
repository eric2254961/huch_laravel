<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class PurgeUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:purge-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Purge all records from the users table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to purge users from the database...');

        // Purge all records from the users table
        User::truncate();

        $this->info('Users table purged successfully.');

        return Command::SUCCESS;
    }
}
