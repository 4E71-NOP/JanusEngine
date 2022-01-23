<?php
$i18n = array(
	'0'				=>		"No",
	'1'				=>		"Yes",
	'Invite'		=>		"Welcome to Hydra",

	'avcf' => "Please, fill the form.\\n\\Fieds:\\n",
	'bouton' => "Install",

	'F1_title' => "This server information",

	'PHP_builtin_ok'			=> "support is enabled",
	'PHP_builtin_nok'			=> "support not found",
	'PHP_support_title'			=> "Database Abstraction Layer:<br>\r",
	'PHP_pear_support'			=> "PEAR support:",
	'PHP_adodb_support'			=> "ADOdb support:",
	'PHP_pdo_support'			=> "PDO support:",
	'PHP_db_builtin_functions'	=> "PHP built-in DB functions:",
	'unveilPassword'			=> "Unveil the password",

	'tabTxt1'	=> "Server",
	'tabTxt2'	=> "DB",
	'tabTxt3'	=> "Method",
	'tabTxt4'	=> "Sites",
	'tabTxt5'	=> "Personalization",
	'tabTxt6'	=> "Logs",

	// Server
	'SRV_ip'		=> "This server Hostname / IP",
	'SRV_phpVrs'	=> "PHP version",
	'SRV_incPth'	=> "Include path",
	'SRV_CurDir'	=> "Current directory",
	'SRV_DisErr'	=> "Display error / register global / Post max size",
	'SRV_MemLim'	=> "Memory limit",
	'SRV_MaxTim'	=> "Max execution time",
	'SRV_DbSrvc'	=> "DB services",
	'SRV_PrcRam'	=> "Preconized install RAM limit",
	'SRV_PrcTim'	=> "Preconized install time limit",

	'test_ok'	=> "ok",
	'test_nok'	=> "Warning",

	// DB
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

	// Method
	'MTH_intro'		=> "There are two ways to install Hydr. This method ease installation on a bigger number of plateforms.<br>\r<br>\r",
	'MTH_opt1'		=> "Direct connection to the DB",
	'MTH_opt2'		=> "Script creation",
	'MTH_opt1Help'	=> "Direct connection<br>The install tool will connect to the database (local or remote) and will create the necessary tables for engine to be functionning.The parameters entered in the config panel will be used when the website will operate. <br><br>Don\'t forget to copy the files on the server.",
	'MTH_opt2Help'	=> "Scripted installation<br>The install tool will create a script you will be able to load on a PhpMyAdmin interface (for example). This is used when the hosting service do not allow direct connection to the server. Nowdays it seems to be rare.<br>",

	// Site Selection
	'SIT_Titlec1'	=> "Directories in '<i><b>Websites-datas</b></i>' folder",
	'SIT_Titlec2'	=> "Installation ?",
	'SIT_Titlec3'	=> "Should I check the code ?",

	// Personalization
	'PER_Titlec1'	=> "Element",
	'PER_Titlec2'	=> "Prefix",
	'PER_Titlec3'	=> "Field",
	'PER_Titlec4'	=> "Information",

	'PER_TbPrfx'	=> "Table Prefix",
	'PER_TbPrfxInf'	=> "Each table will have this prefix. Depending on database it can be usefull.",

	'PER_DbUsrN'	=> "Hydr username for database",
	'PER_DbUsrNInf'	=> "This is the virtual user. The script will use this username to connect to the database. Make sure it's different from the admin user. Depending on webhosting provider you may have to create the DB and the user before installing. In this case it's better to use the script method or install locally and ex/import the DB.",
	'boutonpass'	=> "Generate",

	'PER_DbUsrP'	=> "Password",
	'PER_DbUsrPInf'	=> "If the user already exists for that database, do not generate a password. Use the one associated with that user.",

	'PER_UsrRec'	=> "Recreate this user",
	'PER_UsrRecInf'	=> "If it is possible (admin privilege) it is better to recreate the user during installation. If 'no' is selected you should check that this user is correctly configured to use the database.",
	'dbr_o'			=> "Yes",
	'dbr_n'			=> "No",

	'PER_WbUsrP'	=> "Websites user Password",
	'PER_WbUsrPInf'	=> "The engine will create at least one website user. Enter the password for those website users.",
	
	'PER_MkHtacs'		=> "Make .htaccess",
	'PER_MkHtacsInf'	=> "The .htaccess file is a ruleset that defines access authorizations to files on the web server. It helps to protect the files that contain certain information such as password etc. The file given use classical rules. The behavior of this ruleset also depends on the webserver.",
	'TypeExec1'		=> "Apache module",
	'TypeExec2'		=> "CLI",

	'PER_Typexe'	=> "Execution type",
	'PER_TypexeInf'	=> "You can execute the installation as Apache module or as stand alone CLI. it all depends on what your Webhosting plan authorize you to do. Default is 'as apache module'.",

	// Report
	'REP_Titlec1'	=> "Display report options",
	'REP_db'		=> "Database",
	'REP_consol'	=> "Console",
	'REP_wrnMsg'	=> "Warning messages",
	'REP_errMsg'	=> "Error messages",

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