
  <div class="col-md-8 col-md-offset-1  entry_icerik">
      <?php
            if($this->session->userdata('logged_in'))
   {
     $session_data = $this->session->userdata('logged_in');
     $username = $session_data['username'];
   }
      echo $arama;
      ?>
      <br>
      <br>
      <p>Bu başlık henüz açılmamış ...</p>
      <?php
                  if (@$username){
          ?>
       
       <?php echo form_open('search/ara'); ?>
       <textarea  autofocus  minlength="5" maxlength="7000" class="form-control" rows="3" id="entry_girdi" name="entry_girdi" value="<?php echo set_value('entry_girdi'); ?>" required></textarea>
       <input type="hidden" name="title" id="title" value="<?=$arama?>" />
       <br/>
       <?php echo validation_errors(); ?>
         <input type="submit" class="btn btn-default" value="ekle"/>
       </form>
       <?php } ?>
</div>