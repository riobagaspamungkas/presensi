<?php
$output = "";
$no = 1;
foreach ($datakehadiran as $row) {
	$output.="<tr>
    <td>{$no}</td>
    <td align='left'>{$row->nama}</td>
    <td>{$row->jam_masuk}</td>
    <td>{$row->jam_pulang}</td>
    <td align='left'>{$row->status_absen}</td>
    <td>
    	<a href='detail_kehadiran/$row->id_absen' class='btn btn-dark'>Detail</a>
    </td>
    </tr>";
	$no++;
}
echo $output;
?>