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


$pv['debug_install'] = 0;
//$pv['debug_install_memoire'] = 0;
//ini_set( 'memory_limit', '1024M' );
//ini_set( 'max_execution_time', 60 );

$_REQUEST['moniteur']['SQL_requete_nbr'] = 0;
$_REQUEST['moniteur']['date_debut'] = floor ( microtime_chrono() );

$monSQLn = &$_REQUEST['moniteur']['SQL_requete_nbr'];

// --------------------------------------------------------------------------------------------
//
//
// Mode Web (URL)
//
//
// --------------------------------------------------------------------------------------------
$tab_index = 1 ;
if ( $_REQUEST['resume_detail_desc'] == "on" ) { $tab_index++;}
if ( $_REQUEST['resume_detail_execsql'] == "on" ) { $tab_index += 2; }

$tab_fc['1'] = $theme_tableau.$_REQUEST['bloc']."_fca ".$theme_tableau.$_REQUEST['bloc']."_t1";
$tab_fc['2'] = $theme_tableau.$_REQUEST['bloc']."_fca ".$theme_tableau.$_REQUEST['bloc']."_t1";
$tab_fc['3'] = $theme_tableau.$_REQUEST['bloc']."_fca ".$theme_tableau.$_REQUEST['bloc']."_t1";
$tab_fc['4'] = $theme_tableau.$_REQUEST['bloc']."_fcb ".$theme_tableau.$_REQUEST['bloc']."_t1";
$tab_fc['5'] = $theme_tableau.$_REQUEST['bloc']."_fcc ".$theme_tableau.$_REQUEST['bloc']."_tb2";
$tab_fc['6'] = $theme_tableau.$_REQUEST['bloc']."_fcd ".$theme_tableau.$_REQUEST['bloc']."_tb3";
$tab_fc['7'] = $theme_tableau.$_REQUEST['bloc']."_fcd ".$theme_tableau.$_REQUEST['bloc']."_tb4";

$tab_fc1 = $tab_fc[$tab_index];	$tab_index++;
$tab_fc2 = $tab_fc[$tab_index];	$tab_index++;
$tab_fc3 = $tab_fc[$tab_index];	$tab_index++;
$tab_fc4 = $tab_fc[$tab_index];

$_REQUEST['mode_operatoire']	= $_REQUEST['form']['mode_operatoire'];		// pour compatibilite avec manipulation_xxxxxx.php
$db_ = array();
$db_['type']					= $_REQUEST['form']['database_type_choix'];
$db_['dal']						= $_REQUEST['form']['database_dal_choix'];
$db_['host']					= $_REQUEST['form']['database_host'];
$db_['user_login']				= $_REQUEST['form']['db_hosting_prefix'] . $_REQUEST['form']['db_admin_user'];
$db_['user_password']			= $_REQUEST['form']['db_admin_password'];
$db_['tabprefix']				= $_REQUEST['form']['prefix_des_tables'];
$db_['database_user_login']		= $_REQUEST['form']['db_hosting_prefix'] . $_REQUEST['form']['database_user_login'];
$db_['database_user_password']	= $_REQUEST['form']['database_user_password'];
$db_['standard_user_password']	= $_REQUEST['form']['standard_user_password'];

//$_REQUEST['debug_option']['SQL_debug_level'] = 0;
if ( $_REQUEST['form']['db_detail_log_err'] == "on" ) { $_REQUEST['debug_option']['SQL_debug_level'] = 1; }
if ( $_REQUEST['form']['db_detail_log_warn'] == "on" ) { $_REQUEST['debug_option']['SQL_debug_level'] = 2; }

config_variable();

$db_['dbprefix'] = "mysql"; // permet de réussir la connexion à la base de données si la base mwm n'existe pas.
include ("routines/website/preparatifs_sql.php");
$db_['dbprefix']				= $_REQUEST['form']['db_hosting_prefix'] . $_REQUEST['form']['dbprefix'];


