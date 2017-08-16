<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

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
                $this->load->model('entry_model','em');
                $this->load->model('user_model','um');
            }
            
    public function index($username)
            {
                $user_data[]=$this->um->get_user_info($username);
                 $user_data[]=$this->um->get_last_rating($username);
                 $user_data[]=$this->um->get_last_entry($username);
                 $user_data[]=$this->um->get_best($username);
                 $user_data[]=$username;
          	 $entries=$this->solframe(1); 
            if($this->session->userdata('logged_in'))
           {
             $session_data = $this->session->userdata('logged_in');
             $username = $session_data['username'];
           }
            $meta[]=$this->em->get_option('slogan');
             $meta[3]=$this->em->mesaj_sor(@$username);
             $meta[4]=$this->em->get_option('theme');
          	$this->load->view('header',array('meta'=>$meta));
            $this->load->view('sol_frame',array('entries'=> $entries[0],'slug'=>@$sono["slug"],'t_sayfa'=>$entries[1],'p'=>1));
          $this->load->view('user_page',array('user'=>$user_data));
           $this->load->view('footer');
            }
            
             public function solframe($p=1) {
            $sayfada = 25; // sayfada gösterilecek içerik miktarını belirtiyoruz.
    		$this->db->where(array('entry_type'=>'baslik'));
    		$sorgu = $this->db->count_all_results('entries');
    		$toplam_icerik = $sorgu;
    		$toplam_sayfa = ceil($toplam_icerik / $sayfada);
    		$data[0]=$this->em->get_entries($p);
    		$data[1]=$toplam_sayfa;
            return   $data;
             }
}