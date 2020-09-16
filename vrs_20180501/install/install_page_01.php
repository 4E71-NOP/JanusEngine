<?php
 /*Hydre-licence-debut*/
// --------------------------------------------------------------------------------------------
//
//	Hydre - Le petit moteur de web
//	Sous licence Creative Common	
//	Under Creative Common licence	CC-by-nc-sa (http://creativecommons.org)
//	CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
//	(c)Faust MARIA DE AREVALO faust@club-internet.fr
//
// --------------------------------------------------------------------------------------------
/*Hydre-licence-fin*/
//		Installation page 01
// --------------------------------------------------------------------------------------------

$_REQUEST['StatistiqueInsertion'] = 0;

// --------------------------------------------------------------------------------------------
//
// Récupération information serveur
//
// --------------------------------------------------------------------------------------------

$_REQUEST['CC_niveau_de_verification'] = 1;		//Fait les vérifications au complet des commande entrées. Doublon, erreur etc.// --------------------------------------------------------------------------------------------

function get_real_ip() {
    if (isset($_SERVER['HTTP_CLIENT_IP']))				{ return $_SERVER['HTTP_CLIENT_IP']; }
    elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']))	{ return $_SERVER['HTTP_X_FORWARDED_FOR']; }
    elseif (isset($_SERVER['HTTP_X_FORWARDED']))		{ return $_SERVER['HTTP_X_FORWARDED']; }
    elseif (isset($_SERVER['HTTP_FORWARDED_FOR']))		{ return $_SERVER['HTTP_FORWARDED_FOR']; }
    elseif (isset($_SERVER['HTTP_FORWARDED']))			{ return $_SERVER['HTTP_FORWARDED']; }
    else { return $_SERVER['REMOTE_ADDR']; }
}

$_REQUEST['server_infos']['srv_hostname']		= php_uname('s') . " " . php_uname('n') . " ". php_uname('m') . " / " . get_real_ip();
$_REQUEST['server_infos']['repertoire_courant']	= getcwd();
$_REQUEST['server_infos']['include_path']		= get_include_path(); 
$_REQUEST['server_infos']['uid']				= getmyuid(); 
$_REQUEST['server_infos']['gid']				= getmygid(); 
$_REQUEST['server_infos']['pid']				= getmypid(); 
$_REQUEST['server_infos']['navigateur']			= getenv("HTTP_USER_AGENT");
$_REQUEST['server_infos']['proprietaire']		= get_current_user(); 
$_REQUEST['server_infos']['memory_limit']		= ini_get('memory_limit');
$_REQUEST['server_infos']['display_errors']		= ini_get('display_errors');
$_REQUEST['server_infos']['register_globals']	= ini_get('register_globals'); 
$_REQUEST['server_infos']['post_max_size']		= ini_get('post_max_size');
$_REQUEST['server_infos']['max_execution_time']	= ini_get('max_execution_time');


$tl_['fra']['Oui'] = "Oui";			$tl_['eng']['Oui'] = "Yes";
$tl_['fra']['Non'] = "Non";			$tl_['eng']['Non'] = "No";

if ( $_REQUEST['server_infos']['display_errors'] == 0 ) { $_REQUEST['server_infos']['display_errors'] = $tl_[$l]['Non']; }
else { $_REQUEST['server_infos']['display_errors'] = $tl_[$l]['Oui']; }

if ( $_REQUEST['server_infos']['register_globals'] == 0 ) { $_REQUEST['server_infos']['register_globals'] = $tl_[$l]['Non']; }
else { $_REQUEST['server_infos']['register_globals'] = $tl_[$l]['Oui']; }

$pv['Formulaire_nom'] = "install_page_init";

echo ("
<form ACTION='install.php' id='".$pv['Formulaire_nom']."' method='post'>\r
");
// --------------------------------------------------------------------------------------------
//
//	Cadre 00
//
// --------------------------------------------------------------------------------------------
$pv['lang']['1']['nom'] = "eng";		$pv['lang']['1']['fichier'] = "tl_eng.png";
$pv['lang']['2']['nom'] = "fra";		$pv['lang']['2']['fichier'] = "tl_fra.png" ;

echo ("<p  class='" . $theme_tableau . $_REQUEST['bloc']."_tb3' style='text-align: center;'>\r");
foreach ( $pv['lang'] as $A ) {
	echo ("<a href='install.php?l=".$A['nom']."'><img src='../graph/".${$theme_tableau}['theme_repertoire']."/".$A['fichier']."' alt='' height='64' width='64' border='0'></a>\r");
}
echo ("</p><br>\r");

// --------------------------------------------------------------------------------------------
//
//	Cadre 01
//
// --------------------------------------------------------------------------------------------
$pv['cadre_numero'] = 1;

$tab_infos['AffOnglet']			= 0;
$tab_infos['NbrOnglet']			= 1;
$tab_infos['NbrOnglet']			+= $_REQUEST['debug_option']['onglet_install_debug'];
$tab_infos['tab_comportement']	= 1;
$tab_infos['mode_rendu']		= 0;
$tab_infos['TypSurbrillance']	= 0; // 1:ligne, 2:cellule
$tab_infos['doc_height']		= 320;
$tab_infos['doc_width']			= ${$theme_tableau}['theme_module_largeur_interne'] -24 ;
$tab_infos['groupe']			= "inst1";
$tab_infos['cell_id']			= "cadre01";
$tab_infos['document']			= "doc";

$JavaScriptInitCommandes[] = "ADDA_div_init ( 'Contenu_cadre_".$pv['cadre_numero']."' , 'titre_cadre_".$pv['cadre_numero']."_img', 
'../graph/" . ${$theme_tableau}['theme_repertoire'] . "/" . ${$theme_tableau}[$_REQUEST['blocT']]['deco_icone_bas'] ."', 
'../graph/" . ${$theme_tableau}['theme_repertoire'] . "/" . ${$theme_tableau}[$_REQUEST['blocT']]['deco_icone_haut'] ."', 
1, 60 , 0.25, ".$tab_infos['doc_height']." );";

