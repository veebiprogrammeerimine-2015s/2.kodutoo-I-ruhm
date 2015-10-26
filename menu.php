<h3>Menüü</h3>

<ul>
	<?php
	// ükskõik mis lehe puhul näitan linki aga kui on home leht siis nime
	if($page_file_name != "home.php") { ?>
	<li><a href="home.php">Avaleht</a></li>
	<?php } else {  ?>
		<li> Avaleht </li>
	<?php } ?>
	
	<?php
	// ükskõik mis lehe puhul näitan linki aga kui on home leht siis nime
	if($page_file_name != "login.php") { ?>
	<li><a href="login.php">Logi sisse</a></li>
	<?php } else {  ?>
		<li> Logi sisse </li>
	<?php } ?>
	
</ul>