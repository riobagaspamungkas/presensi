<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Presensi extends CI_Model
{
	public function __construct(){
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->today = date('Y-m-d');
        $queryceksetting=$this->db->query("SELECT * FROM t_setting")->result();
        foreach ($queryceksetting as $rowsetting){
            $this->ceksettingjammasuk = $rowsetting->absen_datang;
            $this->ceksettingjampulang = $rowsetting->absen_pulang;
        }
    }

    public function CountAbsenOnline(){
        $query=$this->db->query("SELECT * FROM t_absen WHERE tanggal='$this->today'");
        return $query->num_rows();
    }

    public function CekAbsenMasuk($nip,$tgl){
        $query=$this->db->query("SELECT * FROM t_absen WHERE nip = '$nip' && tanggal = '$tgl' LIMIT 1")->result();
        foreach ($query as $rowpresensi) {
            $jam_masuk = $rowpresensi->jam_masuk;
            $jam_pulang = $rowpresensi->jam_pulang;
        }
        if (empty($jam_masuk) AND !empty($jam_pulang)) {
            return FALSE;
        }else{
            return TRUE;
        }
    }

    public function kehadiran($nip,$date){
        $no = 0;
        $tgl = strtotime($date);
        $get_tgl = date('Y-m-d',$tgl);
        $jam_masuk = '';
        $jam_pulang = '';
        $rowkehadiran = array();
        $query1=$this->db->query("SELECT * FROM t_absen WHERE tanggal='$get_tgl'")->result();
        foreach ($query1 as $row1) {
            $keterangan = '';
            $status_absen = '-';
            $nip = $row1->nip;
            $query2=$this->db->query("SELECT * FROM t_user WHERE nip=$nip")->result();
            foreach ($query2 as $row2) {
                $nama = $row2->nama;
            }
            $ceklibur=$this->db->query("SELECT * FROM t_ph WHERE tanggal = '$get_tgl'")->result();
            foreach ($ceklibur as $rowceklibur) {
                $status_absen = $rowceklibur->keterangan;
            }
            $cekcuti=$this->db->query("SELECT * FROM t_cuti WHERE status_cuti=2 AND nip= $nip AND tgl_dari<='$get_tgl' AND tgl_sampai>='$get_tgl'")->result();
            foreach ($cekcuti as $rowcekcuti) {
                $query_jenis_cuti=$this->db->query("SELECT * FROM t_jenis_cuti WHERE id_jenis_cuti = $rowcekcuti->jenis_cuti")->result();
                foreach ($query_jenis_cuti as $row_jenis_cuti) {
                    $status_absen = $row_jenis_cuti->jenis_cuti;
                }
            }
            $cekdl=$this->db->query("SELECT * FROM t_dl WHERE (status_dl=2 AND tgl_berangkat<='$get_tgl' AND tgl_kembali>='$get_tgl') AND (nip1=$nip OR nip2=$nip OR nip3=$nip OR nip4=$nip OR nip5=$nip) ORDER BY time DESC")->result();
            foreach ($cekdl as $rowcekdl) {
                $status_absen = 'Dinas Luar';
            }
            $tandamulai = strtotime($this->ceksettingjammasuk);
            $tandaakhir = strtotime($this->ceksettingjampulang);
            $masuk = strtotime($row1->jam_masuk);
            $pulang = strtotime($row1->jam_pulang);
            $jam_masuk = date('H:i',$masuk);
            $jam_pulang = date('H:i',$pulang);
            if ($masuk == "") {
                $jam_masuk = '';
                $keterangan .= "Belum absen masuk <br>";
            }
            if (strlen($jam_masuk) > 0 and $masuk > $tandamulai) {
                $diff = $masuk-$tandamulai;
                $menit = floor( $diff / 60 );
                $keterangan .= "Terlambat absen masuk ".$menit." menit <br>";
            }
            if ($pulang == "") {
                $jam_pulang = '';
                $keterangan .= "Belum absen pulang <br>";
            }
            if (strlen($jam_pulang) > 0 and $pulang < $tandaakhir) {
                $diff = $tandaakhir-$pulang;
                $menit = floor( $diff / 60 );
                $keterangan .= "Absen pulang terlalu cepat ".$menit." menit <br>";
            }
            $keterangan = substr($keterangan,0,-4);
            if ($status_absen == '-') {
                $status_absen = $keterangan;
            }
            $rowkehadiran[$no] = new stdClass;
            $rowkehadiran[$no]->id_absen = $row1->id_absen;
            $rowkehadiran[$no]->nama = $nama;
            $rowkehadiran[$no]->tanggal = $row1->tanggal;
            $rowkehadiran[$no]->jam_masuk = $jam_masuk;
            $rowkehadiran[$no]->jam_pulang = $jam_pulang;
            $rowkehadiran[$no]->status_absen = $status_absen;
            $rowkehadiran[$no]->lokasi = $row1->lokasi_absen;
            $no++;
        }
        return $rowkehadiran;
    }

    public function detail_kehadiran($id){
        $keterangan = '';
        $status_absen = '-';
        $query=$this->db->query("SELECT * FROM t_absen WHERE id_absen='$id'");
        $nip = $query->row()->nip;
        $tanggal = $query->row()->tanggal;
        $jam_masuk = $query->row()->jam_masuk;
        $jam_pulang = $query->row()->jam_pulang;
        $lokasi_absen = $query->row()->lokasi_absen;
        $query2=$this->db->query("SELECT * FROM t_user WHERE nip='$nip'");
        $nama = $query2->row()->nama;
        $ceklibur=$this->db->query("SELECT * FROM t_ph WHERE tanggal = '$tanggal'")->result();
        foreach ($ceklibur as $rowceklibur) {
            $status_absen = $rowceklibur->keterangan;
        }
        $cekcuti=$this->db->query("SELECT * FROM t_cuti WHERE status_cuti=2 AND nip= $nip AND tgl_dari<='$tanggal' AND tgl_sampai>='$tanggal'")->result();
        foreach ($cekcuti as $rowcekcuti) {
            $query_jenis_cuti=$this->db->query("SELECT * FROM t_jenis_cuti WHERE id_jenis_cuti = $rowcekcuti->jenis_cuti")->result();
            foreach ($query_jenis_cuti as $row_jenis_cuti) {
                $status_absen = $row_jenis_cuti->jenis_cuti;
            }
        }
        $cekdl=$this->db->query("SELECT * FROM t_dl WHERE (status_dl=2 AND tgl_berangkat<='$tanggal' AND tgl_kembali>='$tanggal') AND (nip1=$nip OR nip2=$nip OR nip3=$nip OR nip4=$nip OR nip5=$nip) ORDER BY time DESC")->result();
        foreach ($cekdl as $rowcekdl) {
            $status_absen = 'Dinas Luar';
        }
        $tandamulai = strtotime($this->ceksettingjammasuk);
        $tandamasuk = strtotime($jam_masuk);
        $tandaakhir = strtotime($this->ceksettingjampulang);
        $tandapulang = strtotime($jam_pulang);
        if ($tandamasuk == "") {
            $jam_masuk = '';
            $keterangan .= "Belum absen masuk <br><br>";
        }
        if (strlen($jam_masuk) > 0 and $tandamasuk > $tandamulai) {
            $diff = $tandamasuk-$tandamulai;
            $menit = floor( $diff / 60 );
            $keterangan .= "Terlambat absen masuk ".$menit." menit <br><br>";
        }
        if ($tandapulang == "") {
            $jam_pulang = '';
            $keterangan .= "Belum absen pulang <br><br>";
        }
        if (strlen($jam_pulang) > 0 and $tandapulang < $tandaakhir) {
            $diff = $tandaakhir-$tandapulang;
            $menit = floor( $diff / 60 );
            $keterangan .= "Absen pulang terlalu cepat ".$menit." menit <br><br>";
        }
        $keterangan = substr($keterangan,0,-8);
        if ($status_absen == '-') {
            $status_absen = $keterangan;
        }
        $detail = new stdClass;
        $detail->nip = $nip;
        $detail->nama = $nama;
        $detail->tanggal = $tanggal;
        $detail->jam_masuk = $jam_masuk;
        $detail->jam_pulang = $jam_pulang;
        $detail->status_absen = $status_absen;
        $detail->lokasi_absen = $lokasi_absen;
        return $detail;
    }

    public function presensiadmin($tgl_dari, $tgl_sampai, $centang, $where){
        $no = 0;
        $rowpresensi = array();
        $tgl_awal = strtotime($tgl_dari);
        $tgl_akhir = strtotime($tgl_sampai);
        $queryuser=$this->db->query("SELECT * FROM t_user WHERE nip in ($where) ORDER BY nip ASC")->result();
        foreach ($queryuser as $row1) {
            $get_nip = $row1->nip; //ambil get nip untuk nama pegawai
            $get_name = $row1->nama; //ambil get nama untuk nama pegawai
            for ($i=$tgl_awal; $i <= $tgl_akhir; $i += (60 * 60 * 24)) {
                $keterangan = '';
                $ket_excel = '';
                $status_absen = '-';
                $get_tgl = date('Y-m-d',$i);
                $ceklibur=$this->db->query("SELECT * FROM t_ph WHERE tanggal = '$get_tgl'")->result();
                foreach ($ceklibur as $rowceklibur) {
                    $status_absen = $rowceklibur->keterangan;
                }
                $cekcuti=$this->db->query("SELECT * FROM t_cuti WHERE status_cuti=2 AND nip= $get_nip AND tgl_dari<='$get_tgl' AND tgl_sampai>='$get_tgl'")->result();
                foreach ($cekcuti as $rowcekcuti) {
                    $query_jenis_cuti=$this->db->query("SELECT * FROM t_jenis_cuti WHERE id_jenis_cuti = $rowcekcuti->jenis_cuti")->result();
                    foreach ($query_jenis_cuti as $row_jenis_cuti) {
                        $status_absen = $row_jenis_cuti->jenis_cuti;
                    }
                }
                $cekdl=$this->db->query("SELECT * FROM t_dl WHERE (status_dl=2 AND tgl_berangkat<='$get_tgl' AND tgl_kembali>='$get_tgl') AND (nip1=$get_nip OR nip2=$get_nip OR nip3=$get_nip OR nip4=$get_nip OR nip5=$get_nip) ORDER BY time DESC")->result();
                foreach ($cekdl as $rowcekdl) {
                    $status_absen = 'Dinas Luar';
                }
                $keterangan_absen = $status_absen;
                $colorm = '';
                $colorp = '';
                $tampil=$this->db->query("SELECT * FROM t_absen WHERE nip = $get_nip AND tanggal = '$get_tgl' ORDER BY id_absen DESC");
                if($tampil->num_rows() > 0){
                    foreach ($tampil->result() as $row2) {
                        $time_masuk = $row2->jam_masuk;
                        $time_pulang = $row2->jam_pulang;
                        $tandamulai = strtotime($this->ceksettingjammasuk);
                        $tandamasuk = strtotime($time_masuk);
                        $tandaakhir = strtotime($this->ceksettingjampulang);
                        $tandapulang = strtotime($time_pulang);
                        if (strlen($time_masuk) == 0 or $tandamasuk > $tandamulai) {
                            if ($status_absen == '-') {
                                $colorm = '#e65251';
                                if (strlen($time_masuk) == 0) {
                                    $keterangan .= "Belum absen masuk <br>";
                                    $ket_excel .= "Belum absen masuk \n";
                                } else {
                                    $diff = $tandamasuk-$tandamulai;
                                    $menit = floor( $diff / 60 );
                                    $keterangan .= "Terlambat absen masuk ".$menit." menit <br>";
                                    $ket_excel .= "Terlambat absen masuk ".$menit." menit \n";
                                }
                            }
                        }
                        if (strlen($time_pulang) == 0 or $tandapulang < $tandaakhir) {
                            if ($status_absen == '-') {
                                $colorp = '#e65251';
                                if (strlen($time_pulang) == 0) {
                                    $keterangan .= "Belum absen pulang <br>";
                                    $ket_excel .= "Belum absen pulang \n";
                                } else {
                                    $diff = $tandaakhir-$tandapulang;
                                    $menit = floor( $diff / 60 );
                                    $keterangan .= "Absen pulang terlalu cepat ".$menit." menit <br>";
                                    $ket_excel .= "Absen pulang terlalu cepat ".$menit." menit \n";
                                }
                            }
                        }
                        $keterangan = substr($keterangan,0,-4);
                        $ket_excel = substr($ket_excel,0,-2);
                        if (date('w', $i) == '6' OR date('w', $i) == '7') {
                            $colorm = '';
                            $colorp = '';
                        }
                        if ($status_absen == '-') {
                            $status_absen = $keterangan;
                            $keterangan_absen = $ket_excel;
                        }
                        if ($centang == 8) {
                            $dateget = date('Y-m-d',$i);
                            $rowpresensi[$no] = new stdClass;
                            $rowpresensi[$no]->get_name = $get_name;
                            $rowpresensi[$no]->dateget = $dateget;
                            $rowpresensi[$no]->time_masuk = $time_masuk;
                            $rowpresensi[$no]->time_pulang = $time_pulang;
                            $rowpresensi[$no]->status_absen = $status_absen;
                            $rowpresensi[$no]->keterangan_absen = $keterangan_absen;
                            $rowpresensi[$no]->colorm = $colorm;
                            $rowpresensi[$no]->colorp = $colorp;
                            $no++;
                        }else{
                            if ($colorm == '#e65251' OR $colorp == '#e65251') {
                                $dateget = date('Y-m-d',$i);
                                $rowpresensi[$no] = new stdClass;
                                $rowpresensi[$no]->get_name = $get_name;
                                $rowpresensi[$no]->dateget = $dateget;
                                $rowpresensi[$no]->time_masuk = $time_masuk;
                                $rowpresensi[$no]->time_pulang = $time_pulang;
                                $rowpresensi[$no]->status_absen = $status_absen;
                                $rowpresensi[$no]->keterangan_absen = $keterangan_absen;
                                $rowpresensi[$no]->colorm = $colorm;
                                $rowpresensi[$no]->colorp = $colorp;
                                $no++;
                            }
                        }
                    }
                }else{
                    if ($status_absen == '-') {
                        $colorm = '#e65251';
                        $colorp = '#e65251';
                        $status_absen = "Belum absen masuk <br>Belum absen pulang";
                        $keterangan_absen = "Belum absen masuk\nBelum absen pulang";
                    }
                    if (date('w', $i) == '1' OR date('w', $i) == '2' OR date('w', $i) == '3' OR date('w', $i) == '4' OR date('w', $i) == '5') {
                        if ($centang == 8) {
                            $dateget = date('Y-m-d',$i);
                            $rowpresensi[$no] = new stdClass;
                            $rowpresensi[$no]->get_name = $get_name;
                            $rowpresensi[$no]->dateget = $dateget;
                            $rowpresensi[$no]->time_masuk = '';
                            $rowpresensi[$no]->time_pulang = '';
                            $rowpresensi[$no]->status_absen = $status_absen;
                            $rowpresensi[$no]->keterangan_absen = $keterangan_absen;
                            $rowpresensi[$no]->colorm = $colorm;
                            $rowpresensi[$no]->colorp = $colorp;
                            $no++;
                        }else{
                            if ($colorm == '#e65251' OR $colorp == '#e65251') {
                                $dateget = date('Y-m-d',$i);
                                $rowpresensi[$no] = new stdClass;
                                $rowpresensi[$no]->get_name = $get_name;
                                $rowpresensi[$no]->dateget = $dateget;
                                $rowpresensi[$no]->time_masuk = '';
                                $rowpresensi[$no]->time_pulang = '';
                                $rowpresensi[$no]->status_absen = $status_absen;
                                $rowpresensi[$no]->keterangan_absen = $keterangan_absen;
                                $rowpresensi[$no]->colorm = $colorm;
                                $rowpresensi[$no]->colorp = $colorp;
                                $no++;
                            }
                        }
                    }
                }
            }
        }
        return $rowpresensi;
    }

    public function presensipegawai($tgl_dari, $tgl_sampai, $centang, $nip){
        $no = 0;
        $rowpresensi = array();
        $strtgl_akhir = date('Y-m-d');
        $strtgl_awal = date('Y-m-d', strtotime('-1 weeks', strtotime($strtgl_akhir)));
        $tgl_awal = strtotime($tgl_dari);
        $tgl_akhir = strtotime($tgl_sampai);
        if ($tgl_awal=='') {
            $tgl_awal = strtotime($strtgl_awal);
            $tgl_akhir = strtotime($strtgl_akhir);
        }
        $queryuser=$this->db->query("SELECT * FROM t_user WHERE nip='$nip'")->result();
        foreach ($queryuser as $row1) {
            $get_nip = $row1->nip; //ambil get nip untuk nama pegawai
            $get_name = $row1->nama; //ambil get nama untuk nama pegawai
            for ($i=$tgl_akhir; $i >= $tgl_awal; $i -= (60 * 60 * 24)) {
                $keterangan = '';
                $ket_pdf = '';
                $status_absen = '-';
                $get_tgl = date('Y-m-d',$i);
                $ceklibur=$this->db->query("SELECT * FROM t_ph WHERE tanggal = '$get_tgl'")->result();
                foreach ($ceklibur as $rowceklibur) {
                    $status_absen = $rowceklibur->keterangan;
                }
                $cekcuti=$this->db->query("SELECT * FROM t_cuti WHERE status_cuti=2 AND nip= $get_nip AND tgl_dari<='$get_tgl' AND tgl_sampai>='$get_tgl'")->result();
                foreach ($cekcuti as $rowcekcuti) {
                    $query_jenis_cuti=$this->db->query("SELECT * FROM t_jenis_cuti WHERE id_jenis_cuti = $rowcekcuti->jenis_cuti")->result();
                    foreach ($query_jenis_cuti as $row_jenis_cuti) {
                        $status_absen = $row_jenis_cuti->jenis_cuti;
                    }
                }
                $cekdl=$this->db->query("SELECT * FROM t_dl WHERE (status_dl=2 AND tgl_berangkat<='$get_tgl' AND tgl_kembali>='$get_tgl') AND (nip1=$get_nip OR nip2=$get_nip OR nip3=$get_nip OR nip4=$get_nip OR nip5=$get_nip) ORDER BY time DESC")->result();
                foreach ($cekdl as $rowcekdl) {
                    $status_absen = 'Dinas Luar';
                }
                $keterangan_absen = $status_absen;
                $colorm = '';
                $colorp = '';
                $pdfcolorm = '';
                $pdfcolorp = '';
                $tampil=$this->db->query("SELECT * FROM t_absen WHERE nip = $get_nip AND tanggal = '$get_tgl' ORDER BY id_absen DESC");
                if($tampil->num_rows() > 0){
                    foreach ($tampil->result() as $row2) {
                        $id_absen = $row2->id_absen;
                        $time_masuk = $row2->jam_masuk;
                        $time_pulang = $row2->jam_pulang;
                        $tandamulai = strtotime($this->ceksettingjammasuk);
                        $tandamasuk = strtotime($time_masuk);
                        $tandaakhir = strtotime($this->ceksettingjampulang);
                        $tandapulang = strtotime($time_pulang);
                        if (strlen($time_masuk) == 0 or $tandamasuk > $tandamulai) {
                            if ($status_absen == '-') {
                                $colorm = '#e65251';
                                $pdfcolorm = 'true';
                                if (strlen($time_masuk) == 0) {
                                    $keterangan .= "Belum absen masuk <br>";
                                    $ket_pdf .= "Belum absen masuk \n";
                                } else {
                                    $diff = $tandamasuk-$tandamulai;
                                    $menit = floor( $diff / 60 );
                                    $keterangan .= "Terlambat absen masuk ".$menit." menit <br>";
                                    $ket_pdf .= "Terlambat absen masuk ".$menit." menit \n";
                                }
                            }
                        }
                        if (strlen($time_pulang) == 0 or $tandapulang < $tandaakhir) {
                            if ($status_absen == '-') {
                                $colorp = '#e65251';
                                $pdfcolorp = 'true';
                                if (strlen($time_pulang) == 0) {
                                    $keterangan .= "Belum absen pulang <br>";
                                    $ket_pdf .= "Belum absen pulang \n";
                                } else {
                                    $diff = $tandaakhir-$tandapulang;
                                    $menit = floor( $diff / 60 );
                                    $keterangan .= "Absen pulang terlalu cepat ".$menit." menit <br>";
                                    $ket_pdf .= "Absen pulang terlalu cepat ".$menit." menit \n";
                                }
                            }
                        }
                        $keterangan = substr($keterangan,0,-4);
                        $ket_pdf = substr($ket_pdf,0,-2);
                        if (date('w', $i) == '6' OR date('w', $i) == '7') {
                            $colorm = '';
                            $colorp = '';
                            $pdfcolorm = '';
                            $pdfcolorp = '';
                        }
                        if ($status_absen == '-') {
                            $status_absen = $keterangan;
                            $keterangan_absen = $ket_pdf;
                        }
                        if ($centang == 8) {
                            $dateget = date('Y-m-d',$i);
                            $rowpresensi[$no] = new stdClass;
                            $rowpresensi[$no]->id_absen = $id_absen;
                            $rowpresensi[$no]->get_name = $get_name;
                            $rowpresensi[$no]->dateget = $dateget;
                            $rowpresensi[$no]->time_masuk = $time_masuk;
                            $rowpresensi[$no]->time_pulang = $time_pulang;
                            $rowpresensi[$no]->keterangan_absen = $keterangan_absen;
                            $rowpresensi[$no]->status_absen = $status_absen;
                            $rowpresensi[$no]->colorm = $colorm;
                            $rowpresensi[$no]->colorp = $colorp;
                            $rowpresensi[$no]->pdfcolorm = $pdfcolorm;
                            $rowpresensi[$no]->pdfcolorp = $pdfcolorp;
                            $no++;
                        }else{
                            if ($colorm == '#e65251' OR $colorp == '#e65251') {
                                $dateget = date('Y-m-d',$i);
                                $rowpresensi[$no] = new stdClass;
                                $rowpresensi[$no]->id_absen = $id_absen;
                                $rowpresensi[$no]->get_name = $get_name;
                                $rowpresensi[$no]->dateget = $dateget;
                                $rowpresensi[$no]->time_masuk = $time_masuk;
                                $rowpresensi[$no]->time_pulang = $time_pulang;
                                $rowpresensi[$no]->keterangan_absen = $keterangan_absen;
                                $rowpresensi[$no]->status_absen = $status_absen;
                                $rowpresensi[$no]->colorm = $colorm;
                                $rowpresensi[$no]->colorp = $colorp;
                                $rowpresensi[$no]->pdfcolorm = $pdfcolorm;
                                $rowpresensi[$no]->pdfcolorp = $pdfcolorp;
                                $no++;
                            }
                        }
                    }
                }else{
                    if ($status_absen == '-') {
                        $colorm = '#e65251';
                        $colorp = '#e65251';
                        $pdfcolorm = 'true';
                        $pdfcolorp = 'true';
                        $status_absen = "Belum absen masuk <br>Belum absen pulang";
                        $keterangan_absen = "Belum absen masuk\nBelum absen pulang";
                    }
                    if (date('w', $i) == '1' OR date('w', $i) == '2' OR date('w', $i) == '3' OR date('w', $i) == '4' OR date('w', $i) == '5') {
                        if ($centang == 8) {
                            $dateget = date('Y-m-d',$i);
                            $rowpresensi[$no] = new stdClass;
                            $rowpresensi[$no]->get_name = $get_name;
                            $rowpresensi[$no]->dateget = $dateget;
                            $rowpresensi[$no]->time_masuk = '';
                            $rowpresensi[$no]->time_pulang = '';
                            $rowpresensi[$no]->keterangan_absen = $keterangan_absen;
                            $rowpresensi[$no]->status_absen = $status_absen;
                            $rowpresensi[$no]->colorm = $colorm;
                            $rowpresensi[$no]->colorp = $colorp;
                            $rowpresensi[$no]->pdfcolorm = $pdfcolorm;
                            $rowpresensi[$no]->pdfcolorp = $pdfcolorp;
                            $no++;
                        }else{
                            if ($colorm == '#e65251' OR $colorp == '#e65251') {
                                $dateget = date('Y-m-d',$i);
                                $rowpresensi[$no] = new stdClass;
                                $rowpresensi[$no]->get_name = $get_name;
                                $rowpresensi[$no]->dateget = $dateget;
                                $rowpresensi[$no]->time_masuk = '';
                                $rowpresensi[$no]->time_pulang = '';
                                $rowpresensi[$no]->keterangan_absen = $keterangan_absen;
                                $rowpresensi[$no]->status_absen = $status_absen;
                                $rowpresensi[$no]->colorm = $colorm;
                                $rowpresensi[$no]->colorp = $colorp;
                                $rowpresensi[$no]->pdfcolorm = $pdfcolorm;
                                $rowpresensi[$no]->pdfcolorp = $pdfcolorp;
                                $no++;
                            }
                        }
                    }
                }
            }
        }
        return $rowpresensi;
    }

    public function getpresensionline(){
        $no = 0;
        $rowrekampresensi = array();
        $query=$this->db->query("SELECT * FROM t_absen WHERE tanggal='$this->today' ORDER BY id_absen DESC")->result();
        foreach ($query as $rowabsen) {
            $keterangan = '';
            $id_absen = $rowabsen->id_absen;
            $queryuser = $this->db->query("SELECT * FROM t_user WHERE nip = '$rowabsen->nip' LIMIT 1")->result();
            foreach ($queryuser as $rowuser) {
                $nama_pegawai = $rowuser->nama;
            }
            $tandamulai = strtotime($this->ceksettingjammasuk);
            $tandaakhir = strtotime($this->ceksettingjampulang);
            $masuk = strtotime($rowabsen->jam_masuk);
            $pulang = strtotime($rowabsen->jam_pulang);
            $jam_masuk = date('H:i',$masuk);
            $jam_pulang = date('H:i',$pulang);
            if ($masuk == "") {
                $jam_masuk = '';
                $keterangan .= "Belum absen masuk <br>";
            }
            if (strlen($jam_masuk) > 0 and $masuk > $tandamulai) {
                $diff = $masuk-$tandamulai;
                $menit = floor( $diff / 60 );
                $keterangan .= "Terlambat absen masuk ".$menit." menit <br>";
            }
            if ($pulang == "") {
                $jam_pulang = '';
                $keterangan .= "Belum absen pulang <br>";
            }
            if (strlen($jam_pulang) > 0 and $pulang < $tandaakhir) {
                $diff = $tandaakhir-$pulang;
                $menit = floor( $diff / 60 );
                $keterangan .= "Absen pulang terlalu cepat ".$menit." menit <br>";
            }
            $keterangan = substr($keterangan,0,-4);
            $rowrekampresensi[$no] = new stdClass;
            $rowrekampresensi[$no]->id_absen = $id_absen;
            $rowrekampresensi[$no]->nama_pegawai = $nama_pegawai;
            $rowrekampresensi[$no]->tanggal = $this->today;
            $rowrekampresensi[$no]->jam_masuk = $jam_masuk;
            $rowrekampresensi[$no]->jam_pulang = $jam_pulang;
            $rowrekampresensi[$no]->status_absen = $keterangan;
            $no++;
        }
        return $rowrekampresensi;
    }

    public function rekamonline($nip,$tgl,$ket){
        $getid = '';
        $dopresensi = '';
        $clocknow = date("H:i:s");
        $query=$this->db->query("SELECT * FROM t_absen WHERE nip = '$nip' && tanggal = '$tgl' LIMIT 1")->result();
        foreach ($query as $rowpresensi) {
            $getid = $rowpresensi->id_absen;
        }
        if ($getid != ''){ 
            $cekpresensi=$this->db->query("SELECT * FROM t_absen WHERE id_absen = '$getid' LIMIT 1")->result();
            foreach ($cekpresensi as $cekpresen) {
                $gettimemasuk = $cekpresen->jam_masuk;
                $gettimepulang = $cekpresen->jam_pulang;
            }
            if ($ket == 'masuk') {
                if (empty($gettimemasuk) AND !empty($gettimepulang)) {
                    $clocknow = $gettimepulang;
                }elseif ($clocknow>$gettimemasuk) {
                    $clocknow = $gettimemasuk;
                }
                $dopresensi = "UPDATE t_absen SET jam_masuk = '$clocknow' WHERE id_absen = '$getid'";
            }elseif ($ket == 'pulang') {
                if ($clocknow<$gettimepulang) {
                    $clocknow = $gettimepulang;
                }
                $dopresensi = "UPDATE t_absen SET jam_pulang = '$clocknow' WHERE id_absen = '$getid'";
            }
        }else{
            if ($ket == 'masuk') {
                $dopresensi = "INSERT INTO t_absen(nip,tanggal,jam_masuk,lokasi_absen) VALUES('$nip','$tgl','$clocknow','No Location')";
            }elseif ($ket == 'pulang') {
                $dopresensi = "INSERT INTO t_absen(nip,tanggal,jam_pulang,lokasi_absen) VALUES('$nip','$tgl','$clocknow','No Location')";
            }
        }
        $query=$this->db->query($dopresensi);
        if ($query){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function inputmaps($ket,$nip){
        $maps = '';
        if ($this->input->post('maps_absen')) {
            $maps = $this->input->post('maps_absen');
        }
        $getid = '';
        $dopresensi = '';
        $clocknow = date("H:i:s");
        $querycekabsen=$this->db->query("SELECT * FROM t_absen WHERE nip = '$nip' && tanggal = '$this->today' LIMIT 1")->result();
        foreach ($querycekabsen as $rowabsen) {
            $getid = $rowabsen->id_absen;
            $gettimemasuk = $rowabsen->jam_masuk;
            $gettimepulang = $rowabsen->jam_pulang;
        }
        if (!empty($getid)){ 
            if ($ket == 'datang') {
                if (empty($gettimemasuk) AND !empty($gettimepulang)) {
                    $clocknow = $gettimepulang;
                }elseif ($clocknow>$gettimemasuk) {
                    $clocknow = $gettimemasuk;
                }
                $dopresensi = "UPDATE t_absen SET jam_masuk = '$clocknow' WHERE id_absen = '$getid'";
            }elseif ($ket == 'pulang') {
                if ($clocknow<$gettimepulang) {
                    $clocknow = $gettimepulang;
                }
                $dopresensi = "UPDATE t_absen SET jam_pulang = '$clocknow' WHERE id_absen = '$getid'";
            }
        }else{
            if ($ket == 'datang') {
                $dopresensi = "INSERT INTO t_absen(nip,jam_masuk,tanggal,lokasi_absen) VALUES('$nip','$clocknow','$this->today','$maps')";
            }elseif ($ket == 'pulang') {
                $dopresensi = "INSERT INTO t_absen(nip,jam_pulang,tanggal,lokasi_absen) VALUES('$nip','$clocknow','$this->today','$maps')";
            }
        }
        $query=$this->db->query($dopresensi);
        if ($query){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function hapus_row_presensi(){
        $id=$this->input->post('id');
        $query=$this->db->query("DELETE FROM t_absen WHERE id_absen = '$id'");
        if ($query){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function cetak($bulan,$tahun){
        $x = 0;
        $filter = '01-'.$bulan.'-'.$tahun;
        $tgl_dari = date('Y-m-01', strtotime($filter));
        $tgl_sampai = date('Y-m-t', strtotime($filter));
        $tgl_awal = strtotime($tgl_dari);
        $tgl_akhir = strtotime($tgl_sampai);
        $rowlaporan = array();
        $query=$this->db->query("SELECT * FROM t_user WHERE akses!='admin' ORDER BY nip DESC")->result();
        foreach ($query as $rowabsen) {
            $y = 0;
            $get_nip = $rowabsen->nip;
            $get_name = $rowabsen->nama;
            $rowlaporan[$x] = array();
            for ($i=$tgl_awal; $i <= $tgl_akhir; $i += (60 * 60 * 24)) {
                $keterangan = '';
                $time_masuk = '';
                $time_pulang = '';
                $status_absen = '-';
                $get_tgl = date('Y-m-d',$i);
                $ceklibur=$this->db->query("SELECT * FROM t_ph WHERE tanggal = '$get_tgl'")->result();
                foreach ($ceklibur as $rowceklibur) {
                    $status_absen = $rowceklibur->keterangan;
                }
                $cekcuti=$this->db->query("SELECT * FROM t_cuti WHERE status_cuti=2 AND nip= $get_nip AND tgl_dari<='$get_tgl' AND tgl_sampai>='$get_tgl'")->result();
                foreach ($cekcuti as $rowcekcuti) {
                    $query_jenis_cuti=$this->db->query("SELECT * FROM t_jenis_cuti WHERE id_jenis_cuti = $rowcekcuti->jenis_cuti")->result();
                    foreach ($query_jenis_cuti as $row_jenis_cuti) {
                        $status_absen = $row_jenis_cuti->jenis_cuti;
                    }
                }
                $cekdl=$this->db->query("SELECT * FROM t_dl WHERE (status_dl=2 AND tgl_berangkat<='$get_tgl' AND tgl_kembali>='$get_tgl') AND (nip1=$get_nip OR nip2=$get_nip OR nip3=$get_nip OR nip4=$get_nip OR nip5=$get_nip) ORDER BY time DESC")->result();
                foreach ($cekdl as $rowcekdl) {
                    $status_absen = 'Dinas Luar';
                }
                $rowabsen=$this->db->query("SELECT * FROM t_absen WHERE nip = $get_nip AND tanggal = '$get_tgl' ORDER BY id_absen DESC");
                $colorm = '';
                $colorp = '';
                if($rowabsen->num_rows() > 0){
                    foreach ($rowabsen->result() as $rowabs) {
                        if (!empty($rowabs->jam_masuk)){
                            if ($time_masuk>=$rowabs->jam_masuk OR $time_masuk == 0) {
                                $time_masuk = $rowabs->jam_masuk;
                            }
                        }
                        if ($time_pulang<=$rowabs->jam_pulang) {
                            $time_pulang = $rowabs->jam_pulang;
                        }
                        $tandamulai = strtotime($this->ceksettingjammasuk);
                        $tandamasuk = strtotime($time_masuk);
                        $tandaakhir = strtotime($this->ceksettingjampulang);
                        $tandapulang = strtotime($time_pulang);
                        if (strlen($time_masuk) == 0 or $tandamasuk > $tandamulai) {
                            if ($status_absen == '-') {
                                $colorm = 'true';
                                if (strlen($time_masuk) == 0) {
                                    $keterangan .= "Belum absen masuk \n";
                                } else {
                                    $diff = $tandamasuk-$tandamulai;
                                    $menit = floor( $diff / 60 );
                                    $keterangan .= "Terlambat absen masuk ".$menit." menit \n";
                                }
                            }
                        }
                        if (strlen($time_pulang) == 0 or $tandapulang < $tandaakhir) {
                            if ($status_absen == '-') {
                                $colorp = 'true';
                                if (strlen($time_pulang) == 0) {
                                    $keterangan .= "Belum absen pulang \n";
                                } else {
                                    $diff = $tandaakhir-$tandapulang;
                                    $menit = floor( $diff / 60 );
                                    $keterangan .= "Absen pulang terlalu cepat ".$menit." menit \n";
                                }
                            }
                        }
                        $keterangan = substr($keterangan,0,-2);
                        if (date('w', $i) == '6' OR date('w', $i) == '7') {
                            $colorm = '';
                            $colorp = '';
                        }
                        if ($status_absen == '-') {
                            $status_absen = $keterangan;
                        }
                        $rowlaporan[$x][$y] = new stdClass;
                        $rowlaporan[$x][$y]->nip = $get_nip;
                        $rowlaporan[$x][$y]->nama = $get_name;
                        $rowlaporan[$x][$y]->dateget = $get_tgl;
                        $rowlaporan[$x][$y]->time_masuk = $time_masuk;
                        $rowlaporan[$x][$y]->time_pulang = $time_pulang;
                        $rowlaporan[$x][$y]->status_absen = $status_absen;
                        $rowlaporan[$x][$y]->colorm = $colorm;
                        $rowlaporan[$x][$y]->colorp = $colorp;
                        $y++;
                        $rowlaporan[$x][0]->jumlahrow = $y;
                    }
                }else{
                    $colorm = '';
                    $colorp = '';
                    if (date('w', $i) == '1' OR date('w', $i) == '2' OR date('w', $i) == '3' OR date('w', $i) == '4' OR date('w', $i) == '5') {
                        if ($status_absen == '-') {
                            $colorm = 'true';
                            $colorp = 'true';
                            $status_absen = "Belum absen masuk \nBelum absen pulang";
                        }
                        $rowlaporan[$x][$y] = new stdClass;
                        $rowlaporan[$x][$y]->nip = $get_nip;
                        $rowlaporan[$x][$y]->nama = $get_name;
                        $rowlaporan[$x][$y]->dateget = $get_tgl;
                        $rowlaporan[$x][$y]->time_masuk = $time_masuk;
                        $rowlaporan[$x][$y]->time_pulang = $time_pulang;
                        $rowlaporan[$x][$y]->status_absen = $status_absen;
                        $rowlaporan[$x][$y]->colorm = $colorm;
                        $rowlaporan[$x][$y]->colorp = $colorp;
                        $y++;
                        $rowlaporan[$x][0]->jumlahrow = $y;
                    }
                }
            }
            $x++;
        }
        return $rowlaporan;
    }
}