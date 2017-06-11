<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Apto extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->model("apto_model");
	}
	public function index(){
		//$this->template->load('orion/template', 'orion/index.html');
		$data['aptos']=$this->apto_model->listar();
		$this->load->view('apto/index',$data);
	}
	
	public function cadastrar() {
       $apto = array(
					'apt_descricao' => $this->input->post('apt_descricao'),
					'apt_locado' => $this->input->post('apt_locado'),
					'usu_id' => $this->input->post('usu_id'),
				);
		$insert = $this->apto_model->cadastrar($apto);
		echo json_encode(array("status" => TRUE));
    }  
    public function ajax_edit($id){
		$data = $this->apto_model->getApto($id);
		echo json_encode($data);
	}
	public function apto_update(){
		$data = array(
				'apt_descricao' => $this->input->post('apt_descricao'),
				'apt_locado' => $this->input->post('apt_locado'),
				'usu_id' => $this->input->post('usu_id'),
			);
		$this->apto_model->apto_update(array('apt_id' => $this->input->post('apt_id')), $data);
		echo json_encode(array("status" => TRUE));
	}


	public function apto_delete($id){
		$this->apto_model->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}
    
}
