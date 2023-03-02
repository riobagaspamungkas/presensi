<?php
date_default_timezone_set("Asia/Jakarta");
$today = date('m/d/Y');
?>
<link rel="stylesheet" href="<?= base_url() ?>assets/vendors/css/vendor.bundle.addons.css">
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Pengaturan Aplikasi</h4>
                  <br>
                  <?php echo $this->session->flashdata('msg');?>
                  <div class="col-18">
                    <div class="card">
                      <form class="forms-sample" method="post" enctype="multipart/form-data" action="<?= base_url().'admin/e_pengaturan' ?>">
                        <input type="hidden" name="get_id" value="<?= $data_setting->status_setting; ?>">
                        <div class="form-group row">
                          <label for="absen_datang" class="col-sm-2 col-form-label">Absen Datang</label>
                          <div class="col-sm-9">
                            <select name="absen_datang" class="form-control standardSelect" tabindex="1" required="">
                              <?php
                              $start = "00:00:00";
                              $end = "24:00:00";
                              $tStart = strtotime($start);
                              $tEnd = strtotime($end);
                              $tNow = $tStart;
                              while($tNow <= $tEnd){ 
                                $now = date("H:i:s",$tNow);
                                ?>
                                <option value="<?php echo $now; ?>"
                                  <?php
                                  $now = date("H:i:s",$tNow);
                                  if ($now == $data_setting->absen_datang) {
                                    echo " selected ";
                                  }
                                  ?>
                                > <?php echo $now ?>
                                </option>
                                <?php
                                $tNow = strtotime('+30 minutes',$tNow);
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="absen_pulang" class="col-sm-2 col-form-label">Absen Pulang</label>
                          <div class="col-sm-9">
                            <select name="absen_pulang" class="form-control standardSelect" tabindex="1" required="">
                              <?php
                              $start = "00:00:00";
                              $end = "24:00:00";
                              $tStart = strtotime($start);
                              $tEnd = strtotime($end);
                              $tNow = $tStart;
                              while($tNow <= $tEnd){ 
                                $now = date("H:i:s",$tNow);
                                ?>
                                <option value="<?php echo $now; ?>"
                                  <?php
                                  $now = date("H:i:s",$tNow);
                                  if ($now == $data_setting->absen_pulang) {
                                    echo " selected ";
                                  }
                                  ?>
                                > <?php echo $now; ?>
                                </option>
                                <?php
                                $tNow = strtotime('+30 minutes',$tNow);
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="nama" class="col-sm-2 col-form-label">Lokasi</label>
                          <div class="col-sm-9">
                            <input type="checkbox" name="lokasi" class="form-check-input" <?php if($data_setting->lokasi == 1) echo 'checked' ?>>
                            <label for="nama" class="col-sm-8 col-form-label">Menggunakan Maps</label>
                            <!-- <div class="small">(Fitur lokasi ini perlu akses jaringan internet)</div> -->
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="logo" class="col-sm-2 col-form-label">Logo (max 2,5 MB)</label>
                            <img src="<?= base_url().'assets/images/'.$data_setting->logo?>" width="50" class="img-thumbnail">
                            <div class="col-12 col-md-9">
                              <input type="file" name="logo" accept="image/png, image/gif, image/jpeg" class="form-control">
                            </div>
                        </div>
                        <button type="submit" name="update_aplikasi" class="btn btn-success mr-2">Simpan</button>
                        <button type="button" data-toggle='modal' data-target='#reset_aplikasi' class="btn btn-danger btn-fw">Reset Pengaturan Aplikasi</button>
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
  <div class="modal fade" id="reset_aplikasi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form class="form-horizontal" method="post" action="<?= base_url().'admin/resetaplikasi'?>">
          <div class="modal-body">
            Anda yakin ingin mereset ulang settingan ini ke awal?<br><br>
            <input type="hidden" name="id" value="<?= $data_setting->status_setting;?>">
            <input type="hidden" name="logo" value="<?= $data_setting->logo;?>">
            <button type="submit" class="btn btn-primary">Reset</button>
            <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Batal</button>
          </div>
        </form>
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
  <script src="<?= base_url()?>assets/datepicker/js/bootstrap-datepicker.js"></script>

  <script src="<?= base_url() ?>assets/js/jquery.multiselect.js"></script>
  <script>
    window.setTimeout(function() {
      $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
      });
    }, 2000);
  </script>
  <script>
    $(".standardSelect").select2({
      minimumResultsForSearch: -1
    });
  </script>
</body>
</html>