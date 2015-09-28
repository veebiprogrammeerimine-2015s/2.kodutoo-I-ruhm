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

  // muutujad väärtuste jaoks
	$email = "";
	$password = "";
	$create_email = "";
	$create_password = "";
	
	

	
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
?>
<?php
	// lehe nimi
	$page_title = "Logi sisse";
	
	// faili nimi
	$page_file_name = "login.php";

?>
<?php require_ONCE("../header.php"); ?>	
	
		<h2>Login</h2>
		<form action="login.php" method="post">
			<input name="email" type="email"  placeholder="e-post@kool.ee"> <?php echo $email_error; ?> <br> <br>
			<input name="password" type="password"  placeholder="parool"> <?php echo $password_error; ?> <br> <br>
		<form>
			<input type="submit" value="Logi sisse">
		
		<h2>Create user</h2>
				
		<form action="login.php" method="post">
			<input name="name" type="text"  placeholder="Eesnimi Perenimi"> <br> <br>
			<input name="email" type="email"  placeholder="e-post@kool.ee"> <?php echo $email_error; ?> <br> <br>
			<input name="password" type="password"  placeholder="parool"> <?php echo $password_error; ?> <br> <br>
		<form>
			<input type="submit" value="Loo kasutaja"> <br><br>
			
			<?php require_ONCE("../footer.php"); ?>	
	</body>

</html>