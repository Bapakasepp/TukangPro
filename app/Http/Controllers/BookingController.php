<?php

namespace App\Http\Controllers;

use App\Models\ServiceCategory;
use App\Models\ServiceOrder;
use App\Models\Technician;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Validasi & Simpan Work Order Baru dengan Proteksi Rekening Escrow (HELD)
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'technician_id' => 'required|exists:technicians,id',
            'customer_name' => 'required|string|max:100',
            'customer_phone' => 'required|string|max:30',
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
            'customer_name' => $validated['customer_name'],
            'customer_phone' => $validated['customer_phone'],
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

        return redirect()
            ->route('tracking.show', ['orderCode' => $order->order_code])
            ->with('toast_message', "Work Order #{$order->order_code} berhasil dibuat! Dana Escrow terkunci aman.")
            ->with('toast_icon', 'shield_lock');
    }
}