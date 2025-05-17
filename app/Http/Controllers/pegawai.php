<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class pegawai extends Controller
{
    public function exportPdf()
{
    $presensis = Presensi::with('pegawai')->get(); // relasi 'pegawai'

    $pdf = Pdf::loadView('exports.presensi-pdf', compact('presensis'));
    return $pdf->download('data-presensi.pdf');
}
    // App\Models\Presensi.php
    public function pegawai()
    {
    return $this->belongsTo(Pegawai::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

