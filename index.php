<?php
	
	//error_reporting(E_ALL, ~E_NOTICE);
	//Sgut The Error Reporting 
	error_reporting(false);
	//Include the DB Configuration File
	include_once('configuration.php');
	include('includes/common-functions.php');
	include('includes/database-functions.php');

	$action = $_GET['action'];
	
	switch($action) {
	
		case 'form_submit':
			include('includes/database-migration.php');
		break;

		case 'form_submit2':
			include('includes/database-migration2.php');
		break;
		
		case 'removeclients':
			include('includes/database-migration3.php');
		break;
		
		default:
			include('includes/show-index.php');
		break;
	}


?>