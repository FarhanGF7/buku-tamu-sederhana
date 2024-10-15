<?php
require '../assets/vendor/autoload.php'; // Memuat PhpSpreadsheet
require '../database/koneksi.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (isset($_POST['bexport'])) {
    // Buat objek Spreadsheet baru
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Set header kolom
    $sheet->setCellValue('A1', 'No.');
    $sheet->setCellValue('B1', 'Tanggal');
    $sheet->setCellValue('C1', 'Nama Pengunjung');
    $sheet->setCellValue('D1', 'Alamat');
    $sheet->setCellValue('E1', 'Tujuan');
    $sheet->setCellValue('F1', 'No. HP');

    // Set header teks menjadi tebal
    $sheet->getStyle('A1:F1')->getFont()->setBold(true);

    // Set border untuk header
    $styleArray = [
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['argb' => 'FF000000'],
            ],
        ],
    ];
    $sheet->getStyle('A1:F1')->applyFromArray($styleArray);

    // Ambil data dari database tanpa filter tanggal
    $tampil = mysqli_query($koneksi, "SELECT * FROM ttamu ORDER BY DATE(tanggal) ASC");

    // Set lebar kolom otomatis
    foreach (range('A', 'F') as $columnID) {
        $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }

    $row = 2; // Mulai dari baris kedua
    $no = 1;
    while ($data = mysqli_fetch_array($tampil)) {
        $sheet->setCellValue('A' . $row, $no++);
        $sheet->setCellValue('B' . $row, $data['tanggal']);
        $sheet->setCellValue('C' . $row, $data['nama']);
        $sheet->setCellValue('D' . $row, $data['alamat']);
        $sheet->setCellValue('E' . $row, $data['tujuan']);
        $sheet->setCellValue('F' . $row, $data['nope']);
        // Check if 'nope' starts with 0 and store as text
        $noHp = $data['nope'];
        if (strpos($noHp, '0') === 0) {
            $sheet->setCellValueExplicit('F' . $row, "'" . $noHp, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        } else {
            $sheet->setCellValue('F' . $row, $noHp);
        }
        $row++;
    }

    // Set border untuk data
    $sheet->getStyle('A2:F' . ($row - 1))->applyFromArray($styleArray);

    // Set nama file dan simpan file
    $writer = new Xlsx($spreadsheet);
    $filename = 'Rekapitulasi_Pengunjung_Seluruh_' . date('Y-m-d') . '.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer->save('php://output');
    exit();
}
?>
