<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TipoConta extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->model("tipoconta_model");
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
				$data['tipocontas']=$this->tipoconta_model->listar();
				$this->load->view('tipoconta/index',$data);
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
		        $taxa = array(
						'tpc_descricao' => $this->input->post('tpc_descricao')
						);
				$insert = $this->tipoconta_model->cadastrar($taxa);
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
				$data = $this->tipoconta_model->getTipoConta($id);
				echo json_encode($data);
			}
		}			
	}
	public function tipoconta_update(){
		if (!$this->ion_auth->logged_in()){
			$this->session->set_flashdata('message', 'Necessário está logado para ter acesso a essa página');
			redirect('auth/login');
		}else{
			if (!$this->ion_auth->is_admin()){
				$this->session->set_flashdata('message', 'Você deve ser um administrador para visualizar esta página');
				redirect('welcome/index');
			}else{
				$this->_validate();
				$data = array(
						'tpc_descricao' => $this->input->post('tpc_descricao')
					);
				$this->tipoconta_model->tipoConta_update(array('tpc_id' => $this->input->post('tpc_id')), $data);
				echo json_encode(array("status" => TRUE));
			}
		}		
	}


	public function tipoconta_delete($id){
		if (!$this->ion_auth->logged_in()){
			$this->session->set_flashdata('message', 'Necessário está logado para ter acesso a essa página');
			redirect('auth/login');
		}else{
			if (!$this->ion_auth->is_admin()){
				$this->session->set_flashdata('message', 'Você deve ser um administrador para visualizar esta página');
				redirect('welcome/index');
			}else{
				$this->tipoconta_model->delete_by_id($id);
				echo json_encode(array("status" => TRUE));
			}
		}		
	}
	public function lista_tipoconta_json(){
		if (!$this->ion_auth->logged_in()){
			$this->session->set_flashdata('message', 'Necessário está logado para ter acesso a essa página');
			redirect('auth/login');
		}else{
			if (!$this->ion_auth->is_admin()){
				$this->session->set_flashdata('message', 'Você deve ser um administrador para visualizar esta página');
				redirect('welcome/index');
			}else{
		        $data = $this->tipoconta_model->listar();
		        echo json_encode($data);
		    }
		}        
    }
    private function _validate(){
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('tpc_descricao') == ''){
            $data['inputerror'][] = 'tpc_descricao';
            $data['error_string'][] = 'Descrição é obrigatoria';
            $data['status'] = FALSE;
        }
 
        if($data['status'] === FALSE){
            echo json_encode($data);
            exit();
        }
    }
    
}
