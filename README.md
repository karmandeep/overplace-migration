## Synopsis

Custom Database to WHMCS Data Migration Script, writted for overplace.

## Code Example

This is an PHP Script, Which is uploaded to the server and executed via browsing the URL. Instruction are written in 
Italian, for which i tried my best.

Note: I am not a native Italian Speaker.

## Motivation

This Project Required Study of both WHMCS and the custom DB Structure. As we are aware WHMCS has a Complex Database
Structure, So it was a challening project early on but once things became clear after some effort. Finally we were 
able to compile the script.

## Installation

In order to INSTALL the script, you can use methods described below:

1. Ftp method: Download release v1.1.1 and create a new directory on your server and upload the files via ftp client.

2. gitHub: if you are a gitHub user, and know how to work with GIT, then you can Clone or Fork this repository, Then Add new Remote Origin (Set as git directory on your server) 
and git push the files.

3. Local: you can also download the script to localhost if you have setup WAMP 3.0.4 or greater.

Note: gitHub Method, either you should have GIT installed on your server, or you must use third-party deployment service such as deply.com.

Optional: you can also use a git deplyment script, if you know how.

After Uploading the files, edit configuration.php and add values to the following PHP variables:

	//Credentials Import WHMCS
	//WHMCS DB HOSTNAME
	$whmcs_dbhost = "";
	//WHMCS DB USER
	$whmcs_dbuser = "";
	//WHMCS DB PASSWORD
	$whmcs_dbpassword = "";
	//WHMCS DB NAME
	$whmcs_dbname = "";

	//Credentials for DB Export
	//EXPORT DB HOST
	$export_dbhost = ""; 
	//EXPORT DB USENAME
	$export_dbuser = ""; 
	//EXPORT DB PASSWORD
	$export_dbpassword = ""; 
	//EXPORT DB NAME
	$export_dbname = ""; 

Once done you can access http://your-domain.com/yourmigration-directoty/ if it displays the right information.
That means the installation is done. 

## How it Works!

This script connects with the Custom Database and the WHMCS database. Its runtime is divided into three steps.

1. Step 1: Checks Connection with Both Databases. It displays Uptime, Threads etc. generic mysqli database connection 
fields. 
2. Step 2: Imports the Products, and setsup the custom fields for migration.
3. Step 3: Imports the orders, ordered products, customers etc from the custom DB into the WHMCS
4. Step 4: Complete.

Optional: Additional http://your-domain/migrationscript/index.php?action=removeclients will remove the clients imported from the 
custom DB into the WHMCS Manually. 
Note: If you already tried to manually add clients from the custom DB into WHMCS

## Addtional Information

PHP Enviroment Settings: 

max_execution_time = 120000
max_input_time = 600
post_max_size = 128M
upload_max_filesize = 256M