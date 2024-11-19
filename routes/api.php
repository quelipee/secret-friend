<?php

use App\Http\Controllers\GroupsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/groups',[GroupsController::class,'store'])->name('create.groups');
Route::post('/groups/{id}/participants',[GroupsController::class,'storeParticipant'])->name('create.groups.participants');
Route::post('/groups/{id}/matches',[GroupsController::class, 'createSecretSantaMatches'])->name('create.secretSantaMatches');
