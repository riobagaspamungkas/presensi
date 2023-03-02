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
<style type="text/css">
img.center {
  display: block;
  margin-left: auto;
  margin-right: auto;
}
</style>
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
            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h5 style="text-align:center">
                    <?php
                    date_default_timezone_set("Asia/Jakarta");
                    $today = date('Y-m-d'); 
                    $a = date ("H");
                    if (($a>=6) && ($a<=11)) {
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
                  <div class="row">
                    <div class="col-md-12" style="text-align:center">
                      <button id="btn-absen-datang" class="btn btn-primary mr-2">Absen Masuk</button>
                      <button id="btn-absen-pulang" class="btn btn-danger mr-2">Absen Pulang</button>
                      <br><br>
                      <div id="infoabsensi"></div>
                      <?php if ($data_setting->lokasi == 1) { ?>
                        <div id='maps-absen' style='width: 100%; height:250px;'></div>
                        <hr>
                      <?php
                      } else { ?>
                        <img src="<?= base_url() ?>assets/images/fingerprint.png" width="300" class="center">
                      <?php } ?>
                    </div>
                    <div class="col-md-12">
                      <h4 style="text-align:center">
                        <?php 
                        echo 'Presensi '.$data_user_login->nama;
                        ?>
                      </h4>
                      <br>
                      <form class="forms-sample" id="filter" method="post">
                        <div class="form-group row">
                          <label for="tgl_dari" class="col-sm-2 col-form-label">Dari Tanggal : </label>
                          <div class="col-sm-3">
                            <input type="date" class="form-control" name="tgl_dari" placeholder="Masukkan tanggal" value="<?php echo $tgl_dari ?>" required="">
                          </div>
                          <label for="tgl_sampai" class="col-sm-3 col-form-label">Sampai Tanggal : </label>
                          <div class="col-sm-3">
                            <input type="date" class="form-control" name="tgl_sampai" placeholder="Masukkan tanggal" value="<?php echo $tgl_sampai ?>" required="">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="filtgl" class="col-sm-6 control-label">Centang untuk belum absen atau bermasalah
                            <input type="hidden" name="filtgl" value="8">
                            <?php
                            if ($centang == 0){
                              echo '<input type="checkbox" name="filtgl" value="" checked>';
                            }elseif ($centang >= 1){
                              echo '<input type="checkbox" name="filtgl" value="">';
                            }
                            ?>
                          </label>
                        </div>
                        <div class="form-group row">
                          <div class="col-sm-7">
                            <button type="submit" name="tombolfilter" class="btn btn-success mr-2">Cari</button>
                            <?php 
                            if (isset($_POST['tombolfilter'])) { ?>
                              <button type="submit" formtarget="_blank" name="export" class="btn btn-primary mr-2"><em class="mdi mdi-export"></em> Cetak</button>
                            <?php } ?>
                          </div>
                        </div>
                      </form>
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered table-list">
                          <thead style="text-align:center">
                            <tr>
                              <th>Tanggal</th>
                              <th>Jam Masuk</th>
                              <th>Jam Pulang</th>
                              <th>Keterangan</th>
                              <th>Aksi</th>
                            </tr>
                          </thead>
                          <tbody style="text-align:center">
                            <?php
                            foreach ($rowpresensi as $row) {?>
                              <tr>
                                <td><?= $row->dateget ?></td>
                                <td style='background-color:<?= $row->colorm ?>'><?= $row->time_masuk ?></td>
                                <td style='background-color:<?= $row->colorp ?>'><?= $row->time_pulang ?></td>
                                <td align="left"><?= $row->status_absen ?></td>
                                <td>
                                  <?php 
                                  if (!empty($row->id_absen)) { ?>
                                    <a href="<?= base_url() ?>kepala/detail_kehadiran/<?= $row->id_absen;?>/dashboard" class="btn btn-dark">Detail</a>
                                  <?php 
                                  } else {
                                    echo '-';
                                  }
                                  ?>
                                </td>
                              </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
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
  <script src="<?= base_url()?>assets/vendors/js/vendor.bundle.base.js"></script>
  <script src="<?= base_url()?>assets/js/off-canvas.js"></script>
  <script src="<?= base_url()?>assets/js/misc.js'"></script>
  <script src="<?= base_url()?>assets/js/dashboard.js"></script>
  <script src="<?= base_url()?>assets/tables/jquery.dataTables.js"></script>
  <script src="<?= base_url()?>assets/tables/dataTables.bootstrap.js"></script>
  <script src="<?= base_url()?>assets/tables/dataTables.bootstrap.css"></script>
  <script src="<?= base_url()?>assets/vendors/js/vendor.bundle.addons.js"></script>
  <script src="<?= base_url()?>assets/datepicker/js/bootstrap-datepicker.js"></script>
  <script src="<?= base_url()?>assets/vendors/jquery/jquery.min.js"></script>
  <script src="<?= base_url()?>assets/vendors/sweetalert2/sweetalert2.all.min.js"></script>

  <script>
    <?php if ($data_setting->lokasi == 1) : ?>
      let maps_absen = "searching...";
      if (document.getElementById("maps-absen")) {
        window.onload = function() {
          var popup = L.popup();
          var geolocationMap = L.map("maps-absen", {
            center: [0.888897, 104.580942],
            zoom: 15,
            zoomControl: false,
            attributionControl: false,
          });
          L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            attribution: '',
          }).addTo(geolocationMap);
          function geolocationErrorOccurred(geolocationSupported, popup, latLng) {
            popup.setLatLng(latLng);
            popup.setContent(
              geolocationSupported ?
              "<b>Error:</b> The Geolocation service failed." :
              "<b>Error:</b> This browser doesn't support geolocation."
            );
            popup.openOn(geolocationMap);
          }
          if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
              function(position) {
                var latLng = {
                  lat: position.coords.latitude,
                  lng: position.coords.longitude,
                };
                var marker = L.marker(latLng).addTo(geolocationMap);
                maps_absen = position.coords.latitude + ", " + position.coords.longitude;
                geolocationMap.setView(latLng);
              },
              function() {
                geolocationErrorOccurred(true, popup, geolocationMap.getCenter());
                maps_absen = 'No Location';
              }
            );
          } else {
            //No browser support geolocation service
            geolocationErrorOccurred(false, popup, geolocationMap.getCenter());
            maps_absen = 'No Location';
          }
        };
      }
    <?php elseif ($data_setting->lokasi == 0) : ?>
        maps_absen = 'No Location';
    <?php endif; ?>

    $("#btn-absen-datang").click(function(e) {
      $.ajax({
        type: "POST",
        url: '<?= base_url();?>kepala/absen/datang',
        data: {maps_absen: maps_absen}, // serializes the form's elements.
        beforeSend: function() {
          swal.fire({
              imageUrl: "<?= base_url(); ?>assets/images/ajax-loader.gif",
              title: "Proses Presensi",
              text: "Please wait",
              showConfirmButton: false,
              allowOutsideClick: false
          });
        },
        success: function(response) {
          location.reload();
        },
        error: function() {
          location.reload();
        }
      });
    });

    $("#btn-absen-pulang").click(function(e) {
      $.ajax({
        type: "POST",
        url: '<?= base_url();?>kepala/absen/pulang',
        data: {maps_absen: maps_absen}, // serializes the form's elements.
        beforeSend: function() {
          swal.fire({
              imageUrl: "<?= base_url(); ?>assets/images/ajax-loader.gif",
              title: "Proses Presensi",
              text: "Please wait",
              showConfirmButton: false,
              allowOutsideClick: false
          });
        },
        success: function(response) {
          location.reload();
        },
        error: function() {
          location.reload();
        }
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
    window.setTimeout(function() {
      $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
      });
    }, 2000);
  </script>
</body>
</html>