switch ( $_REQUEST['form']['database_profil'] ) {
case "hostplan":
	switch ( $db_['dal'] ) {
	case "MYSQLI":		break;	//Rien a faire : PHP
	case "PDOMYSQL":	break;	//Rien a faire : PHP
	case "SQLITE":		break;
	case "ADODB":		break;
	case "PEARDB":			
	case "PEARSQLITE":	
		$r[] = "SET SESSION query_cache_type = OFF;";				// Sensé inhiber l'utilisation du cache
		$r[] = "USE ".$db_['dbprefix'].";";
		unset ( $A );
		$db->loadModule('Manager');
		foreach ( $db->listTables( $db_['dbprefix'] ) as $A ) { $r[] = "DROP TABLE ". $A .";"; }
		$r[] = "FLUSH TABLES;";										// Sensé remettre a zero les query_cache
		$db->loadModule('Native');
	break;
	}
break; 
case "absolute":
	$r[] = "DROP DATABASE IF EXISTS ".$db_['dbprefix'].";";	// Détruit la base
	$r[] = "FLUSH TABLES;";										// Sensé remettre a zero les query_cache
	$r[] = "FLUSH PRIVILEGES;";
	$r[] = "CREATE DATABASE ".$db_['dbprefix'].";";				// Création de la base
	$r[] = "USE ".$db_['dbprefix'].";";							// Et on utilise
	$r[] = "SET SESSION query_cache_type = ON;";				// Sensé initier l'utilisation du query_cache
	$r[] = "SET GLOBAL query_cache_size = 67108864;";			// 16777216;
	$r[] = "SET GLOBAL tmp_table_size = 67108864;";				// 16777216;
	$r[] = "SET GLOBAL max_heap_table_size = 67108864;";		// 16777216;

	$monSQLn += 9;
break;
}

switch ( $_REQUEST['form']['database_user_recreate'] ) {
case "oui":
	$r[] = "DROP USER '".$db_['database_user_login']."'@'%';";
	$r[] = "DROP USER '".$db_['database_user_login']."'@'localhost';";
	$r[] = "CREATE USER '".$db_['database_user_login']."'@'%' IDENTIFIED BY '".$db_['database_user_password']."';";
	$r[] = "CREATE USER '".$db_['database_user_login']."'@'localhost' IDENTIFIED BY '".$db_['database_user_password']."';";
	$r[] = "GRANT CREATE, DROP, SELECT, INSERT, UPDATE, DELETE ON ".$db_['dbprefix'].".* TO '".$db_['database_user_login']."'@'%' WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;";
	$r[] = "GRANT CREATE, DROP, SELECT, INSERT, UPDATE, DELETE ON ".$db_['dbprefix'].".* TO '".$db_['database_user_login']."'@'localhost' WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;";
	$r[] = "FLUSH TABLES;";										// Sensé remettre a zero les query_cache
	$r[] = "FLUSH PRIVILEGES;";
	$monSQLn += 8;
break;
}
$r[] = "COMMIT;";
$r[] = "USE ".$db_['dbprefix'].";";

// --------------------------------------------------------------------------------------------
foreach ( $r as $Requete ){ requete_sql($_REQUEST['sql_initiateur'], $Requete ); }
unset ($r);

// --------------------------------------------------------------------------------------------
include ("routines/website/manipulation_article.php");
include ("routines/website/manipulation_article_config.php");
include ("routines/website/manipulation_bouclage.php");
include ("routines/website/manipulation_categorie.php");
include ("routines/website/manipulation_contexte.php");
include ("routines/website/manipulation_decoration.php");
include ("routines/website/manipulation_document.php");
include ("routines/website/manipulation_groupe.php");
include ("routines/website/manipulation_module.php");
include ("routines/website/manipulation_mot_cle.php");
include ("routines/website/manipulation_presentation.php");
include ("routines/website/manipulation_site.php");
include ("routines/website/manipulation_theme.php");
include ("routines/website/manipulation_tag.php");
include ("routines/website/manipulation_utilisateur.php");
include ("routines/website/manipulation_variable.php");
include ("routines/website/console_de_commande.php");
include ("install/install_routines/fonction_install.php");
statistique_checkpoint ( "Apres chargement routine manipulation" );

