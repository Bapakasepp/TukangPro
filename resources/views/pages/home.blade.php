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
    {{-- 2. Bento Grid Katalog 6 Layanan Berstandar SNI/BNSP --}}
    <section class="max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-12 py-16 space-y-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-[#0045b2]">KATALOG LAYANAN ON-DEMAND</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-[#141b2b] mt-1">Pilih Spesialisasi Teknisi Rumah Tangga</h2>
            </div>
            <a href="{{ route('technicians.index') }}" class="text-sm font-bold text-[#0045b2] hover:underline">Lihat Semua Mitra BNSP →</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($services as $srv)
                <div class="bg-white rounded-3xl overflow-hidden shadow-xs border border-[#dce2f7] hover:shadow-lg transition-all flex flex-col">
                    <div class="relative h-44 bg-[#e9edff]">
                        <img src="{{ $srv->image_url }}" alt="{{ $srv->title }}" class="w-full h-full object-cover">
                        <span class="absolute top-3 left-3 px-3 py-1 rounded-full bg-[#141b2b]/85 text-[#6ffbbe] text-[11px] font-bold">
                            {{ $srv->active_tech_count }} Teknisi Aktif
                        </span>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                        <div>
                            <div class="flex items-center gap-2 text-xs font-bold text-[#0045b2]">
                                <span class="material-symbols-outlined text-base">{{ $srv->icon }}</span>
                                <span>{{ $srv->category_name }}</span>
                            </div>
                            <h3 class="text-lg font-extrabold text-[#141b2b] mt-1">{{ $srv->title }}</h3>
                            <p class="text-xs text-[#424654] mt-1.5 leading-relaxed">{{ $srv->description }}</p>
                        </div>
                        <div class="pt-3 border-t border-[#dce2f7] flex items-center justify-between">
                            <div>
                                <span class="text-[10px] text-[#424654] block">Tarif Dasar Mulai</span>
                                <strong class="text-base font-extrabold text-[#0045b2]">{{ $srv->formatted_price }}</strong>
                            </div>
                            <a href="{{ route('technicians.index', ['category' => strtolower($srv->category_name)]) }}"
                               class="px-4 py-2 rounded-xl bg-[#0045b2] hover:bg-[#003388] text-white text-xs font-bold">
                                Panggil Teknisi
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    {{-- 3. Alur Cara Kerja Proteksi Escrow 4 Langkah --}}
    <section class="w-full bg-[#f1f3ff] py-16 px-4 sm:px-6 lg:px-12 border-y border-[#dce2f7]">
        <div class="max-w-7xl mx-auto space-y-8">
            <div class="text-center max-w-2xl mx-auto">
                <span class="text-xs font-bold uppercase tracking-wider text-[#00593c]">CARA KERJA AMAN &amp; TRANSPARAN</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-[#141b2b] mt-1">4 Langkah Servis Rumah Bebas Khawatir</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <div class="bg-white p-6 rounded-2xl border border-[#dce2f7]"><span class="text-xs font-extrabold text-[#0045b2]">01 • DIAGNOSA AI</span><h4 class="font-bold text-base mt-1">Cek Keluhan &amp; Estimasi</h4><p class="text-xs text-[#424654] mt-1">Gunakan AI Inspector untuk mengetahui perkiraan penyebab dan rentang biaya wajar.</p></div>
                <div class="bg-white p-6 rounded-2xl border border-[#dce2f7]"><span class="text-xs font-extrabold text-[#0045b2]">02 • PILIH MITRA BNSP</span><h4 class="font-bold text-base mt-1">Bandingkan Jarak &amp; Rating</h4><p class="text-xs text-[#424654] mt-1">Pilih teknisi terdekat dengan sertifikasi kompetensi resmi dan tarif transparan.</p></div>
                <div class="bg-white p-6 rounded-2xl border border-[#dce2f7]"><span class="text-xs font-extrabold text-[#0045b2]">03 • KUNCI ESCROW</span><h4 class="font-bold text-base mt-1">Pantau GPS Real-Time</h4><p class="text-xs text-[#424654] mt-1">Dana ditahan aman di Rekening Bersama selama teknisi meluncur dan bekerja.</p></div>
                <div class="bg-white p-6 rounded-2xl border border-[#dce2f7]"><span class="text-xs font-extrabold text-[#00593c]">04 • SETUJUI BAST</span><h4 class="font-bold text-base mt-1">Garansi 30 Hari Aktif</h4><p class="text-xs text-[#424654] mt-1">Dana baru cair ke mitra setelah pekerjaan beres &amp; BAST Digital Anda setujui.</p></div>
            </div>
        </div>
    </section>