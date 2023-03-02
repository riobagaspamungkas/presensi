<link rel="stylesheet" href="<?= base_url() ?>assets/vendors/css/vendor.bundle.addons.css">
    <!-- partial -->
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="row">
          <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <?php echo $this->session->flashdata('msg');?>
                <h4 class="card-title">Import Data Pegawai</h4>
                <div class="col-18">
                  <div class="card">
                    <div class="form-group row">
                      <label for="bukti" class="col-sm-2 col-form-label">Format File</label>
                      <div class="col-sm-9">
                        <a href="<?= base_url().'assets/images/format_import.xlsx'?>">File</a>
                      </div>
                    </div>
                    <form class="forms-sample" id="import_excel" method="post" enctype="multipart/form-data" action="<?= base_url()?>admin/import_pegawai">
                      <div class="form-group row">
                        <label for="bukti" class="col-sm-2 col-form-label">File excel</label>
                        <div class="col-sm-9">
                          <input type="file" name="file_excel" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" class="form-control" required="">
                        </div>
                      </div>
                      <button type="submit" name="import" class="btn btn-dark" id="btn_submit">Import Excel</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Data Pegawai</h4>
                <div class="col-xs-12 col-md-12 col-lg-12">
                  <a href="<?= base_url() ?>admin/tambah_pegawai" style="float: right;" class="btn btn-secondary"><em class="mdi mdi-plus"></em> Tambah Pegawai</a><br>
                </div>
                <br>
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-list" bgcolor="#000000">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Keterangan</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no = 1;
                      foreach ($getdatapegawai as $row){
                        echo "<tr>";
                        echo "<td>$no</td>";
                        echo "<td>$row->nip</td>";
                        echo "<td>$row->nama</td>";
                        ?>
                        <td align="center">
                          <a href="<?= base_url().'admin/edit_pegawai/'.$row->nip?>" class="btn btn-primary"><em class="mdi mdi-table-edit"></em></a>
                          <a href="#" data-toggle='modal' data-target='#konfirmasi_hapus<?php echo $row->nip;?>' class="btn btn-danger"><em class="mdi mdi-delete-variant"></em></a>
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
  foreach($getdatapegawai as $i){
    $nip=$i->nip;
    $nama=$i->nama;
  ?>
  <div class="modal fade" id="konfirmasi_hapus<?php echo $nip;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form class="form-horizontal" method="post" action="<?= base_url().'admin/hapus_pegawai'?>">
          <div class="modal-body">
            Anda yakin mau menghapus <b><?php echo $nama;?></b><br><br>
            <input type="hidden" name="nip" value="<?= $nip;?>">
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
<script type="text/javascript">
  $(document).ready(function(){
    $('#import_excel').submit(function(evt){
      evt.preventDefault();
      var formData = new FormData(this);
      $('#btn_submit').text('Importing...').addClass('disabled');
      $.ajax({
        type : 'POST',
        url : $(this).attr('action'),
        data : formData,
        cache : false,
        contentType : false,
        processData : false,
        success:function(response) {
          if(response.st==1) {
            //sukses
            alert(response.pesan);
            window.location.reload();
          }
          if(response.st==0) {
            //gagal
            alert(response.pesan);
            $('#btn_submit').text('Import Excel').removeClass('disabled');
          }
        },dataType:'json'
      });
    });
  });
</script>