<?php

use App\Http\Controllers\CampaignController;
use Illuminate\Support\Facades\Route;

// 1. Rota para LISTAR as campanhas (tem que ser GET)
Route::get('/campaigns', [CampaignController::class, 'index']);

// 2. Rota para CRIAR a campanha (tem que ser POST)
Route::post('/campaigns', [CampaignController::class, 'store']);

// 3. Rota para CANCELAR a campanha (pode ser POST ou PUT)
Route::post('/campaigns/{id}/cancel', [CampaignController::class, 'cancel']);