<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Artisan;
class MigrateAndImport extends Command
{
    protected $signature = 'db:migrate-and-import {file}';
    protected $description = 'Run migrations and import an SQL file';

    public function handle()
    {
        // Run migrations
        $this->info('Running migrations...');
        $this->info('Migrations completed.');

        // Get the file path from the command argument
        $filePath = public_path($this->argument('file'));

        // Check if the file exists
        if (!File::exists($filePath)) {
            $this->error("The file does not exist: $filePath");
            return;
        }

        // Read the SQL file
        $sql = File::get($filePath);

        // Execute the SQL commands
        try {
            DB::unprepared($sql);
            $this->info('Database imported successfully.');
        } catch (\Exception $e) {
            $this->error('Error importing database: ' . $e->getMessage());
        }
    }
}
