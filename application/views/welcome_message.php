<?php

/*
coded by nurulmac11
*/
 if(current_url()==base_url()){
   $class='entry_icerik_home'; 
 } else {
        $class='entry_icerik'; 
        $url=explode('/',current_url());
    if(in_array("sayfa", $url))
$class='entry_icerik_home'; 
 }
?>
  <div class="col-md-9 <?=$class?>">

      <ul class="pagination pagination-sm">
      <?php // yukarıdan geldiği varsayılan değişkenler:
// $toplam_sayfa ve $sayfa
 
$sayfa_goster = 11; // gösterilecek sayfa sayısı
 $toplam_sayfa=@$sayfalama;
 $sayfa=$p;
$en_az_orta = ceil($sayfa_goster/2);
$en_fazla_orta = ($toplam_sayfa+1) - $en_az_orta;
 
$sayfa_orta = $sayfa;
if($sayfa_orta < $en_az_orta) $sayfa_orta = $en_az_orta;
if($sayfa_orta > $en_fazla_orta) $sayfa_orta = $en_fazla_orta;
 
$sol_sayfalar = round($sayfa_orta - (($sayfa_goster-1) / 2));
$sag_sayfalar = round((($sayfa_goster-1) / 2) + $sayfa_orta); 
 
if($sol_sayfalar < 1) $sol_sayfalar = 1;
if($sag_sayfalar > $toplam_sayfa) $sag_sayfalar = $toplam_sayfa;
 
if($sayfa != 1) echo ' <li><a href="'.base_url().'w/'.$slug.'/1">«</a></li> ';
 
for($s = $sol_sayfalar; $s <= $sag_sayfalar; $s++) {
    if($sayfa == $s) {
         echo ' <li class="active"><a href="'.base_url().'w/'.$slug.'/'. $s . '">'.$s.'</a></li>';
    } else {
         echo ' <li><a href="'.base_url().'w/'.$slug.'/'. $s . '">'.$s.'</a></li>';
    }
}
 
