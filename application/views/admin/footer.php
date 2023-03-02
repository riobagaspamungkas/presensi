  <script src="<?= base_url()?>assets/vendors/js/vendor.bundle.base.js"></script>
  <script src="<?= base_url()?>assets/js/off-canvas.js"></script>
  <script src="<?= base_url()?>assets/js/misc.js"></script>
  <script src="<?= base_url()?>assets/js/dashboard.js"></script>
  <script src="<?= base_url()?>assets/tables/jquery.dataTables.js"></script>
  <script src="<?= base_url()?>assets/tables/dataTables.bootstrap.js"></script>
  <script src="<?= base_url()?>assets/tables/dataTables.bootstrap.css"></script>
  <script src="<?= base_url()?>assets/vendors/js/vendor.bundle.addons.js"></script>
  <script src="<?= base_url()?>assets/datepicker/js/bootstrap-datepicker.js"></script>

  <script src="<?= base_url() ?>assets/js/jquery.multiselect.js"></script>
  <script type="text/javascript">
    $('.form_date').datetimepicker({
          language:  'en',
          weekStart: 1,
          todayBtn:  1,
      autoclose: 1,
      todayHighlight: 1,
      startView: 2,
      minView: 2,
      forceParse: 0
      });
  </script>
  <script>
    $('#pegawai').multiselect({
      columns: 1,
      placeholder: 'Pilih pegawai',
      search: true,
      selectAll: true
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
  <script>
    $(".standardSelect").select2({});
  </script>
</body>
</html>