$tl_['fra']['C2_titre'] = "Information de ce serveur";
$tl_['eng']['C2_titre'] = "This server information";
echo ("
<div id='titre_cadre_".$pv['cadre_numero']."' class='" . $theme_tableau.$_REQUEST['bloc']."_tb5 ".$theme_tableau.$_REQUEST['bloc']."_fcta' style='width: ".$tab_infos['doc_width']."px; vertical-align: middle;' >\r
<img id='titre_cadre_".$pv['cadre_numero']."_img' src='../graph/" . ${$theme_tableau}['theme_repertoire'] . "/" . ${$theme_tableau}[$_REQUEST['blocT']]['deco_icone_haut'] . "' width='32' height='32' border='0' style='vertical-align: middle;' onclick=\"animation_document_div_accordeon( 'Contenu_cadre_".$pv['cadre_numero']."' );\">\r
".$tl_[$l]['C2_titre']."
</div>\r
<br>\r

<div id='Contenu_cadre_".$pv['cadre_numero']."' style='text-align: justify; width: ".$tab_infos['doc_width']."px; height: ".$tab_infos['doc_height']."px; overflow: hidden;'>\r
");

// --------------------------------------------------------------------------------------------
// Detection des supports installés sur la machine.
// --------------------------------------------------------------------------------------------

$tl_['fra']['PHP_builtin_ok'] = "est pr&eacute;sent.\r";
$tl_['fra']['PHP_builtin_nok'] = "n'a pas &eacute;t&eacute; trouv&eacute;.<br>\r";

$tl_['eng']['PHP_builtin_ok'] = "support is enabled.\r";
$tl_['eng']['PHP_builtin_nok'] = "support not found.<br>\r";

$pv['a'] = "<span class='" . $theme_tableau.$_REQUEST['bloc']."_avert'>";
$pv['b'] = "</span>";

$pv['icone_gonogo_ok'] = "<img src='../graph/" . ${$theme_tableau}['theme_repertoire'] . "/" . ${$theme_tableau}[$_REQUEST['blocT']]['deco_icone_ok'] . "' width='16' height='16' border='0'>";
$pv['icone_gonogo_nok'] = "<img src='../graph/" . ${$theme_tableau}['theme_repertoire'] . "/" . ${$theme_tableau}[$_REQUEST['blocT']]['deco_icone_nok'] . "' width='16' height='16' border='0'>";

$tl_['fra']['PHP_support_titre'] = "Couche d'abstraction de base de donn&eacute;es:<br>\r";
$tl_['eng']['PHP_support_titre'] = "Database abstraction layer:<br>\r";
$Support['reponse'] .= $tl_[$l]['PHP_support_titre'];


$Support['DAL']['ADOdb']['etat'] = 0;
$Support['DAL']['ADOdb']['fichier'] = "/usr/share/php/adodb/adodb.inc.php";
$Support['DAL']['ADOdb']['include'] = "/usr/share/php/adodb/adodb.inc.php";
$Support['DAL']['ADOdb']['fonction'] = "DAL_adodb";
$Support['DAL']['ADOdb']['nom'] = "ADOdb";

$Support['DAL']['pear']['etat'] = 0;
$Support['DAL']['pear']['fichier'] = "/usr/bin/pear";
$Support['DAL']['pear']['include'] = "MDB2.php";
$Support['DAL']['pear']['fonction'] = "DAL_PEAR";
$Support['DAL']['pear']['nom'] = "PEAR";

function DAL_adodb () {
	global $ADODB_vers;
	return ( $ADODB_vers );
}

//  sudo pear list
//  sudo pear install MDB2_Driver_sqlite
//  sudo pear list
//  sudo pear upgrade-all
//
//xxxxx@xxxxx:/usr/share/php$ pear list
//Installed packages, channel pear.php.net:
//=========================================
//Package            Version State
//Archive_Tar        1.3.3   stable
//Console_Getopt     1.2.3   stable
//DB                 1.7.13  stable
//MDB2               2.4.1   stable
//MDB2_Driver_mysql  1.4.1   stable
//MDB2_Driver_sqlite 1.4.1   stable
//PEAR               1.8.1   stable
//Structures_Graph   1.0.2   stable
//XML_Util           1.2.1   stable

// Doctrine = /usr/share/php/Doctrine/lib/Doctrine

function DAL_PEAR () {
	$B = "";
	if ( function_exists( 'exec' ) ) {
		$pv['exec_state'] = 1;
		exec ( "/usr/bin/pear list" , $PEAR , $pv['exec_state'] );
		if ( $pv['exec_state'] == 0 ) {
			foreach ( $PEAR as $A ) {
				if ( strpos ( $A , "MDB2_Driver_mysql" ) !== FALSE ) { $B .= $A; }
				if ( strpos ( $A , "MDB2_Driver_sqlite" ) !== FALSE  ) { $B .= $A; }
			}
		}
	}
	return ( $B );
}

foreach ( $Support['DAL'] as &$A ) {
	if ( file_exists ($A['fichier']) ) {
		$A['etat'] = 1;
		include ( $A['include']); 		// no include_once because MDB2.php bug (timeout 60sec).
		$F = $A['fonction'];
		$Support['reponse'] .= $pv['icone_gonogo_ok'] . " " . $A['nom']  ." " . $tl_[$l]['PHP_builtin_ok'] . "(" . $F() . ")<br>\r";
	}
	else {
		$Support['reponse'] .= $pv['icone_gonogo_nok'] . " " . $pv['a'] . $A['nom']  ." " . $tl_[$l]['PHP_builtin_nok'] . $pv['b'];
	}
}
if (defined('PDO::MYSQL_ATTR_LOCAL_INFILE')) { 
	$Support['reponse'] .= $pv['icone_gonogo_ok'] . " " . "PDO/MySQL" ." " . $tl_[$l]['PHP_builtin_ok']; 
	$Support['DAL']['PDO']['etat'] = 1;
}
else { 
	$Support['reponse'] .= $pv['icone_gonogo_nok'] . " " . $pv['a'] . "PDO/MySQL" ." " . $tl_[$l]['PHP_builtin_nok'] . $pv['b']; 
	$Support['DAL']['PDO']['etat'] = 0;
}

$Support['PHP']['PHP_cubrid_builtin']['etat'] = 0;		$Support['PHP']['PHP_cubrid_builtin']['f'] = "cubrid_connect";		$Support['PHP']['PHP_cubrid_builtin']['nom'] = "CUBRID";
$Support['PHP']['PHP_dbplus_builtin']['etat'] = 0;		$Support['PHP']['PHP_dbplus_builtin']['f'] = "dbplus_open";			$Support['PHP']['PHP_dbplus_builtin']['nom'] = "DB++";
$Support['PHP']['PHP_dbase_builtin']['etat'] = 0;		$Support['PHP']['PHP_dbase_builtin']['f'] = "dbase_open";			$Support['PHP']['PHP_dbase_builtin']['nom']	 = "DBase";
$Support['PHP']['PHP_filepro_builtin']['etat'] = 0;		$Support['PHP']['PHP_filepro_builtin']['f'] = "filepro";			$Support['PHP']['PHP_filepro_builtin']['nom'] = "FilePro";
$Support['PHP']['PHP_ibase_builtin']['etat'] = 0;		$Support['PHP']['PHP_ibase_builtin']['f'] = "ibase_connect";		$Support['PHP']['PHP_ibase_builtin']['nom']	 = "Firebird/InterBase";
$Support['PHP']['PHP_frontbase_builtin']['etat'] = 0;	$Support['PHP']['PHP_frontbase_builtin']['f'] = "fbsql_connect";	$Support['PHP']['PHP_frontbase_builtin']['nom'] = "FrontBase";
$Support['PHP']['PHP_db2_builtin']['etat'] = 0;			$Support['PHP']['PHP_db2_builtin']['f'] = "db2_connect";			$Support['PHP']['PHP_db2_builtin']['nom'] = "IBM DB2";
$Support['PHP']['PHP_ifx_builtin']['etat'] = 0;			$Support['PHP']['PHP_ifx_builtin']['f'] = "ifx_connect";			$Support['PHP']['PHP_ifx_builtin']['nom'] = "Informix";
$Support['PHP']['PHP_ingress_builtin']['etat'] = 0;		$Support['PHP']['PHP_ingress_builtin']['f'] = "ingres_connect";		$Support['PHP']['PHP_ingress_builtin']['nom'] = "Ingress";
$Support['PHP']['PHP_maxdb_builtin']['etat'] = 0;		$Support['PHP']['PHP_maxdb_builtin']['f'] = "maxdb_connect";		$Support['PHP']['PHP_maxdb_builtin']['nom'] = "MaxDB";
$Support['PHP']['PHP_msql_builtin']['etat'] = 0;		$Support['PHP']['PHP_msql_builtin']['f'] = "msql_connect";			$Support['PHP']['PHP_msql_builtin']['nom'] = "mSQL";
$Support['PHP']['PHP_mssql_builtin']['etat'] = 0;		$Support['PHP']['PHP_mssql_builtin']['f'] = "mssql_connect";		$Support['PHP']['PHP_mssql_builtin']['nom'] = "Mssql";
$Support['PHP']['PHP_mysql_builtin']['etat'] = 0;		$Support['PHP']['PHP_mysql_builtin']['f'] = "mysql_connect";		$Support['PHP']['PHP_mysql_builtin']['nom'] = "MySQL";
$Support['PHP']['PHP_mysqli_builtin']['etat'] = 0;		$Support['PHP']['PHP_mysqli_builtin']['f'] = "mysqli_connect";		$Support['PHP']['PHP_mysqli_builtin']['nom'] = "MySQLi";
$Support['PHP']['PHP_oci_builtin']['etat'] = 0;			$Support['PHP']['PHP_oci_builtin']['f'] = "oci_connect";			$Support['PHP']['PHP_oci_builtin']['nom'] = "OCI8";
$Support['PHP']['PHP_px_builtin']['etat'] = 0;			$Support['PHP']['PHP_px_builtin']['f'] = "px_open_fp";				$Support['PHP']['PHP_px_builtin']['nom'] = "Paradox";
$Support['PHP']['PHP_postgresql_builtin']['etat'] = 0;	$Support['PHP']['PHP_postgresql_builtin']['f'] = "pg_connect";		$Support['PHP']['PHP_postgresql_builtin']['nom'] = "PostgreSQL";
$Support['PHP']['PHP_sqlite_builtin']['etat'] = 0;		$Support['PHP']['PHP_sqlite_builtin']['f'] = "sqlite_open";			$Support['PHP']['PHP_sqlite_builtin']['nom'] = "SQLite";
$Support['PHP']['PHP_sqlsrv_builtin']['etat'] = 0;		$Support['PHP']['PHP_sqlsrv_builtin']['f'] = "sqlsrv_connect";		$Support['PHP']['PHP_sqlsrv_builtin']['nom'] = "SQLSRV";
$Support['PHP']['PHP_sybase_builtin']['etat'] = 0;		$Support['PHP']['PHP_sybase_builtin']['f'] = "sybase_connect";		$Support['PHP']['PHP_sybase_builtin']['nom'] = "Sybase";

$tl_['fra']['PHP_support_titre'] = "<hr>Fonctions PHP (le support...):<br>\r";
$tl_['eng']['PHP_support_titre'] = "<hr>PHP functions:<br>\r";
$Support['reponse'] .= $tl_[$l]['PHP_support_titre'];

foreach ( $Support['PHP'] as &$A ) {
	if ( function_exists( $A['f'] ) ) { 
		$A['etat'] = 1; 
		$Support['reponse'] .= $pv['icone_gonogo_ok'] . " " . $A['nom']  ." " . $tl_[$l]['PHP_builtin_ok'];
	}
}
$Support['PHP_version'] = "PHP vrs " . phpversion();

// --------------------------------------------------------------------------------------------
// site_2_config_mwm.php default
$db_['type']				= "mysql";
$db_['admin_user']			= "dbadmin";
$db_['admin_password']		= "nimdabd";
$db_['host']				= "localhost";
$db_['dal']					= "MYSQLI";
$db_['directory']			= "www.multiweb-manager.net";
$db_['user_login']			= "HydreBDD";
$db_['user_password']		= "Celeste";
$db_['db_hosting_prefix']	= "";
$db_['dbprefix']			= "Hdr";
$db_['tabprefix']			= "Ht_";
$maid_stats_nombre_de_couleurs = 5;

// --------------------------------------------------------------------------------------------
$pv['onglet'] = 1;
$ADC['onglet'][$pv['onglet']]['nbr_ligne'] = 8;	$ADC['onglet'][$pv['onglet']]['nbr_cellule'] = 2;	$ADC['onglet'][$pv['onglet']]['legende'] = 0;

$tl_['eng']['o1l1c1'] = "This server Hostname / IP";						$tl_['fra']['o1l1c1'] = "Nom de cette machine / IP"; 
$tl_['eng']['o1l2c1'] = "PHP version";										$tl_['fra']['o1l2c1'] = "Version PHP"; 
$tl_['eng']['o1l3c1'] = "Include path";										$tl_['fra']['o1l3c1'] = "Chemin d'inclusion";
$tl_['eng']['o1l4c1'] = "Current directory";								$tl_['fra']['o1l4c1'] = "R&eacute;pertoire courant";
$tl_['eng']['o1l5c1'] = "Display error / register global / Post max size";	$tl_['fra']['o1l5c1'] = "Affiche erreur / Registre global / Taille maximum du 'POST'";
$tl_['eng']['o1l6c1'] = "Memory limit";										$tl_['fra']['o1l6c1'] = "Limite m&eacute;moire";
$tl_['eng']['o1l7c1'] = "Max execution time";								$tl_['fra']['o1l7c1'] = "Temps d'ex&eacute;cution maximum";
//$tl_['eng']['o1l8c1'] = "PHP component";									$tl_['fra']['o1l8c1'] = "Composant PHP";
$tl_['eng']['o1l8c1'] = "DB services";										$tl_['fra']['o1l8c1'] = "Service de base de donn&eacute;es";

$tl_['uni']['o1l1c2'] = $_REQUEST['server_infos']['srv_hostname'];
$tl_['uni']['o1l2c2'] = $Support['PHP_version'];
$tl_['uni']['o1l3c2'] = $_REQUEST['server_infos']['include_path'];
$tl_['uni']['o1l4c2'] = $_REQUEST['server_infos']['repertoire_courant'];
$tl_['uni']['o1l5c2'] = $_REQUEST['server_infos']['display_errors']." / ". $_REQUEST['server_infos']['register_globals'] ." / ". $_REQUEST['server_infos']['post_max_size'];
$tl_['uni']['o1l6c2'] = $_REQUEST['server_infos']['memory_limit'];
$tl_['uni']['o1l7c2'] = $_REQUEST['server_infos']['max_execution_time'] ."s";
$tl_['uni']['o1l8c2'] = $Support['reponse'];

$tl_['fra']['test_ok']	= "<span  class='" . $theme_tableau .$_REQUEST['bloc']."_t3'>ok</span>";					$tl_['eng']['test_ok']		= "<span  class='" . $theme_tableau .$_REQUEST['bloc']."_t3'>ok</span>";
$tl_['fra']['test_nok']	= "<span  class='" . $theme_tableau .$_REQUEST['bloc']."_avert'>Avertissement</span>";		$tl_['eng']['test_nok']		= "<span  class='" . $theme_tableau .$_REQUEST['bloc']."_avert'>Warning</span>";

if ( intval(str_replace( "M", "", $_REQUEST['server_infos']['memory_limit'] )) >= 128 ) { $tl_['uni']['o1l6c2'] .= " (" . $tl_[$l]['test_ok'].")"; }	
else { $tl_['uni']['o1l6c2'] .= " (" . $tl_[$l]['test_nok'].")"; }

if ( $_REQUEST['server_infos']['max_execution_time'] >= 60 ) { $tl_['uni']['o1l7c2'] .= " (" . $tl_[$l]['test_ok'].")"; }	
else { $tl_['uni']['o1l7c2'] .= " (" . $tl_[$l]['test_nok'].")"; }

for ( $pv['i'] = 1 ; $pv['i'] <= $ADC['onglet'][$pv['onglet']]['nbr_ligne'] ; $pv['i']++ ) {
	$AD[$pv['onglet']][$pv['i']]['1']['cont'] = $tl_[$l]['o1l'.$pv['i'].'c1'];
	$AD[$pv['onglet']][$pv['i']]['2']['cont'] = $tl_['uni']['o1l'.$pv['i'].'c2'];
}

include ("routines/website/affichage_donnees.php");

echo ("</div>\r");

$pv['cadre_numero']++;

// --------------------------------------------------------------------------------------------
//
//	Cadre 02
//
// --------------------------------------------------------------------------------------------
$tab_infos['AffOnglet']			= 0;
$tab_infos['NbrOnglet']			= 1;
$tab_infos['tab_comportement']	= 1;
$tab_infos['NbrOnglet']			+= $_REQUEST['debug_option']['onglet_install_debug'];
$tab_infos['mode_rendu']		= 0;
$tab_infos['TypSurbrillance']	= 0; // 1:ligne, 2:cellule
$tab_infos['doc_height']		= 96;
$tab_infos['doc_width']			= ${$theme_tableau}['theme_module_largeur_interne'] -24 ;
$tab_infos['groupe']			= "inst1";
$tab_infos['cell_id']			= "cadre02";
$tab_infos['document']			= "doc";

$JavaScriptInitCommandes[] = "ADDA_div_init ( 'Contenu_cadre_".$pv['cadre_numero']."' , 'titre_cadre_".$pv['cadre_numero']."_img', 
'../graph/" . ${$theme_tableau}['theme_repertoire'] . "/" . ${$theme_tableau}[$_REQUEST['blocT']]['deco_icone_bas'] ."', 
'../graph/" . ${$theme_tableau}['theme_repertoire'] . "/" . ${$theme_tableau}[$_REQUEST['blocT']]['deco_icone_haut'] ."', 
1, 30 , 0.25, ".$tab_infos['doc_height']." );";

$pv['onglet'] = 1;
$lt = 1;
$ADC['onglet'][$pv['onglet']]['nbr_ligne'] = 1;	$ADC['onglet'][$pv['onglet']]['nbr_cellule'] = 2;	$ADC['onglet'][$pv['onglet']]['legende'] = 0;


