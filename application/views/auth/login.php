<!DOCTYPE html>
<html lang="en">
<head>
  <title>PRESENSI - Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="icon" href="<?= base_url().'assets/images/'.$data_setting->logo?>" type="image/png">
  <link rel="stylesheet" href="<?= base_url()?>assets/assets-login/css/main.css"/>
  <link rel="stylesheet" href="<?= base_url()?>assets/assets-login/css/font.css"/>
  <link rel="stylesheet" href="<?= base_url()?>assets/assets-login/css/font-awesome.min.css"/>
  <link rel="stylesheet" href="<?= base_url()?>assets/css/style.css">
</head>
<body>
  <div class="background"></div>
  <div class="backdrop"></div>
  <div class="login-form-container" id="login-form">
    <div class="login-form-content">
      <div class="login-form-header">
        <div class="logo">
          <img src="<?= base_url().'assets/images/'.$data_setting->logo?>" width="90px">
        </div>
        <h3>Sistem Presensi</h3>
      </div>
      <form method="post" action="<?= base_url().'auth/login'?>" class="login-form">
        <?php echo $this->session->flashdata('msg');?>
        <div class="form-group">
          <div class="input-container">
            <input type="text" class="input" name="nip" placeholder="NIP" required="">
          </div>
        </div>
        <div class="form-group">
          <div class="input-container">
            <input type="password" id="login-password" class="input" name="pass" placeholder="Password" required="">
            <i id="show-password" class="fa fa-eye"></i>
          </div>
        </div>
        <div class="form-group">
          <input type="submit" name="tombollogin" value="Login" class="button"/>
        </div>
      </form>
    </div>
  </div>
  <script type="text/javascript" src="<?= base_url()?>assets/assets-login/js/jquery-1.12.4.min.js"></script>
  <script type="text/javascript" src="<?= base_url()?>assets/assets-login/js/main.js"></script>
  <script>
    window.setTimeout(function() {
      $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
      });
    }, 2000);
  </script>
</body>
</html>