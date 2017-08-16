<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Oylama extends CI_Controller {

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
                $this->load->database(); 
                $this->load->model('entry_model');
                //$this->output->enable_profiler(true);
            }
   
   
            public function index($oy,$slug,$entryid,$userid,$writerid){
              if ($writerid==$userid) {
                redirect('welcome', 'refresh');
              } else {
              
              if($this->entry_model->oy_ver($oy,$entryid,$userid,$writerid)){
                $this->entry_model->rating($writerid,$oy);
              redirect('entry/'.$entryid, 'refresh');
              } else {
                redirect('entry/'.$entryid, 'refresh');
              }
              }
            }
            

   
}
   