// --------------------------------------------------------------------------------------------
//	Creation des tables.
// --------------------------------------------------------------------------------------------
$T_SynResFicCom = array();
$T_StoCom = array();
$c_SRF = 0;
$c_SC = 0;

$tl_['eng']['p3_cd01']		= "Directory : ";		$tl_['fra']['p3_cd01']	= "R&eacute;pertoire : ";
$tl_['eng']['p3_cd02']		= "file : ";			$tl_['fra']['p3_cd02']	= "fichier : ";

$tl_['eng']['p3_t1c01']		= "Field";				$tl_['fra']['p3_t1c01']	= "Colonne";
$tl_['eng']['p3_t1c02']		= "Type";				$tl_['fra']['p3_t1c02']	= "Type";
$tl_['eng']['p3_t1c03']		= "Null";				$tl_['fra']['p3_t1c03']	= "Null";
$tl_['eng']['p3_t1c04']		= "Key";				$tl_['fra']['p3_t1c04']	= "Cl&eacute;";
$tl_['eng']['p3_t1c05']		= "Default";			$tl_['fra']['p3_t1c05']	= "D&eacute;faut";
$tl_['eng']['p3_t1c06']		= "Extra";				$tl_['fra']['p3_t1c06']	= "Extra";

$tl_['eng']['p3_resultat']['cc']				= "Results";			$tl_['fra']['p3_resultat']['cc']				= "R&eacute;sultats";
$tl_['eng']['p3_resultat_ok']['cc']				= "Ok Commands : ";		$tl_['fra']['p3_resultat_ok']['cc']				= "Commande ok : ";							
$tl_['eng']['p3_resultat_warn']['cc']			= "Command warning : ";	$tl_['fra']['p3_resultat_warn']['cc']			= "Avertissement sur commmande : ";							
$tl_['eng']['p3_resultat_err']['cc']			= "Command error : ";	$tl_['fra']['p3_resultat_err']['cc']			= "Erreur sur commande : ";							
$tl_['eng']['p3_resultat_catchy_ok']['cc']		= "Everything is ok";	$tl_['fra']['p3_resultat_catchy_ok']['cc']		= "Tout est bon";							
$tl_['eng']['p3_resultat_catchy_warn']['cc']	= "Warning raised";		$tl_['fra']['p3_resultat_catchy_warn']['cc']	= "Apparition d'avertissement";							
$tl_['eng']['p3_resultat_catchy_err']['cc']		= "Errors raised";		$tl_['fra']['p3_resultat_catchy_err']['cc']		= "Apparition d'erreur";

$tl_['eng']['p3_resultat']['db']				= "Results";			$tl_['fra']['p3_resultat']['db']				= "R&eacute;sultats";
$tl_['eng']['p3_resultat_ok']['db']				= "Queries ok :";		$tl_['fra']['p3_resultat_ok']['db']				= "Requetes ok : ";
$tl_['eng']['p3_resultat_warn']['db']			= "Query warning : ";	$tl_['fra']['p3_resultat_warn']['db']			= "Avertissement sur requete : ";
$tl_['eng']['p3_resultat_err']['db']			= "Query error : ";		$tl_['fra']['p3_resultat_err']['db']			= "Erreur sur requete : ";
$tl_['eng']['p3_resultat_catchy_ok']['db']		= "Everything is ok";	$tl_['fra']['p3_resultat_catchy_ok']['db']		= "Tout est bon";
$tl_['eng']['p3_resultat_catchy_warn']['db']	= "Warning raised";		$tl_['fra']['p3_resultat_catchy_warn']['db']	= "Apparition d'avertissement";
$tl_['eng']['p3_resultat_catchy_err']['db']		= "Errors raised";		$tl_['fra']['p3_resultat_catchy_err']['db']		= "Apparition d'erreur";

/*
$r[] = "INSERT INTO ".$SQL_tab_abrege['']." VALUES (installation_lock,1,'');";
foreach ( $r as $Requete ){ requete_sql($_REQUEST['sql_initiateur'], $Requete ); }
unset ($r);
*/

echo ("<br>\r");

