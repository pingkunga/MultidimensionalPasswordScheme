<?php
	//check session
	session_start();
	include ("../control/checkAdmin.php");
?>
<html>
<head>
<title>Administration</title>
<script type="text/javascript" src="../js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.9.2.custom.min.js"></script>
<link rel="stylesheet" href="../js/resource_jquery_ui/themes/base/jquery-ui.css" />
<link rel="stylesheet" type="text/css" href="../css/mos-style.css">
<script type="text/javascript">
	$(document).ready(function() {
		//check event edit user detail
		$('#editUserDetail').click(function(e) {
			 e.preventDefault();
			 $('#rightContent').load('userDetail.php');
		});
		
		$('#listUser').click(function(e) {
			 e.preventDefault();
			 $('#rightContent').load('userHeader.php');
		});

		//check event change password
		$('#logManager').click(function(e) {
			 e.preventDefault();
			 $('#rightContent').load('logHeader.php');
		});

		
	});
</script>
</head>

<body>
<div id="header">
	<div class="inHeader">
		<div class="mosAdmin">
		Hello, <?php echo $_SESSION['member_login']?> [Admin]<br>
		<a href="../control/logoutControl.php">Sign out</a>
		</div>
	<div class="clear"></div>
	</div>
</div>

<div id="wrapper">
	<div id="leftBar">
		<ul>
			<li><a href=""  id="editUserDetail">Edit user detail</a></li>
			<li><a href=""  id="listUser">List user</a></li>
			<li><a href=""  id="logManager">Log Manager</a></li>
			<!-- <li><a href=""  id="passwordAnalyst">password analyst</a></li>-->
			<!-- <li><a href=""	id="changePassword">Change pasword</a></li>-->
		</ul>
	</div>
	<div id="rightContent">
		<h2>Welcome to admin page</h2>
	</div>
<div class="clear"></div>
<div id="footer">
	SCI422 Group11 (Multi-dimentional Password Scheme)
</div>
</div>
<div id='detailDlg'>
</div>
</body>
</html>
