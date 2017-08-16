$(document).ready(function(){
    // document.ready = jquery ve butun pluginleri yuklendiginde calisan fonksiyon
    // 
  $("a.cevapla").click(function(){
      var towho = $(this).attr("towho");
    $("#kime").val(towho);
    $("#mesaj").focus();
  });
 // bu fonksiyonu neden digerinin icine yaziyosun amk ? :D
});

 function deneme(veri){
  $.ajax({url: "site.com/welcome/ajax/test/veri1/veri2",type: 'get', success: function(result){
        // sonuc result un icinde. istedigini kullan
    }});
}
// disinda dursun


// senin attign kod // $ajax başlayan jquery kodu mu javascript kodu mu illa document içinde olcak diye bişi yok yani tamam lan anladım o zaman .d
//$ la baslayan hersey jquery fonksiyonu. jquery yi bi kere yukledin heryerde kullanabilirsin/
// hayir yok, yuklendiginde calissin istedigin seyler ready icinde olucak.
//şey mümkün mü bi dk
