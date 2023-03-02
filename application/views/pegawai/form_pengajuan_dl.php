<link rel="stylesheet" href="<?= base_url() ?>assets/vendors/css/vendor.bundle.addons.css">
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Permohohan Dinas Luar</h4>
                  <div class="col-18">
                    <div class="card">
                      <form class="forms-sample" method="post" enctype="multipart/form-data" action="<?= base_url()?>pegawai/t_pengajuan_dl">
                        <div class="form-group row">
                          <label for="nip" class="col-sm-2 col-form-label">Nomor Surat Perintah Tugas</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="spt" placeholder="Boleh di Kosongkan">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="nama" class="col-sm-2 col-form-label">Pegawai yang di perintah</label>
                          <div class="col-sm-9">
                            <table class="table table-bordered" id="field">
                              <tr>
                                <td>
                                  <select name="nip[]" class="form-control name_list" required="">
                                    <option value="">Silahkan pilih pegawai</option>
                                    <?php
                                    foreach ($pegawai as $rownip) {
                                        echo "<option value=$rownip->nip>$rownip->nip / $rownip->nama</option>";
                                    } ?>
                                  </select>
                                </td>
                                <td><button type="button" name="tmb" id="tmb" class="btn btn-success">+</button></td>
                              </tr>
                            </table>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="tgl_dari" class="col-sm-2 col-form-label">Tanggal Berangkat</label>
                          <div class="col-sm-9">
                            <input type="date" class="form-control" name="tgl_berangkat" required>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="tgl_sampai" class="col-sm-2 col-form-label">Tanggal Kembali</label>
                          <div class="col-sm-9">
                            <input type="date" class="form-control" name="tgl_kembali" required>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="bukti" class="col-sm-2 col-form-label">Bukti pengajuan pdf/jpg/png (max 5 MB)</label>
                          <div class="col-sm-9">
                            <input type="file" name="bukti" accept="application/pdf, image/png, image/gif, image/jpeg" class="form-control" title="Choose a pdf please" required>
                          </div>
                        </div>
                        <button type="submit" name="kirim" class="btn btn-success mr-2">Simpan</button>
                        <a href="<?= base_url()?>pegawai/pengajuan_dl" class="btn btn-light"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
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
  <script src="<?= base_url()?>assets/vendors/js/vendor.bundle.base.js"></script>
  <script src="<?= base_url()?>assets/js/off-canvas.js"></script>
  <script src="<?= base_url()?>assets/js/misc.js'"></script>
  <script src="<?= base_url()?>assets/js/dashboard.js"></script>
  <script src="<?= base_url()?>assets/tables/jquery.dataTables.js"></script>
  <script src="<?= base_url()?>assets/tables/dataTables.bootstrap.js"></script>
  <script src="<?= base_url()?>assets/tables/dataTables.bootstrap.css"></script>
  <script src="<?= base_url()?>assets/vendors/js/vendor.bundle.addons.js"></script>
  <script src="<?= base_url()?>assets/datepicker/js/bootstrap-datepicker.js"></script>
  <script src="<?= base_url()?>assets/js/jquery.multiselect.js"></script>
  <script>
    $(document).ready(function(){
      var j=1;
      $('#tmb').click(function(){
        j++;
        $('#field').append('<tr id="row'+j+'"><td><select name="nip[]" class="form-control name_list"><option value="">Silahkan pilih pegawai</option> <?php foreach ($pegawai as $rownip) { echo "<option value=$rownip->nip>$rownip->nip / $rownip->nama</option>"; } ?></select></td><td><button type="button" name="remove" id="'+j+'" class="btn btn-danger btn_remove">X</button></td></tr>');
      });
      
      $(document).on('click', '.btn_remove', function(){
        var button_id = $(this).attr("id"); 
        $('#row'+button_id+'').remove();
      });  
    });
  </script>
  <script>
    // Function ini dijalankan ketika Halaman ini dibuka pada browser
    $(function(){
      setInterval(timestamp, 1000);//fungsi yang dijalan setiap detik, 1000 = 1 detik
    });
     
    //Fungi ajax untuk Menampilkan Jam dengan mengakses File ajax_timestamp.php
    function timestamp() {
      $.ajax({
        url: '<?= base_url() ?>assets/jtime.php',
        success: function(data) {
          $('#timestamp').html(data);
        },
      });
    }
  </script>
  <script>
    $(".table").DataTable();
  </script>
</body>
</html>