<?php
require $_SERVER['DOCUMENT_ROOT'] . '/RS/include/db.php';
require $_SERVER['DOCUMENT_ROOT'] . '/RS/vendor/setasign/fpdf/fpdf.php';

$id = $_GET['id'] ?? null;
$pasien = id_pasien($id);

if (!$pasien) {
    die("Data pasien tidak ditemukan.");
}

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Helvetica', 'B', 18);
$pdf->SetTextColor(33, 37, 41); 

$pdf->Cell(190, 12, 'Detail Pasien', 0, 1, 'C');
$pdf->Ln(5);
$pdf->SetLineWidth(0.5);
$pdf->SetDrawColor(100, 100, 100);
$pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY()); 
$pdf->Ln(8);

$pdf->SetFont('Helvetica', '', 12);
$pdf->SetFillColor(230, 230, 230); 

$fields = [
    'Nama' => $pasien['nama'],
    'Tanggal Lahir' => $pasien['tanggal_lahir'],
    'Jenis Kelamin' => $pasien['jenis_kelamin'],
    'Agama' => $pasien['agama'],
    'Pendidikan' => $pasien['pendidikan'],
    'Diagnosa' => $pasien['diagnosa']
];

foreach ($fields as $label => $value) {
    $pdf->Cell(50, 10, $label, 1, 0, 'L', true);
    $pdf->Cell(140, 10, $value, 1, 1, 'L'); 
}

if (!empty($pasien['foto'])) {
    $foto_path = $_SERVER['DOCUMENT_ROOT'] . '/RS/uploads/' . $pasien['foto'];
    if (file_exists($foto_path)) {
        $pdf->Ln(10);
        $pdf->Cell(190, 10, 'Foto Pasien', 0, 1, 'C');
        $pdf->Image($foto_path, 80, $pdf->GetY(), 50, 50);
        $pdf->Ln(55);
    }
}

$pdf->Ln(10);
$pdf->SetFont('Helvetica', 'I', 10);
$pdf->SetTextColor(100, 100, 100);
$pdf->Cell(190, 10, 'Generated by Rumah Sakit Al - ' . date('d M Y'), 0, 1, 'C');

$pdf->Output('D', 'Pasien_' . $pasien['nama'] . '.pdf');
?>