<?php
$output = "";
$no = 1;
foreach ($histori as $row) {
  $time = strtotime($row->time);
  $output.="<tr>
    <td>{$no}</td>
    <td align='left'>{$row->get_name}</td>
    <td>{$row->tgl_awal} - {$row->tgl_akhir}</td>
    <td align='left'>{$row->jenis_permohonan}</td>
    <td>
      <a href='s_persetujuan/$time/$row->tabel' class='btn btn-dark'>Detail</a>
    </td>
    </tr>";
  $no++;
}
echo $output;
?>