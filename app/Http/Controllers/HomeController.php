<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\ServiceCategory;
use App\Models\ServiceOrder;
use App\Models\Technician;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $services = ServiceCategory::orderBy('id')->get();
        $reviews = Review::latest()->take(3)->get();
        $onlineTechCount = Technician::where('is_online', true)->count();
        $activeOrderCount = ServiceOrder::whereIn('status', ['ON_THE_WAY', 'ACTIVE', 'PENDING'])->count();

        return view('pages.home', compact(
            'services',
            'reviews',
            'onlineTechCount',
            'activeOrderCount'
        ));
    }

    public function quickBook(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category' => 'required|string|max:60',
            'location' => 'nullable|string|max:150',
            'schedule' => 'nullable|string|max:40',
            'issue_description' => 'nullable|string|max:500',
        ]);

        $catKeyword = strtolower($validated['category']);
        $service = ServiceCategory::where('slug', 'like', "%{$catKeyword}%")
            ->orWhere('category_name', 'like', "%{$catKeyword}%")
            ->orWhere('title', 'like', "%{$catKeyword}%")
            ->first() ?? ServiceCategory::first();

        $matchedTech = Technician::where('is_online', true)->get()->first(function (Technician $tech) use ($catKeyword) {
            foreach ($tech->skills_category as $skill) {
                if (str_contains(strtolower($skill), $catKeyword)) {
                    return true;
                }
            }
            return false;
        }) ?? Technician::orderBy('distance_km')->first();
        $schedule = $validated['schedule'] ?? 'now';
        $isEmergency = $schedule === 'now';

        $scheduleLabel = match ($schedule) {
            'now' => 'Tiba Segera (15-25 Menit)',
            'today-afternoon' => 'Hari Ini (Siang / Sore)',
            'tomorrow' => 'Besok Pagi (08.00 - 11.00 WIB)',
            'weekend' => 'Akhir Pekan (Sabtu / Minggu)',
            default => '15 - 30 Menit',
        };

        $baseFee = $matchedTech ? $matchedTech->base_fee : ($service?->base_price ?? 75000);
        $diagnosticFee = 25000;
        $emergencyFee = $isEmergency ? 25000 : 0;
        $totalAmount = $baseFee + $diagnosticFee + $emergencyFee;

        $orderCode = 'WO-' . date('Y') . '-' . strtoupper(substr(md5(uniqid((string) mt_rand(), true)), 0, 4));

        $order = ServiceOrder::create([
            'order_code' => $orderCode,
            'customer_name' => 'Pelanggan TukangPro',
            'customer_phone' => '+62 812-3456-7890',
            'service_address' => $validated['location'] ?: 'Kebayoran Baru, Jakarta Selatan',
            'service_category_id' => $service?->id,
            'category_name' => $service?->title ?? ucfirst($validated['category']),
            'technician_id' => $matchedTech?->id,
            'status' => $isEmergency ? 'ON_THE_WAY' : 'PENDING',
            'is_emergency' => $isEmergency,
            'scheduled_arrival_at' => $scheduleLabel,
            'issue_description' => $validated['issue_description']
                ?: "Panggilan penanganan keluhan {$service?->category_name} ({$scheduleLabel})",
            'photos_url' => [$service?->image_url],
            'base_fee' => $baseFee,
            'diagnostic_fee' => $diagnosticFee,
            'spareparts_fee' => 0,
            'emergency_fee' => $emergencyFee,
            'total_amount' => $totalAmount,
            'escrow_status' => 'HELD',
            'eta_minutes' => $matchedTech?->est_arrival_minutes ?? 18,
            'speed_kmh' => 34,
            'warranty_valid_until' => '30 Hari Garansi Resmi Aktif Setelah BAST',
            'ordered_label' => 'Baru Saja (' . now()->format('H:i') . ' WIB)',
        ]);

        return redirect()
            ->route('tracking.show', ['orderCode' => $order->order_code])
            ->with('toast_message', "Armada #{$order->order_code} ({$matchedTech?->full_name}) berhasil dikunci! Sedang meluncur.")
            ->with('toast_icon', 'bolt');
    }
// 17 ---
    public function apiServices(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => ServiceCategory::orderBy('id')->get(),
        ]);
    }
}