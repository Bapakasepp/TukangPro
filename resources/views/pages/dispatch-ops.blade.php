@extends('layouts.app')

@section('title', 'NOC & Dispatch Control Center - TukangPro')

@section('content')
<div class="flex flex-col w-full">
    {{-- 1. Top Header NOC --}}
    <section class="w-full bg-[#141b2b] text-white py-8 px-4 sm:px-6 lg:px-12 border-b border-[#293040]">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <div class="flex items-center gap-2 text-xs text-[#6ffbbe] font-bold uppercase tracking-wider mb-2">
                    <span class="w-2 h-2 rounded-full bg-[#4edea3] animate-pulse"></span>
                    <span>NOC &amp; DISPATCH CONTROL CENTER INDONESIA</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Pusat Komando Operasional Armada</h1>
                <p class="text-xs sm:text-sm text-white/70 mt-1">Pemantauan distribusi teknisi real-time, SLA kedatangan darurat, dan rekonsiliasi escrow berbasis MySQL.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('dispatch.index') }}" class="px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-semibold flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">refresh</span> Sync Database
                </a>
                <a href="{{ route('dispatch.export-csv') }}" class="px-4 py-2.5 rounded-xl bg-[#00744f] text-white text-xs font-bold flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">download</span> Ekspor CSV
                </a>
            </div>
        </div>
    </section>

    {{-- 2. Empat Kartu KPI Utama NOC --}}
    <section class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 -mt-6 pb-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white p-5 rounded-2xl shadow-md border border-[#dce2f7]">
                <span class="text-xs text-[#424654] font-semibold">Armada Siaga</span>
                <div class="text-2xl font-extrabold text-[#141b2b] mt-2">{{ $technicians->count() }} Teknisi</div>
                <div class="text-[11px] text-[#00593c] font-semibold mt-1">100% Terverifikasi BNSP</div>
            </div>
            <div class="bg-white p-5 rounded-2xl shadow-md border border-[#dce2f7]">
                <span class="text-xs text-[#424654] font-semibold">Total Work Order</span>
                <div class="text-2xl font-extrabold text-[#141b2b] mt-2">{{ $allOrders->count() }} Pekerjaan</div>
                <div class="text-[11px] text-[#fc7123] font-semibold mt-1">{{ $activeMovingCount }} Sedang Menuju Lokasi</div>
            </div>
            <div class="bg-white p-5 rounded-2xl shadow-md border border-[#dce2f7]">
                <span class="text-xs text-[#424654] font-semibold">Dana Escrow Ditahan</span>
                <div class="text-2xl font-extrabold text-[#0045b2] mt-2">Rp {{ number_format($totalEscrowHeld, 0, ',', '.') }}</div>
                <div class="text-[11px] text-[#424654] mt-1">Volume: Rp {{ number_format($totalEscrowVolume, 0, ',', '.') }}</div>
            </div>
            <div class="bg-white p-5 rounded-2xl shadow-md border border-[#dce2f7]">
                <span class="text-xs text-[#424654] font-semibold">Rata-rata SLA Tiba</span>
                <div class="text-2xl font-extrabold text-[#00593c] mt-2">18.4 Menit</div>
                <div class="text-[11px] text-[#00593c] font-semibold mt-1">SLA Terpenuhi: 97.4%</div>
            </div>
        </div>
    </section>
    
        {{-- Live Fleet Map & Daftar Armada Siaga NOC --}}
    <div class="bg-white rounded-2xl p-6 shadow-xs border border-[#dce2f7] space-y-4">
        <div class="flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-[#0045b2]">TELEMETRI RADAR ARMADA</span>
                <h4 class="font-bold text-base text-[#141b2b]">Live Fleet Map &amp; Sebaran Teknisi</h4>
            </div>
            <span class="px-2.5 py-1 rounded-full bg-[#6ffbbe]/40 text-[#00593c] text-xs font-bold">● {{ $technicians->where('is_online', true)->count() }} Online</span>
        </div>

        {{-- Visual Radar Grid NOC --}}
        <div class="relative h-48 rounded-2xl bg-[#0b1933] overflow-hidden p-4 flex flex-col justify-between border border-[#233a66]">
            <div class="flex items-center justify-between text-[11px] text-[#6ffbbe] font-mono">
                <span>GRID: JABODETABEK-SEMARANG-BDG</span>
                <span>LATENCY: 18ms • GPS ACTIVE</span>
            </div>
            <div class="grid grid-cols-3 gap-2 my-auto">
                @foreach ($technicians->take(3) as $fleet)
                    <div class="p-2 rounded-xl bg-white/10 backdrop-blur-xs text-white text-[11px]">
                        <div class="font-bold truncate">{{ $fleet->full_name }}</div>
                        <div class="text-[#6ffbbe] text-[10px]">{{ $fleet->police_number }} • {{ $fleet->distance_km }} km</div>
                    </div>
                @endforeach
            </div>
            <div class="text-[10px] text-white/60">Pemantauan posisi kendaraan mitra tersinkronisasi otomatis dengan Work Order aktif.</div>
        </div>

        {{-- Daftar Armada Siaga --}}
        <div class="space-y-2.5">
            @foreach ($technicians as $tech)
                <div class="flex items-center justify-between p-2.5 rounded-xl bg-[#f1f3ff]">
                    <div class="flex items-center gap-2.5">
                        <img src="{{ $tech->avatar_url }}" alt="" class="w-9 h-9 rounded-lg object-cover">
                        <div>
                            <div class="font-bold text-xs text-[#141b2b]">{{ $tech->full_name }}</div>
                            <div class="text-[10px] text-[#424654]">{{ $tech->skills_category[0] ?? 'Teknisi' }} • {{ $tech->distance_km }} km</div>
                        </div>
                    </div>
                    <span class="text-[11px] font-bold text-[#0045b2]">★ {{ number_format($tech->rating_average, 1) }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
    {{-- Tabel Antrean Work Order & Filter Status NOC --}}
    <div class="bg-white rounded-2xl p-6 shadow-xs border border-[#dce2f7] space-y-4">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h3 class="font-extrabold text-lg text-[#141b2b]">Antrean Work Order &amp; Status Escrow</h3>
                <p class="text-xs text-[#424654]">Klik kode Work Order untuk membuka layar Live Tracking &amp; BAST pelanggan.</p>
            </div>
            <div class="flex flex-wrap gap-1.5 text-xs">
                @foreach (['all' => 'Semua', 'ACTIVE' => 'Aktif Jalan', 'PENDING' => 'Menunggu', 'COMPLETED' => 'Selesai'] as $stKey => $stLabel)
                    <a href="{{ route('dispatch.index', ['status' => $stKey]) }}"
                       class="px-3 py-1.5 rounded-lg font-bold {{ $statusFilter === $stKey ? 'bg-[#0045b2] text-white' : 'bg-[#f1f3ff] text-[#424654]' }}">
                        {{ $stLabel }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="border-b border-[#dce2f7] text-[#424654] uppercase">
                        <th class="py-3 px-2">Kode WO</th>
                        <th class="py-3 px-2">Pelanggan &amp; Lokasi</th>
                        <th class="py-3 px-2">Teknisi Ditugaskan</th>
                        <th class="py-3 px-2">Status</th>
                        <th class="py-3 px-2">Dana Escrow</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#dce2f7]/60">
                    @foreach ($filteredOrders as $ord)
                        <tr class="hover:bg-[#f9f9ff]">
                            <td class="py-3 px-2 font-extrabold text-[#0045b2]">
                                <a href="{{ route('tracking.show', ['orderCode' => $ord->order_code]) }}" class="hover:underline">{{ $ord->order_code }}</a>
                            </td>
                            <td class="py-3 px-2">
                                <div class="font-bold text-[#141b2b]">{{ $ord->customer_name }}</div>
                                <div class="text-[11px] text-[#424654] truncate max-w-[200px]">{{ $ord->service_address }}</div>
                            </td>
                            <td class="py-3 px-2 font-semibold text-[#141b2b]">{{ $ord->technician?->full_name ?? 'Menunggu Penugasan' }}</td>
                            <td class="py-3 px-2"><span class="px-2 py-1 rounded-md bg-[#e9edff] text-[#0045b2] font-bold">{{ $ord->status }}</span></td>
                            <td class="py-3 px-2 font-bold text-[#00593c]">Rp {{ number_format($ord->total_amount, 0, ',', '.') }} ({{ $ord->escrow_status }})</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>