
  <div class="col-md-4 col-md-offset-1  entry_icerik">
      <?php if (@$uye_alimi=='kapali') { ?>
     <div class="alert alert-dismissible alert-warning">
  <button type="button" class="close" data-dismiss="alert">×</button>
Şu an için üye alımları kapalıdır...</div>
     <?php } else { echo validation_errors(); ?>
       <?php echo form_open('kayit'); ?>
         <input type="text" minlength="3" maxlength="50"  class="form-control" size="20" id="username" autocomplete="off" required value="<?php echo set_value('username'); ?>" placeholder="kullanıcı adınız..." name="username"/>
         <br/>
         <input type="email" class="form-control" size="20" id="email" autocomplete="off" required value="<?php echo set_value('email'); ?>" placeholder="mail adresiniz..." name="email"/>
         <br/>
         <input type="password" class="form-control" size="20" placeholder="şifreniz..." required id="password" name="password"/>
         <br/>
         <input type="submit" class="btn btn-default" value="kaydol"/>
       </form>
      <br>
      <?php } ?>
</div>