<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Apto extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->model("apto_model");
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
				$data['aptos']=$this->apto_model->listar();
				$this->load->view('apto/index',$data);
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
		        $apto = array(
							'apt_descricao' => $this->input->post('apt_descricao'),
							'apt_locado' => $this->input->post('apt_locado'),
							'usu_id' => $this->input->post('usu_id'),
						);
				$insert = $this->apto_model->cadastrar($apto);
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
				$data = $this->apto_model->getApto($id);
				echo json_encode($data);
			}
		}		
	}
	public function apto_update(){
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
						'apt_descricao' => $this->input->post('apt_descricao'),
						'apt_locado' => $this->input->post('apt_locado'),
						'usu_id' => $this->input->post('usu_id'),
					);
				$this->apto_model->apto_update(array('apt_id' => $this->input->post('apt_id')), $data);
				echo json_encode(array("status" => TRUE));
			}
		}		
	}


	public function apto_delete($id){
		if (!$this->ion_auth->logged_in()){
			$this->session->set_flashdata('message', 'Necessário está logado para ter acesso a essa página');
			redirect('auth/login');
		}else{
			if (!$this->ion_auth->is_admin()){
				$this->session->set_flashdata('message', 'Você deve ser um administrador para visualizar esta página');
				redirect('welcome/index');
			}else{
				$this->apto_model->delete_by_id($id);
				echo json_encode(array("status" => TRUE));
			}
		}		
	}

	public function gerar_receita_extra(){
		if (!$this->ion_auth->logged_in()){
			$this->session->set_flashdata('message', 'Necessário está logado para ter acesso a essa página');
			redirect('auth/login');
		}else{
			if (!$this->ion_auth->is_admin()){
				$this->session->set_flashdata('message', 'Você deve ser um administrador para visualizar esta página');
				redirect('welcome/index');
			}else{
				$this->_validate_receita();
				$this->load->model("receita_model");
				$rec_data_vencimento = $this->input->post('rec_data_vencimento');
				$txc_id = $this->input->post('txc_id');
				$apto_id = $this->input->post('apt_id');
				$insert = $this->receita_model->cadastrarReceitaExtra($rec_data_vencimento, $txc_id, $apto_id);
				echo json_encode(array("status" => TRUE));
				$this->session->set_flashdata('mensagem',"Receita Cadastrada com Sucesso");
			}	
		}
	}
	private function _validate(){
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('apt_descricao') == ''){
            $data['inputerror'][] = 'apt_descricao';
            $data['error_string'][] = 'Descrição é obrigatoria';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('apt_locado') == ''){
            $data['inputerror'][] = 'apt_locado';
            $data['error_string'][] = 'Locado é obrigatoria';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('usu_id') == ''){
            $data['inputerror'][] = 'usu_id';
            $data['error_string'][] = 'Morador é obrigatoria';
            $data['status'] = FALSE;
        }
 
        if($data['status'] === FALSE){
            echo json_encode($data);
            exit();
        }
    }

    private function _validate_receita(){
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('rec_data_vencimento') == ''){
            $data['inputerror'][] = 'rec_data_vencimento';
            $data['error_string'][] = 'Data de vencimento é obrigatoria';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('txc_id') == ''){
            $data['inputerror'][] = 'txc_id';
            $data['error_string'][] = 'Taxa é obrigatoria';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('apt_id') == ''){
            $data['inputerror'][] = 'apt_id';
            $data['error_string'][] = 'Apto é obrigatoria';
            $data['status'] = FALSE;
        }
 
        if($data['status'] === FALSE){
            echo json_encode($data);
            exit();
        }
    }
    
}
