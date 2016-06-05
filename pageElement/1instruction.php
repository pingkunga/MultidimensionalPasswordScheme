<?php
	if(!session_start()) {
	     session_start();
	}
	$_SESSION['userStatus'] = "registration";
//	print_r($_SESSION);
?>
<!-- <link href="../css/smart_wizard.css" rel="stylesheet" type="text/css"> -->
<script type="text/javascript">
	$(document).ready(function() {
		//write log file
		//writelog(logD_action,logD_interaction,logD_input,logD_status,logD_remark)
	    writelog("-","load instruction page","-","-",">> User read instruction");
		$('.buttonNext').click(function() {
			//alert("555");
			$('#container').load('2registrationForm.php',{
				userStatus: "registration"
				}
			);
		});
	});
</script>
<table>
	<tr>
		<td>
			<!-- Smart Wizard -->
			<div id="wizard" class="swMain">
				<ul class="anchor">
					<li>
						<a href="#step-1" class="selected">
							<label class="stepNumber">1</label> 
							<span class="stepDesc"> 
								Step 1<br /> 
								<small>Step 1 Instruction</small>
							</span>
						</a>
					</li>
					<li>
						<a href="#step-2" class="disabled"> 
							<label class="stepNumber">2</label> 
							<span class="stepDesc"> 
								Step 2<br /> 
								<small>Step 2 Personal Information</small>
							</span>
						</a>
					</li>
					<li>
						<a href="#step-3" class="disabled">
							<label class="stepNumber">3</label>
							<span class="stepDesc"> 
								Step 3<br /> 
								<small>Step 3 Create password</small>
							</span>
						</a>
					</li>
					<li>
						<a href="#step-4" class="disabled">
							<label class="stepNumber">4</label> 
								<span class="stepDesc"> 
									Step 4<br /> 
									<small>Step 4 Re-create password</small>
							</span>
						</a>
					</li>
				</ul>
				<div class="stepContainer">
					<div class="content">
						<h2 class="StepTitle">Step 1 Instruction</h2>
						<iframe width="560" height="315" src="http://www.youtube.com/embed/0RgqLOhu4VQ" frameborder="0" allowfullscreen></iframe>
						<br/>คุณสามารถดูวิดีโอนี้ประกอบการทดสอบระบบ โดยจะสรุปสาระที่สำคัญ ดังนี้
						<ul type="disk">
							<li>ผู้ใช้อ่าน และดูวิดีโอตัวอย่างการใช้งาน</li>
							<li>ผู้ใช้กรอกรหัสผ่าน</li>
							<li>กรอกรหัสผ่าน โดยผู้ใช้ามารถเลือกรหัสผ่านจากวตถุ แต่ละชิ้นในระบบได้</li>
							<li>กรอกรหัสผ่าน อีกครั้ง</li>
						</ul>
					</div>
				</div>
				<div class="actionBar">
					<div class="loader">Loading</div>
					<!-- <a href="#" class="buttonFinish buttonDisabled">Finish</a> -->
					<a href="#" class="buttonNext">Next</a>
					<!-- <a href="#" class="buttonPrevious buttonDisabled">Previous</a> -->
				</div>
			</div>
		</td>
	</tr>
</table>