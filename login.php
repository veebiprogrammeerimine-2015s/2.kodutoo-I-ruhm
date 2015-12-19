<?php

    require_once("functions.php");


  // muuutujad errorite jaoks
	$firstname_error = "";
	$lastname_error = "";
	$phone_error = "";
	$email_error = "";
	$password_error = "";
	$create_firstname_error = "";
	$create_lastname_error = "";
	$create_phone_error = "";
	$create_email_error = "";
	$create_password_error = "";

  // muutujad väärtuste jaoks
	$firstname = "";
	$lastname = "";
	$phone = "";
	$email = "";
	$password = "";
	$create_firstname = "";
	$create_lastname = "";
	$create_phone = "";
	$create_email = "";
	$create_password = "";


	if($_SERVER["REQUEST_METHOD"] == "POST") {

    // sisselogimine
		if(isset($_POST["login"])){

			if ( empty($_POST["email"]) ) {
				$email_error = "See väli on kohustuslik";
			}else{
        // puhastame muutuja võimalikest üleliigsetest sümbolitest
				$email = cleanInput($_POST["email"]);
			}

			if ( empty($_POST["password"]) ) {
				$password_error = "See väli on kohustuslik";
			}else{
				$password = cleanInput($_POST["password"]);
			}

      // Kui oleme siia jõudnud, võime kasutaja sisse logida
			if($password_error == "" && $email_error == ""){

                $hash = hash("sha512", $password);

                logInUser($email, $hash);
            }

		} // login if end

    // kasutaja loomine
    if(isset($_POST["create"])){

			if ( empty($_POST["create_firstname"]) ) {
				$create_firstname_error = "See väli on kohustuslik";
			}else{
				$create_firstname = cleanInput($_POST["create_firstname"]);
			}

			if ( empty($_POST["create_lastname"]) ) {
				$create_lastname_error = "See väli on kohustuslik";
			}else{
				$create_lastname = cleanInput($_POST["create_lastname"]);
			}

			if ( empty($_POST["create_phone"]) ) {
				$create_phone_error = "See väli on kohustuslik";
			}else{
				$create_phone = cleanInput($_POST["create_phone"]);
			}
			
			if ( empty($_POST["create_email"]) ) {
				$create_email_error = "See väli on kohustuslik";
			}else{
				$create_email = cleanInput($_POST["create_email"]);
			}
			
			if ( empty($_POST["create_password"]) ) {
				$create_password_error = "See väli on kohustuslik";
			} else {
				if(strlen($_POST["create_password"]) < 8) {
					$create_password_error = "Peab olema vähemalt 8 tähemärki pikk!";
				}else{
					$create_password = cleanInput($_POST["create_password"]);
				}
			}

			if(	$create_email_error == "" && $create_password_error == ""){
				//echo hash("sha512", $create_password);
                //echo "Võib kasutajat luua! Kasutajanimi on ".$create_email." ja parool on ".$create_password;
                
                // tekitan parooliräsi
                $hash = hash("sha512", $create_password);
                
                //functions.php's funktsioon
                createUser($create_firstname, $create_lastname, $create_phone, $create_email, $hash);
                
            }

        } // create if end

	}

  // funktsioon, mis eemaldab kõikvõimaliku üleliigse tekstist
  function cleanInput($data) {
  	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);
  	return $data;
  }
 
  
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
	<input name="create_firstname" type="firstname" placeholder="Eesnimi" value="<?php echo $create_firstname; ?>"> <?php $create_firstname_error; ?><br><br>
	<input name="create_lastname" type="lastname" placeholder="Perekonnanimi" value="<?php echo $create_lastname; ?>"> <?php $create_lastname_error; ?><br><br>
	<input name="create_phone" type="phone" placeholder="Telefon" value="<?php echo $create_phone; ?>"> <?php $create_phone_error; ?><br><br>
  	<input name="create_email" type="email" placeholder="E-post" value="<?php echo $create_email; ?>"> <?php echo $create_email_error; ?><br><br>
  	<input name="create_password" type="password" placeholder="Parool"> <?php echo $create_password_error; ?> <br><br>
  	<input type="submit" name="create" value="Create user">
  </form>
<body>
<html>
