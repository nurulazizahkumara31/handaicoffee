<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GeminiController extends Controller
{
    public function chat(Request $request)
    {
        $userMessage = $request->input('message');
        $systemPrompt = "Kamu adalah chatbot ramah dari Handai Coffee. Tugasmu adalah membantu pelanggan tentang jam buka, lokasi, cara pesan, info menu, dan promo.";

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key=" . env('GEMINI_API_KEY'), [
            'contents' => [
                [
                    'role' => 'user',
                    'parts' => [
                        ['text' => "Kamu adalah chatbot ramah dari Handai Coffee. Tugasmu adalah membantu pelanggan tentang jam buka, lokasi, cara pesan, info menu, dan promo."]
                    ]
                ],
                [
                    'role' => 'user',
                    'parts' => [
                        ['text' => $userMessage]
                    ]
                ]
            ]
            
        ]);

        if ($response->failed()) {
            return response()->json(['reply' => 'Maaf, sistem sedang sibuk. Coba lagi nanti.'], 500);
        }

        $data = $response->json();
        $reply = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Maaf, saya tidak bisa menjawab itu.';

        return response()->json(['reply' => $reply]);
    }
}
