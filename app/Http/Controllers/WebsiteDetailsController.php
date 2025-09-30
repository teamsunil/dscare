<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Website;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class WebsiteDetailsController extends Controller
{
    public function generalDetails($id)
    {


        return view('admin.website.details.general', compact('id'));
    }

    // here code for update websdite data
    public function reloadData($id)
    {

        $result = Website::find($id);

        if (!$result) {
            abort(404, 'Website not found.');
        }
        $iss = rtrim(url('/'), '/');
        $secret = decrypt($result->token_id);
        $sig = base64_encode(hash_hmac('sha256', $iss, $secret, true));
        $final_url = rtrim($result->url, '/') . '/wp-json/laravel-sso/v1/status';

        try {
            $response = Http::withOptions([
                'curl' => [
                    CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
                ],
            ])->timeout(300)->get($final_url, [
                'iss' => $iss,
                'sig' => $sig,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['code']) && $data['code'] === 'rest_no_route') {
                    $data = null;
                    $error = "API route not found on WordPress site.";
                } else {
                    $error = null;
                    if (!empty($data)) {
                        $site_name = data_get($data, 'site.name', '');

                        Website::where('id', $id)->update([
                            'title' => $site_name,
                            'website_status' => 'active',
                            'data' => json_encode($data),
                        ]);
                        // dd($data);

                    }
                }
                return back()->with('success', 'Website data reloaded successfully.');
            } else {
                Website::where('id', $id)->update([
                    'website_status' => 'active',
                ]);
                $data = null;
                $error = "Failed to fetch status. HTTP status: " . $response->status();
                return back()->with('error', $error);
            }
        } catch (\Exception $e) {
            Website::where('id', $id)->update([
                'website_status' => 'active',
            ]);
            $data = null;
            $error = "Connection error: " . $e->getMessage();
            return back()->with('error', $error);
        }
    }

    // here function for check website status downgrade or upgrade
    public function checkWebsiteStatus($id)
    {
        \App\Jobs\CheckWebsiteStatus::dispatch();
    }
}
