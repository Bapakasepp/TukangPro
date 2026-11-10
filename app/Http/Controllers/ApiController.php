<?php

namespace App\Http\Controllers;

use App\Models\PartnerRegistration;
use App\Models\ServiceCategory;
use App\Models\ServiceOrder;
use App\Models\Technician;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    /**
     * GET /api/v1/health — Healthcheck Koneksi Server & Database Laravel 13
     */
    public function health(): JsonResponse
    {
        $dbConnected = true;
        try {
            DB::connection()->getPdo();
        } catch (\Throwable) {
            $dbConnected = false;
        }

        return response()->json([
            'status' => 'ok',
            'app' => config('app.name', 'TukangPro'),
            'framework' => 'Laravel ' . app()->version(),
            'php' => PHP_VERSION,
            'database_connected' => $dbConnected,
            'timestamp' => now()->toIso8601String(),
        ]);
    }

    /**
     * GET /api/v1/stats — Ringkasan KPI Operasional & Escrow Real-Time
     */
    public function stats(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => [
                'categories_count' => ServiceCategory::count(),
                'technicians_online' => Technician::where('is_online', true)->count(),
                'orders_total' => ServiceOrder::count(),
                'escrow_held_rp' => (int) ServiceOrder::where('escrow_status', 'HELD')->sum('total_amount'),
                'escrow_released_rp' => (int) ServiceOrder::where('escrow_status', 'RELEASED')->sum('total_amount'),
                'partner_applicants' => PartnerRegistration::count(),
            ],
        ]);
    }
}
    /**
     * GET /api/v1/services — Daftar 6 Katalog Layanan TukangPro
     */
    public function services(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'count' => ServiceCategory::count(),
            'data' => ServiceCategory::orderBy('id')->get(),
        ]);
    }

    /**
     * GET /api/v1/technicians — Daftar Direktori Teknisi BNSP dengan Filter Query
     */
    public function technicians(\Illuminate\Http\Request $request): JsonResponse
    {
        $query = Technician::query()->orderBy('distance_km');

        if ($request->boolean('online_only', false)) {
            $query->where('is_online', true);
        }

        if ($request->filled('max_radius')) {
            $query->where('distance_km', '<=', (float) $request->query('max_radius'));
        }

        $techs = $query->get();

        return response()->json([
            'success' => true,
            'count' => $techs->count(),
            'data' => $techs,
        ]);
    }