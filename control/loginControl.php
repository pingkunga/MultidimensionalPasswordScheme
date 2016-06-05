<?php
	if(!isset($_SESSION)) {
		session_start();
	}
	//include file
	include ('../control/databaseConnect.php');
	include ('../control/logControl.php');
	include ('../control/sessionManager.php');
	//require ("../control/logControl.php");
	
	$username = $_POST['txtUsername'];
	//echo $username."<br>";
	//get password
	$passwordData = getPassword(1);
	//echo $passwordData;
	$encryptPwd = sha1(md5($passwordData));
	//check username
	$strSQL = 'SELECT * FROM tbl_member WHERE member_login = "'.mysql_real_escape_string(trim($username)).'" AND member_pwd = "'.mysql_real_escape_string(trim($encryptPwd)).'"';
	//$strSQL = "SELECT * FROM test_login WHERE u_name = 'pingkung' AND p_word = 'qwerty1_13_4'";
	echo $strSQL;
	//echo "<br>";
	$objQuery=$conn->query($strSQL) or die(mysql_error());
	//$objQuery = mysql_query($strSQL) or die(mysql_error());
	//$objResult = mysql_fetch_array($objQuery);
	$objResult = $objQuery->fetch_assoc();
	//print_r($objResult)."<br>";
	//$r_num = mysql_num_rows($objResult);
	//==============================================================
	$ip = getRealIpAddr();
	$logH_id = getLogHeaderID($ip,session_id());
	//==============================================================
	$data['logD_action']='vertify';
	$data['logD_interaction']='-';
	$data['logD_input']=$passwordData;
	$data['logD_status']='passwordData';
	$data['logD_remark']='>> vertify username and password';
	writeLogDetail($logH_id,$data);
	//==============================================================
	if(!$objResult)
	{
		//echo "<br>";
		//echo "<h1>Username and Password Incorrect!</h1>";
		//echo "<br>";
		//==============================================================
		$data['logD_action']='End mode';
		$data['logD_interaction']='-';
		$data['logD_input']=$passwordData;
		$data['logD_status']='fail';
		$data['logD_remark']='>> username and password incorrect';
		writeLogDetail($logH_id,$data);
		//==============================================================
		//update member_id with session
		
		print_r($_SESSION);
		//redirect to workSpace.php
		//header("Location: http://localhost/sci422/proj3D/pageElement/success.php");
		session_destroy();
		//sleep(100);
		/*echo '<script type="text/javascript">
				$("#errorMsg").on( "dialogopen", function(e) {
						$("#errorMsg").append("username or password not match");
					} );
				$("#errorMsg").dialog( "option", "buttons", [ { text: "Ok", 
					click: function() { 
						$( this ).dialog( "close" ); 
						window.location="http://localhost/sci422/proj3D/pageElement/login.php";
					} 
				} ] );
				$("#errorMsg").dialog("open");
			</script>';*/
		echo '<script type="text/javascript">
				location.href = "../pageElement/fail.php";
			</script>';
	}
	else
	{
		//echo "<br>";
		//echo "<h1>found</h1>";
		//echo "<br>";
		//var_dump($_SESSION);
		//print_r($_SESSION);
		//header("Location: http://localhost/sci422/proj3D/pageElement/fail.php");
		//session_destroy();
		//sleep(100);
		//get user data and place in session
		//echo $objResult['member_login'].'<br/>';
		//echo $objResult['member_role'].'<br/>';
		$_SESSION['member_id']=$objResult['member_id'];
		$_SESSION['member_login']=$objResult['member_login'];
		$_SESSION['member_role']=$objResult['member_role'];
		
		echo $_SESSION['member_login'].'<br/>';
		echo $_SESSION['member_role'].'<br/>';
		
		//update member_id with session 
		updateLogHeaderByMemID($_SESSION['member_id']);
		//check user type and redirect
		if(($_SESSION['member_role'])=='user'){
			//goto user page
			//==============================================================
			$data['logD_action']='End mode';
			$data['logD_interaction']='-';
			$data['logD_input']=$_SESSION['member_role'];
			$data['logD_status']='passwordSuccess';
			$data['logD_remark']='>> redirect to user page';
			writeLogDetail($logH_id,$data);
			//==============================================================
			echo '<script type="text/javascript">
				location.href ="../pageElement/userPage.php";
			</script>';
		}else if(($_SESSION['member_role'])=='admin'){
			//goto admin page
			//==============================================================
			$data['logD_action']='End mode';
			$data['logD_interaction']='-';
			$data['logD_input']=$_SESSION['member_role'];
			$data['logD_status']='passwordSuccess';
			$data['logD_remark']='>> redirect to admin page';
			writeLogDetail($logH_id,$data);
			//==============================================================
		}
		//check user type and redirect
		echo '<script type="text/javascript">
				location.href ="../pageElement/administration.php";
			</script>';
	}
	$conn->close();
?>