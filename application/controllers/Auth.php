<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    function __construct(){
        parent::__construct();
        $this->load->model('M_Auth');
    }
 
    function index(){
        $hak_akses = $this->session->userdata('h_presensi');
        $data['data_setting'] = $this->M_Auth->getByField("t_setting","status_setting",1);
        if($hak_akses=='admin'){
            redirect('admin');
        }else if($hak_akses == 'kepala'){
            redirect('kepala');
        }else if($hak_akses == 'pegawai'){
            redirect('pegawai');    
        }else{
            $this->load->view('auth/login',$data);
        }
    }

    function login(){
        $nip=htmlspecialchars($this->input->post('nip',TRUE),ENT_QUOTES);
        $pass=htmlspecialchars($this->input->post('pass',TRUE),ENT_QUOTES);
        $cek_user=$this->M_Auth->auth_user($nip,$pass);        
        if($cek_user->num_rows() > 0){
            $data=$cek_user->row_array();
            $this->session->set_userdata('h_presensi',$data['akses']);
            $this->session->set_userdata('presensi',$data['nip']);
            redirect($data['akses']);
        }else{
            echo $this->session->set_flashdata('msg','<div class="alert alert-warning" role="alert">
              <strong>NIP atau Password Salah</strong>
            </div>');
            redirect(base_url());
        }
    }
 
    function logout(){
        $this->session->unset_userdata('h_presensi');
        $this->session->unset_userdata('presensi');
        redirect(base_url(''));
    }
}