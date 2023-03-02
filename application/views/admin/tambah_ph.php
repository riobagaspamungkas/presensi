<link rel="stylesheet" href="<?= base_url() ?>assets/vendors/css/vendor.bundle.addons.css">
    <!-- partial -->
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="row">
          <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Tambah Hari Libur</h4>
                <div class="col-18">
                  <div class="card">
                    <form class="forms-sample" method="post" enctype="multipart/form-data" action="<?= base_url()?>admin/t_ph">
                      <div class="form-group row">
                        <label for="tgl" class="col-sm-2 col-form-label">Tanggal</label>
                        <div class="col-sm-9">
                          <input type="date" class="form-control" name="tgl" required="">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="keterangan" class="col-sm-2 col-form-label">Keterangan</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" name="keterangan" placeholder="Masukkan Libur Nasional" required="">
                        </div>
                      </div>
                      <button type="submit" name="tambah" class="btn btn-success mr-2">Simpan</button>
                      <a href="<?= base_url()?>admin/ph" class="btn btn-light"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
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