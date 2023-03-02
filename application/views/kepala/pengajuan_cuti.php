<link rel="stylesheet" href="<?= base_url() ?>assets/vendors/css/vendor.bundle.addons.css">
    <!-- partial -->
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="row">
          <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Permohohan Izin / Cuti</h4>
                <div class="col-xs-12 col-md-12 col-lg-12">
                  <a href="#" data-toggle='modal' data-target='#list_cuti' style="float: right;" class="btn btn-secondary"><em class="mdi mdi-plus"></em>Tambah Permohonan</a>
                </div>
                <br>
                <?php echo $this->session->flashdata('msg');?>
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-list">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Jenis Cuti</th>
                        <th>Alasan</th>
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
                        echo "<td>$row->tgl_dari s/d $row->tgl_sampai</td>";
                        echo "<td>$row->jenis_cuti</td>";
                        echo "<td>$row->alasan</td>";
                        ?>
                        <td align="center">
                          <a href="<?= base_url().'kepala/update_pengajuan_cuti/'.$time?>" class="btn btn-primary"><em class="mdi mdi-table-edit"></em></a>
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
<div class="modal fade" id="list_cuti" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Pilih permohonan cuti </h4>
      </div>
      <div class="modal-body">
        <?php 
        foreach($listcuti->result() as $j){ ?>
          <a href="<?= base_url() ?>kepala/form_pengajuan_cuti/<?= $j->id_jenis_cuti ?>" class="col-sm-10 btn btn-primary"><?= ucwords($j->jenis_cuti) ?></a><br><br>
        <?php } ?>
      </div>
      <div class="modal-footer">
        <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Batal</button>
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
        <form class="form-horizontal" method="post" action="<?= base_url().'kepala/hapus_pengajuan_cuti'?>">
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