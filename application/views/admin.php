
  <div class="col-md-12  admin_content">
  <center><a href="<?=base_url()?>admin/users">yazarlar</a> | <a href="<?=base_url()?>admin/entrys">entryler</a> | <a href="<?=base_url()?>admin/options">site ayarları</a></center>
  <?php echo @$output; 
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
       <?php echo form_open('admin/options'); ?>
        Slogan<input type="text" class="form-control" name="slogan"  id="slogan" value="<?=$row->slogan?>" placeholder="">
        Üye Alımı
             <select class="form-control" name="uye_alimi"  id="uye_alimi">
          <option <?php if($row->uye_alimi=='kapalı') echo 'selected'; ?>>kapalı</option>
          <option <?php if($row->uye_alimi=='açık') echo 'selected'; ?>>açık</option>
        </select>
          Yeni üyeler ne olsun ?
        <select class="form-control" name="newbies_right"  id="newbies_right">
          <option <?php if($row->newbies_right=='çaylak') echo 'selected'; ?>>çaylak</option>
           <option <?php if($row->newbies_right=='mod') echo 'selected'; ?>>mod</option>
            <option <?php if($row->newbies_right=='admin') echo 'selected'; ?>>admin</option>
            <option <?php if($row->newbies_right=='yazar') echo 'selected'; ?>>yazar</option>
        </select>
         Yeni üyeler kaçıncı nesil olsun ?<input type="text" class="form-control" name="newbies_gen"  id="newbies_gen" value="<?=$row->newbies_gen?>" placeholder="">
         Sitenin teması
               <select class="form-control" id="theme"  onchange="changeCSS('', 0);" name="theme">
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
<div class="col-md-1  admin_content"></div>