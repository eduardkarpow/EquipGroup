<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class HealthCheckDatabaseConnection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Health check for db connection (smoke test for deployment)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('trying to connect to DB');
        try {
            DB::connection()->getPdo();

            $this->info('Successfully connected to DB!');

            return Command::SUCCESS;
        } catch(\Exception $e) {
            $this->error('Failed to connect to DB!');
            $this->error('Error: ' . $e->getMessage());
            return Command::FAILURE;  
        }
    }
}
