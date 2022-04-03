<?php
require_once("dahili.php");  
	
	@$buton = $_POST["girisbuton"];
	@$kullanici_adi = $_POST["ad"];
	@$kullanici_sifre = $_POST["sifre"];
	if($buton):
		$kullanici_sifre 	=md5(sha1(md5($kullanici_sifre)));
		$kullanici_adi2	=md5(sha1(md5($kullanici_adi)));
		
		
		$sorgu = "SELECT * from kullanici where kulad ='$kullanici_adi2' and kulsifre ='$kullanici_sifre'";
		$giriskontrol=$db->prepare($sorgu);
		$giriskontrol->execute();
		$giriskontrolSonuc = $giriskontrol->get_result();
		
		if($giriskontrolSonuc->num_rows!=0):
			
			setcookie("kullanici_adi",$kullanici_adi,time() +60*60*24);
			setcookie("kullanici_sifre",$kullanici_sifre,time() +60*60*24);

			echo '<div class="alert alert-success">Giriş Başarılı</div>';
			header("refresh:1,url=index.php");
		else:
			echo '<div class="alert alert-danger">Giriş Başarısız1</div>';
			header("refresh:1,url=index.php");

		endif;

	else:

			echo '<div class="alert alert-danger">Hata Oluştu</div>';
			header("refresh:1,url=index.php");
	endif;



?>