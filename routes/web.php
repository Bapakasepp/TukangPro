<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\DispatchOpsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderTrackingController;
use App\Http\Controllers\PartnerAndAiController;
use App\Http\Controllers\TechnicianController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web & REST API v1 Routes — TukangPro Full-Stack Laravel 13 Blade MVC
|--------------------------------------------------------------------------
*/

// 1. Modul Beranda & Katalog Layanan
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/quick-book', [HomeController::class, 'quickBook'])->name('orders.quick-book');

// 2. Modul Direktori & Radar Pencarian Teknisi BNSP
Route::get('/cari-teknisi', [TechnicianController::class, 'index'])->name('technicians.index');

// 3. Modul Pemesanan, Live Tracking GPS & Rekening Escrow BAST
Route::get('/status-servis/{orderCode?}', [OrderTrackingController::class, 'show'])->name('tracking.show');
Route::post('/orders/book', [OrderTrackingController::class, 'store'])->name('orders.store');
Route::post('/orders/{order}/release-escrow', [OrderTrackingController::class, 'releaseEscrow'])->name('orders.release-escrow');
Route::post('/orders/{order}/cancel', [OrderTrackingController::class, 'cancel'])->name('orders.cancel');

// 4. Modul NOC Dispatch Control Center, Broadcast & Ekspor CSV
Route::get('/dispatch-ops', [DispatchOpsController::class, 'index'])->name('dispatch.index');
Route::post('/dispatch-ops/broadcast', [DispatchOpsController::class, 'broadcast'])->name('dispatch.broadcast');
Route::get('/dispatch-ops/export-csv', [DispatchOpsController::class, 'exportCsv'])->name('dispatch.export-csv');

// 5. Modul Pendaftaran Mitra & AI Smart Diagnostic Inspector
Route::post('/mitra/daftar', [PartnerAndAiController::class, 'registerPartner'])->name('partners.register');
Route::post('/api/v1/ai/diagnose', [PartnerAndAiController::class, 'diagnose'])->name('ai.diagnose');

// 6. Grup Endpoint JSON REST API v1
Route::prefix('api/v1')->group(function () {
    Route::get('/health', [ApiController::class, 'health'])->name('api.health');
    Route::get('/services', [HomeController::class, 'apiServices'])->name('api.services');
    Route::get('/technicians', [TechnicianController::class, 'apiIndex'])->name('api.technicians');
    Route::get('/technicians/{code}', [TechnicianController::class, 'apiShow'])->name('api.technicians.show');
    Route::get('/orders', [OrderTrackingController::class, 'apiIndex'])->name('api.orders');
    Route::get('/stats', [ApiController::class, 'stats'])->name('api.stats');
});