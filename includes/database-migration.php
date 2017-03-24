<?php


	//Database Connection
	echo '<pre>';
	//Select the products from theexport db 
	
	$product_select_query = mysqli_query($dbexport_con , "select distinct descrizione from ordini_prodotti");
	while($product_select = mysqli_fetch_array($product_select_query , MYSQLI_ASSOC)) {
		//print_r($product_select);
	}
	
	//create a product group called old products in the WHMCS Database.
	//First Check if exists
	
	$product_group_check_query = mysqli_query($dbwhmcs_con , "select count(*) as result, id, name from tblproductgroups where name = 'Web Media Center OLD'");
	$product_group_check = mysqli_fetch_array($product_group_check_query , MYSQLI_ASSOC);
	if($product_group_check['result'] > 0) {
		
		//Get the ID and the Name
		$group_id = $product_group_check['id'];
		
	
	} else {
	
		//Insert the Data
		$product_group_add_query = mysqli_query($dbwhmcs_con , "INSERT INTO tblproductgroups (name, headline, tagline, orderfrmtpl, disabledgateways, hidden, order, created_at, updated_at) VALUES ('Web Media Center OLD' , '', '', '', '', '1', '10', now(), now())");
		
		$group_id = mysqli_insert_id($dbwhmcs_con);
		
	}
	
	//Once we have the Group ID.
	//Now lets insert products into this group. 
	echo  $product_check_result;
	//$create_product_query = mysqli_query($dbwhmcs_con , " "
	
	//mysqli_query(
	
	



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Migrating Data......</title>
</head>

<body>


	


</body>
</html>
