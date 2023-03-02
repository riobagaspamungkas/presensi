<?php
    require_once './assets/classes/PHPExcel.php';
    require_once './assets/classes/PHPExcel/IOFactory.php';

    $random = "file_upload_".rand(11111,99999);
    $target_file = $random.basename($_FILES["file_excel"]["name"]);
    $uploadOk = 1;

    if (move_uploaded_file($_FILES["file_excel"]["tmp_name"], $target_file)) {

        ini_set('memory_limit', '-1');
        $objReader = PHPExcel_IOFactory::createReader('Excel2007');

        $inputFileType = 'Excel2007';
        $sheetIndex = 0;
        $inputFileName = $target_file;

        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $sheetnames = $objReader->listWorksheetNames($inputFileName);
        $objReader->setLoadSheetsOnly($sheetnames[$sheetIndex]);
        
        try {
        $objPHPExcel = $objReader->load($inputFileName);
        } catch(Exception $e) {
        die('Error loading file :' . $e->getMessage());
        }

        $worksheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
        $numRows = count($worksheet);

        //baca untuk setiap baris excel
        for ($i=5; $i <= $numRows ; $i++) {
            $upah= str_replace(",", "", $worksheet[$i]['F']);
            $carikode = mysqli_query($connect, "select max(id_satker) from satker");
            $datakode = mysqli_fetch_array($carikode);
            if ($datakode) {
                $nilaikode = substr($datakode[0], -5);
                $kode = (int) $nilaikode;
                $kode = $kode + 1;
                $kode_otomatis = "0406".str_pad($kode, 5, "0", STR_PAD_LEFT);
            } else {
                $kode_otomatis = "040600001";
            }
            $cek = "SELECT * FROM satker WHERE nm_satker = '".$worksheet[$i]['E']."'";
            $sql = "INSERT INTO satker VALUES ('".$kode_otomatis."','".$worksheet[$i]['E']."', '".$upah."')";
            if ($result = mysqli_query($connect,$cek)){
                $rowcount = mysqli_num_rows($result);
                if ($rowcount > 0) {
                    foreach ($result as $getsatker){
                        $getupah = $getsatker['tagihan'];
                    }
                    $totalupah = $upah + $getupah;
                    $cekupah = "UPDATE satker SET tagihan = '$totalupah' WHERE nm_satker = '".$worksheet[$i]['E']."'";
                    $get = $cekupah;
                } elseif ($rowcount == 0 ) {
                    $get = $sql;
                }
            }
            mysqli_query($connect, $get);
        }
        unlink($target_file);
        $pesan ='Import Excel Success!';
        echo json_encode(array('st'=>1,'pesan'=>$pesan));
    } else {
        $pesan="File tidak ada";
        echo json_encode(array('st'=>0,'pesan'=>$pesan));
    }

?>