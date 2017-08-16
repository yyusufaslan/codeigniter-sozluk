<?php
class User_model extends CI_Model {
	
	
	
	public function __construct()	{
	  $this->load->database(); 
	}
	
	
	
	function login($username, $password)
	 {
	   $this -> db -> limit(1);
	   $query = $this -> db -> get_where('users',array('username'=>$username,'password'=>$password));
	   if($query -> num_rows() == 1)
	   {
	     return $query->result();
	   }
	   else
	   {
	     return false;
	   }
	 }
	 
	 
	 function get_user_id($username){
	   $this -> db -> limit(1);
	   $this -> db -> select('user_id');
	   $query = $this -> db -> get_where('users',array('username'=>$username));
		foreach ($query->result() as $row)
		{
		   return $row->user_id;
		}
	 }
	 
	 //ben sayfası
	 function get_user_info($username){
	   return $this -> db -> get_where('users',array('username'=>$username))->result();
	 }
	 
	 function get_last_rating($username) {
	 	$id=$this->get_user_id($username);
	 	$this->db->order_by('rating.create_time desc');
	 	$this->db->limit(24);
	 	$this->db->join('entries', 'rating.entry_id = entries.entry_id');
	 	return $this -> db -> get_where('rating',array('rating.writer_id'=>$id))->result();
	 }
	 
	function get_last_entry($username) {
	 	$id=$this->get_user_id($username);
	 	$this->db->order_by('create_time desc');
	 	$this->db->limit(12);
	 	return $this -> db -> get_where('entries',array('writer_id'=>$id))->result();
	 }
	 
	 function get_best($username){
	 		$id=$this->get_user_id($username);
	 	$this->db->order_by('entry_puan desc');
	 	$this->db->limit(12);
	 	return $this -> db -> get_where('entries',array('writer_id'=>$id))->result();
	 }
	 //ben sayfası bitiş
	 function ifUserExist($username){
	 	$this -> db -> limit(1);
	   $query = $this -> db -> get_where('users',array('username'=>$username));
	   if($query -> num_rows() == 0)
	   {
	     return true;
	   } else {
	   	return false;
	   }
	 }
	 
	 function ifEmailExist ($mail) {
	 	$this -> db -> limit(1);
	   $query = $this -> db -> get_where('users',array('email'=>$mail));
	   if($query -> num_rows() == 0)
	   {
	     return true;
	   } else {
	   	return false;
	   }
	 }
	 
	 
	 function newUser ($username,$email,$password) {
	 	$query = $this->db->get_where('options',array('id'=>1));
	 	foreach ($query->result() as $row)
		{
		   $user_type=$row->newbies_right;
		   $nesil=$row->newbies_gen;
		   $theme=$row->theme;
		}
		$slug=url_title($username);
		$data = array(
		   'user_type' => $user_type ,
		   'username' => $username ,
		   'slug' => $slug,
		   'email' =>$email ,
		   'password' => $password ,
		   'theme' =>$theme,
		   'nesil' =>$nesil,
		);
		
		if ($this->db->insert('users', $data)){
			return true;
		} else {
			$this->form_validation->set_message('database_check', 'Entry girmede bir sorun oluştu.');
			return false;
		}
		
	 }
	 
	 
	 	public function options() {
    		 $session_data = $this->session->userdata('logged_in');
    		$username = $session_data['username'];
		$query=$this->db->get_where('users',array('username'=>$username));
		 return $query->result();
	}
	
		public function options_update($user_status,$email,$pass,$theme,$username,$newpass) {
			if (!empty($newpass))
			$pass=$newpass;
		$data = array(
               'user_status' => $user_status,
               'email' => $email,
               'password' => md5($pass),
               'theme' => $theme,
            );
		$this->db->where('username', $username);
		$this->db->update('users', $data);
	}
	
	public function pass_check($username,$pass){
		$query=$this->db->get_where('users',array('username'=>$username))->result();
		foreach ($query as $row){
			$password=$row->password;
		}
		if (md5($pass)==$password) { return true; } else { return false; }
		}
	 
}
