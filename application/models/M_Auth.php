<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Auth extends CI_Model
{    
	function auth_user($nip,$pass){
        $query=$this->db->query("SELECT * FROM t_user WHERE nip='$nip' AND pass=MD5('$pass') LIMIT 1");
        return $query;
    }
    
    public function getByField($table,$field,$value){
        $query=$this->db->query("SELECT * FROM $table WHERE $field='$value'");
        return $query->row();
    }
}