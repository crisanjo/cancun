<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empresa extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->model("empresa_model");
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
				//$this->template->load('orion/template', 'orion/index.html');
				$data['empresas']=$this->empresa_model->listar();
				$this->load->view('empresa/index',$data);
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
		        $empresa = array(
						'emp_rz_social' => $this->input->post('emp_rz_social'),
						'emp_nm_fantasia' => $this->input->post('emp_nm_fantasia'),
						'emp_cnpj' => $this->input->post('emp_cnpj')
						);
				$insert = $this->empresa_model->cadastrar($empresa);
				echo json_encode(array("status" => TRUE));
			}
		}		
    }  
    public function ajax_edit($id){
    	if (!$this->ion_auth->logged_in()){
			$this->session->set_flashdata('message', 'Necessário está logado para ter acesso a essa página');
			redirect('auth/login');
		}else{
			if (!$this->ion_auth->is_admin()){
				$this->session->set_flashdata('message', 'Você deve ser um administrador para visualizar esta página');
				redirect('welcome/index');
			}else{
				$data = $this->empresa_model->getEmpresa($id);
				echo json_encode($data);
			}
		}		
	}
	public function empresa_update(){
		if (!$this->ion_auth->logged_in()){
			$this->session->set_flashdata('message', 'Necessário está logado para ter acesso a essa página');
			redirect('auth/login');
		}else{
			if (!$this->ion_auth->is_admin()){
				$this->session->set_flashdata('message', 'Você deve ser um administrador para visualizar esta página');
				redirect('welcome/index');
			}else{
				$this->_validate();
				$empresa = array(
						'emp_rz_social' => $this->input->post('emp_rz_social'),
						'emp_nm_fantasia' => $this->input->post('emp_nm_fantasia'),
						'emp_cnpj' => $this->input->post('emp_cnpj')
						);
				$this->empresa_model->empresa_update(array('emp_id' => $this->input->post('emp_id')), $empresa);
				echo json_encode(array("status" => TRUE));
			}
		}		
	}


	public function empresa_delete($id){
		if (!$this->ion_auth->logged_in()){
			$this->session->set_flashdata('message', 'Necessário está logado para ter acesso a essa página');
			redirect('auth/login');
		}else{
			if (!$this->ion_auth->is_admin()){
				$this->session->set_flashdata('message', 'Você deve ser um administrador para visualizar esta página');
				redirect('welcome/index');
			}else{
				$this->empresa_model->delete_by_id($id);
				echo json_encode(array("status" => TRUE));
			}
		}		
	}
	public function lista_empresa_json(){
		if (!$this->ion_auth->logged_in()){
			$this->session->set_flashdata('message', 'Necessário está logado para ter acesso a essa página');
			redirect('auth/login');
		}else{
			if (!$this->ion_auth->is_admin()){
				$this->session->set_flashdata('message', 'Você deve ser um administrador para visualizar esta página');
				redirect('welcome/index');
			}else{
		        $data = $this->empresa_model->listar();
		        echo json_encode($data);
		    }
		}        
    }
    private function _validate(){
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('emp_rz_social') == ''){
            $data['inputerror'][] = 'emp_rz_social';
            $data['error_string'][] = 'Razão Social é obrigatoria';
            $data['status'] = FALSE;
        }
 
        if($data['status'] === FALSE){
            echo json_encode($data);
            exit();
        }
    }
    
}
