<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
#[Layout('layouts.app')]
class ServicesList extends Component
{
    public $selectedService = null;
    public $services = [];

    public function mount()
    {
        $this->services = [
            'grooming' => [
                'id' => 'grooming',
                'title' => 'Grooming Professional',
                'short_description' => 'Layanan grooming lengkap dengan produk alami untuk menjaga hewan peliharaan Anda bersih dan sehat.',
                'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',
                'image' => 'images/grooming.jpg',
                'price_range' => 'Mulai dari Rp 50.000',
                'duration' => '1-2 jam',
                'description' => 'Layanan grooming profesional kami memberikan perawatan menyeluruh untuk hewan peliharaan Anda. Dengan menggunakan produk-produk berkualitas tinggi dan teknik grooming terdepan.',
                'features' => [
                    'Mandi dengan shampo khusus sesuai jenis kulit',
                    'Pemotongan kuku dan pembersihan telinga',
                    'Styling dan trimming bulu profesional',
                    'Pembersihan gigi dan mulut',
                    'Aromaterapi untuk relaksasi',
                    'Konsultasi perawatan kulit dan bulu'
                ],
                'packages' => [
                    [
                        'name' => 'Basic Grooming',
                        'price' => 'Rp 50.000',
                        'includes' => ['Mandi', 'Pengeringan', 'Pemotongan kuku']
                    ],
                    [
                        'name' => 'Premium Grooming',
                        'price' => 'Rp 100.000',
                        'includes' => ['Basic package', 'Trimming bulu', 'Pembersihan telinga', 'Aromaterapi']
                    ],
                    [
                        'name' => 'Luxury Grooming',
                        'price' => 'Rp 150.000',
                        'includes' => ['Premium package', 'Styling khusus', 'Pembersihan gigi', 'Foto profesional']
                    ]
                ]
            ],
            'boarding' => [
                'id' => 'boarding',
                'title' => 'Pet Boarding',
                'short_description' => 'Fasilitas penitipan premium dengan pengawasan 24 jam dan area bermain yang luas.',
                'icon' => 'M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z',
                'image' => 'images/boarding.jpg',
                'price_range' => 'Mulai dari Rp 75.000/hari',
                'duration' => 'Harian / Mingguan',
                'description' => 'Fasilitas boarding kami menyediakan tempat tinggal sementara yang nyaman dan aman untuk hewan peliharaan Anda. Dengan pengawasan 24 jam dan lingkungan yang ramah.',
                'features' => [
                    'Kamar ber-AC dengan tempat tidur nyaman',
                    'Area bermain indoor dan outdoor',
                    'Makanan berkualitas tinggi 3x sehari',
                    'Pengawasan medis 24 jam',
                    'Aktivitas bermain dan sosialisasi',
                    'Update harian via foto dan video'
                ],
                'packages' => [
                    [
                        'name' => 'Standard Boarding',
                        'price' => 'Rp 75.000/hari',
                        'includes' => ['Kamar standar', 'Makanan 3x', 'Pengawasan basic']
                    ],
                    [
                        'name' => 'Deluxe Boarding',
                        'price' => 'Rp 125.000/hari',
                        'includes' => ['Kamar deluxe', 'Makanan premium', 'Aktivitas bermain', 'Grooming mingguan']
                    ],
                    [
                        'name' => 'VIP Boarding',
                        'price' => 'Rp 200.000/hari',
                        'includes' => ['Suite VIP', 'Menu khusus', 'Personal caregiver', 'Daily updates', 'Spa treatment']
                    ]
                ]
            ]
        ];
    }

    public function selectService($serviceId)
    {
        $this->selectedService = $serviceId;
    }

    public function closeDetail()
    {
        $this->selectedService = null;
    }

    public function render()
    {
        return view('livewire.services-list');
    }
}
