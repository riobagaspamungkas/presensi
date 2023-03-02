<?php
$month = $getcuti->max_bulan;
$tambah_bulan = "+".$month." month";
$date_awal = $getdatapengajuan->tgl_dari;
$date_akhir = $getdatapengajuan->tgl_sampai;
$date_awal = date('m/d/Y', strtotime($date_awal));
$date_akhir = date('m/d/Y', strtotime($date_akhir));
$date_cuti = $date_awal." - ".$date_akhir;
?>
<link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/daterangepicker/daterangepicker.css">
<link rel="stylesheet" href="<?= base_url() ?>assets/vendors/css/vendor.bundle.addons.css">
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Permohohan <?= $getcuti->jenis_cuti ?></h4>
                  <div class="col-18">
                    <div class="card">
                      <form class="forms-sample" method="post" enctype="multipart/form-data" action="<?= base_url().'kepala/e_pengajuan_cuti' ?>">
                        <div class="form-group row">
                          <label for="nip" class="col-sm-2 col-form-label">NIP</label>
                          <div class="col-sm-9">
                            <input name="get_time" type="hidden" value="<?= $getdatapengajuan->time ?>" >
                            <input type="text" class="form-control" name="nip" value="<?= $getdatapengajuan->nip ?>" readonly>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="nama" class="col-sm-2 col-form-label">Nama Pegawai</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="nama" value="<?= $data_user_login->nama ?>" readonly>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="jbtn" class="col-sm-2 col-form-label">Jabatan</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="jbtn" value="<?= $data_jabatan_login->nama_jbtn ?>" readonly>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="gol" class="col-sm-2 col-form-label">Golongan</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="gol" value="<?= $data_user_login->gol ?>" readonly>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="tgl_dari" class="col-sm-2 col-form-label">Tanggal Cuti</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="daterange" value="<?= $date_cuti ?>" required>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="alasan" class="col-sm-2 col-form-label">Alasan Cuti</label>
                          <div class="col-sm-9">
                            <textarea type="text" class="form-control" name="alasan" required><?= $getdatapengajuan->alasan ?></textarea>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="bukti" class="col-sm-2 col-form-label">Bukti pengajuan pdf/jpg/png (max 5 MB)</label>
                            <div class="col-12 col-md-9">
                              <input type="file" name="bukti" accept="application/pdf, image/png, image/gif, image/jpeg" class="form-control">
                            </div>
                        </div>
                        <button type="submit" name="edit" class="btn btn-success mr-2">Simpan</button>
                        <a href="<?= base_url().'kepala/pengajuan_cuti' ?>" class="btn btn-light"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="<?= base_url()?>assets/vendors/js/vendor.bundle.base.js"></script>
  <script src="<?= base_url()?>assets/js/off-canvas.js"></script>
  <script src="<?= base_url()?>assets/js/misc.js'"></script>
  <script src="<?= base_url()?>assets/js/dashboard.js"></script>
  <script src="<?= base_url()?>assets/tables/jquery.dataTables.js"></script>
  <script src="<?= base_url()?>assets/tables/dataTables.bootstrap.js"></script>
  <script src="<?= base_url()?>assets/tables/dataTables.bootstrap.css"></script>
  <script src="<?= base_url()?>assets/vendors/js/vendor.bundle.addons.js"></script>
  <script type="text/javascript" src="<?= base_url()?>assets/daterangepicker/daterangepicker.js"></script>
  <script>
  $(function() {
    var month = <?= $month ?>;
    $('input[name="daterange"]').daterangepicker({
      opens: 'right',
      minDate:new Date(),
      dateLimit: {
        'months': month,
        'days': 0
      }
    }, function(start, end, label) {
      console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
    });
  });
  </script>
  <script>
    window.setTimeout(function() {
      $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
      });
    }, 2000);
  </script>
</body>
</html>