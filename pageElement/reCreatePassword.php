<?php
	session_start();
	//print_r($_SESSION);
	$type = $_SESSION['userStatus'];
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>FinalProject</title>
<script type="text/javascript" src="../js/glge-compiled.js"></script>
<script type="text/javascript" src="../js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="../js/enviroment.min.js"></script>
<script type="text/javascript" src="../js/log.js"></script>
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
		localStorage.CanvasOffset = "true";
		$('.buttonReset').click(function(e) {
			e.preventDefault();
			destoryDialog();
			//call reset
			$.ajax({
				type: 'POST',
				url: '../control/sessionManager.php',
				data: {'call':'unsetScenario'},
				success: function(data){
					//writelog(logD_action,logD_interaction,logD_input,logD_status,logD_remark)
					$("#log").append(">> Reset user scenario <br>");
				    writelog("click","","reset","-",">> Reset user scenario");
					$('#debugging').html(data);
				},
				async:false
			});
		});

		$('.buttonNext').click(function(e) {
			e.preventDefault();
			//writelog(logD_action,logD_interaction,logD_input,logD_status,logD_remark)
		    writelog("click","","next","-",">> saveing first password scenario");
			$.ajax({
				type: 'POST',
				url: '../control/sessionManager.php',
				data: {'call':'updateEntertime'},
				success: function(data){
					$('#debugging').html(data);
					location.href = 'reCreatePassword.php';
				},
				async:false
			});
		});
		

		$('.buttonFinish').click(function(e) {
			e.preventDefault();
			$.blockUI({ css: { 
	            border: 'none', 
	            padding: '15px', 
	            backgroundColor: '#000', 
	            '-webkit-border-radius': '10px', 
	            '-moz-border-radius': '10px', 
	            opacity: .5, 
	            color: '#fff' 
	        } }); 
			//localStorage.CanvasOffset = 'false';destoryDialog()
			//alert('old');
			destoryDialog();
			//writelog(logD_action,logD_interaction,logD_input,logD_status,logD_remark)
		    writelog("click","","finish","-",">> finish");
			//$('.buttonFinish').unbind('click');
			$.ajax({
				type: 'POST',
				url: '../control/registrationControl.php',
				data: {'call':'passwordMatch'},
				success: function(data){
					$('#debugging').html(data);
					//alert(data);
					if(data==11){
						//alert(data+'4');
						$("#errorMsg").on( "dialogopen", function(e) {
							$('#errorMsg').append("Password not match");
						} );
						$('#errorMsg').dialog("open");
						//writelog(logD_action,logD_interaction,logD_input,logD_status,logD_remark)
					    writelog("-","-","-","error",">> password not match");
					}else if(data==00){
						//alert('go');
						location.href = '/sci422/proj3D/control/registrationControl.php?call=registration';
					}},
					async:true
			});
			setTimeout($.unblockUI, 15000); 
		});
		
		function destoryDialog(){
			$("#txtPasswordDlg").dialog( "destroy" );
			$("#passPointDlg").dialog( "destroy" );
			$("#patternUnlockDlg").dialog( "destroy" );
			//$("#errorMsg").dialog( "destroy" );
		}
	});
</script>
</head>
<body>
	<div id="wrapper">
		<!-- Progress bar -->
		<div id="progress_bar" class="ui-progress-bar ui-container">
			<div class="ui-progress" style="width: 79%;">
				<span class="ui-label" style="display: none;">Processing <b
					class="value">79%</b>
				</span>
			</div>
		</div>
		<!-- /Progress bar -->
		<div id="detail">
			<!--div id=header place 3D-enviroment & password-->
			<div id="header">
				<div id="container">
					<table>
						<tr>
							<td>
								<!-- Smart Wizard -->
								<div id="wizard" class="swMain">
									<div id="wizardMenu">
									<?php if($type=="registration"){
										echo '<ul class="anchor">
											<li><a href="#step-1" class="done"> <label class="stepNumber">1</label>
													<span class="stepDesc"> Step 1<br /> <small>Step 1
															Instruction</small>
												</span>
											</a>
											</li>
											<li><a href="#step-2" class="done"> <label class="stepNumber">2</label>
													<span class="stepDesc"> Step 2<br /> <small>Step 2 Personal
															Information</small>
												</span>
											</a>
											</li>
											<li><a href="#step-3" class="done"> <label class="stepNumber">3</label>
													<span class="stepDesc"> Step 3<br /> <small>Step 3 Create
															password</small>
												</span>
											</a>
											</li>
											<li><a href="#step-4" class="selected"> <label
													class="stepNumber">4</label> <span class="stepDesc"> Step 4<br />
														<small>Step 4 Re-create password</small>
												</span>
											</a>
											</li>
										</ul>';
									}else if($type=="forgotPwd"){
										echo '<ul class="anchor">
											<li>
												<a href="#step-1" class="done">
												<label class="stepNumber">1</label>
												<span class="stepDesc">
													Step 1<br />
													<small>Step 1 Create password</small>
												</span>
												</a>
											</li>
											<li>
												<a href="#step-2" class="selected">
												<label class="stepNumber">2</label>
												<span class="stepDesc">
													Step 2<br />
													<small>Step 2 Re-create password</small>
												</span>
												</a>
											</li>
										</ul>';
									}
									?>
									</div>
									<div class="stepContainer">
										<div class="content">
											<!-- <span><h2 class="StepTitle">Step 3 Create password</h2></span> -->
											<div id="pwd" align="center">
												<canvas id="canvas" width="900" height="500"></canvas>
												<div id="framerate" class="elementContain">
													<div id="debug" style="padding: 5px"></div>
												</div>
											</div>
										</div>
									</div>
									<div class="actionBar">
										<div id="actionButton">
											<a href="" class="buttonFinish">Finish</a>
											<a href="" class="buttonReset">Reset</a>
										</div>
									</div>
								</div>
							</td>
						</tr>
					</table>
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
	<div id="txtPasswordDlg" title="password prompt"></div>

	<!-- div id=passPointDlg place password type graphical-->
	<div id="passPointDlg" title="password prompt"></div>

	<!-- div id=patternUnlockDlg place password type graphical-->
	<div id="patternUnlockDlg" title="password prompt"></div>

	<!-- div id=errorMsg use to show error message -->
	<div id="errorMsg" title="error message"></div>

	<!-- <div id="debugging"></div>-->
	<div id ="contactMsg" title="contact us" align="center">
	อาจารย์ที่ปรึกษาโครงงาน อาจารย์ ดร.วราภรณ์ วิยานนท์ (waraporn@swu.ac.th) 
	รายชื่อนิสิต
	นายชาตรี งามเบญจวงศ์	  รหัส 52102010308(pingkunga@gmail.com)
	นายพรฉัตรชัย สังฆมานนท์  รหัส 52102010316(peter2520@gmail.com)
	นายนบพรหม พละสมบูรณ์  รหัส 52102010555(tacomswu@gmail.com)
	</div>
</body>
</html>
