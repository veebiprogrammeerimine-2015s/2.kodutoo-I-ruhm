<?php

	/*  
    // config_global.php
    $servername = "";
    $server_username = "";
    $server_password = "";
    */
	
	//db ühendus
	require_once("../config_global.php");
	$database = "if15_kelllep";

	session_start();
	
	function logInUser($email, $username, $hash){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, email FROM user_db WHERE email=? AND password=?");
        $stmt->bind_param("ss", $email, $hash);
        $stmt->bind_result($id_from_db, $email_from_db);
        $stmt->execute();
        if($stmt->fetch()){
            echo "Kasutaja logis sisse id=".$id_from_db;
			
			// sessioon, salvestatakse serveris
            $_SESSION['logged_in_user_id'] = $id_from_db;
            $_SESSION['logged_in_user_email'] = $email_from_db;
            
			//suuname kasutaja teisele lehel
            header("Location: data.php");
			
                }else{
                    echo "Vale e-mail või parool!";
                }
                
                $stmt->close();
				//echo $stmt->error;
                //echo $mysqli->error;
		
	}
	
	function createUser($new_email, $hash, $new_username){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO user_db (email, password, username) VALUES (?,?,?)");
		$stmt->bind_param("sss", $new_email, $hash, $new_username);
		$stmt->execute();
		$stmt->close();
                
        $mysqli->close();
            
		
	}

	

?>