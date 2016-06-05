<?php
	session_start();
	include ("../control/sessionManager.php");
	if($_SERVER['REQUEST_METHOD']=="POST") {
		//echo "session call";
		if(isset($_POST['call'])){
			$function = $_POST['call'];
			//echo $function;
			if(function_exists($function)) {
				call_user_func($function);
			} else {
				//echo 'Function Not Exists!!';
			}
		}
	}else{
		//echo '45';
	}
	
	function checkUserEmail(){
		//include file
		include ('../control/databaseConnect.php');
		//include ("../control/sessionManager.php");
		//post data
		$username = $_POST['username'];
		$email = $_POST['email'];
		
		$_SESSION['userStatus'] = 'forgotPwd';
		//SQL
		$strSQL = 'SELECT * FROM tbl_member WHERE member_login = "'.mysql_real_escape_string(trim($username)).'" AND member_email = "'.mysql_real_escape_string(trim($email)).'"';
		//echo $strSQL;
		$objQuery=$conn->query($strSQL) or die(mysql_error());
		$objResult = $objQuery->fetch_assoc();
		//print_r($objResult)."<br>";
		if(!$objResult)
		{
			//echo '<br>';
			//echo '<h1>User Email not found in DB</h1>';
			//echo '<br>';
			print_r($_SESSION);
			echo 0;
			//redirect to workSpace.php
			//session_unset();
			$conn->close();
		}
		else
		{
			//echo '<br>';
			//echo '<h1>found</h1>';
			//echo '<br>';
			//var_dump($_SESSION);
			//print_r($_SESSION);
			//Set Session
			$scenarioType = checkAuthType();
			$_SESSION[$scenarioType]['username'] = $username;
			$_SESSION[$scenarioType]['email'] = $email;
			//redirect
			$conn->close();
			//sleep(100);
			//echo '<script type="text/javascript">
			//		location.href="../sci422/proj3D/pageElement/createPassword.php";
			//	  </script>';
			echo 1;
			//header("Location: ../pageElement/createPassword.php");
		}
		
	}
?>