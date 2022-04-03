<?php 

$db = new mysqli("localhost","root","","stoktakip") or die("Bağlanamadı");
$db->set_charset("utf8");


class stok {
	//*****************************BAŞLANGIÇ**********************************************//


	public function kategoricek($veri){
		$sorgum ="SELECT * from kategori";
		$getir =$veri->prepare($sorgum);
		$getir->execute();
		$sonuc=$getir->get_result();

		while($kategoriGetir=$sonuc->fetch_assoc()):
			echo '<a id="link" href="index.php?hareket=kategori&id='.$kategoriGetir["id"].'" style="padding-top:40px;">'.$kategoriGetir["ad"]." ".'</a> | ';
		endwhile;
	}

	//***************************************************************************//

	public function varsayilan($verim){
		$sorgum ="SELECT * from urunler";
		$urunGetir=$verim->prepare($sorgum);
		$urunGetir->execute();
		$sonuc = $urunGetir->get_result();

		while($urunGetirSonuc=$sonuc->fetch_assoc()): ?>
			
			<div class="col-md-2   table-bordered " id="kutuliste">  
				<form action="index.php?hareket=urunguncelle" class="" method="post">      
			        <div class="row" style="text-align:center">
			        <div class="col-md-12" ><?php echo $urunGetirSonuc["ad"] ?></div> 
			          <div class="col-md-12">Stok : <?php echo $urunGetirSonuc["stok"] ?></div> 
			        <div class="col-md-12">
			        	<input type="hidden" name="urunID" value="<?php echo $urunGetirSonuc["id"] ?>" />
			        	<input name="stokGuncelle" type="submit"
			        	class="border-1 btn btn-outline-success" value=">" style="margin-bottom:3px; " />
			        </div>        
			        </div>
			      </form>
	        </div>
    		

		<?php endwhile;

	}

	//***************************************************************************//

	public function kategoriyegore($verim,$katid){
		$sorgum ="SELECT * from urunler where katid=$katid";
		$kategoriUrunleri=$verim->prepare($sorgum);
		$kategoriUrunleri->execute();
		$sonuc = $kategoriUrunleri->get_result();

		if($sonuc->num_rows!=0):
			while($kategoriUrunleriSon=$sonuc->fetch_assoc()): ?>
			
			<div class="col-md-2   table-bordered " id="kutuliste">  
				<form action="index.php?hareket=urunguncelle" class="" method="post">      
			        <div class="row" style="text-align:center">
			        <div class="col-md-12" ><?php echo $kategoriUrunleriSon["ad"] ?></div> 
			          <div class="col-md-12">Stok : <?php echo $kategoriUrunleriSon["stok"] ?></div> 
			        <div class="col-md-12">
			        	<input type="hidden" name="urunID" value="<?php echo $kategoriUrunleriSon["id"] ?>" />
			        	<input name="stokGuncelle" type="submit"
			        	class="border-1 btn btn-outline-success" value=">" style="margin-bottom:3px; " />
			        </div>        
			        </div>
			      </form>
	        </div>
    		

		<?php endwhile;
		else:
			echo '<div class="alert alert-danger">Bu Kategoride Henüz Ürün Yok</div>';
		endif;

	}


	//***************************************************************************//


	public function urunguncellegit($db){

		@$buton = $_POST['stokGuncelle'];
		@$urunid =$_POST['urunID'];

		if($buton):
			$sorgum ="SELECT * from urunler where id=$urunid";
			$stokGuncelle= $db->prepare($sorgum);

			$stokGuncelle->execute();
			$sonuc=$stokGuncelle->get_result();
			$stokGuncelleSon=$sonuc->fetch_assoc();  

		?>

		<div class="col-md-4"></div>
		<div class="col-md-4 table-bordered " id="kutuliste">        
	     
	     <form action="index.php?hareket=urunguncelleson" class="" method="post">      
	        <div class="row" style="text-align:center">
	        <div class="col-md-12" ><?php echo $stokGuncelleSon["ad"]; ?></div> 
	          <div class="col-md-12">
	          	<b class="text-danger">
	          		Stok : <input type="text" name="stok" value="" placeholder="stok...">
	          	</b>
	          </div> 
		       <div class="col-md-12">
		       	    <input type="hidden" name="mevcutstok" value="<?php echo $stokGuncelleSon["stok"]; ?>" />
		        	<input type="hidden" name="urunidson" value="<?php echo $stokGuncelleSon["id"]; ?>" />
		        	<input name="guncelson" type="submit" class="btn btn-outline-success mt-1" value="Güncelle" style="margin-bottom:3px; " />
		        </div>        
	        </div>
	    </form>
        
        </div>
        <div class="col-md-4"></div>

		<?php else:
			echo "hata var";
			header("refresh:2,url=index.php");
		endif;
	}

	//***************************************************************************//

