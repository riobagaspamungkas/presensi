<link rel="stylesheet" href="<?= base_url() ?>assets/vendors/css/vendor.bundle.addons.css">
    <!-- partial -->
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="row">
          <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
               <h4 class="card-title">Presensi Pegawai Via Mesin Fingerprint</h4>
                <form class="forms-sample" id="filter" method="post">
                  <div class="form-group row">
                    <label for="tgl_dari" class="col-sm-2 col-form-label">Dari Tanggal : </label>
                    <div class="col-sm-3">
                      <input type="date" class="form-control" name="tgl_dari" placeholder="Masukkan tanggal" value="<?php echo $tgl_dari ?>" required="">
                    </div>
                    <label for="tgl_sampai" class="col-sm-3 col-form-label">Sampai Tanggal : </label>
                    <div class="col-sm-3">
                      <input type="date" class="form-control" name="tgl_sampai" placeholder="Masukkan tanggal" value="<?php echo $tgl_sampai ?>" required="">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="filtgl" class="col-lg-6 control-label">Centang untuk yang belum absen atau bermasalah
                      <input type="hidden" name="filtgl" value="8">
                      <?php
                      if ($centang == 0){
                        echo '<input type="checkbox" name="filtgl" value="" checked>';
                      }elseif ($centang >= 1){
                        echo '<input type="checkbox" name="filtgl" value="">';
                      }
                      ?>
                    </label>
                    <div class="col-sm-8">
                      <button type="submit" name="tombolfilter" class="btn btn-success mr-2">Cari</button>
                      <a href="<?= base_url() ?>kepala/fingerprint" class="btn btn-secondary"><em class="mdi mdi-refresh"></em> Refresh</a>
                      <?php 
                      if (isset($_POST['tombolfilter'])) { ?>
                        <button type="submit" formtarget="_blank" name="export" class="btn btn-primary mr-2"><em class="mdi mdi-export"></em> Cetak</button>
                      <?php } ?>
                    </div>
                  </div>
                </form>
                <?php 
                if (isset($_POST['tombolfilter'])) { ?>
                  <div class="table-responsive">
                    <table class="table table-striped table-bordered table-list">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Tanggal</th>
                          <th>Masuk</th>
                          <th>Pulang</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $no=1;
                        foreach ($rowpresensi as $row) {?>
                          <tr>
                            <td><?= $no ?></td>
                            <td><?= $row->dateget ?></td>
                            <td style='background-color:<?= $row->colorm ?>'><?= $row->time_masuk ?></td>
                            <td style='background-color:<?= $row->colorp ?>'><?= $row->time_pulang ?></td>
                            <td style='text-align:center;'><?= $row->status_absen ?></td>
                          </tr>
                          <?php $no++; 
                        }?>
                      </tbody>
                    </table>
                  </div>
                  <?php
                }?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>