<?php

	//loome ühenduse andmebaasiga
	require_once("../../config.php");
	$database = "if15_rasmrei";
	$mysqli = new mysqli($servername, $username, $password, $database);
	
	// check connection
	if($mysqli->connect_error) {
		die("connect error".mysqli_connect_error());		
	}
	

	
	//jutumärkide vahele input elemndi NAME
	//echo $_POST["email"];
	//echo $_POST["password"];
	
	// muuutujad errorite jaoks
	$email_error = "";
	$password_error = "";
	$create_email_error = "";
	$create_password_error = "";
	$create_username_error = "";

  // muutujad väärtuste jaoks
	$email = "";
	$password = "";
	$create_email = "";
	$create_password = "";
	$create_username = "";
	
	
	
	

	// Kontrolli ainult siis kui kasutaja vajutab logi sisse nuppu
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		
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
				echo "Võib sisse logida! Kasutajanimi on ".$email." ja parool on ".$password;
			
                $hash = hash("sha512", $password);
                
                $stmt = $mysqli->prepare("SELECT id, email FROM user_sample WHERE email=? AND password=?");
                // küsimärkide asendus
                $stmt->bind_param("ss", $email, $hash);
                //ab tulnud muutujad
                $stmt->bind_result($id_from_db, $email_from_db);
                $stmt->execute();
                
                // teeb päringu ja kui on tõene (st et ab oli see väärtus)
                if($stmt->fetch()){
                    
                    // Kasutaja email ja parool õiged
                    echo "Kasutaja logis sisse id=".$id_from_db;
                    
                }else{
                    echo "Wrong credentials!";
                }
                
                $stmt->close();
                
            
            
            }
		}
	}
	 if(isset($_POST["create"])){
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
				if ( empty($_POST["create_username"]) ) {
					$create_username_error = "Tuleb valida endale nimi";
			}else{
						$create_username = cleanInput($_POST["create_username"]);
					}
			}
			if(	$create_email_error == "" && $create_password_error == "" && $create_username_error == ""){
				echo hash("sha512", $create_password, $create_username);
                echo "V6ib kasutajat luua! email on ".$create_email."parool on ".$create_password."ja kasutaja on".$create_username;
                // tekitab parooliräsi
                $hash = hash("sha512", $create_password);
                //salvestan andmebaasi
                $stmt = $mysqli->prepare("INSERT INTO users (email, password, username) VALUES (?,?,?)");
                //kirjutan välja error
                // ss - s string, iga muutuja koht 1 täht
                $stmt->bind_param("sss", $create_email, $hash, $create_username);
                //käivitab sisestuse
                $stmt->execute();
                $stmt->close();
            }
        } // create if end
	}
  // eemaldab kõikvõimaliku üleliigse tekstist
  function cleanInput($data) {
  	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);
  	return $data;
  }
  $mysqli->close();

?>
<?php
	// lehe nimi
	$page_title = "Logi sisse";
	
	// faili nimi
	$page_file_name = "login.php";

?>
<?php require_ONCE("../header.php"); ?>	
	
		<h2>Login</h2>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
			<input name="email" type="email"  placeholder="e-post@kool.ee"> value="<?php echo $email; ?>"> <?php echo $email_error; ?><br><br>
			<input name="password" type="password"  placeholder="parool"> value="<?php echo $password; ?>"> <?php echo $password_error; ?><br><br>
			<input type="submit" value="Logi sisse">
		</form>
			
		
		<h2>Create user</h2>
				
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
			<input name="name" type="text"  placeholder="Eesnimi Perenimi"> <br> <br>
			<input name="email" type="email"  placeholder="e-post@kool.ee"> <?php value="<?php echo $create_email; ?>"> <?php echo $create_email_error; ?><br><br>
			<input name="password" type="password"  placeholder="parool"> <?php echo $password_error; ?> <br> <br>
			<input type="submit" name="create" value="Loo kasutaja">
		</form>
			
			<?php require_ONCE("../footer.php"); ?>	
	</body>

</html>