<?php 
	$object = $_POST["object"]; 
	//echo $object;
	//var_dump($object);
	echo '<input type="hidden" name="txtObjectAction" id="txtObjectAction" value="'.$object.'"/>';
?>
<form id="txtPasswordForm">
	<fieldset>
		<label for="password">Password</label>
		<input type="password" name="password" id="password" />
	</fieldset>
</form>