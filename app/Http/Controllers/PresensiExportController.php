<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presensi;
use Barryvdh\DomPDF\Facade\Pdf;

class PresensiExportController extends Controller
{
    public function exportPdf()
{
    $presensis = Presensi::with('pegawai')->get(); // Ambil data presensi lengkap dengan relasi pegawai

    $pdf = Pdf::loadView('exports.presensi-pdf', compact('presensis')); // Kirim ke view
    return $pdf->download('data-presensi.pdf');
}
}
