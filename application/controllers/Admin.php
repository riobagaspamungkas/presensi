<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        //validasi jika user belum login
        if($this->session->userdata('h_presensi') != 'admin'){
            $url=base_url();
            redirect($url);
        }
        date_default_timezone_set('Asia/Jakarta');
        $this->today = date('Y-m-d');
        $this->load->model("M_Referensi");
        $this->load->model("M_Presensi");
        $this->load->model("M_Izin");
        $this->load->model("M_Kegiatan");
    }

    public function index(){
        redirect(base_url('admin/dashboard'));
    }

    public function dashboard(){
        $nip = $this->session->userdata('presensi');
        $data = array( 'active' => "dashboard",
            'presensi' => $this->M_Presensi->getpresensionline(),
            'pegawai' => $this->M_Referensi->getAllData('t_user')->result(),
            'data_setting' => $this->M_Referensi->getByField("t_setting","status_setting",1),
            'data_user_login' => $this->M_Referensi->getByField("t_user","nip",$nip),
            'countuser' => $this->M_Referensi->getAllData("t_user")->num_rows(),
            'countabsenonline' => $this->M_Presensi->CountAbsenOnline(),
            'hari_libur' => $this->M_Referensi->getByField("t_ph","tanggal",$this->today));
        $data["data_jabatan_login"] = $this->M_Referensi->getByField("t_jabatan","id_jbtn",$data["data_user_login"]->jbtn);
        $this->load->view('admin/header', $data);
        $this->load->view('admin/dashboard', $data);
        $this->load->view('admin/footer');
    }

    public function data_pegawai(){
        $nip = $this->session->userdata('presensi');
        $data = array( 'active' => "data_pegawai",
            'temp_data' => '',
            'getdatapegawai' => $this->M_Referensi->getDataPegawai($nip),
            'data_setting' => $this->M_Referensi->getByField("t_setting","status_setting",1),
            'data_user_login' => $this->M_Referensi->getByField("t_user","nip",$nip));
        $data["data_jabatan_login"] = $this->M_Referensi->getByField("t_jabatan","id_jbtn",$data["data_user_login"]->jbtn);
        $this->load->view('admin/header', $data);
        $this->load->view('admin/data_pegawai', $data);
        $this->load->view('admin/footer');
    }

    public function import_pegawai(){
        require_once './assets/classes/PHPExcel.php';
        require_once './assets/classes/PHPExcel/IOFactory.php';
        $random = rand(11111,99999);
        $target_file = $random.basename($_FILES["file_excel"]["name"]);
        if (move_uploaded_file($_FILES["file_excel"]["tmp_name"], $target_file)) {
            ini_set('memory_limit', '-1');
            $objReader = PHPExcel_IOFactory::createReader('Excel2007');
            $inputFileType = 'Excel2007';
            $sheetIndex = 0;
            $inputFileName = $target_file;
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $sheetnames = $objReader->listWorksheetNames($inputFileName);
            $objReader->setLoadSheetsOnly($sheetnames[$sheetIndex]);
            try {
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e){
                die('Error loading file :' . $e->getMessage());
            }
            $worksheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
            $numRows = count($worksheet);
            //baca untuk setiap baris excel
            $imagePath = "assets/images/avatar.png";
            for ($i=11; $i <= $numRows ; $i++) {
                $nip = $worksheet[$i]['B'];
                $nama = $worksheet[$i]['C'];
                $password = md5($worksheet[$i]['D']);
                $hak_akses = $worksheet[$i]['E'];
                $golongan = $worksheet[$i]['F'];
                $jenis_kelamin = $worksheet[$i]['G'];
                $jabatan = $worksheet[$i]['H'];
                if (!empty($nip)) {
                    $fileExt   = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));
                    $userFile  = time().'_'.rand(1000,9999).'.'.$fileExt;
                    $newPath = "assets/images/foto/".$userFile;
                    if (!empty($this->M_Referensi->getByField('t_user','nip',$nip))) {
                        $this->M_Referensi->import_update($nip,$password,$nama,$hak_akses,$golongan,$jenis_kelamin,$jabatan);
                    }else{
                        copy($imagePath, $newPath);
                        $this->M_Referensi->import($nip,$password,$nama,$hak_akses,$golongan,$jenis_kelamin,$jabatan,$userFile);
                    }
                }
                if ($i == $numRows) {
                    unlink($target_file);
                }
            }
            echo $this->session->set_flashdata('msg','<div class="alert alert-success" role="alert">
              <strong>Import Excel Success!</strong>
            </div>');
            redirect(base_url('admin/data_pegawai'));
        } else {
            echo $this->session->set_flashdata('msg','<div class="alert alert-success" role="alert">
              <strong>File tidak ada</strong>
            </div>');
            redirect(base_url('admin/data_pegawai'));
        }
    }

    public function kehadiran(){
        $nip = $this->session->userdata('presensi');
        $date = $this->today;
        $data = array( 'active' => "kehadiran",
            'nip' => $nip,
            'modal' => $this->M_Kegiatan->modal('t_desk_kegiatan'),
            'datakehadiran' => $this->M_Presensi->kehadiran($nip,$date),
            'data_setting' => $this->M_Referensi->getByField("t_setting","status_setting",1),
            'data_user_login' => $this->M_Referensi->getByField("t_user","nip",$nip));
        $data["data_jabatan_login"] = $this->M_Referensi->getByField("t_jabatan","id_jbtn",$data["data_user_login"]->jbtn);
        $this->load->view('admin/header', $data);
        $this->load->view('admin/kehadiran', $data);
    }

    public function data_kehadiran(){
        $nip = $this->session->userdata('presensi');
        $date=$this->input->post('date');
        $data = array( 'active' => "data_kehadiran",
            'nip' => $nip,
            'date' => $date,
            'datakehadiran' => $this->M_Presensi->kehadiran($nip,$date),
            'data_setting' => $this->M_Referensi->getByField("t_setting","status_setting",1),
            'data_user_login' => $this->M_Referensi->getByField("t_user","nip",$nip));
        $data["data_jabatan_login"] = $this->M_Referensi->getByField("t_jabatan","id_jbtn",$data["data_user_login"]->jbtn);
        $this->load->view('admin/data_kehadiran', $data);
    }

    public function detail_kehadiran($id){
        $nip = $this->session->userdata('presensi');
        $data = array( 'active' => "detail_kehadiran",
            'data_kehadiran' => $this->M_Presensi->detail_kehadiran($id),
            'data_setting' => $this->M_Referensi->getByField("t_setting","status_setting",1),
            'data_user_login' => $this->M_Referensi->getByField("t_user","nip",$nip));
        $data["data_jabatan_login"] = $this->M_Referensi->getByField("t_jabatan","id_jbtn",$data["data_user_login"]->jbtn);
        $this->load->view('admin/header', $data);
        $this->load->view('admin/detail_kehadiran', $data);
        $this->load->view('admin/footer');
    }

    public function laporan(){
        $bulan = '';
        $tahun = '';
        $jumlahtanggal = 0;
        $nip = $this->session->userdata('presensi');
        if (isset($_POST['cetak'])) {
            $bulan = $this->input->post('bulan');
            $tahun = $this->input->post('tahun');
            $filter = '01-'.$bulan.'-'.$tahun;
            $jumlahtanggal = date('t', strtotime($filter));
        }
        $data = array( 'active' => "laporan",
            'bulan' => $bulan,
            'tahun' => $tahun,
            'jumlahtanggal' => $jumlahtanggal,
            'data_setting' => $this->M_Referensi->getByField("t_setting","status_setting",1),
            'data_kepala' => $this->M_Referensi->getByField("t_user","akses","kepala"),
            'data_user_login' => $this->M_Referensi->getByField("t_user","nip",$nip));
        $data['rowlaporan'] = $this->M_Presensi->cetak($bulan,$tahun);
        $data["data_jabatan_login"] = $this->M_Referensi->getByField("t_jabatan","id_jbtn",$data["data_user_login"]->jbtn);
        if (isset($_POST['cetak'])) {
            $this->load->view('admin/cetak_laporan', $data);
        }else{
            $this->load->view('admin/header', $data);
            $this->load->view('admin/laporan', $data);
            $this->load->view('admin/footer');
        }
    }

    public function monitoring(){
        $nip = $this->session->userdata('presensi');
        $data = array( 'active' => "monitoring",
            'nip' => $this->M_Kegiatan->cekuser(),
            'rowkegiatan' => $this->M_Kegiatan->data_carousel(),
            'data_setting' => $this->M_Referensi->getByField("t_setting","status_setting",1),
            'data_user_login' => $this->M_Referensi->getByField("t_user","nip",$nip));
        $data["data_jabatan_login"] = $this->M_Referensi->getByField("t_jabatan","id_jbtn",$data["data_user_login"]->jbtn);
        $this->load->view('admin/header', $data);
        $this->load->view('admin/monitoring', $data);
    }

    public function detail_kegiatan($id){
        $nip = $this->session->userdata('presensi');
        $data = array( 'active' => "detail_kegiatan",
            'desk_kegiatan' => $this->M_Referensi->getByField("t_desk_kegiatan","id_deskripsi",$id),
            'data_setting' => $this->M_Referensi->getByField("t_setting","status_setting",1),
            'data_user_login' => $this->M_Referensi->getByField("t_user","nip",$nip));
        $data["getdatakegiatan"] = $this->M_Referensi->getByField("t_kegiatan","id_kegiatan",$data["desk_kegiatan"]->id_kegiatan);
        $data["data_jabatan_login"] = $this->M_Referensi->getByField("t_jabatan","id_jbtn",$data["data_user_login"]->jbtn);
        $data["datapegawaikegiatan"] = $this->M_Referensi->getByField("t_user","nip",$data["getdatakegiatan"]->nip);
        $this->load->view('admin/header', $data);
        $this->load->view('admin/detail_kegiatan', $data);
        $this->load->view('admin/footer');
    }

    public function tampil_kegiatan($file){
        $nip = $this->session->userdata('presensi');
        $data = array( 'active' => "tampil",
            'jenis' => "kegiatan",
            'file' => $file);
        $this->load->view('admin/tampil', $data);
    }

    public function pengaturan(){
        $nip = $this->session->userdata('presensi');
        $data = array( 'active' => "pengaturan",
            'data_setting' => $this->M_Referensi->getByField("t_setting","status_setting",1),
            'data_user_login' => $this->M_Referensi->getByField("t_user","nip",$nip));
        $data["data_jabatan_login"] = $this->M_Referensi->getByField("t_jabatan","id_jbtn",$data["data_user_login"]->jbtn);
        $data["data_jabatan"] = $this->M_Referensi->getAllData("t_jabatan")->result();
        $this->load->view('admin/header', $data);
        $this->load->view('admin/pengaturan', $data);
        $this->load->view('admin/footer');
    }

    public function about() {
        $nip = $this->session->userdata('presensi');
        $data = array( 'active' => "about",
            'data_setting' => $this->M_Referensi->getByField("t_setting","status_setting",1),
            'data_user_login' => $this->M_Referensi->getByField("t_user","nip",$nip));
        $data["data_jabatan_login"] = $this->M_Referensi->getByField("t_jabatan","id_jbtn",$data["data_user_login"]->jbtn);
        $this->load->view('admin/header', $data);
        $this->load->view('admin/about', $data);
        $this->load->view('admin/footer');
    }

    public function setting_aplikasi(){
        $nip = $this->session->userdata('presensi');
        $data = array( 'active' => "setting_aplikasi",
            'data_setting' => $this->M_Referensi->getByField("t_setting","status_setting",1),
            'data_user_login' => $this->M_Referensi->getByField("t_user","nip",$nip));
        $data["data_jabatan_login"] = $this->M_Referensi->getByField("t_jabatan","id_jbtn",$data["data_user_login"]->jbtn);
        $data["data_jabatan"] = $this->M_Referensi->getAllData("t_jabatan")->result();
        $this->load->view('admin/header', $data);
        $this->load->view('admin/setting_aplikasi', $data);
    }

    public function e_pengaturan(){
        $fileName  = $_FILES['logo']['name'];
        $cek_logo = $this->M_Referensi->getByField('t_setting','status_setting',1);
        $getuserFile = $cek_logo->logo;
        $logo = ", logo='".$cek_logo->logo."'";
        if($fileName){
            $fileExt   = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $userFile  = time().'_'.rand(1000,9999).'.'.$fileExt;
            $logo = ", logo='".$userFile."'";
            $config['file_name']        = $userFile;
            $config['upload_path']      = './assets/images/';
            $config['allowed_types']    = 'gif|jpg|png';
            $config['max_size']         = 2560;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('logo')){
                unlink('./assets/images/'.$getuserFile);
                if ($this->M_Referensi->updatepengaturan($logo)) {
                    echo $this->session->set_flashdata('msg','<div class="alert alert-success" role="alert">
                      <strong>Data berhasil diubah</strong>
                    </div>');
                    redirect(base_url('admin/setting_aplikasi'));
                }else{
                    echo $this->session->set_flashdata('msg','<div class="alert alert-warning" role="alert">
                      <strong>Data error</strong>
                    </div>');
                    redirect(base_url('admin/setting_aplikasi'));
                }
            }else{
                echo $this->session->set_flashdata('msg','<div class="alert alert-warning" role="alert">
                  <strong>'.$this->upload->display_errors().'</strong>
                </div>');
                redirect(base_url('admin/setting_aplikasi'));
            }
        }else{
            if ($this->M_Referensi->updatepengaturan($logo)) {
                echo $this->session->set_flashdata('msg','<div class="alert alert-success" role="alert">
                  <strong>Data berhasil diubah</strong>
                </div>');
                redirect(base_url('admin/setting_aplikasi'));
            }else{
                echo $this->session->set_flashdata('msg','<div class="alert alert-warning" role="alert">
                  <strong>Data error</strong>
                </div>');
                redirect(base_url('admin/setting_aplikasi'));
            }
        }
    }

    public function resetaplikasi(){
        $logo=$this->input->post('logo');
        $imagePath = "assets/images/reset.png";
        $newPath = "assets/images/logo.png";
        if( $this->M_Referensi->resetapp() > 0 ) {
            unlink('./assets/images/'.$logo);
            copy($imagePath, $newPath);
            echo $this->session->set_flashdata('msg','<div class="alert alert-success" role="alert">
              <strong>Settingan Telah Direset</strong>
            </div>');
            redirect(base_url('admin/setting_aplikasi'));
        } else {
            echo $this->session->set_flashdata('msg','<div class="alert alert-warning" role="alert">
              <strong>Error</strong>
            </div>');
            redirect(base_url('admin/setting_aplikasi'));
        }
    }

    public function histori(){
        $nip = $this->session->userdata('presensi');
        $data = array( 'active' => "histori",
            'data_setting' => $this->M_Referensi->getByField("t_setting","status_setting",1),
            'data_user_login' => $this->M_Referensi->getByField("t_user","nip",$nip));
        $data["histori"] = $this->M_Izin->histori($data["data_user_login"]->akses,'cuti dl',$nip);
        $data["data_jabatan_login"] = $this->M_Referensi->getByField("t_jabatan","id_jbtn",$data["data_user_login"]->jbtn);
        $this->load->view('admin/header', $data);
        $this->load->view('admin/histori', $data);
    }

    public function data_histori(){
        $nip = $this->session->userdata('presensi');
        $cuti_dl=$this->input->post('cuti_dl');
        $data = array( 'active' => "data_histori",
            'nip' => $nip,
            'data_setting' => $this->M_Referensi->getByField("t_setting","status_setting",1),
            'data_user_login' => $this->M_Referensi->getByField("t_user","nip",$nip));
        $data["histori"] = $this->M_Izin->histori($data["data_user_login"]->akses,$cuti_dl,$nip);
        $data["data_jabatan_login"] = $this->M_Referensi->getByField("t_jabatan","id_jbtn",$data["data_user_login"]->jbtn);
        $this->load->view('admin/data_histori', $data);
    }

    public function detail_permohonan($time,$tabel){
        $nip = $this->session->userdata('presensi');
        $id = date('Y-m-d H:i:s',$time);
        $data = array( 'active' => "detail_permohonan",
            'getdatapengajuan' => $this->M_Izin->datapersetujuan($tabel,$id),
            'data_setting' => $this->M_Referensi->getByField("t_setting","status_setting",1),
            'data_user_login' => $this->M_Referensi->getByField("t_user","nip",$nip));
        $data["data_jabatan_login"] = $this->M_Referensi->getByField("t_jabatan","id_jbtn",$data["data_user_login"]->jbtn);
        $this->load->view('admin/header', $data);
        $this->load->view('admin/detail_permohonan_'.$tabel, $data);
        $this->load->view('admin/footer');
    }

    public function persetujuan(){
        $nip = $this->session->userdata('presensi');
        $data = array( 'active' => "persetujuan",
            'data_setting' => $this->M_Referensi->getByField("t_setting","status_setting",1),
            'data_user_login' => $this->M_Referensi->getByField("t_user","nip",$nip));
        $data["persetujuan"] = $this->M_Izin->persetujuan($data["data_user_login"]->akses,'cuti dl');
        $data["data_jabatan_login"] = $this->M_Referensi->getByField("t_jabatan","id_jbtn",$data["data_user_login"]->jbtn);
        $this->load->view('admin/header', $data);
        $this->load->view('admin/persetujuan', $data);
    }

    public function data_persetujuan(){
        $nip = $this->session->userdata('presensi');
        $cuti_dl=$this->input->post('cuti_dl');
        $data = array( 'active' => "data_persetujuan",
            'nip' => $nip,
            'data_setting' => $this->M_Referensi->getByField("t_setting","status_setting",1),
            'data_user_login' => $this->M_Referensi->getByField("t_user","nip",$nip));
        $data["persetujuan"] = $this->M_Izin->persetujuan($data["data_user_login"]->akses,$cuti_dl);
        $data["data_jabatan_login"] = $this->M_Referensi->getByField("t_jabatan","id_jbtn",$data["data_user_login"]->jbtn);
        $this->load->view('admin/data_persetujuan', $data);
    }

    public function s_persetujuan($time,$tabel){
        $nip = $this->session->userdata('presensi');
        $id = date('Y-m-d H:i:s',$time);
        $data = array( 'active' => "s_persetujuan",
            'getdatapengajuan' => $this->M_Izin->datapersetujuan($tabel,$id),
            'data_setting' => $this->M_Referensi->getByField("t_setting","status_setting",1),
            'data_user_login' => $this->M_Referensi->getByField("t_user","nip",$nip));
        $data["data_jabatan_login"] = $this->M_Referensi->getByField("t_jabatan","id_jbtn",$data["data_user_login"]->jbtn);
        $this->load->view('admin/header', $data);
        $this->load->view('admin/s_persetujuan_'.$tabel, $data);
        $this->load->view('admin/footer');
    }

    public function t_persetujuan_cuti(){
        $status = $this->input->post('status');
        if ($status == 2) {
            $ket = 'disetujui';
        }elseif ($status == 3) {
            $ket = 'ditolak';
        }
        if( $this->M_Izin->t_persetujuan('cuti') > 0 ) {
            echo $this->session->set_flashdata('msg','<div class="alert alert-success" role="alert">
              <strong>Permohonan '.$ket.'</strong>
            </div>');
            redirect(base_url('admin/persetujuan'));
        } else {
            echo $this->session->set_flashdata('msg','<div class="alert alert-warning" role="alert">
              <strong>Error, proses permohonan gagal</strong>
            </div>');
            redirect(base_url('admin/persetujuan'));
        }
    }

    public function t_persetujuan_dl(){
        $status = $this->input->post('status');
        if ($status == 2) {
            $ket = 'disetujui';
        }elseif ($status == 3) {
            $ket = 'ditolak';
        }
        if( $this->M_Izin->t_persetujuan('dl') > 0 ) {
            echo $this->session->set_flashdata('msg','<div class="alert alert-success" role="alert">
              <strong>Permohonan '.$ket.'</strong>
            </div>');
            redirect(base_url('admin/persetujuan'));
        } else {
            echo $this->session->set_flashdata('msg','<div class="alert alert-warning" role="alert">
              <strong>Error, proses permohonan gagal</strong>
            </div>');
            redirect(base_url('admin/persetujuan'));
        }
    }

    public function ph(){
        $nip = $this->session->userdata('presensi');
        $data = array( 'active' => "ph",
            'data_setting' => $this->M_Referensi->getByField("t_setting","status_setting",1),
            'data_user_login' => $this->M_Referensi->getByField("t_user","nip",$nip),
            'getData' => $this->M_Referensi->getAllData("t_ph"));
        $data["data_jabatan_login"] = $this->M_Referensi->getByField("t_jabatan","id_jbtn",$data["data_user_login"]->jbtn);
        $this->load->view('admin/header', $data);
        $this->load->view('admin/ph', $data);
        $this->load->view('admin/footer');
    }

    public function presensi_online(){
        $nip = $this->session->userdata('presensi');
        $centang = 8;
        $where = '';
        $tgl_dari = '';
        $tgl_sampai = '';
        $a = $this->M_Referensi->getPegawaiTanpaAdmin();
        foreach ($a as $b) {
            $c = $b->nip;
            $where .= $c ."', '";
        }
        $where = substr($where,0,-4);
        $where = "'".$where."'";
        if (isset($_POST['tombolfilter']) OR isset($_POST['export'])) {
            if ($this->input->post('filtgl') == 0) {
                $centang = 0;
            }else {
                $centang = 8;
            }
            $where = '';
            if (isset($_POST['pegawai'])) {
                $pegawai = $this->input->post('pegawai');
                $where = '';
                foreach ($pegawai as $row) {
                  if ($row) {
                    $where .= $row ."', '";
                  }
                }
                $where = substr($where,0,-4);
                $where = "'".$where."'";
            }else{
                $a = $this->M_Referensi->getPegawaiTanpaAdmin();
                foreach ($a as $b) {
                  $c = $b->nip;
                  $where .= $c ."', '";
                }
                $where = substr($where,0,-4);
                $where = "'".$where."'";
            }
            $tgl_dari = $this->input->post('tgl_dari');
            $tgl_sampai = $this->input->post('tgl_sampai');
            if ($tgl_sampai >= $this->today) {
                $tgl_sampai = $this->today;
            }
            if ($tgl_dari >= $tgl_sampai) {
                $tgl_dari = $tgl_sampai;
            }
        }
        $data = array( 'active' => "presensi_online",
            'tgl_dari' => $tgl_dari,
            'tgl_sampai' => $tgl_sampai,
            'centang' => $centang,
            'where' => $where,
            'pegawai' => $this->input->post('pegawai'),
            'rowpresensi' => $this->M_Presensi->presensiadmin($tgl_dari,$tgl_sampai,$centang,$where),
            'row_pegawai' => $this->M_Referensi->getPegawaiTanpaAdmin(),
            'data_setting' => $this->M_Referensi->getByField("t_setting","status_setting",1),
            'data_user_login' => $this->M_Referensi->getByField("t_user","nip",$nip));
        $data["data_jabatan_login"] = $this->M_Referensi->getByField("t_jabatan","id_jbtn",$data["data_user_login"]->jbtn);
        if (isset($_POST['export'])) {
            $this->load->view('admin/export_excel', $data);
        }else{
            $this->load->view('admin/header', $data);
            $this->load->view('admin/presensi_online', $data);
            $this->load->view('admin/footer');
        }
    }

    public function rekam_online(){
        $nip = $this->session->userdata('presensi');
        $data = array( 'active' => "rekam_online",
            'presensi' => $this->M_Presensi->getpresensionline(),
            'pegawai' => $this->M_Referensi->getAllData('t_user')->result(),
            'data_setting' => $this->M_Referensi->getByField("t_setting","status_setting",1),
            'data_user_login' => $this->M_Referensi->getByField("t_user","nip",$nip));
        $data["data_jabatan_login"] = $this->M_Referensi->getByField("t_jabatan","id_jbtn",$data["data_user_login"]->jbtn);
        $this->load->view('admin/header', $data);
        $this->load->view('admin/rekam_online', $data);
        $this->load->view('admin/footer');
    }

    public function tampil($jenis,$file){
        $nip = $this->session->userdata('presensi');
        $data = array( 'active' => "tampil",
            'jenis' => $jenis,
            'file' => $file);
        $this->load->view('admin/tampil', $data);
    }

    public function tambah_pegawai(){
        $nip = $this->session->userdata('presensi');
        $data = array( 'active' => "tambah_pegawai",
            'data_setting' => $this->M_Referensi->getByField("t_setting","status_setting",1),
            'data_user_login' => $this->M_Referensi->getByField("t_user","nip",$nip));
        $data["data_jabatan_login"] = $this->M_Referensi->getByField("t_jabatan","id_jbtn",$data["data_user_login"]->jbtn);
        $data["data_jabatan"] = $this->M_Referensi->getAllData("t_jabatan")->result();
        $this->load->view('admin/header', $data);
        $this->load->view('admin/tambah_pegawai', $data);
        $this->load->view('admin/footer');
    }

    public function t_pegawai(){
        $ceknip = $this->input->post('nip');
        $cek_user = $this->M_Referensi->getByField("t_user","nip",$ceknip);
        if ($cek_user > 0) {
            echo $this->session->set_flashdata('msg','<div class="alert alert-warning" role="alert">
              <strong>NIP Ganda</strong>
            </div>');
            redirect(base_url('admin/data_pegawai'));
        }else{
            $fileName  = $_FILES['foto']['name'];
            $fileExt   = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $userFile  = time().'_'.rand(1000,9999).'.'.$fileExt;
            $config['file_name']        = $userFile;
            $config['upload_path']      = './assets/images/foto/';
            $config['allowed_types']    = 'gif|jpg|png';
            $config['max_size']         = 2560;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('foto')){
                if ($this->M_Referensi->tambahpegawai($userFile)) {
                    echo $this->session->set_flashdata('msg','<div class="alert alert-success" role="alert">
                      <strong>Data berhasil ditambahkan</strong>
                    </div>');
                    redirect(base_url('admin/data_pegawai'));
                }else{
                    echo $this->session->set_flashdata('msg','<div class="alert alert-warning" role="alert">
                      <strong>Data error</strong>
                    </div>');
                    redirect(base_url('admin/data_pegawai'));
                }
            }else{
                echo $this->session->set_flashdata('msg','<div class="alert alert-warning" role="alert">
                  <strong>'.$this->upload->display_errors().'</strong>
                </div>');
                redirect(base_url('admin/data_pegawai'));
            }
        }
    }

    public function edit_pegawai($getnip){
        $nip = $this->session->userdata('presensi');
        $data = array( 'active' => "edit_pegawai",
            'getdatapegawai' => $this->M_Referensi->getByField("t_user","nip",$getnip),
            'data_setting' => $this->M_Referensi->getByField("t_setting","status_setting",1),
            'data_user_login' => $this->M_Referensi->getByField("t_user","nip",$nip));
        $data["data_jabatan_login"] = $this->M_Referensi->getByField("t_jabatan","id_jbtn",$data["data_user_login"]->jbtn);
        $data["data_jabatan"] = $this->M_Referensi->getAllData("t_jabatan")->result();
        $this->load->view('admin/header', $data);
        $this->load->view('admin/update_pegawai', $data);
        $this->load->view('admin/footer');
    }

    public function e_pegawai(){
        $ceknip = $this->input->post('get_nip');
        $nip = $this->input->post('nip');
        $cek_user = $this->M_Referensi->cekvalidasi('t_user','nip',$nip,$ceknip);
        if ($cek_user > 0) {
            echo $this->session->set_flashdata('msg','<div class="alert alert-warning" role="alert">
              <strong>NIP Ganda</strong>
            </div>');
            redirect(base_url('admin/data_pegawai'));
        }else{
            $fileName  = $_FILES['foto']['name'];
            $cek_gambar = $this->M_Referensi->getByField('t_user','nip',$ceknip);
            $getuserFile = $cek_gambar->gambar;
            $foto = ", gambar='".$cek_gambar->gambar."'";
            if($fileName){
                $fileExt   = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                $userFile  = time().'_'.rand(1000,9999).'.'.$fileExt;
                $foto = ", gambar='".$userFile."'";
                $config['file_name']        = $userFile;
                $config['upload_path']      = './assets/images/foto/';
                $config['allowed_types']    = 'gif|jpg|png';
                $config['max_size']         = 2560;
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('foto')){
                    unlink('./assets/images/foto/'.$getuserFile);
                    if ($this->M_Referensi->updateuser($foto)) {
                        echo $this->session->set_flashdata('msg','<div class="alert alert-success" role="alert">
                          <strong>Data berhasil diubah</strong>
                        </div>');
                        redirect(base_url('admin/data_pegawai'));
                    }else{
                        echo $this->session->set_flashdata('msg','<div class="alert alert-warning" role="alert">
                          <strong>Data error</strong>
                        </div>');
                        redirect(base_url('admin/data_pegawai'));
                    }
                }else{
                    echo $this->session->set_flashdata('msg','<div class="alert alert-warning" role="alert">
                      <strong>'.$this->upload->display_errors().'</strong>
                    </div>');
                    redirect(base_url('admin/data_pegawai'));
                }
            }else{
                if ($this->M_Referensi->updateuser($foto)) {
                    echo $this->session->set_flashdata('msg','<div class="alert alert-success" role="alert">
                      <strong>Data berhasil diubah</strong>
                    </div>');
                    redirect(base_url('admin/data_pegawai'));
                }else{
                    echo $this->session->set_flashdata('msg','<div class="alert alert-warning" role="alert">
                      <strong>Data error</strong>
                    </div>');
                    redirect(base_url('admin/data_pegawai'));
                }
            }
        }
    }

    public function hapus_pegawai(){
        if( $this->M_Referensi->hapus_user() > 0 ) {
            echo $this->session->set_flashdata('msg','<div class="alert alert-success" role="alert">
              <strong>Data berhasil dihapus</strong>
            </div>');
            redirect(base_url('admin/data_pegawai'));
        } else {
            echo $this->session->set_flashdata('msg','<div class="alert alert-warning" role="alert">
              <strong>Error, data gagal dihapus</strong>
            </div>');
            redirect(base_url('admin/data_pegawai'));
        }
    }

    public function ganti_password($page){
        $get_old=$this->input->post('get_password');
        $old=md5($this->input->post('password_lama'));
        $new=md5($this->input->post('password_baru'));
        $pass=$this->input->post('password_baru');
        $confirm_new=md5($this->input->post('konf_password_baru'));
        if($get_old == $old){
            if ($new == $confirm_new) {
                if( $this->M_Referensi->gantipassword() > 0 ) {
                    echo $this->session->set_flashdata('msg','<div class="alert alert-success" role="alert">
                      <strong>Password berhasil diubah, passwordnya adalah '.$pass.'</strong>
                    </div>');
                    redirect(base_url('admin/'.$page));
                } else {
                    echo $this->session->set_flashdata('msg','<div class="alert alert-warning" role="alert">
                      <strong>Data Error</strong>
                    </div>');
                    redirect(base_url('admin/'.$page));
                }
            }else{
                echo "<script>alert('Password baru anda tidak match, silahkan coba lagi!');history.go(-1);</script>";
            }
        }else{
            echo "<script>alert('Password lama anda salah, silahkan coba lagi!');history.go(-1);</script>";
        }
    }

    public function resetpassword($page){
        $newpass = '12345';
        if( $this->M_Referensi->resetpass($newpass) > 0 ) {
            echo $this->session->set_flashdata('msg','<div class="alert alert-success" role="alert">
              <strong>Berhasil reset password, passwordnya adalah '.$newpass.'</strong>
            </div>');
            redirect(base_url('admin/'.$page));
        } else {
            echo $this->session->set_flashdata('msg','<div class="alert alert-warning" role="alert">
              <strong>Data Error</strong>
            </div>');
            redirect(base_url('admin/'.$page));
        }
    }

    public function tambah_ph(){
        $nip = $this->session->userdata('presensi');
        $data = array( 'active' => "tambah_ph",
            'error' => ' ',
            'data_setting' => $this->M_Referensi->getByField("t_setting","status_setting",1),
            'data_user_login' => $this->M_Referensi->getByField("t_user","nip",$nip));
        $data["data_jabatan_login"] = $this->M_Referensi->getByField("t_jabatan","id_jbtn",$data["data_user_login"]->jbtn);
        $data["data_jabatan"] = $this->M_Referensi->getAllData("t_jabatan")->result();
        $this->load->view('admin/header', $data);
        $this->load->view('admin/tambah_ph', $data);
        $this->load->view('admin/footer');
    }

    public function t_ph(){
        $tgl = $this->input->post('tgl');
        $keterangan = $this->input->post('keterangan');
        $data = array(
            'tanggal' => $tgl,
            'keterangan' => $keterangan);
        $cek_ph = $this->M_Referensi->getByField("t_ph","tanggal",$tgl);
        if ($cek_ph > 0) {
            echo $this->session->set_flashdata('msg','<div class="alert alert-warning" role="alert">
              <strong>Data Ganda</strong>
            </div>');
            redirect(base_url('admin/ph'));
        }else{
            if( $this->M_Referensi->input_data($data,'t_ph') > 0 ) {
                echo $this->session->set_flashdata('msg','<div class="alert alert-success" role="alert">
                  <strong>Data berhasil ditambahkan</strong>
                </div>');
                redirect(base_url('admin/ph'));
            } else {
                echo $this->session->set_flashdata('msg','<div class="alert alert-warning" role="alert">
                  <strong>Data Error</strong>
                </div>');
                redirect(base_url('admin/ph'));
            }
        }
    }

    public function edit_ph($gettgl){
        $nip = $this->session->userdata('presensi');
        $data = array( 'active' => "edit_ph",
            'getdataph' => $this->M_Referensi->getByField("t_ph","tanggal",$gettgl),
            'data_setting' => $this->M_Referensi->getByField("t_setting","status_setting",1),
            'data_user_login' => $this->M_Referensi->getByField("t_user","nip",$nip));
        $data["data_jabatan_login"] = $this->M_Referensi->getByField("t_jabatan","id_jbtn",$data["data_user_login"]->jbtn);
        $this->load->view('admin/header', $data);
        $this->load->view('admin/update_ph', $data);
        $this->load->view('admin/footer');
    }

    public function e_ph(){
        $cektgl = $this->input->post('get_tgl');
        $tgl = $this->input->post('tgl');
        $cek_tgl = $this->M_Referensi->cekvalidasi('t_ph','tanggal',$tgl,$cektgl);
        if ($cek_tgl > 0) {
            echo $this->session->set_flashdata('msg','<div class="alert alert-warning" role="alert">
              <strong>Tanggal Ganda</strong>
            </div>');
            redirect(base_url('admin/ph'));
        }else{
            if ($this->M_Referensi->updateph()) {
                echo $this->session->set_flashdata('msg','<div class="alert alert-success" role="alert">
                  <strong>Data berhasil diubah</strong>
                </div>');
                redirect(base_url('admin/ph'));
            }else{
                echo $this->session->set_flashdata('msg','<div class="alert alert-warning" role="alert">
                  <strong>Data error</strong>
                </div>');
                redirect(base_url('admin/ph'));
            }
        }
    }

    public function hapus_ph(){
        $tanggal=$this->input->post('tanggal');
        if( $this->M_Referensi->hapusByField('t_ph','tanggal',$tanggal) > 0 ) {
            echo $this->session->set_flashdata('msg','<div class="alert alert-success" role="alert">
              <strong>Data berhasil dihapus</strong>
            </div>');
            redirect(base_url('admin/ph'));
        } else {
            echo $this->session->set_flashdata('msg','<div class="alert alert-warning" role="alert">
              <strong>Error, data gagal dihapus</strong>
            </div>');
            redirect(base_url('admin/ph'));
        }
    }

    public function e_akun(){
        $ceknip = $this->input->post('get_nip');
        $fileName  = $_FILES['foto']['name'];
        $cek_gambar = $this->M_Referensi->getByField('t_user','nip',$ceknip);
        $getuserFile = $cek_gambar->gambar;
        $foto = ", gambar='".$cek_gambar->gambar."'";
        if($fileName){
            $fileExt   = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $userFile  = time().'_'.rand(1000,9999).'.'.$fileExt;
            $foto = ", gambar='".$userFile."'";
            $config['file_name']        = $userFile;
            $config['upload_path']      = './assets/images/foto/';
            $config['allowed_types']    = 'gif|jpg|png';
            $config['max_size']         = 2560;

            $this->load->library('upload', $config);
            if ($this->upload->do_upload('foto')){
                unlink('./assets/images/foto/'.$getuserFile);
                if ($this->M_Referensi->updateakun($foto)) {
                    echo $this->session->set_flashdata('msg','<div class="alert alert-success" role="alert">
                      <strong>Data berhasil diubah</strong>
                    </div>');
                    redirect(base_url('admin/pengaturan'));
                }else{
                    echo $this->session->set_flashdata('msg','<div class="alert alert-warning" role="alert">
                      <strong>Data error</strong>
                    </div>');
                    redirect(base_url('admin/pengaturan'));
                }
            }else{
                echo $this->session->set_flashdata('msg','<div class="alert alert-warning" role="alert">
                  <strong>'.$this->upload->display_errors().'</strong>
                </div>');
                redirect(base_url('admin/pengaturan'));
            }
        }else{
            if ($this->M_Referensi->updateakun($foto)) {
                echo $this->session->set_flashdata('msg','<div class="alert alert-success" role="alert">
                  <strong>Data berhasil diubah</strong>
                </div>');
                redirect(base_url('admin/pengaturan'));
            }else{
                echo $this->session->set_flashdata('msg','<div class="alert alert-warning" role="alert">
                  <strong>Data error</strong>
                </div>');
                redirect(base_url('admin/pengaturan'));
            }
        }
    }

    public function t_presensi(){
        $nip = $this->input->post('nip');
        $tgl = $this->input->post('tgl_presensi');
        $ket = $this->input->post('keterangan');
        if ($tgl > $this->today) {
            echo $this->session->set_flashdata('msg','<div class="alert alert-warning" role="alert">
              <strong>Error, presensi gagal</strong>
            </div>');
            redirect(base_url('admin/dashboard'));
        } else {
            if( $this->M_Presensi->rekamonline($nip,$tgl,$ket) > 0 ) {
                echo $this->session->set_flashdata('msg','<div class="alert alert-success" role="alert">
                  <strong>Terimakasih, presensi berhasil</strong>
                  <audio autoplay> <source src="'.base_url().'assets/audio/thankyou.mp3"> </audio>
                </div>');
                redirect(base_url('admin/dashboard'));
            } else {
                echo $this->session->set_flashdata('msg','<div class="alert alert-warning" role="alert">
                  <strong>Error, presensi gagal</strong>
                </div>');
                redirect(base_url('admin/dashboard'));
            }
        }
    }

    public function hapus_presensi(){
        if( $this->M_Presensi->hapus_row_presensi() > 0 ) {
            echo $this->session->set_flashdata('msg','<div class="alert alert-success" role="alert">
              <strong>Data berhasil dihapus</strong>
            </div>');
            redirect(base_url('admin/dashboard'));
        } else {
            echo $this->session->set_flashdata('msg','<div class="alert alert-warning" role="alert">
              <strong>Error, data gagal dihapus</strong>
            </div>');
            redirect(base_url('admin/dashboard'));
        }
    }
}