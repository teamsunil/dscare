<?php

namespace App\Jobs;

use App\Models\Website;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class UpdateSiteStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $websiteId;

    public function __construct($websiteId)
    {
        $this->websiteId = $websiteId;
    }

    public function handle()
    {

        $website = Website::find($this->websiteId);
        if (!$website) {

            return;
        }

        $iss = rtrim(url('/'), '/');
        $secret = decrypt($website->token_id);
        $sig = base64_encode(hash_hmac('sha256', $iss, $secret, true));
        $final_url = rtrim($website->url, '/') . '/wp-json/laravel-sso/v1/status';

        try {
            $response = Http::timeout(60)->get($final_url, [
                'iss' => $iss,
                'sig' => $sig,
            ]);

            if ($response->successful()) {

                $data = $response->json();


                if (!empty($data)) {
                    $site_name = data_get($data, 'site.name', '');

                    $website->update([
                        'title' => $site_name,
                        'website_status' => 'active',
                        'data' => json_encode($data),
                    ]);
                }
            } else {
                Website::where('id', $this->websiteId)->update([
                    'website_status' => 'Inactive',
                ]);
                \Log::warning("Failed response: " . $response->status());
            }
        } catch (\Exception $e) {
            Website::where('id', $this->websiteId)->update([
                'website_status' => 'Inactive',
            ]);
            \Log::error("Job failed: " . $e->getMessage());
        }
    }
}
