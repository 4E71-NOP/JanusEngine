<?php
/*MWM-licence*/
// --------------------------------------------------------------------------------------------
//
//	MWM - Multi Web Manager
//	Sous licence Creative common	
//	Under Creative Common licence	CC-by-nc-sa (http://creativecommons.org)
//	CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
//	(c)Faust MARIA DE AREVALO faust@multiweb-manager.net
//
// --------------------------------------------------------------------------------------------
/*MWM-licence-fin*/
$pv['tab'] = &$extensions_['donnees'][$pv['i']];

$pv['tab']['ws_id']					= $website['ws_id'];
$pv['tab']['extension_id']				= 0;
$pv['tab']['extension_nom']				= "MWM_Galerie";
$pv['tab']['extension_version']			= "0.01";
$pv['tab']['extension_auteur']			= "Faust MDA";
$pv['tab']['extension_site_auteur']		= "www.multiweb-manager.net";
$pv['tab']['extension_repertoire']		= "mwm_galerie_v0.01";
$pv['tab']['extension_etat']			= 0;
$pv['tab']['extension_dep']				= array ( 1 => 0 );
$pv['tab']['F_CheckInstall']			= "GalerieCheckInstall";
$pv['tab']['F_CheckClean']				= "GalerieCheckClean";
$pv['tab']['F_Configuration']			= "GalerieConfiguration";
$pv['tab']['F_EffaceConfiguration']		= "GalerieEffaceConfiguration";


function GalerieConfiguration () {
	global $pv, $extensions_, $SQL_tab_abrege;
	$P = &$extensions_['donnees'][$pv['i']];
	$id = manipulation_trouve_id_suivant ( $SQL_tab_abrege['extension_config'] , "config_id" );
	$requete[] = "INSERT INTO ".$SQL_tab_abrege['extension_config']." VALUES ( '".$id."', '".$P['ws_id']."', '".$P['extension_id']."', 'mode', '1' );";				$id++; //OFF 0	BASE 1(base)	FICHIER 2 (FILE)
	$requete[] = "INSERT INTO ".$SQL_tab_abrege['extension_config']." VALUES ( '".$id."', '".$P['ws_id']."', '".$P['extension_id']."', 'x', '128' );";				$id++;
	$requete[] = "INSERT INTO ".$SQL_tab_abrege['extension_config']." VALUES ( '".$id."', '".$P['ws_id']."', '".$P['extension_id']."', 'y', '128' );";				$id++;
	$requete[] = "INSERT INTO ".$SQL_tab_abrege['extension_config']." VALUES ( '".$id."', '".$P['ws_id']."', '".$P['extension_id']."', 'liserai', '5' );";			$id++;
	$requete[] = "INSERT INTO ".$SQL_tab_abrege['extension_config']." VALUES ( '".$id."', '".$P['ws_id']."', '".$P['extension_id']."', 'qualite', '40' );";			$id++;
	$requete[] = "INSERT INTO ".$SQL_tab_abrege['extension_config']." VALUES ( '".$id."', '".$P['ws_id']."', '".$P['extension_id']."', 'table_colonnes', '3' );";		$id++;
	$requete[] = "INSERT INTO ".$SQL_tab_abrege['extension_config']." VALUES ( '".$id."', '".$P['ws_id']."', '".$P['extension_id']."', 'table_lignes', '3' );";		$id++;
	$requete[] = "INSERT INTO ".$SQL_tab_abrege['extension_config']." VALUES ( '".$id."', '".$P['ws_id']."', '".$P['extension_id']."', 'fichier_tag', 'thumb_' );";
	$id = manipulation_trouve_id_suivant ( $SQL_tab_abrege['extension_fichiers'] , "fichier_id" );
	$requete[] = "INSERT INTO ".$SQL_tab_abrege['extension_fichiers']." VALUES ( '".$id."', '".$P['extension_id']."', '".$P['extension_nom']."', 'Call_Galerie_d_images.php', 'Galerie', '0'  );"; $id++;	// 0 exec, 1 librarie
	$requete[] = "INSERT INTO ".$SQL_tab_abrege['extension_fichiers']." VALUES ( '".$id."', '".$P['extension_id']."', '".$P['extension_nom']."', 'generateur_vignette.php', 'vignette', '0'  );"; 			// 0 exec, 1 librarie
	$requete[] = "INSERT INTO ".$SQL_tab_abrege['pv']." VALUES ('galerie_ticket', '1', '');"; // Ticket
	unset ( $A );
	foreach ( $requete as $A ) { manipulation_traitement_requete ( $A ); }
}

