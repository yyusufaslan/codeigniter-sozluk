<?php
class Entry_model extends CI_Model {
	
	
	
	
	
	public function __construct()	{
	  $this->load->database(); 
	}
	
	
	
	

	public function get_entries($p=1) {
		if (!is_numeric($p) or $p<=0)
		$p=1;
		$sayfada = 25; // sayfada gösterilecek içerik miktarını belirtiyoruz.
		$this->db->where(array('entry_type'=>'baslik'));
		$sorgu = $this->db->count_all_results('entries');
		$toplam_icerik = $sorgu;
		$toplam_sayfa = ceil($toplam_icerik / $sayfada);
		$limit = ($p - 1) * $sayfada;
		
		return $this->db->query('SELECT * FROM entries WHERE entry_type="baslik"  ORDER BY last_update desc, entry_id desc LIMIT '.$limit.','.$sayfada.'')->result();
	}
	
	
	public function mesaj_sor($username){
		 $this->db->where(array('message_to'=>$username,'bildirim'=>1));
		 return $this->db->count_all_results('messages');
	}
	
	
	public function get_entry($slug,$p) {

		$sayfada = 25; // sayfada gösterilecek içerik miktarını belirtiyoruz.
    		$this->db->where(array('entry_type'=>'entry','entry_slug'=>$slug));
    		$sorgu = $this->db->count_all_results('entries');
    		$toplam_icerik = $sorgu;
    		$toplam_sayfa = ceil($toplam_icerik / $sayfada);
    		$limit = ($p - 1) * $sayfada;
    		$data[]= $this->db->query('SELECT * FROM entries WHERE entry_slug="'.$slug.'" and entry_type="entry"  ORDER BY create_time asc LIMIT '.$limit.','.$sayfada.'')->result();
    		$data[]=$toplam_sayfa;
    		return $data;
		
	}
	
	
		public function get_single_entry($entry_id) {
		 return $this->db->get_where('entries',array('entry_id'=>$entry_id))->result();
	}
	
	
	public function get_entry_random() {
		$max = $this->db->query("select count(entry_id) as cnt from entries")->row()->cnt;
		for ($i=0;$i<=100;$i++) {
			$rnd = rand(3007,3014);
			$this->db->limit(1);
			$query=$this->db->get_where('entries',array('entry_id'=>$rnd));
			$test='';
			  foreach ($query->result() as $row)
            {
            	 $test=$row->entry_slug;
            }
            if (strlen($test)>3) {
            	return $query->result();
            	break;
            } else {
            	continue;
            }
            
		}
	}
	
	
	
	
	function getEntriesByUser($slug = null,$username = null){
		if($slug == null || $username == null){
			show_error('something bad happened');
		}
		//activerecord kullandiginda get/post vs filtrelemene gerek yok o filtreler
		$this->db->where('writer_user',$username);
		$this->db->where('slug',$slug);
		return $this->db->get('entries')->result();
	}
	
	
	
	
			function ifTopicExist($slug){
				// gelen $slug u temizlememiz lazim standart bi sekilde
			$query=	$this->db->get_where('entries',array('entry_slug'=>$slug,'entry_type'=>'baslik'));	
				if($query->num_rows() == 0){
					return false;
				} else if($query->num_rows() == 1){
					return true;
				} else {
				show_error('oh my god.');
				}
			}
	
	 function entry_edit($entry_id,$entrym,$username) {
	 		 date_default_timezone_set('Europe/Istanbul');
			$date=date('Y-m-d H:i:s');
				$query=	$this->db->get_where('entries',array('entry_id'=>$entry_id))->result();
				foreach ($query as $row){
					$writer=$row->writer_user;
				}
				if($writer!=$username)
				die("çok ayıp.");
				$data = array(
               'entry_content' => $entrym,
               'last_update' => $date
            );
			$this->db->where('entry_id', $entry_id);
			$this->db->update('entries', $data); 
				 }
	 
	 
	function new_entry($entry_name,$entry_type,$entry_content,$writer_user,$writer_id){
		 date_default_timezone_set('Europe/Istanbul');
			$date=date('Y-m-d H:i:s');
		if (!$this->session->userdata('logged_in'))
		redirect('welcome', 'refresh');
		$slug=url_title($entry_name);
		$data = array(
			'create_time' => $date,
		   'entry_name' => $entry_name ,
		   'entry_type' => $entry_type ,
		   'entry_slug' => $slug,
		   'entry_content' => nl2br($entry_content) ,
		   'writer_user' => $writer_user ,
		   'writer_id' =>$writer_id,
		   'last_update' => $date
		);
		if ($entry_type=='baslik'){
			$data2 = array(
			'create_time' => $date,
		   'entry_name' => $entry_name ,
		   'entry_type' => 'entry' ,
		   'entry_slug' => $slug,
		   'entry_content' => nl2br($entry_content) ,
		   'writer_user' => $writer_user ,
		   'writer_id' =>$writer_id,
		   'last_update' => $date
		);
			$this->db->insert('entries', $data2);
		}
		if ($this->db->insert('entries', $data)){
			if (!is_numeric($writer_id))
			die('hayvan gibi şi yapıonuz ya');
				$entry_id= $this->db->insert_id();
				if ($entry_type=='entry'){
			 $this->db->query("UPDATE `users` SET `entry_num` = entry_num + 1 WHERE `user_id` = '$writer_id' "); 
			$this->db->query("UPDATE `entries` SET `last_update` = '$date' WHERE `entry_type` = 'baslik' and `entry_slug`= '$slug'  ");
				}
			 else {
			 $this->db->query("UPDATE `users` SET `tit_num` = tit_num + 1 WHERE `user_id` = '$writer_id' ");
			 }
			return $entry_id;
		} else {
			$this->form_validation->set_message('database_check', 'Entry girmede bir sorun oluştu.');
			return false;
		}
		
	}
	
	
	
