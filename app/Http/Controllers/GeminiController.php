<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiController extends Controller
{
    public function chat(Request $request)
    {
        $userMessage = $request->input('message');

        $apiKey = env('GEMINI_API_KEY');
        $url = "https://generativelanguage.googleapis.com/v1/models/gemini-1.5-flash:generateContent?key=AIzaSyDOJk38nIMggC8MPVihJr-hnHoSCr3vwvY";

        $prompt = "Kamu adalah chatbot ramah bernama Handai dari Handai Coffee. Tugasmu adalah menjawab pertanyaan pelanggan tentang kopi, seperti:
- Jenis-jenis kopi (arabika, robusta, liberika)
- Metode seduh (cold brew, V60, espresso)
- Rasa, kafein, atau manfaat kopi
- Info umum tentang menu dan cara pemesanan
- Oh ya, di handai coffee adai 4 product, ada Kopi Susu Gula Aren (untuk pencinta manis berpadu pahit, cocok buat nemenin nugas), lalu ada susu kurma (ini paling best seller, pecinta susu sama kurma, cocok buat sarapan dan di segala waktu), lalu ada matcha (ini produk baru, pecinta matcha wajib coba ini), lalu ada kopi amerikano (ini cocok buat kamu kalau mau begadang, biar ga ngantuk, pahitnya cocok dilidah ga yang pahit banget)
- Handai coffe juga menerima delivery dan ambil di tempat, kalau ambil di tempat bisa ambil di Masjid Syamsul Ulum, Telkom University.
- Kalau kepo sama media sosial handaicoffee, bisa cek dan follow IG @handaicoffee, atau kamu bisa langsung masuk menu Contact
- Pembayarannya bisa pake apapun, tenang ajaa
- Handai coffee adalah salah satu start up mahasiswa Telkom University yaitu Muhammad Hanif Suryana. disini tersedia Coffee & Non Coffee Bottle
Minuman Kekinian yang Rendah Indeks Glikemik!
Berikan jawaban singkat, jelas, dan ramah.

Pertanyaan: $userMessage";

        // Logging prompt yang dikirim
        Log::info('Gemini prompt:', ['prompt' => $prompt]);

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post($url, [
            'contents' => [
                [
                    'role' => 'user',
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ]
        ]);
              

        // Logging raw response dari Gemini
        Log::info('Gemini raw response:', ['body' => $response->body()]);

        if ($response->failed()) {
            return response()->json([
                'reply' => 'Gagal ambil respon dari Gemini.',
                'status' => $response->status(),
                'error' => $response->body(),
            ], 500);
        }
        $data = $response->json();
        $reply = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Maaf, saya tidak bisa menjawab itu.';

        return response()->json(['reply' => $reply]);
    }
}
