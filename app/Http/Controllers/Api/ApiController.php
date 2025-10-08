<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BackupData;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ApiController extends Controller
{
    public function uploadBackup(Request $request)
    {
        $request->validate([
            'website_id' => 'required|integer',
            'type'       => 'required|string',
            'file'       => 'required|file',
        ]);

        try {
            $file = $request->file('file');
            $websiteId = $request->website_id;
            $type = $request->type;

            $timestamp  = now()->format('Ymd_His');
            $extension  = $file->getClientOriginalExtension();
            $fileName   = $type . '_backup_' . $timestamp . '.' . $extension;
            $destinationPath = 'backups/' . $websiteId . '/' . $fileName;

            $backupDisk = Storage::disk('public');
            $backupDisk->putFileAs('backups/' . $websiteId, $file, $fileName);

            $backup = BackupData::create([
                'type'       => $type,
                'file_path'  => $destinationPath,
                'website_id' => $websiteId,
            ]);

            return response()->json([
                'success' => true,
                'file'    => $backup->file_path,
                'url'     => $backupDisk->url($destinationPath),
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function getWebsiteList()
    {
        $websites = Website::select('id', 'url', 'title', 'website_up_down')->get();
        return response()->json([
            'success' => true,
            'data' => $websites,
            'total' => $websites->count()
        ]);
    }

    public function updateWebsiteStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:up,down',
        ]);

        $website = Website::find($id);
        if (!$website) {
            return response()->json(['success' => false, 'message' => 'Website not found'], 404);
        }

        $website->website_up_down = $request->status;
        $website->save();

        return response()->json(['success' => true, 'message' => 'Status updated']);
    }

    public function updateStatusData()
    {
        $websites = Website::all();
        $websiteData = [];

        foreach ($websites as $website) {
            $iss = rtrim(url('/'), '/');
            $secret = decrypt($website->token_id);
            $sig = base64_encode(hash_hmac('sha256', $iss, $secret, true));
            
            $websiteData[] = [
                'id' => $website->id,
                'url' => $website->url,
                'title' => $website->title,
                'iss' => $iss,
                'sig' => $sig,
                'status_endpoint' => rtrim($website->url, '/') . '/wp-json/laravel-sso/v1/status'
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $websiteData,
            'total' => count($websiteData)
        ]);
    }

    public function updateWebsiteData(Request $request, $id)
    {
        $request->validate([
            'data' => 'required|array'
        ]);

        $website = Website::find($id);
        if (!$website) {
            return response()->json(['success' => false, 'message' => 'Website not found'], 404);
        }

        $website->data = json_encode($request->data);
        
        $website->save();

        return response()->json(['success' => true, 'message' => 'Website data updated']);
    }
}
