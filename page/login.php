<?php

	
	//user_form.php
	//jutumĆ¤rkide vahele GET-ile, see mida tahame kĆ¤tte saada input elemendist NAME HTMLis.
	//olulised on <form action="user_form.php" method="get">
	//ja inputile panna name=""
	
	//echo $_POST["email"];
	//echo $_POST["password"];
	
	
	//muutuja "email_error"
	
	$email_error = "";
	$password_error ="";
	
	$password1 = ""; 
	$password1_error ="";
	$name_error = "";
	$surname_error = "";
	$newemail_error = "";
	$comment ="";
	$gender = "";
	
	//muutujad väärtustega
	$email = "";
	$password = "";
	$name = "";
	$surname = "";
	$newemail = "";
	
	//isset - ütleb kas asi on olemas
	//empty - kas on tühi
	
	//kontrolli ainult siis kui kasutaja vajutab "Logi sisse" nuppu. kas toimub nupuvajutus.
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		
		//kontrollin kas muutuja $_POST["login"] on olemas, ehk "login" nupp ise.
		//kui vajut "logi sisse!"
		if(isset($_POST["login"])){
			
			//kontrollime kasutaja e-posti, et see poleks tühi. kui tühi, siis error.
			if(empty($_POST["email"])){
				$email_error = "Sisesta e-mail";
			}else{
				//annan väärtuse
				$email = test_input($_POST["email"]);
		}
		
		//kontrollime kasutaja parooli, et see poleks tĆ¼hi.
			if(empty($_POST["password"])){
				$password_error = "Sisesta parool!";
			}else{
				$password = test_input($_POST["password"]);
				//parool ei ole tĆ¼hi, kontrollime parooli pikkust.
				//strlen on string lenght
				
				if(strlen($_POST["password"]) <= 8){
					$password_error ="Parool peab olema vähemalt 8 sümbolit pikk!";
				}else{
					$password = test_input($_POST["password"]);
				}
			}
			
			//kui erroreid pole, siis viskab veebilehe päisesse sisestatud andmed
			
				if($email_error == "" && $password_error == ""){
					// kui erroreid ei olnud
					echo "Kontrollin ".$email. " " .$password;
				}
			
		}
	}
	//siit algab kasutaja loomise osa.
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		
		if(isset($_POST["createuser"])){ //kui vajutatakse "registreeri kasutaja" nuppu
		
			if (empty($_POST["name"])) {
				$name_error = "Eesnime väli on kohustuslik!";
			}else{
				$name = test_input($_POST["name"]);
			}	
		
			if (empty($_POST["surname"])) {
				$surname_error = "Perekonnanime väli on kohustuslik!";
			}else{
				$surname = test_input($_POST["surname"]);
			}	
		
			if(empty($_POST["newemail"])){
				$newemail_error = "e-maili väli on kohustuslik!";
			}else{
				$newemail = test_input($_POST["newemail"]);
			}
		
			if(empty($_POST["password1"])){
				$password1_error="Ei saa olla tühi";
			}else{
            
				//parool ei ole tĆ¼hi, kontrollime pikkust
				if(strlen($_POST["password1"]) < 8){
					$password1_error="Peab olema vĆ¤hemalt 8 sümbolit!";
				}else{
					$password1 = test_input($_POST["password1"]);
                
				//errorit trükitakse HTML osas rea järel php koodis.
				}
				
			}
			
			if(!empty($_POST["gender"])){
				$gender = test_input($_POST["gender"]);
			}
		
		
		if($name_error == "" && $surname_error == "" && $newemail_error == "" && $password1_error == ""){
					// kui erroreid ei olnud
					echo "Kontrollin " .$name. " " .$surname. " " .$newemail. " " .$password1;
				}
		
		}
	}
	//Selle saan lisada igale asjale, et käiks läbi ja kustutaks üleliigse.
	function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data); //kaotab liigsed kaldkriipsud
  $data = htmlspecialchars($data); //võtab erinevad HTML sümbolid ja teeb teksti kujule.
  return $data;
}
	
?>
<?php
	//lehe nimi
	$page_title = "Logi sisse!";
	
	//faili nimi
	$page_file_name = "login.php";
?>

<?php require_once("../header.php"); ?>

		<p>Veebilehele sisselogides saaks sisestada andmeid/pääseks ligi kogutud andmetele/neid analüüsida, mis on saadud välitööde käigus. Tegu on NATURA 2000 rannikuelupaikade ja -alade kaardistamisega (GPS-punktid, pildid, kommentaarid).
		Edasi graafikud, kaardid, joonised nende andmete analüüsil. Geoökoloogia.
	
		<h2>Log in</h2>
		<!--selleks, et -->
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			
				<input name="email" type="email" placeholder="e-post" value="<?php echo $email;?>" >* <?php echo $email_error; ?> <br><br>
				<input name="password" type="password" placeholder="parool">* <?php echo $password_error; ?><br><br>
				
				<input name="login" type="submit" value="Logi sisse">
			
			</form>
			
			
		<h2>Create user</h2>
			
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			
				<input type="text" name="name" placeholder="Eesnimi" value="<?php echo $name;?>" >* <?php echo $name_error;?><br><br>
				<input type="text" name="surname" placeholder="Perekonnanimi" value="<?php echo $surname;?>" >* <?php echo $surname_error;?><br><br>
				<input name="newemail" type="email" placeholder="e-post" value="<?php echo $newemail;?>" >* <?php echo $newemail_error; ?> <br><br>
				<input name="password1" type="password" placeholder="Sisesta soovitud parool">* <?php echo $password1_error; ?><br><br>
				
				
				
				Biograafia <textarea name="comment" rows="5" cols="30"><?php echo $comment;?></textarea><br>
				
				<p>Sünniaeg: <input type="text" name="dob" placeholder="nt. 01.01.1993" /></p>
				
				<input type="radio" name="gender" value="female" <?php if (isset($gender) && $gender=="female") echo "checked";?>>Naine
				<input type="radio" name="gender" value="male" <?php if (isset($gender) && $gender=="male") echo "checked";?>>Mees <br><br>
				
				<input name="createuser" type="submit" value="Registreeri kasutajaks!">
			
			
			</form>
					
	<?php require_once("../footer.php"); ?>				
		
