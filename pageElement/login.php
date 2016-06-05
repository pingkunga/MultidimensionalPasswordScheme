<?php
	if(session_start()) {
		session_unset();
		//session_start();
	}
	//print_r($_SESSION);
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Language" content="th">
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>FinalProject</title>
<script type="text/javascript" src="../js/glge-compiled-min.js"></script>
<script type="text/javascript" src="../js/enviroment.min.js"></script>
<script type="text/javascript" src="../js/log.js"></script>
<script type="text/javascript" src="../js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery.blockUI.js"></script>
<script type="text/javascript" src="../js/jquery.ui.pattern.min.js"></script>
<script type="text/javascript" src="../js/progress.js"></script>
<script type="text/javascript" src="../js/index.js"></script>
<link rel="stylesheet" href="../css/index.css" />
<link rel="stylesheet" href="../css/smart_wizard.min.css" />
<link rel="stylesheet" href="../js/resource_jquery_ui/themes/base/jquery-ui.css" />
<link rel="stylesheet" href="../css/ui.progress-bar.css" />
<!-- will be fix path -->
<link rel="stylesheet" type="text/css" href="../passwordType/jquery.ui.pattern.css" />
<script type="text/javascript">
	$(document).ready(function() {
		$('#submit').click(function() { 
	        $.blockUI({ css: { 
	            border: 'none', 
	            padding: '15px', 
	            backgroundColor: '#000', 
	            '-webkit-border-radius': '10px', 
	            '-moz-border-radius': '10px', 
	            opacity: .5, 
	            color: '#fff' 
	        } }); 
	 
	        setTimeout($.unblockUI, 15000); 
	    }); 
	});
</script>
<style type="text/css">
button.login {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #045700;
	padding: 10px 20px;
	background: -moz-linear-gradient(
		top,
		#ffffff 0%,
		#ffffff 50%,
		#b5b5b5);
	background: -webkit-gradient(
		linear, left top, left bottom, 
		from(#ffffff),
		color-stop(0.50, #ffffff),
		to(#b5b5b5));
	-moz-border-radius: 10px;
	-webkit-border-radius: 10px;
	border-radius: 10px;
	border: 3px solid #d8ffc7;
	-moz-box-shadow:
		0px 1px 3px rgba(000,000,000,0.5),
		inset 0px 0px 3px rgba(255,255,255,1);
	-webkit-box-shadow:
		0px 1px 3px rgba(000,000,000,0.5),
		inset 0px 0px 3px rgba(255,255,255,1);
	box-shadow:
		0px 1px 3px rgba(000,000,000,0.5),
		inset 0px 0px 3px rgba(255,255,255,1);
	text-shadow:
		0px -1px 0px rgba(000,000,000,0.2),
		0px 1px 0px rgba(255,255,255,1);
}
</style>
</head>
<body>
	<div id="wrapper">
		<!-- Progress bar -->
	    <div id="progress_bar" class="ui-progress-bar ui-container">
	      <div class="ui-progress" style="width: 79%;">
	        <span class="ui-label" style="display:none;">Processing <b class="value">79%</b></span>
	      </div>
	    </div>
	    <!-- /Progress bar -->
		<div id="detail">
			<!--div id=header place 3D-enviroment & password-->
			<div id="header">
				<div id="container">
					<canvas id="canvas" width="900" height="500"></canvas>
					<div id="framerate" class="elementContain">
						<div id="debug" style="padding: 5px"></div>
					</div>
					<form name="form1" method="post" action="../control/loginControl.php">
						<div id="username" class="elementContain">
							<h2 class="userStyle">Enter username</h2>
							<p class="userStyle">
								<input type="text" name="txtUsername" id="txtUsername" required placeholder="Enter a username" style="border:1px solid #888;width: 100%" />
							</p>
						</div>
						<div id="login">
							<button type="submit" id="submit" value="Submit" class="login">LOGIN</button>
						</div>
					</form>
				</div>
			</div>
	
			<!-- div id=menu place menu (registration/forgot password) -->
			<div id="navigation">
				<ul id="menu">
					<li class="sub" id="registration">Registration</li>
					<li class="sub" id="authentication">Authentication</li>
					<li class="sub" id="forgotPassword">Forgot password</li>
					<li class="sub" id="contactus">Contact us</li>
				</ul>
			</div>
			<br>
			<!-- div id=log place log -->
			<div id=note>
				<p>Log</p>
				<div id="log"></div>
			</div>
		</div>
	</div>
	<!-- div id="txtPasswordDlg" place password type textual -->
	<div id="txtPasswordDlg" title="password prompt">

	</div>
	
	<!-- div id=passPointDlg place password type graphical-->
	<div id="passPointDlg" title="password prompt">

	</div>
	
	<!-- div id=patternUnlockDlg place password type graphical-->
	<div id="patternUnlockDlg" title="password prompt">

	</div>
	
	<!-- div id=errorMsg use to show error message -->
	<div id="errorMsg" title="error message">

	</div>
	
	<div id ="contactMsg" title="contact us" align="center">
	อาจารย์ที่ปรึกษาโครงงาน<br/> อาจารย์ ดร.วราภรณ์ วิยานนท์ (waraporn@swu.ac.th)<br/> <br/>
	รายชื่อนิสิต<br/>
	นายชาตรี งามเบญจวงศ์	  รหัส 52102010308 (pingkunga@gmail.com)<br/>
	นายพรฉัตรชัย สังฆมานนท์	  รหัส 52102010316 (peter2520@gmail.com)<br/>
	นายนบพรหม พละสมบูรณ์	  รหัส 52102010555 (tacomswu@gmail.com)<br/><br/><br/>
	</div>
	
	<!--  <div id="debugging">
	</div>-->
	
</body>
</html>