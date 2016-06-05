<?php
	session_start();
	//include file
	include ("../control/checkAdmin.php");
	include ("../control/databaseConnect.php");
	//include ("../control/sessionManager.php");
	$per_page = 10; //record per page
	
	$strSQL = "SELECT member_id, member_login, member_email, member_role FROM tbl_member";
	//$strSQL = $strSQL." ORDER by member_id limit $start,$per_page";
	$objQuery=$conn->query($strSQL) or die(mysql_error());
	//$objResult = $objQuery->fetch_assoc();
	//print_r($objResult)."<br>";
	//$r_num = mysql_num_rows($objResult);
?>
<!-- List all user -->
<link rel="stylesheet" href="../css/dataList.css" />
<script type="text/javascript" src="../js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="../js/jquery.jplist.3.4.min.js"></script>
<script type="text/javascript">
$("document").ready(function(){
	var jplist = $("#demo").jplist({
		sort: {member_id: "td.member_id"},
		filter: {member: "td.member",
				 email: "td.email"},
		filter_path: "#filter",
		sort_is_num : "true",
		sort_name: "member_id",
		items_box: ".userTable tbody.content",
		item_path: "tr.userRecord",
		items_on_page: 10
	}); 
	 //e.preventDefault();
	 //var log_id = $('.viewLog').attr('id');
	 //console.log(log_id);
});
function show_detail(mem_id){  
	// $("#detailDlg").on( "dialogopen", function(e) {
		 //$(window).unbind('dialogopen');
	        //if(e.handled !== true){
	        //console.log( 'script loaded' );
			//$('#detailDlg').load('logDetail.php?logH_id='+log_id);
			//$('#logDetail').remove();
			//$('#detailDlg').attr('title','Log detail');
			$.ajax({
				type: 'GET',
				url: 'userDetail.php',
				data: {'mem_id':mem_id},
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
				<b>Filter by E-mail</b>:
				<input class="email" type="text" value="" style="margin-left: 20px;" />
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
	<table class="userTable">
		<thead>
		<th>member_id</th>
		<th>member_login</th>
		<th>member_email</th>
		<th>member_role</th>
		<th>view detail</th>
	</thead>
		<tbody class="content">
			<?php
		while($objResult = $objQuery->fetch_assoc()){
			$mem_id = $objResult['member_id'];
			$mem_login = $objResult['member_login'];
		?>
		  <tr class="userRecord">
		    <td class="member_id"><?php echo $objResult['member_id'];?></td>
		    <td class="member"><?php echo $objResult['member_login'];?></td>
		    <td class="email"><?php echo $objResult['member_email'];?></td>
		    <td><?php echo $objResult['member_role'];?></td>
		     <td><?php echo "<a href='#' id=$mem_id class='viewLog' onclick='show_detail($mem_id)'>view</a>";?></td>
		  </tr>
		<?php
		}
		$conn->close();
		?>
		</tbody>
	</table>
</div>