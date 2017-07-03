<?php
class Conta_model extends CI_Model{

    public function listar(){
        $this->db->select("conta.con_id, empresa.emp_rz_social, tipo_conta.tpc_descricao, conta.con_valor, 
  TO_CHAR(con_data, 'DD/MM/YYYY') AS con_data, CASE WHEN con_status='1' THEN 'PAGO' ELSE 'NÃO PAGO' END as con_status, TO_CHAR(con_data, 'DD/MM/YYYY') AS con_data, CASE WHEN con_fixo='1' THEN 'FIXA' ELSE 'LIVRE' END as con_fixo");
        $this->db->from("conta, tipo_conta, empresa");
        $this->db->where("conta.tpc_id = tipo_conta.tpc_id");
        $this->db->where("conta.emp_id = empresa.emp_id");
        $this->db->order_by("con_status, con_data", "asc");
        $contas = $this->db->get()->result();
        return $contas;
    }

    public function cadastrar($conta){
    	if(!isset($conta))
	      return false;
	    $this->db->insert('conta', $conta);
        return $this->db->insert_id();
    }

    public function getConta($id){
        $this->db->from("conta");
        $this->db->where("con_id", $id);
        $conta = $this->db->get()->row();
        return $conta;
    }

    public function conta_update($where, $data){
        $this->db->update("conta", $data, $where);
        return $this->db->affected_rows();
    }

    public function delete_by_id($id){
        $this->db->where('con_id', $id);
        $this->db->delete('conta');
    }

    public function gerarDespesasFixas(){
        $contas = $this->listaContasFixas();
        foreach($contas as $conta){
            $dtVencimento = $data = date("Y-m-d",strtotime(date("Y-m-d", strtotime($conta->con_data)) . " +1 month"));
            $empresa = $conta->emp_id;
            $categoria = $conta->tpc_id;
            $valor = $conta->con_valor;
            $obs = $conta->con_obs;
            if(!$this->verificaContaExiste($dtVencimento, $empresa, $categoria, $valor)){
                $conta = array(
                            'emp_id' => $empresa,
                            'tpc_id' => $categoria,
                            'con_valor' => $valor,
                            'con_data' => $dtVencimento,
                            'con_status' => '0',
                            'con_obs' => $obs,
                            'con_fixo' => '1'
                        );
                $this->cadastrar($conta);
            }    
        }    
    }

    public function listaContasFixas(){
        $mes = date("m");
        $ano = date("Y");
        $ultDia=date("t", mktime(0,0,0,$mes,'01',$ano));
        $dateInicio = $ano.'-' . $mes ."-01";
        $dateFim = $ano.'-' . $mes.'-' .$ultDia;
        $between = "con_data BETWEEN '$dateInicio' AND '$dateFim'";

        $this->db->from("conta");
        $this->db->where("con_fixo", '1');
        $this->db->where($between);
        $this->db->order_by("con_id", "asc");
        $contas = $this->db->get()->result();
        return $contas;
    }

    public function verificaContaExiste($dtVencimento, $empresa, $categoria, $valor){
        $this->db->from("conta");
        $this->db->where("emp_id", $empresa);
        $this->db->where("con_data", $dtVencimento);
        $this->db->where("tpc_id", $categoria);
        $this->db->where("con_valor", $valor);
        $this->db->where("con_fixo", '1');
       return $this->db->get()->row();

    }
   
}