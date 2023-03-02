<link rel="stylesheet" href="<?= base_url() ?>assets/vendors/css/vendor.bundle.addons.css">
    <!-- partial -->
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="row">
          <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Edit Pegawai</h4>
                <div class="col-18">
                  <div class="card">
                    <form class="forms-sample" method="post" enctype="multipart/form-data" action="<?= base_url().'admin/e_pegawai' ?>">
                      <div class="form-group row">
                        <label for="nip" class="col-sm-2 col-form-label">NIP</label>
                        <div class="col-sm-9">
                          <input type="hidden" name="get_nip" value="<?= $getdatapegawai->nip; ?>">
                          <input type="number" class="form-control" name="nip" value="<?= $getdatapegawai->nip; ?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama Pegawai</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" name="nama" value="<?= $getdatapegawai->nama; ?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="hak_akses" class="col-sm-2 col-form-label">Hak Akses</label>
                        <div class="col-sm-9">
                          <select name="akses" class="form-control">
                            <?php 
                            $akses = $getdatapegawai->akses;
                            ?>
                            <option value="admin" <?php if($akses=="admin") echo 'selected="selected"'; ?> >Admin</option>
                            <option value="pegawai" <?php if($akses=="pegawai") echo 'selected="selected"'; ?> >Pegawai</option>
                            <option value="kepala" <?php if($akses=="kepala") echo 'selected="selected"'; ?> >Kepala Sekolah</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="gol" class="col-sm-2 col-form-label">Golongan</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" name="gol" value="<?= $getdatapegawai->gol; ?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="jk" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                        <div class="col-sm-9">
                          <select name="jk" class="form-control">
                            <?php 
                            $jk = $getdatapegawai->jk;
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
                            foreach ($data_jabatan as $rowjb){
                              echo "<option value=$rowjb->id_jbtn ";
                              if ($rowjb->id_jbtn == $getdatapegawai->jbtn) {
                                echo "selected='selected'";
                              }
                              echo " >$rowjb->nama_jbtn</option>";
                            } ?>
                          </select>
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
                    <br><br><br>
                    <h4>Ganti Password</h4>
                    <form class="forms-sample" method="post" action="<?= base_url().'admin/ganti_password/data_pegawai' ?>">
                      <div class="form-group row">
                        <label for="password_lama" class="col-sm-2 col-form-label">Password Lama</label>
                        <div class="col-sm-9">
                          <input type="hidden" name="get_nip" value="<?= $getdatapegawai->nip; ?>">
                          <input type="hidden" name="get_password" value="<?= $getdatapegawai->pass; ?>">
                          <input name="password_lama" class="form-control" type="password" value="" required="">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="password_baru" class="col-sm-2 col-form-label">Password Baru</label>
                        <div class="col-sm-9">
                          <input  name="password_baru" class="form-control" type="password" value="" required="">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="konf_password_baru" class="col-sm-2 col-form-label">Konfirmasi Password Baru</label>
                        <div class="col-sm-9">
                          <input  name="konf_password_baru" class="form-control" type="password" value="" required="">
                        </div>
                      </div>
                      <button type="submit" name="update_password" class="btn btn-success mr-2">Simpan</button>
                      <a href="<?= base_url().'admin/data_pegawai' ?>" class="btn btn-light"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
                    </form>
                    <br /><br /><br />
                    <h4 class="card-title">Reset Password</h4>
                    <form class="forms-sample">
                      <a href="#" data-toggle='modal' data-target='#reset_password<?= $getdatapegawai->nip;?>' class="btn btn-danger" class="btn btn-danger mr-2">Reset</a>
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
<div class="modal fade" id="reset_password<?= $getdatapegawai->nip;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="form-horizontal" method="post" action="<?= base_url().'admin/resetpassword/data_pegawai'?>">
        <div class="modal-body">
          <b>Anda yakin ingin mereset password?</b><br><br>
          <input type="hidden" name="nip" value="<?= $getdatapegawai->nip;?>">
          <button type="submit" class="btn btn-primary">Reset</button>
          <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>