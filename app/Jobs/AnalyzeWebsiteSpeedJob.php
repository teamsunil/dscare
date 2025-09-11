<?php

namespace App\Jobs;

use App\Models\Website;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class AnalyzeWebsiteSpeedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $website;

    public function __construct(Website $website)
    {
        $this->website = $website;
    }

    public function handle()
    {
        $url = $this->website->url;
        $api ="https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=" . urlencode($url) . "&strategy=desktop&key=AIzaSyCWtkcY1AndEIPqUaBHfraos-lSyoqGusc&category=performance&category=accessibility&category=seo&category=best-practices";
        $response = Http::timeout(300)->get($api);

        if ($response->failed()) {
            return;
        }

        $data = $response->json();
        if (!$data || !isset($data['lighthouseResult'])) {
            return;
        }

        $lighthouse = $data['lighthouseResult'];
        $screenshot = $lighthouse['audits']['final-screenshot']['details']['data'] ?? null;
        $performance = isset($lighthouse['categories']['performance']['score']) ? $lighthouse['categories']['performance']['score'] * 100 : null;
        $seo = isset($lighthouse['categories']['seo']['score']) ? $lighthouse['categories']['seo']['score'] * 100 : null;
        $accessibility = isset($lighthouse['categories']['accessibility']['score']) ? $lighthouse['categories']['accessibility']['score'] * 100 : null;
        $best_practices = isset($lighthouse['categories']['best-practices']['score']) ? $lighthouse['categories']['best-practices']['score'] * 100 : null;

        $this->website->update([
            'pagespeed_screenshot'     => $screenshot,
            'pagespeed_performance'    => $performance,
            'pagespeed_seo'            => $seo,
            'pagespeed_accessibility'  => $accessibility,
            'pagespeed_best_practices' => $best_practices,
        ]);
    }
}
