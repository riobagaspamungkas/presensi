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
                <h4 class="card-title">Detail Kegiatan</h4>
                <div class="table-responsive">
                  <table class="table table-hover table-border">
                    <tbody>
                      <tr>
                        <td class="summary-heading">NIP</td>
                        <td class="summary-content"><?php echo $getdatakegiatan->nip ?></td>
                      </tr>
                      <tr>
                        <td class="summary-heading">Nama Pegawai</td>
                        <td><?php echo $datapegawaikegiatan->nama ?></td>
                      </tr>
                      <tr>
                        <td class="summary-heading">Tanggal</td>
                        <td class="summary-content">
                          <?php
                          $tanggal = tgl_indo($getdatakegiatan->tanggal_kegiatan);
                          echo $tanggal;
                          ?>   
                        </td>
                      </tr>
                      <tr>
                        <td class="summary-heading">Jam Dari</td>
                        <td><?php echo $desk_kegiatan->jam_dari ?></td>
                      </tr>
                      <tr>
                        <td class="summary-heading">Jam Sampai</td>
                        <td><?php echo $desk_kegiatan->jam_sampai ?></td>
                      </tr>
                      <tr>
                        <td class="summary-heading">Judul Kegiatan</td>
                        <td><?php echo $desk_kegiatan->title ?></td>
                      </tr>
                      <tr>
                        <td class="summary-heading">Deskripsi</td>
                        <td><?php echo $desk_kegiatan->deskripsi ?></td>
                      </tr>
                      <tr>
                    </tbody>
                  </table>
                  <br>
                  <br>
                  <table align="center">
                    <tr>
                      <td>
                        <a href="javascript:history.go(-1)" class="btn btn-secondary">Kembali</a>
                      </td>
                    </tr>
                  </table>
                  <br>
                  <table class="table table-hover table-border">
                    <tr>
                      <td class="summary-heading">File Lampiran Kegiatan :
                        <?php 
                        if ($desk_kegiatan->lampiran) {?>
                          <button class="btn btn-link" onclick="window.open('<?= base_url().'kepala/tampil_kegiatan/'. $desk_kegiatan->lampiran?>')"> File </button>
                        <?php 
                        }else{
                          echo '-';
                        }
                        ?>
                      </td>
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