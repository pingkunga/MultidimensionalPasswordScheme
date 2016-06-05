<?php
	if(!isset($_SESSION)) {
	     session_start();
	}
	if($_SERVER['REQUEST_METHOD']=='POST') {
		//echo "session call";
		if(isset($_POST['call'])){
			$function = $_POST['call'];
			if(function_exists($function)) {
				call_user_func($function);
			} else {
				echo 'Function Not Exists!!';
			}
		}
	}else{
		//echo "wewewe";
	}
	
	function storeScenario(){
		$password = $_POST['data1'];
		$object = $_POST['data2'];
		echo $object.'<br>';
		echo $password.'<br>';
		//0. check type
		$scenarioType = checkAuthType();
		//1. update scenario count++
		if(isset($_SESSION[$scenarioType]['enterTime'])){
			$enterTime = $_SESSION[$scenarioType]['enterTime'];
			echo $enterTime.'enter time<br>';
			//get scenarioCnt
			$scenarioCnt = getScenarioCnt($enterTime);
			//insert scenario into session
			$_SESSION[$scenarioType][$enterTime][$scenarioType.'scenario'][$scenarioCnt]['object'] = $object;
			$_SESSION[$scenarioType][$enterTime][$scenarioType.'scenario'][$scenarioCnt]['password'] = $password;
			//$_SESSION[$scenarioType]['enterTime'][$scenarioType.'scenario'][$scenarioCnt] = $eachScenarioData;
		}else{
			$enterTime = '1';
			$_SESSION[$scenarioType]['enterTime'] = $enterTime; // create
			//set scenarioCnt
			$scenarioCnt = getScenarioCnt($enterTime);
			//insert scenario into session
			$_SESSION[$scenarioType][$enterTime][$scenarioType.'scenario'][$scenarioCnt]['object'] = $object;
			$_SESSION[$scenarioType][$enterTime][$scenarioType.'scenario'][$scenarioCnt]['password'] = $password;
		}
		session_write_close();
		print_r($_SESSION);
	}
	function getScenarioCnt($enterTime){
		$scenarioType = checkAuthType();
		if(isset($_SESSION[$scenarioType][$enterTime]['scenarioCnt'])){
			$scenarioCnt = $_SESSION[$scenarioType][$enterTime]['scenarioCnt'];
			$scenarioCnt++;
			$_SESSION[$scenarioType][$enterTime]['scenarioCnt'] = $scenarioCnt;
		}else{
			$scenarioCnt = 1;
			$_SESSION[$scenarioType][$enterTime]['scenarioCnt'] = $scenarioCnt;
		}
		return $scenarioCnt;
	}
	
	function updateEntertime(){
		//call when create password has been finish
		echo 'call updateEnterTime';
		$scenarioType = checkAuthType();
		echo $scenarioType;
		if(isset($_SESSION[$scenarioType]['enterTime'])){
			$_SESSION[$scenarioType]['enterTime'] = '2'; // repeated
			echo $_SESSION[$scenarioType]['enterTime'];
		}
		print_r($_SESSION);
	}
	
	function unSetUserStatus(){
		//print_r($_SESSION);
		//echo 'successful unSetUserStatus <br/>';
		session_unset();
		//renew session id
		session_regenerate_id();
		//print_r($_SESSION);
	}
	
	function unsetScenario(){
		//get authType
		$scenarioType = checkAuthType();
		//get current enter time
		if(isset($_SESSION[$scenarioType]['enterTime'])){
			$enterTime = $_SESSION[$scenarioType]['enterTime'];
			echo '<br>'.$enterTime.'<br>';
			if(isset($_SESSION[$scenarioType][$enterTime]['scenarioCnt'])){
				$scenarioCnt = 1;
				//try to unset session
				unset($_SESSION[$scenarioType][$enterTime]);
				//$_SESSION[$scenarioType][$enterTime]['scenarioCnt'] = $scenarioCnt;
				print_r($_SESSION);
			}
			//print_r($_SESSION);
		}else{
			echo 'not found';
		}
		
	}
	
	function unsetAllScenario(){
		//get authType
		$scenarioType = checkAuthType();
		//try to unset session
		unset($_SESSION[$scenarioType]);
		print_r($_SESSION);
	}
	
	function checkAuthType(){
		if(isset($_SESSION['userStatus'])){
			$type = $_SESSION['userStatus'];
			if($type=='registration'){
				$scenarioType = 'regis';
			}else if($type=='forgotPwd'){
				$scenarioType = 'forgot';
			}
		}else{
			$scenarioType = 'auth';
		}
		return $scenarioType;
	}
	
	function getPassword($enterTime){
		$scenarioType = checkAuthType();
		//echo $scenarioType.'<br/>';
		$passwordData = "";
		//echo '2332323323223233'.$_SESSION[$scenarioType]['scenarioCnt'].'<br>';
		$scenario[] = $_SESSION[$scenarioType][$enterTime]['scenarioCnt'];
		//print_r($scenario);
		//print_r($_SESSION);
		for($i=1;$i<=$scenario[0];$i++){
			//echo "-----------------------------------";
			//$tmp = $_SESSION[$scenarioType][$i];
			$tmp = $_SESSION[$scenarioType][$enterTime][$scenarioType.'scenario'][$i]['object'];
			//echo $tmp.'<br>';
			$passwordData = $passwordData.'['.$tmp.']';
			$tmp = $_SESSION[$scenarioType][$enterTime][$scenarioType.'scenario'][$i]['password'];
			//echo $tmp.'<br>';
			$passwordData = $passwordData.$tmp;
		}
		//may be encryption
		return $passwordData;
	}
	
	function setUserDetail(){
		//get user detail
		$firstname = $_POST['firstname']; 
		$lastname = $_POST['lastname'];
		$phone = $_POST['phone'];
		$email = $_POST['email'];
		$username = $_POST['username'];
		//insert into session
		$_SESSION['userInfo']['firstname'] = $firstname;
		$_SESSION['userInfo']['lastname'] = $lastname;
		$_SESSION['userInfo']['phone'] = $phone;
		$_SESSION['userInfo']['email'] = $email;
		$_SESSION['userInfo']['username'] = $username;
		session_write_close();
	}
	
	function checkEmptyScenario(){
		include ('../control/logControl.php');
		//get password
		$scenarioType = checkAuthType();
		$enterTime = 1;
		if(isset($_SESSION[$scenarioType][$enterTime]['scenarioCnt'])){
			//pass
			echo 0;
		}else{
			//empty password
			echo 1;
			//==============================================================
			//$ip = getRealIpAddr();
			//$logH_id = getLogHeaderID($ip,session_id());
			//==============================================================
			//$data['logD_action']='vertify';
			//$data['logD_interaction']='-';
			//$data['logD_input']= '';
			//$data['logD_status']="emptyScenario";
			//$data['logD_remark']='>> empty password scenario';
			//writeLogDetail($logH_id,$data);
			//==============================================================
		}
	}
?>