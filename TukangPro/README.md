import React from 'react';

export const HowItWorksSection: React.FC = () => {
  const steps = [
    { num: '01', title: 'Pilih Layanan & Lokasi', desc: 'Pilih spesialisasi teknisi sesuai kebutuhan Anda.' },
    { num: '02', title: 'Pantau via Radar GPS', desc: 'Lacak posisi teknisi yang sedang meluncur secara real-time.' },
    { num: '03', title: 'Uji Hasil Kerja & BAST', desc: 'Periksa hasil perbaikan bersama teknisi sebelum selesai.' },
    { num: '04', title: 'Rilis Dana Escrow', desc: 'Uang pembayaran hanya dicairkan jika Anda sudah puas.' },
  ];

  return (
    <section className="py-16 bg-[#f1f3ff]" id="cara-kerja">
      <div className="max-w-7xl mx-auto px-4 sm:px-6">
        <div className="text-center max-w-xl mx-auto mb-12">
          <span className="text-xs font-bold uppercase text-[#0d5be1]">Transparan & Aman</span>
          <h2 className="text-2xl sm:text-3xl font-extrabold text-[#0045b2] mt-1">4 Langkah Mudah Pemesanan</h2>
        </div>

        {/* Alur 4 Langkah */}
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-16">
          {steps.map((step, idx) => (
            <div key={idx} className="bg-white p-6 rounded-xl border border-gray-200 relative">
              <span className="text-3xl font-black text-[#0d5be1]/20 absolute top-4 right-4">{step.num}</span>
              <h3 className="font-bold text-gray-900 text-base mb-2">{step.title}</h3>
              <p className="text-xs text-gray-500 leading-relaxed">{step.desc}</p>
            </div>
          ))}
        </div>

        {/* Kartu Testimoni */}
        <div className="bg-white p-8 rounded-2xl border border-gray-200 flex flex-col md:flex-row gap-6 items-center">
          <div className="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center shrink-0">
            <span className="material-symbols-outlined text-3xl text-[#0045b2]">format_quote</span>
          </div>
          <div>
            <p className="text-sm italic text-gray-700">
              "AC kantor mati saat jam kerja, panggil teknisi TukangPro lewat fitur darurat, 20 menit kemudian teknisi sudah sampai dan langsung selesai. Sistem rekening escrow-nya bikin tenang!"
            </p>
            <span className="text-xs font-bold text-gray-900 block mt-2">Budi Santoso — Jakarta Selatan (Rating ★★★★★)</span>
          </div>
        </div>
      </div>
    </section>
  );
};