$pv['lang']['1']['nom'] = "English";			$pv['lang']['1']['fichier'] = "English.png";
$pv['lang']['2']['nom'] = "Fran&ccedil;ais_fr";	$pv['lang']['2']['fichier'] = "Fran&ccedil;ais_fr.png" ;

$tl_['fra']['C2_txt_aide1'] = "<span style=\'font-weight:bold;\'>Choix d\'une installation directe:</span><br>L\'installateur va se connecter &agrave; la base (soit locale soit distante) et va cr&eacute;er les tables n&eacute;cessaires pour que le moteur fonctionne. Les param&egrave;tres entr&eacute;s dans la configuration de cette instalation serviront pour le site en tant que tel.<br><br>N\'oubliez pas de copier les fichiers sur le serveur.";
$tl_['eng']['C2_txt_aide1'] = "<span style=\'font-weight:bold;\'>Direct connection</span><br>The install tool will connect to the database (local or remote) and will create the necessary tables for engine to be functionning.The parameters entered in the config panel will be used when the website will operate. <br><br>Don\'t forget to copy the files on the server.";

$tl_['fra']['C2_txt_aide2'] = "<span style=\'font-weight:bold;\'>Choix d\'une installation par script:</span><br>L\'installateur va cr&eacute;er un script qui permettra &agrave; l\'utilisateur de le charger sur une interface de type PhpMyAdmin. Ce genre de cas s\'applique avec des h&eacute;bergeurs qui ne permettent pas une connexion directe au serveur de base de donn&eacute;es. Cela tend &agrave; &ecirc;tre plus rare de nos jours.<br>";
$tl_['eng']['C2_txt_aide2'] = "<span style=\'font-weight:bold;\'>Scripted installation</span><br>The install tool will create a script you will be able to load on a PhpMyAdmin interface (for example). This is used when the hosting service do not allow direct connection to the server. Nowdays it seems to be rare.<br>";

$tl_['fra']['C2_titre'] = "M&eacute;thode d'installation";
$tl_['eng']['C2_titre'] = "Installation method";


$tl_['fra']['C2_m1o1'] = "Connexion directe &agrave; la base
<img src='../graph/" . ${$theme_tableau}['theme_repertoire'] . "/" . ${$theme_tableau}[$_REQUEST['blocT']]['deco_icone_question'] . "' width='16' height='16' border='0' 
onMouseOver=\"Bulle('".$tl_['fra']['C2_txt_aide1']."')\" onMouseOut=\"Bulle()\">";

$tl_['fra']['C2_m1o2'] = "Cr&eacute;ation d'un script
<img src='../graph/" . ${$theme_tableau}['theme_repertoire'] . "/" . ${$theme_tableau}[$_REQUEST['blocT']]['deco_icone_question'] . "' width='16' height='16' border='0' 
onMouseOver=\"Bulle('".$tl_['fra']['C2_txt_aide2']."')\" onMouseOut=\"Bulle()\">";

$tl_['eng']['C2_m1o1'] = "Direct connection to the DB
<img src='../graph/" . ${$theme_tableau}['theme_repertoire'] . "/" . ${$theme_tableau}[$_REQUEST['blocT']]['deco_icone_question'] . "' width='16' height='16' border='0' 
onMouseOver=\"Bulle('".$tl_['eng']['C2_txt_aide1']."')\" onMouseOut=\"Bulle()\">";

$tl_['eng']['C2_m1o2'] = "Script creation
<img src='../graph/" . ${$theme_tableau}['theme_repertoire'] . "/" . ${$theme_tableau}[$_REQUEST['blocT']]['deco_icone_question'] . "' width='16' height='16' border='0' 
onMouseOver=\"Bulle('".$tl_['eng']['C2_txt_aide2']."')\" onMouseOut=\"Bulle()\">";

$tl_['eng']['o1l1c1'] = "<input type='radio' name='form[mode_operatoire]' value='connexion_directe' checked>".$tl_['eng']['C2_m1o1'];
$tl_['fra']['o1l1c1'] = "<input type='radio' name='form[mode_operatoire]' value='connexion_directe' checked>".$tl_['fra']['C2_m1o1'];

$tl_['eng']['o1l1c2'] = "<input type='radio' name='form[mode_operatoire]' value='installation_differee'>".$tl_['eng']['C2_m1o2'];
$tl_['fra']['o1l1c2'] = "<input type='radio' name='form[mode_operatoire]' value='installation_differee'>".$tl_['fra']['C2_m1o2'];

$tl_['fra']['C2_intro'] = "Il y a deux types d'installation de MultiWeb Manager. Ceci dans le but de permettre une installation facile sur un plus large nombre de plateformes.<br>\r<br>\r";
$tl_['eng']['C2_intro'] = "There are two ways to install MultiWeb Manager. This method ease installation on a bigger number of plateforms.<br>\r<br>\r";

echo ("
<div id='titre_cadre_".$pv['cadre_numero']."' class='" . $theme_tableau.$_REQUEST['bloc']."_tb5 ".$theme_tableau.$_REQUEST['bloc']."_fcta' style='width: ".$tab_infos['doc_width']."px; vertical-align: middle;' >\r
<img id='titre_cadre_".$pv['cadre_numero']."_img' src='../graph/" . ${$theme_tableau}['theme_repertoire'] . "/" . ${$theme_tableau}[$_REQUEST['blocT']]['deco_icone_haut'] . "' width='32' height='32' border='0' style='vertical-align: middle;' onclick=\"animation_document_div_accordeon( 'Contenu_cadre_".$pv['cadre_numero']."' );\">\r
".$tl_[$l]['C2_titre']."
</div>\r
<br>\r
<div class='".$theme_tableau.$_REQUEST['bloc']."_t3' id='Contenu_cadre_".$pv['cadre_numero']."' style='text-align: justify; width: ".$tab_infos['doc_width']."px; height: ".$tab_infos['doc_height']."px; overflow: hidden;'>\r
".$tl_[$l]['C2_intro']."\r
");

$AD[$pv['onglet']][$lt]['1']['cont'] = $tl_[$l]['o1l'.$lt.'c1'];
$AD[$pv['onglet']][$lt]['2']['cont'] = $tl_[$l]['o1l'.$lt.'c2'];

include ("routines/website/affichage_donnees.php");

echo ("</div>\r");

$pv['cadre_numero']++;

// --------------------------------------------------------------------------------------------
//
//	Cadre 03
//
// --------------------------------------------------------------------------------------------
$tab_infos['AffOnglet']			= 0;
$tab_infos['tab_comportement']	= 1;
$tab_infos['NbrOnglet']			= 1;
$tab_infos['NbrOnglet']			+= $_REQUEST['debug_option']['onglet_install_debug'];
$tab_infos['mode_rendu']		= 0;
$tab_infos['TypSurbrillance']	= 0; // 1:ligne, 2:cellule
$tab_infos['doc_height']		= 192;
$tab_infos['doc_width']			= ${$theme_tableau}['theme_module_largeur_interne'] -24 ;
$tab_infos['groupe']			= "inst1";
$tab_infos['cell_id']			= "cadre03";
$tab_infos['document']			= "doc";

$JavaScriptInitCommandes[] = "ADDA_div_init ( 'Contenu_cadre_".$pv['cadre_numero']."' , 'titre_cadre_".$pv['cadre_numero']."_img', 
'../graph/" . ${$theme_tableau}['theme_repertoire'] . "/" . ${$theme_tableau}[$_REQUEST['blocT']]['deco_icone_bas'] ."', 
'../graph/" . ${$theme_tableau}['theme_repertoire'] . "/" . ${$theme_tableau}[$_REQUEST['blocT']]['deco_icone_haut'] ."', 
1, 30, 0.25, ".$tab_infos['doc_height']." );";

$pv['onglet'] = 1;
$lt = 1;
$ADC['onglet'][$pv['onglet']]['nbr_ligne'] = 2;	$ADC['onglet'][$pv['onglet']]['nbr_cellule'] = 2;	$ADC['onglet'][$pv['onglet']]['legende'] = 0;

$tl_['fra']['C3_titre'] = "Les sites &agrave; installer";
$tl_['eng']['C3_titre'] = "Sites to process";

echo ("
<div id='titre_cadre_".$pv['cadre_numero']."' class='" . $theme_tableau.$_REQUEST['bloc']."_tb5 ".$theme_tableau.$_REQUEST['bloc']."_fcta' style='width: ".$tab_infos['doc_width']."px; vertical-align: middle;' >\r
<img id='titre_cadre_".$pv['cadre_numero']."_img' src='../graph/" . ${$theme_tableau}['theme_repertoire'] . "/" . ${$theme_tableau}[$_REQUEST['blocT']]['deco_icone_haut'] . "' width='32' height='32' border='0' style='vertical-align: middle;' onclick=\"animation_document_div_accordeon( 'Contenu_cadre_".$pv['cadre_numero']."' );\">\r
".$tl_[$l]['C3_titre']."
</div>\r
<br>\r
<div id='Contenu_cadre_".$pv['cadre_numero']."' style='text-align: center; width: ".$tab_infos['doc_width']."px; height: ".$tab_infos['doc_height']."px; overflow: hidden;'>\r
");


$ADC['onglet'][$pv['onglet']]['nbr_ligne'] = 0;	$ADC['onglet'][$pv['onglet']]['nbr_cellule'] = 3;	$ADC['onglet'][$pv['onglet']]['legende'] = 1;

$tl_['eng']['o1l1c1']	= "Directories in Website_datas folder";				$tl_['fra']['o1l1c1']	= "R&eacute;pertoires pr&eacute;sents dans Website_datas";
$AD[$pv['onglet']]['1']['1']['cont'] = $tl_[$l]['o1l1c1'];
$AD[$pv['onglet']]['1']['1']['tc'] = 4;

$tl_['eng']['o1l1c2']	= "Installation ?";				$tl_['fra']['o1l1c2']	= "Installation ?";
$AD[$pv['onglet']]['1']['2']['cont'] = $tl_[$l]['o1l1c2'];
$AD[$pv['onglet']]['1']['2']['tc'] = 4;

$tl_['eng']['o1l1c3']	= "Should I check the code ?";				$tl_['fra']['o1l1c3']	= "Faut-il Contr&ocirc;ler le code ?";
$AD[$pv['onglet']]['1']['3']['cont'] = $tl_[$l]['o1l1c3'];
$AD[$pv['onglet']]['1']['3']['tc'] = 4;

$i = 0;
$directory_list = array();
$handle = opendir("../websites-datas/");
while (false !== ($file = readdir($handle))) {
	if ( $file != "." && $file != ".." && !is_file("../websites-datas/".$file)  ) { $directory_list[$i] = $file; }
	$i++;
}
$i = 2;
closedir($handle);
sort ($directory_list);
reset ($directory_list);
foreach ( $directory_list as $a ) {
	if ( $a == "00_Hydre" ) {
		$AD[$pv['onglet']][$i]['1']['cont'] = "<span style='font-style:italic'>".$a."</span>\r";
		$AD[$pv['onglet']][$i]['2']['cont'] = "<input type='checkbox' name='liste_repertoire_a_scanner[".$a."][plouf]' disabled checked >";
		$AD[$pv['onglet']][$i]['3']['cont'] = "<input type='checkbox' name='liste_repertoire_a_scanner[".$a."][plouf2]' disabled checked >\r
		<input type='hidden' name='liste_repertoire_a_scanner[".$a."][nom_repertoire]' value='".$a."'>\r
		<input type='hidden' name='liste_repertoire_a_scanner[".$a."][etat]' value='on'>\r";
	}
	else {
		$AD[$pv['onglet']][$i]['1']['cont'] = $a." <input type='hidden' name='liste_repertoire_a_scanner[".$a."][nom_repertoire]' value='".$a."'>\r";
		$AD[$pv['onglet']][$i]['2']['cont'] = "<input type='checkbox' name='liste_repertoire_a_scanner[".$a."][etat]' checked>\r";
		$AD[$pv['onglet']][$i]['3']['cont'] = "<input type='checkbox' name='liste_repertoire_a_scanner[".$a."][CC_verification]' checked>\r";
	}
	$i++;
}
$ADC['onglet'][$pv['onglet']]['nbr_ligne'] = ( $i - 1 );

include ("routines/website/affichage_donnees.php");

echo ("</div>\r");

$pv['cadre_numero']++;
// --------------------------------------------------------------------------------------------
//
//	Cadre 04
//
// --------------------------------------------------------------------------------------------
$tab_infos['AffOnglet']			= 0;
$tab_infos['NbrOnglet']			= 1;
$tab_infos['NbrOnglet']			+= $_REQUEST['debug_option']['onglet_install_debug'];
$tab_infos['tab_comportement']	= 1;
$tab_infos['mode_rendu']		= 0;
$tab_infos['TypSurbrillance']	= 0; // 1:ligne, 2:cellule
$tab_infos['doc_height']		= 512;
$tab_infos['doc_width']			= ${$theme_tableau}['theme_module_largeur_interne'] -24 ;
$tab_infos['groupe']			= "inst1";
$tab_infos['cell_id']			= "cadre03";
$tab_infos['document']			= "doc";

$JavaScriptInitCommandes[] = "ADDA_div_init ( 'Contenu_cadre_".$pv['cadre_numero']."' , 'titre_cadre_".$pv['cadre_numero']."_img', 
'../graph/" . ${$theme_tableau}['theme_repertoire'] . "/" . ${$theme_tableau}[$_REQUEST['blocT']]['deco_icone_bas'] ."', 
'../graph/" . ${$theme_tableau}['theme_repertoire'] . "/" . ${$theme_tableau}[$_REQUEST['blocT']]['deco_icone_haut'] ."', 
1, 30, 0.25, ".$tab_infos['doc_height']." );";

