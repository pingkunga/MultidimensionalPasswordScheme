<?php
	//session_start();
	//destroy session
	if(session_start()) {
		//session_destroy();
		session_regenerate_id();
		session_unset();
	}
	//redirect to index
	echo '<script type="text/javascript">
				location.href="/sci422/proj3D";
			</script>';
?>