<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CampaignController;
use App\Http\Controllers\API\DonationController;
use App\Http\Controllers\API\DonationTypeController;
use App\Http\Controllers\API\RequestController;

// Public Routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);


   // Campaigns
Route::get('campaigns', [CampaignController::class, 'index']);
Route::post('campaigns', [CampaignController::class, 'store']);
Route::get('campaigns/{id}', [CampaignController::class, 'show']);


// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    // Donation Type
    Route::get('donation-types', [DonationTypeController::class, 'index']);
    Route::post('donation-types', [DonationTypeController::class, 'store']);
    Route::get('donation-types/{id}', [DonationTypeController::class, 'show']);

    // Donations
    Route::get('donations', [DonationController::class, 'index']);
    Route::post('donations', [DonationController::class, 'store']);
    Route::get('donations/{id}', [DonationController::class, 'show']);
    Route::put('donations/{id}', [DonationController::class, 'update']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/requests', [RequestController::class, 'store']);
    Route::get('/requests', [RequestController::class, 'index']);
    Route::get('/requests/my', [RequestController::class, 'showUserRequests']); 
    Route::put('/requests/{id}', [RequestController::class, 'update']);
    Route::delete('/requests/{id}', [RequestController::class, 'destroy']); 


    Route::post('campaigns/{id}/clone', [CampaignController::class, 'cloneCampaign']);

});
