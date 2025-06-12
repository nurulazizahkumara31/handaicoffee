<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NewsController extends Controller
{
    public function index()
    {
        \Log::info('API News dipanggil');
        $apiKey = '16453d31e7bd41f098d29caa96535fae'; // Ganti dengan API key kamu
        $response = Http::get('https://newsapi.org/v2/everything', [
            'q' => 'coffee',
            'language' => 'id',
            'sortBy' => 'publishedAt',
            'apiKey' => $apiKey,
        ]);

        return $response->json();
    }
}
