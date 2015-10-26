<?php
$page_title = "login";
$page_file_name = "login.php";
require_once("header.php"); 
require_once("../config_global.php");
	$database = "if15_ole";	

	
function cleanInput($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
 }
  
//Errorid & muutujad
	$email = "";
	$password = "";
	$email_error = "";
	$password_error = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {

if(isset($_POST["login"])){

	if ( empty($_POST["email"]) ) {
		$email_error = "See väli on kohustuslik";
	}else{
		$email = cleanInput($_POST["email"]);
	}
	if ( empty($_POST["password"]) ) {
		$password_error = "See väli on kohustuslik";
	}else{
		$password = cleanInput($_POST["password"]);
	}
		
	if($password_error == "" && $email_error == ""){
		$password_hash = hash("sha512", $password);
		
	$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT id, email FROM user_sample WHERE email=? AND password=?");
	$stmt->bind_param("ss", $email, $password_hash);
	$stmt->bind_result($id_from_db, $email_from_db);
	$stmt->execute();
		if($stmt->fetch()){
			echo "kasutaja id=".$id_from_db;
			
			
		$_SESSION["id_from_db"] = $id_from_db;
		$_SESSION["user_email"] = $email_from_db;
			header("Location: data.php");
		}else{
			echo "Wrong password or email!";
		}
		$stmt->close();
		$mysqli->close();
	}


}
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
<body>
<html>