$pv['onglet'] = 1;
$lt = 1;
$ADC['onglet'][$pv['onglet']]['nbr_ligne'] = 2;	$ADC['onglet'][$pv['onglet']]['nbr_cellule'] = 2;	$ADC['onglet'][$pv['onglet']]['legende'] = 0;

$tl_['fra']['C4_titre'] = "Se connecter &agrave; la BDD pour installer";
$tl_['eng']['C4_titre'] = "Connection to the DB for installing";


$tl_['fra']['C4_intro'] = "Pour installer le moteur, il faut un acc&egrave;s &agrave; la base de donn&eacute;es associ&eacute;e au serveur web. Il faut un compte ayant suffisamment de privil&egrave;ges sur la base pour pouvoir cr&eacute;er des bases (ou sch&eacute;mas) et des tables. Les identifiants que vous fournirez ne seront pas r&eacute;utilis&eacute;s. L'installateur cr&eacute;era un utilisateur d&eacute;di&eacute;e pour fonctionner (tableau suivant). Veuillez renseigner les champs du tableau ci-dessous.<br>\r<br>\r";
$tl_['eng']['C4_intro'] = "An access to the database associated with the webserver is required for intalling the engine. The user should have enough privilèges to be able to create databases and tables. The logins and password you will provide will not be reused. The installer will create its own user to make the engine function (next form). Please fill the form below.<br>\r<br>\r";

