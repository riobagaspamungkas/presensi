<link rel="stylesheet" href="<?= base_url() ?>assets/vendors/css/vendor.bundle.addons.css">
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Histori Permohohan Izin / Cuti</h4>
                  <div class="form-group row">
                    <div class="col-sm-2" style="float:none;margin:auto;">
                      <select name="cuti_dl" id="cuti_dl" class="form-control">
                        <option value="cuti dl" selected>Semua</option>
                        <option value="cuti">Izin / Cuti</option>
                        <option value="dl">Dinas Luar</option>
                      </select>
                    </div>
                  </div>
                  <div class="table-responsive">
                    <table class="table table-striped table-bordered table-list" id="tableData">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Pegawai</th>
                          <th>Tanggal</th>
                          <th>Jenis Permohonan</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                        $no = 1;
                        foreach ($histori as $row) {
                          $time = strtotime($row->time);
                          ?>
                          <tr>
                            <td><?= $no ?></td>
                            <td><?= $row->get_name ?></td>
                            <td><?= $row->tgl_awal." - ".$row->tgl_akhir ?></td>
                            <td><?= $row->jenis_permohonan ?></td>
                            <td align="center">
                              <a href="<?= base_url() ?>pegawai/detail_permohonan/<?= $time;?>/<?= $row->tabel;?>" class="btn btn-dark">Detail</a>
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
        </div>
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
  <script>
    window.setTimeout(function() {
      $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
      });
    }, 2000);
  </script>
  <script>
    $(".table").DataTable();
  </script>
  <script type="text/javascript">
    $( document ).ready(function() {
      $('#cuti_dl').change(function() {
        var workselected = $(this).val();
        $.ajax({
          url: "<?= base_url() ?>pegawai/data_histori",
          type: "POST",
          cache:false,
          data: {cuti_dl:workselected},
          success:function(result){
            $("#tableData tbody").html(result);
          }
        });
      });
    });
  </script>
</body>
</html>