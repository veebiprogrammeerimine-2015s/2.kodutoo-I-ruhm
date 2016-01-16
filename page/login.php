<?php

	//loome ühenduse andmebaasiga
	require_once("../../config.php");
	$database = "if15_rasmrei";
	$mysqli = new mysqli($servername, $username, $password, $database);
	
	// check connection
	if($mysqli->connect_error) {
		die("connect error".mysqli_connect_error());		
	}
  
  // muuutujad errorite jaoks
	$email_error = "";
	$password_error = "";
	$email_2_error = "";
	$password_2_error = "";
	$create_username_error = "";
	$firstname_error= "";
	$lastname_error= "";
	
  // muutujad väärtuste jaoks
	$email = "";
	$password = "";
	$email_2 = "";
	$password_2 = "";
	$create_username = "";
	$firstname= "";
	$lastname= "";
	
	// kontrolli ainult siis, kui kasutaja vajutab "logi sisse" nuppu
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		
		if(isset($_POST["login"])){
			
			//kontrollime, et e-post ei oleks tühi		
			if(empty($_POST["email"])) { 
				$email_error = "Ei saa olla tühi";
			} else {
				$email = cleaninput($_POST["email"]);
			}
		
			//kontrollime parooli	
			if(empty($_POST["password"])) { 
				 $password_error = "Ei saa olla tühi";
			} else { 
			      $password = cleaninput($_POST["password"]);
			}
		  
			if($password_error == "" && $email_error == ""){
				echo "Sisselogimine. Kasutajanimi on ".$email." ja parool on ".$password;
			   
				$hash = hash("sha512", $password);	

				$stmt = $mysqli->prepare("SELECT id, email FROM users WHERE email=? AND password=?");
				// küsimärkide asendus
				$stmt->bind_param("ss", $email, $hash);
				
				$stmt->bind_result($id_from_db, $email_from_db);
				$stmt->execute();
				
				// teeb päringu ja kui on tõene (st et ab oli see väärtus)
				if($stmt->fetch()){
					
					
					echo "Kasutaja logis sisse id=".$id_from_db;
					
				}else{
					echo "Valed andmed!";
				}
				
				$stmt->close();
               
			} 
		
		
		
		
		
		
		
		
		} elseif(isset($_POST["create"])) {
		
			if(empty($_POST["email_2"])) { 
				$email_2_error = "Ei tohi olla täitmata";
			} else {
				  $email_2 = cleanInput($_POST["email_2"]);
				
			}
			
			if(empty($_POST["password_2"])) { 
				$password_2_error = "Ei tohi olla täitmata";
		    } else {
				if(strlen($_POST["password_2"]) < 8) {
					$password_2_error = "Peab olema vähemalt 8 tähemärki pikk!";
				}else{
					$password_2 = cleanInput($_POST["password_2"]);
				}
			}
					
			if(empty($_POST["username"])) { 
				$username_error = "Ei tohi olla tühi";
			} else {
				$username = cleanInput($_POST["username"]);
			}
			
			if(empty($_POST["firstname"])) { 
				$firstname_error = "Ei tohi olla tühi";
			} else {
				$firstname = cleanInput($_POST["firstname"]);
			
			}
			
			if(empty($_POST["lastname"])) { 
				$lastname_error = "Ei tohi olla tühi";
			} else {
				$lastname = cleanInput($_POST["lastname"]);
			
			}
			
			
			if(	$email_2_error == "" && $password_2_error == "" && $username_error == "" && $firstname_error == "" && $lastname_error == ""){
				echo hash("sha512", $password_2);
				echo " Võib kasutaja luua. Email on ".$email_2." ja parool on ".$password_2.". Kasutajanimi on ".$username.". Eesnimi on ".$firstname.". Perenimi on ".$lastname.".";
			
				$hash = hash("sha512", $password_2);
				
				$stmt = $mysqli->prepare("INSERT INTO `if15_rasmrei`.`users` (`id`, `email`, `password`, `username`, `firstname`, `lastname`) VALUES ('?', '?', '?', '?', '?', '?');");
		
				$stmt->bind_param("sssss", $email_2, $password, $username, $firstname, $lastname);
					
			
				$stmt->execute();
				$stmt->close();
					
			}
			
		}
			
	}	
     
	
		
	function cleanInput($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
	}
	
?>

<?php

 $page_title = "Login page";
 $page_file_name = "login.php"

?>

<?php require_once("../header.php"); ?>

  <h2>Logi sisse</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post"?>
  	<input name="email" type="email" placeholder="E-post"><?php echo $email; ?> <?php echo $email_error; ?><br><br>
  	<input name="password" type="password" placeholder="Parool"> <?php echo $password_error; ?><br><br>
  	<input name="Login" type="submit" value="Logi sisse">
  </form>
<h2>Loo kasutaja</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<input name="email_2" type="email" placeholder="E-post"> <?php echo $email_2_error;?><br><br>
  	<input name="password_2" type="password" placeholder="Parool"> <?php echo $password_2_error; ?> <br><br>
	<input name="create_username" type="text" placeholder="Kasutajanimi"> <?php echo $create_username_error; ?><br><br>
	<input name="firstname" type="text" placeholder="Eesnimi" > <br><br>
	<input name="lastname" type="text" placeholder="Perenimi" > <br><br>
  	<input name="create" type="submit" value="Loo kasutaja">
  </form>
  
  <?php
		require_once("../footer.php"); 
?>
		