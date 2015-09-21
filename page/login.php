<?php
    //loome AB ühenduse
    require_once("../../config.php");
    $database ="if15_klinde";
    $mysqli= new mysqli($servername, $username, $password, $database);
    
    //check connection
    if($mysqli->connect_error){
        die("connect error ".mysqli_connect_error());
    }

    
    //ERRORid
    
    $email_error="";
    $password_error="";
	$password1_error="";
	$firstname_error="";
	$lastname_error="";
	$email2_error="";
	
    //Muutujad väärtustega
    $email = "";
    $password ="";
    $password1="";
    $firstname="";
    $lastname="";
    $email2="";
    
      
    //Kontrolli ainult siis, kui kasutaja vajutab logi sisse nuppu
    if($_SERVER["REQUEST_METHOD"] == "POST"){      //kasutaja vajutas nuppu
    
        //kontrollin, kas muutuja $_POST["login"] on olemas, ehk login nuppu
        if(isset($_POST["login"])){
                //Kontrollime kasutaja e-post, et see ei ole tühi
            if(empty($_POST["email"])){
                $email_error ="Ei saa olla tühi";
            }else{
                //annan väärtuse
                $email = test_input($_POST["email"]);            
            }
            
            //Kontrollime parooli
            if(empty($_POST["password"])){
                $password_error="Ei saa olla tühi";
            } else{
                $password=test_input($_POST["password"]);
            }
            
            if($password_error == "" && $email_error == ""){
                //erroreid ei olnud
                echo "Võib sisse logida! ".$email." ".$password;
                
                $hash = hash("sha512", $password);
                $stmt = $mysqli->prepare("SELECT id, email FROM users WHERE email=? AND password=?");
                //küsimärkide asendus
                
                
                $stmt->bind_param("ss", $email. $hash);
                //andmebaasist tulnud muutujad
                $stmt->bind_result($id_from_db, $email_from_db);
                $stmt->execute();
                
                //teeb päringu ja kui on tõene, st oli see olemas
                if($stmt->fetch()){
                //kasutaja ja parool õiged
                    echo "Kasutaja logis sisse ".$id_from_db;
                }else{
                    echo "Wrong credentials!";
                }
                    
                $stmt->close();
            }
            
            
        }elseif(isset($_POST["create"])){
        
            
            if(empty($_POST["firstname"])){
                $firstname_error="Kohustuslik väli";
            }else{
                //annan väärtuse
                $firstname = test_input($_POST["firstname"]);            
            }
            if(empty($_POST["lastname"])){
                $lastname_error="Kohustuslik väli";
            }else{
                //annan väärtuse
                $lastname = test_input($_POST["lastname"]);            
            }
            if(empty($_POST["email2"])){
                $email2_error="Kohustuslik väli";
            }else{
                //annan väärtuse
                $email2 = test_input($_POST["email2"]);            
            }
            if(empty($_POST["password1"])){
                $password1_error="Ei saa olla tühi";
            }else{
                
                //parool ei ole tühi, kontrollime pikkust
                if(strlen($_POST["password1"]) < 8){
                    $password1_error="Peab olema vähemalt 8 sümbolit";
                    
                }else{
                //annan väärtuse
                $password1 = test_input($_POST["password1"]);            
            }
                
            }
      
            }
                        
            if($firstname_error == "" && $lastname_error == "" && $email2_error == "" && $password1_error == "" ){
                
                echo hash ("sha512", $password1);
                echo "Võib kasutaja luua! Kasutaja nimi on ".$email2." ja parool on ".$password1." Nimi on ".$firstname;
                
                 //tekitan parooliräsi
                $hash=hash("sha512", $password1);
                
                //salvestan andmebaasi
                $stmt = $mysqli->prepare("INSERT INTO users (firstname, lastname, email2, password1) VALUES (?,?,?,?)");
                
                //kirjutan välja errori
                //echo $stmt-> error;
                //echo $mysqli-> error;
                
                //paneme muutujad küsimärkide asemel
                //ss - string, iga muutuja kohta üks täht 
                $stmt->bind_param("ssss", $firstname, $lastname, $email1, $hash);
                
                
                
                //käivitab sisestuse
                $stmt->execute();
                $stmt->close();
            }
            
        }
        
    
    function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
    }
    
    //paneme ühenuduse kinni 
    $mysqli->close();
       
?> 

<?php
    //lehe nimi
    $page_title="Login leht";
    
    //faili nimi
    $page_file_name="login.php";
?>
    
<?php
    require_once("../header.php");
?>
		<p>Tegemist on e-poega, kus on võimalik soetada erinevate jooksuürituste pääsmeid.</p>
        <h2>Login</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input name="email" type="email" placeholder="E-post" value="<?php echo $email; ?>">* <?php echo $email_error;?> <br><br>
        <input name="password" type="password" placeholder="Parool">* <?php echo $password_error;?> <br><br>
        <input name= "login"type="submit" value="Login">
        </form>
        
        <h2>Create user</h2>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="text" name="firstname" placeholder="Eesnimi" value="<?php echo $firstname; ?>">* <?php echo $firstname_error;?><br><br>
		<input type="text" name="lastname" placeholder="Perenimi" value="<?php echo $lastname; ?>">*<?php echo $lastname_error;?><br><br>
		<input type="email" name="email2" placeholder="E-post" value="<?php echo $email2; ?>">*<?php echo $email2_error;?><br><br>
		<input type="password" name="password1" placeholder="Parool" value="<?php echo $password1; ?>">*<?php echo $password1_error;?><br><br>
		<input type="submit" name="create" value="Create">
		
		</form>
<?php
    require_once("../footer.php");
?>