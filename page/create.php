<?php 
	$page_title = "Register";
	$page_file_name = "create.php";
?>
<?php 
// ühenduse loomiseks kasuta
	require_once("../../config.php");
	$database = "if15_joosjoe";
	$mysqli = new mysqli($servername, $username, $password, $database);
	
	//Check Connection
	if($mysqli ->connect_error) {
		die("Connect error".mysqli_connect_error() );
			
	}
	//paneme ühenduse kinni
	function cleanInput($data) {
  	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);
  	return $data;
  }
$email_error = "";
$pw_error = "";
$gender_error = "";
$email = "";
	if (isset($_POST["create"]) ){
						
	//kontrollime eposti et poleks tühi
	
				if(empty($_POST["email"])){
					$email_error = "Insert e-mail";
				} else {
					$email = cleanInput($_POST["email"]);
				}
				if(empty($_POST["password"])){
					$pw_error = "Insert password";
				} else {
					//kontrollime pikkust
				if(strlen($_POST["password"]) < 8){
					$pw_error = "Has to be atleast 8 characters";
					}else{
					$password = cleanInput($_POST["password"]);
				}
			}
			if ($_POST["gender"]){
					$gender = cleanInput($_POST["gender"]);
				}
			if ($_POST["First_name"]){
					
					$First_name = cleanInput($_POST["First_name"]);
				}
			if ($_POST["Last_name"]){
					$Last_name = cleanInput($_POST["Last_name"]);
				}
			if ($_POST["Address"]){
					$Address = cleanInput($_POST["Address"]);
				}
			
			if(	$email_error == "" && $pw_error == ""){
				echo "User can be created. Username is ".$email." and password is ".$password;
				$hash = hash("sha512", $password);
	
				$stmt=$mysqli->prepare("INSERT INTO user(email, password,gender,first_name,last_name,address) VALUES (?,?,?,?,?,?)");
				echo $mysqli->error;
				$stmt->bind_param("ssssss", $email, $hash, $gender, $First_name, $Last_name, $Address);
				
				$stmt->execute();
				
				$stmt->close();
	  }

		}
	?>
	<?php require_once("../header.php");?>
<!--<link rel="stylesheet" href="styles.css">-->
		<div class="center">

			<p style="font-size:30px";>Create user</p>
			<form action="create.php" method="post">
			
				<p>Email/Username</p>
				<input name="email" type="email" placeholder="@example.com" value="<?php echo $email;?>" >* <?php echo $email_error;?> 
				
				<p>Password</p>
				<input name="password" type="password" placeholder="Parool" >* <?php echo $pw_error;?>
				<br>
				<p>Gender</p>
				<select name="gender" style="width:173px;"> 
					<option value="0">Male</option> 
					<option value="1">Female</option>  
				</select> <?php echo $gender_error;?> 
				<br>
				<p>First name</p>
				<input name="First_name" type="text" placeholder="example: John" >
				<br>
				<p>Last name</p>
				<input name="Last_name" type="text" placeholder="example: Doe" >
				<br>
				<p>Address</p>
				<input name="Address" type="text" placeholder="example: Harjumaa" >
				<br><br>
				
				<input name="create" type="submit" value="Create User">
				
			</form>	
			</div>
			
<?php require_once("../footer.php"); ?>