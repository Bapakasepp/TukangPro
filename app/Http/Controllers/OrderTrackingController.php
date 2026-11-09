<?php

namespace App\Http\Controllers;

use App\Models\ServiceCategory;
use App\Models\ServiceOrder;
use App\Models\Technician;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderTrackingController extends Controller
{
    public function show(?string $orderCode = null): View
    {
        $query = ServiceOrder::with(['technician', 'serviceCategory']);

        $order = $orderCode
            ? (clone $query)->where('order_code', $orderCode)->orWhere('id', $orderCode)->first()
            : (clone $query)->whereIn('status', ['ON_THE_WAY', 'ACTIVE', 'PENDING'])->latest()->first();

        if (!$order) {
            $order = ServiceOrder::with(['technician', 'serviceCategory'])->latest()->firstOrFail();
        }

        $recentOrders = ServiceOrder::with('technician')->latest()->take(6)->get();
        $activeOrderCount = ServiceOrder::whereIn('status', ['ON_THE_WAY', 'ACTIVE', 'PENDING'])->count();

        return view('pages.tracking', compact('order', 'recentOrders', 'activeOrderCount'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'technician_id' => 'required|exists:technicians,id',
            'customer_name' => 'nullable|string|max:100',
            'customer_phone' => 'nullable|string|max:30',
            'service_address' => 'required|string|max:255',
            'issue_description' => 'required|string|min:5|max:1000',
            'timing' => 'required|in:now,schedule',
        ]);

        $tech = Technician::findOrFail($validated['technician_id']);
        $primarySkill = $tech->skills_category[0] ?? 'Kelistrikan';

        $service = ServiceCategory::where('title', 'like', "%{$primarySkill}%")
            ->orWhere('category_name', 'like', "%{$primarySkill}%")
            ->first() ?? ServiceCategory::first();
        $isEmergency = $validated['timing'] === 'now';
        $baseFee = $tech->base_fee;
        $diagnosticFee = 25000;
        $emergencyFee = $isEmergency ? 25000 : 0;
        $totalAmount = $baseFee + $diagnosticFee + $emergencyFee;

        $orderCode = 'WO-' . date('Y') . '-' . strtoupper(substr(md5(uniqid((string) mt_rand(), true)), 0, 4));

        $order = ServiceOrder::create([
            'order_code' => $orderCode,
            'customer_name' => $validated['customer_name'] ?: 'Pelanggan TukangPro',
            'customer_phone' => $validated['customer_phone'] ?: '+62 812-3456-7890',
            'service_address' => $validated['service_address'],
            'service_category_id' => $service?->id,
            'category_name' => $primarySkill,
            'technician_id' => $tech->id,
            'status' => $isEmergency ? 'ON_THE_WAY' : 'PENDING',
            'is_emergency' => $isEmergency,
            'scheduled_arrival_at' => $isEmergency ? 'Dalam ' . $tech->est_arrival_minutes . ' Menit' : 'Terjadwal Besok 09:00 WIB',
            'issue_description' => $validated['issue_description'],
            'photos_url' => [$service?->image_url],
            'base_fee' => $baseFee,
            'diagnostic_fee' => $diagnosticFee,
            'spareparts_fee' => 0,
            'emergency_fee' => $emergencyFee,
            'total_amount' => $totalAmount,
            'escrow_status' => 'HELD',
            'eta_minutes' => $tech->est_arrival_minutes,
            'speed_kmh' => 33,
            'warranty_valid_until' => 'Garansi 30 Hari Aktif Setelah BAST Ditandatangani',
            'ordered_label' => 'Baru Saja (' . now()->format('H:i') . ' WIB)',
        ]);

        $formattedTotal = number_format($order->total_amount, 0, ',', '.');

        return redirect()
            ->route('tracking.show', ['orderCode' => $order->order_code])
            ->with('toast_message', "Teknisi {$tech->full_name} dikonfirmasi! Dana Escrow Rp {$formattedTotal} terkunci aman.")
            ->with('toast_icon', 'shield_lock');
    }
    public function releaseEscrow(ServiceOrder $order): RedirectResponse
    {
        $validUntil = now()->addDays(30)->translatedFormat('d F Y');

        $order->update([
            'status' => 'COMPLETED',
            'escrow_status' => 'RELEASED',
            'eta_minutes' => 0,
            'speed_kmh' => 0,
            'warranty_valid_until' => "Aktif 30 Hari (Hingga {$validUntil})",
        ]);

        if ($order->technician) {
            $order->technician->increment('total_completed_jobs');
        }

        return redirect()
            ->route('tracking.show', ['orderCode' => $order->order_code])
            ->with('toast_message', 'BAST Digital Sah! Dana Escrow berhasil dirilis ke mitra & Polis Garansi 30 Hari resmi aktif.')
            ->with('toast_icon', 'verified');
    }

    public function cancel(ServiceOrder $order): RedirectResponse
    {
        $order->update([
            'status' => 'CANCELLED',
            'escrow_status' => 'REFUNDED',
            'eta_minutes' => 0,
            'speed_kmh' => 0,
        ]);

        return redirect()
            ->route('tracking.show', ['orderCode' => $order->order_code])
            ->with('toast_message', "Pesanan #{$order->order_code} dibatalkan. Dana Escrow dikembalikan ke rekening asal.")
            ->with('toast_icon', 'cancel');
    }

    public function apiIndex(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => ServiceOrder::with('technician')->latest()->get(),
        ]);
    }
}