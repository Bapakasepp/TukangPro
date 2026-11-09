<?php

namespace Database\Seeders;

use App\Models\BroadcastLog;
use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $reviews = [
            [
                'customer_name' => 'Rina Sasmita',
                'customer_location' => 'Pondok Indah, Jakarta Selatan',
                'customer_avatar' => 'https://ui-avatars.com/api/?name=Rina+Sasmita&background=0284c7&color=fff&size=150',
                'rating' => 5,
                'review_comment' => 'Pukul 22.00 malam MCB rumah korslet dan berasap. Pesan lewat TukangPro, jam 22.25 teknisi Mas Budi sudah sampai dengan tester lengkap. Pengerjaan rapi, sopan, dan harga sesuai aplikasi tanpa pungli!',
                'verified' => true,
            ],
            [
                'customer_name' => 'Deni Firmansyah',
                'customer_location' => 'General Affair PT Integra Media',
                'customer_avatar' => 'https://ui-avatars.com/api/?name=Deni+Firmansyah&background=0f766e&color=fff&size=150',
                'rating' => 5,
                'review_comment' => 'AC kantor bocor parah di ruang meeting direksi. Tim TukangPro datang bawa vakum drainase dan plastik penampung air higienis. Karpet ruangan sama sekali tidak kotor. Sangat profesional.',
                'verified' => true,
            ],
            [
                'customer_name' => 'Hj. Nurul Aini',
                'customer_location' => 'Buah Batu, Bandung',
                'customer_avatar' => 'https://ui-avatars.com/api/?name=Nurul+Aini&background=4338ca&color=fff&size=150',
                'rating' => 5,
                'review_comment' => 'Paling suka dengan sistem jaminan garansinya. Waktu perbaikan pipa wastafel seminggu kemudian ada rembes kecil, saya klaim lewat aplikasi, teknisi datang lagi keesokan harinya gratis!',
                'verified' => true,
            ],
        ];

        foreach ($reviews as $rev) {
            Review::updateOrCreate(['customer_name' => $rev['customer_name']], $rev);
        }

        BroadcastLog::updateOrCreate(
            ['message' => 'Siaga cuaca sore Jabodetabek & Bandung: pastikan APD sepatu isolasi 1000V digunakan pada seluruh order kelistrikan luar ruang.'],
            [
                'sender_name' => 'Supervisor NOC Shift Siang',
                'target_count' => 5,
                'priority' => 'HIGH',
            ]
        );
    }
}