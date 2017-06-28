<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Conta extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->model("conta_model");
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
				$data['contas']=$this->conta_model->listar();
				$this->load->view('conta/index',$data);
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
		        $conta = array(
							'emp_id' => $this->input->post('emp_id'),
							'tpc_id' => $this->input->post('tpc_id'),
							'con_valor' => $this->input->post('con_valor'),
							'con_data' => $this->input->post('con_data'),
							'con_status' => $this->input->post('con_status'),
							'con_obs' => $this->input->post('con_obs'),
							'con_fixo' => $this->input->post('con_fixo')
						);
				$insert = $this->conta_model->cadastrar($conta);
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
				$data = $this->conta_model->getConta($id);
				echo json_encode($data);
			}
		}		
	}
	public function conta_update(){
		if (!$this->ion_auth->logged_in()){
			$this->session->set_flashdata('message', 'Necessário está logado para ter acesso a essa página');
			redirect('auth/login');
		}else{
			if (!$this->ion_auth->is_admin()){
				$this->session->set_flashdata('message', 'Você deve ser um administrador para visualizar esta página');
				redirect('welcome/index');
			}else{
				$this->_validate();
				$conta = array(
							'emp_id' => $this->input->post('emp_id'),
							'tpc_id' => $this->input->post('tpc_id'),
							'con_valor' => $this->input->post('con_valor'),
							'con_data' => $this->input->post('con_data'),
							'con_status' => $this->input->post('con_status'),
							'con_obs' => $this->input->post('con_obs'),
							'con_fixo' => $this->input->post('con_fixo')
						);
				$this->conta_model->conta_update(array('con_id' => $this->input->post('con_id')), $conta);
				echo json_encode(array("status" => TRUE));
			}
		}		
	}


	public function conta_delete($id){
		if (!$this->ion_auth->logged_in()){
			$this->session->set_flashdata('message', 'Necessário está logado para ter acesso a essa página');
			redirect('auth/login');
		}else{
			if (!$this->ion_auth->is_admin()){
				$this->session->set_flashdata('message', 'Você deve ser um administrador para visualizar esta página');
				redirect('welcome/index');
			}else{
				$this->conta_model->delete_by_id($id);
				echo json_encode(array("status" => TRUE));
			}
		}		
	}

	public function gerar_contas_fixas(){
		if (!$this->ion_auth->logged_in()){
			$this->session->set_flashdata('message', 'Necessário está logado para ter acesso a essa página');
			redirect('auth/login');
		}else{
			if (!$this->ion_auth->is_admin()){
				$this->session->set_flashdata('message', 'Você deve ser um administrador para visualizar esta página');
				redirect('welcome/index');
			}else{
				$insert = $this->conta_model->gerarDespesasFixas();
				echo json_encode(array("status" => TRUE));
				$this->session->set_flashdata('mensagem',"Contas geradas com Sucesso");
			}	
		}
	}
    
    private function _validate(){
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('emp_id') == ''){
            $data['inputerror'][] = 'emp_id';
            $data['error_string'][] = 'Empresa é obrigatoria';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('tpc_id') == ''){
            $data['inputerror'][] = 'tpc_id';
            $data['error_string'][] = 'Categoria é obrigatoria';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('con_data') == ''){
            $data['inputerror'][] = 'con_data';
            $data['error_string'][] = 'Data de vencimento é obrigatoria';
            $data['status'] = FALSE;
        }
        if($this->input->post('con_fixo') == ''){
            $data['inputerror'][] = 'con_fixo';
            $data['error_string'][] = 'Tipo é obrigatoria';
            $data['status'] = FALSE;
        }
        if($this->input->post('con_status') == ''){
            $data['inputerror'][] = 'con_status';
            $data['error_string'][] = 'Situação é obrigatoria';
            $data['status'] = FALSE;
        }
 
        if($data['status'] === FALSE){
            echo json_encode($data);
            exit();
        }
    }
}
