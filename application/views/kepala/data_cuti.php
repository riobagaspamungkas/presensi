<?php
$output = "";
$no = 1;
foreach ($datakehadiran as $row) {
	$output.="<tr style='text-align:center'>
    <td>{$no}</td>
    <td align='left'>{$row->tgl_dari  $row->tgl_sampai}</td>
    <td>{$row->jenis_cuti}</td>
    <td>{$row->jam_pulang}</td>
    <td align='left'>{$row->status_absen}</td>
    <td>
    	<a href='detail_kehadiran/$row->id_absen/kehadiran' class='btn btn-dark'>Detail</a>
    </td>
    </tr>";
	$no++;
}
echo $output;
?>