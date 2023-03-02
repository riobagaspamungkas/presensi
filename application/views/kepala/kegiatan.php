<?php
date_default_timezone_set("Asia/Jakarta");
$today = date('m/d/Y');
?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h3 style="text-align:center">Kegiatan Harian</h3>
                  <br>
                  <?php echo $this->session->flashdata('msg');?>
                  <form class="forms-sample" method="post" enctype="multipart/form-data" action="<?= base_url()?>kepala/tambah_kegiatan">
                    <div class="form-group row">
                      <div class="col-sm-2" style="float:none;margin:auto;">
                        <input type="text" name="get_date" style="text-align:center" class="form-control" id="datepicker" value="<?php echo $today ?>" readonly>
                      </div>
                    </div>
                    <div class="table-responsive">
                      <table class="table table-striped table-bordered table-list" id="tableData">
                        <thead style="text-align:center">
                          <tr>
                            <th>NO</th>
                            <th>Jam Mulai</th>
                            <th>Jam Selesai</th>
                            <th>Judul Kegiatan</th>
                            <th>Aksi</th>
                          </tr>
                        </thead>
                        <tbody style="text-align:center">
                          <?php
                          $no = 1;
                          foreach ($kegiatan as $row) {
                            echo "<tr align='text-center'>
                                <td>".$no."</td>
                                <td>".$row->jam_dari."</td>
                                <td>".$row->jam_sampai."</td>
                                <td>".$row->title."</td>";
                            ?>
                            <td align="center">
                              <a href="<?= base_url() ?>kepala/detail_kegiatan/<?= $row->id_deskripsi;?>" class="btn btn-dark"><em class="mdi mdi-information-outline"></em></a>
                              <a href="<?= base_url().'kepala/update_kegiatan/'.$row->id_deskripsi?>" class="btn btn-primary"><em class="mdi mdi-table-edit"></em></a>
                              <a href="#" data-toggle='modal' data-target='#konfirmasi_hapus<?php echo $row->id_deskripsi;?>' class="btn btn-danger"><em class="mdi mdi-delete-variant"></em></a>
                            </td>
                            </tr>
                          <?php
                          $no++; 
                          } ?>
                        </tbody>
                      </table>
                    </div>
                    <br>
                    <div class="col-sm-3" style="float:none;margin:auto;text-align:center;">
                      <button type="submit" name="get_kegiatan" class="btn btn-primary">Tambah</button>
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
  <?php 
    foreach($modal->result() as $i){
      $id_deskripsi=$i->id_deskripsi;
    ?>
    <div class="modal fade" id="konfirmasi_hapus<?php echo $id_deskripsi;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form class="form-horizontal" method="post" action="<?= base_url().'kepala/hapus_kegiatan'?>">
            <div class="modal-body">
              <p>Anda yakin mau menghapus data ini ?</p>
              <input type="hidden" name="id_deskripsi" value="<?= $id_deskripsi;?>">
              <button type="submit" class="btn btn-primary">Hapus</button>
              <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Batal</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  <?php } ?>
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
  <script type="text/javascript">
    //konfirmasi modal delete data pegawai
    $(document).ready(function() {
        $('#konfirmasi_hapus').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        });
    });
  </script>
  <script type="text/javascript">
    $("#datepicker").datepicker({
      dateFormat: 'yyyy-mm-dd',
      autoclose: true,
      todayHighlight: true,
    }).on("changeDate", function (e) {
      var date = $("#datepicker").val();
      $.ajax({
        url : "<?= base_url() ?>kepala/data_kegiatan",
        type : "POST",
        cache: false,
        data : {date: date},
        success:function(result){
          $("#tableData tbody").html(result);
        }
      });
    });
  </script>
</body>
</html>