echo ("
<div id='titre_cadre_".$pv['cadre_numero']."' class='" . $theme_tableau.$_REQUEST['bloc']."_tb5 ".$theme_tableau.$_REQUEST['bloc']."_fcta' style='width: ".$tab_infos['doc_width']."px; vertical-align: middle;' >\r
<img id='titre_cadre_".$pv['cadre_numero']."_img' src='../graph/" . ${$theme_tableau}['theme_repertoire'] . "/" . ${$theme_tableau}[$_REQUEST['blocT']]['deco_icone_haut'] . "' width='32' height='32' border='0' style='vertical-align: middle;' onclick=\"animation_document_div_accordeon( 'Contenu_cadre_".$pv['cadre_numero']."' );\">\r
".$tl_[$l]['C4_titre']."
</div>\r
<br>\r
<div class='".$theme_tableau.$_REQUEST['bloc']."_t3' id='Contenu_cadre_".$pv['cadre_numero']."' style='text-align: justify; width: ".$tab_infos['doc_width']."px; height: ".$tab_infos['doc_height']."px; overflow: hidden;'>\r
" . $tl_[$l]['C4_intro']);


$ADC['onglet'][$pv['onglet']]['nbr_ligne'] = 0;	$ADC['onglet'][$pv['onglet']]['nbr_cellule'] = 4;	$ADC['onglet'][$pv['onglet']]['legende'] = 1;
$lt = 1;

$tl_['eng']['o2l'.$lt.'c1'] = "Element";		$tl_['fra']['o2l'.$lt.'c1'] = "Element";
$tl_['eng']['o2l'.$lt.'c2'] = "Prefix ";		$tl_['fra']['o2l'.$lt.'c2'] = "Pr&eacute;fixe ";
$tl_['eng']['o2l'.$lt.'c3'] = "Field";			$tl_['fra']['o2l'.$lt.'c3'] = "Champ";
$tl_['eng']['o2l'.$lt.'c4'] = "Information";	$tl_['fra']['o2l'.$lt.'c4'] = "Information";
$AD[$pv['onglet']][$lt]['1']['cont'] = $tl_[$l]['o2l'.$lt.'c1'];	$AD[$pv['onglet']][$lt]['1']['tc'] = 4;	$AD[$pv['onglet']][$lt]['1']['sc'] = 1;
$AD[$pv['onglet']][$lt]['2']['cont'] = $tl_[$l]['o2l'.$lt.'c2'];	$AD[$pv['onglet']][$lt]['2']['tc'] = 4;	$AD[$pv['onglet']][$lt]['2']['sc'] = 1;
$AD[$pv['onglet']][$lt]['3']['cont'] = $tl_[$l]['o2l'.$lt.'c3'];	$AD[$pv['onglet']][$lt]['3']['tc'] = 4;	$AD[$pv['onglet']][$lt]['3']['sc'] = 1;
$AD[$pv['onglet']][$lt]['4']['cont'] = $tl_[$l]['o2l'.$lt.'c4'];	$AD[$pv['onglet']][$lt]['4']['tc'] = 4;	$AD[$pv['onglet']][$lt]['4']['sc'] = 1;
$lt++;



$tl_['eng']['o2l'.$lt.'c1'] = "Abstraction Layer";				$tl_['fra']['o2l'.$lt.'c1'] = "Couche d'abstraction";
$tl_['eng']['o2l'.$lt.'c2'] = "";								$tl_['fra']['o2l'.$lt.'c2']= "";

$tl_['eng']['msdal_msqli'] = "PHP MysqlI (default)";			$tl_['fra']['msdal_msqli']= "PHP MysqlI (Par d&eacute;faut)";
$tl_['eng']['msdal_phppdo'] = "PHP PDO";						$tl_['fra']['msdal_phppdo']= "PHP PDO";
$tl_['eng']['msdal_adodb'] = "ADOdb (check webhosting plan)";	$tl_['fra']['msdal_adodb']= "ADOdb (v&eacute;rifiez votre h&eacute;bergeur)";
$tl_['eng']['msdal_pear'] = "PEAR DB (deprecated)";				$tl_['fra']['msdal_pear']= "PEAR DB (d&eacute;pr&eacute;ci&eacute;)";


unset ($tab_);
$tab_[$db_['dal']] = " selected ";
$tl_['eng']['o2l'.$lt.'c4']	= "Choose the DAL support you wish (Warning PEAR DB is deprecated). AdoDB is experimental at the moment.";			$tl_['fra']['o2l'.$lt.'c4']	= "Choisissez le support CABDD que vous d&eacute;sirez (attention PEARDB est d&eacute;pr&eacute;ci&eacute;). Le support AdoDB est experimental pour le moment.";
$AD[$pv['onglet']][$lt]['1']['cont'] = $tl_[$l]['o2l'.$lt.'c1'];
$AD[$pv['onglet']][$lt]['2']['cont'] = $tl_[$l]['o2l'.$lt.'c2'];
$AD[$pv['onglet']][$lt]['3']['cont'] = "<select id='form[database_dal_choix]' name='form[database_dal_choix]'  class='" . $theme_tableau .$_REQUEST['bloc']."_form_1' onChange=\"MenuSelectForgeron ( 'form[database_dal_choix]' , 'form[database_type_choix]' , CompatiliteDBvsDAL[this.value] );\";>\r";

if ( $Support['PHP']['PHP_mysqli_builtin']['etat'] == 1 )	{ $AD[$pv['onglet']][$lt]['3']['cont'] .= "<option value='MYSQLI'	".$tab_['MYSQLI'].">".$tl_[$l]['msdal_msqli']."</option>\r"; }
if ( $Support['DAL']['ADOdb']['etat'] == 1 )				{ $AD[$pv['onglet']][$lt]['3']['cont'] .= "<option value='ADODB'	".$tab_['ADODB'].">".$tl_[$l]['msdal_adodb']."</option>\r"; }
if ( $Support['DAL']['PDO']['etat'] == 1 )					{ $AD[$pv['onglet']][$lt]['3']['cont'] .= "<option value='PHPPDO'	".$tab_['PDO'].">".$tl_[$l]['msdal_phppdo']."</option>\r"; }
if ( $Support['DAL']['pear']['etat'] == 1 )					{ $AD[$pv['onglet']][$lt]['3']['cont'] .= "<option value='PEARDB'	".$tab_['PEARDB'].">".$tl_[$l]['msdal_pear']."</option>\r"; }

$AD[$pv['onglet']][$lt]['3']['cont'] .= "</select>\r";
$AD[$pv['onglet']][$lt]['4']['cont'] = $tl_[$l]['o2l'.$lt.'c4'];
$AD[$pv['onglet']][$lt]['4']['tc'] = 1;
$lt++;

// Selection Type de BDD
$tl_['eng']['o2l'.$lt.'c1'] = "Type";			$tl_['fra']['o2l'.$lt.'c1'] = "Type";
$tl_['eng']['o2l'.$lt.'c2'] = "";				$tl_['fra']['o2l'.$lt.'c2']= "";
unset ($tab_);
$tab_[$db_['type']] = " selected ";
$tl_['eng']['o2l'.$lt.'c4']	= "The DB support is provided by selected module.";			$tl_['fra']['o2l'.$lt.'c4']	= "Le support base de donn&eacute;es est assur&eacute; par le module s&eacute;lectionn&eacute;.";
$AD[$pv['onglet']][$lt]['1']['cont'] = $tl_[$l]['o2l'.$lt.'c1'];
$AD[$pv['onglet']][$lt]['2']['cont'] = $tl_[$l]['o2l'.$lt.'c2'];
$AD[$pv['onglet']][$lt]['3']['cont'] = "<select id='form[database_type_choix]' name='form[database_type_choix]'  class='" . $theme_tableau .$_REQUEST['bloc']."_form_1'>\r
<option value='mysql'	".$tab_['mysql'].">MySQL 3.x/4.x/5.x</option>\r
</select>\r
";
$AD[$pv['onglet']][$lt]['4']['cont'] = $tl_[$l]['o2l'.$lt.'c4'];
$AD[$pv['onglet']][$lt]['4']['tc'] = 1;
$lt++;

// Profil d'hébergement


$tl_['fra']['o2l'.$lt.'c4AD'] = "Si ce script est lanc&eacute; depuis votre serveur sur un h&eacute;bergement tiers, vous avez probablement des restrictions pour la cr&eacute;ation des bases. Habituellement vous devez le faire dans une interface du genre de Cpanel. Dans ce cas s&eacute;lectionnez \'h&eacute;bergement\'. Le script ne d&eacute;truira pas la base que vous nommez mais ne fera que la vider de ces tables.<br><br>L\'autre cas &eacute;tant un serveur ou vous pouvez absolument tout faire. Vous pouvez s&eacute;lectionnez le profil \'Droit absolu\'.";
$tl_['eng']['o2l'.$lt.'c4AD'] = "If you run this script on your website in a hosting plan, you probably have restriction about creating databases. Usually you have to do it in a Cpanel/PHPMyadmin interface. You should select \'hosting plan\' in that case. The script will not remove the database you name. Only empty it.<br><br>The other case is a server where you can do absolutly everything. Select \'absolute power\'.";

$tl_['eng']['o2l'.$lt.'c1'] = "Hosting profile";	$tl_['fra']['o2l'.$lt.'c1'] = "Profil d'h&eacute;bergement";
$tl_['eng']['o2l'.$lt.'c2'] = "";					$tl_['fra']['o2l'.$lt.'c2']= "";
$tl_['eng']['o2l'.$lt.'c4']	= "Choose the hosting profile where the engine should be installed.
<a href='' onMouseOver=\"Bulle('".$tl_[$l]['o2l'.$lt.'c4AD']."')\" onMouseOut=\"Bulle()\">
<img src='../graph/" . ${$theme_tableau}['theme_repertoire'] . "/" . ${$theme_tableau}[$_REQUEST['blocT']]['deco_icone_question'] . "' width='16' height='16' border='0'>
</a>
";
$tl_['fra']['o2l'.$lt.'c4']	= "Choisissez le profil d'h&eacute;bergement ou le moteur devra &ecirc;tre install&eacute;.
<a href='' onMouseOver=\"Bulle('".$tl_[$l]['o2l'.$lt.'c4AD']."')\" onMouseOut=\"Bulle()\">
<img src='../graph/" . ${$theme_tableau}['theme_repertoire'] . "/" . ${$theme_tableau}[$_REQUEST['blocT']]['deco_icone_question'] . "' width='16' height='16' border='0'>
</a>
";
$AD[$pv['onglet']][$lt]['1']['cont'] = $tl_[$l]['o2l'.$lt.'c1'];
$AD[$pv['onglet']][$lt]['2']['cont'] = $tl_[$l]['o2l'.$lt.'c2'];

$tl_['eng']['dbp_hosted'] = "Hosting plan";		$tl_['fra']['dbp_hosted'] = "H&eacute;bergement";
$tl_['eng']['dbp_asolute'] = "Absolute power";	$tl_['fra']['dbp_asolute'] = "Droit absolu";

$AD[$pv['onglet']][$lt]['3']['cont'] = "<select name='form[database_profil]' class='" . $theme_tableau .$_REQUEST['bloc']."_form_1'>\r
<option value='absolute'>".$tl_[$l]['dbp_asolute']."</option>\r
<option value='hostplan'>".$tl_[$l]['dbp_hosted']."</option>\r
</select>\r
";
$AD[$pv['onglet']][$lt]['4']['cont'] = $tl_[$l]['o2l'.$lt.'c4'];
$AD[$pv['onglet']][$lt]['4']['tc'] = 1;
$lt++;

// Serveur de la BDD
$tl_['eng']['o2l'.$lt.'c1'] = "Database server";	$tl_['fra']['o2l'.$lt.'c1'] = "Serveur de base de donn&eacute;es";
$tl_['eng']['o2l'.$lt.'c2'] = "";					$tl_['fra']['o2l'.$lt.'c2'] = "";
$tl_['eng']['o2l'.$lt.'c3'] = "";					$tl_['fra']['o2l'.$lt.'c3'] = "";
$tl_['eng']['o2l'.$lt.'c4'] = "This is the server where the database is. Most of the time 'localhost' (literaly) is the only necessary information. Otherwise check with the webhosting provider.";
$tl_['fra']['o2l'.$lt.'c4'] = "C'est le serveur de base de donn&eacute;es. Habituellement, 'localhost' (litt&eacute;ralement) est la seule information n&eacute;cessaire. Sinon, v&eacute;rifiez les informations avec l'h&eacute;bergeur.";
$AD[$pv['onglet']][$lt]['1']['cont'] = $tl_[$l]['o2l'.$lt.'c1'];
$AD[$pv['onglet']][$lt]['2']['cont'] = $tl_[$l]['o2l'.$lt.'c2'];
$AD[$pv['onglet']][$lt]['3']['cont'] = "<input type='text' name='form[database_host]' size='20' maxlength='255' value='".$db_['host']."'  class='" . $theme_tableau .$_REQUEST['bloc']."_form_1'>";;
$AD[$pv['onglet']][$lt]['4']['cont'] = $tl_[$l]['o2l'.$lt.'c4'];
$AD[$pv['onglet']][$lt]['4']['tc'] = 1;
$lt++;

// Préfixe
$tl_['eng']['o2l'.$lt.'c1']	= "Prefix";							$tl_['fra']['o2l'.$lt.'c1']	= "Pr&eacute;fixe";
$tl_['eng']['o2l'.$lt.'c2']	= "";								$tl_['fra']['o2l'.$lt.'c2']	= "";
$tl_['eng']['o2l'.$lt.'c3']	= "";								$tl_['fra']['o2l'.$lt.'c3']	= "";
$tl_['eng']['o2l'.$lt.'c4']	= "Sometimes a prefix is needed. Usueally it's your account login provided by your webhosting provider. Ex : myaccount_ + DBuser. Enter the prefix in this filed only.";
$tl_['fra']['o2l'.$lt.'c4']	= "Parfois un pr&eacute;fixe est requis. Habituellement c'est le nom de votre compte pourvu par votre h&eacute;bergeur. Ex MonCompte_ + utilisateurDB. Entrez uniquement le pr&eacute;fixe dans ce champ.";
$AD[$pv['onglet']][$lt]['1']['cont'] = $tl_[$l]['o2l'.$lt.'c1'];
$AD[$pv['onglet']][$lt]['2']['cont'] = "<input type='text' name='form[db_hosting_prefix]' size='10' maxlength='255' value='".$db_['db_hosting_prefix']."' OnKeyup=\"InsereValeur ( this.value , '".$pv['Formulaire_nom']."', ['form[db_hosting_prefix_copie_1]', 'form[db_hosting_prefix_copie_2]', 'form[db_hosting_prefix_copie_3]' ] );\"  class='" . $theme_tableau .$_REQUEST['bloc']."_form_1'>";
$AD[$pv['onglet']][$lt]['3']['cont'] = "";
$AD[$pv['onglet']][$lt]['4']['cont'] = $tl_[$l]['o2l'.$lt.'c4'];
$AD[$pv['onglet']][$lt]['4']['tc'] = 1;
$lt++;


// Nom de la BDD
$tl_['eng']['o2l'.$lt.'c1']	= "Database name";					$tl_['fra']['o2l'.$lt.'c1']	= "Nom de la base de donn&eacute;es";
$tl_['eng']['o2l'.$lt.'c2']	= "";								$tl_['fra']['o2l'.$lt.'c2']	= "";
$tl_['eng']['o2l'.$lt.'c3']	= "";								$tl_['fra']['o2l'.$lt.'c3']	= "";
$tl_['eng']['o2l'.$lt.'c4']	= "This is the name for the database on the server.";
$tl_['fra']['o2l'.$lt.'c4']	= "C'est le nom de la base de donn&eacute;es sur votre serveur.";
$AD[$pv['onglet']][$lt]['1']['cont'] = $tl_[$l]['o2l'.$lt.'c1'];
$AD[$pv['onglet']][$lt]['2']['cont'] = "<input type='text' readonly disable name='form[db_hosting_prefix_copie_1]' size='10' maxlength='255' value=''  class='" . $theme_tableau .$_REQUEST['bloc']."_form_1'>";
$AD[$pv['onglet']][$lt]['3']['cont'] = "<input type='text' name='form[dbprefix]' size='20' maxlength='32' value='".$db_['dbprefix']."'  class='" . $theme_tableau .$_REQUEST['bloc']."_form_1'>";
$AD[$pv['onglet']][$lt]['4']['cont'] = $tl_[$l]['o2l'.$lt.'c4'];
$AD[$pv['onglet']][$lt]['4']['tc'] = 1;
$lt++;

// Login
$tl_['eng']['o2l'.$lt.'c1']	= "Admin login";					$tl_['fra']['o2l'.$lt.'c1']	= "Identifiant admin";
$tl_['eng']['o2l'.$lt.'c2']	= "";								$tl_['fra']['o2l'.$lt.'c2']	= "";
$tl_['eng']['o2l'.$lt.'c3']	= "";								$tl_['fra']['o2l'.$lt.'c3']	= "";
$tl_['eng']['o2l'.$lt.'c4']	= "Enter a login that has enough privileges to create databases and tables and users on the DB server. ";
$tl_['fra']['o2l'.$lt.'c4']	= "Entrez un nom d'utilisateur qui a les droits suffisants pour cr&eacute;er des bases, des tables et des utilisateurs sur le serveur de BDD. ";
$AD[$pv['onglet']][$lt]['1']['cont'] = $tl_[$l]['o2l'.$lt.'c1'];
$AD[$pv['onglet']][$lt]['2']['cont'] = "<input type='text' readonly disable name='form[db_hosting_prefix_copie_2]' size='10' maxlength='255' value=''  class='" . $theme_tableau .$_REQUEST['bloc']."_form_1'>";
$AD[$pv['onglet']][$lt]['3']['cont'] = "<input type='text' name='form[db_admin_user]' size='20' maxlength='32' value='".$db_['admin_user']."'  class='" . $theme_tableau .$_REQUEST['bloc']."_form_1'>";
$AD[$pv['onglet']][$lt]['4']['cont'] = $tl_[$l]['o2l'.$lt.'c4'];
$AD[$pv['onglet']][$lt]['4']['tc'] = 1;
$lt++;


$tl_['eng']['o2l'.$lt.'c1']	= "Password";						$tl_['fra']['o2l'.$lt.'c1']	= "Mot de passe";
$tl_['eng']['o2l'.$lt.'c2']	= "";								$tl_['fra']['o2l'.$lt.'c2']	= "";
$tl_['eng']['o2l'.$lt.'c3']	= "";								$tl_['fra']['o2l'.$lt.'c3']	= "";
$tl_['eng']['o2l'.$lt.'c4']	= "";								$tl_['fra']['o2l'.$lt.'c4']	= "";
$AD[$pv['onglet']][$lt]['1']['cont'] = $tl_[$l]['o2l'.$lt.'c1'];
$AD[$pv['onglet']][$lt]['2']['cont'] = $tl_[$l]['o2l'.$lt.'c2'];
$AD[$pv['onglet']][$lt]['3']['cont'] = "<input type='password' name='form[db_admin_password]' size='20' maxlength='32' value='".$db_['admin_password']."'  class='" . $theme_tableau .$_REQUEST['bloc']."_form_1'>";
$AD[$pv['onglet']][$lt]['4']['cont'] = $tl_[$l]['o2l'.$lt.'c4'];
$lt++;


$_REQUEST['BS']['id']				= "bouton_install_testdb";
$_REQUEST['BS']['type']				= "button";
$_REQUEST['BS']['style_initial']	= $theme_tableau.$_REQUEST['bloc']."_tb3 ".$theme_tableau.$_REQUEST['bloc']."_submit_s1_n";
$_REQUEST['BS']['style_hover']		= $theme_tableau.$_REQUEST['bloc']."_tb3 ".$theme_tableau.$_REQUEST['bloc']."_submit_s1_h";
//".$pv['Formulaire_nom']."
$_REQUEST['BS']['onclick']			= "
affichage_TstBDD ( 'TstBDD_1_' , 0 ) ;
affichage_TstBDD ( 'TstBDD_2_' , 0 ) ;
test_cnx_db();
var tmp_cnx_chaine = document.forms['".$pv['Formulaire_nom']."'].elements['form[db_hosting_prefix]'].value + document.forms['".$pv['Formulaire_nom']."'].elements['form[db_admin_user]'].value + '@' + document.forms['".$pv['Formulaire_nom']."'].elements['form[database_host]'].value  + ', Database: ' + document.forms['".$pv['Formulaire_nom']."'].elements['form[db_hosting_prefix]'].value + document.forms['".$pv['Formulaire_nom']."'].elements['form[dbprefix]'].value ; 
InsereValeur ( tmp_cnx_chaine , '".$pv['Formulaire_nom']."', [ 'form[chaine_connexion_test]']  ) ; 
";

//	$_REQUEST['BS']['onclick']			= "test_cnx_db()";
$_REQUEST['BS']['message']			= "Test DB";
$_REQUEST['BS']['mode']				= 1;
$_REQUEST['BS']['taille'] 			= 128;
$tl_['eng']['o2l'.$lt.'c1']	= "Test the database connexion";			$tl_['fra']['o2l'.$lt.'c1']	= "Tester la connexion &agrave; la base de donn&eacute;e.";
$tl_['eng']['o2l'.$lt.'c2']	= "";										$tl_['fra']['o2l'.$lt.'c2']	= "";
$tl_['eng']['o2l'.$lt.'c3']	= generation_bouton ();						$tl_['fra']['o2l'.$lt.'c3']	= &$tl_['eng']['o2l'.$lt.'c3'];

$pv['div_cnx_db'] = "
	<input type='text' readonly disable name='form[chaine_connexion_test]' size='40' maxlength='255' value=''  class='" . $theme_tableau .$_REQUEST['bloc']."_form_1'><br>\r";

$tl_['eng']['o2l'.$lt.'c4']	= $pv['div_cnx_db'] . "	
	<div id='TstBDD_1_ok' style='visibilty: hidden; display : none; position; realtive;'><img src='../graph/" . ${$theme_tableau}['theme_repertoire'] . "/" . ${$theme_tableau}[$_REQUEST['blocT']]['deco_icone_ok'] . "' width='16' height='16' border='0'>The database connection suceeded.</div>
	<div id='TstBDD_1_ko' style='visibilty: hidden; display : none; position; realtive;'><img src='../graph/" . ${$theme_tableau}['theme_repertoire'] . "/" . ${$theme_tableau}[$_REQUEST['blocT']]['deco_icone_nok'] . "' width='16' height='16' border='0'>The database connection failed.</div>
	<div id='TstBDD_2_ok' style='visibilty: hidden; display : none; position; realtive;'><img src='../graph/" . ${$theme_tableau}['theme_repertoire'] . "/" . ${$theme_tableau}[$_REQUEST['blocT']]['deco_icone_ok'] . "' width='16' height='16' border='0'>A MWM database has been found.</div>
	<div id='TstBDD_2_ko' style='visibilty: hidden; display : none; position; realtive;'><img src='../graph/" . ${$theme_tableau}['theme_repertoire'] . "/" . ${$theme_tableau}[$_REQUEST['blocT']]['deco_icone_nok'] . "' width='16' height='16' border='0'>MWM database not found.</div>
	";
$tl_['fra']['o2l'.$lt.'c4']	= $pv['div_cnx_db'] . "
	<div id='TstBDD_1_ok' style='visibilty: hidden; display : none; position; realtive;'><img src='../graph/" . ${$theme_tableau}['theme_repertoire'] . "/" . ${$theme_tableau}[$_REQUEST['blocT']]['deco_icone_ok'] . "' width='16' height='16' border='0'>La connexion &agrave; la base a r&eacute;ussi.</div>
	<div id='TstBDD_1_ko' style='visibilty: hidden; display : none; position; realtive;'><img src='../graph/" . ${$theme_tableau}['theme_repertoire'] . "/" . ${$theme_tableau}[$_REQUEST['blocT']]['deco_icone_nok'] . "' width='16' height='16' border='0'>La connexion &agrave; la base a &eacute;chou&eacute;.</div>
	<div id='TstBDD_2_ok' style='visibilty: hidden; display : none; position; realtive;'><img src='../graph/" . ${$theme_tableau}['theme_repertoire'] . "/" . ${$theme_tableau}[$_REQUEST['blocT']]['deco_icone_ok'] . "' width='16' height='16' border='0'>Une BDD MWM est d&eacute;j&agrave; pr&eacute;sente.</div>
	<div id='TstBDD_2_ko' style='visibilty: hidden; display : none; position; realtive;'><img src='../graph/" . ${$theme_tableau}['theme_repertoire'] . "/" . ${$theme_tableau}[$_REQUEST['blocT']]['deco_icone_nok'] . "' width='16' height='16' border='0'>BDD non trouv&eacute;e.</div>
	";
$AD[$pv['onglet']][$lt]['1']['cont'] = $tl_[$l]['o2l'.$lt.'c1'];	$AD[$pv['onglet']][$lt]['1']['tc'] = 2;
$AD[$pv['onglet']][$lt]['2']['cont'] = $tl_[$l]['o2l'.$lt.'c2'];	$AD[$pv['onglet']][$lt]['2']['tc'] = 2;
$AD[$pv['onglet']][$lt]['3']['cont'] = $tl_[$l]['o2l'.$lt.'c3'];	$AD[$pv['onglet']][$lt]['3']['tc'] = 2;
$AD[$pv['onglet']][$lt]['4']['cont'] = $tl_[$l]['o2l'.$lt.'c4'];	$AD[$pv['onglet']][$lt]['4']['tc'] = 2;

$ADC['onglet'][$pv['onglet']]['nbr_ligne'] = $lt;

include ("routines/website/affichage_donnees.php");

echo ("</div>\r");

$pv['cadre_numero']++;

$pv['URI'] = $_SERVER['REQUEST_URI'];
$pv['URI_coupe'] = strpos( $_SERVER['REQUEST_URI'] , "/mwm/version_actuelle/install/install_page_01.php" );
$pv['URI'] = substr ( $_SERVER['REQUEST_URI'] , 0 , $pv['URI_coupe'] );

$JavaScriptInitDonnees[] = "var RequestURI = \"". $pv['URI'] . "\"";
$JavaScriptInitDonnees[] = "var FormulaireNom = \"".$pv['Formulaire_nom']."\"";



// --------------------------------------------------------------------------------------------
//
//	Cadre 05
//
// --------------------------------------------------------------------------------------------
$tab_infos['AffOnglet']			= 0;
$tab_infos['NbrOnglet']			= 1;
$tab_infos['NbrOnglet']			+= $_REQUEST['debug_option']['onglet_install_debug'];
$tab_infos['tab_comportement']	= 1;
$tab_infos['mode_rendu']		= 0;
$tab_infos['TypSurbrillance']	= 0; // 1:ligne, 2:cellule
$tab_infos['doc_height']		= 380;
$tab_infos['doc_width']			= ${$theme_tableau}['theme_module_largeur_interne'] -24 ;
$tab_infos['groupe']			= "inst1";
$tab_infos['cell_id']			= "cadre03";
$tab_infos['document']			= "doc";

$JavaScriptInitCommandes[] = "ADDA_div_init ( 'Contenu_cadre_".$pv['cadre_numero']."' , 'titre_cadre_".$pv['cadre_numero']."_img', 
'../graph/" . ${$theme_tableau}['theme_repertoire'] . "/" . ${$theme_tableau}[$_REQUEST['blocT']]['deco_icone_bas'] ."', 
'../graph/" . ${$theme_tableau}['theme_repertoire'] . "/" . ${$theme_tableau}[$_REQUEST['blocT']]['deco_icone_haut'] ."', 
1, 30 , 0.25, ".$tab_infos['doc_height']." );";

