<?php
require 'vendor/autoload.php'; // Pastikan SimpleXLSXGen sudah terinstal

use Shuchkin\SimpleXLSXGen;

// Ambil data JSON dari request
$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    // Buat array untuk data Excel
    $excelData = [
        ['Field 1', 'Field 2'], // Header
        [$data['field1'], $data['field2']] // Data dari form
    ];

    // Buat file Excel
    $fileName = 'APAR_Checklist_' . date('Y-m-d_H-i-s') . '.xlsx';
    $filePath = __DIR__ . '/excel/' . $fileName; // Simpan di folder "excel"

    // Pastikan folder "excel" ada
    if (!is_dir(__DIR__ . '/excel')) {
        mkdir(__DIR__ . '/excel', 0777, true);
    }

    // Simpan file Excel
    SimpleXLSXGen::fromArray($excelData)->saveAs($filePath);

    // Kirim response dengan link ke file
    echo json_encode([
        'success' => true,
        'fileUrl' => "http://MalioApar.vercel.app/excel/Pengecekan APAR.xlsx" // Ganti dengan domain Anda
    ]);
} else {
    echo json_encode(['success' => false]);
}
?>
