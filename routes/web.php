<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SpkController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\InfluencerController;

// Landing page - ke daftar campaign
Route::get('/', [SpkController::class, 'index'])->name('spk.index');

// Campaign Routes
Route::get('/campaign', [CampaignController::class, 'index'])->name('campaign.index');
Route::get('/campaign/create', [CampaignController::class, 'create'])->name('campaign.create');
Route::post('/campaign', [CampaignController::class, 'store'])->name('campaign.store');
Route::get('/campaign/{id}/select', [CampaignController::class, 'select'])->name('campaign.select');

// Influencer Routes
Route::get('/influencer/manage', [InfluencerController::class, 'manage'])->name('influencer.manage');
Route::post('/influencer', [InfluencerController::class, 'store'])->name('influencer.store');
Route::get('/influencer/{id}/edit', [InfluencerController::class, 'edit'])->name('influencer.edit');
Route::put('/influencer/{id}', [InfluencerController::class, 'update'])->name('influencer.update');
Route::delete('/influencer/{id}', [InfluencerController::class, 'destroy'])->name('influencer.destroy');

// SPK Result
Route::get('/spk/result', [SpkController::class, 'result'])->name('spk.result');
