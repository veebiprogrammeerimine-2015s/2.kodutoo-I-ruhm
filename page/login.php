<?php

	// user_form.php
	
	//jutumärkide vahele input elemendi NAME
	//echo $_POST["email"]; 
	//echo $_POST["password"];
	//echo $_POST["comment"];
	
	$email_error = "" ;
	$password_error = "" ;
	$comment_error = "" ;
	$email_2_error = "" ;
	$password_2_error = "" ;
      //Muutujad väärtustega
	 $email = "";
	 $password = "";
	 $comment = "";
	// kontrolli ainult siis, kui kasutaja vajutab "logi sisse" nuppu
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		
		//kontrollin kas muutuja $_POST["login"] ehk kas inimene tahab sisse logida
		if(isset($_POST["login"])){
			
			//kontrollime, et e-post ei oleks tühi		
			if(empty($_POST["email"])) { 
				$email_error = "Ei saa olla tühi";
			} else {
				
				//annan väärtuse
				$email = test_input($_POST["email"]);
				
			}
		
			//kontrollime parooli	
			if(empty($_POST["password"])) { 
				$password_error = "Ei saa olla tühi";
			} else { 
			  $password = test_input($_POST["password"]);
			}
		  
			//if(empty($_POST["comment"])) { 
				//$comment_error = "Ei saa olla tühi";
			//} else {
			//	$comment = test_input($_POST["comment"]);
			//}



		} elseif(isset($_POST["create"])){
		
		if(empty($_POST["email_2"])) { 
			$email_2_error = "Ei saa olla täitmata";
		} 	else {
		}
			if(empty($_POST["password_2"])) { 
			$password_2_error = "Ei saa olla täitmata";
		
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
			<input name="comment" type="text" placeholder="comment"> <br> <br> 
			<textarea name="comment1" type="text" cols= "40" rows= "5" placeholder="see võib tühi ka olla"></textarea> <br> <br>
			<textarea name="comment2" type="text" cols= "60" rows= "5"> Enda tööks planeerin trennipäeviku koostamise. Tegemist võiks olla sellise asjaga, kuhu inimene kirjutab, et mis päevadel ja mida ta täpselt tegi. Andmete põhjal saaks siis teha erinevaid arvutusi ja järeldusi.</textarea> <br> <br>
			<input name="option1" type="checkbox" value="o1"> Sain aru. <br>
			<input name="option2" type="checkbox" value="o2"> Oskasin laadida githubi. <br>

			<input name="create" type="submit" value="loo kasutaja"> 
		</form>	
		
		
		
<?php
		//laeme footer.php faili sisu
		require_once("../footer.php"); 
?>
		