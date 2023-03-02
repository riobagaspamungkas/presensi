<?php
date_default_timezone_set("Asia/Jakarta");
$today = date('m/d/Y');

function tgl_indo($tanggal){
    $bulan = array (
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $pecahkan = explode('-', $tanggal);

    // variabel pecahkan 0 = tanggal
    // variabel pecahkan 1 = bulan
    // variabel pecahkan 2 = tahun
 
    return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}
?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h3 style="text-align:center">Data Kehadiran Pegawai</h3>
                  <br>
                  <?php echo $this->session->flashdata('msg');?>
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
                          <th>Nama Pegawai</th>
                          <th>Jam Masuk</th>
                          <th>Jam Pulang</th>
                          <th>Keterangan</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody style="text-align:center">
                        <?php
                        $no = 1;
                        foreach ($datakehadiran as $row) {
                          echo "<tr align='text-center'>
                              <td>".$no."</td>
                              <td align='left'>".$row->nama."</td>
                              <td>".$row->jam_masuk."</td>
                              <td>".$row->jam_pulang."</td>
                              <td align='left'>".$row->status_absen."</td>";
                          ?>
                          <td align="center">
                            <a href="<?= base_url() ?>kepala/detail_kehadiran/<?= $row->id_absen;?>/kehadiran" class="btn btn-dark">Detail</a>
                          </td>
                          </tr>
                        <?php $no++; } ?>
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
  <script type="text/javascript">
    $("#datepicker").datepicker({
      dateFormat: 'yyyy-mm-dd',
      autoclose: true,
      todayHighlight: true,
    }).on("changeDate", function (e) {
      var date = $("#datepicker").val();
      $.ajax({
        url : "<?= base_url() ?>kepala/data_kehadiran",
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