<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Conta extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->model("conta_model");
	}
	public function index(){
		//$this->template->load('orion/template', 'orion/index.html');
		$data['contas']=$this->conta_model->listar();
		$this->load->view('conta/index',$data);
	}
	
	public function cadastrar() {
       $conta = array(
					'emp_id' => $this->input->post('emp_id'),
					'tpc_id' => $this->input->post('tpc_id'),
					'con_valor' => $this->input->post('con_valor'),
					'con_data' => $this->input->post('con_data'),
					'con_status' => $this->input->post('con_status'),
					'con_obs' => $this->input->post('con_obs'),
					'con_fixo' => $this->input->post('con_fixo')
				);
		$insert = $this->conta_model->cadastrar($conta);
		echo json_encode(array("status" => TRUE));
    }  
    public function ajax_edit($id){
		$data = $this->conta_model->getConta($id);
		echo json_encode($data);
	}
	public function conta_update(){
		$conta = array(
					'emp_id' => $this->input->post('emp_id'),
					'tpc_id' => $this->input->post('tpc_id'),
					'con_valor' => $this->input->post('con_valor'),
					'con_data' => $this->input->post('con_data'),
					'con_status' => $this->input->post('con_status'),
					'con_obs' => $this->input->post('con_obs'),
					'con_fixo' => $this->input->post('con_fixo')
				);
		$this->conta_model->conta_update(array('con_id' => $this->input->post('con_id')), $conta);
		echo json_encode(array("status" => TRUE));
	}


	public function conta_delete($id){
		$this->conta_model->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	public function gerar_contas_fixas(){
		$insert = $this->conta_model->gerarDespesasFixas();
		echo json_encode(array("status" => TRUE));
		$this->session->set_flashdata('mensagem',"Contas geradas com Sucesso");

	}
    
}
