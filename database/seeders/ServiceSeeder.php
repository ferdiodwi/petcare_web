<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $services = [
            [
                'name' => 'Basic Grooming Package',
                'description' => 'Paket grooming dasar yang mencakup mandi, sisir bulu, potong kuku, dan pembersihan telinga untuk menjaga kebersihan hewan peliharaan Anda.',
                'category' => 'grooming',
                'price' => 150000,
                'duration' => 90,
                'is_active' => true,
                'features' => [
                    'Mandi dengan shampoo khusus',
                    'Penyisiran dan penyikatan bulu',
                    'Pemotongan kuku',
                    'Pembersihan telinga',
                    'Blow dry'
                ]
            ],
            [
                'name' => 'Premium Grooming Package',
                'description' => 'Paket grooming premium dengan layanan lengkap termasuk spa treatment dan aromaterapi untuk pengalaman grooming yang mewah.',
                'category' => 'grooming',
                'price' => 300000,
                'duration' => 150,
                'is_active' => true,
                'features' => [
                    'Semua layanan basic grooming',
                    'Spa treatment',
                    'Aromaterapi',
                    'Pemotongan bulu stylish',
                    'Pewangi khusus hewan',
                    'Foto dokumentasi'
                ]
            ],
            [
                'name' => 'Konsultasi Dokter Hewan',
                'description' => 'Konsultasi kesehatan menyeluruh dengan dokter hewan berpengalaman untuk memastikan kesehatan optimal hewan peliharaan Anda.',
                'category' => 'medical',
                'price' => 200000,
                'duration' => 60,
                'is_active' => true,
                'features' => [
                    'Pemeriksaan fisik lengkap',
                    'Konsultasi kesehatan',
                    'Rekomendasi perawatan',
                    'Resep obat jika diperlukan',
                    'Kartu kesehatan'
                ]
            ],
            [
                'name' => 'Vaksinasi Lengkap',
                'description' => 'Program vaksinasi lengkap sesuai jadwal dan usia hewan peliharaan dengan vaksin berkualitas tinggi.',
                'category' => 'medical',
                'price' => 350000,
                'duration' => 45,
                'is_active' => true,
                'features' => [
                    'Vaksin dasar lengkap',
                    'Pemeriksaan kesehatan',
                    'Sertifikat vaksinasi',
                    'Jadwal vaksinasi lanjutan',
                    'Konsultasi gratis'
                ]
            ],
            [
                'name' => 'Pet Hotel - Daily Boarding',
                'description' => 'Layanan penitipan harian dengan fasilitas nyaman dan perawatan terbaik saat Anda tidak dapat merawat hewan peliharaan.',
                'category' => 'boarding',
                'price' => 100000,
                'duration' => 1440, // 24 jam dalam menit
                'is_active' => true,
                'features' => [
                    'Kandang bersih dan nyaman',
                    'Makanan sesuai kebutuhan',
                    'Aktivitas bermain',
                    'Monitoring kesehatan',
                    'Update foto harian'
                ]
            ],
            [
                'name' => 'Basic Training Package',
                'description' => 'Pelatihan dasar untuk mengajarkan perilaku dan kebiasaan baik pada hewan peliharaan Anda.',
                'category' => 'training',
                'price' => 500000,
                'duration' => 300, // 5 jam
                'is_active' => true,
                'features' => [
                    'Pelatihan toilet training',
                    'Pelatihan basic commands',
                    'Sosialisasi',
                    'Panduan perawatan',
                    'Sesi follow-up'
                ]
            ],
            [
                'name' => 'Emergency Care 24/7',
                'description' => 'Layanan gawat darurat 24 jam untuk menangani kondisi urgent hewan peliharaan Anda.',
                'category' => 'emergency',
                'price' => 500000,
                'duration' => 120,
                'is_active' => true,
                'features' => [
                    'Penanganan emergency',
                    'Pertolongan pertama',
                    'Observasi intensif',
                    'Konsultasi dokter',
                    'Rawat inap jika perlu'
                ]
            ],
            [
                'name' => 'Konsultasi Online',
                'description' => 'Konsultasi kesehatan hewan secara online dengan dokter hewan berpengalaman melalui video call.',
                'category' => 'consultation',
                'price' => 75000,
                'duration' => 30,
                'is_active' => true,
                'features' => [
                    'Video call dengan dokter',
                    'Konsultasi kesehatan',
                    'Tips perawatan',
                    'Rekomendasi produk',
                    'Follow-up chat'
                ]
            ],
            [
                'name' => 'Dental Care Package',
                'description' => 'Perawatan gigi dan mulut profesional untuk menjaga kesehatan dental hewan peliharaan Anda.',
                'category' => 'medical',
                'price' => 400000,
                'duration' => 90,
                'is_active' => true,
                'features' => [
                    'Pembersihan karang gigi',
                    'Scaling gigi',
                    'Pemeriksaan mulut',
                    'Konsultasi dental',
                    'Produk perawatan gigi'
                ]
            ],
            [
                'name' => 'Full Body Check-up',
                'description' => 'Pemeriksaan kesehatan menyeluruh dengan teknologi modern untuk deteksi dini masalah kesehatan.',
                'category' => 'medical',
                'price' => 800000,
                'duration' => 180,
                'is_active' => true,
                'features' => [
                    'Pemeriksaan fisik lengkap',
                    'Tes darah lengkap',
                    'X-Ray jika diperlukan',
                    'USG abdomen',
                    'Laporan kesehatan detail',
                    'Konsultasi hasil'
                ]
            ]
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
