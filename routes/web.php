<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\TopupController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\DonateController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('/dashboard');
});

// Dashboard Routes
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Account Routes
Route::get('/account', [AccountController::class, 'index'])->name('account');
Route::get('/account/editProfile', [AccountController::class, 'editProfile'])->name('account.editProfile');
Route::post('/account/update', [AccountController::class, 'update'])->name('account.update');

// Change Password Routes
Route::get('/account/changePassword', [AccountController::class, 'changePassword'])->name('account.changePassword');
Route::post('/account/updatePassword', [AccountController::class, 'updatePassword'])->name('account.updatePassword');

// Settings Routes
Route::get('/account/setting', [AccountController::class, 'setting'])->name('account.setting');
Route::post('/account/updateSettings', [AccountController::class, 'updateSettings'])->name('account.updateSettings');
Route::post('/account/updateLanguage', [AccountController::class, 'updateLanguage'])->name('account.updateLanguage');
Route::post('/account/delete', [AccountController::class, 'delete'])->name('account.delete');

Route::post('/logout', [AccountController::class, 'logout'])->name('logout');

// Topup Routes
Route::get('/topup', [TopupController::class, 'index'])->name('topup');
Route::post('/topup/process', [TopupController::class, 'process'])->name('topup.process');
Route::get('/topup/success', [TopupController::class, 'success'])->name('topup.success');
Route::get('/topup/instruction', [TopupController::class, 'instruction'])->name('topup.instruction');

// Campaign Routes
Route::get('/campaign/{id}', [CampaignController::class, 'detail'])->name('campaign.detail');
Route::get('/campaign/{id}/donate', [CampaignController::class, 'donate'])->name('campaign.donate');

// Donate Routes
Route::get('/donate', [DonateController::class, 'index'])->name('donate');
Route::post('/donate/process', [DonateController::class, 'process'])->name('donate.process');
Route::get('/donate/success', [DonateController::class, 'success'])->name('donate.success');

// Other Routes
Route::get('/history', [HistoryController::class, 'index'])->name('history');
Route::get('/history/search', [HistoryController::class, 'search'])->name('history.search');

Route::get('/my-donations', function() {
    return view('my-donations');
})->name('my-donations');

Route::get('/donation-reminder', function() {
    return view('donation-reminder');
})->name('donation-reminder');

// Campaign Routes
Route::get('/campaigns/category/{category}', function($category) {
    return view('campaigns.category', compact('category'));
})->name('campaigns.category');

// Search Route
Route::get('/search', function() {
    $query = request('q');
    return response()->json(['results' => []]);
})->name('search');
