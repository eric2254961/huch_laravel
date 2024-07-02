<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use League\Csv\Reader;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Notifications\UserImported;

class ImportUsers extends Command
{
    protected $signature = 'import:users';
    protected $description = 'Import users from a CSV file';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Starting to import users from CSV...');

        $csvPath = storage_path('app/users.csv');

        if (!file_exists($csvPath)) {
            $this->error('CSV file not found!');
            return;
        }

        $csv = Reader::createFromPath($csvPath, 'r');
        $csv->setHeaderOffset(0);

        $records = $csv->getRecords();

        foreach ($records as $record) {
            // Check if required fields exist in each record
            if (!isset($record['first_name'], $record['last_name'], $record['dob'], $record['email'], $record['password'])) {
                $this->error('CSV record missing required fields.');
                continue;
            }

            $password = $record['password'];

            $user = User::create([
                'first_name' => $record['first_name'],
                'last_name' => $record['last_name'],
                'dob' => $record['dob'],
                'email' => $record['email'],
                'password' => Hash::make($password),
            ]);

            $user->notify(new UserImported($password));
        }

        $this->info('Users import complete.');
    }
}
