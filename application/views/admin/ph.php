<link rel="stylesheet" href="<?= base_url() ?>assets/vendors/css/vendor.bundle.addons.css">
    <!-- partial -->
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="row">
          <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Data Hari Libur</h4>
                <div class="col-xs-12 col-md-12 col-lg-12">
                  <a href="<?= base_url() ?>admin/tambah_ph" style="float: right;" class="btn btn-secondary"><em class="mdi mdi-plus"></em> Tambah Hari Libur</a><br>
                </div>
                <br>
                <?php echo $this->session->flashdata('msg');?>
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-list">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                    $no = 1;
                    foreach ($getData->result() as $row) {
                      echo "<tr>";
                      echo "<td>$no</td>";
                      echo "<td>$row->tanggal</td>";
                      echo "<td>$row->keterangan</td>";
                      $getgl = strtotime($row->tanggal);
                      ?>
                      <td align="center">
                        <a href="<?= base_url().'admin/edit_ph/'.$row->tanggal?>" class="btn btn-primary"><em class="mdi mdi-table-edit"></em></a>
                        <a href="#" data-toggle='modal' data-target='#konfirmasi_hapus<?php echo $row->tanggal;?>' class="btn btn-danger"><em class="mdi mdi-delete-variant"></em></a>
                      </td>
                      </tr><?php
                      $no++;
                    }
                    ?>
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
<?php 
  foreach($getData->result() as $i):
    $tanggal=$i->tanggal;
  ?>
  <div class="modal fade" id="konfirmasi_hapus<?php echo $tanggal;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form class="form-horizontal" method="post" action="<?= base_url().'admin/hapus_ph'?>">
          <div class="modal-body">
            Anda yakin ingin menghapus data ini ?<br><br>
            <input type="hidden" name="tanggal" value="<?= $tanggal;?>">
            <button type="submit" class="btn btn-primary">Hapus</button>
            <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Batal</button>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php endforeach;?>
<script>
  window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
      $(this).remove(); 
    });
  }, 2000);
</script>