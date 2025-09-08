<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebsiteController;
Route::middleware('auth')->group(function () {
    
    Route::get('/admin/website-list', [WebsiteController::class, 'listWebsite']);
    Route::get('/admin/website/add', [WebsiteController::class, 'showUrlForm'])->name('website.add.url');
    Route::post('/admin/website/add', [WebsiteController::class, 'submitUrl'])->name('website.submit.url');
    Route::post('admin/website/update/{id}', [WebsiteController::class, 'update'])->name('website.update');
    Route::delete('admin/website/delete/{id}', [WebsiteController::class, 'destroy'])->name('website.delete');
    Route::get('admin',function(){ return view('admin.index'); });
    Route::get('/admin/website/credentials', [WebsiteController::class, 'showCredentialsForm'])->name('website.add.credentials');
    Route::post('/admin/website/credentials', [WebsiteController::class, 'submitCredentials'])->name('website.submit.credentials');
    Route::get('/website/sso-login/{id}', [WebsiteController::class, 'loginToWordPress'])
    ->name('website.sso.login');
    Route::get('/admin/list-websites-{id}',[WebsiteController::class,'listWebsites']);

    Route::get('/admin/manage/plugins-{id}',[WebsiteController::class,'managePlugins']);     
    Route::get('/admin/manage/theme-{id}',[WebsiteController::class,'manageTheme']);     
    Route::get('/admin/manage/user-{id}',[WebsiteController::class,'manageUser']);     
});
Route::get('/login', function () {
    return view('login');
});
Route::get('/', function () {
    return view('login');
})->name('login');


Route::controller(UserController::class)->prefix('admin')->group(function(){
    
    Route::post('/login','login');
});

Route::post('/logout', [UserController::class, 'logout']);
Route::get('/admin/show-sso-secret/{id}', function ($id) {
    $website = \App\Models\Website::findOrFail($id);
    return response()->json([
        'url' => $website->url,
        'decrypted_shared_secret' => decrypt($website->token_id),
    ]);
});
