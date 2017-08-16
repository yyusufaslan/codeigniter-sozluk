<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

  /**
   * Index Page for this controller.
   *
   * Maps to the following URL
   *    http://example.com/index.php/welcome
   *  - or -
   *    http://example.com/index.php/welcome/index
   *  - or -
   * Since this controller is set as the default controller in
   * config/routes.php, it's displayed at http://example.com/
   *
   * So any other public methods not prefixed with an underscore will
   * map to /index.php/welcome/<method_name>
   * @see http://codeigniter.com/user_guide/general/urls.html
   */
            public function __construct(){
                parent::__construct();
                //$this->output->enable_profiler(true);
                $this->load->model('entry_model');
            }
            
   
   
   
            public function index($p=1)
            {
           $this->load->helper(array('form'));
           $this->load->library('form_validation');
          	 $entries=$this->solframe($p); 
          	 if ($this->session->userdata('sonokunan')){
          	  $sono=$this->session->userdata('sonokunan');
          	  $entry = $this->entry_model->get_entry($sono["slug"],$sono["page"]);
          	  $slug=$sono["slug"];
          	  $page=$sono["page"];
          	  $entryler=$entry[0];
          	  $cek=0;
          	 } else {
          	  $cek=1;
          	$entryler = $this->entry_model->get_entry_random();
          	 }
          	  foreach ($entryler as $rowtek)
            { 
            $meta[]= $rowtek->entry_name;
            }
            if($this->session->userdata('logged_in'))
           {
             $session_data = $this->session->userdata('logged_in');
             $username = $session_data['username'];
           }
            $meta[]=$this->entry_model->get_option('slogan');
             $meta[3]=$this->entry_model->mesaj_sor(@$username);
             $meta[4]=$this->entry_model->get_option('theme');
          	$this->load->view('header',array('meta'=>$meta));
            $this->load->view('sol_frame',array('entries'=> $entries[0],'slug'=>@$sono["slug"],'t_sayfa'=>$entries[1],'p'=>$p));
            
          if($cek){
             $this->load->view('welcome_message',array('entry'=>$entryler)); //random
            } else {
          $this->load->view('welcome_message',array('entry'=>$entryler,'slug'=>$slug,'sayfalama'=>$entry[1],'p'=>$page)); //sonokunan
            }
           $this->load->view('footer');
            }
            
        
       	public function w($slug = 'test',$p=1)
         {
         $page=1;
          $meta[4]=$this->entry_model->get_option('theme');
             $this->load->helper(array('form'));
             $this->load->library('form_validation');
             	$this->form_validation->set_rules('entry_girdi', 'Entry', 'trim|strip_tags|min_length[5]|max_length[7000]|required|callback_entry_ekle');
            		$this->form_validation->set_message('required', 'Entry boş olamaz.');
            		$this->form_validation->set_message('min_length', 'Entry 5 karakterden kısa olamaz.');
            	if (	$this->form_validation->run()){
            	 
            	}
            	if($this->input->get('username') == ''){ 
                     $entry = $this->entry_model->get_entry($slug,$p);
                     }else { 
                     $entry = $this->entry_model->getEntriesByUser($this->input->get('username'),$slug);
                      }
                    foreach ($entry[0] as $rowtek)
                    { 
                    $meta[0]= $rowtek->entry_name;
                    }
         
            if($this->session->userdata('logged_in'))
           {
             $session_data = $this->session->userdata('logged_in');
             $username = $session_data['username'];
           }
             $meta[3]=$this->entry_model->mesaj_sor(@$username);
                    $entries=$this->solframe($page);
                    $meta[1]=$this->entry_model->get_option('slogan');
                   $this->load->view('header',array('meta'=>$meta));
                  $this->load->view('sol_frame',array('entries'=> $entries[0],'slug'=>$slug,'t_sayfa'=>$entries[1],'p'=>$page));
                   $this->load->view('welcome_message',array('entry'=>$entry[0],'slug'=>$slug,'sayfalama'=>$entry[1],'p'=>$p));
                   $sonokunan = array(
                   'slug'  => $slug,
                   'page' => $p,
               );
                $this->session->set_userdata('sonokunan',$sonokunan);
                   $this->load->view('footer');
                   
             }
             
             
             public function entry($entry_id){
              $meta[4]=$this->entry_model->get_option('theme');
                           $this->load->helper(array('form'));
             $this->load->library('form_validation');
                 $entry=$this->entry_model->get_single_entry($entry_id);
                    foreach ($entry as $rowtek)
                    { 
                    $meta[0]= $rowtek->entry_name;
                    $slug=$rowtek->entry_slug;
                    }
                    $entries=$this->solframe(1);
                    $meta[1]=$this->entry_model->get_option('slogan');
                   $this->load->view('header',array('meta'=>$meta));
                   $this->load->view('sol_frame',array('entries'=> $entries[0],'slug'=>$slug,'t_sayfa'=>$entries[1],'p'=>1));
                   $this->load->view('welcome_message',array('entry'=>$entry,'slug'=>$slug));
                   $this->load->view('footer');
             }
             
             public function solframe($p=1) {
            $sayfada = 25; // sayfada gösterilecek içerik miktarını belirtiyoruz.
    		$this->db->where(array('entry_type'=>'baslik'));
    		$sorgu = $this->db->count_all_results('entries');
    		$toplam_icerik = $sorgu;
    		$toplam_sayfa = ceil($toplam_icerik / $sayfada);
    		          $url=explode('/',current_url());
          $onay=0;
    if(in_array("sayfa", $url))
$onay=1;
  if($this->session->userdata('page') and !$onay){
    $p=$this->session->userdata('page');
  } else {
        $this->session->set_userdata('page',$p);
  }
    		$data[0]=$this->entry_model->get_entries($p);
    		$data[1]=$toplam_sayfa;
            return   $data;
             }
     
     
             public function entry_ekle($entrym) {
                   $session_data = $this->session->userdata('logged_in');
                   $username = $session_data['username'];
                   $title=$this->input->post('title');
                  	$user_id= $session_data['id'];
                  $entry_id=	$this->entry_model->new_entry($title,'entry',$entrym,$username,$user_id);
                  $slug=url_title($title);
             }
     
     
           public function search ($p=1,$yazar='') {
            $meta[4]=$this->entry_model->get_option('theme');
               $slug = url_title( $this->input->post('ara'));
               if ($yazar !=''){
               $slug=url_title($yazar); } else {
                $yazar = $this->input->post('ara');
               }
               if ($this->entry_model->ifTopicExist($slug)) {
               redirect('w/'.$slug, 'refresh');
               } else {
               $this->load->helper(array('form'));
               $this->load->library('form_validation');
               if ($this->input->post('entry_girdi')){
                $this->form_validation->set_rules('title', 'Entry', 'trim|strip_tags|min_length[5]|max_length[60]|required');
                $this->form_validation->set_rules('entry_girdi', 'Entry', 'trim|strip_tags|min_length[5]|max_length[7000]|required|callback_baslik_ac');
                $this->form_validation->set_message('required', 'Entry boş olamaz.');
                if ($this->form_validation->run() == FALSE) {
                  } else {
                   $slug=url_title($this->input->post('title'));
                   redirect('w/'.$slug, 'refresh');
                  }
               }
              $meta[]=$yazar;
              $meta[]=$this->entry_model->get_option('slogan');
              $meta[0]=$yazar;
               $this->load->view('header',array('meta'=>$meta));
               $entries = $this->solframe($p);
               $this->load->view('sol_frame',array('entries'=> $entries[0],'slug'=>$slug,'t_sayfa'=>$entries[1],'p'=>$p));
               $this->load->view('yeni_baslik',array('arama'=>$yazar));
               $this->load->view('footer');
               
               }  
           }
           public function getdatos(){
              
              $resultado = $this->db->select('entry_name')->where('entry_type', "baslik")->get('entries');
              echo json_encode($resultado->result());
            }
           
           
           
           public function baslik_ac($entrym) {
                   $session_data = $this->session->userdata('logged_in');
                   $username = $session_data['username'];
                   $title=$this->input->post('title');
                  	$user_id= $session_data['id'];
                  	$this->entry_model->new_entry($title,'baslik',$entrym,$username,$user_id);
           }
           
           public function ayarlar($p=1){
             if(!$this->session->userdata('logged_in'))
               {
                     redirect('giris', 'refresh');
               }
            $this->load->model('user_model');
                $meta[4]=$this->entry_model->get_option('theme');
                 $this->load->helper(array('form'));
                $this->load->library('form_validation');
                $this->form_validation->set_rules('user_status', 'User_status', 'trim|max_length[250]');
                 $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
                 $this->form_validation->set_rules('pass', 'Pass', 'trim|required|md5|callback_options_update');
                 $this->form_validation->set_rules('newpass', 'Newpass', 'trim|md5');
                 $this->form_validation->set_rules('theme', 'Theme', 'trim');
            		if ($this->form_validation->run())
            		$update["onay"]=true;
              $data=$this->user_model->options();
              $meta[1]=$this->entry_model->get_option('slogan');
              $meta[0]='ayarlar';
            	$this->load->view('header',array('meta'=>$meta));
            	 $entries = $this->solframe($p);
            $this->load->view('sol_frame',array('entries'=> $entries[0],'t_sayfa'=>$entries[1],'p'=>$p));
               $this->load->view('user_ayar',array('data'=>$data,'update'=>@$update));
                $this->load->view('footer');
           }
           
           
               public function  options_update(){
                $session_data = $this->session->userdata('logged_in');
    	        	$username = $session_data['username'];
                $this->load->model('user_model');
               $user_status = $this->input->post('user_status');
               $email = $this->input->post('email');
               $pass = $this->input->post('pass');
               $newpass = $this->input->post('newpass');
               $theme = $this->input->post('theme');
                if($this->user_model->pass_check($username,$pass)) {
               $this->user_model->options_update($user_status,$email,$pass,$theme,$username,$newpass);
               return true; } else {
                $this->form_validation->set_message('options_update', 'Şifreniz yanlış.');
                return false;
               }
              }
              
              
              public function favori($entry_id,$type){
               if(!is_numeric($entry_id) or ($type!='entry' and $type!='baslik'))
               die('hayvan gibi şi yapıosunuz ya');
               if( $this->entry_model->favori_ekle($entry_id,$type)) {
               redirect('favorilerim/gir', 'refresh');
               } else {
                echo 'bu zaten ekli.';
               }
              }
              
              public function favorilerim($i=0){
                  if(!$this->session->userdata('logged_in'))
               {
                     redirect('giris', 'refresh');
               }
               if($i!=0 and is_numeric($i)){
                $this->entry_model->fav_sil($i);
               }
               $data=$this->entry_model->get_favs();
                           $this->load->model('user_model');
                $meta[4]=$this->entry_model->get_option('theme');
              $meta[1]=$this->entry_model->get_option('slogan');
              $meta[0]='favorilerim';
            	$this->load->view('header',array('meta'=>$meta));
            	 $entries = $this->solframe(1);
            $this->load->view('sol_frame',array('entries'=> $entries[0],'t_sayfa'=>$entries[1],'p'=>1));
               $this->load->view('favs',array('data'=>$data));
                $this->load->view('footer');
              }
              
              
              public function entrynisil($slug,$id,$writer_id) {
                $this->entry_model->entrySil($id,$writer_id);
                redirect('w/'.$slug, 'refresh');
              }
              
              public function edit($entry_id){
              $meta[4]=$this->entry_model->get_option('theme');
                           $this->load->helper(array('form'));
             $this->load->library('form_validation');
                 $entry=$this->entry_model->get_single_entry($entry_id);
                    foreach ($entry as $rowtek)
                    { 
                    $meta[0]= $rowtek->entry_name;
                    $slug=$rowtek->entry_slug;
                    }
                 if ($this->input->post('entry_girdi')){
               	$this->form_validation->set_rules('entry_id', 'entry_id', 'trim|strip_tags|required');
              	$this->form_validation->set_rules('entry_girdi', 'Entry', 'trim|strip_tags|min_length[5]|max_length[7000]|required|callback_entry_edit');
            	 	$this->form_validation->set_message('required', 'Entry boş olamaz.');
            	 	if ($this->form_validation->run() == FALSE) {
            		  } else {
            		   redirect('entry/'.$entry_id, 'refresh');
            		  }
               }
                    $entries=$this->solframe(1);
                    $meta[1]=$this->entry_model->get_option('slogan');
                   $this->load->view('header',array('meta'=>$meta));
                   $this->load->view('sol_frame',array('entries'=> $entries[0],'slug'=>$slug,'t_sayfa'=>$entries[1],'p'=>1));
                   $this->load->view('entry_edit',array('entry'=>$entry,'slug'=>$slug));
                   $this->load->view('footer');
               }  
              
                      public function entry_edit($entrym) {
                   $session_data = $this->session->userdata('logged_in');
                   $username = $session_data['username'];
                   $entry_id=$this->input->post('entry_id');
                  	$user_id= $session_data['id'];
                  	$this->entry_model->entry_edit($entry_id,$entrym,$username);
           }
           
           
           
           
            function logout()
             {
               $this->session->unset_userdata('logged_in');
               session_destroy();
               redirect('welcome', 'refresh');
             }
}
