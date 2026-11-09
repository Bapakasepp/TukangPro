<?php

namespace Database\Seeders;

use App\Models\ServiceCategory;
use App\Models\ServiceOrder;
use App\Models\Technician;
use Illuminate\Database\Seeder;

class ServiceOrderSeeder extends Seeder
{
    public function run(): void
    {
        $catListrik = ServiceCategory::where('slug', 'srv-listrik')->first();
        $catAc = ServiceCategory::where('slug', 'srv-ac')->first();
        $catPlumbing = ServiceCategory::where('slug', 'srv-plumbing')->first();

        $tech1 = Technician::where('code', 'tech-1')->first();
        $tech2 = Technician::where('code', 'tech-2')->first();
        $tech3 = Technician::where('code', 'tech-3')->first();

        $orders = [
            [
                'order_code' => 'WO-2026-X79A',
                'customer_name' => 'Saiful Haq',
                'customer_phone' => '+62 812-3456-7890',
                'service_address' => 'Jl. Senopati No. 42, Kebayoran Baru, Jakarta Selatan',
                'service_category_id' => $catListrik?->id,
                'category_name' => 'Listrik & Kelistrikan Arus Kuat',
                'technician_id' => $tech1?->id,
                'status' => 'ON_THE_WAY',
                'is_emergency' => true,
                'scheduled_arrival_at' => '14:26 WIB',
                'issue_description' => 'MCB rumah sering jepret saat AC dan microwave dinyalakan bersamaan, tercium sedikit bau sangit di panel induk.',
                'photos_url' => ['https://images.unsplash.com/photo-1621905251189-08b45d6a269e?auto=format&fit=crop&w=800&q=80'],
                'base_fee' => 75000,
                'diagnostic_fee' => 80000,
                'spareparts_fee' => 0,
                'emergency_fee' => 25000,
                'total_amount' => 180000,
                'escrow_status' => 'HELD',
                'eta_minutes' => 8,
                'speed_kmh' => 34,
                'warranty_valid_until' => '30 Hari Setelah BAST Ditandatangani',
                'ordered_label' => 'Hari Ini, 14:05 WIB',
            ],
            [
                'order_code' => 'WO-2026-C48M',
                'customer_name' => 'Nadia Kusuma',
                'customer_phone' => '+62 813-8899-1122',
                'service_address' => 'Jl. Kemang Raya No. 18, Mampang, Jakarta Selatan',
                'service_category_id' => $catAc?->id,
                'category_name' => 'Servis AC & Perawatan Freon',
                'technician_id' => $tech2?->id,
                'status' => 'COMPLETED',
                'is_emergency' => false,
                'scheduled_arrival_at' => '10:30 WIB',
                'issue_description' => 'Cuci steam 2 unit AC Split 1 PK Daikin + tambah tekanan freon R32 ruang kerja utama.',
                'photos_url' => [$catAc?->image_url],
                'base_fee' => 65000,
                'diagnostic_fee' => 50000,
                'spareparts_fee' => 0,
                'emergency_fee' => 0,
                'total_amount' => 115000,
                'escrow_status' => 'RELEASED',
                'eta_minutes' => 0,
                'speed_kmh' => 0,
                'warranty_valid_until' => 'Aktif 30 Hari (BAST Terverifikasi)',
                'ordered_label' => 'Hari Ini, 09:45 WIB',
            ],
            [
                'order_code' => 'WO-2026-P19Q',
                'customer_name' => 'Hendra Gunawan',
                'customer_phone' => '+62 856-3344-5566',
                'service_address' => 'Jl. Dago Asri II No. 9, Coblong, Kota Bandung',
                'service_category_id' => $catPlumbing?->id,
                'category_name' => 'Plumbing & Saluran Pipa',
                'technician_id' => $tech3?->id,
                'status' => 'PENDING',
                'is_emergency' => false,
                'scheduled_arrival_at' => 'Besok, 09:00 WIB',
                'issue_description' => 'Saluran pembuangan kitchen sink mampet total dan kran mixer air panas bocor halus.',
                'photos_url' => [$catPlumbing?->image_url],
                'base_fee' => 90000,
                'diagnostic_fee' => 25000,
                'spareparts_fee' => 0,
                'emergency_fee' => 0,
                'total_amount' => 115000,
                'escrow_status' => 'HELD',
                'eta_minutes' => 15,
                'speed_kmh' => 28,
                'warranty_valid_until' => '30 Hari Setelah BAST Ditandatangani',
                'ordered_label' => 'Hari Ini, 13:20 WIB',
            ],
        ];

        foreach ($orders as $order) {
            ServiceOrder::updateOrCreate(['order_code' => $order['order_code']], $order);
        }
    }
}