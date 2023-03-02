<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" type="image/png" href="<?= base_url()?>assets/images/logo.png">
  <title>Presensi</title>
</head>
<?php
if ($jenis=='cuti') {
	$upload_dir = base_url().'assets/upload/cuti/';
}elseif ($jenis=='dl') {
	$upload_dir = base_url().'assets/upload/dinasluar/';
}
$sub_kalimat = substr($file,-3);
if ($sub_kalimat == 'pdf') {?>
	<embed src="<?= $upload_dir.$file; ?>" type='application/pdf' width='100%' height='700px'/>
<?php
}else{ ?>
	<p style="text-align:center"><img src="<?= $upload_dir.$file; ?>" type='image/png, image/gif, image/jpeg' width='700px' height='100%'/></p>
<?php } ?>
</html>