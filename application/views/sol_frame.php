<?php
 if(current_url()==base_url()){
   $class='sol_frame_home'; 
 } else {
   $class='sol_frame_icerik'; 
   $url=explode('/',current_url());
    if(in_array("sayfa", $url))
   $class='sol_frame_home'; 
 }
?>
  <div class="col-md-3  <?=$class?>" id="sol_frame">
    <div class="list-group"><center>
  <?php
          $url=explode('/',current_url());
          $onay=0;
    if(in_array("sayfa", $url))
$onay=1;
  if($this->session->userdata('page') and !$onay){
    $p=$this->session->userdata('page');
  } else {
        $this->session->set_userdata('page',$p);
  } ?>
 <ul class="pagination pagination-sm">
      <?php // yukarıdan geldiği varsayılan değişkenler:
// $toplam_sayfa ve $sayfa
 
$sayfa_goster = 9; // gösterilecek sayfa sayısı
 $toplam_sayfa=$t_sayfa;
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
 
if($sayfa != 1) echo ' <li><a href="'.base_url().'sayfa/1">«</a></li> ';
 
for($s = $sol_sayfalar; $s <= $sag_sayfalar; $s++) {
    if($sayfa == $s) {
         echo ' <li class="active"><a href="'.base_url().'sayfa/'. $s . '">'.$s.'</a></li>';
    } else {
         echo ' <li><a href="'.base_url().'sayfa/'. $s . '">'.$s.'</a></li>';
    }
}
 
if($sayfa != $toplam_sayfa) echo ' <li><a href="'.base_url().'sayfa/'. $t_sayfa . '">»</a></li>';
?>
      </ul>
<?php
  foreach ($entries as $row)
{
if (@$slug==$row->entry_slug){
echo '<a href="'.base_url().'w/'.$row->entry_slug.'" class="list-group-item selected ">'.$row->entry_name.'</a>';
} else {
  echo '<a href="'.base_url().'w/'.$row->entry_slug.'" class="list-group-item ">'.$row->entry_name.'</a>';
}
}
  ?>
  </div>
 <div class="text-center center-block">
                
                <a href="https://www.facebook.com/gluteenapp/"><i class="fa fa-facebook-square fa-3x social"></i></a>
              <a href="https://twitter.com/gluteenapp"><i class="fa fa-twitter-square fa-3x social"></i></a>
              <a href="https://www.instagram.com/gluteenapp"><i class="fa fa-instagram fa-3x social" aria-hidden="true"></i></a>
              <a href="mailto:gluteenapp@gmail.com"><i class="fa fa-envelope-square fa-3x social"></i></a> &nbsp;&nbsp;&nbsp;&nbsp;
              <a href="www.gluteen.com/"><i class="glyphicon glyphicon-info-sign fa-2x"></i></a>
              <br>
               
              </div>
  </div>