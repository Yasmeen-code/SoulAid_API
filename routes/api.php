<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CampaignController;
use App\Http\Controllers\API\DonationController;
use App\Http\Controllers\API\DonationTypeController;
use App\Http\Controllers\API\RequestController;
use App\Http\Controllers\API\AdminAuthController;
use App\Http\Controllers\API\UserAuthController;
use App\Http\Controllers\API\FeedbackController;


Route::post('/feedback', [FeedbackController::class, 'store']);             
Route::get('/feedback/campaign/{campId}', [FeedbackController::class, 'showByCampaign']);
Route::put('/feedback/{id}', [FeedbackController::class, 'update']);    


Route::prefix('user')->group(function () {
    Route::post('login', [UserAuthController::class, 'login']);
    Route::post('register', [UserAuthController::class, 'register']);
    Route::middleware('auth:user')->post('logout', [UserAuthController::class, 'logout']);
});




Route::prefix('admin')->group(function () {
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::delete('/users/{id}', [AdminAuthController::class, 'destroy']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout']);
        Route::get('/users', [AdminAuthController::class, 'getUsers']);       
    });    
});

   // Campaigns
Route::get('campaigns', [CampaignController::class, 'index']);
Route::post('campaigns', [CampaignController::class, 'store']);
Route::get('campaigns/{id}', [CampaignController::class, 'show']);
Route::delete('/campaigns/{id}', [CampaignController::class, 'destroy']);

Route::put('/campaigns/update/{id}', [CampaignController::class, 'update']);
Route::get('/campaigns/edit/{id}', [CampaignController::class, 'edit']);



// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
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
Route::get('/', function () {
    return response()->json(['message' => 'Success']);
});
