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

	

	// Create a Global Array of table products
	function product_check($name) {
		global $whmcs_products_array;
		if(in_array($name,$whmcs_products_array)){
			return true;
		}
		return false;
	}

	function get_product_id($name) {
		global $whmcs_products_array;
		if(in_array($name, $whmcs_products_array)){
			$flipped_array = array_flip($whmcs_products_array);
			return $flipped_array[$name];
		}
	}
	
	function customer_type_check($customer_type) {
		global $whmcs_customer_types_array;
		if(in_array($customer_type,$whmcs_customer_types_array)){
			return true;
		}
		return false;
	}

	function get_customer_type_id($customer_type) {
		global $whmcs_customer_types_array;
		if(in_array($customer_type, $whmcs_customer_types_array)){
			$flipped_array = array_flip($whmcs_customer_types_array);
			return $flipped_array[$customer_type];
		}
	}
	
	
	function orderstatus_type_check($order_status_types) {
		global $whmcs_order_status_types_array;
		if(in_array($order_status_types,$whmcs_order_status_types_array)){
			return true;
		}
		return false;
	} 
	
	function get_orderstatus_type_id($order_status_types) {
		global $whmcs_order_status_types_array;
		if(in_array($order_status_types, $whmcs_order_status_types_array)){
			$flipped_array = array_flip($whmcs_order_status_types_array);
			return $flipped_array[$order_status_types];
		}
	}
	
?>