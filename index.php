<?php  require_once("dahili.php");  $dahilet = new stok; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<link rel="stylesheet" href="dosya/tasarim.css" />
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>STOK TAKİP SİSTEMİ</title>
</head>
<body>

<div class="container table-bordered" id="cont">

  <?php 
    //echo md5(sha1(md5("hasan")))." ";
  //echo md5(sha1(md5("1234")));
  if(@$_COOKIE['kullanici_adi']=="" && @$_COOKIE['kullanici_sifre']==""): ?>

      <div class="row" style="text-align:center">
          <form action="giris_kontrol.php" method="post">
            
             <div class="col-md-12" >
                Kullanıcı Adı : <br><input type="text" name="ad">
            </div> 
            <div class="col-md-12">
              Parola : <br><input type="password" name="sifre">
            </div> 
            <div class="col-md-12">
              <input name="girisbuton" type="submit" class="mt-2 btn-block btn btn-outline-success" value="Giriş" style="margin-bottom:3px; " />
            </div>  
          </form>      
        </div>
   <?php else:?> 

 

      
      
        
      



<!-- ÜST BÖLÜM -->
<div class="row border-bottom" style="min-height:60px">
		<div class="col-md-3" id="ustbolum"><h4 class="text-danger">Hoşgeldin : <?php echo $_COOKIE['kullanici_adi']; ?></h4></div>
		<div class="col-md-9" id="ustbolum">

      <ul class="nav justify-content-end" >
       <?php $dahilet->linkkontrol($db);  ?>
      </ul>

</div>
</div>
<!-- ÜST BÖLÜM -->

<!-- KATEGORİ BÖLÜM -->
<div class="row border-bottom">
		<div class="col-md-9"><br />
       <?php 
          $dahilet->kategoricek($db);
        ?>
  </div>
		<div class="col-md-3"><form class="form-inline">
  <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Listeleme</label>
  <select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref">
    <option value="1">Kutu</option>
    <option value="2">Liste</option>
     </select>
  <button type="submit" class="btn btn-primary my-1">Uygula</button>
</form></div>
</div>
<!-- KATEGORİ BÖLÜM -->

<!-- ORTA BÖLÜM -->
<div class="row">

<?php 

@$hareket = $_GET['hareket'];

switch ($hareket) :
  case 'kategori':
    
      @$katid=$_GET["id"];
      $dahilet->kategoriyegore($db,$katid);
    break;

    case 'urunguncelle':
      $dahilet->urunguncellegit($db);
    break;

    case 'urunguncelleson':
      $dahilet->guncelson($db);
    break;
  
     case 'sifredegistir':
      $dahilet->sifredegistir($db);
    break;

     case 'cikis':
      $dahilet->cikis($db);
    break;

     case 'islemler':
      $dahilet->islemler($db);
    break;

  default:
   // Ürünleri en son eklenene göre sıralayalım...
  $dahilet->varsayilan($db);
    break;
endswitch;

 ?>



 <!-- LİSTELEME İSKELET

<table class="table table-hover text-center">
    <thead>
      <tr>
        <th>Ürün Adı</th>
        <th>Stok Durumu</th>
        <th>İşlem</th>
      </tr>
    </thead>
    
    <tbody>
    
      <tr>
        <td>Ürün Adı</td>
        <td><b class="text-danger">000</b></td>
        <td><input name="guncel" type="submit" class="btn btn-outline-success" value=">" style="margin-bottom:3px; " /></td>
      </tr>
   <!-- EKLEMELER BURADAN DEVAM EDECEK 
   
      
    </tbody>
  </table>
-->





<!-- KUTU LİSTENİN İSKELETİ

		<div class="col-md-1 table-bordered " id="kutuliste">        
        <div class="row" style="text-align:center">
        <div class="col-md-12" >Ürün Adı</div> 
          <div class="col-md-12"><b class="text-danger">Stok :</b></div> 
        <div class="col-md-12"><input name="guncel" type="submit" class="btn btn-outline-success" value=">" style="margin-bottom:3px; " /></div>        
        </div>
        
        </div>
        
 -->   
		
</div>
<!-- ORTA BÖLÜM -->






</div>

<div class="container table-bordered table-info text-center">
<!-- SAYFALAMA BÖLÜM -->
<div class="row" style="min-height:30px;">
		<div class="col-md-12">SAYFALAMA</div>		
</div>
<!-- SAYFALAMA BÖLÜM -->

 <?php endif;?>
</div>

</body>
</html>