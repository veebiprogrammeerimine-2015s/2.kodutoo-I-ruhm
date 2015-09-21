<h3>Menüü</h3>

<ul>
	<?php if($page_file != "home.php") { ?>
		<li><a href="home.php">Avaleht</a></li>
	<?php } else { ?>
		<li>Avaleht</li>
	<?php } ?>
	
	<?php if($page_file != "login.php") { ?>
		<li><a href="login.php">Logi sisse</a></li>
	<?php } else { ?>
		<li>Logi sisse</li>
	<?php } ?>
	
	
</ul>