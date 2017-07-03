<?php
class Empresa_model extends CI_Model{

    public function listar(){
        $this->db->from("empresa");
        $dados = $this->db->get()->result();
        return $dados;
    }

    public function cadastrar($empresa){
    	if(!isset($empresa))
	      return false;
	    $this->db->insert('empresa', $empresa);
        return $this->db->insert_id();
    }

    public function getEmpresa($id){
        $this->db->from("empresa");
        $this->db->where("emp_id", $id);
        $empresa = $this->db->get()->row();
        return $empresa;
    }

    public function empresa_update($where, $data){
        $this->db->update("empresa", $data, $where);
        return $this->db->affected_rows();
    }

    public function delete_by_id($id){
        $this->db->where('emp_id', $id);
        $this->db->delete('empresa');
    }
   
}