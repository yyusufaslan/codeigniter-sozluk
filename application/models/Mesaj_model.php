<?php
class Mesaj_model extends CI_Model {
	
	
	
	public function __construct()	{
	  $this->load->database(); 
	  //
	}
	
	public function get_mesajlar($userid,$route){
	    if ($route=='gelen'){
		$this->db->order_by("create_time", "desc"); 
	    $msjlr=$this->db->get_where('messages',array('message_to'=>$userid,$route=>'true'))->result(); 
	     $data = array(
               'bildirim' => '0',
            );
		$this->db->where('message_to', $userid);
		$this->db->update('messages', $data);  
	    	return $msjlr;
	    }
	    else if ($route=='giden') {
	    $this->db->order_by("create_time", "desc"); 
	    return $this->db->get_where('messages',array('message_from'=>$userid,$route=>'true'))->result();
	    }
	}
	
	public function yeni_mesaj($mesaj,$kime){
		    $session_data = $this->session->userdata('logged_in');
    		 $username = $session_data['username'];
		$data = array(
		   'message_content' => $mesaj ,
		   'message_from' => $username ,
		   'message_to' => $kime,
		);
		$this->db->insert('messages', $data);
	}
	
	public function sil($id,$route){
		if (!is_numeric($id))
		die('hayvan gibi şi yapıonuz ya');

        $data = array(
               $route => 'false',
            );
		$this->db->where('message_id', $id);
		$this->db->update('messages', $data);         
		$mesajsil=$this->db->get_where('messages',array('message_id'=>$id,'gelen'=>'false','giden'=>'false'));
        if($mesajsil->num_rows()==1){
		$this->db->delete('messages',array('message_id' => $id));
		}
	}
	
}