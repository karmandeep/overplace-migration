<?php


	//Database Functions

	//Connection
	
	$dbwhmcs_con = mysqli_connect($whmcs_dbhost, $whmcs_dbuser, $whmcs_dbpassword);	
	if (!$dbwhmcs_con) {
    	die("Database connection to host: " . $whmcs_dbhost . " failed: " . mysqli_error());
	}
	
	
	$dbexport_con = mysqli_connect($export_dbhost, $export_dbuser, $export_dbpassword);
	if (!$dbexport_con) {
    	die("Database connection to host: " . $export_dbhost . " failed: " . mysqli_error());
	}
	
	//Selection
	
	
	$dbwhmcs_select = mysqli_select_db($dbwhmcs_con, $whmcs_dbname);
	if (!$dbwhmcs_select) {
		die("Database " . $whmcs_dbname . " selection failed: " . mysqli_error());
	}	
	
	$dbexport_select = mysqli_select_db($dbexport_con, $export_dbname);
	if (!$dbexport_select) {
		die("Database " . $export_dbname . " selection failed: " . mysqli_error());
	}	
	
	//mysqli_select_db($dbwhmcs_con, $whmcs_dbname);
	//mysqli_select_db($dbexport_con, $export_dbname);

	//echo '<pre>';
	//print_r($dbwhmcs_con->stat);


?>