
  <div class="col-md-9  entry_icerik">
        <table class="table table-striped table-hover ">
  <thead>
    <tr>
      <th>#</th>
      <th>Entry Adı</th>
      <th>Türü</th>
      <th>Son entry</th>
      <th>İlk entry</th>
      <th>İşlemler</th>
    </tr>
  </thead>
  <tbody>
    <?php $i=1; foreach ($data as $row) { 
    if ($row->fav_type=='baslik'){
      $link='<a href="'.base_url().'w/'.$row->entry_slug.'">';
    } else {
      $link='<a href="'.base_url().'entry/'.$row->entry_id.'">';
    }
    ?>
    <tr>
      <td><?=$i?></td>
      <td><?=$link?><?=$row->entry_name;?></a></td>
      <td><?=$row->fav_type;?></td>
      <td><?=$row->last_update;?></td>
      <td><?=$row->create_time;?></td>
      <td><?='<a href="'.base_url().'favorilerim/'.$row->entry_id.'">'?>sil</a></td>
    </tr>
    <?php
    $i++;
}
?>
  </tbody>
</table> 
</div>