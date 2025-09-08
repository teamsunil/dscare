<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Website;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class WebsiteController extends Controller
{
    public function listWebsite()
    {
        $websites=Website::get();
         foreach ($websites as $website) {
            // $website->decrypted_password = decrypt($website->password);
            // $response = Http::timeout(2000)->get($website->url);
            
            // if ($response->successful()) {
            //    $website->status= 'up';
            // } else {
            //      $website->status= 'down';
            // }
               $website->status= 'up';

        }
        // dd($websites);
        return view('admin.website-list',['result'=>$websites]);
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

        return view('admin.website.add-credentials');
    }

    public function submitCredentials(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string|max:255',
        ]);
        $url = $request->session()->get('website_url');
        if (!$url) {
            return redirect()->route('website.add.url')->withErrors('Session expired, please enter website URL again.');
        }
        $sharedSecret = Str::random(32); // Laravel helper to generate a secure string
        $wpSsoUrl = rtrim($url, '/') . '/wp-json/laravel-sso/v1/add-secret-token';
        $query = http_build_query([
            'token' => $sharedSecret,
            'url' => rtrim(url('/'), '/'),
            'redirect' => '',
        ]);
        $data= Http::get($wpSsoUrl . '?' . $query);
        if(!empty($data))
        {
             Website::create([
                'url' => rtrim($url, '/'),
                'username' => $request->username,
                'password' => encrypt($request->password), // Encrypt the password
                'token_id' => encrypt($sharedSecret), // Encrypt the shared secret
                'title'=>$request->title,
                'logo'=>$request->logo,
            ]);
            // Clear session
            $request->session()->forget('website_url');
            return redirect('admin/website-list')->with('success', 'Website credentials saved successfully!  Token ID : '.$sharedSecret);
        }
        else
        {
            return back()->with('error','Wordpress Plugins Isseus');
        }

        // Save to DB
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
        $website = Website::find($id);
        $payload = [
            'iss' => rtrim(url('/'), '/'),
            'aud' => rtrim($website->url, '/'),
            'email' => $website->username,  // Use valid email
            'role' => 'subscriber',
            'exp' => time() + 300,
            'nonce' => bin2hex(random_bytes(8)),
        ];

       $payloadJson = json_encode($payload, JSON_UNESCAPED_SLASHES);


        // Use the shared secret exactly as stored in DB/WordPress
        $sharedSecret = decrypt($website->token_id); // if you're using Laravel's encryption;  // Ensure this exists and matches WP!

        $sig = base64_encode(hash_hmac('sha256', $payloadJson, $sharedSecret, true));

        $wpSsoUrl = rtrim($website->url, '/') . '/wp-json/laravel-sso/v1/login';

        $query = http_build_query([
            'payload' => $payloadJson,
            'sig' => $sig,
            'redirect' => '',
        ]);
    
        return redirect($wpSsoUrl . '?' . $query);
    }

    // Here code for list websites
   public function listWebsites($id)
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
            $response = Http::timeout(10)->get($final_url, [
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
                    $this->updateWebsiteData($response, $id);
                }
            } else {
                $data = null;
                $error = "Failed to fetch status. HTTP status: " . $response->status();
            }
        } catch (\Exception $e) {
            $data = null;
            $error = "Connection error: " . $e->getMessage();
        }

        return view('admin.website.view-website', [
            'response' => $data,
            'result' => $result,
            'error' => $error,
        ]);
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

    public function updateWebsiteData($data,$id)
    {
        if(!empty($data))
        {
            $site_name=data_get($data, 'site.name', '');
           
            Website::where('id',$id)->update([
                'title'=>$site_name,
                'data'=>$data
            ]);
            return true;
        }
        return false;
    }   
   

}
