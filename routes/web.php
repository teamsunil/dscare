<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\WebsiteDetailsController;

Route::middleware('guestUser')->group(function () {
    Route::get('/login', function () {
        return view('login');
    });
    Route::get('/', function () {
        return view('login');
    })->name('login');
});
Route::get('list',function(){
    return view('admin.list');
});
Route::middleware('auth')->group(function () {
    
    Route::get('admin/index',function(){
        return view('admin.index');
    })->name('index');

  Route::get('/admin/website/{id}/details', [WebsiteController::class, 'websiteDetails'])->name('website.details');
   
    Route::get('admin/index', [WebsiteController::class, 'dashboardIndex'])->name('index');

    Route::get('admin/website/reload/{id}/data', [WebsiteDetailsController::class, 'reloadData']);
    Route::get('/admin/website/{id}/upgrade-plugin',[WebsiteController::class,'hitUpgradePlugin']);
    Route::get('/admin/website-list', [WebsiteController::class, 'listWebsite'])->name('dashboard');
    Route::get('/admin/website/add', [WebsiteController::class, 'showUrlForm'])->name('website.add.url');
    Route::post('/admin/website/add', [WebsiteController::class, 'submitUrl'])->name('website.submit.url');
    Route::post('admin/website/update/{id}', [WebsiteController::class, 'update'])->name('website.update');
    Route::delete('admin/website/delete/{id}', [WebsiteController::class, 'destroy'])->name('website.delete');
    Route::get('admin', function () {
        return view('admin.index');
    });
    Route::get('/admin/website/credentials', [WebsiteController::class, 'showCredentialsForm'])->name('website.add.credentials');
    Route::post('/admin/website/credentials', [WebsiteController::class, 'submitCredentials'])->name('website.submit.credentials');
    Route::get('/website/sso-login/{id}', [WebsiteController::class, 'loginToWordPress'])
        ->name('website.sso.login');
    Route::get('/admin/list-websites-{id}', [WebsiteController::class, 'listWebsites']);

    Route::get('/admin/manage/plugins-{id}', [WebsiteController::class, 'managePlugins']);
    Route::get('/admin/manage/theme-{id}', [WebsiteController::class, 'manageTheme']);
    Route::get('/admin/manage/user-{id}', [WebsiteController::class, 'manageUser']);
    Route::get('/admin/website/{id}/backup', [WebsiteController::class, 'backupWebsite'])->name('website.backup');
    Route::post('/admin/website/{id}/check-speed', [WebsiteController::class, 'checkSpeed'])->name('website.check.speed');
    Route::get('/admin/download', function () {
        $filePath = public_path('ds_care_sso.zip');
        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }
        return response()->download($filePath, 'ds_care_sso.zip');
    })->name('download');
    Route::get('admin/website/{id}/delete-backup', [WebsiteController::class, 'deleteBackup'])->name('website.delete.backup');
    Route::get('/admin/website/{id}/tab-data', [WebsiteController::class, 'tabData'])->name('website.tabdata');
});


Route::controller(UserController::class)->prefix('admin')->group(function () {

    Route::post('/login', 'login');
});

Route::get('/logout', [UserController::class, 'logout'])->name('logout');
Route::get('/admin/show-sso-secret/{id}', function ($id) {
    $website = \App\Models\Website::findOrFail($id);
    return response()->json([
        'url' => $website->url,
        'decrypted_shared_secret' => decrypt($website->token_id),
    ]);
});
