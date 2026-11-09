<?php

namespace Database\Seeders;

use App\Models\ServiceCategory;
use Illuminate\Database\Seeder;

class ServiceCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'slug' => 'srv-listrik',
                'category_name' => 'Kelistrikan',
                'title' => 'Instalasi & Korsleting Listrik',
                'description' => 'Penelusuran korsleting, instalasi kabel SNI, peremajaan stop kontak, sakelar, penataan ulang panel MCB 1-3 Phase.',
                'base_price' => 75000,
                'estimated_duration_minutes' => 60,
                'icon' => 'bolt',
                'image_url' => 'https://images.unsplash.com/photo-1621905251189-08b45d6a269e?auto=format&fit=crop&w=800&q=80',
                'active_tech_count' => 42,
                'tag_color' => 'primary',
            ],
            [
                'slug' => 'srv-plumbing',
                'category_name' => 'Plumbing',
                'title' => 'Plumbing & Saluran Pipa',
                'description' => 'Pelancaran pipa got mampet tanpa bongkar, pergantian kran bocor, pemasangan filter air, dan perbaikan toren air bocor.',
                'base_price' => 90000,
                'estimated_duration_minutes' => 60,
                'icon' => 'plumbing',
                'image_url' => 'https://images.unsplash.com/photo-1585704032915-c3400ca199e7?auto=format&fit=crop&w=800&q=80',
                'active_tech_count' => 28,
                'tag_color' => 'secondary',
            ],
            [
                'slug' => 'srv-ac',
                'category_name' => 'HVAC / Pendingin',
                'title' => 'Servis AC & Perawatan Freon',
                'description' => 'Cuci evaporator antibakteri, isi/tambah freon R32, R410, perbaikan kompresor berisik, hingga bongkar pasang unit AC baru.',
                'base_price' => 65000,
                'estimated_duration_minutes' => 60,
                'icon' => 'ac_unit',
                'image_url' => 'https://images.unsplash.com/photo-1581094288338-2314dddb7ece?auto=format&fit=crop&w=800&q=80',
                'active_tech_count' => 53,
                'tag_color' => 'tertiary',
            ],
            [
                'slug' => 'srv-elektronik',
                'category_name' => 'Elektronik',
                'title' => 'Mesin Cuci & Kulkas',
                'description' => 'Perbaikan dinamo pengering mesin cuci front/top loading, kulkas tidak dingin, ganti thermostat, dan modul microwave.',
                'base_price' => 85000,
                'estimated_duration_minutes' => 90,
                'icon' => 'kitchen',
                'image_url' => 'https://images.unsplash.com/photo-1626806787461-102c1bfaaea1?auto=format&fit=crop&w=800&q=80',
                'active_tech_count' => 19,
                'tag_color' => 'primary',
            ],
            [
                'slug' => 'srv-atap',
                'category_name' => 'Pertukangan',
                'title' => 'Pengecatan & Atap Bocor',
                'description' => 'Waterproofing dak beton, ganti genteng bocor, pasang plafon gypsum, pelapisan cat dinding interior dan eksterior rumah.',
                'base_price' => 120000,
                'estimated_duration_minutes' => 120,
                'icon' => 'format_paint',
                'image_url' => 'https://images.unsplash.com/photo-1562259949-e8e7689d7828?auto=format&fit=crop&w=800&q=80',
                'active_tech_count' => 24,
                'tag_color' => 'secondary',
            ],
            [
                'slug' => 'srv-kunci',
                'category_name' => 'Keamanan Pintu',
                'title' => 'Tukang Kunci & Pintu Darurat',
                'description' => 'Duplikasi kunci darurat, perbaikan handle pintu macet, pasang smart door lock digital, serta perbaikan engsel pagar besi.',
                'base_price' => 70000,
                'estimated_duration_minutes' => 45,
                'icon' => 'lock',
                'image_url' => 'https://images.unsplash.com/photo-1558002038-1055907df827?auto=format&fit=crop&w=800&q=80',
                'active_tech_count' => 16,
                'tag_color' => 'tertiary',
            ],
        ];

        foreach ($categories as $item) {
            ServiceCategory::updateOrCreate(['slug' => $item['slug']], $item);
        }
    }
}