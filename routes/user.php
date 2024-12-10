<?php

use App\Http\Controllers\User;
use App\Http\Controllers\FinancialRoadmapsController;
use App\Models\FinancialRoadmap;
use Illuminate\Support\Facades\Route;

//Route::middleware('auth:web')->group(function () {
//    Route::get('/', [FinancialRoadmapsController::class, 'index'])->name('index');
//});

Route::get('/{id}/{encode_code}', [FinancialRoadmapsController::class, 'stage1'])->name('index');
Route::get('/partial_result/{financialRoadmap}/{user_id}/{encode_code}', [FinancialRoadmapsController::class, 'stage2'])->name('stage2');
Route::get('/final_result/{financialRoadmap}', [FinancialRoadmapsController::class, 'stage3'])->name('stage3');

Route::post('/store', [FinancialRoadmapsController::class, 'store'])->name('index.store');
