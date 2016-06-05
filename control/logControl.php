<?php
	//include file
	//include ("../control/databaseConnect.php");
	//include ("../control/sessionManager.php");
	if(!isset($_SESSION)) {
		session_start();
	}
	if($_SERVER['REQUEST_METHOD']=='POST') {
		//echo "session call";
		//$data = $_POST[];
		//print('<pre>');
		//print_r($_POST['json']);
		if(isset($_POST['json'])){
			$data = json_decode($_POST['json']);
			//var_dump($data);
			$data2 = (array)$data;
			//echo $data2["call"];
			//print('</pre>');
			//print_r(json_decode($_POST));
			if(isset($data2['call'])){
				$function = $data2['call'];
				if(function_exists($function)) {
					call_user_func($function,$data2);
				} else {
					echo 'Function Not Exists!!';
				}
			}
		}
	}else{
		//echo "wewewe";
	}
	
	//write log into DB
	function writeLog($data2){
		//include ("../control/databaseConnect.php");
		//get parameter
		//get IP and Session ID
		$ip = getRealIpAddr();
		$session_id = session_id();
		//echo $ip.'<br/>';
		//echo $session_id.'<br/>';
		//$obj = $_POST['obj'];
		//echo $obj;
		//encode json
		//$data = json_decode($obj);
		//var_dump($data);
		//check header in same IP AND Session ID
		//1 true : 0 false
		//echo checkHeader($ip,$session_id);
		if(checkHeader($ip,$session_id)){
			//get log header ID
			$logHeaderID = getLogHeaderID($ip,$session_id);
			//write a log in session detail only
			writeLogDetail($logHeaderID,$data2);
		}else{
			//not header then create
			//create log header
			$logHeaderID = insertLogHeader($ip,$session_id);
			//write a log in session detail
			writeLogDetail($logHeaderID,$data2);
		}
		
		
		//else then write into DB
	}
	
	//check header in DB
	function checkHeader($ip,$session_id){
		include('../control/databaseConnect.php');
		$strSQL = 'SELECT * FROM tbl_logheader WHERE logH_ip = "'.trim($ip).'" AND logH_session = "'.trim($session_id).'"';
		$objQuery=$conn->query($strSQL) or die(mysql_error());
		$objResult = $objQuery->fetch_assoc();
		if(!$objResult){
			//echo 'false_text <br/>';
			$conn->close();
			return false;
		}else{
			//echo 'true_text <br/>';
			$conn->close();
			return true;
		}
	}
	
	function insertLogHeader($ip,$session_id){
		include('../control/databaseConnect.php');
		$strSQL = 'INSERT INTO tbl_logheader(logH_ip,logH_session,logH_datetime) VALUES (?, ?, ?)';
		//echo $strSQL;
		$logH_datetime = date('Y-m-d H:i:s');
		$stmt = $conn->prepare($strSQL);
		$stmt->bind_param('sss', $ip,$session_id,$logH_datetime);
		$stmt->execute();
		$newId = $stmt->insert_id;
		$stmt->close();
		$conn->close();
		return $newId;
	}
	
	function getLogHeaderID($ip,$session_id){
		include('../control/databaseConnect.php');
		$strSQL = 'SELECT * FROM tbl_logheader WHERE logH_ip = "'.trim($ip).'" AND logH_session = "'.trim($session_id).'"';
		$objQuery=$conn->query($strSQL) or die(mysql_error());
		$objResult = $objQuery->fetch_assoc();
		//$stmt->close();
		$conn->close();
		return $objResult['logH_id'];
	}
	
	function writeLogDetail($logH_id,$data2){
		include('../control/databaseConnect.php');
		//get data
		//print_r($data2);
		$logHeader_id = $logH_id;
		$logD_action = $data2['logD_action'];
		$logD_interaction = $data2['logD_interaction'];
		$logD_input = $data2['logD_input'];
		$logD_status = $data2['logD_status'];
		$logD_remark = $data2['logD_remark'];
		//$logD_mode = checkMode();
		//get user status
		$strSQL = 'INSERT INTO tbl_logdetail(logD_action,logD_interaction,logD_input,';
		$strSQL = $strSQL.'logD_status,logD_remark,logH_id) VALUES (?, ?, ?, ?, ?, ?)';
		//echo $strSQL;
		$stmt = $conn->prepare($strSQL);
		$stmt->bind_param('sssssi', $logD_action,$logD_interaction,$logD_input,$logD_status,$logD_remark,$logH_id);
		//$stmt->bind_param('ssssss', "test","test","test","test","test",1);
		$stmt->execute();
		$newId = $stmt->insert_id;
		$stmt->close();
		$conn->close();
	}
	function checkMode(){
		if(isset($_SESSION['userStatus'])){
			$type = $_SESSION['userStatus'];
			if($type=='registration'){
				$mode = 'registration';
			}else if($type=='forgotPwd'){
				$mode = 'forgot password';
			}
		}else{
			$mode = 'authentication';
		}
		return $mode;
	}
	function updateLogHeaderByMemID($member_id){
		include('../control/databaseConnect.php');
		$logH_mode = checkMode();
		$ip = getRealIpAddr();
		$session_id = session_id();
		$strSQL = 'UPDATE tbl_logheader SET logH_mode = ? , member_id = ? WHERE logH_ip = ? AND logH_session =?';
		//echo $strSQL;
		$stmt = $conn->prepare($strSQL);
		$stmt->bind_param('siss', $logH_mode, $member_id,$ip,$session_id);
		$stmt->execute();
		$stmt->close();
		$conn->close();
	}
	
	//this function calculate time for each log
	function calculateEachLogTime($logH_id,$logH_datetime){
		include('../control/databaseConnect.php');
		$strSQL = 'SELECT logD_time FROM tbl_logdetail';
		$strSQL = $strSQL.' WHERE logH_id = "'.$logH_id.'"';
		$strSQL = $strSQL.' ORDER BY logD_id DESC LIMIT 1';
		$objQuery=$conn->query($strSQL) or die(mysql_error());
		$objResult = $objQuery->fetch_assoc();
		//LastTime
		$lastTime = $objResult['logD_time'];
		$conn->close();
		//DiffTime in second $lastTime - $logH_datetime
		$logTime = strtotime($lastTime) - strtotime($logH_datetime);
		return $logTime;
	}
	
	//echo getRealIpAddr().'<br/>';
	//echo "5555555".'<br/>';
	function getRealIpAddr()
	{
		if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
		{
			$ip=$_SERVER['HTTP_CLIENT_IP'];
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
		{
			$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else
		{
			$ip=$_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}
?>