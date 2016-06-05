<?php
	if(!session_start()) {
	     session_start();
	}
	//post data sent
	$_SESSION['userStatus'] = $_POST["userStatus"];
	//print_r($_SESSION);
?>
<!-- <link href="../css/smart_wizard.css" rel="stylesheet" type="text/css"> -->
<script type="text/javascript">
	$(document).ready(function() {
		//writelog(logD_action,logD_interaction,logD_input,logD_status,logD_remark)
	    writelog("-","load registation form page","-","-",">> User fill information");
		//check mode registration or change pwd
		$('.buttonNext').click(function(e) {
			//alert("555");
			//e.preventDefault();
			if(validateRegisForm(e)){
				//set value into session
				localStorage.CanvasOffset = "true";
				var $firstname = $('#firstname').attr('value');
				console.log($firstname);
				var $lastname = $('#lastname').attr('value');
				console.log($lastname);
				var $phone = $('#phone').attr('value');
				console.log($phone);
				var $email = $('#email').attr('value');
				console.log($email);
				var $username = $('#username').attr('value');
				console.log($username);
				$.ajax({
					type: 'POST',
					url: '../control/sessionManager.php',
					data: {'call':'setUserDetail',
						'firstname':$firstname,
						'lastname':$lastname,
						'phone':$phone,
						'email':$email,
						'username':$username,},
					success: function(data){
						$('#debugging').html(data);
						localStorage.CanvasOffset="true";
						location.href = "createPassword.php";
					},
					async:false
				});
			}
		});

		//validate form
		function validateRegisForm(e){
			var isValid = true; 
			// Validate firstname
			var firstname = $('#firstname').val();
			if(!firstname && firstname.length <= 0){
				isValid = false;
				$('#msg_firstname').html('Please fill firstname').show();
			}else{
				$('#msg_firstname').html('').hide();
			}

			// Validate lastname
			var lastname = $('#lastname').val();
			if(!lastname && lastname.length <= 0){
				isValid = false;
				$('#msg_lastname').html('Please fill lastname').show();
			}else{
				$('#msg_lastname').html('').hide();
			}

			// Validate phone
			var phone = $('#phone').val();
			if(!phone && phone.length <= 0){
				isValid = false;
				$('#msg_phone').html('Please fill phone').show();
			}else{
				$('#msg_phone').html('').hide();
			}

			// Validate email
			var email = $('#email').val();
			if(email && email.length > 0){
				if(!isValidEmailAddress(email)){
		           isValid = false;
		           $('#msg_email').html('Email is invalid').show();           
		        }else{
		        	var userAvaliable = true;
		        	e.preventDefault();
			        $.ajax({
						type: 'POST',
						url: '../control/registrationControl.php',
						data: {	'call':'chkSameInDB',
								'data1':email,
								'data2':'email',},
						success: function(data){
							$('#debugging').html(data);
							if(data==11){
								//alert(data);
								$('#msg_email').html('E-mail already in use!!').show();
								userAvaliable = false;
								isValid = false;
							}
						},
						async:false
					});         
			        if(userAvaliable){
					   $('#msg_email').html('').hide();
				    }
		        }
		    }else{
		        isValid = false;
		        $('#msg_email').html('Please fill email').show();
		    }

		    //Valiate username
			var username = $('#username').val();
			if(username && username.length > 0){
				var userAvaliable = true;
				e.preventDefault();
		        $.ajax({
					type: 'POST',
					url: '../control/registrationControl.php',
					data: {'call':'chkSameInDB',
						'data1':username,
						'data2':'username',},
					success: function(data){
						$('#debugging').html(data);
						if(data==11){
							$('#msg_username').html('username already exist!!').show();
							userAvaliable = false;
							isValid = false;
						}
					},
					async:false
				});           
		        if(userAvaliable){
			       $('#msg_username').html('').hide();
		        }
		    }else{
		        isValid = false;
		        $('#msg_username').html('Please fill username').show();
		    }

			//return validate result
			return isValid;
		}

		// Email Validation
	    function isValidEmailAddress(emailAddress) {
	    	var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
	      	return pattern.test(emailAddress);
	    }
	});
</script>
<style>
	.txtBox {
	  border:1px solid #CCCCCC;
	  color:#5A5655;
	  font:13px Verdana,Arial,Helvetica,sans-serif;
	  padding:2px;
	  width:200px;
	}
	.txtBox:focus {
	  border:1px solid #EA8511;
	}
	.message {
		color : #FF0000;
		font-size : 12pt;
		font-weight : bold;
		text-align : left;
	}
</style>
<table>
	<tr>
		<td>
			<!-- Smart Wizard -->
			<div id="wizard" class="swMain">
				<ul class="anchor">
					<li>
						<a href="#step-1" class="done">
							<label class="stepNumber">1</label> 
							<span class="stepDesc"> 
								Step 1<br /> 
								<small>Step 1 Instruction</small>
							</span>
						</a>
					</li>
					<li>
						<a href="#step-2" class="selected"> 
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
						<h2 class="StepTitle">Step 2 Personal Information</h2>
						<table cellspacing="3" cellpadding="3" align="center">
							<tr>
								<td align="center" colspan="3">&nbsp;</td>
							</tr>
							<tr>
								<td align="right">Firstname :</td>
								<td align="left"><input type="text" id="firstname"
									name="firstname" value="" class="txtBox">
								</td>
								<td align="left"><span id="msg_firstname" class="message"></span>&nbsp;</td>
							</tr>
							<tr>
								<td align="right">Lastname :</td>
								<td align="left"><input type="text" id="lastname"
									name="lastname" value="" class="txtBox">
								</td>
								<td align="left"><span id="msg_lastname" class="message"></span>&nbsp;</td>
							</tr>
							<tr>
								<td align="right">Mobile phone :</td>
								<td align="left"><input type="text" id="phone" name="phone"
									value="" class="txtBox">
								</td>
								<td align="left"><span id="msg_phone" class="message"></span>&nbsp;</td>
							</tr>
							<tr>
								<td align="right">E-mail :</td>
								<td align="left"><input type="text" id="email" name="email"
									value="" class="txtBox">
								</td>
								<td align="left"><span id="msg_email" class="message"></span>&nbsp;</td>
							</tr>
							<tr>
								<td align="right">Username :</td>
								<td align="left"><input type="text" id="username" name="username"
									value="" class="txtBox">
								</td>
								<td align="left"><span id="msg_username" class="message"></span>&nbsp;</td>
							</tr>
						</table>
					</div>
				</div>
				<div class="actionBar">
					<div class="loader">Loading</div>
					<a href="#" class="buttonNext">Next</a>
				</div>
			</div>
		</td>
	</tr>
</table>