<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Website;
use App\Jobs\UpdateSiteStatusJob;

class UpdateAllWebsitesStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-all-websites-status';

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
            // Dispatch the job for each website
            UpdateSiteStatusJob::dispatch($website->id);
        }

        $this->info('Dispatched UpdateSiteStatusJob for all websites.');
    }
}
