<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" context="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="">
          <?php if($this->session->userdata('logged_in'))
   {
     $session_data = $this->session->userdata('logged_in');
     $username = $session_data['username'];
   }
     ?>
    <title><?=@$meta[0]?> | gluteen.com</title>

    <link href="<?php echo base_url('assets/css/'.$meta[4].'.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/mine.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/font-awesome.min.css') ?>" rel="stylesheet">
        <script src="<?php echo base_url('assets/js/jquery.min.js') ?>"></script>
  <script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
  <script src="<?php echo base_url('assets/js/mine.js') ?>"></script>
         <!-- EASY COMPLETE -->
   <script src="<?php echo base_url();?>js/jquery-3.1.1.js"></script>
  <!-- JS file -->
  <script src="<?php echo base_url();?>js/easyautocomplete/jquery.easy-autocomplete.min.js"></script> 

  <!-- CSS file -->
  <link rel="stylesheet" href="<?php echo base_url();?>js/easyautocomplete/easy-autocomplete.min.css"> 

  <!-- Additional CSS Themes file - not required-->
  <link rel="stylesheet" href="<?php echo base_url();?>js/easyautocomplete/easy-autocomplete.themes.min.css"> 


<script type="text/javascript">
    $(function () {
        $("[rel='tooltip']").tooltip();
    });
</script>
   <script type="text/javascript">
      function changeCSS(cssFile, cssLinkIndex) {
        var oldlink = document.getElementsByTagName("link").item(cssLinkIndex);
        var newlink = document.createElement("link");
        var myselect = document.getElementById('theme');
        newlink.setAttribute("rel", "stylesheet");
        newlink.setAttribute("type", "text/css");
        cssFile = '<?php echo base_url('assets/css/') ?>/'+myselect.value + '.min.css';
        newlink.setAttribute("href", cssFile);
        document.getElementsByTagName("head").item(0).replaceChild(newlink, oldlink);
      }
    </script>
  </head>
<body>
  <div id="container" class="content">
 <!-- Üst menü giriş -->
<nav class="navbar navbar-default navbar-fixed-top" >
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" style="margin:0px 300px 0px 30px" href="<?=base_url()?>">gluteen</a>
     
    </div>

    <div class="collapse navbar-collapse" id="navbar">

    <form method="post" action="<?php echo base_url() ?>search/1" class="navbar-form navbar-left" role="search">
        <div class="form-group">
          <input style="width: 300px;"  minlength="5" maxlength="60" type="text" name="ara" id="ara" class="form-control" placeholder="başlık ara..">
        </div>
        <button type="submit" class="btn btn-default">ara</button>
    </form> 
 

      <ul class="nav navbar-nav navbar-right">
        <?php
          if(@$username)
   { 
   if (@$meta[3]>0)
   $not='<span style="color:red">*</span>';
   ?>
   <li><a href="<?=base_url().'user/'.$username.''?>">ben</a></li>
            <li class="dropdown" style="margin-right:90px">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?=@$not.' '.$username?><span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="<?=base_url().'favorilerim/gir'?>">Favorilerim</a></li>
            <li><a href="<?=base_url().'mesaj'?>">Mesajlar <?=@$meta[3]?></a></li>
            <li><a href="<?=base_url().'ayarlar/guncelle'?>">Ayarlar</a></li>
               <?php if(@$username=='admin') { echo '<li class="divider"></li><li><a href="'.base_url().'admin">Yönetim Paneli</a></li>'; } ?>
            <li class="divider"></li>
            <li><a href="<?=base_url()?>logout/ben">Çıkış</a></li>
          </ul>
        </li>
     <?php
   } else {
        ?>
        <li><a href="<?=base_url()?>giris" style="margin-right:90px">Giriş</a></li> 
        <li><a class="navbar-brand"  href="<?=base_url().'w/gluten-nedir-'?>">nedir?</a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  
</nav>
<!-- üst menü bitiş -->
<div class="mobil_menu" style="display:none">
  <ul class="breadcrumb" style="margin-bottom:0px;">
  <li><a href="<?=base_url()?>">gluteen</a></li>
     <?php
          if(@$username)
   {  ?>
    <li><a href="<?=base_url().'user/'.$username.''?>">ben</a></li>
   <li><a href="<?=base_url().'mesaj'?>">Mesajlar <?=@$meta[3]?></a></li>
   <li><a href="<?=base_url().'favorilerim/gir'?>">Favorilerim</a></li>
   <li><a href="<?=base_url()?>logout/ben">Çıkış</a></li>
   <?php } else { ?>
    <li><a href="<?=base_url()?>giris" style="margin-right:90px">Giriş</a></li>
   <?php } ?>
</ul>
       <form  method="post" action="<?php echo base_url() ?>search/1"  role="search">
         
          <input  style="width:250px; float:left"  minlength="5" maxlength="60" type="text" name="ara" id="araa" class="form-control input-sm" placeholder="başlık ara..">
          
          <button class="btn btn-default" style="float:left; margin-left:6px; margin-top:2px; width:50px; height: 30px;" type="submit">ara</button> 
      </form>
     
</div>



<script type="text/javascript">

  var options = {
    //url: "<?php echo base_url();?>js/countries.json",
    url: "<?php echo base_url();?>welcome/getdatos",
    
    getValue: "entry_name",
    
    theme:"blue-light",


    list: {
      maxNumberOfElements: 5,
      match: {
        enabled: true
      },
      // onClickEvent: function(value, item) {
      //  alert('seleccionado');
      // },
      onClickEvent: function() {
        var value = $("#ara").getSelectedItemData().entry_slug;


        $("#data-holder").val(value).trigger("change");
      },
      onKeyEnterEvent: function(){
        var value = $("#ara").getSelectedItemData().entry_slug;
        $("#data-holder").val(value).trigger("change");
      }
    }
  };

  $("#ara").easyAutocomplete(options);
  $("#araa").easyAutocomplete(options);
</script>