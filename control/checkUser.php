<?php
	if(session_id() == ''){
		session_start();
	}
	//print_r($_SESSION);
	if(isset($_SESSION['member_login'])){
		if($_SESSION['member_login'] == "")
		{
			header("Location: /sci422/proj3D/");
			exit();
		}
	}else{
		header("Location: /sci422/proj3D/");
		exit();
	}
?>