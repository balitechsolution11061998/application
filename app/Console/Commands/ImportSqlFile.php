<?php

  namespace App\Console\Commands;

  use Illuminate\Console\Command;
  use Illuminate\Support\Facades\DB;
  use Illuminate\Support\Facades\File;

  class ImportSqlFile extends Command
  {
      protected $signature = 'db:import {file}';
      protected $description = 'Import an SQL file into the database';

      public function handle()
      {
          // Get the file path from the command argument
          $filePath = $this->argument('file');

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
