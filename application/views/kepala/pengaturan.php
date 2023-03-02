<link rel="stylesheet" href="<?= base_url() ?>assets/vendors/css/vendor.bundle.addons.css">
    <!-- partial -->
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="row">
          <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Edit Akun</h4>
                <?php echo $this->session->flashdata('msg');?>
                <div class="col-18">
                  <div class="card">
                    <form class="forms-sample" method="post" enctype="multipart/form-data" action="<?= base_url().'kepala/e_akun' ?>">
                      <div class="form-group row">
                        <label for="nip" class="col-sm-2 col-form-label">NIP</label>
                        <div class="col-sm-9">
                          <input type="hidden" name="get_nip" value="<?= $data_user_login->nip; ?>">
                          <input type="number" class="form-control" name="nip" value="<?= $data_user_login->nip; ?>" disabled>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama Pegawai</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" name="nama" value="<?= $data_user_login->nama; ?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="gol" class="col-sm-2 col-form-label">Golongan</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" name="gol" value="<?= $data_user_login->gol; ?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="jk" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                        <div class="col-sm-9">
                          <select name="jk" class="form-control">
                            <?php 
                            $jk = $data_user_login->jk;
                            ?>
                            <option value="laki-laki" <?php if($jk=="laki-laki") echo 'selected="selected"'; ?> >Laki-laki</option>
                            <option value="perempuan" <?php if($jk=="perempuan") echo 'selected="selected"'; ?> >Perempuan</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="jbtn" class="col-sm-2 col-form-label">Jabatan</label>
                        <div class="col-sm-9">
                          <select name="jbtn" class="form-control">
                            <?php
                            foreach ($data_jabatan as $rowjb) :
                              echo "<option value=$rowjb->id_jbtn ";
                              if ($rowjb->id_jbtn == $data_user_login->jbtn) {
                                echo "selected='selected'";
                              }
                              echo " >$rowjb->nama_jbtn</option>";
                            endforeach; ?>
                          </select>
                        </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="foto" class="col-sm-2 col-form-label">Foto (max 2,5 MB)</label>
                          <div class="col-12 col-md-9">
                            <input type="file" name="foto" accept="image/png, image/gif, image/jpeg" class="form-control">
                          </div>
                      </div>
                      <button type="submit" name="update_pegawai" class="btn btn-success mr-2">Simpan</button>
                    </form>
                    <br /><br /><br />
                    <h4 class="card-title">Ganti Password</h4> 
                    <form class="forms-sample" method="post" action="<?= base_url()?>kepala/ganti_password/pengaturan">
                      <div class="form-group row">
                        <label for="password_lama" class="col-sm-2 col-form-label">Password Lama</label>
                        <div class="col-sm-9">
                          <input type="hidden" name="get_nip" value="<?= $data_user_login->nip; ?>">
                          <input type="hidden" name="get_password" value="<?= $data_user_login->pass; ?>">
                          <input name="password_lama" class="form-control" type="password" value="">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="password_baru" class="col-sm-2 col-form-label">Password Baru</label>
                        <div class="col-sm-9">
                          <input  name="password_baru" class="form-control" type="password" value="">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="konf_password_baru" class="col-sm-2 col-form-label">Konfirmasi Password Baru</label>
                        <div class="col-sm-9">
                          <input  name="konf_password_baru" class="form-control" type="password" value="">
                        </div>
                      </div>
                      <button type="submit" name="update_password" class="btn btn-success mr-2">Simpan</button>
                      <a href="<?= base_url().'kepala/' ?>" class="btn btn-light"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
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
<script>
  window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
      $(this).remove(); 
    });
  }, 2000);
</script>