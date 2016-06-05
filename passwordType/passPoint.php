<style type="text/css">
#grid-source {
	position: absolute;
}

#grid-overlay {
	position: relative;
}

table#wrap {
	border-spacing: 0px;
}

.hover {
	background-color: rgba(0, 0, 0, 0.1) !important;
}

.unselected {
	background-color: rgba(0, 0, 0, 0.5);
}

.selected {
	background-color: none;
}
</style>
<!-- <script type="text/javascript" src="../js/jquery-1.8.3.min.js"></script> -->
<script type="text/javascript">
	var $gridSelectCnt = 0;
	var gridSelect = new Array() ;
	function grid(){
		// Handler for .ready() called.  เรียกใช้ Jquery ให้ทำงาน
		var $src = $('#grid-source');
		var $wrap = $('<div id="grid-overlay"></div>');
		var $gsize = 30;

		//var $cols = Math.ceil($src.find('img').innerWidth() / $gsize);
		//var $rows = Math.ceil($src.find('img').innerHeight() / $gsize);
		
		//var $img = document.getElementById('imgid');
		var $width = $("#imgid").width();
		var $height = $("#imgid").height();
		//$("#passPointDlg").on( "dialogopen", function() {
		//	$("#passPointDlg").dialog( "option", "width", $width );
		//	$("#passPointDlg").dialog( "option", "height", $height+70 );
		//} );
		console.log($width);
		console.log($height);
		
		var $cols = Math.ceil($width / $gsize);
		var $rows = Math.ceil($height / $gsize);
		console.log("a"+($gsize*$cols)+"b"+($gsize*$rows));
		//set div size
		$src.css('width',($gsize*$cols)+'px');
		$src.css('height',($gsize*$rows)+'px');
		$("#passPointDlg").dialog( "option", "width", (($gsize*$cols)+50));
		
		// create overlay
		var $tbl = $('<table id="wrap" cellpadding="0" cellspacing="0"></table>');
		for (var y = 1; y <= $rows; y++) {
		    var $tr = $('<tr></tr>');
		    for (var x = 1; x <= $cols; x++) {
		    	var $id = y.toString()+"_"+x.toString();
		        var $td = $('<td id='+$id+'></td>');
		        $td.css('width', $gsize+'px').css('height', $gsize+'px');
		        $td.addClass('unselected');
		        $tr.append($td);
		    }
		    $tbl.append($tr);
		}
		$src.css('width', $cols*$gsize+'px').css('height', $rows*$gsize+'px')

		// attach overlay
		$wrap.append($tbl);
		$src.after($wrap);
		
		console.log("Passs");

		$('#grid-overlay td').hover(function() {
		    $(this).toggleClass('hover');
		});

		$('#grid-overlay td').click(function() {
		    $(this).toggleClass('selected').toggleClass('unselected');
		    //get element id
		    var $selectID = $(this).attr('id');
		    console.log($selectID);
		    var $class = $(this).attr('class');
		    var $status = $class.substring(6);
		    console.log($class);
		    console.log($status);
		    
		    //check type
		    //selected then add into array
		    if($status=='selected'){
		    	console.log('1');
		    	gridSelect.push($selectID);
		    	logDebug(">>You click is "+$selectID+"<br/>");
                //writelog(logD_action,logD_interaction,logD_input,logD_status,logD_remark)
                writelog("get user click","passPoint",$selectID,"-",">> You click is "+$selectID);
		    }else if($status=='unselected'){
		    	//unselected then delete from array
		    	console.log('2');
		    	gridSelect.splice($.inArray($selectID, gridSelect),1);
		    	logDebug(">>You remove click is "+$selectID+"<br/>");
                //writelog(logD_action,logD_interaction,logD_input,logD_status,logD_remark)
                writelog("get user remove","passPoint",$selectID,"-",">> You remove click is "+$selectID);
		    }
		    //more optimization ?
		    setPassword(gridSelect);
		    console.log(gridSelect);
		});
	}
	function setPassword(gridSelect){
		var pwd = "";
		var lengths = gridSelect.length;
		for(var i=0; i<lengths;i++){
			pwd = pwd + gridSelect[i];
		}
		//$("#log").append(">>"+date+":"+time+"-Action: remove "+$pwd+"<br>");
		$('#password').val(pwd);
		console.log('pwd'+pwd);
	}
	function getPassword(){
		return gridSelect;
	}
	/*$(document).ready(function() {
		$("#imgid").load(function(){
			//use this event to check img id="imdid" that load already
			//call method to make grid
			grid();
					
		})
	});*/
	$("#imgid").load(function(){
		//use this event to check img id="imdid" that load already
		//call method to make grid
		grid();
				
	})
</script>
<div id="grid-source">
	<?php
		//$object = "television";
		$object = $_POST["object"];
		//echo $object;
		//var_dump($object);
		echo '<input type="hidden" name="ppObjectAction" id="ppObjectAction" value="'.$object.'"/>';
		if($object=="pictureOfSWU"){
			echo '<img id="imgid" src="../3Delement/3Dimg/swuOcta.jpg">';
		}else if($object=="television"){
			echo '<img id="imgid" src="../3Delement/3Dimg/the_sun.jpg">';
			//echo '<img id="imgid" src="http://www.google.com/images/logos/ps_logo2.png">';
		}
	?>
</div>
<input type="hidden" name="password" id="password"/>