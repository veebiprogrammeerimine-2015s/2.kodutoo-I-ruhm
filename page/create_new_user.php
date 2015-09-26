<?php 
	// create_new_user.php
	
	//loome db ühenduse
	require_once("../../config.php");
	$database = "if15_kelllep";
    $mysqli = new mysqli($servername, $username, $password, $database);
	
	//check connection
    if($mysqli->connect_error) {
        die("connect error ".mysqli_connect_error());
    }
	
	//ERRORid
	$new_username_error = "";
	$new_email_error = "";
	$new_password_error = "";
	
	//muutujad väärtustega
	$new_username = "";
	$new_email = "";
	$new_password = "";
	
	
	
	if($_SERVER["REQUEST_METHOD"] == "POST") {
	
		// kontrollin kas muutuja $_POST ["create"], ehk create nupp
		if(isset($_POST["create"])) {
		
		
			//Kontrollime kasutaja e-posti, et see ei ole tühi
			if(empty($_POST["new_email"])) {
				$new_email_error = "ei saa olla tühi";
			} else {
				//annan väärtuse
				$new_email = test_input($_POST["new_email"]);
			}
				
		
			//Kontrolli parooli
			if(empty($_POST["new_password"])) {
				$new_password_error = "sisesta parool";
			} else {
				$new_password = test_input($_POST["new_password"]);
			
				//Parool ei ole tühi, kontrollime pikkust
				if(strlen($_POST["new_password"]) < 8 ){
				
					$new_password_error = "Peab olema vähemalt 8 sümbolit pikk";
				}
		}	
		
			if(	$new_email_error == "" && $new_password_error == ""){
				echo hash("sha512", $new_password);
				echo "Võib kasutajat luua! Kasutajanimi on ".$new_email." ja parool on ".$new_password;
                
        // tekitan parooliräsi
		$hash = hash("sha512", $new_password);
                
        //salvestan andmebaasi
		$stmt = $mysqli->prepare("INSERT INTO user_db (email, password) VALUES (?,?)");
                
                //kirjutan välja error
                //echo $stmt->error;
                //echo $mysqli->error;
                
        // paneme muutujad küsimärkide asemel
        // ss - s string, iga muutuja koht 1 täht
		$stmt->bind_param("ss", $new_email, $hash);
			
	                
        //käivitab sisestuse
		$stmt->execute();
		$stmt->close();
                
                
            }
			
			
				//ega nimi ei ole tühi
				if (empty($_POST["new_username"])) {
					$new_username_error = "Palun sisesta kasutajanimi";
					} else {
				//annan väärtuse
				$new_username = test_input($_POST["new_username"]);
				}
				
		$stmt = $mysqli->prepare("INSERT INTO user_db (username) VALUES (?)");
		$stmt->bind_param("s", $new_username);
				
		$stmt->execute();
		$stmt->close();
			
		}
		}
		
	// funktsioon, mis eemaldab kõikvõimaliku üleliigse tekstist
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
		
	}
		
			
	// paneme ühenduse kinni
	  $mysqli->close();
	
?>

<?php
	//lehe nimi
	$page_title = "Uue kasutaja loomine";
	
	//faili nimi
	$page_file_name = "create_new_user.php";
	
?>
<?php require_once("../header.php"); ?>

		<h2>Loo uus kasutaja</h2>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			Sisesta E-posti aadress: <input name="new_email" type= "email"  placeholder="E-post" value="<?php echo $new_email; ?>" >* <?php echo $new_email_error; ?> <br> <br>
			Sisesta parool: <input name="new_password" type= "password"  placeholder="Parool" >* <?php echo $new_password_error; ?> <br> <br>
			Kasutajanimi: <input name="new_username" type= "text"  placeholder="kasutajanimi" value="<?php echo $new_username; ?>" >* <?php echo $new_username_error; ?> <br> <br>
		
			<input name="create" type ="submit" value="Loo kasutaja"> 
			
		</form>
		
			
<?php require_once("../footer.php"); ?>  