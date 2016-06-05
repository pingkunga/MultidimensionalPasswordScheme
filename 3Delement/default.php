<?php
	if (stristr(htmlentities($_SERVER['PHP_SELF']), "default.php")) {
		   header("Location: /sci422/proj3D/");
		die();
	}
?>
