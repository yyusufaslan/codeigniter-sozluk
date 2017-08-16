<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kayit extends CI_Controller {

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
                $this->load->model('entry_model'); 
            	$this->load->model('user_model');
            }
   
   
   
   
              public function index($p=1)
              {
                  if($this->session->userdata('logged_in'))
               {
                     redirect('welcome', 'refresh');
               }
                $meta[4]=$this->entry_model->get_option('theme');
               if ($this->entry_model->get_option('uye_alimi')=='açık'){
                $this->load->helper(array('form'));
                $this->load->library('form_validation');
            		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[3]|max_length[50]',array('is_unique'=>'Bu kullanıcı adı daha önce alınmış.'));
            		$this->form_validation->set_rules('email', 'email', 'trim|required|valid_email');
            		$this->form_validation->set_rules('password', 'Password', 'trim|required|md5|callback_kayit_ol');
            		$this->form_validation->set_message('required', 'Kullanıcı adı ya da şifre boş olamaz.');
            		if ($this->form_validation->run() == FALSE)
            		{
            		   $meta[1]=$this->entry_model->get_option('slogan');
            	$this->load->view('header',array('meta'=>$meta));
            	$entries = $this->solframe($p);
               $this->load->view('sol_frame',array('entries'=> $entries[0],'t_sayfa'=>$entries[1],'p'=>$p));
             $this->load->view('kayit',array('entries'=> $entries));
             $this->load->view('footer');
            		}
            		else
            		{
            		$sess_array = array(
                   'id' => $this->user_model->get_user_id($this->input->post('username')),
                   'username' =>$this->input->post('username'));
                 $this->session->set_userdata('logged_in', $sess_array);
                      redirect('welcome', 'refresh');
            		}
               } else {
                 $meta[1]=$this->entry_model->get_option('slogan');
                 $this->load->view('header',array('meta'=>$meta));
            	 $entries = $this->solframe($p);
                 $this->load->view('sol_frame',array('entries'=> $entries[0],'t_sayfa'=>$entries[1],'p'=>$p));
                 $this->load->view('kayit',array('entries'=> $entries,'uye_alimi'=>'kapali'));
                 $this->load->view('footer');
               }
              }
              
           public function solframe($p=1) {
            $sayfada = 25; // sayfada gösterilecek içerik miktarını belirtiyoruz.
    		$this->db->where(array('entry_type'=>'baslik'));
    		$sorgu = $this->db->count_all_results('entries');
    		$toplam_icerik = $sorgu;
    		$toplam_sayfa = ceil($toplam_icerik / $sayfada);
    		$data[0]=$this->entry_model->get_entries($p);
    		$data[1]=$toplam_sayfa;
            return   $data;
             }
              
            public function kayit_ol($password)
           {
             //Field validation succeeded.  Validate against database
             $username = $this->input->post('username');
             $email = $this->input->post('email');
             //query the database
              $result = $this->user_model->ifUserExist($username);
             if ($result){
                 if ($this->user_model->ifEmailExist($email)) {
                  $result = $this->user_model->newUser($username,$email, $password);
                 return true;
                 } else {
                 $this->form_validation->set_message('kayit_ol','Bu email ile daha önce kayıt olunmuş.');
                 return false;
                 }

             } else {
                 $this->form_validation->set_message('kayit_ol','Bu kullanıcı adı daha önce alınmış.');
                 return false;
             }
           }
     
  
}