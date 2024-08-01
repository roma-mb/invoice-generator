<?php

declare(strict_types=1);

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LoginController;
use App\Http\Middleware\JWTAuth;
use Illuminate\Support\Facades\Route;

Route::post('/login', [LoginController::class, 'login'])->name('auth.login');
Route::get('/login/verify', [LoginController::class, 'verify'])->name('auth.verify');


Route::middleware(JWTAuth::class)->group(function () {
    Route::post('/issue', [InvoiceController::class, 'issue'])->name('invoice.issue');
    Route::get('/consult/{key}', [InvoiceController::class, 'consult'])->name('invoice.consult');
    Route::put('/cancel', [InvoiceController::class, 'cancel'])->name('invoice.cancel');
    Route::get('/certificate', [InvoiceController::class, 'certificate'])->name('invoice.certificate');
    Route::get('/sefaz', [InvoiceController::class, 'sefaz'])->name('invoice.sefaz');
});
