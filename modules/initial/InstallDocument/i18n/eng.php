<?php
$i18n = array(
	'0'				=>		"No",
	'1'				=>		"Yes",
	'Invite'		=>		"Welcome to Hydra",

	'avcf' => "Please, fill the form.\\n\\Form:\\n",
	'bouton' => "Install",

	'F1_title' => "This server information",

	'PHP_builtin_ok' => "support is enabled",
	'PHP_builtin_nok' => "support not found",
	'PHP_support_title' => "Database Abstraction Layer:<br>\r",
	'PHP_pear_support' => "PEAR support:",
	'PHP_adodb_support' => "ADOdb support:",
	'PHP_pdo_support' => "PDO support:",
	'PHP_db_builtin_functions' => "PHP built-in DB functions:",

	'tabTxt1' => "Server",
	'tabTxt2' => "DB",
	'tabTxt3' => "Method",
	'tabTxt4' => "Sites",
	'tabTxt5' => "Personalization",
	'tabTxt6' => "Logs",

	't1l1c1' => "This server Hostname / IP",
	't1l2c1' => "PHP version",
	't1l3c1' => "Include path",
	't1l4c1' => "Current directory",
	't1l5c1' => "Display error / register global / Post max size",
	't1l6c1' => "Memory limit",
	't1l7c1' => "Max execution time",
	't1l8c1' => "DB services",
	't1l9c1' => "Preconized install RAM limit",
	't1l10c1' => "Preconized install time limit",

	'test_ok'	=> "ok",
	'test_nok'	=> "Warning",

	'F2_title' => "Installation method",
	'F2_intro' => "There are two ways to install Hydr. This method ease installation on a bigger number of plateforms.<br>\r<br>\r",
	'F2_txt_aide1' => "Direct connection<br>The install tool will connect to the database (local or remote) and will create the necessary tables for engine to be functionning.The parameters entered in the config panel will be used when the website will operate. <br><br>Don\'t forget to copy the files on the server.",
	'F2_txt_aide2' => "Scripted installation<br>The install tool will create a script you will be able to load on a PhpMyAdmin interface (for example). This is used when the hosting service do not allow direct connection to the server. Nowdays it seems to be rare.<br>",
	'F2_m1o1' => "Direct connection to the DB",
	'F2_m1o2' => "Script creation",


	'F3_title' => "Sites to process",
	't3l1c1'	=> "Directories in Website_datas folder",
	't3l1c2'	=> "Installation ?",
	't3l1c3'	=> "Should I check the code ?",

	// DB tab
	// 'F4_title' => "Connection to the DB for installing",
	// 'F4_intro' => "An access to the database associated with the webserver is required for intalling the engine. The user should have enough privilèges to be able to create databases and tables. The logins and password you will provide will not be reused. The installer will create its own user to make the engine function (next form). Please fill the form below.<br>\r<br>\r",
	// 't4l4c4AD'		=> "If you run this script on your website in a hosting plan, you probably have restriction about creating databases. Usually you have to do it in a Cpanel/PHPMyadmin interface. You should select \'hosting plan\' in that case. The script will not remove the database you name. Only empty it.<br><br>The other case is a server where you can do absolutly everything. Select \'absolute power\'.",
	'DB_Titlec1'	=> "Element",
	'DB_Titlec2'	=> "Prefix ",
	'DB_Titlec3'	=> "Field",
	'DB_Titlec4'	=> "Information",

	'DB_dal'		=> "Abstraction Layer",
	'DB_dalInf'		=> "Select the DAL you want to use. Warning PEAR DB is deprecated. AdoDB is experimental at the moment.",			
	'msdal_php'		=> "PHP functions (default)",
	'msdal_pdo'		=> "PHP PDO",
	'msdal_adodb'	=> "ADOdb (check webhosting plan)",
	'msdal_pear' 	=> "PEAR DB (deprecated)",

	'DB_type'		=> "Type",
	'DB_typeInf'	=> "The DB support is provided by selected module.",

	'DB_hosting'	=> "Hosting profile",
	'DB_hostingInf'	=> "Choose the hosting profile where the engine should be installed.",
	'dbp_hosted'	=> "Hosting plan",
	'dbp_asolute'	=> "I'm god on my server",

	'DB_server' 	=> "Database server",	
	'DB_serverInf'	=> "This is the server where the database is. use 'localhost' or 'mysql' (Docker, etc) or the server IP address. Otherwise check with the webhosting provider.",

	'Db_prefix'		=> "Prefix",
	'Db_prefixInf'	=> "Sometimes a prefix is needed. Usually it's your account login provided by your webhosting provider. Ex : myaccount_ + DBuser. Enter the prefix in this filed only.",

	'DB_name'		=> "Database name",
	'DB_nameInf'	=> "This is the database name on the server.",

	'DB_Admlogin'		=> "Admin login",
	'DB_AdmloginInf'	=> "Enter a login that has enough privileges to create databases, tables and users on the DB server. ",

	'DB_password'	=> "Password",

	'DB_tstcnx'		=> "Test the database connexion",
	'DB_tstcnxAok'	=> "The database connection suceeded.",
	'DB_tstcnxAko'	=> "The database connection failed.",
	'DB_tstcnxBok'	=> "WARNING A Hydr database has been found. The install process will erase this DB if you continue. Change the DB name if you want to keep the existing DB.",
	'DB_tstcnxBko'	=> "Hydr database not found.",


	'F5_title' => "DB personalization",
	't5l1c1' => "Element",
	't5l1c2' => "Prefix ",
	't5l1c3' => "Field",
	't5l1c4' => "Information",
	't5l2c1'	=> "Table Prefix",
	't5l2c2'	=> "",
	't5l2c3'	=> "",
	't5l2c4'	=> "Each table will have this prefix. Depending on database it can be usefull.",
	't5l3c1'	=> "User name of the database user (your scripts)",
	't5l3c2'	=> "",
	't5l3c3'	=> "",
	't5l3c4'	=> "This is the virtual user. The script will use this username to connect to the database. Make sure it's different from the admin user. Depending on webhosting provider you may have to create the DB and the user before installing. In this case it's better to use the script method or install locally and ex/import the DB.",
	'boutonpass'		=> "Generate",
	't5l4c1'	=> "Password",
	't5l4c2'	=> "",
	'unveilPassword'=> "Click to unveil password",
	't5l4c4'	=> "If the user already exists for that database, do not generate a password. Use the one associated with that user.",
	't5l5c1'	=> "Recreate this user",
	'dbr_o' => "Yes",
	'dbr_n' => "No",
	't5l5c2'	=> "",
	't5l5c3'	=> "",
	't5l5c4'	=> "If it is possible (admin privilege) it is better to recreate the user during installation. If 'no' is selected you should check that this user is correctly configured to use the database.",
	't5l6c1'	=> "Generic user Password",
	't5l6c2'	=> "",
	't5l6c3'	=> "",
	't5l6c4'	=> "The engine will create at least one website user. Enter the password for those website users.",
	't5l7c1'	=> "Make .htaccess",
	't5l7c2'	=> "",
	't5l7c3'	=> "",
	't5l7c4'	=> "The .htaccess file is a ruleset that defines access authorizations to files on the web server. It helps to protect the files that contain certain information such as password etc. The file given use classical rules. The behavior of this ruleset also depends on the webserver.",
	'TypeExec1'	=> "Apache module",
	'TypeExec2'	=> "CLI",
	't5l8c1'	=> "Execution type",
	't5l8c2'	=> "",
	't5l8c3'	=> "",
	't5l8c4'	=> "You can execute the installation as Apache module or as stand alone CLI. it all depends on what your Webhosting plan authorize you to do. Default is 'as apache module'.",


	'F6_title' => "Installation report",
	't6l1c1'	=> "Display report options",
	't6l1c2'	=> "",
	't6l1c3'	=> "",
	't6l1c4'	=> "",
	't6l2c1'	=> "Database",
	't6l2c2'	=> "Warning messages",
	't6l2c3'	=> "Error messages",
	't6l3c1'	=> "Console",
	't6l3c2'	=> "Warning messages",
	't6l3c3'	=> "Error messages",


	'ls0' => "Database server",
	'ls1' => "Admin login (read / write)",
	'ls2' => "Password",
	'ls3' => "Database name",
	'ls4' => "User name of the database user (your scripts)",
	'ls5' => "Database user Password",
	'ls6' => "Generic user Password",


	'tab_1' => "Table creation",
	'tab_2' => "Load SQL data",
	'tab_3' => "Script",
	'tab_4' => "Load more SQL data",
	'tab_5' => "Raw SQL",
	'tab_6' => "Performances",
	'tab_7' => "Files",
	'tab_8' => "7",

	't1c1' => "File",
	't1c2' => "Ok",
	't1c3' => "Warning",
	't1c4' => "Error",
	't1c5' => "Time",
	't1c6' => "SQL",
	't1c7' => "Commands",

	't5c1' => "
Those files must be saved (if not already saved) in the 'current/config/current/' directory.<br>\r
Access to this directory must be restricted. A simple 'default .htaccess' is provided in this directory.<br>\r
Make sure it's on the server. Make sure you edit it carfully. And make sure 'AllowOverride All' is set for 'Directory /var/www/'<br>\r
<br>\r
",
	'BtnSelect' => "Select",
	
	"perfTab01"	=>	"N",
	"perfTab02"	=>	"Point de contrôle",
	"perfTab03"	=>	"Temps",
	"perfTab04"	=>	"Mémoire",
	"perfTab05"	=>	"Requêtes",
	
	't9c1' => "A",
	't9c2' => "B",
	't9c3' => "C",
	't9c4' => "D",
	't9c5' => "E",
	't9c6' => "F",

);
?>