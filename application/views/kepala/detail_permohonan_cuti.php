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
                <h4 class="card-title">Persetujuan Permohonan <?= $getdatapengajuan->jenis_permohonan ?></h4>
                <div class="table-responsive">
                  <table class="table table-hover table-border">
                    <tbody>
                      <tr>
                        <td class="summary-heading">Status Permohonan Cuti</td>
                        <td class="summary-content"><?= strtoupper($getdatapengajuan->status_pengajuan_cuti) ?></td>
                      </tr>
                      <tr>
                        <td class="summary-heading">NIP</td>
                        <td class="summary-content"><?= $getdatapengajuan->nip ?></td>
                      </tr>
                      <tr>
                        <td class="summary-heading">Nama Pegawai</td>
                        <td><?= $getdatapengajuan->nama ?></td>
                      </tr>
                      <tr>
                        <td class="summary-heading">Tanggal </td>
                        <td><?= tgl_indo($getdatapengajuan->tgl_dari,false).' s/d '.tgl_indo($getdatapengajuan->tgl_sampai,false) ?></td>
                      </tr>
                      <tr>
                        <td class="summary-heading">Jenis Permohonan</td>
                        <td><?php echo $getdatapengajuan->jenis_permohonan ?></td>
                      </tr>
                      <tr>
                        <td class="summary-heading">Alasan</td>
                        <td><?php echo $getdatapengajuan->alasan ?></td>
                      </tr>
                    </tbody>
                  </table>
                  </br>
                  </br>
                  <table align="center">
                    <tr>
                      <td>
                        <a href="<?= base_url() ?>kepala/histori" class="btn btn-secondary">Kembali</a>
                      </td>
                    </tr>
                  </table>
                  </br>
                  <table class="table table-hover table-border">
                    <tr>
                      <td class="summary-heading">File Bukti Permohonan :
                      <a href="#" type="text" onclick="window.open('<?= base_url().'kepala/tampil/'.$getdatapengajuan->jenis.'/'.$getdatapengajuan->bukti?>')"> File </a></td>
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