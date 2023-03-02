<?php
$output = "";
$no = 1;
foreach ($kegiatan as $row) {
	$output.="<tr>
    <td align='text-center'>{$no}</td>
    <td align='text-center'>{$row->jam_dari}</td>
    <td align='text-center'>{$row->jam_sampai}</td>
    <td align='text-center'>{$row->title}</td>
    <td align='text-center'>
    	<a href='detail_kegiatan/$row->id_deskripsi' class='btn btn-dark'><em class='mdi mdi-information-outline'></em></a>
    	<a href='update_kegiatan/$row->id_deskripsi' class='btn btn-primary'><em class='mdi mdi-table-edit'></em></a> 
    	<a data-href='#' data-toggle='modal' data-target='#konfirmasi_hapus$row->id_deskripsi' class='btn btn-danger'><em class='mdi mdi-delete-variant'></em></a>
    </td>
    </tr>";
	$no++;
}
echo $output;
?>