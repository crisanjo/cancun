<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TipoConta extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->model("tipoconta_model");
	}
	public function index(){
		//$this->template->load('orion/template', 'orion/index.html');
		$data['tipocontas']=$this->tipoconta_model->listar();
		$this->load->view('tipoconta/index',$data);
	}
	
	public function cadastrar() {
       $taxa = array(
				'tpc_descricao' => $this->input->post('tpc_descricao')
				);
		$insert = $this->tipoconta_model->cadastrar($taxa);
		echo json_encode(array("status" => TRUE));
    }  
    public function ajax_edit($id){
		$data = $this->tipoconta_model->getTipoConta($id);
		echo json_encode($data);
	}
	public function tipoconta_update(){
		$data = array(
				'tpc_descricao' => $this->input->post('tpc_descricao')
			);
		$this->tipoconta_model->tipoConta_update(array('tpc_id' => $this->input->post('tpc_id')), $data);
		echo json_encode(array("status" => TRUE));
	}


	public function tipoconta_delete($id){
		$this->tipoconta_model->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}
	public function lista_tipoconta_json(){
        $data = $this->tipoconta_model->listar();
        echo json_encode($data);
    }
    
}
