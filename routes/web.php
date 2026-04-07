<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TrackingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TrackingController::class, 'index']);
Route::post('/track', [TrackingController::class, 'track'])->name('track');
Route::get('/live-location/{tracking}', [TrackingController::class, 'liveLocation']);


Route::prefix('admin')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');

    Route::get('/shipments', [AdminController::class, 'index'])
        ->name('admin.shipments');

    Route::get('/shipments/create', [AdminController::class, 'create'])
        ->name('admin.shipments.create');

    Route::post('/shipments/store', [AdminController::class, 'store'])
        ->name('admin.shipments.store');

    Route::get('/shipments/{id}/edit', [AdminController::class, 'edit'])
        ->name('admin.shipments.edit');

    Route::post('/shipments/{id}/update', [AdminController::class, 'update'])
        ->name('admin.shipments.update');

    Route::get('/shipments/{id}/delete', [AdminController::class, 'delete'])
        ->name('admin.shipments.delete');
});
Route::get('/payment/checkout/{id}', [PaymentController::class, 'checkout'])
    ->name('payment.checkout');
