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
function bulan_indo($tanggal){
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
  return $bulan[$tanggal];
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
 
  return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}

$getbulantahun = '01-'.$bulan.'-'.$tahun;
$tgl_dari = date('01-m-Y', strtotime($getbulantahun));
$tgl_sampai = date('t-m-Y', strtotime($getbulantahun));

$cari = '\n';
$pdf = new FPDF('P','mm','A4');
$pdf->SetFillColor(230, 82, 81);
$pdf->SetMargins(15,20,15);
$pdf->SetTitle("PRESENSI PEGAWAI");
$cell1 = 8;
$cell2 = 13;
$cell3 = 30;
$cell4 = 20;
$cell5 = 20;
$cell6 = 55;
$length = 7;
$stgh_length = $length;
$font = 9;
foreach ($rowlaporan as $row) {
  $pdf->AddPage();
  $pdf->SetFont('Times','',15);
  $pdf->Cell(0,8,'LAPORAN PRESENSI PEGAWAI','0','1','C',false);
  $pdf->SetFont('Times','',12);
  $pdf->SetMargins(35,20,15);
  $pdf->Ln(8);
  $pdf->Cell(0,5,'NIP : '.$row[0]->nip,'0','1','L',false);
  $pdf->Cell(0,5,'Nama : '.$row[0]->nama,'0','1','L',false);

  $pdf->SetXY(110, 36);
  $pdf->Multicell(0,5,'Periode waktu','0','C');
  $pdf->SetXY(110, 41);
  $pdf->Multicell(0,5,'Dari '.$tgl_dari.' s/d '.$tgl_sampai,'0','C');

  $pdf->Ln(2);
  $pdf->SetFont('Arial','',$font);
  $pdf->Cell($cell1,$length,'No',1,0,'C');
  $pdf->Cell($cell2,$length,'Hari',1,0,'C');
  $pdf->Cell($cell3,$length,'Tanggal',1,0,'C');
  $pdf->Cell($cell4,$length,'Jam Masuk',1,0,'C');
  $pdf->Cell($cell5,$length,'Jam Pulang',1,0,'C');
  $pdf->Cell($cell6,$length,'Keterangan',1,0,'C');
  $no = 1;
  $posisiy=55;
  $tambahy=0;
  for ($i=0; $i < $row[0]->jumlahrow ; $i++) {
    if (preg_match("/$cari/i", $row[$i]->status_absen)) {
      $length = 8;
      $stgh_length = $length/2;
    }
    $pdf->Ln();
    $pdf->SetY($posisiy);
    $pdf->SetFont('Arial','',$font);
    $pdf->Cell($cell1,$length,$no,1,0,'C');
    $pdf->Cell($cell2,$length,hari_indo($row[$i]->dateget),1,0,'C');
    $pdf->Cell($cell3,$length,tgl_indo($row[$i]->dateget),1,0,'C');
    $pdf->Cell($cell4,$length,$row[$i]->time_masuk,1,0,'C',$row[$i]->colorm);
    $pdf->Cell($cell5,$length,$row[$i]->time_pulang,1,0,'C',$row[$i]->colorp);
    $pdf->SetXY(126, $posisiy);
    $pdf->Multicell($cell6,$stgh_length,$row[$i]->status_absen,1,'L',false);
    $no++;
    $posisiy += $length;
    $length = 7;
    $stgh_length = $length;
  }
  $pdf->Ln(5);
  $pdf->SetLeftMargin(110);
  $pdf->SetFont('Arial','',11);
  $pdf->Cell(0,0,"Mengetahui,",0,0,'C');
  $pdf->Ln(5);
  $pdf->Cell(0,0,"Kepala SMKN 1 Bintan Timur",0,0,'C');
  $pdf->Ln(20);
  $pdf->Cell(0,0,$data_kepala->nama,0,0,'C');
  $pdf->SetMargins(35,20,15);
}
$pdf->Output();
?>