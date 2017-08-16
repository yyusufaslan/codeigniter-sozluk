<?php
class Admin_model extends CI_Model {
	
	
	public function __construct()	{
	  $this->load->database(); 
	   $session_data = $this->session->userdata('logged_in');
     $username = $session_data['username'];
	  $user_type=$this->adminCheck($username);
	  if ($user_type=='admin') {
	      $ciddi=1;
	  } else if ($user_type=='mod') {
	      $ciddi=0;
	} else {
	    redirect('welcome', 'refresh');
	}
	}
	
	
	public function adminCheck($username){
	   $this -> db -> limit(1);
	   $query = $this -> db -> get_where('users',array('username'=>$username));
	   	foreach ($query->result() as $row)
		{
		   return $row->user_type;
		}
	}
	
	public function entrySil($id,$wid){
			if (!is_numeric($wid) or !is_numeric($id))
			die('hayvan gibi şi yapıonuz ya');
			 $this->db->query("UPDATE `users` SET `entry_num` = entry_num - 1 WHERE `user_id` = '$wid' "); 
	    $this->db->delete('entries', array('entry_id' => $id)); 
	     $this->db->delete('rating', array('entry_id' => $id)); 
	}
    
    
    public function baslikSil($slug){
	    $this->db->delete('entries', array('entry_slug' => $slug));
	    
	}
	
	    public function userSil($userid){
	    	if (!is_numeric($userid))
			die('hayvan gibi şi yapıonuz ya');
	    $this->db->delete('users', array('user_id' => $userid)); 
	}

    
    	
	    public function butunEntryler($username){
	    $this->db->delete('entries', array('writer_user' => $username)); 
	    $this -> db -> limit(1);
	   $this -> db -> select('user_id');
	   $query = $this -> db -> get_where('users',array('username'=>$username));
		foreach ($query->result() as $row)
		{
		   $user_id= $row->user_id;
		}
	    $this->db->delete('rating', array('writer_id' => $user_id)); 
	}
	
	public function users(){
		 $query=$this->db->get('users');
		 return $query->result();
	}
	
	public function options() {
	$query=$this->db->get('options');
		 return $query->result();
	}
	
	public function options_update($slogan,$uye_alimi,$newbies_right,$newbies_gen,$theme) {
		$data = array(
               'slogan' => $slogan,
               'uye_alimi' => $uye_alimi,
               'newbies_right' => $newbies_right,
               'newbies_gen' => $newbies_gen,
               'theme' => $theme,
            );
		$this->db->where('id', 1);
		$this->db->update('options', $data);
	}
	

}


