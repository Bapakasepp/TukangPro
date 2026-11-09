<?php

namespace App\Http\Controllers;

use App\Models\BroadcastLog;
use App\Models\PartnerRegistration;
use App\Models\ServiceOrder;
use App\Models\Technician;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DispatchOpsController extends Controller
{
    public function index(Request $request): View
    {
        $statusFilter = $request->query('status', 'all');
        $allOrders = ServiceOrder::with('technician')->latest()->get();

        $filteredOrders = $allOrders->filter(function (ServiceOrder $order) use ($statusFilter) {
            if ($statusFilter === 'all') {
                return true;
            }
            if ($statusFilter === 'ACTIVE') {
                return in_array($order->status, ['ON_THE_WAY', 'ACTIVE', 'WORKING'], true);
            }
            return $order->status === $statusFilter;
        })->values();

        $technicians = Technician::orderByDesc('rating_average')->get();
        $broadcastLogs = BroadcastLog::latest()->take(5)->get();
        $partnerApplicants = PartnerRegistration::latest()->take(5)->get();

        $totalEscrowHeld = $allOrders->where('escrow_status', 'HELD')->sum('total_amount');
        $totalEscrowVolume = $allOrders->whereIn('escrow_status', ['HELD', 'RELEASED'])->sum('total_amount');
        $activeMovingCount = $allOrders->filter(fn ($o) => in_array($o->status, ['ON_THE_WAY', 'ACTIVE'], true))->count();
        $activeOrderCount = $allOrders->filter(fn ($o) => in_array($o->status, ['ON_THE_WAY', 'ACTIVE', 'PENDING'], true))->count();
        return view('pages.dispatch-ops', compact(
            'allOrders',
            'filteredOrders',
            'technicians',
            'broadcastLogs',
            'partnerApplicants',
            'statusFilter',
            'totalEscrowHeld',
            'totalEscrowVolume',
            'activeMovingCount',
            'activeOrderCount'
        ));
    }

    public function broadcast(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'message' => 'required|string|min:5|max:500',
        ]);

        $onlineCount = Technician::where('is_online', true)->count();

        BroadcastLog::create([
            'sender_name' => 'Operator NOC TukangPro',
            'message' => $validated['message'],
            'target_count' => $onlineCount,
            'priority' => 'HIGH',
        ]);

        return redirect()
            ->route('dispatch.index')
            ->with('toast_message', "Broadcast darurat terkirim ke {$onlineCount} armada aktif!")
            ->with('toast_icon', 'campaign');
    }

    public function exportCsv(): StreamedResponse
    {
        $orders = ServiceOrder::with('technician')->latest()->get();

        return response()->streamDownload(function () use ($orders) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Kode WO', 'Pelanggan', 'Kategori', 'Teknisi', 'Status', 'Escrow', 'Total (Rp)']);
            foreach ($orders as $o) {
                fputcsv($out, [
                    $o->order_code,
                    $o->customer_name,
                    $o->category_name,
                    $o->technician?->full_name ?? '-',
                    $o->status,
                    $o->escrow_status,
                    $o->total_amount,
                ]);
            }
            fclose($out);
        }, 'laporan-work-order-tukangpro.csv', ['Content-Type' => 'text/csv']);
    }
}