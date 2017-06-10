<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Apto extends CI_Controller {

	public function __construct() {
		parent::__construct();
		 $this->load->model("apto_model");
	}
	public function index(){
		//$this->template->load('orion/template', 'orion/index.html');
		$this->load->view('apto/index');
	}
	
	public function cadastrar() {
       $this->load->library('form_validation');
       $this->form_validation->set_rules('login', 'Login', 'required|min_length[5]|max_length[20]');
       $this->form_validation->set_rules('senha', 'Senha', 'required|min_length[7]', array('required' => 'Você deve preencher a %s.'));
       $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
       if ($this->form_validation->run() == FALSE) {
           $erros = array('mensagens' => validation_errors());
           //$this->session->set_flashdata('mensagem',$erros); 
           $this->load->view('apto/index', $erros);
        } else {
	        $cpf = $this->input->post("cpf");
	        $cnpj = $this->input->post("cnpj");
	        $login = $this->input->post("login");
	        $email = $this->input->post("email");
	        $senha = $this->input->post("senha"); 
	        
	        $dados = array(
	            'cli_codigo' => $cliente->cli_codigo,
	            'usc_login' => $login,
	            'usc_email' => $email,
	            'usc_senha' => md5($senha),
	            'usc_nivel' => '1',
	            'usc_situacao' => '1'
	        );
	        $result = $this->usuarios_model->cadastrar($dados); 
	        if($result == FALSE)  {  
	            $this->session->set_flashdata('mensagem',"Apto cadastrado com sucesso"); 
	            redirect('apto/index');
	        }else {  
	            $this->session->set_flashdata('mensagem',"Erro no cadastro"); 
	            redirect('apto/index');
	        }
        }
      
    }  

    
}
