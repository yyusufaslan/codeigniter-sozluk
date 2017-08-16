<?php
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

    <?php
      if($this->session->userdata('logged_in'))
   {
     $session_data = $this->session->userdata('logged_in');
     $username = $session_data['username'];
     $user_id = $session_data['id'];
   }
              foreach ($entry as $rowtek)
            {
                $slug=$rowtek->entry_slug;
            ?>
  <?php 
            if (@$username==$rowtek->writer_user){
            echo form_open('edit/'.$rowtek->entry_id); ?>
       <textarea minlength="5" maxlength="7000" class="form-control" rows="3" id="entry_girdi" name="entry_girdi" value="<?php echo set_value('entry_girdi'); ?>" required><?=trim($rowtek->entry_content)?></textarea>
       <input type="hidden" name="entry_id" id="entry_id" value="<?=$rowtek->entry_id?>" />
       <br/>
       <?php echo validation_errors(); ?>
         <input type="submit" class="btn btn-default" value="düzelt"/>
       </form>
       <?php } else {
           redirect('w/'.$slug, 'refresh');
       }
       }?>
</div>