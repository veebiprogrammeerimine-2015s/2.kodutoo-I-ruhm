<h2>Menüü</h2>

<?php echo $page_file_name; ?>
<ul>

	<?php 
	//ükskõik mis lehe puhul näitan linki aga kui on 
	//home leht, sisi lihtsalt nime
	if($page_file_name != "home.php") { ?>
	<li><a href="home.php">Avaleht</a></li>
	<?php } else { ?>
		<li>Avaleht</li>
	<?php } ?>
	
	
	<?php
	//teine variant sama kirjutamiseks, kompaktsem
	if($page_file_name != "login.php"){
		echo '<li><a href="login.php">Logi sisse!</a></li>';
	}else{
		echo '<li>Logi sisse!</li>';
	}
	?>
	
</ul>