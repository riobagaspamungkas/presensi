<script src="<?= base_url() ?>assets/bootstrap/js/jquery.min.js"></script>
<script src="<?= base_url() ?>assets/bootstrap/js/bootstrap.min.js"></script>
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                      <?php
                      $upload_dir = '../images/foto/';
                      foreach ($rowkegiatan as $row) {
                        $get_nip = $row[0]->get_nip;
                        $jumlahrow = $row[0]->jumlahrow;
                        ?>
                        <div class="carousel-item <?php if ( $get_nip == $nip ) echo 'active'; ?>">
                          <div class="row">
                            <div class="col-sm-1 table-dark"></div>
                            <div class="col-sm-2 border border-dark">
                              <p style="text-align:center">Info Pegawai
                              <img src="<?php echo base_url().'assets/images/foto/'.$row[0]->gambar?>" class="col-sm-12 d-block" alt="gambar"><?php echo $row[0]->nama_pegawai.'<br>'.$row[0]->jabatan ?></p>
                            </div>
                            <div class="col-sm-8">
                              <div class="table-responsive">
                                <table class="table table-striped table-bordered table-list">
                                  <thead style="text-align:center">
                                    <tr>
                                      <th class="col-3">Waktu</th>
                                      <th>Kegiatan</th>
                                      <th>Keterangan</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                    if ($jumlahrow>0) {
                                      for ($i=0; $i < $jumlahrow; $i++) { 
                                        echo "<tr>";
                                        echo "<td>".$row[$i]->jam_dari ."-". $row[$i]->jam_sampai."</td>";
                                        echo "<td>".$row[$i]->deskripsi."</td>";?>
                                        <td align="center">
                                          <a href="<?= base_url() ?>pegawai/detail_kegiatan/<?= $row[$i]->id_deskripsi;?>" class="btn btn-dark">Detail</a>
                                        </td>
                                      <?php
                                      }
                                    }else{
                                      echo "<tr>";
                                      echo "<td colspan='3' style='text-align:center' height='100'>Belum mengisi kegiatan</td>";
                                      echo "</tr>";
                                    }
                                    ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                            <div class="col-sm-1 table-dark"></div>
                          </div>
                        </div>
                        <?php
                      }?>
                    </div>
                    <a class="col-sm-1 carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="sr-only">Previous</span>
                    </a>
                    <a class="col-sm-1 carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="sr-only">Next</span>
                    </a>
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
</body>
</html>