$pv['onglet'] = 1;
$lt = 1;
$ADC['onglet'][$pv['onglet']]['nbr_ligne'] = 0;	$ADC['onglet'][$pv['onglet']]['nbr_cellule'] = 4;	$ADC['onglet'][$pv['onglet']]['legende'] = 1;

$tl_['fra']['C5_titre'] = "Personalisation DB";
$tl_['eng']['C5_titre'] = "DB personalization";

echo ("
<div id='titre_cadre_".$pv['cadre_numero']."' class='" . $theme_tableau.$_REQUEST['bloc']."_tb5 ".$theme_tableau.$_REQUEST['bloc']."_fcta' style='width: ".$tab_infos['doc_width']."px; vertical-align: middle;' >\r
<img id='titre_cadre_".$pv['cadre_numero']."_img' src='../graph/" . ${$theme_tableau}['theme_repertoire'] . "/" . ${$theme_tableau}[$_REQUEST['blocT']]['deco_icone_haut'] . "' width='32' height='32' border='0' style='vertical-align: middle;' onclick=\"animation_document_div_accordeon( 'Contenu_cadre_".$pv['cadre_numero']."' );\">\r
".$tl_[$l]['C5_titre']."
</div>\r
<br>\r
<div id='Contenu_cadre_".$pv['cadre_numero']."' style='text-align: justify; width: ".$tab_infos['doc_width']."px; height: ".$tab_infos['doc_height']."px; overflow: hidden;'>\r
");

$tl_['eng']['o2l'.$lt.'c1'] = "Element";		$tl_['fra']['o2l'.$lt.'c1'] = "Element";
$tl_['eng']['o2l'.$lt.'c2'] = "Prefix ";		$tl_['fra']['o2l'.$lt.'c2'] = "Pr&eacute;fixe ";
$tl_['eng']['o2l'.$lt.'c3'] = "Field";			$tl_['fra']['o2l'.$lt.'c3'] = "Champ";
$tl_['eng']['o2l'.$lt.'c4'] = "Information";	$tl_['fra']['o2l'.$lt.'c4'] = "Information";
$AD[$pv['onglet']][$lt]['1']['cont'] = $tl_[$l]['o2l'.$lt.'c1'];	$AD[$pv['onglet']][$lt]['1']['tc'] = 4;	$AD[$pv['onglet']][$lt]['1']['sc'] = 1;
$AD[$pv['onglet']][$lt]['2']['cont'] = $tl_[$l]['o2l'.$lt.'c2'];	$AD[$pv['onglet']][$lt]['2']['tc'] = 4;	$AD[$pv['onglet']][$lt]['2']['sc'] = 1;
$AD[$pv['onglet']][$lt]['3']['cont'] = $tl_[$l]['o2l'.$lt.'c3'];	$AD[$pv['onglet']][$lt]['3']['tc'] = 4;	$AD[$pv['onglet']][$lt]['3']['sc'] = 1;
$AD[$pv['onglet']][$lt]['4']['cont'] = $tl_[$l]['o2l'.$lt.'c4'];	$AD[$pv['onglet']][$lt]['4']['tc'] = 4;	$AD[$pv['onglet']][$lt]['4']['sc'] = 1;
$lt++;

$tl_['eng']['o2l'.$lt.'c1']	= "Table Prefix";					$tl_['fra']['o2l'.$lt.'c1']	= "Pr&eacute;fixes des tables";
$tl_['eng']['o2l'.$lt.'c2']	= "";								$tl_['fra']['o2l'.$lt.'c2']	= "";
$tl_['eng']['o2l'.$lt.'c3']	= "";								$tl_['fra']['o2l'.$lt.'c3']	= "";
$tl_['eng']['o2l'.$lt.'c4']	= "Each table will have this prefix. Depending on database it can be usefull.";
$tl_['fra']['o2l'.$lt.'c4']	= "Chaque table aura ce pr&eacute;fixe. Suivant la base de donn&eacute;es cela peut s'av&eacute;rer utile.";
$AD[$pv['onglet']][$lt]['1']['cont'] = $tl_[$l]['o2l'.$lt.'c1'];
$AD[$pv['onglet']][$lt]['2']['cont'] = "<input type='text' name='form[prefix_des_tables]' size='10' maxlength='32' value='".$db_['tabprefix']."' OnKeyup=\"InsereValeur ( 'Ex: ' + this.value + 'article_config' , '".$pv['Formulaire_nom']."', ['form[db_hosting_tabprefix_copie_1]'] );\"  class='" . $theme_tableau .$_REQUEST['bloc']."_form_1'>";
$AD[$pv['onglet']][$lt]['3']['cont'] = "<input type='text' readonly disable name='form[db_hosting_tabprefix_copie_1]' size='20' maxlength='255' value=''  class='" . $theme_tableau .$_REQUEST['bloc']."_form_1'>";
$AD[$pv['onglet']][$lt]['4']['cont'] = $tl_[$l]['o2l'.$lt.'c4'];
$AD[$pv['onglet']][$lt]['4']['tc'] = 1;
$JavaScriptInitCommandes[] = "InsereValeur ( 'Ex: ".$db_['tabprefix']."article_config' , '".$pv['Formulaire_nom']."', ['form[db_hosting_tabprefix_copie_1]' , 'form[db_hosting_tabprefix_copie_1]' ] );";

$lt++;


$tl_['eng']['o2l'.$lt.'c1']	= "User name of the database user (your scripts)";	$tl_['fra']['o2l'.$lt.'c1']	= "Nom de l'utilisateur de la base (vos scripts)";
$tl_['eng']['o2l'.$lt.'c2']	= "";												$tl_['fra']['o2l'.$lt.'c2']	= "";
$tl_['eng']['o2l'.$lt.'c3']	= "";												$tl_['fra']['o2l'.$lt.'c3']	= "";
$tl_['eng']['o2l'.$lt.'c4']	= "This is the virtual user. The script will use this to connect the database. Make sure it is diff&eacute;rent from the server owner. Depending on webhosting provider you have to declare the DB and the user before installing.";
$tl_['fra']['o2l'.$lt.'c4']	= "C'est l'utilisateur virtuel. Le script l'utilisera pour se connecter a la base de donn&eacute;es. Faites en sorte que ce nom soit diff&eacute;rent du propri&eacute;taire du serveur. Suivant l'h&eacute;bergeur vous aurez a d&eacute;clarer la base et l'utilisateur avant d'installer.";
$AD[$pv['onglet']][$lt]['1']['cont'] = $tl_[$l]['o2l'.$lt.'c1'];
$AD[$pv['onglet']][$lt]['2']['cont'] = "<input type='text' readonly disable name='form[db_hosting_prefix_copie_3]' size='10' maxlength='255' value=''  class='" . $theme_tableau .$_REQUEST['bloc']."_form_1'>";
$AD[$pv['onglet']][$lt]['3']['cont'] = "<input type='text' name='form[database_user_login]' size='20' maxlength='32' value='".$db_['user_login']."'  class='" . $theme_tableau .$_REQUEST['bloc']."_form_1'>";
$AD[$pv['onglet']][$lt]['4']['cont'] = $tl_[$l]['o2l'.$lt.'c4'];
$AD[$pv['onglet']][$lt]['4']['tc'] = 1;
$lt++;


$tl_['eng']['boutonpass']		= "Generate";						$tl_['fra']['boutonpass']	= "G&eacute;n&eacute;rer";
$_REQUEST['BS']['id']				= "bouton_install_radompass";
$_REQUEST['BS']['type']				= "button";
$_REQUEST['BS']['style_initial']	= $theme_tableau.$_REQUEST['bloc']."_tb3 ".$theme_tableau.$_REQUEST['bloc']."_submit_s1_n";
$_REQUEST['BS']['style_hover']		= $theme_tableau.$_REQUEST['bloc']."_tb3 ".$theme_tableau.$_REQUEST['bloc']."_submit_s1_h";
$_REQUEST['BS']['onclick']			= "modifie_INPUT ( '".$pv['Formulaire_nom']."' , 'form[database_user_password]' , GenereMDPAleatoire( 20 ) );";
$_REQUEST['BS']['message']			= $tl_[$l]['boutonpass'];
$_REQUEST['BS']['mode']				= 1;
$_REQUEST['BS']['taille'] 			= 128;
$tl_['eng']['o2l'.$lt.'c1']	= "Password";						$tl_['fra']['o2l'.$lt.'c1']	= "Mot de passe";
$tl_['eng']['o2l'.$lt.'c2']	= "";								$tl_['fra']['o2l'.$lt.'c2']	= "";
$tl_['eng']['o2l'.$lt.'c3']	= "";								$tl_['fra']['o2l'.$lt.'c3']	= "";
$tl_['eng']['o2l'.$lt.'c4']	= "If the user already exists for that database, do not generate a password. Use the one associated with that user.";
$tl_['fra']['o2l'.$lt.'c4']	= "Si l'utilisateur existe d&eacute;j&agrave; pour cette base de donn&eacute;es, ne g&eacute;n&eacute;rez pas de mot de passe. Utilisez le mot de passe associ&eacute; &agrave; cet utilisateur.";

$AD[$pv['onglet']][$lt]['1']['cont'] = $tl_[$l]['o2l'.$lt.'c1'];
$AD[$pv['onglet']][$lt]['2']['cont'] = $tl_[$l]['o2l'.$lt.'c2'];
$AD[$pv['onglet']][$lt]['3']['cont'] = "<input type='password' id='form[database_user_password]' name='form[database_user_password]' size='20' maxlength='32' value='".$db_['user_password']."'  class='" . $theme_tableau .$_REQUEST['bloc']."_form_1'>";
$AD[$pv['onglet']][$lt]['4']['cont'] = $tl_[$l]['o2l'.$lt.'c4'] . "<br><br>". generation_bouton ();
$AD[$pv['onglet']][$lt]['4']['tc'] = 1;
$lt++;

$tl_['eng']['o2l'.$lt.'c1']	= "Recreate this user";			$tl_['fra']['o2l'.$lt.'c1']	= "Recr&eacute;er cet utilisateur.";
$tl_['eng']['o2l'.$lt.'c2']	= "";							$tl_['fra']['o2l'.$lt.'c2']	= "";
$tl_['eng']['o2l'.$lt.'c3']	= "";							$tl_['fra']['o2l'.$lt.'c3']	= "";
$tl_['eng']['o2l'.$lt.'c4']	= "If it is possible (admin privilège) it is better to recreate the script user during installation. If 'no' is selected you should check that this user is correctly configured to use the databse.";
$tl_['fra']['o2l'.$lt.'c4']	= "Si c'est possible (privil&egrave;ges administrateur) il pr&eacute;f&eacute;rable de recr&eacute;er l'utilisateur du script durant l'installation. Si 'non' est selectionn&eacute; vous devez v&eacute;rifier que cet utilisateur est correctement configur&eacute; pour utiliser cette base.";
$AD[$pv['onglet']][$lt]['1']['cont'] = $tl_[$l]['o2l'.$lt.'c1'];
$AD[$pv['onglet']][$lt]['2']['cont'] = $tl_[$l]['o2l'.$lt.'c2'];
$tl_['eng']['dbr_o'] = "Yes";	$tl_['fra']['dbr_o'] = "Oui";
$tl_['eng']['dbr_n'] = "No";	$tl_['fra']['dbr_n'] = "Non";
$AD[$pv['onglet']][$lt]['3']['cont'] = "<select name='form[database_user_recreate]'  class='" . $theme_tableau .$_REQUEST['bloc']."_form_1'>\r
<option value='non'>".$tl_[$l]['dbr_n']."</option>\r
<option value='oui' selected >".$tl_[$l]['dbr_o']."</option>\r
</select>\r
";
$AD[$pv['onglet']][$lt]['4']['cont'] = $tl_[$l]['o2l'.$lt.'c4'];
$AD[$pv['onglet']][$lt]['4']['tc'] = 1;
$lt++;


$tl_['eng']['o2l'.$lt.'c1']	= "Generic user Password";			$tl_['fra']['o2l'.$lt.'c1']	= "Mot de passe des utilisateurs g&eacute;n&eacute;riques";
$tl_['eng']['o2l'.$lt.'c2']	= "";								$tl_['fra']['o2l'.$lt.'c2']	= "";
$tl_['eng']['o2l'.$lt.'c3']	= "";								$tl_['fra']['o2l'.$lt.'c3']	= "";
$tl_['eng']['o2l'.$lt.'c4']	= "The engine needs some user in order for you to access the admin panel of the site. This is the password for the generics user of the website.";
$tl_['fra']['o2l'.$lt.'c4']	= "Le moteur a besoin de quelques utilisateurs pour que vous puissiez acc&eacute;der aux panneaux d'aministration. C'est le mot de passe pour les utilisateurs g&eacute;n&eacute;riques.";
$AD[$pv['onglet']][$lt]['1']['cont'] = $tl_[$l]['o2l'.$lt.'c1'];
$AD[$pv['onglet']][$lt]['2']['cont'] = $tl_[$l]['o2l'.$lt.'c2'];
$AD[$pv['onglet']][$lt]['3']['cont'] = "<input type='password' name='form[standard_user_password]' size='20' maxlength='32' value='".$db_['user_password']."'  class='" . $theme_tableau .$_REQUEST['bloc']."_form_1'>";
$AD[$pv['onglet']][$lt]['4']['cont'] = $tl_[$l]['o2l'.$lt.'c4'];
$AD[$pv['onglet']][$lt]['4']['tc'] = 1;
$lt++;

$tl_['eng']['o2l'.$lt.'c1']	= "Make .htaccess";			$tl_['fra']['o2l'.$lt.'c1']	= "Cr&eacute;ation .htacces";
$tl_['eng']['o2l'.$lt.'c2']	= "";						$tl_['fra']['o2l'.$lt.'c2']	= "";
$tl_['eng']['o2l'.$lt.'c3']	= "";						$tl_['fra']['o2l'.$lt.'c3']	= "";
$tl_['eng']['o2l'.$lt.'c4']	= "The .htaccess file is a ruleset that defines access authorizations to files on the web server. It helps to protect the files that contain certain information such as password etc. The file given use classical rules. The behavior of this ruleset also depends on the webserver.";
$tl_['fra']['o2l'.$lt.'c4']	= "Le fichier .htaccess est un fichier de r&egrave;gles d&eacute;finissant les autorisations d'acc&egrave;s aux fichiers du serveur. Cela permet de prot&eacute;ger des fichiers contenant des informations senssibles. Le fichier propos&eacute; offre des r&egrave;gles classiques. Le bon fonctionnement de ces r&egrave;gles d&eacute;pend aussi du serveur.";
$AD[$pv['onglet']][$lt]['1']['cont'] = $tl_[$l]['o2l'.$lt.'c1'];
$AD[$pv['onglet']][$lt]['2']['cont'] = $tl_[$l]['o2l'.$lt.'c2'];
$AD[$pv['onglet']][$lt]['3']['cont'] = "<select name='form[creation_htaccess]'  class='" . $theme_tableau .$_REQUEST['bloc']."_form_1'>\r
<option value='non' selected>".$tl_[$l]['dbr_n']."</option>\r
<option value='oui'>".$tl_[$l]['dbr_o']."</option>\r
</select>\r
";
$AD[$pv['onglet']][$lt]['4']['cont'] = $tl_[$l]['o2l'.$lt.'c4'];
$AD[$pv['onglet']][$lt]['4']['tc'] = 1;
$lt++;


$tl_['eng']['TypeExec1']	= "Apache module";			$tl_['fra']['TypeExec1']	= "Module Apache";
$tl_['eng']['TypeExec2']	= "CLI";					$tl_['fra']['TypeExec2']	= "Lignes de commande";

$tl_['eng']['o2l'.$lt.'c1']	= "Execution type";			$tl_['fra']['o2l'.$lt.'c1']	= "Type d'ex&eacute;cution";
$tl_['eng']['o2l'.$lt.'c2']	= "";						$tl_['fra']['o2l'.$lt.'c2']	= "";
$tl_['eng']['o2l'.$lt.'c3']	= "";						$tl_['fra']['o2l'.$lt.'c3']	= "";
$tl_['eng']['o2l'.$lt.'c4']	= "You can execute the installation as Apache module or as stand alone CLI. it all depends on what you Webhosting plan authorize you to do. Default is 'as apache module'.";
$tl_['fra']['o2l'.$lt.'c4']	= "Vous pouvez ex&eacute;cuter le script suivant deux mode. Comme un module Apache ou comme un script de ligne de commande. Tout d&eacute;pend de ce que votre h&eacute;bergeur autorise. Par d&eacute;faut l'ex&eacute;cution se fait comme un 'module Apache'.";
$AD[$pv['onglet']][$lt]['1']['cont'] = $tl_[$l]['o2l'.$lt.'c1'];
$AD[$pv['onglet']][$lt]['2']['cont'] = $tl_[$l]['o2l'.$lt.'c2'];
$AD[$pv['onglet']][$lt]['3']['cont'] = "<select name='form[TypeExec]'  class='" . $theme_tableau .$_REQUEST['bloc']."_form_1'>\r
<option value='ModuleApache' selected>".$tl_[$l]['TypeExec1']."</option>\r
<option value='CLI'>".$tl_[$l]['TypeExec2']."</option>\r
</select>\r
";
$AD[$pv['onglet']][$lt]['4']['cont'] = $tl_[$l]['o2l'.$lt.'c4'];
$AD[$pv['onglet']][$lt]['4']['tc'] = 1;
//$lt++;

$ADC['onglet'][$pv['onglet']]['nbr_ligne'] = $lt;

include ("routines/website/affichage_donnees.php");

echo ("</div>\r");

$pv['cadre_numero']++;


// --------------------------------------------------------------------------------------------
//
//	Cadre 06
//
// --------------------------------------------------------------------------------------------
$tab_infos['AffOnglet']			= 0;
$tab_infos['NbrOnglet']			= 1;
$tab_infos['NbrOnglet']			+= $_REQUEST['debug_option']['onglet_install_debug'];
$tab_infos['tab_comportement']	= 0;
$tab_infos['TypSurbrillance']	= 0; // 1:ligne, 2:cellule
$tab_infos['doc_height']		= 128;
$tab_infos['doc_width']			= ${$theme_tableau}['theme_module_largeur_interne'] -24 ;
$tab_infos['groupe']			= "inst1";
$tab_infos['cell_id']			= "cadre03";
$tab_infos['document']			= "doc";

$JavaScriptInitCommandes[] = "ADDA_div_init ( 'Contenu_cadre_".$pv['cadre_numero']."' , 'titre_cadre_".$pv['cadre_numero']."_img', 
'../graph/" . ${$theme_tableau}['theme_repertoire'] . "/" . ${$theme_tableau}[$_REQUEST['blocT']]['deco_icone_bas'] ."', 
'../graph/" . ${$theme_tableau}['theme_repertoire'] . "/" . ${$theme_tableau}[$_REQUEST['blocT']]['deco_icone_haut'] ."', 
1, 60 , 0.25, ".$tab_infos['doc_height']." );";

