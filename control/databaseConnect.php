<?php
	$host = "localhost";      //hostname
	$user = "root";           //database username
	$password = "";		  	  //database password
	//$database_name = "senior_project";
	$database_name = "multi_dimentional_password";

	/* �� ����������ʼ�ҹ ����˹���颳з��ӡ�õԴ��� MySQL */
	$conn=new mysqli($host, $user, $password, $database_name) or die('Cannot open database');
	
	if ($conn) {
		//echo "�����Ţ����������� MySQL 㹤��駹����  <b>" . $conn . "</b>";
		//mysql_select_db($database_name,$conn);
		//mysql_close($conn);  // �Դ����������� MySQL
	}
	else {
		//echo "�������ö�������͡Ѻ MySQL �� ��سҵ�Ǩ�ͺ������ʵ� ���ͼ���� ������ʼ�ҹ ��Ҷ١��ͧ�������";
	}
?>