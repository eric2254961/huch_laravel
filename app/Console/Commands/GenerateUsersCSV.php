<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Faker\Factory as Faker;
use League\Csv\Writer;
use SplFileObject;

class GenerateUsersCsv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:userscsv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a CSV file with 100,000 users using Faker';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting to generate CSV...');

        $faker = Faker::create();
        $csv = Writer::createFromFileObject(new SplFileObject(storage_path('app/users.csv'), 'w+'));

        // Define the headers
        $headers = ['id', 'first_name', 'last_name', 'email', 'dob', 'password', 'created_at', 'updated_at'];
        $csv->insertOne($headers);

        // Generate 100,000 records
        for ($i = 1; $i <= 100000; $i++) {
            $csv->insertOne([
                $i,
                $faker->firstName,
                $faker->lastName,
                $faker->unique()->safeEmail,
                $faker->date,
                $faker->password,
                now(),
                now(),
            ]);
        }

        $this->info('CSV generation complete.');

        return Command::SUCCESS;
    }
}
