<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CampaignController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/campaigns', [CampaignController::class, 'index']);
Route::post('/campaigns', [CampaignController::class, 'store']);
Route::post('/campaigns/{id}/cancel', [CampaignController::class, 'cancel']);