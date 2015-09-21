<?php

	//loome AB ühenduse
	require_once("../../config.php");
	$database = "if15_naaber";
	$mysqli = new mysqli($servername, $username, $password, $database);
	
	//check connection
	if ($mysqli->connect_error) {
		die("connect error ".mysqli_connect_error());
	}
	
	//jutumärkide vahele input elemendi NAME
	//echo $_POST["email"];
	//echo $_POST["password"];
	
	$email_error = "";
	$password_error = "";
	
	//muutujad väärtustega
	$email = "";
	$password = "";
	
    // kontrolli ainult siis kui kasutaja vajutab logi sisse nuppu
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        
        // kontrollin kas muutuja $_POST["login"], ehk login nupp
        if(isset($_POST["login"])){
            
            //Kontrollime kasutaja e-posti, et see ei ole tühi
            if(empty($_POST["email"])) {
                $email_error = "Ei saa olla tühi";
            } else {
                
                // annan väärtuse
                $email = cleanInput($_POST["email"]);
				
                
            }
            
            // Kontrollime parooli
            if(empty($_POST["password"])) {
                $password_error = "Ei saa olla tühi";
            } else {
                $password = cleanInput($_POST["password"]);
            }
            
            if($password_error == "" && $email_error == ""){
                // erroreid ei olnud
                echo "Võib sisse logida! Kasutajanimi on ".$email." ".$password;
				
				$hash = hash("sha512", $password);
                
                $stmt = $mysqli->prepare("SELECT id, email FROM users_naaber WHERE email=? AND password=?");
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
	
	function cleanInput($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
?>
<?php

	//lehe nimi
	$page_title = "Login";
	
	//faili nimi
	$page_file = "login.php";
	
?>
<?php require_once("../header.php"); ?>
		<h2>Login</h2>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			<input name="email" type="email" placeholder="E-post" value ="<?php echo $email; ?>">* <?php echo $email_error; ?> <br><br>
			<input name="password" type="password" placeholder="Parool">* <?php echo $password_error; ?> <br><br>
		
			<input name="login" type="submit" value="Logi sisse">
		</form>
<?php require_once("../footer.php"); ?>