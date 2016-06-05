<?php
	session_start();
	//include file
	include ("../control/checkAdmin.php");
	include ('../control/databaseConnect.php');
	//$per_page = 10; //record per page
	if($_GET)
	{
		$logH_id=$_GET['logH_id'];
		$diffTime=$_GET['diffTime'];
		//$page=$_GET['page'];
	}
	$strSQL = 'SELECT * '; 
	$strSQL = $strSQL.'FROM tbl_logheader ';
	$strSQL = $strSQL.'LEFT JOIN tbl_logdetail ON ( tbl_logheader.logH_id = tbl_logdetail.logH_id ) ';
	$strSQL = $strSQL.'LEFT JOIN tbl_member ON ( tbl_logheader.member_id = tbl_member.member_id ) ';
	$strSQL = $strSQL."WHERE tbl_logheader.logH_id = $logH_id";
	$objQuery=$conn->query($strSQL) or die(mysql_error());
	$objResult = $objQuery->fetch_assoc();
	//print_r($objQuery)."<br>";
	//$r_num = mysql_num_rows($objResult);
?>
<script type="text/javascript">
	function Display_Load()
	{
		//$("#loading").fadeIn(900,0);
		//$("#loading").html("<img src="bigLoader.gif" />");
	}
	//Hide Loading Image
	function Hide_Load()
	{
		//$("#loading").fadeOut('slow');
	}

	function backToPage(pageNum){
		//alert(pageNum);
		//$("#logPagination").load("listLogData.php?page=1", Hide_Load());
		$("#logPagination").load("listLogData.php?page=" + pageNum, Hide_Load());
		$('#pagination').show();
	}
</script>
<div id="logDetail">
	<h2>Log Information</h2>
	<?php //echo "<a href='#' id=$page class='backPage' onclick='backToPage($page)'>&nbsp;&nbsp;&nbsp;<< Back</a>";?></td>
	<table>
		<tr>
			<td>
				<table>
					<tr>
						<td>logH_id</td>
						<td><?php echo $objResult['logH_id'];?></td>
					</tr>
					<tr>
						<td>logH_ip</td>
						<td><?php echo $objResult['logH_ip'];?></td>
					</tr>
					<tr>
						<td>logH_session</td>
						<td><?php echo $objResult['logH_session'];?></td>
					</tr>
					<tr>
						<td>logH_mode</td>
						<td><?php echo $objResult['logH_mode'];?></td>
					</tr>
					<tr>
						<td>logH_datetime</td>
 						<td><?php echo $objResult['logH_datetime'];?></td>
					</tr>
					<tr>
						<td>Total time</td>
 						<td><?php echo $diffTime.' sec';?></td>
					</tr>
					<tr>
						<td>member_login</td>
						<td><?php echo $objResult['member_login'];?></td>
					</tr>
				</table>	
			</td>
		</tr>
		<tr>
			<td>
				<table>
					<thead>
						<th>logD_id</th>
						<th>logD_time</th>
						<th>logD_action</th>
						<th>logD_interaction</th>
						<th width="120">logD_input</th>
						<th>logD_status</th>
						<th>logD_remark</th>
					</thead>
					<tbody>
						<?php
						while($objResult = $objQuery->fetch_assoc()){
							$logHeaderID = $objResult['logH_id'];
						?>
						  <tr>
						    <td><?php echo $objResult['logD_id'];?></td>
						    <td><?php echo $objResult['logD_time'];?></td>
						    <td><?php echo $objResult['logD_action'];?></td>
						    <td><?php echo $objResult['logD_interaction'];?></td>
						    <td><?php echo $objResult['logD_input'];?></td>
						    <td><?php echo $objResult['logD_status'];?></td>
						    <td><?php echo $objResult['logD_remark'];?></td>
						  </tr>
						<?php
						}
						$conn->close();
						?>
					</tbody>
				</table>
			</td>
		</tr>
	</table>
</div>