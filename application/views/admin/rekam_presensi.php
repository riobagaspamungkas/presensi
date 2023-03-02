<?php
function hari_tgl($num)
{
  $hari = array ( 0 =>  'Minggu', 
    'Senin',
    'Selasa',
    'Rabu',
    'Kamis',
    'Jumat',
    'Sabtu'
  );
  return $hari[$num];
}
?>
<link rel="stylesheet" href="<?= base_url() ?>assets/vendors/css/vendor.bundle.addons.css">
<!-- partial -->
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="row">
          <div class="col-xl-6 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
            <div class="card card-statistics">
              <div class="card-body">
                <div class="clearfix">
                  <div class="float-left">
                    <i class="mdi mdi-account-card-details text-success icon-lg"></i>
                  </div>
                  <div class="float-right">
                    <p class="mb-0 text-right">Via Online</p>
                    <div class="fluid-container">
                      <h3 class="font-weight-medium text-right mb-0">
                        <?= $countabsenonline.'/'.$countuser; ?>
                      </h3>
                    </div>
                  </div>
                </div>
                <p class="text-muted mt-3 mb-0">
                  <i class="mdi mdi-calendar mr-1" aria-hidden="true"></i> Presensi hari ini
                </p>
              </div>
            </div>
          </div>
          <div class="col-xl-6 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
            <div class="card card-statistics">
              <div class="card-body">
                <div class="clearfix">
                  <div class="float-left">
                    <i class="mdi mdi-account-location text-info icon-lg"></i>
                  </div>
                  <div class="float-right">
                    <p class="mb-0 text-right">User</p>
                    <div class="fluid-container">
                      <h3 class="font-weight-medium text-right mb-0">
                        <?= $countuser ?>
                      </h3>
                    </div>
                  </div>
                </div>
                <p class="text-muted mt-3 mb-0">
                  <i class="mdi mdi-account mr-1" aria-hidden="true"></i> Jumlah user
                </p>
              </div>
            </div>
          </div>
        </div>
        <!--collapse start-->
        <div class="row">
          <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h5 style="text-align:center">
                  <?php
                  date_default_timezone_set("Asia/Jakarta");
                  $a = date ("H");
                  if (($a>=5) && ($a<=11)) {
                      echo "Selamat Pagi . .";
                  }else if(($a>=11) && ($a<=15)){
                      echo "Selamat Siang . .";
                  }elseif(($a>15) && ($a<=18)){
                      echo "Selamat Sore . .";
                  }else{
                      echo "Selamat Malam . .";
                  } ?>
                </h5>
                <h2 id="timestamp" style="text-align:center"></h2>
                <h5 style="text-align:center">
                  <?php 
                  $tanggal = mktime(date('m'), date("d"), date('Y'));
                  echo "".hari_tgl(date("w", $tanggal )) .", " . date("d F Y", $tanggal );
                  ?>
                </h5>
                <br>
                <?php echo $this->session->flashdata('msg');?>
                <form class="forms-sample" method="post" action="<?= base_url()?>admin/t_presensi">
                  <div class="form-group row">
                    <label for="tgl_presensi" class="col-sm-2 col-form-label">Tanggal : </label>
                    <div class="col-sm-3">
                      <input type="date" class="form-control" name="tgl_presensi" value="<?php echo date('Y-m-d'); ?>" required="">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Keterangan</label>
                    <div class="col-sm-2">
                      <div class="form-radio">
                        <label class="form-check-label">
                          <input type="radio" class="form-check-input" name="keterangan" value="masuk" <?php if(($a>=5) && ($a<=12)) echo 'checked'; ?>> Absen Masuk
                        </label>
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="form-radio">
                        <label class="form-check-label">
                          <input type="radio" class="form-check-input" name="keterangan" value="pulang" <?php if(($a>12) || ($a<5)) echo 'checked'; ?>> Absen Pulang
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="row form-group">
                    <div class="col col-md-2">
                      <label for="select" class=" form-control-label">NIP</label>
                    </div>
                    <div class="col-12 col-md-9">
                      <select name="nip" data-placeholder="Silahkan pilih pegawai" class="form-control standardSelect" tabindex="1" required="">
                        <option value=""></option>
                        <?php
                        foreach ($pegawai as $rowlok) {
                            echo "<option value=$rowlok->nip>$rowlok->nip / $rowlok->nama</option>";
                        } ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-lg-2 control-label"></label>
                    <div class="col-sm-8">
                      <button type="submit" name="presensi" class="btn btn-success mr-2">Absen</button>
                    </div>
                  </div>
                </form>
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-list">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Nama Pegawai</th>
                        <th>Tanggal</th>
                        <th>Masuk</th>
                        <th>Pulang</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                      $no = 1;
                      foreach ($presensi as $row) {?>
                        <tr>
                          <td><?= $no ?></td>
                          <td><?= $row->nama_pegawai ?></td>
                          <td><?= $row->tanggal ?></td>
                          <td><?= $row->jam_masuk ?></td>
                          <td><?= $row->jam_pulang ?></td>
                          <td align="center">
                            <a href="#" data-toggle='modal' data-target='#konfirmasi_hapus<?php echo $row->id_absen;?>' class="btn btn-danger"><em class="mdi mdi-delete-variant"></em></a>
                          </td>
                        </tr>
                        <?php $no++;
                      } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!--collapse end-->
      </div>
    </div>
  </div>
</div>
<?php 
foreach($presensi as $i){
  $id_absen=$i->id_absen;
?>
<div class="modal fade" id="konfirmasi_hapus<?php echo $id_absen;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="form-horizontal" method="post" action="<?= base_url().'admin/hapus_presensi'?>">
        <div class="modal-body">
          Anda yakin ingin menghapus data presensi ini?<br><br>
          <input type="hidden" name="id" value="<?= $id_absen;?>">
          <button type="submit" class="btn btn-primary">Hapus</button>
          <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php }?>
<script src="<?= base_url()?>assets/vendors/js/vendor.bundle.base.js"></script>
<script src="<?= base_url()?>assets/js/misc.js"></script>
<script>
  window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
      $(this).remove(); 
    });
  }, 2000);
</script>