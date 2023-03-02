<?php
/** PHPExcel */
require_once './assets/classes/PHPExcel.php';
require_once './assets/classes/PHPExcel/IOFactory.php';
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
 
    return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}
$jenis = '';
if ($active == 'fingerprint') {
    $jenis = 'MESIN FINGERPRINT';
}else{
    $jenis = 'ONLINE';
}

// Create new PHPExcel object
$object = new PHPExcel();
 
// Set properties
$object->getProperties()->setCreator("Tempo")->setLastModifiedBy("Tempo")->setCategory("Approve by ");
$style = array(
  'alignment' => array(
    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
  )
);

$object->getDefaultStyle()->applyFromArray($style);
// Add some data
$object->getActiveSheet()->getColumnDimension('A')->setWidth(35);
$object->getActiveSheet()->getColumnDimension('B')->setWidth(10);
$object->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$object->getActiveSheet()->getColumnDimension('D')->setWidth(15);
$object->getActiveSheet()->getColumnDimension('E')->setWidth(15);
$object->getActiveSheet()->getColumnDimension('F')->setWidth(35);
$object->getActiveSheet()->mergeCells('A1:F1');
$object->getActiveSheet()->mergeCells('A2:F2');
$object->getActiveSheet()->mergeCells('A3:F3');
$object->getActiveSheet()->mergeCells('A4:F4');
$object->setActiveSheetIndex(0)
            ->setCellValue('A1', 'PRESENSI PEGAWAI')
            ->setCellValue('A2', 'VIA '.$jenis)
            ->setCellValue('A3', 'SMKN 1 BINTAN TIMUR')
            ->setCellValue('A4', tgl_indo($tgl_dari).' - '.tgl_indo($tgl_sampai))
            ->setCellValue('A6', 'Nama Pegawai')
            ->setCellValue('B6', 'Hari')
            ->setCellValue('C6', 'Tanggal')
            ->setCellValue('D6', 'Jam Masuk')
            ->setCellValue('E6', 'Jam Pulang')
            ->setCellValue('F6', 'Keterangan');

//add data
$testing='hello hello hello \r world';
$counter=7;
$ex = $object->setActiveSheetIndex(0);

foreach ($rowpresensi as $row) {
    $colorm = '';
    $colorp = '';
    if (!empty($row->colorm)) {
        $colorm = substr($row->colorm, 1);
        $object->getActiveSheet()->getStyle('D'.$counter)->applyFromArray(
            array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => $colorm)
                )
            )
        );
    }
    if (!empty($row->colorp)) {
        $colorp = substr($row->colorp, 1);
        $object->getActiveSheet()->getStyle('E'.$counter)->applyFromArray(
            array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => $colorp)
                )
            )
        );
    }
    $strdate = strtotime($row->dateget);
    $date = date('Y-m-d', $strdate);
    $ex->setCellValue("A".$counter,$row->get_name);
    $ex->setCellValue("B".$counter,hari_indo($row->dateget));
    $ex->setCellValue("C".$counter,tgl_indo($date));
    $ex->setCellValue("D".$counter,$row->time_masuk);
    $ex->setCellValue("E".$counter,$row->time_pulang);
    $ex->setCellValue("F".$counter,$row->keterangan_absen);
    $ex->getStyle("F".$counter)->getAlignment()->setWrapText(true);
    $counter+=1;
}
$styleArray = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN
        )
    ),
    'alignment' => array(
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
    )
);
$border = $counter-1;
$object->getActiveSheet()->getStyle('A6:F'.$border)->applyFromArray($styleArray);
unset($styleArray);

// Rename sheet
$object->getActiveSheet()->setTitle('SMKN 1 BINTAN TIMUR');
            
// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Presensi pegawai.xlsx"');
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
$objWriter->save('php://output');
exit;
?>