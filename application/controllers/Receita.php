<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Receita extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->model("receita_model");
	}
	public function index(){
		if (!$this->ion_auth->logged_in()){
			$this->session->set_flashdata('message', 'Necessário está logado para ter acesso a essa página');
			redirect('auth/login');
		}else{
			if (!$this->ion_auth->is_admin()){
				$this->session->set_flashdata('message', 'Você deve ser um administrador para visualizar esta página');
				redirect('welcome/index');
			}else{
				//$this->template->load('tenplate/template', 'receita/index.php'');
				$data['receitas']=$this->receita_model->listar();
				$this->load->view('receita/index',$data);
			}
		}		
	}
	
	public function cadastrar() {
		if (!$this->ion_auth->logged_in()){
			$this->session->set_flashdata('message', 'Necessário está logado para ter acesso a essa página');
			redirect('auth/login');
		}else{
			if (!$this->ion_auth->is_admin()){
				$this->session->set_flashdata('message', 'Você deve ser um administrador para visualizar esta página');
				redirect('welcome/index');
			}else{
				$this->_validate();
				$rec_data_vencimento = $this->input->post('rec_data_vencimento');
				$tgo_id = $this->input->post('tgo_id');
					
				$insert = $this->receita_model->cadastrar($rec_data_vencimento, $tgo_id);
				echo json_encode(array("status" => TRUE));
			}
		}		
    }  
     public function ajax_pagamento($id){
     	if (!$this->ion_auth->logged_in()){
			$this->session->set_flashdata('message', 'Necessário está logado para ter acesso a essa página');
			redirect('auth/login');
		}else{
			if (!$this->ion_auth->is_admin()){
				$this->session->set_flashdata('message', 'Você deve ser um administrador para visualizar esta página');
				redirect('welcome/index');
			}else{
			 	$data = array('rec_status' => '1');
				$this->receita_model->pagamento(array('rec_id' => $id), $data);
				echo json_encode(array("status" => TRUE));
			}
		}		
	}

	public function receita_delete($id){
		if (!$this->ion_auth->logged_in()){
			$this->session->set_flashdata('message', 'Necessário está logado para ter acesso a essa página');
			redirect('auth/login');
		}else{
			if (!$this->ion_auth->is_admin()){
				$this->session->set_flashdata('message', 'Você deve ser um administrador para visualizar esta página');
				redirect('welcome/index');
			}else{
			 	$this->receita_model->delete_by_id($id);
			 	echo json_encode(array("status" => TRUE));
			}
		}	 	
	}
	private function _validate(){
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('rec_data_vencimento') == ''){
            $data['inputerror'][] = 'rec_data_vencimento';
            $data['error_string'][] = 'Data de vencimento é obrigatoria';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('tgo_id') == ''){
            $data['inputerror'][] = 'tgo_id';
            $data['error_string'][] = 'Grupo é obrigatorio';
            $data['status'] = FALSE;
        }
 
        if($data['status'] === FALSE){
            echo json_encode($data);
            exit();
        }
    }
    
}
