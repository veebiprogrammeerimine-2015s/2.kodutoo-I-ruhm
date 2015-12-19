<?php

    require_once("../config_global.php");
    $database = "if15_kristalv";
    
    session_start();
    
    
    function logInUser($email, $hash){
        
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        
        $stmt = $mysqli->prepare("SELECT email, password FROM user_sample WHERE email=? AND password=?");
        $stmt->bind_param("ss", $email, $hash);
        $stmt->bind_result($email_from_db, $password_from_db);
        $stmt->execute();

        if($stmt->fetch()){
            echo "Kasutaja ".$email_from_db." on sisse logitud.";
            
            $_SESSION['logged_in_user_username'] = $email_from_db;
            $_SESSION['logged_in_user_password'] = $password_from_db;
            
            
        }else{
            echo "Kontrolli kasutajanime ja parooli!";
        }
        $stmt->close();
        
        $mysqli->close();
        
    }
    
    
    function createUser($create_firstname, $create_lastname, $create_phone, $create_email, $hash){
        
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);

        $stmt = $mysqli->prepare("INSERT INTO user_sample (firstname, lastname, phone, email, password) VALUES (?,?,?,?,?)");
		echo $mysqli->error;
        $stmt->bind_param("sssss", $create_firstname, $create_lastname, $create_phone, $create_email, $hash);
        $stmt->execute();
		
		echo "Kasutaja loodud! Kasutajanimi on ".$create_email;
        
		$stmt->close();
        $mysqli->close();
        
    }
?>