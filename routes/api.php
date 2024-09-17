<?php

use App\Http\Controllers\CartController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/test', function () {
    return response()->json(['user' => Auth::user()]);
})->middleware('verify.token');


Route::apiResource('cart', CartController::class);