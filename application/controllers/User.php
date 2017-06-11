<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model("user_model");
    }
    
    public function lista_user_json(){
        $data = $this->user_model->listar();
        echo json_encode($data);
    }
    
}
