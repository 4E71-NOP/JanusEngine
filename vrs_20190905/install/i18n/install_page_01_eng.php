<?php 
$i18n['avcf'] = "Please, fill the form.\\n\\Form:\\n";
$i18n['bouton'] = "Install";

$i18n['F1_title'] = "This server information";

$i18n['PHP_builtin_ok'] = "support is enabled.\r";
$i18n['PHP_builtin_nok'] = "support not found.<br>\r";
$i18n['PHP_support_title'] = "Database Abstraction Layer:<br>\r";

$i18n['t1l1c1'] = "This server Hostname / IP";
$i18n['t1l2c1'] = "PHP version";
$i18n['t1l3c1'] = "Include path";
$i18n['t1l4c1'] = "Current directory";
$i18n['t1l5c1'] = "Display error / register global / Post max size";
$i18n['t1l6c1'] = "Memory limit";
$i18n['t1l7c1'] = "Max execution time";
$i18n['t1l8c1'] = "DB services";
$i18n['t1l9c1'] = "Preconized install RAM limit";
$i18n['t1l10c1'] = "Preconized install time limit";

$i18n['test_ok']	= "ok";
$i18n['test_nok']	= "Warning";

$i18n['F2_title'] = "Installation method";
$i18n['F2_intro'] = "There are two ways to install MultiWeb Manager. This method ease installation on a bigger number of plateforms.<br>\r<br>\r";
$i18n['F2_txt_aide1'] = "<span style=\'font-weight:bold;\'>Direct connection</span><br>The install tool will connect to the database (local or remote) and will create the necessary tables for engine to be functionning.The parameters entered in the config panel will be used when the website will operate. <br><br>Don\'t forget to copy the files on the server.";
$i18n['F2_txt_aide2'] = "<span style=\'font-weight:bold;\'>Scripted installation</span><br>The install tool will create a script you will be able to load on a PhpMyAdmin interface (for example). This is used when the hosting service do not allow direct connection to the server. Nowdays it seems to be rare.<br>";
$i18n['F2_m1o1'] = "Direct connection to the DB";
$i18n['F2_m1o2'] = "Script creation";


$i18n['F3_title'] = "Sites to process";
$i18n['t3l1c1']	= "Directories in Website_datas folder";
$i18n['t3l1c2']	= "Installation ?";
$i18n['t3l1c3']	= "Should I check the code ?";


$i18n['F4_title'] = "Connection to the DB for installing";
$i18n['F4_intro'] = "An access to the database associated with the webserver is required for intalling the engine. The user should have enough privilèges to be able to create databases and tables. The logins and password you will provide will not be reused. The installer will create its own user to make the engine function (next form). Please fill the form below.<br>\r<br>\r";
$i18n['t4l1c1'] = "Element";
$i18n['t4l1c2'] = "Prefix ";
$i18n['t4l1c3'] = "Field";
$i18n['t4l1c4'] = "Information";
$i18n['t4l2c1'] = "Abstraction Layer";
$i18n['t4l2c2'] = "";
$i18n['t4l2c4']	= "Choose the DAL support you wish (Warning PEAR DB is deprecated). AdoDB is experimental at the moment.";			
$i18n['msdal_msqli'] = "PHP MysqlI (default)";
$i18n['msdal_phppdo'] = "PHP PDO";
$i18n['msdal_adodb'] = "ADOdb (check webhosting plan)";
$i18n['msdal_pear'] = "PEAR DB (deprecated)";
$i18n['t4l3c1'] = "Type";
$i18n['t4l3c2']= "";
$i18n['t4l3c4']	= "The DB support is provided by selected module.";
$i18n['t4l4c4AD'] = "If you run this script on your website in a hosting plan, you probably have restriction about creating databases. Usually you have to do it in a Cpanel/PHPMyadmin interface. You should select \'hosting plan\' in that case. The script will not remove the database you name. Only empty it.<br><br>The other case is a server where you can do absolutly everything. Select \'absolute power\'.";
$i18n['t4l4c1'] = "Hosting profile";
$i18n['t4l4c2']= "";
$i18n['t4l4c4']	= "Choose the hosting profile where the engine should be installed.";
$i18n['dbp_hosted'] = "Hosting plan";
$i18n['dbp_asolute'] = "Absolute power";
$i18n['t4l5c1'] = "Database server";	
$i18n['t4l5c2'] = "";
$i18n['t4l5c3'] = "";
$i18n['t4l5c4'] = "This is the server where the database is. Most of the time 'localhost' (literaly) is the only necessary information. Otherwise check with the webhosting provider.";
$i18n['t4l6c1']	= "Prefix";
$i18n['t4l6c2']	= "";
$i18n['t4l6c3']	= "";
$i18n['t4l6c4']	= "Sometimes a prefix is needed. Usueally it's your account login provided by your webhosting provider. Ex : myaccount_ + DBuser. Enter the prefix in this filed only.";
$i18n['t4l7c1']	= "Database name";
$i18n['t4l7c2']	= "";
$i18n['t4l7c3']	= "";
$i18n['t4l7c4']	= "This is the name for the database on the server.";
$i18n['t4l8c1']	= "Admin login";
$i18n['t4l8c2']	= "";
$i18n['t4l8c3']	= "";
$i18n['t4l8c4']	= "Enter a login that has enough privileges to create databases and tables and users on the DB server. ";
$i18n['t4l9c1']	= "Password";
$i18n['t4l9c2']	= "";
$i18n['t4l9c3']	= "";
$i18n['t4l9c4']	= "";
$i18n['t4l10c1']	= "Test the database connexion";
$i18n['t4l10c2']	= "";
$i18n['t4l10c4aok']	= "The database connection suceeded.";
$i18n['t4l10c4ako']	= "The database connection failed.";
$i18n['t4l10c4bok']	= "A Hydr database has been found.";
$i18n['t4l10c4bko']	= "Hydr database not found.";


