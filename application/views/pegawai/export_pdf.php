<?php
require_once './assets/fpdf/fpdf.php';

function hari_indo($tanggal)
{
  $hari = array ( 1 =>    'Senin',
    'Selasa',
    'Rabu',
    'Kamis',
    'Jumat',
    'Sabtu',
    'Minggu'
  );
  $num = date('N', strtotime($tanggal));
  return $hari[$num];
}
function tgl_indo($tanggal){
  $bulan = array (
    1 =>   'Januari',
    'Februari',
    'Maret',
    'April',
    'Mei',
    'Juni',
    'Juli',
    'Agustus',
    'September',
    'Oktober',
    'November',
    'Desember'
  );
  $pecahkan = explode('-', $tanggal);
    
  // variabel pecahkan 0 = tanggal
  // variabel pecahkan 1 = bulan
  // variabel pecahkan 2 = tahun
 
  return $pecahkan[0] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[2];
}

$tgl_dari = date('d-m-Y',strtotime($tgl_dari));
$tgl_sampai = date('d-m-Y',strtotime($tgl_sampai));

$cari = '\n';
$pdf = new FPDF('L','mm','A4');
$pdf->SetFillColor(230, 82, 81);
$pdf->SetMargins(15,20,15);
$pdf->AddPage();
$pdf->SetTitle("PRESENSI PEGAWAI");
$cell1 = 65;
$cell2 = 17;
$cell3 = 32;
$cell4 = 22;
$cell5 = 22;
$cell6 = 90;
$length = 7;
$stgh_length = $length;
$font = 9;

$pdf->SetFont('Times','',11);
$pdf->Cell(0,5,'PRESENSI PEGAWAI','0','1','C',false);
$pdf->SetFont('Times','',11);
$pdf->Cell(0,5,'SMKN 1 BINTAN TIMUR','0','1','C',false);
$pdf->SetFont('Times','',11);
$pdf->Cell(0,5,'VIA ONLINE','0','1','C',false);
$pdf->SetFont('Times','',11);
$pdf->Cell(0,5,tgl_indo($tgl_dari).' - '.tgl_indo($tgl_sampai),'0','1','C',false);
$pdf->SetMargins(25,20,15);
$pdf->Ln(8);
$pdf->SetFont('Arial','',$font);
$pdf->Cell($cell1,$length,'Nama Pegawai',1,0,'C');
$pdf->Cell($cell2,$length,'Hari',1,0,'C');
$pdf->Cell($cell3,$length,'Tanggal',1,0,'C');
$pdf->Cell($cell4,$length,'Jam Masuk',1,0,'C');
$pdf->Cell($cell5,$length,'Jam Pulang',1,0,'C');
$pdf->Cell($cell6,$length,'Keterangan',1,0,'C');
$posisiy=55;
$tambahy=0;
foreach ($rowpresensi as $row) {
  if (preg_match("/$cari/i", $row->keterangan_absen)) {
    $length = 10;
    $stgh_length = $length/2;
  }
  $tanggal = strtotime($row->dateget);
  $gettanggal = date('d-m-Y',$tanggal);
  $pdf->Ln();
  $pdf->SetY($posisiy);
  $pdf->SetFont('Arial','',$font);
  $pdf->Cell($cell1,$length,$data_user_login->nama,1,0,'C');
  $pdf->Cell($cell2,$length,hari_indo($gettanggal),1,0,'C');
  $pdf->Cell($cell3,$length,tgl_indo($gettanggal),1,0,'C');
  $pdf->Cell($cell4,$length,$row->time_masuk,1,0,'C',$row->pdfcolorm);
  $pdf->Cell($cell5,$length,$row->time_pulang,1,0,'C',$row->pdfcolorp);
  $pdf->SetXY(183, $posisiy);
  $pdf->Multicell($cell6,$stgh_length,$row->keterangan_absen,1,'L',false);
  $posisiy += $length;
  $length = 7;
  $stgh_length = $length;
}
$pdf->Output();
?>