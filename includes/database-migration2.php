<?php

	//Now once the products have been migrated. Lets add the order/ordini and order_prodotti/tblhosting.
	//Get the orders.
	echo '<pre>';
	//customer_id for the corresponding order-id
	//Make Array of this.
	$export_data_sql_array = array();
	
	//Let us first get the clients.
	$export_client_sql = "select * from utenti";
	$export_client_query = mysqli_query($dbexport_con , $export_client_sql); 
	
	//$cnt = 0;
	while($export_client_data = mysqli_fetch_array($export_client_query , MYSQLI_ASSOC)) {
		$customer_order_data = array();
		$customer_orders_query = mysqli_query($dbexport_con , "select * from ordini where id_utente = '" . $export_client_data['id'] . "'");
		
		while($customer_orders = mysqli_fetch_array($customer_orders_query , MYSQLI_ASSOC)) {
			
			$customer_product_order_data = array();		
			//Lets Get the Ordered products.
			$customer_product_orders_query = mysqli_query($dbexport_con , "select * from ordini_prodotti where id_ordine = '" . $customer_orders['id'] . "'");
			while($customer_product_orders = mysqli_fetch_array($customer_product_orders_query , MYSQLI_ASSOC)) {
				$customer_product_order_data[] = $customer_product_orders;
			}
			//print_r($customer_orders);
			$customer_order_data[] = array('order' => $customer_orders, 'ordered_products' => $customer_product_order_data);
		}
		
		$export_data_sql_array[] = array('customerdetails' => $export_client_data, 'orders' => $customer_order_data);
	}
	
	print_r($export_data_sql_array);

	
	//echo 1;
	
	exit;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Migrating Data ......</title>
</head>

<body>
<h1>Now lets add Orders</h1>


</body>
</html>
