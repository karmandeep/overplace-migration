<?php


	//Database Connection
	//echo '<pre>';
	
	//WHMCS Products Array
	
	$whmcs_products_array = array();
	$whmcs_products_select_query = mysqli_query($dbwhmcs_con , "select id, name from tblproducts");
	while($whmcs_products_select = mysqli_fetch_array($whmcs_products_select_query , MYSQLI_ASSOC)) {
			$whmcs_products_array[$whmcs_products_select['id']] = $whmcs_products_select['name'];
	}
	
	
	
	//Select the products from theexport db 
	$products_array = array();
	$product_select_query = mysqli_query($dbexport_con , "select distinct descrizione from ordini_prodotti");
	while($product_select = mysqli_fetch_array($product_select_query , MYSQLI_ASSOC)) {
		if(!product_check($product_select['descrizione'])) {
			$products_array[] = $product_select['descrizione'];
		} 
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
	
	$_product_insert_sql_raw = "INSERT INTO tblproducts (type, gid, name, description, hidden, showdomainoptions, welcomeemail, stockcontrol, qty, proratabilling, proratadate, proratachargenextmonth, paytype, allowqty, subdomain, autosetup, servertype, servergroup, configoption1, configoption2, configoption3, configoption4, configoption5, configoption6, configoption7, configoption8, configoption9, configoption10, configoption11, configoption12, configoption13, configoption14, configoption15, configoption16, configoption17, configoption18, configoption19, configoption20, configoption21, configoption22, configoption23, configoption24, freedomain, freedomainpaymentterms, freedomaintlds, recurringcycles, autoterminatedays, autoterminateemail, configoptionsupgrade, billingcycleupgrade, upgradeemail, overagesenabled, overagesdisklimit, overagesbwlimit, overagesdiskprice, overagesbwprice, tax, affiliateonetime, affiliatepaytype, affiliatepayamount, `order`, retired, is_featured, created_at, updated_at) VALUES ";
	
	$_cnt = 0;
	//echo count($products_array);
	foreach( $products_array as $product_name ) {
		
		
		//Lets First Check, and then add this value.
		$_cnt++;
		$_product_insert_sql_raw .= "('other', '" . $group_id . "', '" . $product_name . "', '" . $product_name . "', '1', 0, 0, 0, 0, 0, 0, 0, 'onetime', 0, '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', 0, '', 0, 0, '0.0000', '0.0000', '1', '0', '', '0.00', 0, 0, 0, now(), now())";
		//echo $value;
		
		
		if($_cnt < count($products_array)) {
			$_product_insert_sql_raw .= ' , ';
		}
	}	
	//echo $_product_insert_sql_raw;
	//print_r($products_array);
	//echo  $product_check_result;
	
	// Now Lets Add these Products.
	//mysqli_query($dbwhmcs_con , $_product_insert_sql_raw);
	
	//mysqli_query(
	
	
	//Lets Insert the type of orders and types of customers
	
	//Select all the WHMCS Customer Types.
	$whmcs_customer_types_array = array();
	$whmcs_customer_types_query = mysqli_query($dbwhmcs_con , "select id, groupname from tblclientgroups");
	while($whmcs_customer_types = mysqli_fetch_array($whmcs_customer_types_query , MYSQLI_ASSOC)) {
			$whmcs_products_array[$whmcs_customer_types['id']] = $whmcs_customer_types['groupname'];
	}
	
	
	//Select Export DB Customer Types:
	$customer_type_array = array();
	$customer_type_select_query = mysqli_query($dbexport_con , "select distinct descrizione from tipologie_utente");
	while($customer_type_select = mysqli_fetch_array($customer_type_select_query , MYSQLI_ASSOC)) {
		if(!customer_type_check($customer_type_select['descrizione'])) {
			$customer_type_array[] = $customer_type_select['descrizione'];
		} 
	}
	
	//Now Lets Insert Them
	$_customer_type_insert_sql_raw = "INSERT INTO tblclientgroups (groupname, groupcolour, discountpercent, susptermexempt, separateinvoices) VALUES ";

	$_cnt = 0;
	foreach( $customer_type_array as $customer_type ) {
		$_cnt++;
		$_customer_type_insert_sql_raw .= "('" . $customer_type . "', '#9CE0FF', '0', '', '')";
		if($_cnt < count($customer_type_array)) {
			$_customer_type_insert_sql_raw .= ' , ';
		}
	
	}


	//Now Lets Insert The Order Types:
	//This may refer to as WHMCS Order Status.

	/******************* ORDER TYPES NEEDS TO BE ADDED HERE ********************************************/
	
	//mysqli_query($dbwhmcs_con , $_customer_type_insert_sql_raw);
	
	

	echo $_customer_type_insert_sql_raw;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Migrating Data......</title>
</head>

<body>
<h1>Products Have been Added, Do not Refresh.</h1>

<form name="whmcsdb" action="index.php?action=form_submit2" method="post" enctype="multipart/form-data">
	
    	<div style="float:left; width:100%;">
        
        	<div style="float:left; width:50%;">
            	<h2>Following Products have been added to following group.</h2>
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
        <input type="submit" name="submit" value="Next" style="float:right;" />
	
</form>
	


</body>
</html>
