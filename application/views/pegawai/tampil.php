<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" type="image/png" href="<?= base_url()?>assets/images/logo.png">
  <title>Presensi</title>
</head>
<?php
if ($jenis=='kegiatan') {
	$upload_dir = base_url().'assets/upload/kegiatan/';
}elseif ($jenis=='permohonan') {
	$upload_dir = base_url().'assets/upload/permohonan/';
}
?>
<embed src="<?= $upload_dir.$file; ?>" type='application/pdf' width='100%' height='700px'/>
</html>