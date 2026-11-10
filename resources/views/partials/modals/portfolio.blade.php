<div id="modal-portfolio" class="fixed inset-0 z-50 hidden bg-[#293040]/70 backdrop-blur-sm items-center justify-center p-4">
    <div class="w-full max-w-2xl bg-white rounded-3xl p-6 sm:p-8 shadow-2xl space-y-6 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-3 border-b border-[#dce2f7]">
            <div>
                <h3 id="pf-name" class="text-lg font-extrabold text-[#141b2b]">Portofolio Hasil Kerja Teknisi</h3>
                <p id="pf-meta" class="text-xs font-semibold text-[#00593c]">Sertifikasi BNSP Terverifikasi</p>
            </div>
            <button type="button" onclick="closeModal('modal-portfolio')" class="w-8 h-8 rounded-full hover:bg-[#e9edff] flex items-center justify-center text-[#424654] cursor-pointer">
                <span class="material-symbols-outlined text-xl">close</span>
            </button>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="rounded-2xl overflow-hidden bg-[#f1f3ff] border border-[#dce2f7]">
                <img src="https://images.unsplash.com/photo-1621905251189-08b45d6a269e?w=600&auto=format&fit=crop&q=80"
                     alt="Rewiring Panel MCB" class="w-full h-40 object-cover">
                <div class="p-3.5">
                    <span class="text-xs font-bold text-[#141b2b] block">Peremajaan Panel MCB 3-Phase Standar SNI</span>
                    <span class="text-[11px] text-[#424654]">Lulus Uji Multimeter • Garansi 30 Hari Aktif</span>
                </div>
            </div>
            <div class="rounded-2xl overflow-hidden bg-[#f1f3ff] border border-[#dce2f7]">
                <img src="https://images.unsplash.com/photo-1581094288338-2314dddb7ece?w=600&auto=format&fit=crop&q=80"
                     alt="Servis HVAC & Pipa" class="w-full h-40 object-cover">
                <div class="p-3.5">
                    <span class="text-xs font-bold text-[#141b2b] block">Inspeksi Tekanan &amp; Pembersihan Steril K3</span>
                    <span class="text-[11px] text-[#424654]">BAST Digital Disetujui Pelanggan ★ 5.0</span>
                </div>
            </div>
        </div>

        <div class="pt-2 flex justify-end gap-3">
            <button type="button" onclick="closeModal('modal-portfolio')"
                    class="px-4 py-2.5 rounded-xl bg-[#f1f3ff] text-[#141b2b] text-xs font-semibold cursor-pointer">
                Tutup
            </button>
            <a href="{{ route('technicians.index') }}"
               class="px-5 py-2.5 rounded-xl bg-[#fc7123] hover:bg-[#a14000] text-white text-xs font-bold shadow-md">
                Booking Teknisi Ini
            </a>
        </div>
    </div>
</div>

<script>
    window.openPortfolioModal = function(name, cert) {
        if (typeof name === 'object' && name !== null) {
            document.getElementById('pf-name').textContent = 'Portofolio ' + (name.full_name || 'Teknisi');
            document.getElementById('pf-meta').textContent = name.certification_level || 'BNSP Terverifikasi';
        } else {
            document.getElementById('pf-name').textContent = 'Portofolio ' + (name || 'Teknisi');
            document.getElementById('pf-meta').textContent = cert || 'BNSP Terverifikasi';
        }
        window.openModal('modal-portfolio');
    };
</script>