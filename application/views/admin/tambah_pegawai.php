<link rel="stylesheet" href="<?= base_url() ?>assets/vendors/css/vendor.bundle.addons.css">
    <!-- partial -->
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="row">
          <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Tambah Pegawai</h4>
                <div class="col-18">
                  <div class="card">
                    <form class="forms-sample" method="post" enctype="multipart/form-data" action="<?= base_url()?>admin/t_pegawai">
                      <div class="form-group row">
                        <label for="nip" class="col-sm-2 col-form-label">NIP</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" name="nip" placeholder="Masukkan NIP" required="">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama Pegawai</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" name="nama" placeholder="Masukkan Nama Pegawai" required="">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="pass" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-9">
                          <input type="password" class="form-control" name="pass" placeholder="Masukkan password" required="">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="akses" class="col-sm-2 col-form-label">Hak Akses</label>
                        <div class="col-sm-9">
                          <select name="akses" class="form-control" required="">
                            <option value="">Silahkan pilih</option>
                            <option value="admin">Admin</option>
                            <option value="pegawai">Pegawai</option>
                            <option value="kepala">Kepala Sekolah</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="gol" class="col-sm-2 col-form-label">Golongan</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" name="gol" placeholder="Masukkan Golongan" required="">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="jk" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                        <div class="col-sm-9">
                          <select name="jk" class="form-control" required="">
                            <option value="">Silahkan pilih</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                          </select>
                        </div>
                      </div>
                        <div class="form-group row">
                          <label for="jbtn" class="col-sm-2 col-form-label">Jabatan</label>
                          <div class="col-lg-9">
                            <select name="jbtn" class="form-control" required="">
                              <option value="">Silahkan pilih</option>
                            <?php
                            foreach ($data_jabatan as $row) :
                              echo "<option value=$row->id_jbtn > $row->nama_jbtn </option>";
                            endforeach; 
                            ?>
                          </select>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="bukti" class="col-sm-2 col-form-label">Foto (max 2,5 MB)</label>
                          <div class="col-sm-9">
                            <input type="file" name="foto" accept="image/png, image/gif, image/jpeg" class="form-control" title="Choose a pdf please" required="">
                          </div>
                        </div>
                        <button type="submit" name="tambah" class="btn btn-success mr-2">Simpan</button>
                        <a href="<?= base_url()?>admin/data_pegawai" class="btn btn-light"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
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