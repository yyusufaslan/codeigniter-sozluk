<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

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
                $this->load->model('admin_model');
                $this->load->model('entry_model');
                	   $session_data = $this->session->userdata('logged_in');
     $username = $session_data['username'];
	  $user_type=$this->admin_model->adminCheck($username); 
	  if ($user_type=='admin') {
	      $ciddi=1;
	  } else if ($user_type=='mod') {
	      $ciddi=0;
	} else {
	    redirect('welcome', 'refresh');
	}
            }
   
   
   
   
              public function index()
              {
                  $meta[4]=$this->entry_model->get_option('theme');
          	$entries = $this->entry_model->get_entries();
          	$meta[1]=$this->entry_model->get_option('slogan');
            	$this->load->view('header',array('meta'=>$meta));
           $this->load->view('admin',array('entries'=> $entries));
           $this->load->view('footer');
              }
              
              
              public function users(){
                  $meta[4]=$this->entry_model->get_option('theme');
                 $this->load->helper('url');
               $this->load->library('grocery_CRUD'); 
                  $crud = new grocery_CRUD();
                   $crud->set_table('users')
                   ->set_subject('User')
                   ->columns('create_time','user_id','user_type','user_status','username','slug','email','password','theme','entry_num','tit_num','nesil','rate');
                    $crud->display_as('user_type','Admin/mod/yazar/çaylak')->display_as('user_id','id')->display_as('user_status','Durumu');
                     $output = $crud->render();
               $this->load->view('admin_header',$output);
               $this->load->view('admin');
                $this->load->view('footer');
              }
              
               public function entrys(){
                 $this->load->helper('url');
               $this->load->library('grocery_CRUD'); 
                 $this->grocery_crud->set_table('entries');
              $output = $this->grocery_crud->render();
               $this->load->view('admin_header',$output);
               $this->load->view('admin');
                $this->load->view('footer');
              }
              
                public function options(){
                    $meta[4]=$this->entry_model->get_option('theme');
                 $this->load->helper(array('form'));
                $this->load->library('form_validation');
                $this->form_validation->set_rules('slogan', 'Slogan', 'trim');
            		$this->form_validation->set_rules('newbies_gen', 'Newbies_gen', 'trim|callback_options_update');
            		if ($this->form_validation->run())
            		$update["onay"]=true;
              $data=$this->admin_model->options();
              $meta[1]=$this->entry_model->get_option('slogan');
            	$this->load->view('header',array('meta'=>$meta));
               $this->load->view('admin',array('data'=>$data,'update'=>@$update));
                $this->load->view('footer');
              }
              
              public function entrySil($slug,$id,$writer_id) {
                $this->admin_model->entrySil($id,$writer_id);
                redirect('w/'.$slug, 'refresh');
              }
              
              public function  options_update(){
               $slogan = $this->input->post('slogan');
               $uye_alimi = $this->input->post('uye_alimi');
               $newbies_right = $this->input->post('newbies_right');
               $newbies_gen = $this->input->post('newbies_gen');
               $theme = $this->input->post('theme');
               $this->admin_model->options_update($slogan,$uye_alimi,$newbies_right,$newbies_gen,$theme);
               return true;
              }
              
              
               public function baslikSil($slug) {
                $this->admin_model->baslikSil($slug);
               redirect('welcome', 'refresh');
              }
              
              public function userSil($slug,$id) {
                $this->admin_model->userSil($id);
               redirect('w/'.$slug, 'refresh');
              }
              
              public function butunEntryler($username) {
                $this->admin_model->butunEntryler($username);
               redirect('welcome', 'refresh');
              }
}