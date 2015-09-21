<?php

	//user_form.php
	
	//jutumärkide vahele input elemndi NAME
	//echo $_POST["email"];
	//echo $_POST["password"];
	
	// muuutujad errorite jaoks
	$email_error = "";
	$password_error = "";
	$create_email_error = "";
	$create_password_error = "";

  // muutujad väärtuste jaoks
	$email = "";
	$password = "";
	$create_email = "";
	$create_password = "";

	
	// Kontrolli ainult siis kui kasutaja vajutab logi sisse nuppu
	if($_SERVER["REQUEST_METHOD"] == "POST") {

		//Kontrollime kasutaja e-posti et see ei ole tühi
		if(empty($_POST["email"])) {
		$email_error = "* Ei tohi jääda tühjaks";
		}
		
		//Kontrollime parooli
		if(empty($_POST["password"])) {
		$password_error = "* Ei tohi jääda tühjaks";
		}else {
			
				//parool ei ole tühi, kontrollime pikkust
				if(strlen($_POST["password"]) < 8 ){
					
					$password_error = "Peab olema vähemalt 8 sümbolit pikk";
					
				}
		
		}
	}
?>
<?php
	// lehe nimi
	$page_title = "Logi sisse";
	
	// faili nimi
	$page_file_name = "login.php";

?>
<?php require_ONCE("../header.php"); ?>	
	
		<h2>Login</h2>
		<form action="user_form.php" method="post">
			<input name="email" type="email"  placeholder="e-post@kool.ee"> <?php echo $email_error; ?> <br> <br>
			<input name="password" type="password"  placeholder="parool"> <?php echo $password_error; ?> <br> <br>
		<form>
			<input type="submit" value="Logi sisse">
		
		<h2>Create user</h2>
				
		<form action="user_form.php" method="post">
			<input name="name" type="text"  placeholder="Eesnimi Perenimi"> <br> <br>
			<input name="email" type="email"  placeholder="e-post@kool.ee"> <?php echo $email_error; ?> <br> <br>
			<input name="password" type="password"  placeholder="parool"> <?php echo $password_error; ?> <br> <br>
		<form>
			<input type="submit" value="Loo kasutaja"> <br><br>
			
			<?php require_ONCE("../footer.php"); ?>	
	</body>

</html>