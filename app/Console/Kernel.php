<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->job(ProcessAudioFiles::class)->everyFifteenMinutes();

        $schedule->command('queue:work --stop-when-empty')
             ->everyMinute()
             ->withoutOverlapping();

    }

    /**
     * Register the commands for the application.
     */
    protected $commands = [
        Commands\AddUsersCommand::class,
    ];

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
    protected function bootstrappers()
    {
        return array_merge(
            [\Inspector\Laravel\OutOfMemoryBootstrapper::class],
            parent::bootstrappers(),
        );
    }
}
