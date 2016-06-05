<?php
	session_start();
	$_SESSION['userStatus'] = $_POST["userStatus"];
	//echo $_SESSION['userStatus'];
	//print_r($_SESSION);
?>
<script type="text/javascript">
	$(document).ready(function() {
		$("#errorForgotMsg").dialog({
			autoOpen : false,
			modal: true,
			//position: ['center', 'center'],
			buttons: {
		        Ok: function() {
		        	//close
		        	$( this ).dialog( "close" );
		        }
		     },
			close : function() {
				$(this).dialog( "close" );
			}
		});
		//check submit event
		$('#buttonOK').click(function(e) {
			//set value into session
			//localStorage.CanvasOffset = "true";
			e.preventDefault();
			if(validateRegisForm(e)){
				var $username = $('#username').attr('value');
				console.log($username);
				var $email = $('#email').attr('value');
				console.log($email);
				if(e.handled !== true){
					$.ajax({
						type: 'POST',
						url: '../control/forgotPasswordControl.php',
						data: {'call':'checkUserEmail',
							'email':$email,
							'username':$username},
						success: function(data){
							//$('#debugging').html(data);
							if(data=='11'){
								//true
								location.href="../pageElement/createPassword.php";
							}else{
								//false
								//pop up error
								$("#errorForgotMsg").on( "dialogopen", function(e) {
									$('#errorForgotMsg').html("Username & E-mail not found in database");
								} );
								$('#errorForgotMsg').dialog("open");
								var html = ">> Username & E-mail not found in database";
								logDebug(html+'<br/>');
								//writelog(logD_action,logD_interaction,logD_input,logD_status,logD_remark)
							    writelog("-","-","-","error",html);
							}
							//window.location.href = "index.php";
						},
						async:true
					});
					e.handled = true;
				}
			}
		});

		//validate form
		function validateRegisForm(e){
			var isValid = true; 
			// Validate username
			var username = $('#username').val();
			if(!username && username.length <= 0){
				isValid = false;
				$('#msg_username').html('Please fill username').show();
			}else{
				$('#msg_username').html('').hide();
			}

			// Validate email
			var email = $('#email').val();
			if(email && email.length > 0){
				if(!isValidEmailAddress(email)){
		           isValid = false;
		           $('#msg_email').html('Email is invalid').show();           
		        }else{    
				   $('#msg_email').html('').hide();
		        }
		    }else{
		        isValid = false;
		        $('#msg_email').html('Please fill email').show();
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
	/* Form Styles */
	#buttonOK {
	  display:block;
	  float:right;
	  margin:5px 3px 0 3px;
	  padding:5px;
	  text-decoration: none;
	  text-align: center;
	  font: bold 12px Verdana, Arial, Helvetica, sans-serif;
	  width:80px;
	  color:#FFF;
	  outline-style:none;
	  background-color:   #5A5655;
	  border: 1px solid #5A5655;
	  -moz-border-radius  : 5px; 
	  -webkit-border-radius: 5px;    
	}
	.txtBox {
	  border:1px solid #CCCCCC;
	  color:#5A5655;
	  font:13px Verdana,Arial,Helvetica,sans-serif;
	  padding:2px;
	  width:150px;
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
	
    table#forgotForm{
        border: 0px solid grey;
        margin: auto auto;
        width: 400px;
        vertical-align: middle;
     }
</style>
<div id=forgotPwdd style="height: 400px;">
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<form name="form1" method="post">
  <table id = "forgotForm">
  	<tr>
		<td>Forgot your password? (Input Username and Email)</td>
	</tr>
  	<tr>
  		<td>
		  <table>
		    <tbody>
		      <tr>
					<td align="right">Username :</td>
					<td align="left">
						<input type="text" id="username" name="username" value="" class="txtBox">
					</td>
					<td align="left"><span id="msg_username" class="message"></span>&nbsp;</td>
			  </tr>
		      <tr>
					<td align="right">E-mail :</td>
					<td align="left">
						<input type="text" id="email" name="email" value="" class="txtBox">
					</td>
					<td align="left"><span id="msg_email" class="message"></span>&nbsp;</td>
			  </tr>
		       <tr>
		       		<td>&nbsp;</td>
		      		<td><a href="" id="buttonOK">OK</a></td></td>
		      		<td>&nbsp;</td>
		      </tr>
		    </tbody>
		  </table>
  		</td>
  	</tr>
  </table>
  <br>
  
</form>
</div>

<!-- div id=errorMsg use to show error message -->
<div id="errorForgotMsg" title="error message">

</div>