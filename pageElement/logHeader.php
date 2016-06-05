<?php
	session_start();
	//include file
	include ("../control/checkAdmin.php");
	include ('../control/databaseConnect.php');
	include ('../control/logControl.php');
	$per_page = 10; //record per page
	//if($_GET)
	//{
	//	$page=$_GET['page'];
	//}
	//$start = ($page-1)*$per_page;
	$strSQL = 'SELECT tbl_logheader.logH_id, tbl_logheader.logH_ip, tbl_logheader.logH_session, ';
	$strSQL = $strSQL.'tbl_logheader.logH_mode, tbl_logheader.logH_datetime, MAX(tbl_logdetail.logD_time) AS logD_time, ';
	$strSQL = $strSQL.'MAX(tbl_logdetail.logD_id), tbl_member.member_login ';
	$strSQL = $strSQL.'FROM tbl_logheader LEFT JOIN tbl_logdetail ';
	$strSQL = $strSQL.'ON tbl_logheader.logH_id = tbl_logdetail.logH_id ';
	$strSQL = $strSQL.'LEFT JOIN tbl_member ON ( tbl_logheader.member_id = tbl_member.member_id ) ';
	$strSQL = $strSQL.'GROUP BY tbl_logdetail.logH_id';
	//$strSQL = 'SELECT logH_id, logH_ip, logH_session, logH_mode, logH_datetime FROM tbl_logheader';
	//$strSQL = $strSQL." ORDER by logH_id limit $start,$per_page";
	$objQuery=$conn->query($strSQL) or die(mysql_error());
	//$objResult = $objQuery->fetch_assoc();
	//var_dump($objResult)."<br>";
	//$r_num = mysql_num_rows($objResult);
?>
<!-- List all log -->
<link rel="stylesheet" href="../css/dataList.css" />
<script type="text/javascript" src="../js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="../js/jquery.jplist.3.4.min.js"></script>
<script type="text/javascript">
$("document").ready(function(){
	var jplist = $("#demo").jplist({
		sort: {logH_id: "td.logH_id"},
		filter: {member: "td.member",
				 mode: "td.mode"},
		filter_path: "#filter",
		sort_is_num : "true",
		sort_name: "logH_id",
		items_box: ".logTable tbody.content",
		item_path: "tr.logRecord",
		items_on_page: 10
	}); 
	 //e.preventDefault();
	 //var log_id = $('.viewLog').attr('id');
	 //console.log(log_id);
});
function show_detail(log_id,diffTime){  
	// $("#detailDlg").on( "dialogopen", function(e) {
		 //$(window).unbind('dialogopen');
	        //if(e.handled !== true){
	        //console.log( 'script loaded' );
			//$('#detailDlg').load('logDetail.php?logH_id='+log_id);
			//$('#logDetail').remove();
			//$('#detailDlg').attr('title','Log detail');
			$.ajax({
				type: 'GET',
				url: 'logDetail.php',
				data: {'logH_id':log_id,
					  'diffTime':diffTime},
				cache: false,
				success: function(html){
					//$(window).bind('dialogopen');
					//$('#pagination').hide();
					$('#rightContent').html(html);
				},
				async:true
			});
			//e.handled = true;
			return false;
	// } );
	// $("#detailDlg").dialog("open");
 }
</script>
<div id="demo" class="books-list">
	<div class="panel">
		<div id="filter">
			<p>
				<b>Filter by Member login</b>:
				<input class="member" type="text" value="" style="margin: 0px 20px 0px 20px;" /> 
				<b>Filter by mode</b>:
				<input class="mode" type="text" value="" style="margin-left: 20px;" />
			</p>
			<br/>
		</div>
		<!-- <div id="sorts">
			<div class="drop-down" id="sort-drop-down">
				<b>Sorting:</b> &nbsp;
				<ul>
					<li><span class="logH_id asc true"> log_id: ascending </span></li>
					<li><span class="logH_id desc true"> log_id: descending </span></li>
				</ul>
			</div>
		</div>-->
		<p>
			<br/>
			<br/>
		</p>
		<div id="paging">
			<div class="text">
				<b>Paging:</b>
			</div>
			<div id="buttons"></div>
			<div id="info"></div>
			<div class="drop-down" id="page-by">
				<ul>
					<li><span class="p3"> 3 per page </span></li>
					<li><span class="p5"> 5 per page </span></li>
					<li><span class="p10"> 10 per page </span></li>
					<!--<li><span class="all"> view all </span></li>-->
				<ul>
			</div>

		</div>
	</div>
	<!-- table -->
	<table class="logTable">
		<thead>
			<th>log_id</th>
			<th>ip</th>
			<th>session</th>
			<th>mode</th>
			<th>datetime</th>
			<th>time(sec)</th>
			<th>member</th>
			<th>view detail</th>
		</thead>
		<tbody class="content">
			<?php
			while($objResult = $objQuery->fetch_assoc()){
			$logHeaderID = $objResult['logH_id'];
			//diff time
			$diffTime = strtotime($objResult['logD_time']) - strtotime($objResult['logH_datetime']);
			?>
			<tr class="logRecord">
				<td class="logH_id"><?php echo $objResult['logH_id'];?></td>
				<td class="ip"><?php echo $objResult['logH_ip'];?></td>
				<td><?php echo $objResult['logH_session'];?></td>
				<td class="mode"><?php echo $objResult['logH_mode'];?></td>
				<td class="date"><?php echo $objResult['logH_datetime'];?></td>
				<td><?php echo $diffTime;?></td>
				<td class="member"><?php echo $objResult['member_login'];?></td>
				<td><?php echo "<a href='#' id=$logHeaderID class='viewLog' onclick='show_detail($logHeaderID,$diffTime)'>view</a>";?>
				</td>
			</tr>
			<?php
		}
		$conn->close();
		?>
		</tbody>
	</table>
</div>