<?php

	//Get the list of clients from the exportdb
	$export_data_customer_array = array();
	
	//Let us first get the clients.
	$export_data_customer_sql = "select * from utenti";
	$export_data_customer_query = mysqli_query($dbexport_con , $export_data_customer_sql); 
	while($export_data_customer = mysqli_fetch_array($export_data_customer_query , MYSQLI_ASSOC)) {
	
		$export_data_customer_array[] = $export_data_customer['username'];
	}


	foreach($export_data_customer_array as $key => $value) {
		
		mysqli_query($dbwhmcs_con , "delete from tblclients where email = '" . $value . "'");
		
	}
	


?>