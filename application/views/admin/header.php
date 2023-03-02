<!DOCTYPE html>
<html>

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" type="image/png" href="<?= base_url().'assets/images/'.$data_setting->logo?>">
  <title>Presensi</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="<?= base_url()?>assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="<?= base_url()?>assets/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="<?= base_url()?>assets/datepicker/css/bootstrap-datepicker.css">
  <!-- endinject -->
  <!-- inject:css -->
  <link href="<?= base_url()?>assets/css/jquery.multiselect.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="<?= base_url()?>assets/css/style.css">
  <!-- endinject -->
  <link href="<?= base_url(); ?>assets/leaflet/leaflet.css" rel="stylesheet" />
  <script src="<?= base_url(); ?>assets/leaflet/leaflet.js"></script>
</head>
<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="navbar-menu-wrapper d-flex align-items-center">
        <a class="navbar-brand">PRESENSI PEGAWAI</a>
      </div>
      <div>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item nav-profile">
            <div class="nav-link">
              <div class="user-wrapper">
                <div class="profile-image">
                  <img src="<?= base_url().'assets/images/'.$data_setting->logo?>" class="img-thumbnail">
                </div>
                <div class="text-wrapper">
                  <p class="profile-name"><?= $data_user_login->nama ?></p>
                  <div>
                    <small class="designation text-muted"><?= $data_jabatan_login->nama_jbtn ?></small>
                    <span class="status-indicator online"></span>
                  </div>
                </div>
              </div>
            </div>
          </li>
          <li class="nav-item <?php if($active == 'dashboard') echo 'active' ?>">
            <a class="nav-link" href="<?= base_url().'admin/dashboard'?>">
              <i class="menu-icon mdi mdi-television"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <!-- <li class="nav-item <?php if($active == 'kehadiran') echo 'active' ?>">
            <a class="nav-link" href="<?= base_url().'admin/kehadiran'?>">
              <i class="menu-icon mdi mdi-format-list-bulleted"></i>
              <span class="menu-title">Data Kehadiran</span>
            </a>
          </li> -->
          <li class="nav-item <?php if($active == 'fingerprint' || $active == 'presensi_online' || $active == 'rekam_online' || $active == 'kehadiran') echo 'active' ?>">
            <a class="nav-link" data-toggle="collapse" href="#presensi" aria-expanded="<?php if($active == 'fingerprint' || $active == 'presensi_online' || $active == 'rekam_online' || $active == 'kehadiran') echo 'true' ?>" aria-controls="ui-basic">
              <i class="menu-icon mdi mdi-account-card-details"></i>
              <span class="menu-title">Presensi</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse <?php if($active == 'fingerprint' || $active == 'presensi_online' || $active == 'rekam_online' || $active == 'kehadiran') echo 'show' ?>" id="presensi">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link <?php if($active == 'presensi_online') echo 'active' ?>" href="<?= base_url().'admin/presensi_online'?>">Online</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link <?php if($active == 'kehadiran') echo 'active' ?>" href="<?= base_url().'admin/kehadiran'?>">Data Kehadiran</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item <?php if($active == 'data_pegawai') echo 'active' ?>">
            <a class="nav-link" href="<?= base_url().'admin/data_pegawai'?>">
              <i class="menu-icon mdi mdi-account-multiple"></i>
              <span class="menu-title">Pegawai</span>
            </a>
          </li>
          <li class="nav-item <?php if($active == 'persetujuan' || $active == 'histori') echo 'active' ?>">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="<?php if($active == 'persetujuan' || $active == 'histori') echo 'true' ?>" aria-controls="ui-basic">
              <i class="menu-icon mdi mdi-clipboard-text"></i>
              <span class="menu-title">Izin / Cuti</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse <?php if($active == 'persetujuan' || $active == 'histori') echo 'show' ?>" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link <?php if($active == 'persetujuan') echo 'active' ?>" href="<?= base_url().'admin/persetujuan'?>">Persetujuan</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link <?php if($active == 'histori') echo 'active' ?>" href="<?= base_url().'admin/histori'?>">History</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item <?php if($active == 'monitoring') echo 'active' ?>">
            <a class="nav-link" href="<?= base_url().'admin/monitoring'?>">
              <i class="menu-icon mdi mdi-lead-pencil"></i>
              <span class="menu-title">Monitoring Kegiatan</span>
            </a>
          </li>
          <li class="nav-item <?php if($active == 'ph') echo 'active' ?>">
            <a class="nav-link" href="<?= base_url().'admin/ph'?>">
              <i class="menu-icon mdi mdi-calendar"></i>
              <span class="menu-title">Libur Nasional</span>
            </a>
          </li>
          <li class="nav-item <?php if($active == 'laporan') echo 'active' ?>">
            <a class="nav-link" href="<?= base_url().'admin/laporan'?>">
              <i class="menu-icon mdi mdi-download"></i>
              <span class="menu-title">Laporan</span>
            </a>
          </li>
          <li class="nav-item <?php if($active == 'pengaturan') echo 'active' ?>">
            <a class="nav-link" href="<?= base_url().'admin/pengaturan'?>">
              <i class="menu-icon mdi mdi-account-settings-variant"></i>
              <span class="menu-title">Pengaturan</span>
            </a>
          </li>
          <li class="nav-item <?php if($active == 'setting_aplikasi') echo 'active' ?>">
            <a class="nav-link" href="<?= base_url().'admin/setting_aplikasi'?>">
              <i class="menu-icon mdi mdi-settings"></i>
              <span class="menu-title">Pengaturan Aplikasi</span>
            </a>
          </li>
          <li class="nav-item <?php if($active == 'about') echo 'active' ?>">
            <a class="nav-link" href="<?= base_url().'admin/about'?>">
              <i class="menu-icon mdi mdi-information-outline"></i>
              <span class="menu-title">About</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url().'auth/logout'?>">
              <i class="menu-icon mdi mdi-logout"></i>
              <span class="menu-title">Logoout</span>
            </a>
          </li>
        </ul>
      </nav>