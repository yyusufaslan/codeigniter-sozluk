<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Giris extends CI_Controller {

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
            }
   
   
   
   
              public function index($page=1)
              {
                  if($this->session->userdata('logged_in'))
               {
                     redirect('user', 'refresh');
               }
               
                $this->load->helper(array('form'));
                $this->load->library('form_validation');
               $this->load->model('entry_model'); 
               
            	$this->load->model('user_model');
            		$this->form_validation->set_rules('username', 'Username', 'trim|required');
            		$this->form_validation->set_rules('password', 'Password', 'trim|required|md5|callback_database_check');
            		$this->form_validation->set_message('required', 'Kullanıcı adı ya da şifre boş olamaz.');
            		if ($this->form_validation->run() == FALSE)
            		{
            		$entries = $this->entry_model->get_entries(); 
            	   $entries=$this->solframe($page);
            	   	$meta[1]=$this->entry_model->get_option('slogan');
            	    $meta[4]=$this->entry_model->get_option('theme');
            	      $meta[0]='giriş';
            	$this->load->view('header',array('meta'=>$meta));
                   $this->load->view('sol_frame',array('entries'=> $entries[0],'t_sayfa'=>$entries[1],'p'=>$page));
             $this->load->view('giris');
             $this->load->view('footer');
            		}
            		else {
                  redirect('welcome', 'refresh');
            		}
              }
              
              
              
             public function solframe($p=1) {
            $sayfada = 25; // sayfada gösterilecek içerik miktarını belirtiyoruz.
    		$this->db->where(array('entry_type'=>'baslik'));
    		$sorgu = $this->db->count_all_results('entries');
    		$toplam_icerik = $sorgu;
    		$toplam_sayfa = ceil($toplam_icerik / $sayfada);
    		$data[0]=$this->entry_model->get_entries($p=1);
    		$data[1]=$toplam_sayfa;
            return   $data;
             }
              
  
            public function database_check($password)
           {
               $ip = $_SERVER['REMOTE_ADDR'];
               	$this->load->model('user_model');
             //Field validation succeeded.  Validate against database
             $username = $this->input->post('username');
           if (!$this->confirmIPAddress($ip)){
             //query the database
             $result = $this->user_model->login($username, $password);
           
             if($result)
             {
               $sess_array = array();
               foreach($result as $row)
               {
                 $sess_array = array(
                   'id' => $row->user_id,
                   'username' => $row->username
                 );
                 $this->session->set_userdata('logged_in', $sess_array);
               }
               return TRUE;
             }
             else
             {
               $this->form_validation->set_message('database_check', 'Yanlış kullanıcı adı ya da şifre.');
               $this->addLoginAttempt($ip);
               return false;
             } 
           } else {
                $this->form_validation->set_message('database_check', 'Çok fazla sayıda deneme yaptınız lütfen bi süre sonra tekrar deneyin.');
               return false;
             }
           }
     
     
     function confirmIPAddress($value) { 

  $q = "SELECT attempts, (CASE when lastlogin is not NULL and DATE_ADD(LastLogin, INTERVAL 10 MINUTE)>NOW() then 1 else 0 end) as Denied FROM LoginAttempts WHERE ip = '$value'"; 

  $result = $this->db->query($q);
  $Denied= @$result->row()->Denied;
  $data =$result->result();
   foreach ($data as $row) {
       $attempts= $row->attempts;
   }
    
  //Verify that at least one login attempt is in database 

  if (!$data) { 
    return 0; 
  } 
  if ($attempts >= 3) 
  { 
    if($Denied == 1) 
    { 
      return 1; 
    } 
    else 
    { 
      $this->clearLoginAttempts($value); 
      return 0; 
    } 
  } 
  return 0; 
} 

function addLoginAttempt($value) {

   //Increase number of attempts. Set last login attempt if required.

   $q = "SELECT * FROM LoginAttempts WHERE ip = '$value'"; 
   $data = $this->db->query($q)->result();
   
   if($data)
   {
       foreach ($data as $row) {
           $attempt=$row->Attempts;
       }
     $attempts = $attempt+1;         

     if($attempts==3) {
       $q = "UPDATE LoginAttempts SET attempts=".$attempts.", lastlogin=NOW() WHERE ip = '$value'";
       $result = $this->db->query($q);
     }
     else {
       $q = "UPDATE LoginAttempts SET attempts=".$attempts." WHERE ip = '$value'";
       $result = $this->db->query($q);
     }
   }
   else {
     $q = "INSERT INTO LoginAttempts (attempts,IP,lastlogin) values (1, '$value', NOW())";
     $result = $this->db->query($q);
   }
}

function clearLoginAttempts($value) {
  $q = "UPDATE LoginAttempts SET attempts = 0 WHERE ip = '$value'"; 
  return $this->db->query($q);
}
     
  
}