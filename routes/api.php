<?php

use App\Http\Controllers\LineBotController;
use Illuminate\Support\Facades\Route;

Route::post('/linebot', [LineBotController::class, 'reply']);
