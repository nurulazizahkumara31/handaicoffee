<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        return view('about'); // ini akan memanggil resources/views/about.blade.php
    }
    public function contact()
    {
        return view('contact');
    }

}

