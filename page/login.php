<?php 
	// user_form.php
	
	//db ühendus
	require_once("../../config.php");
	$database = "if15_kelllep";
	$mysqli = new mysqli($servername, $username, $password, $database);
	
	if($mysqli->connect_error) {
		die("connect error ".mysqli_connect_error());		
	}
	
	//ERRORid
	$email_error = "";
	$password_error = "";
		
	//muutujad väärtustega
	$email = "";
	$password = "";
	
	
	//Kontrolli ainult siis kui kasutaja vajutab logi sisse nuppu
	if($_SERVER["REQUEST_METHOD"] == "POST") {
	
		// kontrollin kas muutuja $_POST ["login"], ehk login nupp
		if(isset($_POST["login"])) {
			
			
			//Kontrollime kasutaja e-posti, et see ei ole tühi
			if(empty($_POST["email"])) {
				$email_error = "ei saa olla tühi";
			} else {
				//annan väärtuse
				$email = test_input($_POST["email"]);
			}	
		
			//Kontrolli parooli
			if(empty($_POST["password"])) {
				$password_error = "sisesta parool";
			} else {
				$password = test_input($_POST["password"]);
			}

			if($password_error == "" && $email_error == ""){
				//erroreid ei olnud
				echo "Kontrollin ".$email." ".$password;
		
		 $hash = hash("sha512", $password);
                
                $stmt = $mysqli->prepare("SELECT id, email FROM user_db WHERE email=? AND password=?");
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
				//echo $stmt->error;
                //echo $mysqli->error;
           	}
			
		}  
            
            
		
	}
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
		
	}
			
?>

<?php
	//lehe nimi
	$page_title = "Login leht";
	
	//faili nimi
	$page_file_name = "login.php";
	
?>
<?php require_once("../header.php"); ?>
	
		<h2>Logi sisse</h2>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
			<input name="email" type= "email"  placeholder="E-post" value="<?php echo $email; ?>" >* <?php echo $email_error; ?> <br> <br>
			<input name="password" type= "password"  placeholder="Parool" >* <?php echo $password_error; ?> <br> <br>
			<input name ="login" type="submit" value= "Logi sisse"> 
		</form>
		
		<h4>Ei ole veel kasutajat? <a href="create_new_user.php">Loo uus kasutaja</a></h4>
		
	
<?php require_once("../footer.php"); ?>  