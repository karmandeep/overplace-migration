<?php

	//Now once the products have been migrated. Lets add the order/ordini and order_prodotti/tblhosting.
	//Get the orders.
	//echo '<pre>';
	//customer_id for the corresponding order-id
	//Make Array of this.
	$export_data_sql_array = array();
	
	//Let us first get the clients.
	$export_client_sql = "select u.*, tu.descrizione as tipologia_utente from utenti u, tipologie_utente tu where u.id_tipologia_utente = tu.id";
	$export_client_query = mysqli_query($dbexport_con , $export_client_sql); 
	
	//$cnt = 0;
	while($export_client_data = mysqli_fetch_array($export_client_query , MYSQLI_ASSOC)) {
		$customer_order_data = array();
		$customer_orders_query = mysqli_query($dbexport_con , "select o.*, tio.descrizione as tipologie_ordine from ordini o, tipologie_ordine tio where o.id_utente = '" . $export_client_data['id'] . "' and tio.id = o.id_tipologia_ordine");
		
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
	


	
	//Now Let Us Insert This Array Data into the WHMCS Database.
	if(count($export_data_sql_array) > 0) {
		//Create Bulk Insert SQL x3
		//Let us First insert the customer
		foreach($export_data_sql_array as $key => $value) {
			
			//Single Insert SQL
			$customer_import_sql_raw = "INSERT INTO tblclients (firstname, lastname, companyname, email, address1, address2, city, state, postcode, country, phonenumber, password, authmodule, authdata, currency, defaultgateway, credit, taxexempt, latefeeoveride, overideduenotices, separateinvoices, disableautocc, datecreated, notes, billingcid, securityqid, securityqans, groupid, cardtype, cardlastfour, cardnum, startdate, expdate, issuenumber, bankname, banktype, bankcode, bankacct, gatewayid, lastlogin, ip, host, status, language, pwresetkey, emailoptout, overrideautoclose, allow_sso, email_verified, created_at, updated_at, pwresetexpiry)";
			
			
			$customer_import_sql_raw .= " VALUES ('" . $value['customerdetails']['nome'] . "', '" . $value['customerdetails']['cognome'] . "', '" . $value['customerdetails']['ragione_sociale'] . "', '" . $value['customerdetails']['username'] . "', '" . $value['customerdetails']['indirizzo'] . "', '" . $value['customerdetails']['reigone'] . "', '" . $value['customerdetails']['citta'] . "', '" . $value['customerdetails']['provincia'] . "', '" . $value['customerdetails']['cap'] . "', '" . $value['customerdetails']['stato'] . "', '" . $value['customerdetails']['telefono'] . "', '" . generateClientPW($value['customerdetails']['password']) . "', '', '', '1', 'paypal', '0.00', '0', '0', '0', '0', '0', now(), 'Migrated From Old system', '0', '0', '', '" . get_customer_type_id($value['customerdetails']['tipologia_utente']) . "', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00', '212.39.6.250', '250-6.ppp.reteradio.it', 'Inactive', 'italian', '', '0', '0', '1', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00');";
			
			/***UnComment this once its live****/
			mysqli_query($dbwhmcs_con , $customer_import_sql_raw);
			$customer_id = mysqli_insert_id($dbwhmcs_con);
			
			
			//Insert the Client EmailAddress and The SalesTax Field
			//Let us get the custom fieldid
			
			$customer_salestax_field_id = get_custom_field('Sales Tax Code (VAT Registration Number)');
			
			$customer_salestax_import_sql_raw = "INSERT INTO tblcustomfieldsvalues (fieldid, relid, value) VALUES ('" . $customer_salestax_field_id . "' , '" . $customer_id . "' , '" . $value['customerdetails']['partita_iva'] . "');";
			

			/***UnComment this once its live****/
			mysqli_query($dbwhmcs_con , $customer_salestax_import_sql_raw);
			
			//Client EmailAddress
			$customer_emailaddress_field_id = get_custom_field('Client EmailAddress');
			
			$customer_emailaddress_import_sql_raw = "INSERT INTO tblcustomfieldsvalues (fieldid, relid, value) VALUES ('" . $customer_emailaddress_field_id . "' , '" . $customer_id . "' , '" . $value['customerdetails']['email'] . "');";
			
			/***UnComment this once its live****/
			mysqli_query($dbwhmcs_con , $customer_emailaddress_import_sql_raw);
			
			//Now Let Us Insert the orders
			foreach($value['orders'] as $subkey => $subvalue ) {

				$orderstatus = get_orderstatus_type_id($subvalue['order']['tipologie_ordine']);
			
				$order_import_sql_raw = "INSERT INTO tblorders (userid, contactid, date, nameservers, transfersecret, renewals, promocode, promotype, promovalue, orderdata, amount, paymentmethod, invoiceid, status, ipaddress, fraudmodule, fraudoutput, notes)";


				$order_import_sql_raw .= " VALUES ('" . $customer_id . "', '0', '" . $subvalue['order']['data'] . "', 'ns1.whmcs.t6tv.eu,ns2.whmcs.t6tv.eu', '', '', '', '', '', 'a:0:{}', '" . $subvalue['order']['importo'] . "', 'banktransfer', '0', '" . $orderstatus . "', '212.39.6.250', '', '', 'Migrated From Old system ');";
				
				mysqli_query($dbwhmcs_con , $order_import_sql_raw);
				$order_id = mysqli_insert_id($dbwhmcs_con);

				//Now lets insert the ordered_products
				if(count($subvalue['ordered_products']) > 0) {


					foreach( $subvalue['ordered_products'] as $keyindex => $ordered_products ) {

						$ordered_products_sql_raw = "INSERT INTO tblhosting (userid, orderid, packageid, server, regdate, domain, paymentmethod, firstpaymentamount, amount, billingcycle, nextduedate, nextinvoicedate, termination_date, completed_date, domainstatus, username, password, notes, subscriptionid, promoid, suspendreason, overideautosuspend, overidesuspenduntil, dedicatedip, assignedips, ns1, ns2, diskusage, disklimit, bwusage, bwlimit, lastupdate, created_at, updated_at ) VALUES ";
						
						$ordered_products_sql_raw .= "('" . $customer_id . "', '" . $order_id . "', '" . get_product_id($ordered_products['descrizione']) . "', '0', '" . $ordered_products['data_attivazione'] . "', '', 'banktransfer', '0.00', '0.00', 'Annually', '" . $ordered_products['data_scadenza'] . "', '" . $ordered_products['data_scadenza'] . "', '0000-00-00', '0000-00-00', 'Active', '', '', 'Imported From Old System', '', '', '', '0', '0000-00-00', '', '', '', '', '0', '0', '0', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00')";
						
							
						/***UnComment this once its live****/
						mysqli_query($dbwhmcs_con , $ordered_products_sql_raw);
						$relid = mysqli_insert_id($dbwhmcs_con);
						
						$fieldid = get_custom_field('Client Identifier' , 'product' , get_product_id($ordered_products['descrizione']));
						//echo 123;

						//Now Lets Insert the Client Identifier Field.
						//Let first get the customfieldsid
						$fieldid = get_custom_field('Client Identifier' , 'product' , get_product_id($ordered_products['descrizione']));
						
						$client_identifier_field_sql_raw = "INSERT INTO tblcustomfieldsvalues (fieldid, relid, value) VALUES ('" . $fieldid . "' , '" . $relid . "', '" . $ordered_products['riferimento_cliente'] . "')";
						
						/***UnComment this once its live****/
						mysqli_query($dbwhmcs_con , $client_identifier_field_sql_raw);
						
						
					}
					
					
				}
				
				
			}
			
		}
	
	}
	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Migrazione dei dati ...</title>
</head>

<body>
<h1>WHMCS importare dati completa, Elenco clienti Importato</h1>

<div style="width:100%; margin:0; padding:0; float:left;">
<ul style="width:100%; margin:0; padding:0; float:left; border:solid 1px #000000; border-bottom:none; list-style:none;">
	<li style="width:25%; margin:0; padding:0 2px; float:left; border-right:solid 1px #000000;"><strong>Ragione Sociale</strong></li>
	<li style="width:8%; margin:0; padding:0 2px; float:left; border-right:solid 1px #000000;"><strong>Nome</strong></li>
	<li style="width:8%; margin:0; padding:0 2px; float:left; border-right:solid 1px #000000;"><strong>Conome</strong></li>
	<li style="width:20%; margin:0; padding:0 2px; float:left; border-right:solid 1px #000000;"><strong>Indirizzo</strong></li>
	<li style="width:8%; margin:0; padding:0 2px; float:left; border-right:solid 1px #000000;"><strong>Reigone</strong></li>
	<li style="width:10%; margin:0; padding:0 2px; float:left; border-right:solid 1px #000000;"><strong>Provincia</strong></li>
	<li style="width:10%; margin:0; padding:0 2px; float:left; border-right:solid 1px #000000;"><strong>Citta</strong></li>
	<li style="width:5%; margin:0; padding:0 2px; float:left;"><strong>Stato</strong></li>
</ul>
	
<?php
	foreach($export_data_sql_array as $key => $value) {
?>
<ul style="width:100%; margin:0; padding:0; float:left; border:solid 1px #000000; border-bottom:none; list-style:none;">
	<li style="width:25%; margin:0; padding:0 2px; float:left; border-right:solid 1px #000000;"><?php echo $value['customerdetails']['ragione_sociale']; ?></li>
	<li style="width:8%; margin:0; padding:0 2px; float:left; border-right:solid 1px #000000;"><?php echo $value['customerdetails']['nome']; ?></li>
	<li style="width:8%; margin:0; padding:0 2px; float:left; border-right:solid 1px #000000;"><?php echo $value['customerdetails']['cognome']; ?></li>
	<li style="width:20%; margin:0; padding:0 2px; float:left; border-right:solid 1px #000000;"><?php echo $value['customerdetails']['username']; ?></li>
	<li style="width:8%; margin:0; padding:0 2px; float:left; border-right:solid 1px #000000;"><?php echo $value['customerdetails']['reigone']; ?></li>
	<li style="width:10%; margin:0; padding:0 2px; float:left; border-right:solid 1px #000000;"><?php echo $value['customerdetails']['provincia']; ?></li>
	<li style="width:10%; margin:0; padding:0 2px; float:left; border-right:solid 1px #000000;"><?php echo $value['customerdetails']['citta']; ?></li>
	<li style="width:5%; margin:0; padding:0 2px; float:left;"><?php echo $value['customerdetails']['stato']; ?></li>
</ul>

<?php
	}
?>
</div>
<hr />
<center><strong><h1>Thank You!</h1></strong></center>

</body>
</html>