		public function get_option($field) {
			if ($field=='theme' and $this->session->userdata('logged_in')){
				$session_data = $this->session->userdata('logged_in');
    			 $username = $session_data['username'];
				 $query=$this->db->get_where('users',array('username'=>$username));
				 	foreach ($query->result() as $row)
				{
				  $theme= $row->theme;
				}
				if (empty($theme)){
					$query=$this->db->get_where('options',array('id'=>1));
				foreach ($query->result() as $row)
					{
				   return $row->$field;
					}
					} else {
						return $theme;
					}
				
			} else {
				$query=$this->db->get_where('options',array('id'=>1));
					foreach ($query->result() as $row)
				{
				   return $row->$field;
				}
			}
	}
	
	
		public function oy_ver($oy,$entryid,$userid,$writerid){
			        $data = array(
          		   'user_id' => $userid ,
          		   'entry_id' => $entryid ,
          		   'writer_id' => $writerid,
          		   'rate' =>$oy ,
          		);
          	if (!is_numeric($entryid))
			die('hayvan gibi şi yapıonuz ya');
			$query=	$this->db->get_where('rating',array('entry_id'=>$entryid,'user_id'=>$userid));	
			if ($query->num_rows()==0){
			if ($oy=='arti'){
			 $this->db->query("UPDATE `entries` SET `entry_puan` = entry_puan + 1 WHERE `entry_id` = '$entryid' "); 
			} else {
			 	$this->db->query("UPDATE `entries` SET `entry_puan` = entry_puan - 1 WHERE `entry_id` = '$entryid' "); 
			 }
          	return $this->db->insert('rating', $data);
			} else {
				if ($oy=='arti'){
			$query=	$this->db->get_where('rating',array('entry_id'=>$entryid,'user_id'=>$userid))->row();	
			$reski=$query->rate;
			if($reski=='eksi'){
			 $this->db->query("UPDATE `entries` SET `entry_puan` = entry_puan + 2 WHERE `entry_id` = '$entryid' "); 
			 $this->db->query("UPDATE `users` SET `rate` = rate + 2 WHERE `user_id` = '$writerid' "); 
			}
			 $this->db->query("UPDATE `rating` SET `rate` = 'arti' WHERE `entry_id` = '$entryid' and `user_id` = '$userid' "); 
			} else {
			$query=	$this->db->get_where('rating',array('entry_id'=>$entryid,'user_id'=>$userid))->row();	
			$reski=$query->rate;
			if($reski=='arti'){
			 	$this->db->query("UPDATE `entries` SET `entry_puan` = entry_puan - 2 WHERE `entry_id` = '$entryid' "); 
				$this->db->query("UPDATE `users` SET `rate` = rate - 2 WHERE `user_id` = '$writerid' "); 
			}
			 	$this->db->query("UPDATE `rating` SET `rate` = 'eksi'  WHERE `entry_id` = '$entryid'  and `user_id` = '$userid'"); 
			 }
			
				return false;
			}
		}
		
		   public function rating($id,$oy){
		   	if (!is_numeric($id))
			die('hayvan gibi şi yapıonuz ya');
          	if ($oy=='arti'){
			 $this->db->query("UPDATE `users` SET `rate` = rate + 1 WHERE `user_id` = '$id' "); 
			} else {
			 	$this->db->query("UPDATE `users` SET `rate` = rate - 1 WHERE `user_id` = '$id' "); 
			 }
            }
   
		public function favori_ekle($entry_id,$type){
				$session_data = $this->session->userdata('logged_in');
    			 $username = $session_data['username'];
    		$query=	$this->db->get_where('favs',array('username'=>$username,'entry_id'=>$entry_id,'fav_type'=>$type));	
				if($query->num_rows() != 0){
					return false;
				} else {
			  $data = array(
          		   'username' => $username ,
          		   'entry_id' => $entry_id ,
          		   'fav_type' => $type,
          		);
          		 if($this->db->insert('favs', $data)){
          		 	return true;
          		 } else {
          		 	return false;
          		 }
		}
		}
		
		
		
		public function get_favs(){
			$session_data = $this->session->userdata('logged_in');
    		$username = $session_data['username'];
    		$this->db->join('entries', 'favs.entry_id = entries.entry_id');
    		$this->db->order_by("favs.create_time desc");
    		return $this->db->get_where('favs',array('username'=>$username))->result();	
		}
		
		public function fav_sil($id) {
			$this->db->delete('favs',array('entry_id'=>$id));
		}
		
			public function entrySil($id,$wid){
	   $this -> db -> limit(1);
	   $this -> db -> select('writer_id');
	   $query = $this -> db -> get_where('entries',array('entry_id'=>$id));
		foreach ($query->result() as $row)
		{
		   $writer= $row->writer_id;
		}
		if ($writer!=$wid)
		redirect('welcome', 'refresh');
			if (!is_numeric($wid) or !is_numeric($id))
			die('hayvan gibi şi yapıonuz ya');
			 $this->db->query("UPDATE `users` SET `entry_num` = entry_num - 1 WHERE `user_id` = '$wid' "); 
	    $this->db->delete('entries', array('entry_id' => $id)); 
	    $this->db->delete('rating', array('entry_id' => $id)); 
	}
}