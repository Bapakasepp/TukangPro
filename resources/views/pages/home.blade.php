@extends('layouts.app')

@section('title', 'TukangPro - Jasa Teknisi Listrik, AC & Plumbing On-Demand BNSP')

@section('content')
<div class="flex flex-col w-full">
    {{-- 1. Hero Section & Statistik Real-Time --}}
    <section class="relative w-full bg-gradient-to-br from-[#061532] via-[#0a2351] to-[#0045b2] text-white py-16 lg:py-24 px-4 sm:px-6 lg:px-12 overflow-hidden">
        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
            <div class="lg:col-span-7 space-y-6">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 border border-white/20 text-xs font-bold text-[#6ffbbe]">
                    <span class="w-2 h-2 rounded-full bg-[#6ffbbe] animate-ping"></span>
                    <span>{{ $onlineTechCount }} Teknisi BNSP Siaga • {{ $activeOrderCount }} Order Aktif</span>
                </div>

                <h1 class="text-3xl sm:text-5xl font-extrabold leading-tight tracking-tight">
                    Solusi Cepat Perbaikan Listrik, Pipa &amp; AC Rumah Tanpa Khawatir Harga Tembak
                </h1>

                <p class="text-sm sm:text-base text-white/80 max-w-2xl leading-relaxed">
                    Panggil teknisi tersertifikasi BNSP terdekat dalam hitungan menit. Dilengkapi diagnosa kerusakan AI cerdas, pelacakan GPS real-time, serta perlindungan dana Rekening Bersama (Escrow) &amp; Garansi 30 Hari.
                </p>

                <div class="flex flex-wrap items-center gap-3 pt-2">
                    <a href="{{ route('technicians.index') }}"
                       class="px-6 py-3.5 rounded-xl bg-[#fc7123] hover:bg-[#e05d12] text-white font-extrabold text-sm shadow-lg flex items-center gap-2">
                        <span class="material-symbols-outlined text-lg">bolt</span> Cari Teknisi Terdekat
                    </a>
                    <button type="button" onclick="openModal('modal-ai-diagnostic')"
                            class="px-6 py-3.5 rounded-xl bg-white/10 hover:bg-white/20 border border-white/25 text-white font-bold text-sm flex items-center gap-2 cursor-pointer">
                        <span class="material-symbols-outlined text-lg text-[#6ffbbe]">neurology</span> Cek Kerusakan dengan AI
                    </button>
                </div>
            </div>
            {{-- Kartu Quick Dispatch 3-Langkah di Hero --}}
            <div class="lg:col-span-5 bg-white text-[#141b2b] rounded-3xl p-6 sm:p-7 shadow-2xl space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="font-extrabold text-lg text-[#0045b2]">Panggilan Cepat Darurat</h3>
                    <span class="px-2.5 py-1 rounded-full bg-[#6ffbbe]/40 text-[#00593c] text-[11px] font-bold">Escrow Aman</span>
                </div>
                <form method="POST" action="{{ route('orders.quick-book') }}" class="space-y-3">
                    @csrf
                    <div>
                        <label class="text-xs font-bold text-[#424654] block mb-1">Kategori Kerusakan</label>
                        <select name="category" id="quick-book-category" class="w-full p-3 rounded-xl bg-[#f1f3ff] text-sm font-semibold text-[#141b2b]">
                            @foreach ($services as $srv)
                                <option value="{{ $srv->category_name }}">{{ $srv->title }} (Mulai {{ $srv->formatted_price }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-[#424654] block mb-1">Lokasi Pengerjaan</label>
                        <input type="text" name="location" placeholder="Contoh: Jl. Pandanaran No. 12, Semarang"
                               class="w-full p-3 rounded-xl bg-[#f1f3ff] text-sm text-[#141b2b]">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-[#424654] block mb-1">Jadwal Kedatangan</label>
                        <select name="schedule" class="w-full p-3 rounded-xl bg-[#f1f3ff] text-sm font-semibold text-[#141b2b]">
                            <option value="now">Darurat Sekarang (Tiba 15-25 Menit)</option>
                            <option value="today-afternoon">Hari Ini Siang / Sore</option>
                            <option value="tomorrow">Besok Pagi (08:00 - 11:00 WIB)</option>
                        </select>
                    </div>
                    <input type="hidden" name="issue_description" id="quick-book-issue" value="">
                    <button type="submit" class="w-full py-3.5 rounded-xl bg-[#0045b2] hover:bg-[#003388] text-white font-extrabold text-sm cursor-pointer">
                        Kunci Armada &amp; Pantau GPS
                    </button>
                </form>
            </div>
        </div>
    </section>

    {{-- Tempat Seksi Katalog Layanan (#32) & Testimoni (#37) --}}
</div>
@endsection