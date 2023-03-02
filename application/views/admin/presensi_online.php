<style>
  /* custom checkbox */
  .checkbox {
      display: block;
      position: relative;
      padding-left: 35px;
      margin-bottom: 12px;
      cursor: pointer;
      font-size: 20px;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
  }
  /* hide the browser's default checkbox */
  .checkbox input {
      position: absolute;
      opacity: 0;
      cursor: pointer;
  }
  ul,li { margin:0; padding:0; list-style:none;}
  .label { color:#000; font-size:16px;}
  .combo-label {margin-bottom:.5em;}
</style>
<link rel="stylesheet" href="<?= base_url() ?>assets/vendors/css/vendor.bundle.addons.css">
    <!-- partial -->
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="row">
          <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
               <h4 class="card-title">Presensi Pegawai Via Web Online</h4>
                <form class="forms-sample" id="filter" method="post">
                  <div class="form-group row">
                    <label for="tgl_dari" class="col-sm-2 col-form-label">Dari Tanggal : </label>
                    <div class="col-sm-3">
                      <input type="date" class="form-control" name="tgl_dari" value="<?= $tgl_dari ?>" required="">
                    </div>
                    <label for="tgl_sampai" class="col-sm-3 col-form-label">Sampai Tanggal : </label>
                    <div class="col-sm-3">
                      <input type="date" class="form-control" name="tgl_sampai" value="<?= $tgl_sampai ?>" required="">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="pegawai" class="col-sm-2 col-form-label">Pegawai : </label>
                      <div class="col-sm-5">
                        <select name="pegawai[]" multiple id="pegawai" class="form-control">
                          <?php
                            foreach ($row_pegawai as $rows) {
                              echo "<option ";
                              if (isset($_POST['pegawai'])) {
                                foreach ($pegawai as $trow) {
                                if ($rows->nip == $trow) {
                                  echo' selected';
                                }}
                              }
                              echo " value=$rows->nip>$rows->nip / $rows->nama </option>";
                            }
                          ?>
                        </select>
                      </div>
                  </div>
                  <div class="form-group row">
                    <label for="filtgl" class="col-lg-6 control-label">Centang untuk pegawai yang belum absen atau bermasalah
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
                      <a href="<?= base_url() ?>admin/presensi_online" class="btn btn-secondary"><em class="mdi mdi-refresh"></em> Refresh</a>
                      <?php 
                      if (isset($_POST['tombolfilter'])) { ?>
                        <button type="submit" name="export" class="btn btn-primary mr-2"><em class="mdi mdi-export"></em> Export to Excel</button>
                      <?php } ?>
                    </div>
                  </div>
                </form>
                <?php 
                if (isset($_POST['tombolfilter'])) { ?>
                  <div class="table-responsive">
                    <table class="table table-striped table-bordered table-list">
                      <thead style="text-align:center">
                        <tr>
                          <th>No</th>
                          <th>Nama Pegawai</th>
                          <th>Tanggal</th>
                          <th>Jam Masuk</th>
                          <th>Jam Pulang</th>
                          <th>Keterangan</th>
                        </tr>
                      </thead>
                      <tbody style="text-align:center">
                        <?php
                        $no = 1;
                        foreach ($rowpresensi as $row) {?>
                          <tr>
                            <td><?= $no ?></td>
                            <td align='left'><?= $row->get_name ?></td>
                            <td><?= $row->dateget ?></td>
                            <td style='background-color:<?= $row->colorm ?>'><?= $row->time_masuk ?></td>
                            <td style='background-color:<?= $row->colorp ?>'><?= $row->time_pulang ?></td>
                            <td align='left'><?= $row->status_absen ?></td>
                        </tr>
                        <?php $no++;
                      } ?>
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