<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Kegiatan extends CI_Model
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

    public function cekuser(){
        $nip = '';
        $sqlcek=$this->db->query("SELECT * FROM t_user WHERE akses='kepala' LIMIT 1")->result();
        foreach ($sqlcek as $rowcek) {
            $nip = $rowcek->nip;
        }
        if ($nip == NULL) {
            $sqlcek2=$this->db->query("SELECT * FROM t_user WHERE akses='pegawai' ORDER BY nip ASC LIMIT 1")->result();
            foreach ($sqlcek2 as $rowcek2) {
                $nip = $rowcek2->nip;
            }
        }
        return $nip;
    }

    public function data_carousel(){
        $x = 0;
        $rowdatacarousel = array();
        $sqlrowpegawai=$this->db->query("SELECT * FROM t_user WHERE akses!='admin' ORDER BY nip ASC")->result();
        foreach ($sqlrowpegawai as $row) {
            $y = 0;
            $jam_dari = '';
            $jam_sampai = '';
            $id_kegiatan = '';
            $deskripsi = '';
            $rowdatacarousel[$x] = array();
            $get_nip = $row->nip;
            $nama_pegawai = $row->nama;
            $jbtn = $row->jbtn;
            $gambar = $row->gambar;
            $sqljabatan=$this->db->query("SELECT * FROM t_jabatan WHERE id_jbtn = $jbtn")->result();
            foreach ($sqljabatan as $rowjabatan) {
                $jabatan = $rowjabatan->nama_jbtn;
            }
            $sqlkegiatan=$this->db->query("SELECT * FROM t_kegiatan where nip = $get_nip AND tanggal_kegiatan='$this->today'");
            if ($sqlkegiatan->num_rows()>0) {
                foreach($sqlkegiatan->result() as $rowkegiatan){
                    $id_kegiatan = $rowkegiatan->id_kegiatan;
                    $jam_dari = '';
                    $jam_sampai = '';
                    $id_deskripsi = '';
                    $deskripsi = '';
                    $sqldeskripsi=$this->db->query("SELECT * FROM t_desk_kegiatan where id_kegiatan = $id_kegiatan");
                    foreach($sqldeskripsi->result() as $rowdeskripsi){
                        $jam_dari = $rowdeskripsi->jam_dari;
                        $str_jam_dari = strtotime($jam_dari);
                        $jam_dari = date('H:i',$str_jam_dari);
                        $jam_sampai = $rowdeskripsi->jam_sampai;
                        $str_jam_sampai = strtotime($jam_sampai);
                        $jam_sampai = date('H:i',$str_jam_sampai);
                        $id_deskripsi = $rowdeskripsi->id_deskripsi;
                        $deskripsi = $rowdeskripsi->deskripsi;
                        
                        $rowdatacarousel[$x][$y] = new stdClass;
                        $rowdatacarousel[$x][$y]->get_nip = $get_nip;
                        $rowdatacarousel[$x][$y]->nama_pegawai = $nama_pegawai;
                        $rowdatacarousel[$x][$y]->jabatan = $jabatan;
                        $rowdatacarousel[$x][$y]->gambar = $gambar;
                        $rowdatacarousel[$x][$y]->jam_dari = $jam_dari;
                        $rowdatacarousel[$x][$y]->jam_sampai = $jam_sampai;
                        $rowdatacarousel[$x][$y]->id_kegiatan = $id_kegiatan;
                        $rowdatacarousel[$x][$y]->id_deskripsi = $id_deskripsi;
                        $rowdatacarousel[$x][$y]->deskripsi = $deskripsi;
                        $y++;
                        $rowdatacarousel[$x][0]->jumlahrow = $sqldeskripsi->num_rows();
                    }
                }
            }else{
                $rowdatacarousel[$x][$y] = new stdClass;
                $rowdatacarousel[$x][$y]->get_nip = $get_nip;
                $rowdatacarousel[$x][$y]->nama_pegawai = $nama_pegawai;
                $rowdatacarousel[$x][$y]->jabatan = $jabatan;
                $rowdatacarousel[$x][$y]->gambar = $gambar;
                $rowdatacarousel[$x][$y]->jam_dari = $jam_dari;
                $rowdatacarousel[$x][$y]->jam_sampai = $jam_sampai;
                $rowdatacarousel[$x][$y]->id_kegiatan = $id_kegiatan;
                $rowdatacarousel[$x][$y]->id_deskripsi = '';
                $rowdatacarousel[$x][$y]->deskripsi = $deskripsi;
                $y++;
                $rowdatacarousel[$x][0]->jumlahrow = 0;
            }    
            $x++;
        }
        return $rowdatacarousel;
    }

    public function kegiatan($nip){
        $no = 0;
        $rowkegiatan = array();
        $query1=$this->db->query("SELECT * FROM t_kegiatan WHERE nip=$nip AND tanggal_kegiatan='$this->today'")->result();
        foreach ($query1 as $row1) {
            $getidkegiatan = $row1->id_kegiatan;
            $query2=$this->db->query("SELECT * FROM t_desk_kegiatan WHERE id_kegiatan=$getidkegiatan ORDER BY jam_dari ASC")->result();
            foreach ($query2 as $row2) {
                $title = $row2->title;
                $id_deskripsi = $row2->id_deskripsi;
                $id_kegiatan = $row2->id_kegiatan;
                $dari = strtotime($row2->jam_dari);
                $sampai = strtotime($row2->jam_sampai);
                $jam_dari = date('H:i',$dari);
                $jam_sampai = date('H:i',$sampai);

                $rowkegiatan[$no] = new stdClass;
                $rowkegiatan[$no]->id_deskripsi = $id_deskripsi;
                $rowkegiatan[$no]->id_kegiatan = $id_kegiatan;
                $rowkegiatan[$no]->title = $title;
                $rowkegiatan[$no]->jam_dari = $jam_dari;
                $rowkegiatan[$no]->jam_sampai = $jam_sampai;
                $no++;
            }
        }
        return $rowkegiatan;
    }

    public function data_kegiatan($nip,$date){
        $no = 0;
        $tgl = strtotime($date);
        $get_tgl = date('Y-m-d',$tgl);
        $rowkegiatan = array();
        $query1=$this->db->query("SELECT * FROM t_kegiatan WHERE nip=$nip AND tanggal_kegiatan='$get_tgl'")->result();
        foreach ($query1 as $row1) {
            $getidkegiatan = $row1->id_kegiatan;
            $query2=$this->db->query("SELECT * FROM t_desk_kegiatan WHERE id_kegiatan=$getidkegiatan ORDER BY jam_dari ASC")->result();
            foreach ($query2 as $row2) {
                $title = $row2->title;
                $id_deskripsi = $row2->id_deskripsi;
                $id_kegiatan = $row2->id_kegiatan;
                $dari = strtotime($row2->jam_dari);
                $sampai = strtotime($row2->jam_sampai);
                $jam_dari = date('H:i',$dari);
                $jam_sampai = date('H:i',$sampai);

                $rowkegiatan[$no] = new stdClass;
                $rowkegiatan[$no]->id_deskripsi = $id_deskripsi;
                $rowkegiatan[$no]->id_kegiatan = $id_kegiatan;
                $rowkegiatan[$no]->title = $title;
                $rowkegiatan[$no]->jam_dari = $jam_dari;
                $rowkegiatan[$no]->jam_sampai = $jam_sampai;
                $no++;
            }
        }
        return $rowkegiatan;
    }

    public function tambahkegiatan($lampiran){
        $nip = $this->input->post('nip');
        $tgl = $this->input->post('tgl');
        $judul = $this->input->post('judul');
        $deskripsi = $this->input->post('deskripsi');
        $jam_mulai = $this->input->post('jam_mulai');
        $menit_mulai = $this->input->post('menit_mulai');
        $jam_selesai = $this->input->post('jam_selesai');
        $menit_selesai = $this->input->post('menit_selesai');

        $dari = '';
        $dari .= $jam_mulai .":".$menit_mulai;
        $strdari = strtotime($dari);
        $jam_dari = date("H:i",$strdari);
        $sampai = '';
        $sampai .= $jam_selesai .":".$menit_selesai;
        $strsampai = strtotime($sampai);
        $jam_sampai = date("H:i",$strsampai);

        $getidkegiatan = '';
        $sqlcekkegiatan=$this->db->query("SELECT * FROM t_kegiatan WHERE nip=$nip AND tanggal_kegiatan='$tgl'")->result();
        foreach ($sqlcekkegiatan as $row1) {
            $getidkegiatan = $row1->id_kegiatan;
        }
        if ($getidkegiatan !='') {
            $query=$this->db->query("INSERT INTO t_desk_kegiatan(id_kegiatan, title, deskripsi, jam_dari, jam_sampai, lampiran) VALUES('$getidkegiatan', '$judul', '$deskripsi', '$jam_dari', '$jam_sampai', '$lampiran')");
            if ($query){
                return TRUE;
            }
        } else {
            $query=$this->db->query("INSERT INTO t_kegiatan(nip, tanggal_kegiatan) VALUES('$nip', '$tgl')");
            if ($query){
                $sqlcektgl=$this->db->query("SELECT * FROM t_kegiatan WHERE tanggal_kegiatan='$tgl'")->result();
                foreach ($sqlcektgl as $row2) {
                    $getidkegiatan = $row2->id_kegiatan;
                }
                $query2=$this->db->query("INSERT INTO t_desk_kegiatan(id_kegiatan, title, deskripsi, jam_dari, jam_sampai, lampiran) VALUES('$getidkegiatan', '$judul', '$deskripsi', '$jam_dari', '$jam_sampai', '$lampiran')");
                if ($query2){
                    return TRUE;
                }else {
                    return FALSE;
                }
            } else {
                return FALSE;
            }
        }
    }

    public function updatekegiatan($lampiran){
        $get_id = $this->input->post('get_id');
        $judul = $this->input->post('judul');
        $deskripsi = $this->input->post('deskripsi');
        $jam_mulai = $this->input->post('jam_mulai');
        $menit_mulai = $this->input->post('menit_mulai');
        $jam_selesai = $this->input->post('jam_selesai');
        $menit_selesai = $this->input->post('menit_selesai');

        $dari = '';
        $dari .= $jam_mulai .":".$menit_mulai;
        $strdari = strtotime($dari);
        $jam_dari = date("H:i",$strdari);
        $sampai = '';
        $sampai .= $jam_selesai .":".$menit_selesai;
        $strsampai = strtotime($sampai);
        $jam_sampai = date("H:i",$strsampai);

        $query=$this->db->query("UPDATE t_desk_kegiatan SET title='$judul', deskripsi='$deskripsi', jam_dari='$jam_dari', jam_sampai='$jam_sampai' $lampiran WHERE id_deskripsi='$get_id'");
        if ($query){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function hapus_kegiatan(){
        $id_deskripsi=$this->input->post('id_deskripsi');
        $getidkegiatan ='';
        $row = $this->getByField('t_desk_kegiatan','id_deskripsi',$id_deskripsi);
        $getidkegiatan = $row->id_kegiatan;
        $lampiran = $row->lampiran;
        $query = $this->db->query("SELECT * FROM t_desk_kegiatan WHERE id_kegiatan=$getidkegiatan");
        if ($query->num_rows()>1) {
            $sql = "DELETE FROM t_desk_kegiatan WHERE id_deskripsi=$id_deskripsi";
        }else{
            $sql = "DELETE FROM t_kegiatan WHERE id_kegiatan=$getidkegiatan";
        }
        $queryhapus=$this->db->query($sql);
        if ($queryhapus){
            unlink('./assets/upload/kegiatan/'.$lampiran);
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function modal(){
        $query=$this->db->query("SELECT id_deskripsi FROM t_desk_kegiatan");
        return $query;
    }
}