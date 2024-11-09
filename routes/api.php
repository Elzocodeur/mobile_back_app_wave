<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;


// Notez que nous n'avons pas besoin du préfixe 'api' car il est déjà ajouté dans RouteServiceProvider
Route::prefix('v1/auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/token/refresh', [AuthController::class, 'refreshToken'])->name('auth.refresh');
});
Route::prefix('v1/client')->group(function () {
    Route::post('/inscrire', [ClientController::class, 'inscrire'])->name('client.inscrire');
});

Route::middleware('auth:api')->prefix('v1/auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});




