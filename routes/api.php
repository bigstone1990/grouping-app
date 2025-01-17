<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GroupingController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/getPastGroupings', [GroupingController::class, 'getPastGroupings'])->middleware('auth:sanctum')->name('api.groupings');

Route::get('/getAllMembers', [GroupingController::class, 'getAllMembers'])->middleware('auth:sanctum')->name('api.members');

Route::get('/getAutoGroupings', [GroupingController::class, 'getAutoGroupings'])->middleware('auth:sanctum')->name('api.autogroupings');
