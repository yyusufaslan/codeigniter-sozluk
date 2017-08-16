<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mesaj extends CI_Controller {

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
               // $this->output->enable_profiler(true);
              $this->load->model('entry_model');
              $this->load->model('mesaj_model','mm');
            }
   
            public function index(){
                $meta[4]=$this->entry_model->get_option('theme');
              $p=1;
             $this->load->helper(array('form'));
            $this->load->library('form_validation');
          	 $entries=$this->solframe($p); 
            $meta[1]=$this->entry_model->get_option('slogan');
            $meta[0]='gelen mesajlar';
            $session_data = $this->session->userdata('logged_in');
             $username = $session_data['username'];
            $g_ms=$this->mm->get_mesajlar($username,'gelen');
          	$this->load->view('header',array('meta'=>$meta));
             $this->load->view('sol_frame',array('entries'=> $entries[0],'t_sayfa'=>$entries[1],'p'=>$p));
          $this->load->view('mesaj',array('gms'=>$g_ms,'aktif'=>'gelen'));
           $this->load->view('footer');
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
            
                public function giden(){
                    $meta[4]=$this->entry_model->get_option('theme');
              $p=1;
             $this->load->helper(array('form'));
            $this->load->library('form_validation');
            $this->form_validation->set_rules('mesaj', 'Mesaj', 'trim|strip_tags|min_length[5]|max_length[7000]|required|callback_yolla');
            $this->form_validation->set_rules('kime', 'Kime', 'trim|strip_tags|min_length[3]|max_length[240]|required');
            $this->form_validation->set_message('required', 'Mesaj boş olamaz.');
            if($this->form_validation->run()) {
                $gitti='Mesajınız gönderildi.<br/>';
            }
          	 $entries=$this->solframe($p); 
            $meta[1]=$this->entry_model->get_option('slogan');
            $meta[0]='giden mesajlar';
            $session_data = $this->session->userdata('logged_in');
             $username = $session_data['username'];
            $g_ms=$this->mm->get_mesajlar($username,'giden');
          	$this->load->view('header',array('meta'=>$meta));
             $this->load->view('sol_frame',array('entries'=> $entries[0],'t_sayfa'=>$entries[1],'p'=>$p));
          $this->load->view('mesaj',array('gms'=>$g_ms,'aktif'=>'giden','durum'=>@$gitti));
           $this->load->view('footer');
            }
            
            public function yolla(){
                $this->load->model('user_model','um');
                $mesaj=$this->input->post('mesaj');
                $kime=$this->input->post('kime');
                if(!$this->um->ifUserExist($kime)){
                $this->mm->yeni_mesaj($mesaj,$kime);
                return true;
                } else {
                    $this->form_validation->set_message('yolla', 'Böyle bir kullanıcı yok. Şizofren olabilir misiniz ?');
                    return false;
                }
            }
            
            public function sil($route,$id){
                $this->mm->sil($id,$route);
                 if ($route=='gelen')
                $route='';
                redirect('mesaj/'.$route, 'refresh');
            }
}
   