// --------------------------------------------------------------------------------------------
//
//		Lancement des scripts.
//
// --------------------------------------------------------------------------------------------
include ("routines/website/formattage_commande.php");


$chemin = "../websites-datas/";	$methode = "filename";				$section = "tables_creation";
include ("install/install_routines/admin_creation_database.php");
statistique_checkpoint ( "Apres creation BDD" );


$chemin = "../websites-datas/";	$methode = "filename";				$section = "tables_data";
include ("install/install_routines/admin_creation_database.php");
statistique_checkpoint ( "Apres remplissage table" );
requete_sql ( $_REQUEST['sql_initiateur'], "UPDATE ".$SQL_tab_abrege['installation']." SET install_etat_nombre = '". $_REQUEST['moniteur']['SQL_requete_nbr'] ."' WHERE install_etat_nom = 'SQL_requete_nbr';" );
requete_sql ( $_REQUEST['sql_initiateur'], "UPDATE ".$SQL_tab_abrege['installation']." SET install_etat_nombre = '". $_REQUEST['SessionID'] ."' WHERE install_etat_nom = 'SessionID';" );
requete_sql ( $_REQUEST['sql_initiateur'], "UPDATE ".$SQL_tab_abrege['installation']." SET install_etat_nombre = '". $_REQUEST['moniteur']['date_debut'] ."' WHERE install_etat_nom = 'date_debut';" );


requete_sql($_REQUEST['sql_initiateur'],"FLUSH TABLES;");
$langList = array();
genere_table_langue ("langues");


$chemin = "../websites-datas/";	$methode = "console de commandes";	$section = "script";
include ("install/install_routines/admin_creation_database.php");
statistique_checkpoint ( "Apres execution des scripts de commandes" );

$chemin = "../websites-datas/";	$methode = "filename";				$section = "tables_post_install";
include ("install/install_routines/admin_creation_database.php");
statistique_checkpoint ( "SQL post installation" );


requete_sql ( $_REQUEST['sql_initiateur'], "UPDATE ".$SQL_tab_abrege['installation']." SET install_etat_nombre = '". floor ( microtime_chrono() ) ."' WHERE install_etat_nom = 'date_fin';" );
requete_sql ( $_REQUEST['sql_initiateur'], "UPDATE ".$SQL_tab_abrege['installation']." SET install_etat_nombre = '0' WHERE install_etat_nom = 'affichage';" );

/*
$r[] = "FLUSH TABLES;";									// Sensé remettre a zero les query_cache
$r[] = "DROP USER 'GAL_MWM'@'%';";
$r[] = "DROP USER 'GAL_MWM'@'localhost';";
$r[] = "FLUSH PRIVILEGES;";
$r[] = "CREATE USER 'GAL_MWM'@'%' IDENTIFIED BY 'GAL_MWM';";
$r[] = "CREATE USER 'GAL_MWM'@'localhost' IDENTIFIED BY 'GAL_MWM';";
$r[] = "GRANT SELECT, INSERT, UPDATE, DELETE ON ".$db_['dbprefix'].".".$db_['tabprefix']."_galerie TO 'GAL_MWM'@'%' WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0";
$r[] = "GRANT SELECT, INSERT, UPDATE, DELETE ON ".$db_['dbprefix'].".".$db_['tabprefix']."_galerie TO 'GAL_MWM'@'localhost' WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0";
$r[] = "GRANT SELECT, UPDATE ON ".$db_['dbprefix'].".".$db_['tabprefix']."_pv TO 'GAL_MWM'@'%' WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0";
$r[] = "GRANT SELECT, UPDATE ON ".$db_['dbprefix'].".".$db_['tabprefix']."_pv TO 'GAL_MWM'@'localhost' WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0";
$r[] = "FLUSH PRIVILEGES;";
foreach ( $r as $pv['Requete'] ){ requete_sql($_REQUEST['sql_initiateur'], $pv['Requete'] ); }
unset ($r);
*/
// --------------------------------------------------------------------------------------------
//
//	Rapport d'execution
//
// --------------------------------------------------------------------------------------------
statistique_checkpoint ("Fin_avant_stat");
$localisation = " / inst";
$_REQUEST['localisation'] = substr ( $_REQUEST['localisation'] , 0 , (0 - strlen( $localisation )) );
$_REQUEST['StatistiqueInsertion'] = 0;

