
  <div class="col-md-9 entry_icerik ">
      <div class="user_page">
          
      <?php foreach($user[0] as $row) { ?>
      <?=$user[4]?> / <?=$row->nesil?> nesil <?=$row->user_type?>/ <?=$row->entry_num?> entry / <?=$row->tit_num?> başlık / <?=$row->rate?> puan <br/>
       <?=$row->user_status?>
      <?php } ?>
      <div class="ilk-row-user">
          <ul class="son_entryler wbox">
              Son entryler
     <?php foreach($user[2] as $row) { ?>
      <li><a href="<?=base_url()?>entry/<?=$row->entry_id?>"><?=$row->entry_name?></a></li>
      <?php } ?>
      </ul>
      <ul class="son_sukular wbox">
          Son şukulananlar
           <?php foreach($user[1] as $row) { 
                if ($row->rate=='eksi')
     continue;    ?>
      <li><a href="<?=base_url()?>entry/<?=$row->entry_id?>"><?=$row->entry_name?></a></li>
      <?php } ?>
          
      </ul>
      </div>
       <div class="ikinci-row-user">
          <ul class="son_cukular wbox">
             Son çukulananlar
     <?php foreach($user[1] as $row) { 
     if ($row->rate=='arti')
     continue;
     ?>
      <li><a href="<?=base_url()?>entry/<?=$row->entry_id?>"><?=$row->entry_name?></a></li>
      <?php } ?>
      </ul>
      <ul class="en_iyiler wbox">
          En iyiler
           <?php foreach($user[3] as $row) { ?>
      <li><a href="<?=base_url()?>entry/<?=$row->entry_id?>"><?=$row->entry_name?></a></li>
      <?php } ?>
          
      </ul>
      </div>
      </div>
      </div>