<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class NewsController extends Controller
{
    public function index()
    {
        $apiKey = '16453d31e7bd41f098d29caa96535fae';
        $response = Http::get('https://newsapi.org/v2/everything', [
            'q' => 'coffee',
            'language' => 'id',
            'sortBy' => 'publishedAt',
            'apiKey' => $apiKey,
        ]);

        return $response->json();
    }
}
