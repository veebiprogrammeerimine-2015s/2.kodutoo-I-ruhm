<?php

  //loome AB �henduse
	require_once ("../config.php");
	$database = "if15_kristalv";
	$mysqli = new mysqli($servername, $username, $password, $database);

  //check connection
	if($mysqli->connect_error) {
		die("connect error ".mysqli_connect_error());
	}
	
	
  // muuutujad errorite jaoks
	$email_error = "";
	$password_error = "";
	$create_email_error = "";
	$create_password_error = "";

  // muutujad v��rtuste jaoks
	$email = "";
	$password = "";
	$create_email = "";
	$create_password = "";


	if($_SERVER["REQUEST_METHOD"] == "POST") {

    // *********************
    // **** LOGI SISSE *****
    // *********************
		if(isset($_POST["login"])){

			if ( empty($_POST["email"]) ) {
				$email_error = "See v�li on kohustuslik";
			}else{
        // puhastame muutuja v�imalikest �leliigsetest s�mbolitest
				$email = cleanInput($_POST["email"]);
			}

			if ( empty($_POST["password"]) ) {
				$password_error = "See v�li on kohustuslik";
			}else{
				$password = cleanInput($_POST["password"]);
			}

      // Kui oleme siia j�udnud, v�ime kasutaja sisse logida
			if($password_error == "" && $email_error == ""){
				echo "V�ib sisse logida! Kasutajanimi on ".$email." ja parool on ".$password;
			
				$hash = hash("sha512", $password);
				
				$stmt = $mysqli->prepare("SELECT id, email FROM user_sample WHERE email=? AND password=?");
				//k�sim�rkide asendus
				$stmt->bind_param("ss", $email, $hash);
				//ab tulnud muutujad
				$stmt->bind_result($id_from_db, $email_from_db);
				$stmt->execute();
				
				//teeb p�ringu ja kui on t�ene (st, et AB oli see v��rtus)
				if($stmt->fetch()){
					
					//kasutaja email ja parool �iged
					echo "Kasutaja logis sisse id=".$id_from_db;
				
				}else{
					echo "Wrong credentials!";
				}
			 
			 $stmt->close();

			}

		} // login if end

    // *********************
    // ** LOO KASUTAJA *****
    // *********************
    if(isset($_POST["create"])){

			if ( empty($_POST["create_email"]) ) {
				$create_email_error = "See v�li on kohustuslik";
			}else{
				$create_email = cleanInput($_POST["create_email"]);
			}

			if ( empty($_POST["create_password"]) ) {
				$create_password_error = "See v�li on kohustuslik";
			} else {
				if(strlen($_POST["create_password"]) < 8) {
					$create_password_error = "Peab olema v�hemalt 8 t�hem�rki pikk!";
				}else{
					$create_password = cleanInput($_POST["create_password"]);
				}
			}

			if(	$create_email_error == "" && $create_password_error == ""){
				echo hash("sha512", $create_password);
				echo "V�ib kasutajat luua! Kasutajanimi on ".$create_email." ja parool on ".$create_password;
			
			  //tekitan parooli r�si muutujasse hash
				$hash = hash("sha512", $create_password);
			
			  //salvestan andmebaasi
				$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password) VALUES (?,?)");
							
			  //kirjutan v�lja errori
			  //echo $stmt->error;
			  //echo $mysqli->error;
				
			  //paneme muutujad k�sim�rkide asemele
			  //ss - s on string, iga muutuja kohta �ks t�ht
				$stmt->bind_param("ss", $create_email, $hash);
				
			  //k�ivitab sisestuse
				$stmt->execute();
				$stmt->close();
			
			}

		} // create if end

	}

  // funktsioon, mis eemaldab k�ikv�imaliku �leliigse tekstist
  function cleanInput($data) {
  	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);
  	return $data;
  }

  //paneme �henduse kinni
	$mysqli->close();
  
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
</head>
<body>

  <h2>Log in</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<input name="email" type="email" placeholder="E-post" value="<?php echo $email; ?>"> <?php echo $email_error; ?><br><br>
  	<input name="password" type="password" placeholder="Parool" value="<?php echo $password; ?>"> <?php echo $password_error; ?><br><br>
  	<input type="submit" name="login" value="Log in">
  </form>

  <h2>Create user</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<input name="create_email" type="email" placeholder="E-post" value="<?php echo $create_email; ?>"> <?php echo $create_email_error; ?><br><br>
  	<input name="create_password" type="password" placeholder="Parool"> <?php echo $create_password_error; ?> <br><br>
  	<input type="submit" name="create" value="Create user">
  </form>

<body>
<html>
