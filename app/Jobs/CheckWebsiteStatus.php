<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Dispatchable;
use App\Models\Website;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
class CheckWebsiteStatus implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {  
        $websites = Website::get();
        foreach ($websites as $website) {
            $response = Http::timeout(2000)->get($website->url);
            if (!empty($response) && $response->successful()) {
               $website->website_up_down= 'up';
            } else {
                 $website->website_up_down= 'down';
            }
            $website->save();
        }
        return;
    }
}
