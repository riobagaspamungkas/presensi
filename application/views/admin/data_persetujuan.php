<?php
$output = "";
$no = 1;
foreach ($persetujuan as $row) {
  $time = strtotime($row->time);
  $output.="<tr>
    <td>{$no}</td>
    <td>{$row->get_name}</td>
    <td>{$row->tgl_awal} - {$row->tgl_akhir}</td>
    <td>{$row->jenis_permohonan}</td>
    <td align='center'>
      <a href='s_persetujuan/$time/$row->tabel' class='btn btn-primary'>Persetujuan</a>
    </td>
    </tr>";
  $no++;
}
echo $output;
?>