<?php

	//Include the DB Configuration File
	include_once('configuration.php');
	include('includes/common-functions.php');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Overplace WHMCS Migration Script</title>
</head>

<body>

<h1>This is a PHP Migration Script for transfer of WHMCS DB.</h1>

<!-- Verify the DB Crentials -->
<form name="whmcsdb" action="index.php?action=form_submit" method="post" enctype="multipart/form-data">

	<input type="submit" name="submit" value="Sync" />

</form>

<!-- Run The script -->

</body>
</html>
