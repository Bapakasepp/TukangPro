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
</div>
@endsection