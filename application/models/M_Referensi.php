<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Referensi extends CI_Model
{
    public function input_data($data,$table){
        $query=$this->db->insert($table,$data);
        if ($query){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function getByField($table,$field,$value){
        $query=$this->db->query("SELECT * FROM $table WHERE $field='$value'");
        return $query->row();
    }

    public function getAllData($table){
        $query=$this->db->query("SELECT * FROM $table");
        return $query;
    }

    public function getDataPegawai($nip){
        $query=$this->db->query("SELECT * FROM t_user WHERE nip != $nip");
        return $query->result();
    }

    public function getPegawaiTanpaAdmin(){
        $query=$this->db->query("SELECT * FROM t_user WHERE akses!='admin' ORDER BY nip ASC");
        return $query->result();
    }

    public function tambahpegawai($foto){
        $nip = $this->input->post('nip');
        $pass = md5($this->input->post('pass'));
        $nama = $this->input->post('nama');
        $akses = $this->input->post('akses');
        $gol = $this->input->post('gol');
        $jk = $this->input->post('jk');
        $jbtn = $this->input->post('jbtn');
        $query=$this->db->query("insert into t_user values('$nip', '$pass', '$nama', '$akses', '$gol', '$jk', '$jbtn', '$foto')");
        if ($query){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    public function updateuser($foto){
        $ceknip = $this->input->post('get_nip');
        $nip = $this->input->post('nip');
        $nama = $this->input->post('nama');
        $akses = $this->input->post('akses');
        $gol = $this->input->post('gol');
        $jk = $this->input->post('jk');
        $jbtn = $this->input->post('jbtn');
        $cekquery = "update t_user set nip='$nip', nama='$nama', akses='$akses', gol='$gol', jk='$jk', jbtn='$jbtn' $foto where nip='$ceknip'";
        $query=$this->db->query("update t_user set nip='$nip', nama='$nama', akses='$akses', gol='$gol', jk='$jk', jbtn='$jbtn' $foto where nip='$ceknip'");
        if ($query){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function hapus_user(){
        $nip=$this->input->post('nip');
        $rowfoto = $this->getByField('t_user','nip',$nip);
        $foto = $rowfoto->gambar;
        $query=$this->db->query("DELETE FROM t_user WHERE nip = '$nip'");
        if ($query){
            unlink('./assets/images/foto/'.$foto);
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function resetpass($newpass){
        $nip=$this->input->post('nip');
        $password = md5($newpass);
        $query=$this->db->query("UPDATE t_user SET pass = '$password' WHERE nip = '$nip'");
        if ($query){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function gantipassword(){
        $nip=$this->input->post('get_nip');
        $newpass=md5($this->input->post('password_baru'));
        $password = md5($newpass);
        $query=$this->db->query("UPDATE t_user SET pass = '$newpass' WHERE nip = '$nip'");
        if ($query){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function cekvalidasi($table,$field,$value1,$value2){
        $ceknip = $this->input->post('get_nip');
        $nip = $this->input->post('nip');
        $query=$this->db->query("SELECT * FROM $table WHERE $field = '$value1' AND $field != '$value2'");
        return $query->row();
    }

    public function hapusByField($table,$field,$value){
        $query=$this->db->query("DELETE FROM $table WHERE $field='$value'");
        if ($query){
            return TRUE;
        }else{
            return FALSE;
        }
    }    
    
    public function updateph(){
        $cektgl = $this->input->post('get_tgl');
        $tgl = $this->input->post('tgl');
        $keterangan = $this->input->post('keterangan');
        $query=$this->db->query("update t_ph set tanggal='$tgl', keterangan='$keterangan' where tanggal='$cektgl'");
        if ($query){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function updateakun($foto){
        $ceknip = $this->input->post('get_nip');
        $nama = $this->input->post('nama');
        $gol = $this->input->post('gol');
        $jk = $this->input->post('jk');
        $jbtn = $this->input->post('jbtn');
        $query=$this->db->query("update t_user set nama='$nama', gol='$gol', jk='$jk', jbtn='$jbtn' $foto where nip='$ceknip'");
        if ($query){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function updatepengaturan($logo){
        $lokasi = 0;
        $get_id = $this->input->post('get_id');
        $absen_datang = $this->input->post('absen_datang');
        $absen_pulang = $this->input->post('absen_pulang');
        $ceklokasi = $this->input->post('lokasi');
        if ($ceklokasi) {
            $lokasi = 1;
        }
        $query=$this->db->query("update t_setting set absen_datang='$absen_datang', absen_pulang='$absen_pulang', lokasi='$lokasi' $logo where status_setting='$get_id'");
        if ($query){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function resetapp(){
        $id=$this->input->post('id');
        $query=$this->db->query("UPDATE t_setting SET absen_datang = '08:00:00', absen_pulang = '16:00:00', lokasi = 0, logo = 'logo.png' WHERE status_setting = '$id'");
        if ($query){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function import_update($nip,$password,$nama,$akses,$gol,$jk,$jbtn){
        $query=$this->db->query("UPDATE t_user SET pass = '$password', nama = '$nama', akses = '$akses', gol = '$gol', jk = '$jk', jbtn = '$jbtn' WHERE nip = '$nip'");
    }

    public function import($nip,$password,$nama,$akses,$gol,$jk,$jbtn,$gambar){
        $query=$this->db->query("INSERT INTO t_user VALUE($nip, '$password', '$nama', '$akses', '$gol', '$jk', '$jbtn', '$gambar')");
    }

    public function import_update2($nip,$nama,$password,$gambar){
        $query=$this->db->query("UPDATE excel SET nama = '$nama', password = '$password' WHERE nip = '$nip'");
    }

    public function import2($nip,$nama,$password,$gambar){
        $query=$this->db->query("INSERT INTO excel VALUE($nip, '$nama', '$password', '$gambar')");
    }
}