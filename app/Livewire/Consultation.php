<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

#[Layout('layouts.app')]
class Consultation extends Component
{
    public $messages = [];
    public $newMessage = '';
    public $isTyping = false;
    public $petType = 'pet';
    public $petAge = '';
    public $petSymptoms = '';

    public function render()
    {
        return view('livewire.consultation');
    }

    public function sendMessage()
    {
        if (empty($this->newMessage)) return;

        // Tambahkan pesan pengguna
        $this->messages[] = [
            'role' => 'user',
            'content' => $this->newMessage,
            'timestamp' => now()->format('H:i')
        ];

        $userMessage = $this->newMessage;
        $this->newMessage = '';
        $this->isTyping = true;

        // Kirim ke Gemini AI
        $this->getGeminiResponse($userMessage);
    }

    private function getGeminiResponse($userMessage)
    {
        try {
            // Debug: Cek API key
            $apiKey = config('services.gemini.api_key');
            if (empty($apiKey)) {
                throw new \Exception('API Key tidak ditemukan. Pastikan GEMINI_API_KEY sudah diset di file .env');
            }

            // Konteks untuk Gemini
            $petTypeMap = [
                'dog' => 'anjing',
                'cat' => 'kucing',
                'bird' => 'burung',
                'rabbit' => 'kelinci',
                'other' => 'hewan lainnya'
            ];

            $petTypeName = $petTypeMap[$this->petType] ?? 'hewan peliharaan';

            $prompt = "Anda adalah asisten dokter hewan. Hewan: {$petTypeName}";
            if (!empty($this->petAge)) {
                $prompt .= ", usia: {$this->petAge}";
            }
            if (!empty($this->petSymptoms)) {
                $prompt .= ", gejala: {$this->petSymptoms}";
            }
            $prompt .= ". Jawab dalam bahasa Indonesia.\n\nPertanyaan: " . $userMessage;

            // Payload sederhana
            $payload = [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ]
            ];

            // URL API - gunakan model yang benar
            $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=' . $apiKey;

            // Panggil API dengan timeout yang lebih panjang
            $response = Http::timeout(60)
                ->retry(2, 1000)
                ->post($url, $payload);

            if ($response->successful()) {
                $data = $response->json();

                if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                    $responseText = $data['candidates'][0]['content']['parts'][0]['text'];

                    $this->messages[] = [
                        'role' => 'assistant',
                        'content' => $responseText,
                        'timestamp' => now()->format('H:i')
                    ];
                } else {
                    // Coba akses error dari response
                    if (isset($data['error'])) {
                        throw new \Exception('API Error: ' . $data['error']['message']);
                    } else {
                        throw new \Exception('Format response tidak valid: ' . json_encode($data));
                    }
                }
            } else {
                $errorBody = $response->body();
                throw new \Exception('HTTP ' . $response->status() . ': ' . $errorBody);
            }

        } catch (\Exception $e) {
            // Log error tanpa \Log untuk menghindari konflik
            error_log('Gemini API Error: ' . $e->getMessage());

            // Tampilkan error untuk debugging (nanti hapus di production)
            $this->messages[] = [
                'role' => 'assistant',
                'content' => 'DEBUG - Error: ' . $e->getMessage(),
                'timestamp' => now()->format('H:i')
            ];
        }

        $this->isTyping = false;
    }

    public function startNewConsultation()
    {
        $this->messages = [];
        $this->petType = 'pet';
        $this->petAge = '';
        $this->petSymptoms = '';
    }
}
