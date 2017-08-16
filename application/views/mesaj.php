<div class="col-md-9 entry_icerik">
    <h3>yeni mesaj:</h3>
    <hr/>
    
       <?php echo form_open('mesaj/giden'); ?>
    <textarea minlength="5"   maxlength="7000" class="form-control" rows="3" id="mesaj" name="mesaj" required><?php echo set_value('mesaj'); ?></textarea>
       <br/><input type="text" id="kime" name="kime" class="form-control input-sm" style="width:200px; float:none; margin:0px;" placeholder="kime"  value="<?php echo set_value('kime'); ?>" /><br/>
         <?php echo validation_errors(); ?>
         <?=@$durum?>
        <input type="submit" class="btn btn-default"  value="gönder" />
        </form>
       <hr/>
   <ul class="nav nav-tabs">
  <li role="presentation" <?php if($aktif=='gelen') echo'class="active"'; ?>><a href="<?=base_url()?>mesaj">gelen</a></li>
  <li role="presentation" <?php if($aktif=='giden') echo'class="active"'; ?>><a href="<?=base_url()?>mesaj/giden">giden</a></li>
</ul>
    <?php $kim='message_to';   if ($aktif=='gelen') $kim='message_from';    
    foreach ($gms as $gm)
            {
                if ($gm->bildirim==1 and $aktif=='gelen')
                $yeni='style="border-radius: 2px;  border: 2px solid #5c0000" '; else {
                    $yeni ='';
                }
            ?><hr/>
              <div class="tek_mesaj" <?=$yeni?>>
             
            <div class="ust_mesaj_bilgisi">
            <a href="#" id="kim"><?=$gm->$kim?></a>  <span class="pull-right"><?=$gm->create_time?></span>
            </div>
            <?=$gm->message_content?><br/>
            <div class="alt_mesaj_bilgisi">
            <span class="pull-right"><a href="<?=base_url().'mesaj/sil/'.$aktif.'/'.$gm->message_id?>">sil</a> <a towho="<?=$gm->$kim?>" class="cevapla">cevapla</a> <a href="#">şikayet</a></span>
            </div>
            </div>
            <?php } ?>
            
    
    </div>