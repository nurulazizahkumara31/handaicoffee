<?php
 
// fungsi untuk mengembalikan format rupiah dari suatu nominal tertentu
// dengan pemisah ribuan 
function rupiah($angka)
{
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

function dolar($nominal) {
    return "USD ".number_format($nominal);
}