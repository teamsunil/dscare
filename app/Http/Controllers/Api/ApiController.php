<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BackupData;
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
}
