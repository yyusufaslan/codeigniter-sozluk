
  <div class="col-md-4 col-md-offset-1  entry_icerik">
     <?php echo validation_errors(); ?>
       <?php echo form_open('giris'); ?>
         <input type="text" class="form-control" size="20" id="username" autocomplete="off" required value="<?php echo set_value('username'); ?>" placeholder="kullanıcı adınız..." name="username"/>
         <br/>
         <input type="password" class="form-control" size="20" placeholder="şifreniz..." required id="password" name="password"/>
         <br/>
         Hesabınız yoksa kayıt olmak için <a href="<?=base_url()?>kayit">tıklayın.</a><br/>
         <input type="submit" class="btn btn-default" value="gir"/>
       </form>
      <br>
</div>