$i18n['F5_title'] = "DB personalization";
$i18n['t5l1c1'] = "Element";
$i18n['t5l1c2'] = "Prefix ";
$i18n['t5l1c3'] = "Field";
$i18n['t5l1c4'] = "Information";
$i18n['t5l2c1']	= "Table Prefix";
$i18n['t5l2c2']	= "";
$i18n['t5l2c3']	= "";
$i18n['t5l2c4']	= "Each table will have this prefix. Depending on database it can be usefull.";
$i18n['t5l3c1']	= "User name of the database user (your scripts)";
$i18n['t5l3c2']	= "";
$i18n['t5l3c3']	= "";
$i18n['t5l3c4']	= "This is the virtual user. The script will use this to connect the database. Make sure it is diff&eacute;rent from the server owner. Depending on webhosting provider you have to declare the DB and the user before installing.";
$i18n['boutonpass']		= "Generate";
$i18n['t5l4c1']	= "Password";
$i18n['t5l4c2']	= "";
$i18n['t5l4c3']	= "";
$i18n['t5l4c4']	= "If the user already exists for that database, do not generate a password. Use the one associated with that user.";
$i18n['t5l5c1']	= "Recreate this user";
$i18n['dbr_o'] = "Yes";
$i18n['dbr_n'] = "No";
$i18n['t5l5c2']	= "";
$i18n['t5l5c3']	= "";
$i18n['t5l5c4']	= "If it is possible (admin privilège) it is better to recreate the script user during installation. If 'no' is selected you should check that this user is correctly configured to use the databse.";
$i18n['t5l6c1']	= "Generic user Password";
$i18n['t5l6c2']	= "";
$i18n['t5l6c3']	= "";
$i18n['t5l6c4']	= "The engine needs some user in order for you to access the admin panel of the site. This is the password for the generics user of the website.";
$i18n['t5l7c1']	= "Make .htaccess";
$i18n['t5l7c2']	= "";
$i18n['t5l7c3']	= "";
$i18n['t5l7c4']	= "The .htaccess file is a ruleset that defines access authorizations to files on the web server. It helps to protect the files that contain certain information such as password etc. The file given use classical rules. The behavior of this ruleset also depends on the webserver.";
$i18n['TypeExec1']	= "Apache module";
$i18n['TypeExec2']	= "CLI";
$i18n['t5l8c1']	= "Execution type";
$i18n['t5l8c2']	= "";
$i18n['t5l8c3']	= "";
$i18n['t5l8c4']	= "You can execute the installation as Apache module or as stand alone CLI. it all depends on what your Webhosting plan authorize you to do. Default is 'as apache module'.";


$i18n['F6_title'] = "Installation report";
$i18n['t6l1c1']	= "Display report options";
$i18n['t6l1c2']	= "";
$i18n['t6l1c3']	= "";
$i18n['t6l1c4']	= "";
$i18n['t6l2c1']	= "Database";
$i18n['t6l2c2']	= "Warning messages";
$i18n['t6l2c3']	= "Error messages";
$i18n['t6l3c1']	= "Console";
$i18n['t6l3c2']	= "Warning messages";
$i18n['t6l3c3']	= "Error messages";


$i18n['ls0'] = "Database server";
$i18n['ls1'] = "Admin login (read / write)";
$i18n['ls2'] = "Password";
$i18n['ls3'] = "Database name";
$i18n['ls4'] = "User name of the database user (your scripts)";
$i18n['ls5'] = "Database user Password";
$i18n['ls6'] = "Generic user Password";

?>