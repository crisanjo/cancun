<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TaxaGrupo extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->model("taxagrupo_model");
	}
	public function index(){
		//$this->template->load('orion/template', 'orion/index.html');
		$data['taxas']=$this->taxagrupo_model->listar();
		$this->load->view('taxagrupo/index',$data);
	}
	
	public function cadastrar() {
       $taxa = array(
				'tgo_descricao' => $this->input->post('tgo_descricao'),
				'tgo_data' => $this->input->post('tgo_data')
				);
		$insert = $this->taxagrupo_model->cadastrar($taxa);
		echo json_encode(array("status" => TRUE));
    }  
    public function ajax_edit($id){
		$data = $this->taxagrupo_model->getTaxaGrupo($id);
		echo json_encode($data);
	}
	public function taxagrupo_update(){
		$data = array(
				'tgo_descricao' => $this->input->post('tgo_descricao'),
				'tgo_data' => $this->input->post('tgo_data')
			);
		$this->taxagrupo_model->taxagrupo_update(array('tgo_id' => $this->input->post('tgo_id')), $data);
		echo json_encode(array("status" => TRUE));
	}


	public function taxagrupo_delete($id){
		$this->taxagrupo_model->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}
	public function lista_taxagrupo_json(){
        $data = $this->taxagrupo_model->listar();
        echo json_encode($data);
    }
    
}
