<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Website;
use App\Jobs\AnalyzeWebsiteSpeedJob;

class AnalyzeAllWebsitesSpeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:analyze-all-websites-speed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $websites = Website::all();

        foreach ($websites as $website) {
            AnalyzeWebsiteSpeedJob::dispatch($website);
        }

        $this->info('Dispatched AnalyzeWebsiteSpeedJob for all websites.');
    }
}
