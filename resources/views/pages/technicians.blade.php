@extends('layouts.app')

@section('title', 'Direktori Teknisi BNSP & Radar Terdekat - TukangPro')

@section('content')
<div class="flex flex-col w-full">
    {{-- 1. Header Highlight Direktori Teknisi --}}
    <section class="w-full bg-[#0045b2] text-white py-8 px-4 sm:px-6 lg:px-12">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-[#6ffbbe]">DIREKTORI MITRA TERSERTIFIKASI BNSP</span>
                <h1 class="text-2xl sm:text-3xl font-extrabold mt-1">Pilih Teknisi Terdekat Sesuai Keahlian</h1>
                <p class="text-xs sm:text-sm text-white/80 mt-1">Menampilkan {{ $filteredTechs->count() }} mitra siap panggil di sekitar {{ $location }}.</p>
            </div>
            <button type="button" onclick="openModal('modal-ai-diagnostic')"
                    class="px-4 py-2.5 rounded-xl bg-white text-[#0045b2] font-bold text-xs flex items-center gap-2 shadow-sm cursor-pointer">
                <span class="material-symbols-outlined text-base">neurology</span> Bingung Pilih? Cek AI Inspector
            </button>
        </div>
    </section>

    {{-- Dynamic Filter Bar (GET Form) --}}
    <section class="w-full bg-white border-b border-[#dce2f7] sticky top-20 z-30 shadow-2xs">
        <form method="GET" action="{{ route('technicians.index') }}" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 py-4 space-y-3">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
                <div class="md:col-span-5 flex items-center gap-2 px-3.5 py-2.5 rounded-xl bg-[#f1f3ff]">
                    <span class="material-symbols-outlined text-[#0045b2] text-lg">search</span>
                    <input type="text" name="search" value="{{ $search }}"
                           placeholder="Cari nama teknisi, keahlian MCB, freon, pipa..."
                           class="w-full bg-transparent text-xs sm:text-sm text-[#141b2b] outline-none">
                </div>

                <div class="md:col-span-3">
                    <select name="category" class="w-full px-3.5 py-2.5 rounded-xl bg-[#f1f3ff] text-xs sm:text-sm font-semibold text-[#141b2b]">
                        <option value="all" {{ $category === 'all' ? 'selected' : '' }}>Semua Kategori Layanan</option>
                        <option value="listrik" {{ $category === 'listrik' ? 'selected' : '' }}>Kelistrikan &amp; MCB</option>
                        <option value="ac" {{ $category === 'ac' ? 'selected' : '' }}>Servis AC &amp; Freon</option>
                        <option value="plumbing" {{ $category === 'plumbing' ? 'selected' : '' }}>Plumbing &amp; Pipa</option>
                        <option value="pompa" {{ $category === 'pompa' ? 'selected' : '' }}>Pompa Air &amp; Elektronik</option>
                        <option value="atap" {{ $category === 'atap' ? 'selected' : '' }}>Atap &amp; Kunci</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <select name="radius" class="w-full px-3.5 py-2.5 rounded-xl bg-[#f1f3ff] text-xs sm:text-sm font-semibold text-[#141b2b]">
                        <option value="5" {{ $radius === 5 ? 'selected' : '' }}>Radius ≤ 5 km</option>
                        <option value="10" {{ $radius === 10 ? 'selected' : '' }}>Radius ≤ 10 km</option>
                        <option value="25" {{ $radius === 25 ? 'selected' : '' }}>Radius ≤ 25 km</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <button type="submit" class="w-full py-2.5 rounded-xl bg-[#0045b2] hover:bg-[#003388] text-white font-bold text-xs sm:text-sm cursor-pointer">
                        Terapkan Filter
                    </button>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-4 text-xs text-[#424654]">
                <label class="inline-flex items-center gap-1.5 cursor-pointer">
                    <input type="checkbox" name="online" value="1" {{ $onlineOnly ? 'checked' : '' }} onchange="this.form.submit()">
                    <span>Hanya Siaga Online</span>
                </label>
                <label class="inline-flex items-center gap-1.5 cursor-pointer">
                    <input type="checkbox" name="rating" value="1" {{ $highRating ? 'checked' : '' }} onchange="this.form.submit()">
                    <span>Rating ★ 4.8+</span>
                </label>
                <label class="inline-flex items-center gap-1.5 cursor-pointer">
                    <input type="checkbox" name="bnsp" value="1" {{ $bnspOnly ? 'checked' : '' }} onchange="this.form.submit()">
                    <span>Wajib Sertifikat BNSP</span>
                </label>
            </div>
        </form>
    </section>

    {{-- 2. Grid Kartu Profil Teknisi BNSP --}}
    <section class="max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-12 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <div class="lg:col-span-7 space-y-4">
                @forelse ($filteredTechs as $tech)
                    <div class="bg-white rounded-2xl p-5 shadow-xs border {{ ($selectedTech?->id === $tech->id) ? 'border-[#0045b2] ring-2 ring-[#0045b2]/20' : 'border-[#dce2f7]' }} transition-all">
                        <div class="flex items-start gap-4">
                            <img src="{{ $tech->avatar_url }}" alt="{{ $tech->full_name }}" class="w-16 h-16 rounded-2xl object-cover shrink-0">
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                    <h3 class="text-lg font-extrabold text-[#141b2b]">{{ $tech->full_name }}</h3>
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold {{ $tech->is_online ? 'bg-[#6ffbbe]/40 text-[#00593c]' : 'bg-gray-100 text-gray-600' }}">
                                        {{ $tech->is_online ? '● Siaga Online' : 'Sedang Tugas' }}
                                    </span>
                                </div>
                                <p class="text-xs font-semibold text-[#0045b2] mt-0.5">{{ $tech->certification_level }}</p>
                                <p class="text-xs text-[#424654] mt-1.5">{{ $tech->bio }}</p>
                                <div class="grid grid-cols-3 gap-2 mt-3 p-2.5 rounded-xl bg-[#f1f3ff] text-xs">
                                    <div><span class="text-[#424654] block text-[10px]">Rating</span><strong class="text-[#141b2b]">★ {{ number_format($tech->rating_average, 2) }} ({{ $tech->total_ratings_count }})</strong></div>
                                    <div><span class="text-[#424654] block text-[10px]">Jarak &amp; ETA</span><strong class="text-[#00593c]">{{ $tech->distance_km }} km • ~{{ $tech->est_arrival_minutes }} mnt</strong></div>
                                    <div><span class="text-[#424654] block text-[10px]">Tarif Dasar</span><strong class="text-[#0045b2]">Rp {{ number_format($tech->base_fee, 0, ',', '.') }}</strong></div>
                                </div>

                                <div class="flex flex-wrap gap-1.5 mt-3">
                                    @foreach ($tech->skills_tags as $tag)
                                        <span class="px-2.5 py-1 rounded-lg bg-[#e9edff] text-[#0045b2] text-[11px] font-semibold">{{ $tag }}</span>
                                    @endforeach
                                </div>

                                <div class="flex flex-wrap items-center gap-2 mt-4 pt-3 border-t border-[#dce2f7]">
                                    <a href="{{ route('technicians.index', ['selected' => $tech->code, 'category' => $category]) }}"
                                       class="px-4 py-2 rounded-xl bg-[#fc7123] hover:bg-[#a14000] text-white text-xs font-bold">
                                        Pilih &amp; Booking Teknisi
                                    </a>
                                    <button type="button" onclick="openPortfolioModal('{{ $tech->full_name }}', '{{ $tech->certification_level }}')"
                                            class="px-3 py-2 rounded-xl bg-[#f1f3ff] text-[#0045b2] text-xs font-semibold cursor-pointer">
                                        Lihat Portofolio ({{ $tech->portfolio_count }})
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-2xl p-8 text-center border border-[#dce2f7]">
                        <p class="font-bold text-[#141b2b]">Tidak ada teknisi yang cocok dengan filter saat ini.</p>
                        <a href="{{ route('technicians.index', ['online' => 0]) }}" class="inline-block mt-3 px-4 py-2 rounded-xl bg-[#0045b2] text-white text-xs font-bold">Reset Filter Pencarian</a>
                    </div>
                @endforelse
            </div>

            {{-- Kolom Kanan: Panel Booking Cepat --}}
            <div class="lg:col-span-5">
                @includeIf('pages.booking')
            </div>
        </div>
    </section>
</div>

@endsection