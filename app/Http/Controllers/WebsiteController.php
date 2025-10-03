<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Website;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use App\Models\BackupData;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class WebsiteController extends Controller
{
    public function updateSiteStatus($websiteId)
    {
       
        \App\Jobs\UpdateSiteStatusJob::dispatch($websiteId);
    }
    public function checkSpeed(Request $request, $id)
    {
        $website = Website::find($id);
        if (!$website) {
            return response()->json(['success' => false, 'error' => 'Website not found.'], 404);
        }

        try {
            \App\Jobs\AnalyzeWebsiteSpeedJob::dispatch($website);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function checkPlugin(Request $request)
    {
        $request->validate([
            'url' => 'required|url'
        ]);

        $siteUrl = rtrim($request->url, '/');

        try {
            $response = Http::timeout(10)->get($siteUrl . '/wp-json/laravel-sso/v1/check-plugin');

            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Plugin is available and active'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Plugin is not available or not active'
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Could not connect to the website: ' . $e->getMessage()
            ], 500);
        }
    }
    public function listWebsite()
    {
        $websites = Website::query();

        $websitesQuery = Website::query();

        if (isset($_GET['status']) && !empty($_GET['status'])) {
            if ($_GET['status'] == 'up') {
                $websitesQuery->where('website_up_down', 'up');
            } else {
                $websitesQuery->where('website_up_down', null)->orwhere('website_up_down', 'down');
            }
        }
        // Get the results
        $websites = $websitesQuery->get();
        foreach ($websites as $website) {
            try {
                $website->decrypted_password = decrypt($website->password);
            } catch (DecryptException $e) {
                $website->decrypted_password = null;
            }
          
            $website->status = 'up';
        }
        // dd($websites);
        return view('admin.list', ['result' => $websites]);
    }
    public function showUrlForm()
    {
        return view('admin.website.add-url');
    }

    public function submitUrl(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
        ]);

        // Store URL temporarily in session for next step
        $request->session()->put('website_url', $request->url);

        // Redirect to credentials form
        return redirect()->route('website.add.credentials');
    }

    public function showCredentialsForm(Request $request)
    {
        // Check if URL exists in session, else redirect back
        if (!$request->session()->has('website_url')) {
            return redirect()->route('website.add.url')->withErrors('Please enter a website URL first.');
        }
        $websiteUrl = $request->session()->get('website_url');
        // Generate a shared secret and provide it to the view so the browser can register it with the WP site
        $sharedSecret = Str::random(32);
        return view('admin.website.add-credentials', compact('websiteUrl', 'sharedSecret'));
    }

    public function submitCredentials(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string|max:255',
            'site_url' => 'required|url',
            'shared_secret' => 'required|string',
        ]);

        // Prefer the site_url sent from the form (JS sets this), fallback to session
        $url = trim($request->input('site_url')) ?: $request->session()->get('website_url');
        if (!$url) {
            return redirect()->route('website.add.url')->withErrors('Session expired or site URL missing, please enter website URL again.');
        }

        // The browser should have registered the shared secret with the WP site.
        // We accept the posted shared_secret and save it encrypted. This avoids the server having to connect to the remote site.
        $sharedSecret = $request->input('shared_secret');

        $savedData = Website::create([
            'url' => rtrim($url, '/'),
            'username' => $request->username,
            'password' => encrypt($request->password), // Encrypt the password
            'token_id' => encrypt($sharedSecret), // Encrypt the shared secret
            'title' => $request->title,
            'logo' => $request->logo,
        ]);

        // Clear session
        $request->session()->forget('website_url');

        // Trigger status update job
        \App\Jobs\UpdateSiteStatusJob::dispatch($savedData->id);

        return redirect('admin/website-list')->with('success', 'Website credentials saved successfully!  Token ID : ' . $sharedSecret);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'url' => 'required',
            'username' => 'required|string|max:255',
            'password' => 'required|string|max:255',
        ]);
        $sharedSecret = Str::random(32);
        $website = Website::findOrFail($id);
        $website->update([
            'username' => $request->username,
            'url' => rtrim($request->url, '/'),
            'password' => encrypt($request->password), // Encrypt the password
            'token_id' => encrypt($sharedSecret),
        ]);
        return response()->json(['success' => true, 'website' => $website]);
    }

    public function destroy($id)
    {
        $website = Website::findOrFail($id);
        $website->delete();
        return response()->json(['success' => true]);
    }

 public function loginToWordPress($id)
{
    try {
        $website = Website::findOrFail($id);

        // Verify website exists and has required credentials
        if (!$website->username || !$website->token_id) {
            return response()->json([
                'error'   => 'missing_params',
                'message' => 'Website credentials are incomplete.'
            ], 400);
        }

        // Generate secure nonce
        $nonce = bin2hex(random_bytes(16));

        // Prepare payload
        $payload = [
            'iss'   => rtrim(url('/'), '/'),      // Laravel app URL
            'aud'   => rtrim($website->url, '/'), // WordPress site URL
            'email' => $website->username,        // WP admin email
            'exp'   => time() + 300,              // 5 min expiry
            'nonce' => $nonce                     // Prevent replay
        ];

        $payloadJson = json_encode($payload, JSON_UNESCAPED_SLASHES);

        // Decrypt shared secret
        try {
            $sharedSecret = decrypt($website->token_id);
        } catch (\Throwable $e) {
            return response()->json([
                'error'   => 'internal_error',
                'message' => 'Invalid token configuration'
            ], 500);
        }

        // Calculate signature
        $sig = base64_encode(hash_hmac('sha256', $payloadJson, $sharedSecret, true));

        // Redirect URL after login
        $redirectUrl = rtrim($website->url, '/') . '/wp-admin/';

        // WordPress SSO endpoint
        $wpSsoUrl = rtrim($website->url, '/') . '/wp-json/laravel-sso/v1/login';

        // ✅ Redirect browser directly so cookies are set client-side
        $finalUrl = $wpSsoUrl
            . '?payload='  . urlencode($payloadJson)
            . '&sig='      . urlencode($sig)
            . '&redirect=' . urlencode($redirectUrl);

        return redirect()->away($finalUrl);

    } catch (\Throwable $e) {
        Log::error('WordPress login error', [
            'website_id' => $id,
            'error'      => $e->getMessage(),
            'trace'      => $e->getTraceAsString()
        ]);

        return response()->json([
            'error'   => 'internal_error',
            'message' => 'An unexpected error occurred'
        ], 500);
    }
}


    // Here code for list websites
    public function listWebsites($id)
    {
        $result = Website::find($id);
         $iss = rtrim(url('/'), '/');
        $secret = decrypt($result->token_id);
        $sig = base64_encode(hash_hmac('sha256', $iss, $secret, true));
        $backupdata = BackupData::where('website_id', $id)->orderBy('id', 'desc')->first();
        $backupAllData = BackupData::where('website_id', $id)->get();
        // dd($backupdata);
        if (!$result) {
            abort(404, 'Website not found.');
        }
        $data = Website::where('id', $id)->value('data');
        $data = json_decode($data, true);

        //  dd($data,$result);

        return view('admin.website.view-website', [
            'response' => $data,
            'result' => $result,
            'backupdata' => $backupdata,
            'backupAllData' => $backupAllData,
            'iss' => $iss,
            'sig' => $sig
        ]);
    }

    // here code for update site data our backend
    public function updateSiteStatusWihotuJob($id)
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
            $response = Http::timeout(300)->get($final_url, [
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
                return response()->json(['success' => true, 'data' => $data]);
            } else {
                Website::where('id', $id)->update([
                    'website_status' => 'Inactive',
                ]);
                $data = null;
                $error = "Failed to fetch status. HTTP status: " . $response->status();
                return response()->json(['success' => false, 'error' => $error], $response->status());
            }
        } catch (\Exception $e) {
            $data = null;
            $error = "Connection error: " . $e->getMessage();
            return response()->json(['success' => false, 'error' => $error], 500);
        }
    }

    // here code for show plugins
    public function managePlugins($id)
    {
        return view('admin.website.manage-plugins');
    }
    public function manageTheme($id)
    {
        return view('admin.website.manage-theme');
    }
    public function manageUser($id)
    {
        return view('admin.website.manage-user');
    }

    public function updateWebsiteData($data, $id)
    {
        if (!empty($data)) {
            $site_name = data_get($data, 'site.name', '');

            Website::where('id', $id)->update([
                'title' => $site_name,
                'data' => json_encode($data),
            ]);
            // dd($data);
            return true;
        }
        return false;
    }

    public function hitUpgradePlugin(Request $request, $id)
    {
        $type = $request->input('type');
        $slug = $request->input('slug');
        $action = $request->input('action');

        $website = Website::find($id);
        if (!$website) {
            return response()->json(['error' => 'Website not found.'], 404);
        }

        // Prepare signed API call
        $iss = rtrim(url('/'), '/');
        $secret = decrypt($website->token_id);
        $sig = base64_encode(hash_hmac('sha256', $iss, $secret, true));
        $finalUrl = rtrim($website->url, '/') . '/wp-json/laravel-sso/v1/upgrade';
        // dd($finalUrl);
        // Build query parameters
        $queryParams = [
            'iss' => $iss,
            'sig' => $sig,
            'type' => $type,
            'slug' => $slug,
            'action' => $action,
        ];

        try {
            $response = Http::timeout(30)->get($finalUrl, $queryParams);
            //   dd($response);
            if ($response->successful()) {
                $data = $response->json();
                $this->updateSiteStatusWihotuJob($id);
                return response()->json(['success' => true, 'data' => $data]);
            } else {
                return response()->json(['error' => 'Failed to upgrade plugin. HTTP status: ' . $response->status()], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Connection error: ' . $e->getMessage()], 500);
        }
    }
    public function backupWebsite(Request $request, $id)
    {
        $website = Website::find($id);
        if (!$website) {
            return response()->json(['error' => 'Website not found.'], 404);
        }

        // Prepare signed API call
        $iss = rtrim(url('/'), '/');
        $secret = decrypt($website->token_id);
        $sig = base64_encode(hash_hmac('sha256', $iss, $secret, true));
        $finalUrl = rtrim($website->url, '/') . '/wp-json/laravel-sso/v1/handle_backup';

        // Build query parameters
        $queryParams = [
            'iss' => $iss,
            'sig' => $sig,
            'type' => $request->type,
            'website_id' => $website->id,
            'laravel_url' => rtrim(url('/'), '/'),
        ];

        try {
            $response = Http::timeout(1200)->get($finalUrl, $queryParams);

            if ($response->successful()) {
                $data = $response->json();

                // Calculate backup progress percentage
                $percent = 0;
                if (isset($data['status']) && $data['status'] === 'completed') {
                    $percent = 100;
                } elseif (!empty($data['total_files']) && !empty($data['next_batch'])) {
                    $percent = round(($data['next_batch'] / $data['total_files']) * 100, 2);
                }
                $data['progress_percent'] = $percent;

                // When backup is completed, hit send-to-laravel endpoint to store backup
                if ($percent == 100 && !empty($data['files'])) {
                    $this->moveAndStoreBackups($data['files'], $request->type, $website->id);
                    $this->deleteBackup($request, $website->id);
                }

                return response()->json(['success' => true, 'data' => $data]);
            } else {
                return response()->json(['error' => 'Failed to initiate backup. HTTP status: ' . $response->status()], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Connection error: ' . $e->getMessage()], 500);
        }
    }


    public function deleteBackup(Request $request, $id)
    {
        $website = Website::find($id);
        if (!$website) {
            return response()->json(['error' => 'Website not found.'], 404);
        }
        // Prepare signed API call
        $iss = rtrim(url('/'), '/');
        $secret = decrypt($website->token_id);
        $sig = base64_encode(hash_hmac('sha256', $iss, $secret, true));
        $finalUrl = rtrim($website->url, '/') . '/wp-json/laravel-sso/v1/delete-backup';

        // Build query parameters
        $queryParams = [
            'iss' => $iss,
            'sig' => $sig,
        ];
        try {
            $response = Http::timeout(300)->get($finalUrl, $queryParams);
            // dd($response);
            if ($response->successful()) {
                $data = $response->json();
                return response()->json(['success' => true, 'data' => $data]);
            } else {
                return response()->json(['error' => 'Failed to delete backup. HTTP status: ' . $response->status()], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Connection error: ' . $e->getMessage()], 500);
        }
    }


    public function moveAndStoreBackups($files, $type, $websiteId): array
    {
        $results = [];
        $backupDisk = Storage::disk('public');
        $destinationDir = 'backups/' . $websiteId;

        if (!$backupDisk->exists($destinationDir)) {
            $backupDisk->makeDirectory($destinationDir);
        }

        foreach ($files as $key => $filePath) {
            try {
                if (!$filePath) {
                    $results[$key] = 'No file provided';
                    continue;
                }

                $timestamp  = now()->format('Ymd_His');
                $extension  = pathinfo(parse_url($filePath, PHP_URL_PATH), PATHINFO_EXTENSION);
                $fileName   = "{$key}_{$type}_backup_{$timestamp}." . ($extension ?: 'zip');
                $destinationPath = $destinationDir . '/' . $fileName;
                $fullLocalPath   = storage_path("app/public/{$destinationPath}");

                // Remote file (streamed download)
                if (filter_var($filePath, FILTER_VALIDATE_URL)) {
                    $stream = fopen($fullLocalPath, 'w');
                    Http::timeout(1200)->sink($stream)->get($filePath);
                    fclose($stream);
                } else {
                    // Local file (copy, not read into memory)
                    if (!file_exists($filePath)) {
                        throw new \Exception("File not found: $filePath");
                    }
                    copy($filePath, $fullLocalPath);
                }

                // Save DB record
                $backup = BackupData::create([
                    'type'       => $type,
                    'file_path'  => $destinationPath,
                    'website_id' => $websiteId,
                ]);

                $results[$key] = [
                    'status' => 'success',
                    'file'   => $backup->file_path,
                    'url'    => $backupDisk->url($destinationPath),
                ];
            } catch (\Exception $e) {
                $results[$key] = [
                    'status'  => 'error',
                    'message' => $e->getMessage(),
                ];
            }
        }

        return $results;
    }






    // here code for added more functions
    public function dashboardIndex()
    {
        $websites = Website::all();

        $totalSites = $websites->count();
        $activeSites = $websites->where('website_status', 'active')->count();
        $upSites = $websites->where('website_up_down', 'up')->count();

        $allPlugins = collect();
        $allThemes  = collect();
        $pluginSiteMap = [];
        $themeSiteMap  = [];
        $websitelist   = [];

        foreach ($websites as $key => $site) {
            $websitelist[$key]['url'] = $site->url;
            $data = json_decode($site->data, true);

            $websitelist[$key]['site_name'] = $data['site_name'] ?? '';
            $websitelist[$key]['wordpress_version'] = $data['wordpress_version'] ?? '';
            $websitelist[$key]['wordpress_update_available'] = $data['wordpress_update_available'] ?? '';
            $websitelist[$key]['pagespeed_screenshot'] = $site->pagespeed_screenshot ?? '';
            $websitelist[$key]['website_up_down'] = $site->website_up_down ?? '';
            $websitelist[$key]['id'] = $site->id ?? '';

            // Collect plugin data
            if (isset($data['plugins']['items']) && is_array($data['plugins']['items'])) {
                foreach ($data['plugins']['items'] as $plugin) {
                    $pluginName = $plugin['name'] ?? null;

                    if ($pluginName) {
                        $allPlugins->push($plugin);
                        $pluginSiteMap[$pluginName][] = $site->url;
                    }
                }
            }

            // Collect theme data
            if (isset($data['themes']['items']) && is_array($data['themes']['items'])) {
                foreach ($data['themes']['items'] as $theme) {
                    $themeName = $theme['name'] ?? null;

                    if ($themeName) {
                        $allThemes->push($theme);
                        $themeSiteMap[$themeName][] = $site->url;
                    }
                }
            }
        }

        // Unique by plugin name
        $uniquePlugins = $allPlugins->unique('name')->values();
        $uniqueThemes  = $allThemes->unique('name')->values();

        // Prepare plugin list with all data
        $pluginsList = [];
        foreach ($uniquePlugins as $plugin) {
            $pluginsList[] = [
                'name'       => $plugin['name'] ?? '',
                'version'    => $plugin['version'] ?? '',
                'author'     => $plugin['author'] ?? '',
                'plugin_uri' => $plugin['plugin_uri'] ?? '',
                'icon_url'   => $plugin['icon_url'] ?? null,
                'is_active'  => $plugin['is_active'] ?? false,
                'update'     => $plugin['update'] ?? null,
                'sites'      => $pluginSiteMap[$plugin['name']] ?? [],
            ];
        }

        // Prepare theme list with all data
        $themesList = [];
        foreach ($uniqueThemes as $theme) {
            $themesList[] = [
                'name'       => $theme['name'] ?? '',
                'version'    => $theme['version'] ?? '',
                'author'     => $theme['author'] ?? '',
                'theme_uri'  => $theme['theme_uri'] ?? '',
                'screenshot' => $theme['screenshot'] ?? null,
                'is_active'  => $theme['is_active'] ?? false,
                'update'     => $theme['update'] ?? null,
                'sites'      => $themeSiteMap[$theme['name']] ?? [],
            ];
        }


        return view('admin.index', [
            'totalSites' => $totalSites,
            'activeSites' => $activeSites,
            'upSites' => $upSites,
            'pluginsList' => $pluginsList,
            'themesList' => $themesList,
            'websitelist' => $websitelist,
        ]);
    }
    public function websiteDetails($id)
    {
        $website = Website::findOrFail($id);
        $data = json_decode($website->data, true);
        // You can add more logic here to fetch related info, plugins, themes, backups, etc.
        return view('admin.website.website-details', [
            'website' => $website,
            'data' => $data,
        ]);
    }
    public function tabData(Request $request, $id)
    {
        $tab = $request->get('tab');
        $search = $request->get('search');
        $website = Website::findOrFail($id);
        $html = '';
        switch ($tab) {
            case 'overview':
                $html = view('admin.website.tabs.overview', compact('website'))->render();
                break;
            case 'plugins':
                $plugins = $website->plugins(); // Adjust this to your actual relationship or query
                if ($search) {
                    $plugins = $plugins->where('name', 'like', "%$search%");
                }
                $plugins = $plugins->get();
                $html = view('admin.website.tabs.plugins', compact('plugins'))->render();
                break;
            case 'themes':
                $themes = $website->themes(); // Adjust this to your actual relationship or query
                $html = view('admin.website.tabs.themes', compact('themes'))->render();
                break;
            case 'users':
                $users = $website->users(); // Adjust this to your actual relationship or query
                if ($search) {
                    $users = $users->where('name', 'like', "%$search%");
                }
                $users = $users->get();
                $html = view('admin.website.tabs.users', compact('users'))->render();
                break;
            case 'backup':
                $backups = BackupData::where('website_id', $id)->orderByDesc('created_at')->get();
                $html = view('admin.website.tabs.backup', compact('backups'))->render();
                break;
            default:
                $html = '<div class="text-danger">Invalid tab.</div>';
        }
        return response()->json(['html' => $html]);
    }

    public function listPlugins()
    {
        $websites = Website::all();
        $allPlugins = collect();
        $pluginSiteMap = [];

        foreach ($websites as $site) {
            $data = json_decode($site->data, true);
            if (isset($data['plugins']['items']) && is_array($data['plugins']['items'])) {
                foreach ($data['plugins']['items'] as $plugin) {
                    $pluginName = $plugin['name'] ?? null;
                    if ($pluginName) {
                        $allPlugins->push($plugin);
                        $pluginSiteMap[$pluginName][] = [
                            'name' => $data['site_name'] ?? $site->url,
                            'url' => $site->url,
                            'id' => $site->id
                        ];
                    }
                }
            }
        }

        $uniquePlugins = $allPlugins->unique('name')->values();
        $pluginsList = [];
        foreach ($uniquePlugins as $plugin) {
            $pluginsList[] = [
                'name' => $plugin['name'] ?? '',
                'version' => $plugin['version'] ?? '',
                'author' => $plugin['author'] ?? '',
                'plugin_uri' => $plugin['plugin_uri'] ?? '',
                'icon_url' => $plugin['icon_url'] ?? null,
                'is_active' => $plugin['is_active'] ?? false,
                'update' => $plugin['update'] ?? null,
                'sites' => $pluginSiteMap[$plugin['name']] ?? [],
            ];
        }

        return view('admin.plugins.list', ['pluginsList' => $pluginsList]);
    }

    public function listThemes()
    {
        $websites = Website::all();
        $allThemes = collect();
        $themeSiteMap = [];

        foreach ($websites as $site) {
            $data = json_decode($site->data, true);
            if (isset($data['themes']['items']) && is_array($data['themes']['items'])) {
                foreach ($data['themes']['items'] as $theme) {
                    $themeName = $theme['name'] ?? null;
                    if ($themeName) {
                        $allThemes->push($theme);
                        $themeSiteMap[$themeName][] = [
                            'name' => $data['site_name'] ?? $site->url,
                            'url' => $site->url,
                            'id' => $site->id
                        ];
                    }
                }
            }
        }

        $uniqueThemes = $allThemes->unique('name')->values();
        $themesList = [];
        foreach ($uniqueThemes as $theme) {
            $themesList[] = [
                'name' => $theme['name'] ?? '',
                'version' => $theme['version'] ?? '',
                'author' => $theme['author'] ?? '',
                'theme_uri' => $theme['theme_uri'] ?? '',
                'screenshot' => $theme['screenshot'] ?? null,
                'is_active' => $theme['is_active'] ?? false,
                'update' => $theme['update'] ?? null,
                'sites' => $themeSiteMap[$theme['name']] ?? [],
            ];
        }

        return view('admin.themes.list', ['themesList' => $themesList]);
    }
}
