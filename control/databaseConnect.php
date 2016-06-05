<?php
	$host = "localhost";      //hostname
	$user = "root";           //database username
	$password = "";		  	  //database password
	//$database_name = "senior_project";
	$database_name = "multi_dimentional_password";

	/* ใช้ ชื่อและรหัสผ่าน ที่กำหนดไว้ขณะที่ทำการติดตั้ง MySQL */
	$conn=new mysqli($host, $user, $password, $database_name) or die('Cannot open database');
	
	if ($conn) {
		//echo "หมายเลขการเชื่อมต่อ MySQL ในครั้งนี้คือ  <b>" . $conn . "</b>";
		//mysql_select_db($database_name,$conn);
		//mysql_close($conn);  // ปิดการเชื่อมต่อ MySQL
	}
	else {
		//echo "ไม่สามารถเชื่อมต่อกับ MySQL ได้ กรุณาตรวจสอบชื่อโฮสต์ ชื่อผู้ใช้ และรหัสผ่าน ว่าถูกต้องหรือไม่";
	}
?>