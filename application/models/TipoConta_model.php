<?php
class TipoConta_model extends CI_Model{

    public function listar(){
        $this->db->from("tipo_conta");
        $dados = $this->db->get()->result();
        return $dados;
    }

    public function cadastrar($tipoConta){
    	if(!isset($tipoConta))
	      return false;
	    $this->db->insert('tipo_conta', $tipoConta);
        return $this->db->insert_id();
    }

    public function getTipoConta($id){
        $this->db->from("tipo_conta");
        $this->db->where("tpc_id", $id);
        $tipoConta = $this->db->get()->row();
        return $tipoConta;
    }

    public function tipoConta_update($where, $data){
        $this->db->update("tipo_conta", $data, $where);
        return $this->db->affected_rows();
    }

    public function delete_by_id($id){
        $this->db->where('tpc_id', $id);
        $this->db->delete('tipo_conta');
    }
   
}