<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\CheckWebsiteStatusCommand::class,
        \App\Console\Commands\AnalyzeAllWebsitesSpeed::class,
        \App\Console\Commands\UpdateSiteStatusCommand::class,

    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('website:check-status')->everyThirtyMinutes();
        $schedule->command('websites:analyze-speed')->daily();
        // Schedule UpdateSiteStatusCommand every 10 minutes (example)
        $schedule->command('website:update-status')->daily()->at('12:00')();
    }
}
