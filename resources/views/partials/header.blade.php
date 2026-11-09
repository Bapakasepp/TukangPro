@php
    $isHome = request()->routeIs('home');
    $isTech = request()->routeIs('technicians.*');
    $isTrack = request()->routeIs('tracking.*');
    $isDispatch = request()->routeIs('dispatch.*');
    $badgeCount = $activeOrderCount ?? 1;
@endphp

<header class="fixed top-0 left-0 right-0 z-40 bg-[#ffffff]/95 backdrop-blur-xl shadow-[0_1px_8px_rgba(0,0,0,0.04)] border-b border-[#dce2f7]/50">
    <div class="h-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 flex items-center justify-between gap-4">
        <div class="flex items-center gap-4 shrink-0">
            <a href="{{ route('home') }}" class="flex items-center gap-2 text-left group">
                <div class="w-10 h-10 rounded-lg bg-[#0d5be1] flex items-center justify-center text-white shadow-sm">
                    <span class="material-symbols-outlined text-2xl">home_repair_service</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-[20px] font-bold tracking-tight text-[#0045b2] leading-tight">
                        Tukang<span class="text-[#0d5be1]">Pro</span>
                    </span>
                    <span class="text-[11px] text-[#424654] leading-none">Laravel 13 Blade MVC</span>
                </div>
            </a>
            <div class="hidden sm:flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-[#e1e8fd]">
                <span class="material-symbols-outlined text-[#0045b2] text-sm">verified</span>
                <span class="text-xs text-[#141b2b] font-semibold">Mitra BNSP</span>
            </div>
        </div>

        <nav class="hidden xl:flex items-center gap-5 text-[14px]">
            <a href="{{ route('home') }}" class="font-semibold py-1.5 px-1 {{ $isHome ? 'text-[#0045b2] border-b-2 border-[#0045b2]' : 'text-[#424654] hover:text-[#0045b2]' }}">Beranda</a>
            <a href="{{ route('technicians.index') }}" class="font-semibold py-1.5 px-1 {{ $isTech ? 'text-[#0045b2] border-b-2 border-[#0045b2]' : 'text-[#424654] hover:text-[#0045b2]' }}">Cari Teknisi</a>
            <a href="{{ route('tracking.show') }}" class="font-semibold py-1.5 px-1 flex items-center gap-1.5 {{ $isTrack ? 'text-[#0045b2] border-b-2 border-[#0045b2]' : 'text-[#424654] hover:text-[#0045b2]' }}">
                <span>Live Tracking &amp; Escrow</span>
                @if ($badgeCount > 0)
                    <span class="px-1.5 py-0.5 rounded-full bg-[#6ffbbe]/40 text-[#00593c] text-[10px] font-bold">{{ $badgeCount }}</span>
                @endif
            </a>
            <button type="button" onclick="openModal('modal-join-partner')" class="font-semibold py-1.5 px-1 text-[#424654] hover:text-[#0045b2] cursor-pointer">Gabung Mitra</button>
            <a href="{{ route('dispatch.index') }}" class="font-semibold py-1.5 px-2.5 rounded-lg text-xs flex items-center gap-1 {{ $isDispatch ? 'bg-[#0045b2] text-white' : 'bg-[#e9edff] text-[#0045b2]' }}">
                <span class="material-symbols-outlined text-[15px]">cell_tower</span> Dispatch Ops
            </a>
        </nav>
        <div class="flex items-center gap-3 shrink-0">
            <button type="button" onclick="openModal('modal-ai-diagnostic')" class="hidden lg:inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-[#f1f3ff] hover:bg-[#dbe1ff] text-[#0045b2] font-semibold text-xs border border-[#dce2f7] cursor-pointer">
                <span class="material-symbols-outlined text-base">neurology</span> AI Inspector
            </button>
            <a href="{{ route('technicians.index') }}" class="inline-flex items-center justify-center px-4 py-2.5 rounded-lg bg-[#fc7123] text-white font-semibold text-sm hover:bg-[#a14000] shadow-sm">
                Pesan Cepat
            </a>
        </div>
    </div>
</header>