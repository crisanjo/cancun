<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Taxa extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->model("taxa_model");
	}
	public function index(){
		//$this->template->load('orion/template', 'orion/index.html');
		$data['taxas']=$this->taxa_model->listar();
		$this->load->view('taxa/index',$data);
	}
	
	public function cadastrar() {
       $taxa = array(
					'txc_descricao' => $this->input->post('txc_descricao'),
					'txc_valor' => $this->input->post('txc_valor'),
					'txc_qtd' => $this->input->post('txc_qtd'),
					'txc_status' => $this->input->post('txc_status'),
					'txc_antecipado' => $this->input->post('txc_antecipado')
				);
		$insert = $this->taxa_model->cadastrar($taxa);
		echo json_encode(array("status" => TRUE));
    }  
    public function ajax_edit($id){
		$data = $this->taxa_model->getTaxa($id);
		echo json_encode($data);
	}
	public function taxa_update(){
		$data = array(
				'txc_descricao' => $this->input->post('txc_descricao'),
				'txc_valor' => $this->input->post('txc_valor'),
				'txc_qtd' => $this->input->post('txc_qtd'),
				'txc_status' => $this->input->post('txc_status'),
				'txc_antecipado' => $this->input->post('txc_antecipado')
			);
		$this->taxa_model->taxa_update(array('txc_id' => $this->input->post('txc_id')), $data);
		echo json_encode(array("status" => TRUE));
	}


	public function taxa_delete($id){
		$this->taxa_model->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}
	public function lista_taxa_json(){
        $data = $this->taxa_model->listarExtra();
        echo json_encode($data);
    }
    
}