function GalerieEffaceConfiguration () {
	global $pv, $extensions_, $SQL_tab_abrege;
	$P = &$extensions_['donnees']['0'];
	$requete[] = "DELETE FROM ".$SQL_tab_abrege['extension_config']." WHERE ws_id = '".$P['ws_id']."' AND extension_id = '".$P['extension_id']."';";
	$requete[] = "DELETE FROM ".$SQL_tab_abrege['extension_fichiers']." WHERE extension_id = '".$P['extension_id']."';";
	$requete[] = "DELETE FROM ".$SQL_tab_abrege['pv']." WHERE pv_nom = 'galerie_ticket';";
	unset ( $A );
	foreach ( $requete as $A ) { manipulation_traitement_requete ( $A ); }
}

function GalerieCheckInstall () {
	global $pv, $SQL_tab_abrege, $website, $db_, $extensions_;
	$P = &$extensions_['donnees']['0'];
	$dp = &$pv['diagnostic_extension'];

	// Vérifie l'enregistrement du extension
	$pv['requete'] = "SELECT ext.* FROM ".$SQL_tab_abrege['extension']." ext WHERE ext.ws_id = '".$P['ws_id']."' AND ext.extension_nom = '".$P['extension_nom']."';";
	$dbquery = requete_sql($_REQUEST['sql_initiateur'], $pv['requete'] );
	if ( num_row_sql( $dbquery ) == 1 ) { $dp['extension_enregistrement'] = "ok"; }

	//Vérifier la table Galerie
	$pv['requete'] = "INSERT INTO ". $db_['tabprefix'] . "_galerie VALUES ( '1', 'fichier', '10', '1', '1', 'abcdef' );";
	$dbquery = requete_sql($_REQUEST['sql_initiateur'], $pv['requete'] );

	$pv['requete'] = "SELECT * FROM ". $db_['tabprefix'] . "_galerie WHERE gal_id = '1';";
	$dbquery = requete_sql($_REQUEST['sql_initiateur'], $pv['requete'] );
	if ( num_row_sql( $dbquery ) == 1 ) { 
		$dp['tables']['galerie']['nom'] = "galerie"; 
		$dp['tables']['galerie']['etat'] = "ok"; 
	}

	$pv['requete'] = "DELETE FROM ". $db_['tabprefix'] . "_galerie WHERE gal_id = '1';";
	$dbquery = requete_sql($_REQUEST['sql_initiateur'], $pv['requete'] );

	$liste = array ( "doc_uni_config_galerie_p01.php" );
	extension_score_element ( $dp['documents'] , $liste , "M_DOCUME_red");

	$liste = array ( "fra_config_galerie_p01", "eng_config_galerie_p01" );
	extension_score_element ( $dp['articles'] , $liste , "M_ARTICL_rea" );

	$liste = array ( "fra_galerie", "eng_galerie" );
	extension_score_element ( $dp['categories'] , $liste , "M_CATEGO_rep" );

// $_REQUEST['sru_ERR']
/*
	$pv['requete'] = "DELETE FROM ". $db_['tabprefix'] . "_galerie WHERE gal_id = '1';";
	$dbquery = requete_sql($_REQUEST['sql_initiateur'], $pv['requete'] );
*/
}



?>
