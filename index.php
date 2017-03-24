<?php
	
	//error_reporting(E_ALL, ~E_NOTICE);
	//Sgut The Error Reporting 
	error_reporting(false);
	//Include the DB Configuration File
	include_once('configuration.php');
	include('includes/common-functions.php');
	include('includes/database-functions.php');

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

	<div style="float:left; width:100%;">
    
    	<div style="float:left; width:50%;">
        	<h2>WHMCS DB Connection</h2>
            <ul>
        		<li><strong>DBHost:</strong> <?php echo $whmcs_dbhost; ?></li>
        		<li><strong>DBUser:</strong> <?php echo $whmcs_dbuser; ?></li>
        		<li><strong>DBName:</strong> <?php echo $whmcs_dbname; ?></li>
        		<li><strong>Connection Check:</strong> <?php echo $dbwhmcs_con->stat; ?></li>
                
        	</ul>
        </div>
    	<div style="float:left; width:50%;">
        	<h2>Export DB Connection</h2>
        	<ul>
            	<li><strong>DBHost:</strong> <?php echo $export_dbhost; ?></li>
            	<li><strong>DBUser:</strong> <?php echo $export_dbuser; ?></li>
            	<li><strong>DBName:</strong> <?php echo $export_dbname; ?></li>
        		<li><strong>Connection Check:</strong> <?php echo $dbexport_con->stat; ?></li>
            
            </ul>
        
        </div>
    
    </div>

    	<input type="submit" name="submit" value="Sync" style="float:right;" />

	

</form>

<!-- Run The script -->

</body>
</html>
