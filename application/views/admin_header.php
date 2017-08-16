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
   if (!isset($meta[4]))
   $meta[4]='simplex';
     ?>
    <title>Yönetim</title>
<?php 
foreach($css_files as $file): ?>
    <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
 
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
 
    <script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
    <link href="<?php echo base_url('assets/css/'.$meta[4].'.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/mine.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/font-awesome.min.css') ?>" rel="stylesheet">
<script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
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
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" style="margin:0px 400px 0px 30px" href="<?=base_url()?>">Sözlük</a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
 
      <form method="post" action="<?php echo base_url() ?>search/ara" class="navbar-form navbar-left" role="search">
        <div class="form-group">
          <input type="text" name="ara" id="ara" class="form-control" placeholder="başlık ara..">
        </div>
        <button type="submit" class="btn btn-default">ara</button>
      </form>
      <ul class="nav navbar-nav navbar-right">
        <?php
          if(@$username)
   { ?>
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
        <?php } ?>
      </ul>
    </div>
  </div>
</nav>
<!-- üst menü bitiş -->