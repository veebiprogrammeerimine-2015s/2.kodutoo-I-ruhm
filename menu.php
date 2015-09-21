<h3> Menu </h3>

<ul>
	<?php if($page_file_name != "home.php") { ?>
	<li><a href="home.php"> Avaleht </a></li>
	<?php } else { ?>
	<li> Avaleht </li>
	<?php } ?>
	<?php if($page_file_name != "sisu.php") { ?>
	<li><a href="sisu.php"> Log In </a></li>
	<?php } else { ?>
	<li>Log In</li>
	<?php } ?>
	<?php if($page_file_name != "create.php") { ?>

		<li><a href="create.php"> Register </a></li>
	<?php } else { ?>
	<li>Creation</li>
	<?php } ?>
	</ul>