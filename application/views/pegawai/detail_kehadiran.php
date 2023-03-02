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
                <h4 class="card-title">Detail Presensi Pegawai</h4>
                <div class="table-responsive">
                  <table class="table table-hover table-border">
                    <tbody>
                      <tr>
                        <td class="summary-heading">NIP</td>
                        <td class="summary-content"><?php echo $data_kehadiran->nip ?></td>
                      </tr>
                      <tr>
                        <td class="summary-heading">Nama Pegawai</td>
                        <td><?php echo $data_kehadiran->nama ?></td>
                      </tr>
                      <tr>
                        <td class="summary-heading">Tanggal Absen</td>
                        <td class="summary-content">
                          <?php
                          $tanggal = tgl_indo($data_kehadiran->tanggal);
                          echo $tanggal;
                          ?>   
                        </td>
                      </tr>
                      <tr>
                        <td class="summary-heading">Jam Masuk</td>
                        <td>
                          <?php
                          if (empty($data_kehadiran->jam_masuk)) {
                            echo '-';
                          }else{
                            echo $data_kehadiran->jam_masuk;
                          } ?>
                        </td>
                      </tr>
                      <tr>
                        <td class="summary-heading">Jam Pulang</td>
                        <td>
                          <?php
                          if (empty($data_kehadiran->jam_pulang)) {
                            echo '-';
                          }else{
                            echo $data_kehadiran->jam_pulang;
                          } ?>
                        </td>
                      </tr>
                      <tr>
                        <td class="summary-heading">Keterangan</td>
                        <td><?php echo $data_kehadiran->status_absen ?></td>
                      </tr>
                      <tr>
                        <td class="summary-heading">Lokasi Absen</td>
                        <td>
                          <?php
                          if (empty($data_kehadiran->lokasi_absen) || $data_kehadiran->lokasi_absen == 'No Location' || $data_kehadiran->lokasi_absen == 'searching...') {
                            echo '-';
                          }
                          ?>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <?php
                  if (!empty($data_kehadiran->lokasi_absen) && $data_kehadiran->lokasi_absen != 'No Location' && $data_kehadiran->lokasi_absen != 'searching...') { ?>
                    <div id='maps-view-absen' style='width: 100%; height:250px;'></div>
                    <a class="btn btn-primary my-2" href="http://maps.google.com/maps?q=<?= $data_kehadiran->lokasi_absen; ?>" target="_blank"><span class="fas fa-fw fa-map-marker-alt mr-1"></span>Lihat Lokasi</a>
                    <script>
                      if (document.getElementById("maps-view-absen")) {
                        var map = L.map('maps-view-absen', {zoomControl: false,attributionControl: false,}).setView([<?= $data_kehadiran->lokasi_absen; ?>], 15);
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                        }).addTo(map);
                        L.marker([<?= $data_kehadiran->lokasi_absen; ?>]).addTo(map);
                      }
                    </script>
                  <?php } ?>
                  <table align="center">
                    <tr>
                      <td>
                        <a href="<?= base_url() ?>admin/dashboard" class="btn btn-secondary">Kembali</a>
                      </td>
                    </tr>
                  </table>
                  <br>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>