if($sayfa != $toplam_sayfa and (@$sayfalama)) echo ' <li><a href="'.base_url().'w/'.$slug.'/'. $toplam_sayfa . '">»</a></li>';
?>
      </ul>
      
      
      
      
      
    <?php
    $i=1;
    if(!empty($p) and !empty($sayfalama)) {
$i=($p-1)*25;
}
      if($this->session->userdata('logged_in'))
   {
     $session_data = $this->session->userdata('logged_in');
     $username = $session_data['username'];
     $user_id = $session_data['id'];
   }
    function ClickLink($s) {
  return preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" target="_blank">$1</a>', $s);
}
              foreach ($entry as $rowtek)
            {  
                if ($rowtek->last_update!=$rowtek->create_time){
                $editlendi="son düzenleme:".$rowtek->last_update;} else {
                    $editlendi="";
                }
            $i++;
            ?>
            
            <div id="<?=$rowtek->entry_id?>" class="entry" >
            <?php
            if (@$username==$rowtek->writer_user and @$username!='admin')
            $silkendin='<a  class="confirm"  rel="tooltip" data-toggle="tooltip" title="Bu entryi sil." href="'.base_url().'entrynisil/'.$rowtek->entry_slug.'/'.$rowtek->entry_id.'/'.$rowtek->writer_id.'">x</a>';
                                      if (@$username=='admin'){
                $silbaslik='<a  class="confirm" rel="tooltip" data-toggle="tooltip" title="Bu başlığı sil." href="'.base_url().'admin/baslikSil/'.$rowtek->entry_slug.'">x</a> ';
                $silentryleri=' <a  class="confirm" rel="tooltip" data-toggle="tooltip" title="Bu yazarın tüm entrylerini sil." href="'.base_url().'admin/butunEntryler/'.$rowtek->writer_user.'">x</a> ';
                $silentry='<a  class="confirm"  rel="tooltip" data-toggle="tooltip" title="Bu entryi sil." href="'.base_url().'admin/entrySil/'.$rowtek->entry_slug.'/'.$rowtek->entry_id.'/'.$rowtek->writer_id.'">x</a>';
                $siluser=' <a class="confirm"  rel="tooltip" data-toggle="tooltip" title="Bu yazarı sil." href="'.base_url().'admin/userSil/'.$rowtek->entry_slug.'/'.$rowtek->writer_id.'">x</a> ';
            }
            if ($i==1 or (empty($sayfalama) and $i==2)){
                if(@$username)
              $favbaslik='<a href="'.base_url().'favori/'.$rowtek->entry_id.'/baslik"><span rel="tooltip" data-toggle="tooltip" title="favorilere ekle" class="glyphicon glyphicon-star" aria-hidden="true"></span></a> ';
            echo '<p class="baslik">'.@$silbaslik.@$favbaslik.'<a href="'.base_url().'w/'.$rowtek->entry_slug.'">'.$entry_title=$rowtek->entry_name.'</a></p>';
                }
            if (@$username){  
                if ($username==$rowtek->writer_user){
                $edit='<a href="'.base_url().'edit/'.$rowtek->entry_id.'" > edit</a> '; } else {
                    $edit="";
                }
        $fav='<a href="'.base_url().'favori/'.$rowtek->entry_id.'/entry"><span rel="tooltip" data-toggle="tooltip" title="favorilere ekle" class="glyphicon glyphicon-star" aria-hidden="true"></span></a> ';
        if ($username!=$rowtek->writer_user){
        $oylama='
        <a onClick="oylama(this,\''.base_url().'oylama/arti/'.$rowtek->entry_slug.'/'.$rowtek->entry_id.'/'.$user_id.'/'.$rowtek->writer_id.'\')"><span id="oylamaresult" rel="tooltip" data-toggle="tooltip" title="şuku" class="glyphicon glyphicon-plus" aria-hidden="true"></span></a> 
        <a onClick="oylama(this,\''.base_url().'oylama/eksi/'.$rowtek->entry_slug.'/'.$rowtek->entry_id.'/'.$user_id.'/'.$rowtek->writer_id.'\')"><span id="oylamaeksi" rel="tooltip" data-toggle="tooltip" title="çuku" class="glyphicon glyphicon-minus" aria-hidden="true"></span></a>'; 
            
        } else {
            $oylama='';
        }
                }
               
            echo @$fav.@$silentry.' '.@$silkendin.'<span rel="tooltip" data-toggle="tooltip" title="puan: '.$rowtek->entry_puan.'">'.$i.'</span>. '.ClickLink($rowtek->entry_content).'<br/><span class="pull-right"> '.@$oylama.@$siluser.' <a href="'.base_url().'user/'.url_title($rowtek->writer_user).'">'.$rowtek->writer_user.'</a> <a href="'.base_url().'user/'.url_title($rowtek->writer_user).'">?</a> '.@$silentryleri.'</span>
            <p class="text-success pull-right oylamasonucu" ></p><br/>
            <span style="font-size:9px" class="pull-right">'.@$edit.'<a style="color:gray" href="'.base_url().'entry/'.$rowtek->entry_id.'" >'.$rowtek->create_time.'</a> '.@$editlendi.' </span>
            <hr/>';
            $entry_slug=$rowtek->entry_slug;
           
            $entry_title_gir=$rowtek->entry_name; ?>
            </div>
            <?php
            }
            if (@$username){  echo form_open('w/'.@$entry_slug.'/'.$p); ?>
       <textarea minlength="5" maxlength="7000" class="form-control" rows="3" id="entry_girdi" name="entry_girdi" value="<?php echo set_value('entry_girdi'); ?>" required></textarea>
       <input type="hidden" name="title" id="title" value="<?=@$entry_title_gir?>" />
       <br/>
       <?php echo validation_errors(); ?>
         <input type="submit" class="btn btn-default" value="ekle"/>
       </form>
       <?php } ?>
</div>