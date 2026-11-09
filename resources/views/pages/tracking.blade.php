@extends('layouts.app')

@section('title', 'Live Tracking GPS & Rekening Escrow BAST - TukangPro')

@section('content')
<div class="max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-12 py-8 space-y-6">
    {{-- Quick Switcher Antar Work Order --}}
    <div class="flex flex-wrap items-center gap-2">
        <span class="text-xs font-bold text-[#424654] mr-1">Pilih Work Order:</span>
        @foreach ($recentOrders as $ro)
            <a href="{{ route('tracking.show', ['orderCode' => $ro->order_code]) }}"
               class="px-3 py-1.5 rounded-full text-xs font-bold border {{ $ro->id === $order->id ? 'bg-[#0045b2] text-white border-[#0045b2]' : 'bg-white text-[#424654] border-[#dce2f7]' }}">
                {{ $ro->order_code }} ({{ $ro->status }})
            </a>
        @endforeach
    </div>

    {{-- Header Status Work Order Aktif --}}
    <section class="bg-[#141b2b] text-white rounded-3xl p-6 sm:p-8 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
        <div class="space-y-2">
            <div class="flex flex-wrap items-center gap-2">
                <span class="px-3 py-1 rounded-full bg-[#6ffbbe]/20 text-[#6ffbbe] text-xs font-bold">{{ $order->order_code }}</span>
                <span class="px-3 py-1 rounded-full bg-white/10 text-white text-xs font-semibold">Status: {{ $order->status }}</span>
                <span class="px-3 py-1 rounded-full bg-[#fc7123]/20 text-[#ffb596] text-xs font-bold">Escrow: {{ $order->escrow_status }}</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold">{{ $order->category_name }}</h1>
            <p class="text-xs sm:text-sm text-white/75">{{ $order->issue_description }}</p>
            <p class="text-xs text-[#6ffbbe] font-semibold">📍 {{ $order->service_address }} • Jadwal: {{ $order->scheduled_arrival_at }}</p>
        </div>
        <div class="bg-white/10 rounded-2xl p-4 min-w-[200px] text-right">
            <span class="text-xs text-white/70 block">Estimasi Tiba (ETA)</span>
            <strong class="text-3xl font-extrabold text-[#6ffbbe]">{{ $order->eta_minutes > 0 ? $order->eta_minutes . ' Menit' : 'Tiba / Selesai' }}</strong>
            <span class="text-[11px] text-white/70 block mt-1">Kecepatan Armada: {{ $order->speed_kmh }} km/jam</span>
        </div>
    </section>
    {{-- Grid Utama: Kiri Radar & Stepper, Kanan Profil Teknisi & Escrow BAST --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-7 space-y-6" id="tracking-left-panel">
            <div class="bg-white rounded-2xl p-6 border border-[#dce2f7]">
                <h3 class="font-bold text-base text-[#141b2b]">Tahapan Pengerjaan Lapangan</h3>
                <p class="text-xs text-[#424654] mt-1">Pantau pergerakan armada secara real-time hingga BAST ditandatangani.</p>
            </div>
        </div>

        {{-- Kartu Teknisi Bertugas --}}
        <div class="lg:col-span-5 space-y-6">
            @if ($order->technician)
                <div class="bg-white rounded-2xl p-6 border border-[#dce2f7] space-y-4">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-[#0045b2]">Teknisi Bertugas</span>
                    <div class="flex items-center gap-4">
                        <img src="{{ $order->technician->avatar_url }}" alt="" class="w-16 h-16 rounded-2xl object-cover">
                        <div>
                            <h3 class="font-extrabold text-lg text-[#141b2b]">{{ $order->technician->full_name }}</h3>
                            <p class="text-xs font-semibold text-[#00593c]">{{ $order->technician->certification_level }}</p>
                            <p class="text-xs text-[#424654] mt-0.5">{{ $order->technician->vehicle }} • {{ $order->technician->police_number }}</p>
                        </div>
                    </div>
                    <a href="https://wa.me/{{ $order->technician->whatsapp }}" target="_blank"
                       class="w-full py-2.5 rounded-xl bg-[#00744f] text-white font-bold text-xs flex items-center justify-center gap-2">
                        Hubungi Teknisi via WhatsApp
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection