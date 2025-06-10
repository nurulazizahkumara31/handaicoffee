<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GeminiController extends Controller
{
    <?php

    namespace App\Http\Controllers;
    
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Http;
    
    class GeminiController extends Controller
    {
        public function chat(Request $request)
        {
            $userMessage = $request->input('message');
    
            $apiKey = env('GEMINI_API_KEY');
            $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key=$apiKey";
    
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($url, [
                'contents' => [
                    [
                        'parts' => [
                            [
                                'text' => "Kamu adalah chatbot ramah dari Handai Coffee. Tugasmu adalah membantu pelanggan tentang jam buka, lokasi, cara pesan, info menu, dan promo.\n\nPesan dari pelanggan: $userMessage"
                            ]
                        ]
                    ]
                ]
            ]);
    
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
    


}
