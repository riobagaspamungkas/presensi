<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pegawai extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //validasi jika user belum login
        if($this->session->userdata('h_presensi') != 'pegawai'){
            $url=base_url();
            redirect($url);
        }
        date_default_timezone_set('Asia/Jakarta');
        $this->today = date('Y-m-d');
        $this->clocknow = date('H:i:s');
        $this->load->model("M_Referensi");
        $this->load->model("M_Presensi");
        $this->load->model("M_Izin");
        $this->load->model("M_Kegiatan");
    }
    
    public function index(){
        redirect(base_url('pegawai/dashboard'));
    }

    public function dashboard(){
        $nip = $this->session->userdata('presensi');
        $centang = 8;
        $tgl_dari = '';
        $tgl_sampai = '';
        if (isset($_POST['tombolfilter']) OR isset($_POST['export'])) {
            if ($this->input->post('filtgl') == 0) {
                $centang = 0;
            }else {
                $centang = 8;
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
        $data = array( 'active' => "dashboard",
            'tgl_dari' => $tgl_dari,
            'tgl_sampai' => $tgl_sampai,
            'centang' => $centang,
            'pegawai' => $this->input->post('pegawai'),
            'rowpresensi' => $this->M_Presensi->presensipegawai($tgl_dari,$tgl_sampai,$centang,$nip),
            'data_setting' => $this->M_Referensi->getByField("t_setting","status_setting",1),
            'data_user_login' => $this->M_Referensi->getByField("t_user","nip",$nip));
        $data["data_jabatan_login"] = $this->M_Referensi->getByField("t_jabatan","id_jbtn",$data["data_user_login"]->jbtn);
        if (isset($_POST['export'])) {
            $this->load->view('pegawai/export_pdf', $data);
        }else{
            $this->load->view('pegawai/header', $data);
            $this->load->view('pegawai/dashboard', $data);
        }
    }

    public function detail_kehadiran($id){
        $nip = $this->session->userdata('presensi');
        $data = array( 'active' => "detail_kehadiran",
            'data_kehadiran' => $this->M_Presensi->detail_kehadiran($id),
            'data_setting' => $this->M_Referensi->getByField("t_setting","status_setting",1),
            'data_user_login' => $this->M_Referensi->getByField("t_user","nip",$nip));
        $data["data_jabatan_login"] = $this->M_Referensi->getByField("t_jabatan","id_jbtn",$data["data_user_login"]->jbtn);
        $this->load->view('pegawai/header', $data);
        $this->load->view('pegawai/detail_kehadiran', $data);
        $this->load->view('pegawai/footer');
    }

    public function histori(){
        $nip = $this->session->userdata('presensi');
        $data = array( 'active' => "histori",
            'data_setting' => $this->M_Referensi->getByField("t_setting","status_setting",1),
            'data_user_login' => $this->M_Referensi->getByField("t_user","nip",$nip));
        $data["histori"] = $this->M_Izin->histori($data["data_user_login"]->akses,'cuti dl',$nip);
        $data["data_jabatan_login"] = $this->M_Referensi->getByField("t_jabatan","id_jbtn",$data["data_user_login"]->jbtn);
        $this->load->view('pegawai/header', $data);
        $this->load->view('pegawai/histori', $data);
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
        $this->load->view('pegawai/data_histori', $data);
    }

    public function detail_permohonan($time,$tabel){
        $nip = $this->session->userdata('presensi');
        $id = date('Y-m-d H:i:s',$time);
        $data = array( 'active' => "detail_permohonan",
            'getdatapengajuan' => $this->M_Izin->datapersetujuan($tabel,$id),
            'data_setting' => $this->M_Referensi->getByField("t_setting","status_setting",1),
            'data_user_login' => $this->M_Referensi->getByField("t_user","nip",$nip));
        $data["data_jabatan_login"] = $this->M_Referensi->getByField("t_jabatan","id_jbtn",$data["data_user_login"]->jbtn);
        $this->load->view('pegawai/header', $data);
        $this->load->view('pegawai/detail_permohonan_'.$tabel, $data);
        $this->load->view('pegawai/footer');
    }

    public function tampil($file){
        $nip = $this->session->userdata('presensi');
        $data = array( 'active' => "tampil",
            'jenis' => "permohonan",
            'file' => $file);
        $this->load->view('pegawai/tampil', $data);
    }

    public function kegiatan(){
        $nip = $this->session->userdata('presensi');
        $data = array( 'active' => "kegiatan",
            'nip' => $nip,
            'modal' => $this->M_Kegiatan->modal('t_desk_kegiatan'),
            'kegiatan' => $this->M_Kegiatan->kegiatan($nip),
            'data_setting' => $this->M_Referensi->getByField("t_setting","status_setting",1),
            'data_user_login' => $this->M_Referensi->getByField("t_user","nip",$nip));
        $data["data_jabatan_login"] = $this->M_Referensi->getByField("t_jabatan","id_jbtn",$data["data_user_login"]->jbtn);
        $this->load->view('pegawai/header', $data);
        $this->load->view('pegawai/kegiatan', $data);
    }

    public function monitoring(){
        $nip = $this->session->userdata('presensi');
        $data = array( 'active' => "monitoring",
            'nip' => $this->M_Kegiatan->cekuser(),
            'rowkegiatan' => $this->M_Kegiatan->data_carousel(),
            'data_setting' => $this->M_Referensi->getByField("t_setting","status_setting",1),
            'data_user_login' => $this->M_Referensi->getByField("t_user","nip",$nip));
        $data["data_jabatan_login"] = $this->M_Referensi->getByField("t_jabatan","id_jbtn",$data["data_user_login"]->jbtn);
        $this->load->view('pegawai/header', $data);
        $this->load->view('pegawai/monitoring', $data);
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
        $this->load->view('pegawai/header', $data);
        $this->load->view('pegawai/detail_kegiatan', $data);
        $this->load->view('pegawai/footer');
    }

    public function tambah_kegiatan(){
        $nip = $this->session->userdata('presensi');
        $get_date=$this->input->post('get_date');
        $data = array( 'active' => "tambah_kegiatan",
            'get_date' => $get_date,
            'data_setting' => $this->M_Referensi->getByField("t_setting","status_setting",1),
            'data_user_login' => $this->M_Referensi->getByField("t_user","nip",$nip));
        $data["data_jabatan_login"] = $this->M_Referensi->getByField("t_jabatan","id_jbtn",$data["data_user_login"]->jbtn);
        $this->load->view('pegawai/header', $data);
        $this->load->view('pegawai/tambah_kegiatan', $data);
        $this->load->view('pegawai/footer');
    }

    public function t_kegiatan(){
        $dari = '';
        $jam_mulai = $this->input->post('jam_mulai');
        $menit_mulai = $this->input->post('menit_mulai');
        $dari .= $jam_mulai .":".$menit_mulai;
        $strdari = strtotime($dari);
        $jam_dari = date("H:i",$strdari);

        $sampai = '';
        $jam_selesai = $this->input->post('jam_selesai');
        $menit_selesai = $this->input->post('menit_selesai');
        $sampai .= $jam_selesai .":".$menit_selesai;
        $strsampai = strtotime($sampai);
        $jam_sampai = date("H:i",$strsampai);
        
        if ($jam_dari>$jam_sampai) {
            echo $this->session->set_flashdata('msg','<div class="alert alert-warning" role="alert">
              <strong>Data Error</strong>
            </div>');
            redirect(base_url('pegawai/kegiatan'));
        }else{
            $fileName  = $_FILES['lampiran']['name'];
            $fileExt   = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $userFile  = time().'_'.rand(1000,9999).'.'.$fileExt;
            $config['file_name']        = $userFile;
            $config['upload_path']      = './assets/upload/kegiatan';
            $config['allowed_types']    = 'pdf|gif|jpg|png';
            $config['max_size']         = 5000;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('lampiran')){
                if ($this->M_Kegiatan->tambahkegiatan($userFile)) {
                    echo $this->session->set_flashdata('msg','<div class="alert alert-success" role="alert">
                      <strong>Data berhasil disimpan</strong>
                    </div>');
                    redirect(base_url('pegawai/kegiatan'));
                }else{
                    echo $this->session->set_flashdata('msg','<div class="alert alert-warning" role="alert">
                      <strong>Data error</strong>
                    </div>');
                    redirect(base_url('pegawai/kegiatan'));
                }
            }else{
                echo $this->session->set_flashdata('msg','<div class="alert alert-warning" role="alert">
                  <strong>'.$this->upload->display_errors().'</strong>
                </div>');
                redirect(base_url('pegawai/kegiatan'));
            }
        }
    }

    public function hapus_kegiatan(){
        if( $this->M_Kegiatan->hapus_kegiatan() > 0 ) {
            echo $this->session->set_flashdata('msg','<div class="alert alert-success" role="alert">
              <strong>Data berhasil dihapus</strong>
            </div>');
            redirect(base_url('pegawai/kegiatan'));
        } else {
            echo $this->session->set_flashdata('msg','<div class="alert alert-warning" role="alert">
              <strong>Error, data gagal dihapus</strong>
            </div>');
            redirect(base_url('pegawai/kegiatan'));
        }
    }

    public function tampil_kegiatan($file){
        $nip = $this->session->userdata('presensi');
        $data = array( 'active' => "tampil",
            'jenis' => "kegiatan",
            'file' => $file);
        $this->load->view('pegawai/tampil', $data);
    }

    public function data_kegiatan(){
        $nip = $this->session->userdata('presensi');
        $date=$this->input->post('date');
        $data = array( 'active' => "kegiatan",
            'nip' => $nip,
            'date' => $date,
            'kegiatan' => $this->M_Kegiatan->data_kegiatan($nip,$date),
            'data_setting' => $this->M_Referensi->getByField("t_setting","status_setting",1),
            'data_user_login' => $this->M_Referensi->getByField("t_user","nip",$nip));
        $data["data_jabatan_login"] = $this->M_Referensi->getByField("t_jabatan","id_jbtn",$data["data_user_login"]->jbtn);
        $this->load->view('pegawai/data_kegiatan', $data);
    }

    public function update_kegiatan($id){
        $nip = $this->session->userdata('presensi');
        $data = array( 'active' => "update_kegiatan",
            'desk_kegiatan' => $this->M_Referensi->getByField("t_desk_kegiatan","id_deskripsi",$id),
            'data_setting' => $this->M_Referensi->getByField("t_setting","status_setting",1),
            'data_user_login' => $this->M_Referensi->getByField("t_user","nip",$nip));
        $data["getdatakegiatan"] = $this->M_Referensi->getByField("t_kegiatan","id_kegiatan",$data["desk_kegiatan"]->id_kegiatan);
        $data["data_jabatan_login"] = $this->M_Referensi->getByField("t_jabatan","id_jbtn",$data["data_user_login"]->jbtn);
        $data["data_jenis_permohonan"] = $this->M_Referensi->getAllData("t_jenis_permohonan")->result();
        $this->load->view('pegawai/header', $data);
        $this->load->view('pegawai/update_kegiatan', $data);
        $this->load->view('pegawai/footer');
    }

    public function e_kegiatan(){
        $get_id = $this->input->post('get_id');
        $dari = '';
        $jam_mulai = $this->input->post('jam_mulai');
        $menit_mulai = $this->input->post('menit_mulai');
        $dari .= $jam_mulai .":".$menit_mulai;
        $strdari = strtotime($dari);
        $jam_dari = date("H:i",$strdari);

        $sampai = '';
        $jam_selesai = $this->input->post('jam_selesai');
        $menit_selesai = $this->input->post('menit_selesai');
        $sampai .= $jam_selesai .":".$menit_selesai;
        $strsampai = strtotime($sampai);
        $jam_sampai = date("H:i",$strsampai);
        
        if ($jam_dari>$jam_sampai) {
            echo $this->session->set_flashdata('msg','<div class="alert alert-warning" role="alert">
              <strong>Data Error</strong>
            </div>');
            redirect(base_url('pegawai/kegiatan'));
        }else{
            $fileName  = $_FILES['lampiran']['name'];
            $cek_lampiran = $this->M_Referensi->getByField('t_desk_kegiatan','id_deskripsi',$get_id);
            $getuserFile = $cek_lampiran->lampiran;
            $lampiran = ", lampiran='".$getuserFile."'";
            if($fileName){
                $fileExt   = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                $userFile  = time().'_'.rand(1000,9999).'.'.$fileExt;
                $lampiran = ", lampiran='".$userFile."'";
                $config['file_name']        = $userFile;
                $config['upload_path']      = './assets/upload/kegiatan/';
                $config['allowed_types']    = 'pdf|gif|jpg|png';
                $config['max_size']         = 5000;

                $this->load->library('upload', $config);
                if ($this->upload->do_upload('lampiran')){
                    unlink('./assets/upload/kegiatan/'.$getuserFile);
                    if ($this->M_Kegiatan->updatekegiatan($lampiran)) {
                        echo $this->session->set_flashdata('msg','<div class="alert alert-success" role="alert">
                          <strong>Data berhasil diubah</strong>
                        </div>');
                        redirect(base_url('pegawai/kegiatan'));
                    }else{
                        echo $this->session->set_flashdata('msg','<div class="alert alert-warning" role="alert">
                          <strong>Data error</strong>
                        </div>');
                        redirect(base_url('pegawai/kegiatan'));
                    }
                }else{
                    echo $this->session->set_flashdata('msg','<div class="alert alert-warning" role="alert">
                      <strong>'.$this->upload->display_errors().'</strong>
                    </div>');
                    redirect(base_url('pegawai/kegiatan'));
                }
            }else{
                if ($this->M_Kegiatan->updatekegiatan($lampiran)) {
                    echo $this->session->set_flashdata('msg','<div class="alert alert-success" role="alert">
                      <strong>Data berhasil diubah</strong>
                    </div>');
                    redirect(base_url('pegawai/kegiatan'));
                }else{
                    echo $this->session->set_flashdata('msg','<div class="alert alert-warning" role="alert">
                      <strong>Data error</strong>
                    </div>');
                    redirect(base_url('pegawai/kegiatan'));
                }
            }
        }
    }

    public function pengajuan_cuti(){
        $nip = $this->session->userdata('presensi');
        $data = array( 'active' => "pengajuan_cuti",
            'getdatapengajuan' => $this->M_Izin->getDataPengajuanCuti($nip),
            'listcuti' => $this->M_Referensi->getAllData("t_jenis_cuti"),
            'data_setting' => $this->M_Referensi->getByField("t_setting","status_setting",1),
            'data_user_login' => $this->M_Referensi->getByField("t_user","nip",$nip));
        $data["data_jabatan_login"] = $this->M_Referensi->getByField("t_jabatan","id_jbtn",$data["data_user_login"]->jbtn);
        $this->load->view('pegawai/header', $data);
        $this->load->view('pegawai/pengajuan_cuti', $data);
        $this->load->view('pegawai/footer');
    }

    public function form_pengajuan_cuti($id){
        $nip = $this->session->userdata('presensi');
        $data = array( 'active' => "form_pengajuan_cuti",
            'id_jenis_cuti' => $id,
            'getcuti' => $this->M_Referensi->getByField("t_jenis_cuti","id_jenis_cuti",$id),
            'data_setting' => $this->M_Referensi->getByField("t_setting","status_setting",1),
            'data_user_login' => $this->M_Referensi->getByField("t_user","nip",$nip));
        $data["data_jabatan_login"] = $this->M_Referensi->getByField("t_jabatan","id_jbtn",$data["data_user_login"]->jbtn);
        $data["data_jenis_cuti"] = $this->M_Referensi->getAllData("t_jenis_cuti")->result();
        $this->load->view('pegawai/header', $data);
        $this->load->view('pegawai/form_pengajuan_cuti', $data);
    }

    public function t_pengajuan_cuti(){
        $daterange = $this->input->post('daterange');
        $tgl_dari = implode(" ", array_slice(explode(" ", $daterange), 0, 1));
        $tgl_sampai = implode(" ", array_slice(explode(" ", $daterange), 2, 2));
        $fileName  = $_FILES['bukti']['name'];
        $fileExt   = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $userFile  = time().'_'.rand(1000,9999).'.'.$fileExt;
        $config['file_name']        = $userFile;
        $config['upload_path']      = './assets/upload/cuti';
        $config['allowed_types']    = 'pdf|gif|jpg|png';
        $config['max_size']         = 5000;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('bukti')){
            if ($this->M_Izin->tambahpengajuan($userFile)) {
                echo $this->session->set_flashdata('msg','<div class="alert alert-success" role="alert">
                  <strong>Data berhasil disimpan</strong>
                </div>');
                redirect(base_url('pegawai/pengajuan_cuti'));
            }else{
                echo $this->session->set_flashdata('msg','<div class="alert alert-warning" role="alert">
                  <strong>Data error</strong>
                </div>');
                redirect(base_url('pegawai/pengajuan_cuti'));
            }
        }else{
            echo $this->session->set_flashdata('msg','<div class="alert alert-warning" role="alert">
              <strong>'.$this->upload->display_errors().'</strong>
            </div>');
            redirect(base_url('pegawai/pengajuan_cuti'));
        }
    }

    public function update_pengajuan_cuti($time){
        $nip = $this->session->userdata('presensi');
        $id = date('Y-m-d H:i:s',$time);
        $data = array( 'active' => "update_pengajuan_cuti",
            'getdatapengajuan' => $this->M_Referensi->getByField("t_cuti","time",$id),
            'data_setting' => $this->M_Referensi->getByField("t_setting","status_setting",1),
            'data_user_login' => $this->M_Referensi->getByField("t_user","nip",$nip));
        $data["data_jabatan_login"] = $this->M_Referensi->getByField("t_jabatan","id_jbtn",$data["data_user_login"]->jbtn);
        $data["getcuti"] = $this->M_Referensi->getByField("t_jenis_cuti","id_jenis_cuti",$data["getdatapengajuan"]->jenis_cuti);
        $data["data_jenis_cuti"] = $this->M_Referensi->getAllData("t_jenis_cuti")->result();
        $this->load->view('pegawai/header', $data);
        $this->load->view('pegawai/update_pengajuan_cuti', $data);
    }

    public function e_pengajuan_cuti(){
        $get_time = $this->input->post('get_time');
        $daterange = $this->input->post('daterange');
        $tgl_dari = implode(" ", array_slice(explode(" ", $daterange), 0, 1));
        $tgl_sampai = implode(" ", array_slice(explode(" ", $daterange), 2, 2));
        $fileName  = $_FILES['bukti']['name'];
        $cek_bukti = $this->M_Referensi->getByField('t_cuti','time',$get_time);
        $getuserFile = $cek_bukti->bukti;
        $bukti = ", bukti='".$getuserFile."'";
        if($fileName){
            $fileExt   = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $userFile  = time().'_'.rand(1000,9999).'.'.$fileExt;
            $bukti = ", bukti='".$userFile."'";
            $config['file_name']        = $userFile;
            $config['upload_path']      = './assets/upload/cuti/';
            $config['allowed_types']    = 'pdf|gif|jpg|png';
            $config['max_size']         = 5000;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('bukti')){
                unlink('./assets/upload/cuti/'.$getuserFile);
                if ($this->M_Izin->updatepengajuan($bukti)) {
                    echo $this->session->set_flashdata('msg','<div class="alert alert-success" role="alert">
                      <strong>Data berhasil diubah</strong>
                    </div>');
                    redirect(base_url('pegawai/pengajuan_cuti'));
                }else{
                    echo $this->session->set_flashdata('msg','<div class="alert alert-warning" role="alert">
                      <strong>Data error</strong>
                    </div>');
                    redirect(base_url('pegawai/pengajuan_cuti'));
                }
            }else{
                echo $this->session->set_flashdata('msg','<div class="alert alert-warning" role="alert">
                  <strong>'.$this->upload->display_errors().'</strong>
                </div>');
                redirect(base_url('pegawai/pengajuan_cuti'));
            }
        }else{
            if ($this->M_Izin->updatepengajuan($bukti)) {
                echo $this->session->set_flashdata('msg','<div class="alert alert-success" role="alert">
                  <strong>Data berhasil diubah</strong>
                </div>');
                redirect(base_url('pegawai/pengajuan_cuti'));
            }else{
                echo $this->session->set_flashdata('msg','<div class="alert alert-warning" role="alert">
                  <strong>Data error</strong>
                </div>');
                redirect(base_url('pegawai/pengajuan_cuti'));
            }
        }
    }

    public function hapus_pengajuan_cuti(){
        if( $this->M_Izin->hapus_pengajuan() > 0 ) {
            echo $this->session->set_flashdata('msg','<div class="alert alert-success" role="alert">
              <strong>Data berhasil dihapus</strong>
            </div>');
            redirect(base_url('pegawai/pengajuan_cuti'));
        } else {
            echo $this->session->set_flashdata('msg','<div class="alert alert-warning" role="alert">
              <strong>Error, data gagal dihapus</strong>
            </div>');
            redirect(base_url('pegawai/pengajuan_cuti'));
        }
    }

    public function pengajuan_dl(){
        $nip = $this->session->userdata('presensi');
        $data = array( 'active' => "pengajuan_dl",
            'getdatapengajuan' => $this->M_Izin->getDataPengajuanDL($nip),
            'data_setting' => $this->M_Referensi->getByField("t_setting","status_setting",1),
            'data_user_login' => $this->M_Referensi->getByField("t_user","nip",$nip));
        $data["data_jabatan_login"] = $this->M_Referensi->getByField("t_jabatan","id_jbtn",$data["data_user_login"]->jbtn);
        $this->load->view('pegawai/header', $data);
        $this->load->view('pegawai/pengajuan_dl', $data);
        $this->load->view('pegawai/footer');
    }

    public function form_pengajuan_dl(){
        $nip = $this->session->userdata('presensi');
        $data = array( 'active' => "form_pengajuan_dl",
            'pegawai' => $this->M_Referensi->getPegawaiTanpaAdmin(),
            'data_setting' => $this->M_Referensi->getByField("t_setting","status_setting",1),
            'data_user_login' => $this->M_Referensi->getByField("t_user","nip",$nip));
        $data["data_jabatan_login"] = $this->M_Referensi->getByField("t_jabatan","id_jbtn",$data["data_user_login"]->jbtn);
        $this->load->view('pegawai/header', $data);
        $this->load->view('pegawai/form_pengajuan_dl', $data);
    }

    public function t_pengajuan_dl(){
        $tgl_berangkat = $this->input->post('tgl_berangkat');
        $tgl_kembali = $this->input->post('tgl_kembali');
        if ($tgl_berangkat>$tgl_kembali) {
            echo $this->session->set_flashdata('msg','<div class="alert alert-warning" role="alert">
              <strong>Data Error</strong>
            </div>');
            redirect(base_url('pegawai/pengajuan_dl'));
        }else{
            $fileName  = $_FILES['bukti']['name'];
            $fileExt   = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $userFile  = time().'_'.rand(1000,9999).'.'.$fileExt;
            $config['file_name']        = $userFile;
            $config['upload_path']      = './assets/upload/dinasluar';
            $config['allowed_types']    = 'pdf|gif|jpg|png';
            $config['max_size']         = 5000;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('bukti')){
                if ($this->M_Izin->tambahdl($userFile)) {
                    echo $this->session->set_flashdata('msg','<div class="alert alert-success" role="alert">
                      <strong>Data berhasil disimpan</strong>
                    </div>');
                    redirect(base_url('pegawai/pengajuan_dl'));
                }else{
                    echo $this->session->set_flashdata('msg','<div class="alert alert-warning" role="alert">
                      <strong>Data error</strong>
                    </div>');
                    redirect(base_url('pegawai/pengajuan_dl'));
                }
            }else{
                echo $this->session->set_flashdata('msg','<div class="alert alert-warning" role="alert">
                  <strong>'.$this->upload->display_errors().'</strong>
                </div>');
                redirect(base_url('pegawai/pengajuan_dl'));
            }
        }
    }

    public function update_pengajuan_dl($time){
        $nip = $this->session->userdata('presensi');
        $id = date('Y-m-d H:i:s',$time);
        $data = array( 'active' => "update_pengajuan_dl",
            'pegawai' => $this->M_Referensi->getPegawaiTanpaAdmin(),
            'countnip' => $this->M_Izin->countnip($id),
            'getdatapengajuan' => $this->M_Referensi->getByField("t_dl","time",$id),
            'data_setting' => $this->M_Referensi->getByField("t_setting","status_setting",1),
            'data_user_login' => $this->M_Referensi->getByField("t_user","nip",$nip));
        $data["data_jabatan_login"] = $this->M_Referensi->getByField("t_jabatan","id_jbtn",$data["data_user_login"]->jbtn);
        $this->load->view('pegawai/header', $data);
        $this->load->view('pegawai/update_pengajuan_dl', $data);
    }

    public function e_pengajuan_dl(){
        $get_time = $this->input->post('get_time');
        $tgl_berangkat = $this->input->post('tgl_berangkat');
        $tgl_kembali = $this->input->post('tgl_kembali');
        if ($tgl_berangkat>$tgl_kembali) {
            echo $this->session->set_flashdata('msg','<div class="alert alert-warning" role="alert">
              <strong>Data Error</strong>
            </div>');
            redirect(base_url('pegawai/pengajuan_dl'));
        }else{
            $fileName  = $_FILES['bukti']['name'];
            $cek_bukti = $this->M_Referensi->getByField('t_dl','time',$get_time);
            $getuserFile = $cek_bukti->bukti;
            $bukti = ", bukti='".$getuserFile."'";
            if($fileName){
                $fileExt   = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                $userFile  = time().'_'.rand(1000,9999).'.'.$fileExt;
                $bukti = ", bukti='".$userFile."'";
                $config['file_name']        = $userFile;
                $config['upload_path']      = './assets/upload/dinasluar/';
                $config['allowed_types']    = 'pdf|gif|jpg|png';
                $config['max_size']         = 5000;
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('bukti')){
                    unlink('./assets/upload/dinasluar/'.$getuserFile);
                    if ($this->M_Izin->updatedl($bukti)) {
                        echo $this->session->set_flashdata('msg','<div class="alert alert-success" role="alert">
                          <strong>Data berhasil diubah</strong>
                        </div>');
                        redirect(base_url('pegawai/pengajuan_dl'));
                    }else{
                        echo $this->session->set_flashdata('msg','<div class="alert alert-warning" role="alert">
                          <strong>Data error</strong>
                        </div>');
                        redirect(base_url('pegawai/pengajuan_dl'));
                    }
                }else{
                    echo $this->session->set_flashdata('msg','<div class="alert alert-warning" role="alert">
                      <strong>'.$this->upload->display_errors().'</strong>
                    </div>');
                    redirect(base_url('pegawai/pengajuan_dl'));
                }
            }else{
                if ($this->M_Izin->updatedl($bukti)) {
                    echo $this->session->set_flashdata('msg','<div class="alert alert-success" role="alert">
                      <strong>Data berhasil diubah</strong>
                    </div>');
                    redirect(base_url('pegawai/pengajuan_dl'));
                }else{
                    echo $this->session->set_flashdata('msg','<div class="alert alert-warning" role="alert">
                      <strong>Data error</strong>
                    </div>');
                    redirect(base_url('pegawai/pengajuan_dl'));
                }
            }
        }
    }

    public function hapus_pengajuan_dl(){
        if( $this->M_Izin->hapus_dl() > 0 ) {
            echo $this->session->set_flashdata('msg','<div class="alert alert-success" role="alert">
              <strong>Data berhasil dihapus</strong>
            </div>');
            redirect(base_url('pegawai/pengajuan_dl'));
        } else {
            echo $this->session->set_flashdata('msg','<div class="alert alert-warning" role="alert">
              <strong>Error, data gagal dihapus</strong>
            </div>');
            redirect(base_url('pegawai/pengajuan_dl'));
        }
    }

    public function pengaturan(){
        $nip = $this->session->userdata('presensi');
        $data = array( 'active' => "pengaturan",
            'data_setting' => $this->M_Referensi->getByField("t_setting","status_setting",1),
            'data_user_login' => $this->M_Referensi->getByField("t_user","nip",$nip));
        $data["data_jabatan_login"] = $this->M_Referensi->getByField("t_jabatan","id_jbtn",$data["data_user_login"]->jbtn);
        $data["data_jabatan"] = $this->M_Referensi->getAllData("t_jabatan")->result();
        $this->load->view('pegawai/header', $data);
        $this->load->view('pegawai/pengaturan', $data);
        $this->load->view('pegawai/footer');
    }

    public function about() {
        $nip = $this->session->userdata('presensi');
        $data = array( 'active' => "about",
            'data_setting' => $this->M_Referensi->getByField("t_setting","status_setting",1),
            'data_user_login' => $this->M_Referensi->getByField("t_user","nip",$nip));
        $data["data_jabatan_login"] = $this->M_Referensi->getByField("t_jabatan","id_jbtn",$data["data_user_login"]->jbtn);
        $this->load->view('pegawai/header', $data);
        $this->load->view('pegawai/about', $data);
        $this->load->view('pegawai/footer');
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
                    redirect(base_url('pegawai/pengaturan'));
                }else{
                    echo $this->session->set_flashdata('msg','<div class="alert alert-warning" role="alert">
                      <strong>Data error</strong>
                    </div>');
                    redirect(base_url('pegawai/pengaturan'));
                }
            }else{
                echo $this->session->set_flashdata('msg','<div class="alert alert-warning" role="alert">
                  <strong>'.$this->upload->display_errors().'</strong>
                </div>');
                redirect(base_url('pegawai/pengaturan'));
            }
        }else{
            if ($this->M_Referensi->updateakun($foto)) {
                echo $this->session->set_flashdata('msg','<div class="alert alert-success" role="alert">
                  <strong>Data berhasil diubah</strong>
                </div>');
                redirect(base_url('pegawai/pengaturan'));
            }else{
                echo $this->session->set_flashdata('msg','<div class="alert alert-warning" role="alert">
                  <strong>Data error</strong>
                </div>');
                redirect(base_url('pegawai/pengaturan'));
            }
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
                      <strong>Berhasil reset password, passwordnya adalah '.$pass.'</strong>
                    </div>');
                    redirect(base_url('pegawai/'.$page));
                } else {
                    echo $this->session->set_flashdata('msg','<div class="alert alert-warning" role="alert">
                      <strong>Data Error</strong>
                    </div>');
                    redirect(base_url('pegawai/'.$page));
                }
            }else{
                echo "<script>alert('Password baru anda tidak match, silahkan coba lagi!');history.go(-1);</script>";
            }
        }else{
            echo "<script>alert('Password lama anda salah, silahkan coba lagi!');history.go(-1);</script>";
        }
    }

    public function absen($ket){
        $nip = $this->session->userdata('presensi');
        if ($this->M_Presensi->inputmaps($ket,$nip) > 0) {
            echo $this->session->set_flashdata('msg','<div class="alert alert-success" role="alert">
              <strong>Terimakasih, presensi berhasil</strong>
            </div>');
        }else{
            echo $this->session->set_flashdata('msg','<div class="alert alert-warning" role="alert">
              <strong>Error, presensi gagal</strong>
            </div>');
        }
    }
}