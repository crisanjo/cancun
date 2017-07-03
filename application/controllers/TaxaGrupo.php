<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TaxaGrupo extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->model("TaxaGrupo_model");
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
				$data['taxas']=$this->TaxaGrupo_model->listar();
				$this->load->view('taxagrupo/index',$data);
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
						'tgo_descricao' => $this->input->post('tgo_descricao'),
						'tgo_data' => $this->input->post('tgo_data')
						);
				$insert = $this->taxagrupo_model->cadastrar($taxa);
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
				$data = $this->taxagrupo_model->getTaxaGrupo($id);
				echo json_encode($data);
			}
		}		
	}
	public function taxagrupo_update(){
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
						'tgo_descricao' => $this->input->post('tgo_descricao'),
						'tgo_data' => $this->input->post('tgo_data')
					);
				$this->taxagrupo_model->taxagrupo_update(array('tgo_id' => $this->input->post('tgo_id')), $data);
				echo json_encode(array("status" => TRUE));
			}
		}		
	}


	public function taxagrupo_delete($id){
		if (!$this->ion_auth->logged_in()){
			$this->session->set_flashdata('message', 'Necessário está logado para ter acesso a essa página');
			redirect('auth/login');
		}else{
			if (!$this->ion_auth->is_admin()){
				$this->session->set_flashdata('message', 'Você deve ser um administrador para visualizar esta página');
				redirect('welcome/index');
			}else{
				$this->taxagrupo_model->delete_by_id($id);
				echo json_encode(array("status" => TRUE));
			}
		}		
	}
	public function lista_taxagrupo_json(){
		if (!$this->ion_auth->logged_in()){
			$this->session->set_flashdata('message', 'Necessário está logado para ter acesso a essa página');
			redirect('auth/login');
		}else{
			if (!$this->ion_auth->is_admin()){
				$this->session->set_flashdata('message', 'Você deve ser um administrador para visualizar esta página');
				redirect('welcome/index');
			}else{
		        $data = $this->taxagrupo_model->listar();
		        echo json_encode($data);
		    }
		}        
    }
    private function _validate(){
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('tgo_descricao') == ''){
            $data['inputerror'][] = 'tgo_descricao';
            $data['error_string'][] = 'Descrição é obrigatoria';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('tgo_data') == ''){
            $data['inputerror'][] = 'tgo_data';
            $data['error_string'][] = 'Data é obrigatoria';
            $data['status'] = FALSE;
        }
 
        if($data['status'] === FALSE){
            echo json_encode($data);
            exit();
        }
    }
    
}
