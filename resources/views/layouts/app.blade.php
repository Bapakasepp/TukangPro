<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'TukangPro - Platform Teknisi & Workforce On-Demand')</title>
    <meta name="description" content="Platform on-demand marketplace jasa teknisi listrik, AC, plumbing, dan perbaikan rumah terpercaya dengan radar GPS real-time, rekening escrow aman, dan sertifikasi BNSP.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
    @if (file_exists(public_path('css/tukangpro.css')))
        <link rel="stylesheet" href="{{ asset('css/tukangpro.css') }}">
    @else
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
        <style>
            body { font-family: 'Inter', sans-serif; }
            .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; vertical-align: middle; line-height: 1; }
            .material-symbols-outlined.fill-1 { font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        </style>
    @endif
</head>
<body class="min-h-screen flex flex-col bg-[#f9f9ff] text-[#141b2b] antialiased selection:bg-[#0045b2] selection:text-white">
    @include('partials.header')

    <main class="flex-1 flex flex-col w-full pt-28 xl:pt-20">
        @if ($errors->any())
            <div class="max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-12 pt-4">
                <div class="p-4 rounded-2xl bg-[#ffdad6] border border-[#ba1a1a]/30 text-[#93000a] text-xs sm:text-sm flex items-start gap-3">
                    <span class="material-symbols-outlined text-lg shrink-0">error</span>
                    <div>
                        <strong class="font-bold block">Mohon periksa kembali input Anda:</strong>
                        <ul class="list-disc list-inside mt-1 space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        @yield('content')
    </main>
    @include('partials.footer')
    @includeIf('partials.modals.ai-diagnostic')
    @includeIf('partials.modals.join-partner')
    @includeIf('partials.modals.portfolio')

    {{-- Floating System Toast --}}
    <div id="tukangpro-toast"
         class="fixed bottom-6 right-6 z-50 {{ session('toast_message') ? 'flex' : 'hidden' }} items-center gap-3 px-5 py-3.5 rounded-2xl bg-[#141b2b] text-white shadow-2xl border border-white/20 transition-all duration-300">
        <span id="tukangpro-toast-icon" class="material-symbols-outlined text-xl text-[#6ffbbe]">
            {{ session('toast_icon', 'verified') }}
        </span>
        <span id="tukangpro-toast-text" class="text-xs sm:text-sm font-semibold max-w-sm">
            {{ session('toast_message') }}
        </span>
    </div>

    <script>
        window.showTukangToast = function(message, icon = 'info') {
            const toast = document.getElementById('tukangpro-toast');
            const iconEl = document.getElementById('tukangpro-toast-icon');
            const textEl = document.getElementById('tukangpro-toast-text');
            if (!toast || !iconEl || !textEl) return;
            iconEl.textContent = icon;
            textEl.textContent = message;
            toast.classList.remove('hidden');
            toast.classList.add('flex');
            clearTimeout(window.__tukangToastTimer);
            window.__tukangToastTimer = setTimeout(() => {
                toast.classList.add('hidden');
                toast.classList.remove('flex');
            }, 4500);
        };
        window.openModal = function(id) {
            const el = document.getElementById(id);
            if (el) { el.classList.remove('hidden'); el.classList.add('flex'); }
        };
        window.closeModal = function(id) {
            const el = document.getElementById(id);
            if (el) { el.classList.add('hidden'); el.classList.remove('flex'); }
        };
        @if (session('toast_message'))
            setTimeout(() => {
                const toast = document.getElementById('tukangpro-toast');
                if (toast) { toast.classList.add('hidden'); toast.classList.remove('flex'); }
            }, 5000);
        @endif
    </script>
    @stack('scripts')
</body>
</html>