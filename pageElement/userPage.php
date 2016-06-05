<?php
	//check session
	session_start();
	include ("../control/checkUser.php");
	
?>
<html>
<head>
<title>user detail</title>
<script type="text/javascript" src="../js/glge-compiled.js"></script>
<script type="text/javascript" src="../js/jquery-1.8.3.min.js"></script>
<!-- <script type="text/javascript" src="js/enviroment.js"></script>  -->
<script type="text/javascript" src="../js/jquery-ui-1.9.2.custom.min.js"></script>
<link rel="shortcut icon" href="stylesheet/img/devil-icon.png"> <!--Pemanggilan gambar favicon-->
<link rel="stylesheet" type="text/css" href="../css/mos-style.css">
<script type="text/javascript">
	$(document).ready(function() {
		//check event edit user detail
		$('#editUserDetail').click(function(e) {
			 e.preventDefault();
			 $('#rightContent').load('userDetail.php');
		});
	});
</script>
</head>

<body>
<div id="header">
	<div class="inHeader">
		<div class="mosAdmin">
		Hello, <?php echo $_SESSION['member_login']?> [User]<br>
		<a href="../control/logoutControl.php">Sign out</a>
		</div>
	<div class="clear"></div>
	</div>
</div>

<div id="wrapper">
	<div id="leftBar">
	<ul>
		<li><a href=""  id="editUserDetail">Edit user detail</a></li>
		<!-- <li><a href=""	id="changePassword">Change pasword</a></li>-->
	</ul>
	</div>
	<div id="rightContent">
		<h2>Welcome to user page</h2>
	</div>
<div class="clear"></div>
<div id="footer">
	SCI422 Group11 (Multi-dimentional Password Scheme)
</div>
</div>
</body>
</html>
