<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Taxa extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->model("taxa_model");
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
				$data['taxas']=$this->taxa_model->listar();
				$this->load->view('taxa/index',$data);
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
							'txc_descricao' => $this->input->post('txc_descricao'),
							'txc_valor' => $this->input->post('txc_valor'),
							'txc_qtd' => $this->input->post('txc_qtd'),
							'txc_status' => $this->input->post('txc_status'),
							'txc_antecipado' => $this->input->post('txc_antecipado')
						);
				$insert = $this->taxa_model->cadastrar($taxa);
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
				$data = $this->taxa_model->getTaxa($id);
				echo json_encode($data);
			}
		}		
	}
	public function taxa_update(){
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
						'txc_descricao' => $this->input->post('txc_descricao'),
						'txc_valor' => $this->input->post('txc_valor'),
						'txc_qtd' => $this->input->post('txc_qtd'),
						'txc_status' => $this->input->post('txc_status'),
						'txc_antecipado' => $this->input->post('txc_antecipado')
					);
				$this->taxa_model->taxa_update(array('txc_id' => $this->input->post('txc_id')), $data);
				echo json_encode(array("status" => TRUE));
			}
		}		
	}


	public function taxa_delete($id){
		if (!$this->ion_auth->logged_in()){
			$this->session->set_flashdata('message', 'Necessário está logado para ter acesso a essa página');
			redirect('auth/login');
		}else{
			if (!$this->ion_auth->is_admin()){
				$this->session->set_flashdata('message', 'Você deve ser um administrador para visualizar esta página');
				redirect('welcome/index');
			}else{
				$this->taxa_model->delete_by_id($id);
				echo json_encode(array("status" => TRUE));
			}
		}		
	}
	public function lista_taxa_json(){
		if (!$this->ion_auth->logged_in()){
			$this->session->set_flashdata('message', 'Necessário está logado para ter acesso a essa página');
			redirect('auth/login');
		}else{
			if (!$this->ion_auth->is_admin()){
				$this->session->set_flashdata('message', 'Você deve ser um administrador para visualizar esta página');
				redirect('welcome/index');
			}else{
		        $data = $this->taxa_model->listarExtra();
		        echo json_encode($data);
		    }
		}        
    }
    private function _validate(){
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('txc_descricao') == ''){
            $data['inputerror'][] = 'txc_descricao';
            $data['error_string'][] = 'Descrição é obrigatoria';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('txc_valor') == ''){
            $data['inputerror'][] = 'txc_valor';
            $data['error_string'][] = 'Valor é obrigatoria';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('txc_qtd') == ''){
            $data['inputerror'][] = 'txc_qtd';
            $data['error_string'][] = 'Qtd de parcelas é obrigatoria';
            $data['status'] = FALSE;
        }
        if($this->input->post('txc_status') == ''){
            $data['inputerror'][] = 'txc_status';
            $data['error_string'][] = 'Status é obrigatoria';
            $data['status'] = FALSE;
        }
        if($this->input->post('txc_antecipado') == ''){
            $data['inputerror'][] = 'txc_antecipado';
            $data['error_string'][] = 'Anteceipado é obrigatoria';
            $data['status'] = FALSE;
        }
 
        if($data['status'] === FALSE){
            echo json_encode($data);
            exit();
        }
    }
    
}
