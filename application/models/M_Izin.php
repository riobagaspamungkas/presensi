<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Izin extends CI_Model
{
	public function __construct(){
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->today = date('Y-m-d');
    }

    public function getByField($table,$field,$value){
        $query=$this->db->query("SELECT * FROM $table WHERE $field='$value'");
        return $query->row();
    }

    public function countnip($id){
        $jumlah = 0;
        $query = $this->db->query("SELECT * FROM t_dl WHERE time='$id'")->result();
        foreach ($query as $row) {
            $nip1 = $row->nip1;
            $nip2 = $row->nip2;
            $nip3 = $row->nip3;
            $nip4 = $row->nip4;
            $nip5 = $row->nip5;
            for ($i=1; $i <6 ; $i++) { 
                if (${'nip'.$i} != '') {
                    $jumlah += 1;
                }
            }
        }
        return $jumlah;
    }

    public function persetujuan($hak_akses,$jenis_permohonan){
        $no = 0;
        $rowpersetujuan = array();
        if ($hak_akses=='admin') {
            $akses="kepala";
        }else{
            $akses='pegawai';
        }
        if ($jenis_permohonan == 'cuti dl' OR $jenis_permohonan == 'cuti') {
            $querycuti=$this->db->query("SELECT * FROM t_cuti where status_cuti = 1 ORDER BY time DESC")->result();
            foreach ($querycuti as $rowcuti) {
                $time = $rowcuti->time;
                $tgl_dari = $rowcuti->tgl_dari;
                $tgl_sampai = $rowcuti->tgl_sampai;
                $cekuser=$this->db->query("SELECT * FROM t_user where nip = $rowcuti->nip AND akses in('$akses')")->result();
                foreach ($cekuser as $rowuser) {
                    $cekjeniscuti=$this->db->query("SELECT * FROM t_jenis_cuti WHERE id_jenis_cuti = $rowcuti->jenis_cuti")->result();
                    foreach ($cekjeniscuti as $rowjeniscuti) {
                        $kedaluwarsa = $rowjeniscuti->kedaluwarsa;
                        $jenis_cuti = $rowjeniscuti->jenis_cuti;
                    }
                    $tambah_hari = "-".$kedaluwarsa." days";
                    $tglkedaluwarsa = date('Y-m-d', strtotime($tambah_hari, strtotime($this->today)));
                    if ($tgl_dari>=$tglkedaluwarsa) {
                        $rowpersetujuan[$no] = new stdClass;
                        $rowpersetujuan[$no]->time = $time;
                        $rowpersetujuan[$no]->tabel = 'cuti';
                        $rowpersetujuan[$no]->get_name = $rowuser->nama;
                        $rowpersetujuan[$no]->tgl_awal = $tgl_dari;
                        $rowpersetujuan[$no]->tgl_akhir = $tgl_sampai;
                        $rowpersetujuan[$no]->jenis_permohonan = $jenis_cuti;
                        $no++;
                    }
                }
            }
        }
        if ($jenis_permohonan == 'cuti dl' OR $jenis_permohonan == 'dl') {
            $cekhakakses = 'tidak';
            $tampil = 'tidak';
            $querydl=$this->db->query("SELECT * FROM t_dl where status_dl = 1 AND tgl_berangkat >= '$this->today' ORDER BY time DESC")->result();
            foreach ($querydl as $rowdl) {
                $time = $rowdl->time;
                $tgl_berangkat = $rowdl->tgl_berangkat;
                $tgl_kembali = $rowdl->tgl_kembali;
                $nip1 = $rowdl->nip1;
                $nip2 = $rowdl->nip2;
                $nip3 = $rowdl->nip3;
                $nip4 = $rowdl->nip4;
                $nip5 = $rowdl->nip5;
                $getnip = '';
                $pegawai = '';
                for ($i=1; $i <6 ; $i++) { 
                    if (${'nip'.$i} != '') {
                        $ceknamapegawai=$this->db->query("SELECT * FROM t_user WHERE nip = ${'nip'.$i}")->result();
                        foreach ($ceknamapegawai as $rowceknamapegawai) {
                            $getnip .= ${'nip'.$i}."','";
                            $pegawai .= $rowceknamapegawai->nama."<br>";
                        }
                    }
                }
                $getnip = substr($getnip,0,-3);
                $cektampil=$this->db->query("SELECT * FROM t_user WHERE nip in('$getnip') AND akses='kepala'");
                if($cektampil->num_rows() > 0){
                    $cekhakakses = 'ada';
                }
                if ($hak_akses=='admin' AND $cekhakakses=='ada') {
                    $tampil = 'ya';
                }
                if ($hak_akses=='kepala' AND $cekhakakses=='tidak') {
                    $tampil = 'ya';
                }
                if ($tampil == 'ya') {
                    $rowpersetujuan[$no] = new stdClass;
                    $rowpersetujuan[$no]->time = $time;
                    $rowpersetujuan[$no]->tabel = 'dl';
                    $rowpersetujuan[$no]->get_name = $pegawai;
                    $rowpersetujuan[$no]->tgl_awal = $tgl_berangkat;
                    $rowpersetujuan[$no]->tgl_akhir = $tgl_kembali;
                    $rowpersetujuan[$no]->jenis_permohonan = 'Dinas Luar';
                    $no++;
                }
                $no++;
                $cekhakakses = 'tidak';
                $tampil = 'tidak';
            }
        }
        return $rowpersetujuan;
    }

    public function datapersetujuan($tabel,$id){
        $gettabel = 't_'.$tabel;
        if ($tabel == 'cuti') {
            $query=$this->db->query("SELECT * FROM t_cuti WHERE time = '$id'");
            foreach ($query->result() as $row) {
                $time = $row->time;
                $nip = $row->nip;
                $querynama=$this->db->query("SELECT * FROM t_user WHERE nip = $nip")->result();
                foreach ($querynama as $rownama) {
                    $nama = $rownama->nama;
                }
                $tgl_dari = $row->tgl_dari;
                $tgl_sampai = $row->tgl_sampai;
                $jenis_cuti = $row->jenis_cuti;
                $queryjenis=$this->db->query("SELECT * FROM t_jenis_cuti WHERE id_jenis_cuti = $jenis_cuti")->result();
                foreach ($queryjenis as $rowjenis) {
                    $jenis_permohonan = $rowjenis->jenis_cuti;
                }
                $alasan = $row->alasan;
                $status_cuti = $row->status_cuti;
                $querystatuscuti=$this->db->query("SELECT * FROM t_status_pengajuan WHERE id_status_pengajuan = $status_cuti")->result();
                foreach ($querystatuscuti as $rowstatuscuti) {
                    $status_pengajuan_cuti = $rowstatuscuti->status_pengajuan;
                }
                $bukti = $row->bukti;
                $rowpersetujuan = new stdClass;
                $rowpersetujuan->time = $time;
                $rowpersetujuan->nip = $nip;
                $rowpersetujuan->nama = $nama;
                $rowpersetujuan->tgl_dari = $tgl_dari;
                $rowpersetujuan->tgl_sampai = $tgl_sampai;
                $rowpersetujuan->jenis = 'cuti';
                $rowpersetujuan->jenis_permohonan = $jenis_permohonan;
                $rowpersetujuan->alasan = $alasan;
                $rowpersetujuan->status_cuti = $status_cuti;
                $rowpersetujuan->status_pengajuan_cuti = $status_pengajuan_cuti;
                $rowpersetujuan->bukti = $bukti;
            }
        }elseif ($tabel == 'dl') {
            $query=$this->db->query("SELECT * FROM t_dl WHERE time = '$id'");
            foreach ($query->result() as $row) {
                $time = $row->time;
                $no_spt = $row->no_spt;
                $nip1 = $row->nip1;
                $nip2 = $row->nip2;
                $nip3 = $row->nip3;
                $nip4 = $row->nip4;
                $nip5 = $row->nip5;
                $pegawai = '';
                $pegawaidiperintah = '';
                for ($i=1; $i <6 ; $i++) { 
                    if (${'nip'.$i} != '') {
                        $ceknamapegawai=$this->db->query("SELECT * FROM t_user WHERE nip = ${'nip'.$i}")->result();
                        foreach ($ceknamapegawai as $rowceknamapegawai) {
                            $pegawai .= $rowceknamapegawai->nama."<br>";
                            $pegawaidiperintah .= $rowceknamapegawai->nip." / ".$rowceknamapegawai->nama."<br><br>";
                        }
                    }
                }
                $pegawai = substr($pegawai,0,-4);
                $pegawaidiperintah = substr($pegawaidiperintah,0,-8);
                $tgl_berangkat = $row->tgl_berangkat;
                $tgl_kembali = $row->tgl_kembali;
                $status_dl = $row->status_dl;
                $querystatusdl=$this->db->query("SELECT * FROM t_status_pengajuan WHERE id_status_pengajuan = $status_dl")->result();
                foreach ($querystatusdl as $rowstatusdl) {
                    $status_pengajuan_dl = $rowstatusdl->status_pengajuan;
                }
                $bukti = $row->bukti;
                $rowpersetujuan = new stdClass;
                $rowpersetujuan->time = $row->time;
                $rowpersetujuan->no_spt = $row->no_spt;
                $rowpersetujuan->pegawai = $pegawai;
                $rowpersetujuan->pegawaidiperintah = $pegawaidiperintah;
                $rowpersetujuan->tgl_berangkat = $row->tgl_berangkat;
                $rowpersetujuan->tgl_kembali = $row->tgl_kembali;
                $rowpersetujuan->status_dl = $row->status_dl;
                $rowpersetujuan->status_pengajuan_dl = $status_pengajuan_dl;
                $rowpersetujuan->bukti = $row->bukti;
            }
        }
        return $rowpersetujuan;
    }

    public function getDataPengajuanCuti($nip){
        $no = 0;
        $rowcuti = array();
        $query=$this->db->query("SELECT * FROM t_cuti WHERE nip = $nip AND status_cuti = 1 ORDER BY time ASC");
        foreach ($query->result() as $row) {
            $cekjeniscuti=$this->db->query("SELECT * FROM t_jenis_cuti WHERE id_jenis_cuti = $row->jenis_cuti")->result();
            foreach ($cekjeniscuti as $rowjeniscuti) {
                $kedaluwarsa = $rowjeniscuti->kedaluwarsa;
                $jenis_cuti = $rowjeniscuti->jenis_cuti;
            }
            $tambah_hari = "-".$kedaluwarsa." days";
            $tglkedaluwarsa = date('Y-m-d', strtotime($tambah_hari, strtotime($this->today)));
            if ($row->tgl_dari>=$tglkedaluwarsa) {
                $rowcuti[$no] = new stdClass;
                $rowcuti[$no]->time = $row->time;
                $rowcuti[$no]->tgl_dari = $row->tgl_dari;
                $rowcuti[$no]->tgl_sampai = $row->tgl_sampai;
                $rowcuti[$no]->alasan = $row->alasan;
                $rowcuti[$no]->jenis_cuti = $row->jenis_cuti;
                $no++;
            }
        }
        return $rowcuti;
    }

    public function tambahpengajuan($bukti){
        $status = 1;
        $time = date('Y-m-d H:i:s');
        $nip = $this->input->post('nip');
        $daterange = $this->input->post('daterange');
        $tgl_dari = implode(" ", array_slice(explode(" ", $daterange), 0, 1));
        $tgl_dari = date('Y-m-d', strtotime($tgl_dari));
        $tgl_sampai = implode(" ", array_slice(explode(" ", $daterange), 2, 2));
        $tgl_sampai = date('Y-m-d', strtotime($tgl_sampai));
        $jenis_cuti = $this->input->post('jenis_cuti');
        $alasan = $this->input->post('alasan');
        $query=$this->db->query("insert into t_cuti values('$time', '$nip', '$tgl_dari', '$tgl_sampai', '$jenis_cuti', '$alasan', '$status', '$bukti')");
        if ($query){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function hapus_pengajuan(){
        $get_id = $this->input->post('id');
        $id = date('Y-m-d H:i:s', $get_id);
        $rowbukti = $this->getByField('t_cuti','time',$id);
        $bukti = $rowbukti->bukti;
        $query=$this->db->query("DELETE FROM t_cuti WHERE time = '$id'");
        if ($query){
            unlink('./assets/upload/cuti/'.$bukti);
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    public function updatepengajuan($bukti){
        $time = date('Y-m-d H:i:s');
        $get_time = $this->input->post('get_time');
        $nip = $this->input->post('nip');
        $daterange = $this->input->post('daterange');
        $tgl_dari = implode(" ", array_slice(explode(" ", $daterange), 0, 1));
        $tgl_dari = date('Y-m-d', strtotime($tgl_dari));
        $tgl_sampai = implode(" ", array_slice(explode(" ", $daterange), 2, 2));
        $tgl_sampai = date('Y-m-d', strtotime($tgl_sampai));
        $alasan = $this->input->post('alasan');
        $query=$this->db->query("update t_cuti set time='$time', tgl_dari='$tgl_dari', tgl_sampai='$tgl_sampai', alasan='$alasan' $bukti where time='$get_time'");
        if ($query){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function getDataPengajuanDL($nip){
        $no = 0;
        $rowdl = array();
        $query=$this->db->query("SELECT * FROM t_dl WHERE (status_dl = 1 AND tgl_berangkat>='$this->today') AND (nip1 = $nip OR nip2 = $nip OR nip3 = $nip OR nip4 = $nip OR nip5 = $nip) ORDER BY time ASC");
        foreach ($query->result() as $row) {
            $nip1 = $row->nip1;
            $nip2 = $row->nip2;
            $nip3 = $row->nip3;
            $nip4 = $row->nip4;
            $nip5 = $row->nip5;
            $pegawai = '';
            for ($i=1; $i <6 ; $i++) { 
                if (${'nip'.$i} != '') {
                    $ceknamapegawai=$this->db->query("SELECT * FROM t_user WHERE nip = ${'nip'.$i}")->result();
                    foreach ($ceknamapegawai as $rowceknamapegawai) {
                        $pegawai .= $rowceknamapegawai->nama."<br>";
                    }
                }
            }
            $rowdl[$no] = new stdClass;
            $rowdl[$no]->time = $row->time;
            $rowdl[$no]->no_spt = $row->no_spt;
            $rowdl[$no]->pegawai = $pegawai;
            $rowdl[$no]->tgl_berangkat = $row->tgl_berangkat;
            $rowdl[$no]->tgl_kembali = $row->tgl_kembali;
            $rowdl[$no]->status_dl = $row->status_dl;
            $rowdl[$no]->bukti = $row->bukti;
            $no++;
        }
        return $rowdl;
    }

    public function tambahdl($bukti){
        $status = 1;
        $time = date('Y-m-d H:i:s');
        $spt = $this->input->post('spt');
        if ($spt == '') {
            $spt = 'NULL';
        }else{
            $spt = "'".$spt."'";
        }
        $tgl_berangkat = $this->input->post('tgl_berangkat');
        $tgl_kembali = $this->input->post('tgl_kembali');
        $nip = $this->input->post('nip');
        $numbnip = count($nip);
        if ($numbnip >= 0) {
            $ceknip = '';
            $ceknull = '';
            $ceknumbnip = 0;
            for ($i=0; $i < 5 ; $i++) { 
                if (trim($nip[$i] != '')) {
                    $ceknumbnip += 1;
                    $getnip = $nip[$i];
                    $ceknip .= $getnip ."', '";
                }else{
                    $null = 'NULL';
                    $ceknull .= $null .", ";
                }
            }
            $ceknip = substr($ceknip,0,-4);
            if ($ceknumbnip == 5) {
                $ceknip = "'".$ceknip."'";
            }else {
                $ceknip = "'".$ceknip."',";
            }
            $ceknull = substr($ceknull,0,-2);
        }
        $pegawai = "".$ceknip ."".$ceknull;
        $query=$this->db->query("insert into t_dl values('$time', $spt, $pegawai, '$tgl_berangkat', '$tgl_kembali', '$status', '$bukti')");
        if ($query){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function hapus_dl(){
        $get_id = $this->input->post('id');
        $id = date('Y-m-d H:i:s', $get_id);
        $rowbukti = $this->getByField('t_dl','time',$id);
        $bukti = $rowbukti->bukti;
        $query=$this->db->query("DELETE FROM t_dl WHERE time = '$id'");
        if ($query){
            unlink('./assets/upload/dinasluar/'.$bukti);
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    public function updatedl($bukti){
        $time = date('Y-m-d H:i:s');
        $get_time = $this->input->post('get_time');
        $spt = $this->input->post('spt');
        if ($spt == '') {
            $spt = 'NULL';
        }else{
            $spt = "'".$spt."'";
        }
        $tgl_berangkat = $this->input->post('tgl_berangkat');
        $tgl_kembali = $this->input->post('tgl_kembali');
        $nip = $this->input->post('nip');
        $numbnip = count($nip);
        if ($numbnip >= 0) {
            $ceknip = '';
            $ceknull = '';
            $ceknumbnip = 0;
            for ($i=0; $i < 5 ; $i++) { 
                if (trim($nip[$i] != '')) {
                    $ceknumbnip += 1;
                    $urutannip = 'nip'.$ceknumbnip;
                    $getnip = $nip[$i];
                    $ceknip .= $urutannip ."='". $getnip."',";
                }
            }
            for ($j=5; $j > $ceknumbnip; $j--) { 
                $urutansisa = 'nip'.$j;
                $ceknull .= $urutansisa ."= NULL, ";
            }
            $ceknip = substr($ceknip,0,-2);
            if ($ceknumbnip == 5) {
                $ceknip = $ceknip."'";
            }else {
                $ceknip = $ceknip."',";
            }
            $ceknull = substr($ceknull,0,-2);
        }
        $pegawai = "".$ceknip ."".$ceknull;

        $query=$this->db->query("update t_dl set time='$time', no_spt=$spt, tgl_berangkat='$tgl_berangkat', tgl_kembali='$tgl_kembali', $pegawai $bukti where time='$get_time'");
        if ($query){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    public function t_persetujuan($jenis){
        $time = date('Y-m-d H:i:s');
        $get_time = $this->input->post('time');
        $status = $this->input->post('status');
        if ($jenis == 'cuti') {
            $query=$this->db->query("update t_cuti set status_cuti = '$status', time = '$time' where time = '$get_time'");
        }
        if ($jenis == 'dl') {
            $query=$this->db->query("update t_dl set status_dl = '$status', time = '$time' where time = '$get_time'");
        }
        if ($query){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function histori($hak_akses,$jenis_permohonan,$nip){
        $no = 0;
        $rowpersetujuan = array();
        if ($jenis_permohonan == 'cuti dl' OR $jenis_permohonan == 'cuti') {
            $tampil = 'tidak';
            $querycuti=$this->db->query("SELECT * FROM t_cuti where status_cuti in (2,3) ORDER BY time DESC")->result();
            foreach ($querycuti as $rowcuti) {
                $time = $rowcuti->time;
                $getnip = $rowcuti->nip;
                $tgl_dari = $rowcuti->tgl_dari;
                $tgl_sampai = $rowcuti->tgl_sampai;
                if ($hak_akses == 'admin') {
                    $tampil = 'ya';
                }else{
                    if ($getnip == $nip) {
                        $tampil = 'ya';
                    }
                }
                $cekuser=$this->db->query("SELECT * FROM t_user where nip = $getnip")->result();
                foreach ($cekuser as $rowuser) {
                    $nama = $rowuser->nama;
                }
                $cekjeniscuti=$this->db->query("SELECT * FROM t_jenis_cuti WHERE id_jenis_cuti = $rowcuti->jenis_cuti")->result();
                foreach ($cekjeniscuti as $rowjeniscuti) {
                    $jenis_cuti = $rowjeniscuti->jenis_cuti;
                }
                if ($tampil == 'ya') {
                    $rowpersetujuan[$no] = new stdClass;
                    $rowpersetujuan[$no]->time = $time;
                    $rowpersetujuan[$no]->tabel = 'cuti';
                    $rowpersetujuan[$no]->get_name = $nama;
                    $rowpersetujuan[$no]->tgl_awal = $tgl_dari;
                    $rowpersetujuan[$no]->tgl_akhir = $tgl_sampai;
                    $rowpersetujuan[$no]->jenis_permohonan = $jenis_cuti;
                    $no++;
                }
                $tampil = 'tidak';
            }
        }
        if ($jenis_permohonan == 'cuti dl' OR $jenis_permohonan == 'dl') {
            $tampil = 'tidak';
            $querydl=$this->db->query("SELECT * FROM t_dl where status_dl in (2,3) ORDER BY time DESC")->result();
            foreach ($querydl as $rowdl) {
                $time = $rowdl->time;
                $tgl_berangkat = $rowdl->tgl_berangkat;
                $tgl_kembali = $rowdl->tgl_kembali;
                $nip1 = $rowdl->nip1;
                $nip2 = $rowdl->nip2;
                $nip3 = $rowdl->nip3;
                $nip4 = $rowdl->nip4;
                $nip5 = $rowdl->nip5;
                $getnip = '';
                $pegawai = '';
                for ($i=1; $i <6 ; $i++) { 
                    if (${'nip'.$i} != '') {
                        if ($hak_akses == 'admin') {
                            $tampil = 'ya';
                        }else{
                            if (${'nip'.$i} == $nip) {
                                $tampil = 'ya';
                            }
                        }
                        $ceknamapegawai=$this->db->query("SELECT * FROM t_user WHERE nip = ${'nip'.$i}")->result();
                        foreach ($ceknamapegawai as $rowceknamapegawai) {
                            $getnip .= ${'nip'.$i}."','";
                            $pegawai .= $rowceknamapegawai->nama."<br>";
                        }
                    }
                }
                $getnip = substr($getnip,0,-3);
                if ($tampil == 'ya') {
                    $rowpersetujuan[$no] = new stdClass;
                    $rowpersetujuan[$no]->time = $time;
                    $rowpersetujuan[$no]->tabel = 'dl';
                    $rowpersetujuan[$no]->get_name = $pegawai;
                    $rowpersetujuan[$no]->tgl_awal = $tgl_berangkat;
                    $rowpersetujuan[$no]->tgl_akhir = $tgl_kembali;
                    $rowpersetujuan[$no]->jenis_permohonan = 'Dinas Luar';
                    $no++;
                }
                $tampil = 'tidak';
            }
        }
        return $rowpersetujuan;
    }

}