<?php
class TaxaGrupo_model extends CI_Model{

    public function listar(){
        $this->db->from("taxa_grupo");
        $dados = $this->db->get()->result();
        return $dados;
    }

    public function cadastrar($taxa){
    	if(!isset($taxa))
	      return false;
	    $this->db->insert('taxa_grupo', $taxa);
        return $this->db->insert_id();
    }

    public function getTaxaGrupo($id){
        $this->db->from("taxa_grupo");
        $this->db->where("tgo_id", $id);
        $taxa = $this->db->get()->row();
        return $taxa;
    }

    public function taxagrupo_update($where, $data){
        $this->db->update("taxa_grupo", $data, $where);
        return $this->db->affected_rows();
    }

    public function delete_by_id($id){
        $this->db->where('tgo_id', $id);
        $this->db->delete('taxa_grupo');
    }
   
}