<?php
class User_model extends CI_Model{

    public function listar(){
        $this->db->from("users");
        $users = $this->db->get()->result();
        return $users;
    }
   
    public function getApto($id){
        $this->db->from("users");
        $this->db->where("id", $id);
        $user = $this->db->get()->row();
        return $user;
    }

   
   
}