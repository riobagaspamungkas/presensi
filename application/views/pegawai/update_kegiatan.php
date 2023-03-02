<link rel="stylesheet" href="<?= base_url() ?>assets/vendors/css/vendor.bundle.addons.css">
    <!-- partial -->
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="row">
          <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Edit Kegiatan</h4>
                <div class="col-18">
                  <div class="card">
                    <form class="forms-sample" method="post" enctype="multipart/form-data" action="<?= base_url()?>pegawai/e_kegiatan">
                      <div class="form-group row">
                        <label for="nip" class="col-sm-2 col-form-label">NIP</label>
                        <div class="col-sm-9">
                          <input name="get_id" type="hidden" value="<?= $desk_kegiatan->id_deskripsi ?>" >
                          <input type="text" class="form-control" name="nip" value="<?php echo $data_user_login->nip ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama Pegawai</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" name="nama" value="<?php echo $data_user_login->nama ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="tgl" class="col-sm-2 col-form-label">Tanggal</label>
                        <div class="col-sm-9">
                          <input type="date" class="form-control" name="tgl" value="<?php echo $getdatakegiatan->tanggal_kegiatan; ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="judul" class="col-sm-2 col-form-label">Judul Kegiatan</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" name="judul" placeholder="Masukkan judul" value="<?php echo $desk_kegiatan->title; ?>" required>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label for="mulai" class="col-sm-4 col-form-label">Jam Mulai</label>
                            <div class="col-sm-1.5">
                              <select name="jam_mulai" class="form-control" required="">
                                <?php 
                                for ($i=1; $i < 24; $i++) { ?>
                                  <option value='<?php echo $i ?>' <?php if($i==date('H',strtotime($desk_kegiatan->jam_dari))) echo 'selected="selected"'; ?> ><?php if($i<10) echo '0'.$i; else echo $i; ?></option>
                                <?php }
                                ?>
                              </select>
                            </div>
                            <div class="col-form-label">:</div>
                            <div class="col-sm-1.5">
                              <select name="menit_mulai" class="form-control" required="">
                                <?php 
                                for ($i=0; $i < 60; $i++) { ?>
                                  <option value='<?php echo $i ?>' <?php if($i==date('i',strtotime($desk_kegiatan->jam_dari))) echo 'selected="selected"'; ?> ><?php if($i<10) echo '0'.$i; else echo $i; ?></option>
                                <?php }
                                ?>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label for="selesai" class="col-sm-4 col-form-label">Jam Selesai</label>
                            <div class="col-sm-1.5">
                              <select name="jam_selesai" class="form-control" required="">
                                <?php 
                                for ($i=1; $i < 24; $i++) {?>
                                  <option value='<?php echo $i ?>' <?php if($i==date('H',strtotime($desk_kegiatan->jam_sampai))) echo 'selected="selected"'; ?> ><?php if($i<10) echo '0'.$i; else echo $i; ?></option>
                                <?php }
                                ?>
                              </select>
                            </div>
                            <div class="col-form-label">:</div>
                            <div class="col-sm-1.5">
                              <select name="menit_selesai" class="form-control" required="">
                                <?php 
                                for ($i=0; $i < 60; $i++) { ?>
                                  <option value='<?php echo $i ?>' <?php if($i==date('i',strtotime($desk_kegiatan->jam_sampai))) echo 'selected="selected"'; ?> ><?php if($i<10) echo '0'.$i; else echo $i; ?></option>
                                <?php }
                                ?>
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="deskripsi" class="col-sm-2 col-form-label">Deskripsi Kegiatan</label>
                        <div class="col-sm-9">
                          <textarea type="text" class="form-control" name="deskripsi" placeholder="Masukkan Keterangan"  required><?php echo $desk_kegiatan->deskripsi; ?></textarea>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="lampiran" class="col-sm-2 col-form-label">Lampiran gambar/pdf (max 2,5 MB)</label>
                        <div class="col-sm-9">
                          <input type="file" name="lampiran" accept="application/pdf, image/png, image/gif, image/jpeg" class="form-control" title="Choose a pdf please" >
                        </div>
                      </div>
                      <button type="submit" name="edit" class="btn btn-success mr-2">Simpan</button>
                      <a href="<?= base_url()?>pegawai/kegiatan" class="btn btn-light"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
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