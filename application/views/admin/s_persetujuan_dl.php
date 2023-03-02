<?php
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
?>
<link rel="stylesheet" href="<?= base_url() ?>assets/vendors/css/vendor.bundle.addons.css">
    <!-- partial -->
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="row">
          <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Persetujuan Permohonan Dinas Luar</h4>
                <div class="table-responsive">
                  <table class="table table-hover table-border">
                    <tbody>
                      <tr>
                        <td class="summary-heading">Nomor Surat Perintah Tugas</td>
                        <td class="summary-content"><?= $getdatapengajuan->no_spt ?></td>
                      </tr>
                      <tr>
                        <td class="summary-heading">Pegawai yang diperintah</td>
                        <td class="summary-content"><?= $getdatapengajuan->pegawaidiperintah ?></td>
                      </tr>
                      <tr>
                        <td class="summary-heading">Tanggal </td>
                        <td><?= tgl_indo($getdatapengajuan->tgl_berangkat,false).' s/d '.tgl_indo($getdatapengajuan->tgl_kembali,false) ?></td>
                      </tr>
                    </tbody>
                  </table>
                  </br>
                  </br>
                  <table align="center">
                    <tr>
                      <td>
                        <a href="#" data-toggle='modal' data-target='#setuju' class="btn btn-success">Setuju</a>
                        <a href="#" data-toggle='modal' data-target='#ditolak' class="btn btn-danger">Tolak</a>
                        <a href="<?= base_url() ?>admin/persetujuan" class="btn btn-secondary">Kembali</a>
                      </td>
                    </tr>
                  </table>
                  </br>
                  <table class="table table-hover table-border">
                    <tr>
                      <td class="summary-heading">File Bukti Permohonan :
                      <a href="#" type="text" onclick="window.open('<?= base_url().'admin/tampil/dl/'.$getdatapengajuan->bukti?>')"> File </a></td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="setuju" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="form-horizontal" method="post" action="<?= base_url().'admin/t_persetujuan_dl'?>">
        <div class="modal-body">
          <b>Apakah Anda setuju ?</b><br><br>
          <input type="hidden" name="status" value="2">
          <input type="hidden" name="time" value="<?= $getdatapengajuan->time;?>">
          <button type="submit" class="btn btn-primary">Setuju</button>
          <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="ditolak" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="form-horizontal" method="post" action="<?= base_url().'admin/t_persetujuan_dl'?>">
        <div class="modal-body">
          <b>Apakah Anda menolak ?</b><br><br>
          <input type="hidden" name="status" value="3">
          <input type="hidden" name="time" value="<?= $getdatapengajuan->time;?>">
          <button type="submit" class="btn btn-primary">Tolak</button>
          <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>