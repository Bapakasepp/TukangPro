{{-- Komponen Formulir Booking Teknisi 3 Langkah & Proteksi Escrow --}}
<div id="booking-form-card" class="bg-white rounded-3xl p-6 shadow-md border border-[#dce2f7] sticky top-28 space-y-4">
    <div class="flex items-center justify-between border-b border-[#dce2f7] pb-3">
        <div>
            <span class="text-[11px] font-bold uppercase tracking-wider text-[#0045b2]">FORMULIR PEMESANAN 3 LANGKAH</span>
            <h3 class="font-extrabold text-lg text-[#141b2b]">Kunci Jadwal &amp; Rekening Escrow</h3>
        </div>
        <span class="material-symbols-outlined text-2xl text-[#00744f]">verified_user</span>
    </div>

    @if ($selectedTech)
        <div class="p-3.5 rounded-2xl bg-[#f1f3ff] flex items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <img src="{{ $selectedTech->avatar_url }}" alt="" class="w-11 h-11 rounded-xl object-cover">
                <div>
                    <div id="booking-tech-name" class="font-bold text-sm text-[#141b2b]">{{ $selectedTech->full_name }}</div>
                    <div class="text-[11px] text-[#00593c] font-semibold">{{ $selectedTech->certification_level }}</div>
                </div>
            </div>
            <div class="text-right">
                <span class="text-[10px] text-[#424654] block">Tarif Dasar</span>
                <strong id="booking-tech-fee" class="text-sm font-extrabold text-[#0045b2]">Rp {{ number_format($selectedTech->base_fee, 0, ',', '.') }}</strong>
            </div>
        </div>

        <form method="POST" action="{{ route('orders.store') }}" class="space-y-3">
            @csrf
            <input type="hidden" name="technician_id" id="booking-tech-id" value="{{ $selectedTech->id }}">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="text-xs font-bold text-[#424654] block mb-1">1. Nama Pelanggan</label>
                    <input type="text" name="customer_name" required placeholder="Nama lengkap Anda"
                           class="w-full p-2.5 rounded-xl bg-[#f1f3ff] text-xs sm:text-sm text-[#141b2b]">
                </div>
                <div>
                    <label class="text-xs font-bold text-[#424654] block mb-1">No. WhatsApp Aktif</label>
                    <input type="text" name="customer_phone" required placeholder="0812xxxxxxxx"
                           class="w-full p-2.5 rounded-xl bg-[#f1f3ff] text-xs sm:text-sm text-[#141b2b]">
                </div>
            </div>

            <div>
                <label class="text-xs font-bold text-[#424654] block mb-1">2. Alamat Lengkap Lokasi Servis</label>
                <input type="text" name="service_address" required placeholder="Nama jalan, nomor rumah, patokan..."
                       class="w-full p-2.5 rounded-xl bg-[#f1f3ff] text-xs sm:text-sm text-[#141b2b]">
            </div>

            <div>
                <label class="text-xs font-bold text-[#424654] block mb-1">3. Detail Keluhan Kerusakan</label>
                <textarea name="issue_description" rows="3" required minlength="5"
                          placeholder="Jelaskan gejala kerusakan (contoh: MCB sering turun saat malam, pipa wastafel rembes)..."
                          class="w-full p-2.5 rounded-xl bg-[#f1f3ff] text-xs sm:text-sm text-[#141b2b]"></textarea>
            </div>

            <div>
                <label class="text-xs font-bold text-[#424654] block mb-1">Waktu Penanganan</label>
                <select name="timing" class="w-full p-2.5 rounded-xl bg-[#f1f3ff] text-xs sm:text-sm font-semibold text-[#141b2b]">
                    <option value="now">Panggilan Darurat Sekarang (+Rp 25.000 Biaya Prioritas)</option>
                    <option value="schedule">Terjadwal Besok Pagi (Tanpa Biaya Darurat)</option>
                </select>
            </div>

            <button type="submit" class="w-full py-3.5 rounded-xl bg-[#fc7123] hover:bg-[#a14000] text-white font-extrabold text-sm shadow-md cursor-pointer">
                Konfirmasi Booking &amp; Kunci Dana Escrow
            </button>
        </form>
    @endif
</div>