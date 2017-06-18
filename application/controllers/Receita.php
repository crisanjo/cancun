<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Receita extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->model("receita_model");
	}
	public function index(){
		//$this->template->load('tenplate/template', 'receita/index.php'');
		$data['receitas']=$this->receita_model->listar();
		$this->load->view('receita/index',$data);
	}
	
	public function cadastrar() {
		$rec_data_vencimento = $this->input->post('rec_data_vencimento');
		$tgo_id = $this->input->post('tgo_id');
			
		$insert = $this->receita_model->cadastrar($rec_data_vencimento, $tgo_id);
		echo json_encode(array("status" => TRUE));
    }  
     public function ajax_pagamento($id){
	 	$data = array('rec_status' => '1');
		$this->receita_model->pagamento(array('rec_id' => $id), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function receita_delete($id){
	 	$this->receita_model->delete_by_id($id);
	 	echo json_encode(array("status" => TRUE));
	}
    
}
