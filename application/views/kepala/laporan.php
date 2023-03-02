<?php
date_default_timezone_set("Asia/Jakarta");
$bulan = date('m');
$tahun = date('Y');
?>
<link rel="stylesheet" href="<?= base_url() ?>assets/vendors/css/vendor.bundle.addons.css">
    <!-- partial -->
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="row">
          <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
               <h4 class="card-title">Laporan Presensi Pegawai</h4>
                <form class="forms-sample" id="filter" method="post" target="_blank">
                  <div class="form-group row">
                    <label for="tgl_dari" class="col-sm-2 col-form-label">Bulan </label>
                    <div class="col-sm-3">
                      <select name="bulan" class="form-control" required="">
                        <option value="1" <?php if($bulan=='01') echo 'selected="selected"'; ?> >Januari</option>
                        <option value="2" <?php if($bulan=='02') echo 'selected="selected"'; ?> >Februari</option>
                        <option value="3" <?php if($bulan=='03') echo 'selected="selected"'; ?> >Maret</option>
                        <option value="4" <?php if($bulan=='04') echo 'selected="selected"'; ?> >April</option>
                        <option value="5" <?php if($bulan=='05') echo 'selected="selected"'; ?> >Mei</option>
                        <option value="6" <?php if($bulan=='06') echo 'selected="selected"'; ?> >Juni</option>
                        <option value="7" <?php if($bulan=='07') echo 'selected="selected"'; ?> >Juli</option>
                        <option value="8" <?php if($bulan=='08') echo 'selected="selected"'; ?> >Agustus</option>
                        <option value="9" <?php if($bulan=='09') echo 'selected="selected"'; ?> >September</option>
                        <option value="10" <?php if($bulan=='10') echo 'selected="selected"'; ?> >Oktober</option>
                        <option value="11" <?php if($bulan=='11') echo 'selected="selected"'; ?> >November</option>
                        <option value="12" <?php if($bulan=='12') echo 'selected="selected"'; ?> >Desember</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="tgl_sampai" class="col-sm-2 col-form-label">Tahun </label>
                    <div class="col-sm-3">
                      <select name="tahun" class="form-control" required="">
                      <?php 
                      for ($i=$tahun-7; $i <= $tahun; $i++) { ?>
                        <option value="<?php echo $i; ?>" <?php if($i==$tahun) echo 'selected="selected"'; ?> > <?php echo $i; ?></option>
                      <?php }
                      ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-8">
                      <button type="submit" name="cetak" class="btn btn-success mr-2">Tampilkan</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
