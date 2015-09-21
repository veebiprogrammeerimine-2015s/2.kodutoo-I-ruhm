<?php
    
    //jutumärkide vahele input elemendi NAME
 
    //ERRORid
    
    $email_error="";
    $password_error="";
	$password1_error="";
	$password2_error="";
	$firstname_error="";
	$lastname_error="";
	$epost_error="";
	
    //Muutujad väärtustega
    $email = "";
    $password ="";
    $password1="";
    $password2="";
    $firstname="";
    $lastname="";
    $epost="";
    
      
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
                echo "Kontrollin ".$email." ".$password;
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
            if(empty($_POST["epost"])){
                $epost_error="Kohustuslik väli";
            }else{
                //annan väärtuse
                $epost = test_input($_POST["epost"]);            
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
            if(empty($_POST["password2"])){
                $password2_error="Ei saa olla tühi";
            }else{
                
                //parool ei ole tühi, kontrollime pikkust
                if(strlen($_POST["password2"]) != strlen($_POST["password1"])){
                    $password2_error="Vale parool";
                    
                }else{
                //annan väärtuse
                $password2 = test_input($_POST["password2"]);            
                }
                
            }
                        
            if($firstname_error == "" && $lastname_error == "" && $epost_error == "" && $password1_error == "" && $password2_error == ""){
                //erroreid ei olnud
                echo "Kontrollin ".$firstname." ".$lastname." ".$epost." ".$password1." ".$password2;
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
		<input type="email" name="epost" placeholder="E-post" value="<?php echo $epost; ?>">*<?php echo $epost_error;?><br><br>
		<input type="password" name="password1" placeholder="Parool" value="<?php echo $password1; ?>">*<?php echo $password1_error;?><br><br>
		<input type="password" name="password2" placeholder="Korda parooli" value="<?php echo $password2; ?>">*<?php echo $password2_error;?><br><br>
		<input type="submit" name="create" value="Create">
		
		</form>
<?php
    require_once("../footer.php");
?>