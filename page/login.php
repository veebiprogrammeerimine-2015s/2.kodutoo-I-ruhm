<?php

// loome andmebaasi ühenduse
	require_once("../config.php");
	$database = "if15_karl";
	$mysqli = new mysqli ($servername, $username, $password, $database);
	
	//check connection
	if($mysqli->connect_error) {
		die("connect error".mysqli_connect_error());
	}


	//user_form.php
	// e post & parool
	
	//jutumarkide vahele input elemendi NAME
	//echo $_POST["email"];
	//echo $_POST["password"];
	//Errorid
	
	$loginemail_error = "";
	$loginpassword_error = "";
	$createemail_error = "";
	$createpassword_error = "";
	
	//muutujad valuedega
	$loginemail = "";
	$loginpassword = "";
	$createemail = "";
	$createpassword = "";
	
	
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		
		//kontrollin kas muutuja $_POST["login"], ehk login nupp 
		if (isset($_POST["login"])){
		
			//kontrollime kasutaja eposti lahtrit, et see ei oleks tyhi
		
			if (empty($_POST["loginemail"])){
				$loginemail_error = "Emaili ei tohi tyhjaks j2tta";
			} else {
				
				//annan value
				$loginemail = cleanInput($_POST ["loginemail"]);
			}
			
			
			// kontrollime parooli
			if (empty($_POST["loginpassword"])){
				$loginpassword_error = "Parooli ei tohi tyhjaks j2tta";
			} else {
			//kontrollime pikkust
			
			}
			if ($loginpassword_error == "" && $loginemail_error == "")
			{
				
				//erroreid polnud
				echo "Kontrollin".$loginemail. " ".$loginpassword;
			}	
			
		} elseif (isset($_POST["Create"])){
		
		//if (strlen($_POST["password"]) <8 ){
		//	$password_error = "Peab olema vahemalt 8 symbolit";
		//}
		
		if (empty($_POST["createemail"])){
				$createemail_error = "Emaili ei tohi tyhjaks j2tta";
			} else {
				
				//annan value
				$createemail = $_POST ["createemail"];
			}
			
			
			// kontrollime parooli
			if (empty($_POST["createpassword"])){
				$createpassword_error = "Parooli ei tohi tyhjaks j2tta";
			} else {
			//kontrollime pikkust
			
			}
			if ($createpassword_error == "" && $createemail_error == "")
			{
				
				//erroreid polnud
				echo "Kontrollin".$createemail. " ".$createpassword;
			
			}
		}
		
	}
	
	
	
	//kontrolli ainult siis kui kasutaja vajutab login nuppu
	
	
	?>
	<?php
//lehe nimi
$page_title = "Login";
//faili nimi
$page_file_name = "login.php";
?>

	<?php require_once("../header.php"); ?>
	
			
				<h2>Login</h2>
					<form action="<?php echo htmlspecialchars( $_SERVER["PHP_SELF"] )?>" method="post">
						<input name="loginemail" type="email" placeholder="E-post" value ="<?php echo $loginemail; ?>" > * <?php echo $loginemail_error; ?> <br> <br> 
						<input name="loginpassword" type="password" placeholder="Parool" > * <?php echo $loginpassword_error ; ?><br><br>
						
						<input name="login" type="submit" value="Login">
					</form>
				<h2>Create user</h2>
					<form action="<?php echo htmlspecialchars ( $_SERVER["PHP_SELF"] )?>" method="post">
						<input name="createemail" type="email" placeholder="E-post" value ="<?php echo $createemail; ?>" > * <?php echo $createemail_error; ?> <br> <br> 
						<input name="createpassword" type="password" placeholder="Parool" > * <?php echo $createpassword_error ; ?><br><br>
						
						<input name="Create" type="submit" value="Create">
			<?php require_once("../footer.php"); ?>