<?php
class Receita_model extends CI_Model{

    public function listar(){
        $this->db->select("users.first_name, apto.apt_descricao, receita.rec_valor, TO_CHAR(rec_data_vencimento, 'DD/MM/YYYY') AS rec_data_vencimento,  CASE WHEN rec_status='0' THEN 'ABERTO' ELSE 'PAGO' END as rec_status, receita.rec_id, tgo_descricao");
        $this->db->from("receita, users, apto, taxa_grupo");
        $this->db->where("apto.usu_id = users.id");
        $this->db->where("apto.apt_id = receita.apt_id");
        $this->db->where("receita.tgo_id = taxa_grupo.tgo_id");
        $receita = $this->db->get()->result();
        return $receita;
    }

    public function cadastrar($rec_data_vencimento, $tgo_id){
    	if(!isset($rec_data_vencimento))
	      return false;
        $this->load->model("apto_model");
        $this->load->model("taxa_model");
        $id_boleto = null;
        $aptos = $this->apto_model->listar();
        foreach($aptos as $apto){
            $valor = 0.00;
            $contador = 0;
            $receita_id = $this->getReceita($rec_data_vencimento, $tgo_id, $apto->apt_id);
            if(!$receita_id){
                $receita = array('rec_valor' => 0.00, 'apt_id' => $apto->apt_id, 'rec_data_vencimento' => $rec_data_vencimento, 'tgo_id' => $tgo_id);
                $this->db->insert('receita', $receita);
                $id_receita = $this->db->insert_id();
                $taxas = $this->taxa_model->listarPorGrupo($tgo_id);

                foreach ($taxas as $taxa) {
                    $contador = $this->getNumeroParcela($apto->apt_id, $taxa->txc_id);
                    $qtdParc = $taxa->txc_qtd;
                    
                    if($qtdParc == -1 OR $qtdParc > $contador){
                        $valor = $valor+ $taxa->txc_valor;
                        $boleto = array('txc_id' =>$taxa->txc_id, 'rec_id' => $id_receita);
                        $this->db->insert('boleto', $boleto);
                        $id_boleto = $this->db->insert_id();
                    }
                }
                $data = array('rec_valor' => $valor);
                $this->receita_update(array('rec_id' =>$id_receita), $data);
            }    
        }

	    return $id_boleto;
    }

    public function getReceita($rec_data_vencimento, $tgo_id, $apt_id){
        $this->db->from("receita");
        $this->db->where("rec_data_vencimento", $rec_data_vencimento);
        $this->db->where("tgo_id", $tgo_id);
        $this->db->where("apt_id", $apt_id);
        $receita = $this->db->get()->row();
        return $receita;
    }

    public function receita_update($where, $data){
        $this->db->update("receita", $data, $where);
        return $this->db->affected_rows();
    }

    public function delete_by_id($id){
        $this->db->where('rec_id', $id);
        $this->db->delete('receita');
    }

    public function getNumeroParcela($id_apto, $txc_id){
        $this->db->select("boleto.rec_id ");
        $this->db->from("receita, boleto");
        $this->db->where("boleto.rec_id = receita.rec_id");
        $this->db->where("receita.apt_id", $id_apto);
        $this->db->where("boleto.txc_id", $txc_id);
        $boleto = $this->db->get()->result();
        $num = count($boleto) ? count($boleto) : 0;

        return $num;
    }
    public function pagamento($where, $data){
        $this->db->update("receita", $data, $where);
        return $this->db->affected_rows();
    }

    public function cadastrarReceitaExtra($rec_data_vencimento, $txc_id, $apto_id){
        if(!isset($rec_data_vencimento))
          return false;
        $this->load->model("taxa_model");
        $id_boleto = null;
        $valor = 0.00;
        $contador = 0;
        $taxa = $this->taxa_model->getTaxa($txc_id);

        $receita_id = $this->getReceita($rec_data_vencimento, $taxa->tgo_id, $apto_id);
        if(!$receita_id){
            
            $contador = $this->getNumeroParcela($apto_id, $txc_id);
            $qtdParc = $taxa->txc_qtd;
            
            if($qtdParc <> -1 OR $qtdParc > $contador){
                $receita = array('rec_valor' => 0.00, 'apt_id' => $apto_id, 'rec_data_vencimento' => $rec_data_vencimento, 'tgo_id' => $taxa->tgo_id);
                $this->db->insert('receita', $receita);
                $id_receita = $this->db->insert_id();

                $boleto = array('txc_id' =>$taxa->txc_id, 'rec_id' => $id_receita);
                $this->db->insert('boleto', $boleto);
                $id_boleto = $this->db->insert_id();
                $data = array('rec_valor' => $taxa->txc_valor);
                $this->receita_update(array('rec_id' =>$id_receita), $data);
            }   
        }

        return $id_boleto;
    }
   
}