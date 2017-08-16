$(document).ready(function(){
  $("a.cevapla").click(function(){
      var towho = $(this).attr("towho");
    $("#kime").val(towho);
    $("#mesaj").focus();
  });
  function deneme(veri){
  alert(veri);
}
});

function oylama(yer,url){
  $( "#oylamaresult" ).load( url );
  $(yer).html("Oyunuz kaydedildi... ");
}

$(function() {
    $('.confirm').click(function() {
        return window.confirm("Emin misiniz ? Bu işlem geri alınamaz.");
    });
});
