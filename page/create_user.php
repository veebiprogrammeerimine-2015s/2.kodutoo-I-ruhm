<?php	
	$create_user_email_error = "";
	$create_user_password_error = "";
	$first_name_error = "";
	$last_name_error = "";
	
	$create_user_email = "";
	$create_user_password = "";
	$first_name = "";
	$last_name = "";
	
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		
		if(isset($_POST["create_user"])){

			if(empty($_POST["create_user_email"])) {
				$create_user_email_error = "Ei saa olla tühi";
			} else {
				$create_user_email = test_input($_POST["create_user_email"]);
			}
			
			if(empty($_POST["create_user_password"])) {
				$create_user_password_error = "Ei saa olla tühi";
			} elseif(strlen($_POST["create_user_password"]) < 8) {
					$create_user_password_error = "Peab olema vähemalt 8 sümbolit pikk";
			} else {
				$create_user_password = test_input($_POST["create_user_password"]);
			}
			
			if(empty($_POST["first_name"])) {
				$first_name_error = "Ei saa olla tühi";
			} else {
				$first_name = test_input($_POST["first_name"]);
			}
			
			if(empty($_POST["last_name"])) {
				$last_name_error = "Ei saa olla tühi";
			} else {
				$last_name = test_input($_POST["last_name"]);
			}
			
			if($create_user_password_error == "" && $create_user_email_error == "" && $first_name_error == "" && $last_name_error == ""){
				echo "Kontrollin ".$first_name." ".$last_name." ".$create_user_email." ".$create_user_password;
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
	
	$page_title = "Create User";
	$page_file = "create_user.php"
	
?>
<?php require_once("../header.php"); ?>
		<h2>Create user</h2>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			<input name="first_name" type="text" placeholder="Eesnimi" value="<?php echo $first_name; ?>">* <?php echo $first_name_error; ?> <br><br>
			<input name="last_name" type="text" placeholder="Perekonnanimi" value="<?php echo $last_name; ?>">* <?php echo $last_name_error; ?> <br><br>
			<input name="create_user_email" type="email" placeholder="E-post" value="<?php echo $create_user_email; ?>">* <?php echo $create_user_email_error; ?> <br><br>
			<input name="create_user_password" type="password" placeholder="Parool">* <?php echo $create_user_password_error; ?> <br><br>
			
			<input name ="create_user" type="submit" value="Loo kasutaja">
		</form>
<?php require_once("../footer.php"); ?>