statistique_checkpoint ( "Apres chargement Javascript" );

$tab_equivalent_['on'] = 1;
$a = $_REQUEST['form']['console_detail_log_err'];	$pv['affiche_log_console'] += $tab_equivalent_[$a];
$a = $_REQUEST['form']['console_detail_log_warn'];	$pv['affiche_log_console'] += $tab_equivalent_[$a];
$a = $_REQUEST['form']['db_detail_log_err'];		$pv['affiche_log_db'] += $tab_equivalent_[$a];
$a = $_REQUEST['form']['db_detail_log_warn'];		$pv['affiche_log_db'] += $tab_equivalent_[$a];


$tl_['eng']['onglet_1'] = "Begining";			$tl_['fra']['onglet_1'] = "D&eacute;marrage";
$tl_['eng']['onglet_2'] = "Script synthesis";	$tl_['fra']['onglet_2'] = "synth&egrave;se des scripts";
$tl_['eng']['onglet_3'] = "Database logs";		$tl_['fra']['onglet_3'] = "Journaux de BDD";
$tl_['eng']['onglet_4'] = "Console logs";		$tl_['fra']['onglet_4'] = "Journaux de la console";
$tl_['eng']['onglet_5'] = "Statistics";			$tl_['fra']['onglet_5'] = "Statistiques";
$tl_['eng']['onglet_6'] = "Deboggage";			$tl_['fra']['onglet_6'] = "Debug";
$tl_['eng']['onglet_7'] = "Memory";				$tl_['fra']['onglet_7'] = "M&eacute;moire";

$CptOglt = 5 + $pv['debug_install'];
// --------------------------------------------------------------------------------------------
$pv['onglet'] = 1;
$ADC['onglet'][$pv['onglet']]['nbr_ligne'] = 3;	$ADC['onglet'][$pv['onglet']]['nbr_cellule'] = 2;	$ADC['onglet'][$pv['onglet']]['legende'] = 1;
$lt = 1;

$tl_['eng']['o1l'.$lt.'c1'] = "Information";	$tl_['fra']['o1l'.$lt.'c1'] = "Information";
$tl_['eng']['o1l'.$lt.'c2'] = " ";			$tl_['fra']['o1l'.$lt.'c2'] = "";
$AD[$pv['onglet']][$lt]['1']['cont'] = $tl_[$l]['o1l'.$lt.'c1'];	$AD[$pv['onglet']][$lt]['1']['tc'] = 4;	$AD[$pv['onglet']][$lt]['1']['sc'] = 1;
$AD[$pv['onglet']][$lt]['2']['cont'] = $tl_[$l]['o1l'.$lt.'c2'];	$AD[$pv['onglet']][$lt]['2']['tc'] = 4;	$AD[$pv['onglet']][$lt]['2']['sc'] = 1;
$lt++;

$tl_['eng']['o1l'.$lt.'c1'] = "";			$tl_['fra']['o1l'.$lt.'c1'] = "";
$tl_['eng']['o1l'.$lt.'c2'] = "You have chosen to intall using the direct mode. The scripts have inserted all the needed data in the database.";			
$tl_['fra']['o1l'.$lt.'c2'] = "Vous avez choisi l'installation en mode direct. Les scripts ont ins&eacute;r&eacute; tous les &eacute;l&eacute;ments n&eacute;cessaires dans la base de donn&eacute;es.";
$AD[$pv['onglet']][$lt]['1']['cont'] = $tl_[$l]['o1l'.$lt.'c1'];
$AD[$pv['onglet']][$lt]['2']['cont'] = $tl_[$l]['o1l'.$lt.'c2'];
$lt++;

