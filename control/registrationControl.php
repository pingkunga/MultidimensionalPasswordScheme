<?php
	session_start();
	//include file
	//include ("../control/databaseConnect.php");
	include ('../control/logControl.php');
	include ('../control/sessionManager.php');
	
	if($_SERVER['REQUEST_METHOD']=='POST') {
		//echo "session call";
		if(isset($_POST['call'])){
			$function = $_POST['call'];
			if(function_exists($function)) {
				call_user_func($function);
			} else {
				//echo 'Function Not Exists!!';
			}
		}
	}else if($_SERVER['REQUEST_METHOD']=='GET'){
		if(isset($_GET['call'])){
			$function = $_GET['call'];
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
	
	function registration(){
		//include file
		
		include ('../control/databaseConnect.php');
		//get first time scenario
		$firstPwd = getPassword(1);
		//echo $firstPwd.'<br/>';
		//get second time scenario
		$secondPwd = getPassword(2);
		//echo $secondPwd.'<br/>';
		//==============================================================
		$ip = getRealIpAddr();
		$logH_id = getLogHeaderID($ip,session_id());
		//==============================================================
		//compare first time scenario && second time scenario
		//print_r($_SESSION);
		//Encryption
		$encryptPwd = sha1(md5($firstPwd));
		if($firstPwd==$secondPwd){
			//check session type
			$type = $_SESSION['userStatus'];
			
			echo $type;
			//echo $firstPwd.'<br/>';
			//echo $secondPwd.'<br/>';
			//==============================================================
			$data['logD_action']='vertify';
			$data['logD_interaction']='-';
			$data['logD_input']=$firstPwd;
			$data['logD_status']='passwordData';
			$data['logD_remark']='>> vertify password';
			writeLogDetail($logH_id,$data);
			//==============================================================
			if($type=='registration'){
				//get user data
				$firstname = $_SESSION['userInfo']['firstname'];
				$lastname = $_SESSION['userInfo']['lastname'];
				$phone = $_SESSION['userInfo']['phone'];
				$email = $_SESSION['userInfo']['email'];
				$username = $_SESSION['userInfo']['username'];
				//SQL
				$strSQL = 'INSERT INTO tbl_member(member_firstname,member_lastname,member_phone,';
				$strSQL = $strSQL.'member_email,member_login,member_pwd) VALUES (?, ?, ?, ?, ?, ?)';
				//echo $strSQL;
				$stmt = $conn->prepare($strSQL);
				$stmt->bind_param('ssisss', $firstname,$lastname,$phone,$email,$username,$encryptPwd);
				$stmt->execute();
				$newId = $stmt->insert_id;
				//assign member id to log
				updateLogHeaderByMemID($newId);
				$stmt->close();
			}else if($type=='forgotPwd'){
				//post data
				$scenarioType = checkAuthType();
				$username = $_SESSION[$scenarioType]['username'];
				$email = $_SESSION[$scenarioType]['email'];
				//sql
				$strSQL = 'UPDATE tbl_member SET member_pwd = ? WHERE member_login = ? AND member_email =?';
				//echo $strSQL;
				$stmt = $conn->prepare($strSQL);
				$stmt->bind_param('sss', $encryptPwd,$username,$email);
				$stmt->execute();
				$stmt->close();
				$strSQL = 'SELECT member_id FROM tbl_member WHERE member_login = "'.mysql_real_escape_string(trim($username)).'" AND member_email = "'.mysql_real_escape_string(trim($email)).'"';
				echo $strSQL;
				$objQuery=$conn->query($strSQL) or die(mysql_error());
				$objResult = $objQuery->fetch_assoc();
				echo $objResult['member_id'];;
				//$updateID = getUserID($username,$email);
				updateLogHeaderByMemID($objResult['member_id']);
				//echo "Forgot Complete";
			}
			$conn->close();
			//echo "Complete";
			//header("Location: http://localhost/sci422/proj3D/pageElement/success.php");
			//session_destroy();
			session_regenerate_id();
			session_unset();
			echo '<script type="text/javascript">
					location.href="/sci422/proj3D/pageElement/success.php";
				</script>';
			//exit();
		}else{
			//delete user session scenario (unset enterTime)
			//unsetAllScenario();
			//set mode
			//echo 'mode: password not match';
			//$_SESSION['errorMag'] = 'Password not match';
			//redirect to regisuser detail page
			echo '<script type="text/javascript">
					//alert("pwd not match");
					window.location="http://localhost/sci422/proj3D/";
				  </script>';
		}
	}
	
	function getUserID($username,$email){
		//include file
		include ('../control/databaseConnect.php');
		$strSQL = 'SELECT member_id FROM tbl_member WHERE member_login = ? AND member_email =?';
		$stmt = $conn->prepare($strSQL);
		$stmt->bind_param('ss', trim($username),trim($email));
		$stmt->execute();
		$stmt->bind_result($member_id);
		$conn->close();
		return $member_id;
	}
	function passwordMatch(){
		//include ('../control/logControl.php');
		$firstPwd = getPassword(1);
		//echo $firstPwd.'<br/>';
		//get second time scenario
		$secondPwd = getPassword(2);
		//echo $secondPwd.'<br/>';
		if($firstPwd!=$secondPwd){
			//delete user session scenario (unset enterTime)
			//unsetAllScenario();
			//==============================================================
			//$ip = getRealIpAddr();
			$ip = '127.0.0.1';
			$logH_id = getLogHeaderID($ip,session_id());
			//==============================================================
			$data['logD_action']='vertify';
			$data['logD_interaction']='-';
			$data['logD_input']= $firstPwd.' and '.$secondPwd;
			$data['logD_status']="passwordNotMatch";
			$data['logD_remark']='>> passwordNotMatch '.$firstPwd.' and '.$secondPwd;
			writeLogDetail($logH_id,$data);
			//==============================================================
			//true
			echo 1;
		}else{
			//false
			echo 0;
		}
	}

	function chkSameInDB(){
		include ('../control/databaseConnect.php');
		$key = $_POST['data1'];
		$field = $_POST['data2'];
		if($field=='username'){
			$strSQL = 'SELECT * FROM tbl_member WHERE member_login = "'.mysql_real_escape_string(trim($key)).'"';
		}else if($field=='email'){
			$strSQL = 'SELECT * FROM tbl_member WHERE member_email = "'.mysql_real_escape_string(trim($key)).'"';
		}
		$objQuery=$conn->query($strSQL) or die(mysql_error());
		$objResult = $objQuery->fetch_assoc();
		if(!$objResult){
			//Not found
			echo 0;
		}else{
			//Found
			echo 1;
		}
		$conn->close();
	}
?>