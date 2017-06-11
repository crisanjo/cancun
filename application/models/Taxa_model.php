<?php
class Taxa_model extends CI_Model{

    public function listar(){
        $this->db->select("txc_id, txc_descricao, txc_valor, CASE WHEN txc_qtd=-1 THEN 'FIXO' ELSE txc_qtd ||'' END as txc_qtd, CASE WHEN txc_status=true THEN 'ATIVO' ELSE 'INATIVO' END as txc_status, CASE WHEN txc_antecipado=true THEN 'SIM' ELSE 'NÃO' END as txc_antecipado, txc_create, txc_update");
        $this->db->from("taxa_condominio");
        $aptos = $this->db->get()->result();
        return $aptos;
    }

    public function cadastrar($taxa){
    	if(!isset($taxa))
	      return false;
	    $this->db->insert('taxa_condominio', $taxa);
        return $this->db->insert_id();
    }

    public function getTaxa($id){
        $this->db->select("txc_id, txc_descricao, txc_valor, txc_qtd, CASE WHEN txc_status=true THEN '1' ELSE '0' END as txc_status, CASE WHEN txc_antecipado=true THEN '1' ELSE '0' END as txc_antecipado, txc_create, txc_update");
        $this->db->from("taxa_condominio");
        $this->db->where("taxa_condominio.txc_id", $id);
        $taxa = $this->db->get()->row();
        return $taxa;
    }

    public function taxa_update($where, $data){
        $this->db->update("taxa_condominio", $data, $where);
        return $this->db->affected_rows();
    }

    public function delete_by_id($id){
        $this->db->where('txc_id', $id);
        $this->db->delete('taxa_condominio');
    }
   
}