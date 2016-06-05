<?php 
	//$object = $_POST["object"]; 
	//echo $object;
	//echo '<input type="hidden" name="patternObjectAction" id="patternObjectAction" value="'.$object.'"/>';
?>
<script type="text/javascript" src="../js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery.ui.pattern.js"></script>
<script type="text/javascript" src="../js/patternControl.js"></script>
<!--  <script type="text/javascript" src="../js/patternlock.js"></script>-->
<link rel="stylesheet" type="text/css" href="jquery.ui.pattern.css"/>
<script type="text/javascript">
$('#show-pattern').click(function () {
	$('#pattern-container').pattern('option', 'showPattern', $('#show-pattern').is(':checked'));
});

$('#multi-select').click(function () {
	$('#pattern-container').pattern('option', 'multiSelect', $('#multi-select').is(':checked'));
});

$('#disabled').click(function () {
	if ($('#disabled').is(':checked')) {
		$('#pattern-container').pattern('disable');
	} else { 
		$('#pattern-container').pattern('enable');
	}
});

function setPattern(pattern) {
	if (pattern.length) {
		currentPattern = pattern;
		alert(currentPattern);
		$('#pattern-container').pattern('clearPattern', true);
	}

	$('#set-pattern').removeAttr('checked');
}

function checkPattern(pattern) {
	// Note: this is where you would contact the server to check the supplied pattern. 
	// When the check is complete, you can call clearPattern: 
	// $('#pattern-container').pattern('clearPattern', RESULT);, where RESULT is 
	// true or false, depending on the result of the check.
	if (currentPattern.length == pattern.length) {
		for (var i = 0; i < pattern.length; i++) {
			if (pattern[i] != currentPattern[i]) {
				$('#pattern-container').pattern('clearPattern', false);
				return;
			}
		}

		$('#pattern-container').pattern('clearPattern', true);
	} else {
		$('#pattern-container').pattern('clearPattern', false);
	}
}

$('#pattern-container').pattern({
	arrowCorrectImage: 'patternUnlock/arrow-correct.png',
	arrowIncorrectImage: 'patternUnlock/arrow-incorrect.png',
	stop: function (event, ui) {
		if ($('#set-pattern').is(':checked')) {
			// Note: for demo purposes...
			setPattern(ui.pattern);
		} else {
			checkPattern(ui.pattern);
		}
	}
});
</script>
<div>
	<div class="double-column">
        <div id="pattern-container">
		</div>
	</div>
	<div id="pattern-header" class="column last">
		<!-- <h2>jQuery UI pattern</h2>
		<h1>Android-style unlock screen</h1>-->
		<div id="pattern-configuration">
			<div>
				<div>
					<input id="show-pattern" checked="checked" type="checkbox" /><label for="show-pattern">show pattern</label>
					<input id="multi-select" type="checkbox" /><label for="multi-select">multi select</label>
					<input id="disabled" type="checkbox" /><label for="disabled">disabled</label>
					<input id="set-pattern" type="checkbox" /><label for="set-pattern">set pattern</label>
				</div>
			</div>
		</div>
	</div>
</div>