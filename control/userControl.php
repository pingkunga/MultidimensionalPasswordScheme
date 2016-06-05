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
	
	function userUpdate(){
		include ('../control/databaseConnect.php');
		//get user detail
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$phone = $_POST['phone'];
		$email = $_POST['email'];
		$mem_id = $_POST['mem_id'];
		$role = $_POST['role'];
		
		$strSQL = 'UPDATE tbl_member SET member_firstname = ?, member_lastname = ?, ';
		$strSQL = $strSQL.'member_phone = ?, member_email = ?, member_role = ? WHERE member_id = ?';
		$stmt = $conn->prepare($strSQL);
		$stmt->bind_param('ssissi', $firstname, $lastname, $phone, $email, $role, $mem_id);
		$stmt->execute();
		$stmt->close();
		$conn->close();
		echo '1';
	}
	
	function updateRole(){
		include ('../control/databaseConnect.php');
		$strSQL = 'UPDATE tbl_member SET member_role = ? WHERE member_id = ?';
		//echo $strSQL;
		$mem_id = $_POST['mem_id'];
		$role = $_POST['role'];
		if($role==1){
			$mem_role='admin';
		}else{
			$mem_role='user';
		}
		$stmt = $conn->prepare($strSQL);
		$stmt->bind_param('ss', $mem_role,$mem_id);
		$stmt->execute();
		$stmt->close();
		$conn->close();
		
	}
?>