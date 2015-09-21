<?php

	//loome AB ühenduse
    require_once("../../config.php");
    $database = "if15_merit26_1";
    $mysqli = new mysqli($servername, $username, $password, $database);
    
    //check connection
    if($mysqli->connect_error) {
        die("connect error ".mysqli_connect_error());
	}
	
	// muuutujad errorite jaoks
	$email_error = "" ;
	$password_error = "" ;
	
	$email_2_error = "" ;
	$password_2_error = "" ;
	$comment_error = "" ;
	$comment_2_error = "" ;
	
      //Muutujad väärtuste jaoks
	 $email = "";
	 $password = "";
	 $email_2 = "";
	 $password_2 = "";
	 $comment = "";
	 $comment_2 = "";
	 
	// kontrolli ainult siis, kui kasutaja vajutab "logi sisse" nuppu
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		
		//kontrollin kas muutuja $_POST["login"] ehk kas inimene tahab sisse logida
		if(isset($_POST["login"])){
			
			//kontrollime, et e-post ei oleks tühi		
			if(empty($_POST["email"])) { 
				$email_error = "Ei saa olla tühi";
			} else {
				//annan väärtuse
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

				$stmt = $mysqli->prepare("SELECT id, email FROM MINU ANDMEBAAS WHERE email=? AND password=?");
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
					echo "Valed andmed!";
				}
				
				$stmt->close();
               
			} 
		
		
		
		
		
		
		
		
		} elseif(isset($_POST["create"])) {
		
			if(empty($_POST["email_2"])) { 
				$email_2_error = "Ei saa olla täitmata";
			} 	else {
				// siin on puudu
			}
			
			if(empty($_POST["password_2"])) { 
				$password_2_error = "Ei saa olla täitmata";
		    } else {
				if(strlen($_POST["password_2"]) < 8) {
					$password_2_error = "Peab olema vähemalt 8 tähemärki pikk!";
				}else{
					$password_2 = cleanInput($_POST["password_2"]);
				}
			}
					
			if(empty($_POST["comment"])) { 
				$comment_error = "Ei saa olla tühi";
			} else {
				$comment = cleanInput($_POST["comment"]);
			}
			
			if(empty($_POST["comment_2"])) { 
				$comment_2_error = "Ei saa olla tühi";
			} else {
				$comment_2 = cleanInput($_POST["comment_2"]);
			}
			
			
			
			
			if(	$email_error_2 == "" && $password_error_2 == "" && $comment_error == "" && $comment_2_error == ""){
				echo hash("sha512", $password_2);
				echo "Kasutaja loomine. Kasutajanimi on ".$email_2." ja parool on ".$password_2."vanus on ".$comment." sugu on".$comment_2;
			
				$hash = hash("sha512", $password_2);
				
				$stmt = $mysqli->prepare("INSERT INTO ANDMEBAASI NIMI (email, password, comment, comment_2) VALUES (?,?,?,?)");
		
				$stmt->bind_param("ssss", $email_2, $hash, $comment, $comment_2); //iga string on s
					
				//käivitab sisestuse
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
 //lehe nimi
 $page_title = "Login leht";
 // faili nimi
 $page_file_name = "login.php"

?>
<?php require_once("../header.php"); ?>
	
		<h2>Login</h2>

	    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"?>
			<input name="email" type="email" placeholder="E-post">*<?php echo $email_error; ?><br><br>
			<input name="password" type="password" placeholder="parool">*<?php echo $password_error; ?><br><br>		
			<input name="login" type="submit" value="logi sisse"> 
		</form>
		
		<h2>Create user</h2>
	        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"?>
			<input name="email_2" type="email" placeholder="E-post">*<?php echo $email_2_error; ?><br> <br>
			<input name="password_2" type="password" placeholder="parool">*<?php echo $password_2_error; ?> <br> <br>
			<input name="comment" type="text" placeholder="vanus"> <br> <br> 
			<input name="comment_2" type="text" placeholder="sugu mees/naine"> <br> <br> 
			
			<textarea name="comment_3" type="text" cols= "60" rows= "5"> Enda tööks planeerin trennipäeviku koostamise. Tegemist võiks olla sellise asjaga, kuhu inimene kirjutab, et mis päevadel ja mida ta täpselt tegi. Andmete põhjal saaks siis teha erinevaid arvutusi ja järeldusi.</textarea> <br> <br>
			

			<input name="create" type="submit" value="loo kasutaja"> 
		</form>	
		
		
		
<?php
		//laeme footer.php faili sisu
		require_once("../footer.php"); 
?>
		