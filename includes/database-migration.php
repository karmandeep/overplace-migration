<?php



	//Product Group	
	$product_group_check_query = mysqli_query($dbwhmcs_con , "select count(*) as result, id, name from tblproductgroups where name = 'Web Media Center OLD'");
	$product_group_check = mysqli_fetch_array($product_group_check_query , MYSQLI_ASSOC);
	if($product_group_check['result'] > 0) {
		//Get the ID and the Name
		$group_id = $product_group_check['id'];
	} else {

		//Insert the Data
		$product_group_add_query = mysqli_query($dbwhmcs_con , "INSERT INTO tblproductgroups (name, headline, tagline, orderfrmtpl, disabledgateways, hidden, created_at, updated_at) VALUES ('Web Media Center OLD' , '', '', '', '', '1', now(), now())");
		$group_id = mysqli_insert_id($dbwhmcs_con);
	}

	//Select the products from theexport db 
	$products_array = array();
	$products_query = mysqli_query($dbexport_con , "select distinct descrizione from ordini_prodotti");
	while($products = mysqli_fetch_array($products_query , MYSQLI_ASSOC)) {
		if(!product_check($products['descrizione'])) {
			$products_array[] = $products['descrizione'];
		} 
	}

	//Once we have the Group ID.
	//Now lets insert products into this group. 
	if(count($products_array) > 0) {
		
		foreach( $products_array as $product_name ) {
			
			$_product_insert_sql_raw = "INSERT INTO tblproducts (type, gid, name, description, hidden, showdomainoptions, welcomeemail, stockcontrol, qty, proratabilling, proratadate, proratachargenextmonth, paytype, allowqty, subdomain, autosetup, servertype, servergroup, configoption1, configoption2, configoption3, configoption4, configoption5, configoption6, configoption7, configoption8, configoption9, configoption10, configoption11, configoption12, configoption13, configoption14, configoption15, configoption16, configoption17, configoption18, configoption19, configoption20, configoption21, configoption22, configoption23, configoption24, freedomain, freedomainpaymentterms, freedomaintlds, recurringcycles, autoterminatedays, autoterminateemail, configoptionsupgrade, billingcycleupgrade, upgradeemail, overagesenabled, overagesdisklimit, overagesbwlimit, overagesdiskprice, overagesbwprice, tax, affiliateonetime, affiliatepaytype, affiliatepayamount, `order`, retired, is_featured, created_at, updated_at) VALUES ";

			
			$_product_insert_sql_raw .= "('other', '" . $group_id . "', '" . $product_name . "', '" . $product_name . "', '1', 0, 0, 0, 0, 0, 0, 0, 'onetime', 0, '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', 0, '', 0, 0, '0.0000', '0.0000', '1', '0', '', '0.00', 0, 0, 0, now(), now())";
			//echo $value;
	

			//UNCOMMENT THIS WHEN PUTTING IN TO ACTION
			mysqli_query($dbwhmcs_con , $_product_insert_sql_raw);
			$product_id = mysqli_insert_id($dbwhmcs_con);
	
			$config_options_insert_sql_raw = "INSERT INTO tblcustomfields (type, relid, fieldname, fieldtype, description, fieldoptions, regexpr, adminonly, required, showorder, showinvoice, sortorder, created_at, updated_at) VALUES ";

			$config_options_insert_sql_raw .= "('product', '" . $product_id . "', 'Client Identifier', 'text', 'Unique identifier of the client for whom the service was ordered. It will be visible in the invoice and on orders.', '', '', '', 'on', 'on', 'on', '0', now(), now())  ";
			

			//UNCOMMENT THIS WHEN PUTTING IN TO ACTION
			mysqli_query($dbwhmcs_con , $config_options_insert_sql_raw);

		}	

	
	}
	
	
	
	//Select Export DB Customer Types:
	$customer_type_array = array();
	$customer_type_query = mysqli_query($dbexport_con , "select distinct descrizione from tipologie_utente");
	while($customer_type = mysqli_fetch_array($customer_type_query , MYSQLI_ASSOC)) {
		if(!customer_type_check($customer_type['descrizione'])) {
			$customer_type_array[] = $customer_type['descrizione'];
		} 
	}

	//Now Lets Insert Them
	if(count($customer_type_array) > 0) {
		$_customer_type_insert_sql_raw = "INSERT INTO tblclientgroups (groupname, groupcolour, discountpercent, susptermexempt, separateinvoices) VALUES ";
	
		$_cnt = 0;
		foreach( $customer_type_array as $customer_type ) {
			$_cnt++;
			$_customer_type_insert_sql_raw .= "('" . $customer_type . "', '#9CE0FF', '0', '', '')";
			if($_cnt < count($customer_type_array)) {
				$_customer_type_insert_sql_raw .= ' , ';
			}
		
		}

		//UNCOMMENT THIS WHEN PUTTING IN TO ACTION
		mysqli_query($dbwhmcs_con , $_customer_type_insert_sql_raw);
	
		//echo $_customer_type_insert_sql_raw;

	}

	//Select Export DB Order Types:
	$order_status_types_array = array();
	$order_status_types_query = mysqli_query($dbexport_con , "select distinct descrizione from tipologie_ordine");
	while($order_status_types = mysqli_fetch_array($order_status_types_query , MYSQLI_ASSOC)) {
		if(!orderstatus_type_check($order_status_types['descrizione'])) {
			$order_status_types_array[] = $order_status_types['descrizione'];
		} 
	}
	
	//Create Insert Statement.
	if(count($order_status_types_array) > 0) {
		$order_status_type_insert_sql_raw = "INSERT INTO tblorderstatuses (title, color, showpending, showactive, showcancelled, sortorder) VALUES ";
		
		$_cnt = 0;
		foreach( $order_status_types_array as $order_status_type ) {
			$_cnt++;
			$order_status_type_insert_sql_raw .= "('" . $order_status_type . "', '#9CE0FF', '0', '', '', '')";
			if($_cnt < count($order_status_types_array)) {
				$order_status_type_insert_sql_raw .= ' , ';
			}
		
		}

		//UNCOMMENT THIS WHEN PUTTING IN TO ACTION
		mysqli_query($dbwhmcs_con , $order_status_type_insert_sql_raw);

		//echo $order_status_type_insert_sql_raw;


	}





	/******************We Also Need to Add Custom Field Client Identifier****************************/
	/*
	
select tcf.relid as productid, tcfv.relid as hostingid, tcf.id as fieldid, tcf.fieldname, tcfv.value from tblcustomfields tcf,
tblcustomfieldsvalues tcfv where tcf.fieldname = 'Client Identifier' and tcf.id = tcfv.fieldid;
/*select * from tblcustomfields where fieldname = 'Client Identifier';*/
/*select * from tblcustomfieldsvalues where relid = '26';*/	
	
	/*/
	*/
	
	
	//Need Two Fields basically: Client Identifier And Client EmailAddress

	//Insert
	//Config Option Client EmailAddress
	$config_options_insert_sql_raw = "INSERT INTO tblcustomfields (type, relid, fieldname, fieldtype, description, fieldoptions, regexpr, adminonly, required, showorder, showinvoice, sortorder, created_at, updated_at) VALUES ('client', '0', 'Client EmailAddress', 'text', 'Client Email Address From earlier system', '', '', '', 'on', 'on', 'on', '0', now(), now())";
	
	mysqli_query($dbwhmcs_con , $config_options_insert_sql_raw);
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Migrazione dei dati ......</title>
</head>

<body>
<h1>Prodotti sono stati aggiunti, non Refresh.</h1>

<form name="whmcsdb" action="index.php?action=form_submit2" method="post" enctype="multipart/form-data">
	
    	<div style="float:left; width:100%;">
        
        	<div style="float:left; width:50%;">
            	<h2>Seguenti prodotti sono stati aggiunti al gruppo seguente.</h2>
                <ul>
				<?php
                	foreach( $products_array as $product_name ) {
				?>
                	<li><strong><?php echo $product_name; ?></strong></li>
                <?php	
						
					}
				
				?>
                </ul>
			</div>
       		<div style="float:left; width:50%;">
        
       		</div>
		</div>
        <input type="submit" name="submit" value="Il prossimo" style="float:right;" />
	
</form>
	


</body>
</html>