$pv['onglet'] = 1;
$lt = 1;
$ADC['onglet'][$pv['onglet']]['nbr_ligne'] = 3;	$ADC['onglet'][$pv['onglet']]['nbr_cellule'] = 3;	$ADC['onglet'][$pv['onglet']]['legende'] = 1;

$tl_['fra']['C6_titre'] = "Journalisation de l'installation";
$tl_['eng']['C6_titre'] = "Installation report";

echo ("
<div id='titre_cadre_".$pv['cadre_numero']."' class='" . $theme_tableau.$_REQUEST['bloc']."_tb5 ".$theme_tableau.$_REQUEST['bloc']."_fcta' style='width: ".$tab_infos['doc_width']."px; vertical-align: middle;' >\r
<img id='titre_cadre_".$pv['cadre_numero']."_img' src='../graph/" . ${$theme_tableau}['theme_repertoire'] . "/" . ${$theme_tableau}[$_REQUEST['blocT']]['deco_icone_haut'] . "' width='32' height='32' border='0' style='vertical-align: middle;' onclick=\"animation_document_div_accordeon( 'Contenu_cadre_".$pv['cadre_numero']."' );\">\r
".$tl_[$l]['C6_titre']."
</div>\r
<br>\r
<div id='Contenu_cadre_".$pv['cadre_numero']."' style='text-align: justify; width: ".$tab_infos['doc_width']."px; height: ".$tab_infos['doc_height']."px; overflow: hidden;'>\r
");


$tl_['eng']['o2l'.$lt.'c1']	= "Display report options";			$tl_['fra']['o2l'.$lt.'c1']	= "Options de l'affichage du r&eacute;sum&eacute;";
$tl_['eng']['o2l'.$lt.'c2']	= "";								$tl_['fra']['o2l'.$lt.'c2']	= "";
$tl_['eng']['o2l'.$lt.'c3']	= "";								$tl_['fra']['o2l'.$lt.'c3']	= "";
$tl_['fra']['o2l'.$lt.'c4']	= "";
$AD[$pv['onglet']][$lt]['1']['cont'] = $tl_[$l]['o2l'.$lt.'c1'];	$AD[$pv['onglet']][$lt]['1']['tc'] = 4;	$AD[$pv['onglet']][$lt]['1']['sc'] = 1;
$AD[$pv['onglet']][$lt]['2']['cont'] = $tl_[$l]['o2l'.$lt.'c2'];	$AD[$pv['onglet']][$lt]['2']['tc'] = 4;	$AD[$pv['onglet']][$lt]['2']['sc'] = 1;
$AD[$pv['onglet']][$lt]['3']['cont'] = $tl_[$l]['o2l'.$lt.'c3'];	$AD[$pv['onglet']][$lt]['3']['tc'] = 4;	$AD[$pv['onglet']][$lt]['3']['sc'] = 1;
$lt++;

$tl_['eng']['o2l'.$lt.'c1']	= "Database";								$tl_['fra']['o2l'.$lt.'c1']	= "Base de donn&eacute;es";
$tl_['eng']['o2l'.$lt.'c2']	= "Warning messages";						$tl_['fra']['o2l'.$lt.'c2']	= "Messages d'avertissement";
$tl_['eng']['o2l'.$lt.'c3']	= "Error messages";							$tl_['fra']['o2l'.$lt.'c3']	= "Messages d'erreur";
$AD[$pv['onglet']][$lt]['1']['cont'] = $tl_[$l]['o2l'.$lt.'c1'];
$AD[$pv['onglet']][$lt]['2']['cont'] = "<input type='checkbox' name='form[db_detail_log_warn]'>" . $tl_[$l]['o2l'.$lt.'c2'];
$AD[$pv['onglet']][$lt]['3']['cont'] = "<input type='checkbox' name='form[db_detail_log_err]' checked>" . $tl_[$l]['o2l'.$lt.'c3'];
$lt++;


$tl_['eng']['o2l'.$lt.'c1']	= "Console";								$tl_['fra']['o2l'.$lt.'c1']	= "Console de commande";
$tl_['eng']['o2l'.$lt.'c2']	= "Warning messages";						$tl_['fra']['o2l'.$lt.'c2']	= "Messages d'avertissement";
$tl_['eng']['o2l'.$lt.'c3']	= "Error messages";							$tl_['fra']['o2l'.$lt.'c3']	= "Messages d'erreur";
$AD[$pv['onglet']][$lt]['1']['cont'] = $tl_[$l]['o2l'.$lt.'c1'];
$AD[$pv['onglet']][$lt]['2']['cont'] = "<input type='checkbox' name='form[console_detail_log_warn]' checked>" . $tl_[$l]['o2l'.$lt.'c2'];
$AD[$pv['onglet']][$lt]['3']['cont'] = "<input type='checkbox' name='form[console_detail_log_err]' checked>" . $tl_[$l]['o2l'.$lt.'c3'];
$lt++;

include ("routines/website/affichage_donnees.php");

echo ("</div>\r");

$pv['cadre_numero']++;

// --------------------------------------------------------------------------------------------

$pv['i'] = 0;
$tl_['eng'][$pv['i']] = "Database server";									$tl_['fra'][$pv['i']] = "Serveur de base de donn\351es";	$pv['i']++;
$tl_['eng'][$pv['i']] = "Admin login (read / write)";						$tl_['fra'][$pv['i']] = "Identifiant admin (lecture / \351criture)";	$pv['i']++;
$tl_['eng'][$pv['i']] = "Password";											$tl_['fra'][$pv['i']] = "Mot de passe";	$pv['i']++;
$tl_['eng'][$pv['i']] = "Database name";									$tl_['fra'][$pv['i']] = "Nom de la base de donn\351es";	$pv['i']++;
$tl_['eng'][$pv['i']] = "User name of the database user (your scripts)";	$tl_['fra'][$pv['i']] = "Nom de l\'utilisateur de la base (vos scripts)";	$pv['i']++;
$tl_['eng'][$pv['i']] = "Database user Password";							$tl_['fra'][$pv['i']] = "Mot de passe l\'utilisateur de la base";			$pv['i']++;
$tl_['eng'][$pv['i']] = "Generic user Password";							$tl_['fra'][$pv['i']] = "Mot de passe des utilisateurs g\351n\351riques";	$pv['i']++;

$pv['i'] = 0;
$pv['ListeChamps'][$pv['i']]['id'] = 'form[database_host]';				$pv['ListeChamps'][$pv['i']]['nom'] = $tl_[$l][$pv['i']];	$pv['ListeChamps'][$pv['i']]['err'] = 0;	$pv['i']++;
$pv['ListeChamps'][$pv['i']]['id'] = 'form[db_admin_user]';				$pv['ListeChamps'][$pv['i']]['nom'] = $tl_[$l][$pv['i']];	$pv['ListeChamps'][$pv['i']]['err'] = 0;	$pv['i']++;
$pv['ListeChamps'][$pv['i']]['id'] = 'form[db_admin_password]';			$pv['ListeChamps'][$pv['i']]['nom'] = $tl_[$l][$pv['i']];	$pv['ListeChamps'][$pv['i']]['err'] = 0;	$pv['i']++;
$pv['ListeChamps'][$pv['i']]['id'] = 'form[dbprefix]';					$pv['ListeChamps'][$pv['i']]['nom'] = $tl_[$l][$pv['i']];	$pv['ListeChamps'][$pv['i']]['err'] = 0;	$pv['i']++;
$pv['ListeChamps'][$pv['i']]['id'] = 'form[database_user_login]';		$pv['ListeChamps'][$pv['i']]['nom'] = $tl_[$l][$pv['i']];	$pv['ListeChamps'][$pv['i']]['err'] = 0;	$pv['i']++;
$pv['ListeChamps'][$pv['i']]['id'] = 'form[database_user_password]';	$pv['ListeChamps'][$pv['i']]['nom'] = $tl_[$l][$pv['i']];	$pv['ListeChamps'][$pv['i']]['err'] = 0;	$pv['i']++;
$pv['ListeChamps'][$pv['i']]['id'] = 'form[standard_user_password]';	$pv['ListeChamps'][$pv['i']]['nom'] = $tl_[$l][$pv['i']];	$pv['ListeChamps'][$pv['i']]['err'] = 0;	$pv['i']++;

$pv['JSONListeChamps'] = "var ListeChamps = { \r";

$pv['i'] = 0;
foreach ( $pv['ListeChamps'] as $A ) {
	$pv['JSONListeChamps'] .= "'".$pv['i']."' : { 'id':'".$A['id']."', 'nom':'".$A['nom']."', 'err':'0' },\r";
	$pv['i']++;
}
$pv['JSONListeChamps'] = substr ( $pv['JSONListeChamps'] , 0 , -2 ) . "}; ";
$JavaScriptInitDonnees[] = $pv['JSONListeChamps'];

$tl_['eng']['avcf'] = "Please, fill the form.\\n\\Form:\\n";		
$tl_['fra']['avcf'] = "Veuillez compl\351ter le formulaire.\\n\\nChamps du fomulaire:\\n";
$JavaScriptInitDonnees[] = " var AlertVerifieChampsFomulaire = '". $tl_[$l]['avcf'] ."'";

// --------------------------------------------------------------------------------------------
$tl_['eng']['bouton'] = "Install";					//ENG
$tl_['fra']['bouton'] = "Installer";			//FRA

$SessionID = floor ( microtime_chrono() );

$_REQUEST['BS']['id']				= "bouton_install_p1";
$_REQUEST['BS']['type']				= "button";
$_REQUEST['BS']['style_initial']	= $theme_tableau.$_REQUEST['bloc']."_tb3 ".$theme_tableau.$_REQUEST['bloc']."_submit_s2_n";
$_REQUEST['BS']['style_hover']		= $theme_tableau.$_REQUEST['bloc']."_tb3 ".$theme_tableau.$_REQUEST['bloc']."_submit_s3_h";
$_REQUEST['BS']['onclick']			= "VerifieChampsFomulaire( ListeChamps , '".$l."' , '".$SessionID."')";
$_REQUEST['BS']['message']			= $tl_[$l]['bouton'];
$_REQUEST['BS']['mode']				= 1;
$_REQUEST['BS']['taille'] 			= 256;
$_REQUEST['BS']['derniere_taille']	= 256;

// langue='".$l."'; var SessionID = '".$SessionID."'; 

echo ("
<div style='position: absolute; text-align: center; width: ".${$theme_tableau}['theme_module_largeur_interne']."px;'>\r
<table cellpadding='0' cellspacing='0' style='margin-left: auto; margin-right: auto;'>
<tr>\r
<td>\r
");
echo generation_bouton ();
echo ("
</td>\r
</tr>\r
</table>\r


<input type='hidden' name='PageInstall' value='2'>\r
<input type='hidden' name='SessionID' value='".$SessionID."'>\r
<input type='hidden' name='l' value='".$l."'>\r

</form>\r
");

//<input type='hidden' name='form[mode_operatoire]' value='".$_REQUEST['form']['mode_operatoire']."'>\r
// --------------------------------------------------------------------------------------------

$_REQUEST['StatistiqueInsertion'] = 1;

?>