	public function guncelson($db){

		@$guncelson 		=$_POST['guncelson'];
		@$urunidson			=$_POST['urunidson'];
		@$mevcutstok 		=$_POST['mevcutstok'];
		@$stok 				=$_POST['stok'];

		$sonstok = $mevcutstok-$stok;


		if($guncelson):
			$guncelle="update urunler set stok=$sonstok where id=$urunidson";
			$guncelson=$db->prepare($guncelle);
			$guncelson->execute();
			echo "Başarıyla Güncellendi";
			header("refresh:1,url=index.php");
			//$sonuc=$guncelson->get_result();
			//$sonSorgu=$sonuc->fetch_assoc();  

		
		else:
			echo "hata var";
			header("refresh:2,url=index.php");
		endif;
	}

	//***************************************************************************//

	public function linkkontrol($db){
		
		$kullaniciSifre=$_COOKIE['kullanici_sifre'];
		$sorgu 							="SELECT * from kullanici where kulsifre='$kullaniciSifre'";
		$kullaniciKontrol 				=$db->prepare($sorgu);
		$kullaniciKontrol->execute();
		$sonuc 							= $kullaniciKontrol->get_result();
		$kullaniciKontrolSonuc			= $sonuc->fetch_assoc();
		

		

		if($kullaniciKontrolSonuc["yetki"]==1): ?>

			<li class="nav-item" id="islem">
	          <a class="nav-link btn btn-outline-dark" href="index.php?hareket=sifredegistir">Şifre Değiştir</a>
	        </li>
	        <li class="nav-item" id="islem">
	          <a class="nav-link btn btn-outline-dark"  href="index.php?hareket=cikis">Çıkış</a>
	        </li>
			<?php else:  ?>
			<li class="nav-item"  id="islem">
	          <a class="nav-link btn btn-outline-dark" href="index.php?hareket=islemler">İşlemler</a>
	        </li>
	        <li class="nav-item" id="islem">
	          <a class="nav-link btn btn-outline-dark" href="index.php?hareket=sifredegistir">Şifre Değiştir</a>
	        </li>
	        <li class="nav-item" id="islem">
	          <a class="nav-link btn btn-outline-dark"  href="index.php?hareket=cikis">Çıkış</a>
	        </li>
			<?php	endif;
	}

	public function sifredegistir($db){ ?>

		<?php
		   $kullaniciSifre=$_COOKIE['kullanici_sifre'];
		  @$buton = $_POST["girisbuton"];
		  @$eski_sifre = md5(sha1(md5($_POST["eski_sifre"])));
		  @$yeni_sifre = md5(sha1(md5($_POST["yeni_sifre"])));
		  @$yeni_sifre_tekrari = md5(sha1(md5($_POST["yeni_sifre_tekrari"])));

		  if(!$buton): ?>
		  	<div class="row" style="text-align:center">
		          <form action="index.php?hareket=sifredegistir" method="post">
		           <div class="col-md-12">
		              Eski Şifre : <br><input type="password" name="eski_sifre">
		            </div> 

		             <div class="col-md-12">
		              Yeni şifre : <br><input type="password" name="yeni_sifre">
		            </div>
		             <div class="col-md-12">
		              Yeni şifre Tekrarı : <br><input type="password" name="yeni_sifre_tekrari">
		            </div> 
		            <div class="col-md-12">
		              <input name="girisbuton" type="submit" class="mt-2 btn-block btn btn-outline-success" value="Şifre Değiştir" style="margin-bottom:3px; " />
		            </div>  
		          </form>      
        	</div>


		 <?php  else: 
		 		
		 		if($eski_sifre !=$kullaniciSifre):
		 			echo '<div class="alert alert-danger ml-2 mt-2">Eski Şifreyi hatalı girdiniz</div>';
					header("refresh:1,url=index.php?hareket=sifredegistir");
		 		elseif($yeni_sifre!=$yeni_sifre_tekrari):
		 			echo '<div class="alert alert-danger ml-2 mt-2">Yeni şifreler uyuşmuyor</div>';
					header("refresh:1,url=index.php?hareket=sifredegistir");
				else:

					$sorgu 							="SELECT * from kullanici where kulsifre='$kullaniciSifre'";
					$kullaniciKontrol 				=$db->prepare($sorgu);
					$kullaniciKontrol->execute();
					$sonuc 							= $kullaniciKontrol->get_result();
					$kullaniciKontrolSonuc			= $sonuc->fetch_assoc();
					$kullaniciID =$kullaniciKontrolSonuc['id'];
					$sorgum="UPDATE kullanici set kulsifre='$yeni_sifre' where id=$kullaniciID";
					$sifreGuncelle=$db->prepare($sorgum);
					$sifreGuncelle->execute();
					$son = $sifreGuncelle->get_result();
					
					setcookie("kullanici_sifre",$yeni_sifre,time() +60*60*24);
					echo '<div class="alert alert-success ml-2 mt-2">Şifre değiştirildi</div>';
					header("refresh:1,url=index.php?hareket=sifredegistir");
		 		endif;

		 endif;
	}


//***************************************************************************//


public function cikis($db){

	setcookie("kullanici_adi",$_COOKIE['kullanici_adi'],time() -10);
	setcookie("kullanici_sifre",$_COOKIE['kullanici_sifre'],time() -10);
	echo '<div class="alert alert-success ml-2 mt-2">Çıkış Yapıldı</div>';
	header("refresh:1,url=index.php");
}







//*****************************BİTİŞ**********************************************//
}

?>