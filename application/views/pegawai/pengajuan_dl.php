<link rel="stylesheet" href="<?= base_url() ?>assets/vendors/css/vendor.bundle.addons.css">
    <!-- partial -->
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="row">
          <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Permohohan Dinas Luar</h4>
                <div class="col-xs-12 col-md-12 col-lg-12">
                  <a href="<?= base_url() ?>pegawai/form_pengajuan_dl" style="float: right;" class="btn btn-secondary"><em class="mdi mdi-plus"></em> Tambah Permohonan</a><br>
                </div>
                <br>
                <?php echo $this->session->flashdata('msg');?>
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-list">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>No SPT</th>
                        <th>Pegawai</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no = 1;
                      foreach ($getdatapengajuan as $row){
                        $time=strtotime($row->time);
                        echo "<tr>";
                        echo "<td>$no</td>";
                        echo "<td>$row->no_spt</td>";
                        echo "<td>$row->pegawai</td>";
                        ?>
                        <td align="center">
                          <a href="<?= base_url().'pegawai/update_pengajuan_dl/'.$time?>" class="btn btn-primary"><em class="mdi mdi-table-edit"></em></a>
                          <a href="#" data-toggle='modal' data-target='#konfirmasi_hapus<?php echo $time;?>' class="btn btn-danger"><em class="mdi mdi-delete-variant"></em></a>
                        </td>
                        </tr>
                        <?php $no++;
                      }?>
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
  foreach($getdatapengajuan as $i){
    $time=strtotime($i->time);
  ?>
  <div class="modal fade" id="konfirmasi_hapus<?php echo $time;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form class="form-horizontal" method="post" action="<?= base_url().'pegawai/hapus_pengajuan_dl'?>">
          <div class="modal-body">
            Anda yakin mau menghapus<br><br>
            <input type="hidden" name="id" value="<?= $time;?>">
            <button type="submit" class="btn btn-primary">Hapus</button>
            <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Batal</button>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php } ?>
<script>
  window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
      $(this).remove(); 
    });
  }, 2000);
</script>