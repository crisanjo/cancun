<?php
class Apto_model extends CI_Model{

    public function listar(){
        $this->db->select("apto.*, users.first_name");
        $this->db->from("apto, users");
        $this->db->where("apto.usu_id = users.id");
        $aptos = $this->db->get()->row_array();
        return $aptos;
    }

    public function cadastrar($apto){
    	if(!isset($apto))
	      return false;
	    return $this->db->insert('apto', $apto);
    }

    public function getApto($id){
        $this->db->from("apto");
        $this->db->where("apto.apt_id", $id);
        $apto = $this->db->get()->row();
        return $apto;
    }

    
   
}