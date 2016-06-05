<?php
	session_start();
	//include file
	include ("../control/checkUser.php");
	include ("../control/databaseConnect.php");
	
	
	//include file
	include ("../control/sessionManager.php");
	if($_GET){
		$mem_id = $_GET['mem_id'];
		$strSQL = "SELECT * FROM tbl_member WHERE member_id = '".trim($mem_id)."'";
	}else{
		$username = $_SESSION['member_login'];
		$strSQL = "SELECT * FROM tbl_member WHERE member_login = '".trim($username)."'";
	}
	//check username
	//$strSQL = "SELECT * FROM tbl_member WHERE member_login = '".trim($username)."'";
	$objQuery=$conn->query($strSQL) or die(mysql_error());
	$objResult = $objQuery->fetch_assoc();
	//print_r($objResult)."<br>";
	//$r_num = mysql_num_rows($objResult);
	$conn->close();
?>
<script type="text/javascript" src="../js/jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		//DetailDialog
		$("#detailDlg").dialog({
			autoOpen : false,
			height : 200,
			width : 300,
			modal : true,
			buttons: {
                Ok: function() {
                    $(this).dialog( "close" );
                }
            },
			close : function() {
				//$(this).dialog( "close" );
			}
		});
		$('#buttonUpdate').click(function(e) {
			//alert("555");
			e.preventDefault();
			//alert('555');
			if(validateRegisForm(e)){
				//set value into session
				var $mem_id = $('#member_id').attr('value');
				var $firstname = $('#firstname').attr('value');
				console.log($firstname);
				var $lastname = $('#lastname').attr('value');
				console.log($lastname);
				var $phone = $('#phone').attr('value');
				console.log($phone);
				var $role = $('#mem_role').attr('value');
				console.log($role);
				var $email = $('#email').attr('value');
				console.log($email);
				//alert('555');
				$.ajax({
					type: 'POST',
					url: '../control/userControl.php',
					data: {'call':'userUpdate',
						'firstname':$firstname,
						'lastname':$lastname,
						'phone':$phone,
						'email':$email,
						'mem_id':$mem_id,
						'role':$role},
					success: function(data){
						$('#debugging').html(data);
						if(data==1){
							//show success dialog
							$("#detailDlg").on( "dialogopen", function(e) {
								$('#detailDlg').html("<h2>update successful!!!</h2>");
							});
							$('#detailDlg').dialog("open");
							//update
							e.preventDefault();
							$('#rightContent').load('userUpdate.php');
						}else{
							//show error
							$("#detailDlg").on( "dialogopen", function(e) {
								$('#detailDlg').html("<h2>error!!!</h2>");
							});
							$('#detailDlg').dialog("open");
						}
						//alert(data);
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
<h2>Personal Information</h2>
	<table cellspacing="3" cellpadding="3" align="left">
			<tr>
				<td align="right">Firstname :</td>
				<td align="left">
					<input type="text" id="firstname" name="firstname" value="<?php echo $objResult['member_firstname']?>" class="txtBox">
				</td>
				<td align="left"><span id="msg_firstname" class="message"></span>&nbsp;</td>
			</tr>
			<tr>
				<td align="right">Lastname :</td>
				<td align="left">
					<input type="text" id="lastname" name="lastname" value="<?php echo $objResult['member_lastname']?>" class="txtBox">
				</td>
				<td align="left"><span id="msg_lastname" class="message"></span>&nbsp;</td>
			</tr>
			<tr>
				<td align="right">Mobile phone :</td>
				<td align="left">
					<input type="text" id="phone" name="phone" value="<?php echo '0'.$objResult['member_phone']?>" class="txtBox">
				</td>
				<td align="left"><span id="msg_phone" class="message"></span>&nbsp;</td>
			</tr>
			<tr>
				<td align="right">E-mail :</td>
				<td align="left">
					<input type="text" id="email" name="email" value="<?php echo $objResult['member_email']?>" class="txtBox">
				</td>
				<td align="left"><span id="msg_email" class="message"></span>&nbsp;</td>
			</tr>
			<tr>
				<td align="right">Username :</td>
				<td align="left">
					<input type="text" id="username" name="username" value="<?php echo $objResult['member_login']?>" readonly class="txtBox">
				</td>
				<td align="left"><span id="msg_username" class="message"></span>&nbsp;</td>
			</tr>
			<tr>
				<td align="right">Role :</td>
				<td>
				<?php if(isset($_SESSION['member_role'])){
						if($_SESSION['member_role']=='admin'){
							if($objResult['member_role']=='admin'){
								$str = '<select id="mem_role">';
								$str = $str.'<option value="admin">admin</option>';
								$str = $str.'<option value="user">user</option>';
								$str = $str.'</select>';
							}else{
								$str = '<select id="mem_role">';
								$str = $str.'<option value="user">user</option>';
								$str = $str.'<option value="admin">admin</option>';
								$str = $str.'</select>';
							}
							echo  $str;
						}else if($_SESSION['member_role']=='user'){
							$str = '<input type="text" id="mem_role" name="mem_role" ';
							$str = $str.'value="'.$objResult["member_role"].'" readonly class="txtBox">';
							echo  $str;
						}
					}
				?>
				</td>
			</tr>
			<tr>
				<td><input type="hidden" id="member_id" name="member_id" value="<?php echo $objResult['member_id']?>" class="txtBox"></td>
				<td><a href="" id="buttonUpdate">Update</a></td>
			</tr>
	</table>