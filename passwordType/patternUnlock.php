<?php 
	$object = $_POST["object"]; 
	//echo $object;
	echo '<input type="hidden" name="patternObjectAction" id="patternObjectAction" value="'.$object.'"/>';
	echo '<input type="hidden" name="password" id="password" />';
?>
<!-- <script type="text/javascript" src="../js/jquery-1.8.3.min.js"></script>
<!-- <script type="text/javascript" src="../js/jquery-ui-1.9.2.custom.min.js"></script>-->
<script type="text/javascript" src="../js/jquery.ui.pattern.js"></script>
<!-- <script type="text/javascript" src="../js/patternControl.js"></script>
<!--  <script type="text/javascript" src="../js/patternlock.js"></script>
<link rel="stylesheet" type="text/css" href="jquery.ui.pattern.css"/>-->
<script type="text/javascript">
function setPattern(pattern) {
	if (pattern.length) {
		currentPattern = pattern;
		//alert(currentPattern);
		var pwd = ""
		for (var i = 0; i < currentPattern.length; i++) {
			pwd = pwd + pattern[i];
		}
		$('#password').val(pwd);
		//alert(pwd);
		logDebug(">> You pattern is "+pwd+"<br>");
        //writelog(logD_action,logD_interaction,logD_input,logD_status,logD_remark)
        writelog("get user input","patternUnlock",pwd,"-",">> You pattern is "+pwd);
		$('#pattern-container').pattern('clearPattern', true);
	}

	$('#set-pattern').removeAttr('checked');
}

$('#pattern-container').pattern({
	arrowCorrectImage: 'patternUnlock/arrow-correct.png',
	arrowIncorrectImage: 'patternUnlock/arrow-incorrect.png',
	showPattern: true,
	stop: function (event, ui) {
			setPattern(ui.pattern);
		}
});
</script>
<div id="pattern-container">
</div>