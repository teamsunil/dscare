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

    /**
     * AJAX version of reloadData - returns JSON response for frontend requests.
     */
    public function reloadDataAjax(Request $request, $id)
    {
        $result = Website::find($id);

        if (!$result) {
            return response()->json(['success' => false, 'message' => 'Website not found.'], 404);
        }

        $iss = rtrim(url('/'), '/');
        try {
            $secret = decrypt($result->token_id);
        } catch (\Exception $e) {
            Log::error('Failed to decrypt token for website id '.$id.': '.$e->getMessage());
            return response()->json(['success' => false, 'message' => 'Invalid token.'], 500);
        }

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
                    return response()->json(['success' => false, 'message' => 'API route not found on WordPress site.'], 404);
                }

                if (!empty($data)) {
                    $site_name = data_get($data, 'site.name', '');

                    $result->update([
                        'title' => $site_name,
                        'website_status' => 'active',
                        'data' => json_encode($data),
                    ]);
                }

                return response()->json(['success' => true, 'message' => 'Website data reloaded successfully.', 'data' => $data]);
            }

            Log::warning('Failed response from '.$final_url.' status: '.$response->status());
            return response()->json(['success' => false, 'message' => 'Failed to fetch status. HTTP status: '.$response->status()], 500);
        } catch (\Exception $e) {
            Log::error('Job failed for website id '.$id.': '.$e->getMessage());
            return response()->json(['success' => false, 'message' => 'Connection error: '.$e->getMessage()], 500);
        }
    }

    /**
     * Server-side fetch of WordPress API status - returns JSON (useful if client cannot call WP)
     */
    public function fetchWp($id)
    {
        $result = Website::find($id);
        if (!$result) {
            return response()->json(['success' => false, 'message' => 'Website not found.'], 404);
        }

        $iss = rtrim(url('/'), '/');
        try {
            $secret = decrypt($result->token_id);
        } catch (\Exception $e) {
            Log::error('Failed to decrypt token for website id '.$id.': '.$e->getMessage());
            return response()->json(['success' => false, 'message' => 'Invalid token.'], 500);
        }

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
                return response()->json(['success' => true, 'data' => $response->json()]);
            }

            return response()->json(['success' => false, 'message' => 'Failed to fetch status. HTTP status: '.$response->status()], 500);
        } catch (\Exception $e) {
            Log::error('Fetch WP failed for website id '.$id.': '.$e->getMessage());
            return response()->json(['success' => false, 'message' => 'Connection error: '.$e->getMessage()], 500);
        }
    }

    /**
     * Save a posted WP response into the Website model.
     * Expects JSON body (application/json) containing the WP API response.
     */
    public function saveResponse(Request $request, $id)
    {
        $result = Website::find($id);
        if (!$result) {
            return response()->json(['success' => false, 'message' => 'Website not found.'], 404);
        }

        $data = $request->all();
        if (empty($data)) {
            return response()->json(['success' => false, 'message' => 'No data provided.'], 400);
        }

        try {
            $site_name = data_get($data, 'site.name', $result->title);
            $result->update([
                'title' => $site_name,
                'website_status' => 'active',
                'data' => json_encode($data),
            ]);
            return response()->json(['success' => true, 'message' => 'Saved successfully.']);
        } catch (\Exception $e) {
            Log::error('Save response failed for website id '.$id.': '.$e->getMessage());
            return response()->json(['success' => false, 'message' => 'Save failed: '.$e->getMessage()], 500);
        }
    }

    // here function for check website status downgrade or upgrade
    public function checkWebsiteStatus($id)
    {
        \App\Jobs\CheckWebsiteStatus::dispatch();
    }
}
