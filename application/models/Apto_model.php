<?php
class Apto_model extends CI_Model{

    public function listar(){
        $this->db->select("apto.*, users.first_name, CASE WHEN apt_locado='1' THEN 'SIM' ELSE 'NÃO' END as apt_sit");
        $this->db->from("apto, users");
        $this->db->where("apto.usu_id = users.id");
        $aptos = $this->db->get()->result();
        return $aptos;
    }

    public function cadastrar($apto){
    	if(!isset($apto))
	      return false;
	    $this->db->insert('apto', $apto);
        return $this->db->insert_id();
    }

    public function getApto($id){
        $this->db->from("apto");
        $this->db->where("apto.apt_id", $id);
        $apto = $this->db->get()->row();
        return $apto;
    }

    public function apto_update($where, $data){
        $this->db->update("apto", $data, $where);
        return $this->db->affected_rows();
    }

    public function delete_by_id($id){
        $this->db->where('apt_id', $id);
        $this->db->delete('apto');
    }
   
}