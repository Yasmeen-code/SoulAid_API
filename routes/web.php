<?php
use Illuminate\Support\Facades\Route;
use App\Models\Campaign;

Route::get('/login', function () {
    return view('login');
});

Route::get('/register', function () {
    return view('register');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});
Route::get('/profile', function () {
    return view('profile');
});
Route::get('/campaign-details', function () {
    return view('campaign-details');
});
Route::get('/login-admin', function () {
    return view('admin-login');
});
Route::get('/admin-dashboard', function () {
    return view('admin-dashboard');
});
Route::get('/manage-users', function () {
    return view('manage_users');
});
Route::get('/manage-campaigns', function () {
    return view('manage-campaigns');
});
Route::get('/campaigns/create_campaign', function () {
    return view('create_campaign');
});
Route::get('/campaigns/update/{id}', function ($id) {
    return view('edit-campaign'); 
});
Route::get('/campaigns/edit-campaign/{id}', function ($id) {
    return view('edit-campaign'); 
});
Route::get('/campaigns', function () {
    return view('campaigns');
});
Route::get('/test-users', function () {
    return \App\Models\User::all();
});
