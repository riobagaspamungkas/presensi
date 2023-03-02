<?php
$output = "";
$no = 1;
foreach ($histori as $row) {
  $time = strtotime($row->time);
  $output.="<tr>
    <td>{$no}</td>
    <td>{$row->get_name}</td>
    <td>{$row->tgl_awal} - {$row->tgl_akhir}</td>
    <td>{$row->jenis_permohonan}</td>
    <td align='center'>
      <a href='detail_permohonan/$time/$row->tabel' class='btn btn-dark'>Detail</a>
    </td>
    </tr>";
  $no++;
}
echo $output;
?>