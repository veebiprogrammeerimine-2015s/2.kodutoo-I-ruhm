<?php
    //loome AB ühenduse
		require_once("../config.php");
		$database = "if15_raiklep";
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
  // muutujad väärtuste jaoks
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
		} // login if end
    // *********************
    // ** LOO KASUTAJA *****
    // *********************
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
			}
			if(	$create_email_error == "" && $create_password_error == ""){
				echo hash("sha512", $create_password);
                echo "Võib kasutajat luua! Kasutajanimi on ".$create_email." ja parool on ".$create_password;
                
                // tekitan parooliräsi
                $hash = hash("sha512", $create_password);
                
                //salvestan andmebaasi
                $stmt = $mysqli->prepare("INSERT INTO user_sample (email, password) VALUES (?,?)");
                
                //kirjutan välja error
                //echo $stmt->error;
                //echo $mysqli->error;
                
                // paneme muutujad küsimärkide asemel
                // ss - s string, iga muutuja koht 1 täht
                $stmt->bind_param("ss", $create_email, $hash);
                
                //käivitab sisestuse
                $stmt->execute();
                $stmt->close();
                
                
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
   
  
  // paneme ühenduse kinni
  $mysqli->close();
  
?>		
	<?php require_once("../header.php"); ?>
		<h4>See veebileht on loodud selleks, et tellida endale omapärased prillid, mis sobiksid vastavalt inimese peakujuga ja oleksid sobiva hinnaga.</h4>
		<h4>Lähemalt tutvimiseks minge sellele leheküljele : http://evoklaas.blogspot.com.ee/ </h4>
		<h4>Facebookist leiate meid leheküljelt : https://www.facebook.com/EVOGlasses?fref=ts </h4>
		
				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
				
				<input name="email" type="email" placeholder="Email" value="<?php echo $email; ?>">* <?php echo $email_error; ?> <br> <br> 
				<input name="password" type="password" placeholder="Password">* <?php echo $password_error; ?>	<br> <br>	
				<input name="login" type="submit" value="log in">
				</form>
				<h2>Sign up</h2>
				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
				
				
				<input name="test" type="text" placeholder="age">* <br> <br>
				<input name="id_number" type="text" placeholder="Email">*  <br><br>
				<input name="test" type="text" placeholder="Password">* <br> <br>
			Gender:
			<input type="radio" name="gender"
			<?php if (isset($gender) && $gender=="female") echo "checked";?>
			value="female">Female
			<input type="radio" name="gender"
			<?php if (isset($gender) && $gender=="male") echo "checked";?>
			value="male">Male	<br> <br>
		
		<input name="sign_up" type="submit" value="sign up">	
			</form>
	<?php require_once("../footer.php"); ?>