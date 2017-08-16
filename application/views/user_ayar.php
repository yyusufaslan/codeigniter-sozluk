
  <div class="col-md-9  entry_icerik">
  <?php
  if (@$data){
      if(@$update["onay"]) {
          echo '<div class="alert alert-dismissible alert-success">
  <button type="button" class="close" data-dismiss="alert">×</button>
  Ayarlar güncellendi!.
</div>';
      }
      foreach ($data as $row){
      ?>
      <div id="options_form">
       <?php echo validation_errors(); ?>
       <?php echo form_open('ayarlar/update'); ?>
        durum<input required type="text" class="form-control" name="user_status"  id="user_status" value="<?=$row->user_status?>" placeholder="">
        email<input required type="text" class="form-control" name="email"  id="email" value="<?=$row->email?>" placeholder="">
         eski şifreniz*<input  required type="password" class="form-control" name="pass"  id="pass" value="" placeholder="">
         yeni şifre<input type="password" class="form-control" name="newpass"  id="newpass" value="" placeholder="">
         Sitenin teması
               <select class="form-control" onchange="changeCSS('', 0);" id="theme" name="theme">
          <option  <?php if($row->theme=='cosmo') echo 'selected'; ?>>cosmo</option>
          <option  <?php if($row->theme=='cyborg') echo 'selected'; ?>>cyborg</option>
          <option  <?php if($row->theme=='darkly') echo 'selected'; ?>>darkly</option>
          <option  <?php if($row->theme=='simplex') echo 'selected'; ?>>simplex</option>
          <option  <?php if($row->theme=='slate') echo 'selected'; ?>>slate</option>
        </select>
         <p style="margin-top:10px;"><button type="submit" class="btn btn-default">kaydet</button></p>
</form>
      </div>
  <?php }}?>
</div>