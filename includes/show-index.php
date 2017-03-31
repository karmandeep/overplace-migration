<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Impostazione WHMCS migrazione</title>
</head>

<body>

<h1>Benvenuti alla configurazione WHMCS Importa dati, fare clic su Avanti per procedere</h1>

<!-- Verify the DB Crentials -->
<form name="whmcsdb" action="index.php?action=form_submit" method="post" enctype="multipart/form-data">

	<div style="float:left; width:100%;">
    
    	<div style="float:left; width:50%;">
        	<h2>WHMCS connessione al database</h2>
            <ul>
        		<li><strong>host del database:</strong> <?php echo $whmcs_dbhost; ?></li>
        		<li><strong>database degli utenti:</strong> <?php echo $whmcs_dbuser; ?></li>
        		<li><strong>Nome del database:</strong> <?php echo $whmcs_dbname; ?></li>
        		<li><strong>Controllare il collegamento:</strong> <?php echo $dbwhmcs_con->stat; ?></li>
                
        	</ul>
        </div>
    	<div style="float:left; width:50%;">
        	<h2>Collegamento di esportazione del database</h2>
        	<ul>
            	<li><strong>host del database:</strong> <?php echo $export_dbhost; ?></li>
            	<li><strong>database degli utenti:</strong> <?php echo $export_dbuser; ?></li>
            	<li><strong>Nome del database:</strong> <?php echo $export_dbname; ?></li>
        		<li><strong>Controllare il collegamento:</strong> <?php echo $dbexport_con->stat; ?></li>
            
            </ul>
        
        </div>
    
    </div>

	<div style="float:left; width:50%;">
    
    
    
    
    
    </div>
    
    <div style="float:left; width:50%;">
    
    
    	
        
    </div>
	<p>
    	Al fine di sincronizzare i dati, cliccate
    </p>
    	<input type="submit" name="submit" value="Sincronizzare" style="float:right; cursor:pointer;" />

	

</form>

<!-- Run The script -->

</body>
</html>