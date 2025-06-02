<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
#[Layout('layouts.app')]

class About extends Component
{
    public $teamMembers = [];
    public $stats = [];
    public $values = [];
    public $milestones = [];

    public function mount()
    {
        $this->stats = [
            [
                'number' => '2000+',
                'label' => 'Hewan yang Dirawat',
                'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'
            ],
            [
                'number' => '500+',
                'label' => 'Klien Puas',
                'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'
            ],
            [
                'number' => '8+',
                'label' => 'Tahun Pengalaman',
                'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'
            ],
            [
                'number' => '24/7',
                'label' => 'Layanan Darurat',
                'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'
            ]
        ];

        $this->values = [
            [
                'title' => 'Profesionalisme',
                'description' => 'Kami berkomitmen memberikan layanan berkualitas tinggi dengan standar profesional yang ketat.',
                'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'
            ],
            [
                'title' => 'Kasih Sayang',
                'description' => 'Setiap hewan peliharaan diperlakukan dengan penuh kasih sayang seperti keluarga sendiri.',
                'icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z'
            ],
            [
                'title' => 'Kepercayaan',
                'description' => 'Membangun hubungan jangka panjang berdasarkan kepercayaan dan transparansi.',
                'icon' => 'M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z'
            ],
            [
                'title' => 'Inovasi',
                'description' => 'Selalu mengadopsi teknologi dan metode terbaru untuk perawatan yang optimal.',
                'icon' => 'M13 10V3L4 14h7v7l9-11h-7z'
            ]
        ];

        $this->teamMembers = [
            [
                'name' => 'Dr. Sarah Veterina',
                'position' => 'Dokter Hewan Senior',
                'specialization' => 'Spesialis Bedah & Internal Medicine',
                'experience' => '12 tahun',
                'image' => 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
                'description' => 'Lulusan terbaik Fakultas Kedokteran Hewan IPB dengan pengalaman luas dalam penanganan kasus kompleks.'
            ],
            [
                'name' => 'Michael Groomer',
                'position' => 'Head Groomer',
                'specialization' => 'Master Groomer Bersertifikat',
                'experience' => '8 tahun',
                'image' => 'https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
                'description' => 'Ahli grooming bersertifikat internasional dengan keahlian khusus untuk berbagai ras anjing dan kucing.'
            ],
            [
                'name' => 'Lisa Caregiver',
                'position' => 'Senior Animal Caregiver',
                'specialization' => 'Perawatan Hewan & Boarding',
                'experience' => '6 tahun',
                'image' => 'https://images.unsplash.com/photo-1594824388538-c516067f7b04?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
                'description' => 'Berpengalaman dalam perawatan harian dan boarding dengan pendekatan yang penuh kasih sayang.'
            ],
            [
                'name' => 'David Manager',
                'position' => 'Operations Manager',
                'specialization' => 'Manajemen Operasional',
                'experience' => '10 tahun',
                'image' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
                'description' => 'Memastikan semua operasional berjalan lancar dan standar kualitas terjaga dengan baik.'
            ]
        ];

        $this->milestones = [
            [
                'year' => '2016',
                'title' => 'Pendirian PetCare',
                'description' => 'Memulai dengan klinik kecil dan komitmen besar untuk hewan peliharaan'
            ],
            [
                'year' => '2018',
                'title' => 'Ekspansi Layanan',
                'description' => 'Menambahkan layanan grooming dan boarding profesional'
            ],
            [
                'year' => '2020',
                'title' => 'Sertifikasi Internasional',
                'description' => 'Mendapatkan sertifikasi standar internasional untuk layanan pet care'
            ],
            [
                'year' => '2022',
                'title' => 'Fasilitas Baru',
                'description' => 'Membuka fasilitas modern dengan teknologi terdepan'
            ],
            [
                'year' => '2024',
                'title' => 'Digital Innovation',
                'description' => 'Meluncurkan aplikasi mobile dan sistem booking online'
            ]
        ];
    }

    public function render()
    {
        return view('livewire.about');
    }
}