$tl_['eng']['o1l'.$lt.'c1'] = "Configuration files";	$tl_['fra']['o1l'.$lt.'c1'] = "Fichier de configuration";
$tl_['eng']['o1l'.$lt.'c2'] = " ";						$tl_['fra']['o1l'.$lt.'c2'] = "";
$AD[$pv['onglet']][$lt]['1']['cont'] = $tl_[$l]['o1l'.$lt.'c1'];	$AD[$pv['onglet']][$lt]['1']['tc'] = 4;	$AD[$pv['onglet']][$lt]['1']['sc'] = 1;
$AD[$pv['onglet']][$lt]['2']['cont'] = $tl_[$l]['o1l'.$lt.'c2'];	$AD[$pv['onglet']][$lt]['2']['tc'] = 4;	$AD[$pv['onglet']][$lt]['2']['sc'] = 1;
$lt++;

include ("install/install_routines/creation_fichier_config.php");



// --------------------------------------------------------------------------------------------
//	logs.
// --------------------------------------------------------------------------------------------
if ( $CptOglt > 1 ) { $pv['onglet']++;	installation_log_rapport_fichier (); }
if ( $CptOglt > 2 ) { $pv['onglet']++;	installation_log_sql (); }
if ( $CptOglt > 3 ) { $pv['onglet']++;	installation_log_manipulation (); }
if ( $CptOglt > 4 ) { $pv['onglet']++;	include ("../modules/initial/AdminInfoDebug/maid_stats.php"); }
if ( $CptOglt > 5 ) { $pv['onglet']++;	include ("../modules/initial/AdminInfoDebug/maid_journaux_debug.php"); }
/*
if ( $CptOglt > 6 ) { 
		$pv['onglet']++;
		$_REQUEST['ChasseurMemoire'] = 1;
		$_REQUEST['ChasseurMemoireLimite'] = 1024*64;
		$CAV['profondeur_max_demande'] = 1;
		include ("../modules/initial/maid_memoire.php"); }
*/
$tab_infos['AffOnglet']			= 1;
$tab_infos['NbrOnglet']			= $pv['onglet'];
$tab_infos['tab_comportement']	= 1;
$tab_infos['mode_rendu']		= 0;
$tab_infos['TypSurbrillance']	= 0; // 1:ligne, 2:cellule
$tab_infos['doc_height']		= 432 ;
$tab_infos['doc_width']			= ${$theme_tableau}['theme_module_largeur_interne'] -24;
$tab_infos['groupe']			= "Grp2";
$tab_infos['cell_id']			= "Tab";
$tab_infos['document']			= "I3b";
$tab_infos['cell_1_txt']		= $tl_[$l]['onglet_1'];
$tab_infos['cell_2_txt']		= $tl_[$l]['onglet_2'];
$tab_infos['cell_3_txt']		= $tl_[$l]['onglet_3'];
$tab_infos['cell_4_txt']		= $tl_[$l]['onglet_4'];
$tab_infos['cell_5_txt']		= $tl_[$l]['onglet_5'];
$tab_infos['cell_6_txt']		= $tl_[$l]['onglet_6'];
$tab_infos['cell_7_txt']		= $tl_[$l]['onglet_7'];
include ("routines/website/affichage_donnees.php");



// --------------------------------------------------------------------------------------------

switch ( $_REQUEST['form']['database_profil'] ) {
case "hostplan":
	switch ( $db_['dal'] ) {
	case "MYSQLI":		break;	//Rien a faire : PHP
	case "PDOMYSQL":	break;	//Rien a faire : PHP
	case "SQLITE":		break;
	case "ADODB":		break;
	case "PEARDB":			
	case "PEARSQLITE":	
	break;
	}
break; 
case "absolute":
	$r[] = "SET GLOBAL query_cache_size = 16777216;";			// 16777216;
	$r[] = "SET GLOBAL tmp_table_size = 16777216;";				// 16777216;
	$r[] = "SET GLOBAL max_heap_table_size = 16777216;";		// 16777216;
	$monSQLn += 3;
break;
}

switch ( $_REQUEST['form']['database_user_recreate'] ) {
case "oui":
break;
}
foreach ( $r as $Requete ){ requete_sql($_REQUEST['sql_initiateur'], $Requete ); }
unset ($r);







?>
