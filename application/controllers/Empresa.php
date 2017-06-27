<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empresa extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->model("empresa_model");
	}
	public function index(){
		//$this->template->load('orion/template', 'orion/index.html');
		$data['empresas']=$this->empresa_model->listar();
		$this->load->view('empresa/index',$data);
	}
	
	public function cadastrar() {
       $empresa = array(
				'emp_rz_social' => $this->input->post('emp_rz_social'),
				'emp_nm_fantasia' => $this->input->post('emp_nm_fantasia'),
				'emp_cnpj' => $this->input->post('emp_cnpj')
				);
		$insert = $this->empresa_model->cadastrar($empresa);
		echo json_encode(array("status" => TRUE));
    }  
    public function ajax_edit($id){
		$data = $this->empresa_model->getEmpresa($id);
		echo json_encode($data);
	}
	public function empresa_update(){
		 $empresa = array(
				'emp_rz_social' => $this->input->post('emp_rz_social'),
				'emp_nm_fantasia' => $this->input->post('emp_nm_fantasia'),
				'emp_cnpj' => $this->input->post('emp_cnpj')
				);
		$this->empresa_model->empresa_update(array('emp_id' => $this->input->post('emp_id')), $empresa);
		echo json_encode(array("status" => TRUE));
	}


	public function empresa_delete($id){
		$this->empresa_model->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}
	public function lista_empresa_json(){
        $data = $this->empresa_model->listar();
        echo json_encode($data);
    }
    
}
