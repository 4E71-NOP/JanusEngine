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
//	Module : menu
//	Reconstitue nom du fichier avec le numero de style choisi et execute le fichier
//	2007 08 26 : Derniere modification
// --------------------------------------------------------------------------------------------

$localisation = " / module_menu";
$MapperObj->AddAnotherLevel($localisation );
$LMObj->logCheckpoint("module_menu");
$MapperObj->RemoveThisLevel($localisation );
$MapperObj->setSqlApplicant("module_menu");

$_REQUEST['localisation'] .= $localisation;
// statistique_checkpoint ("module_menu");
$_REQUEST['localisation'] = substr ( $_REQUEST['localisation'] , 0 , (0 - strlen( $localisation )) );


function menu_nbr_fils ( $cate_parent ) {
	global $menu_principal;
	$nbr = 0;
	foreach ( $menu_principal as $A ) {
		if ( $A['cate_parent'] == $cate_parent ) { $nbr++; }
	}
	return $nbr;
}

// 20110131 ajouter une colone sur la table tab_deco_10_menu = type
// le type donne l'index du menu a aller chercher.
// 00 = no menu / Offline
// 01 = statique
// 02 = Div Animé
// 03 = banner style
// 1xx = Non officiel

$pv['menu_genre']['0'] = "Offline";
$pv['menu_genre']['1'] = "../modules/initial/Menu/module_menu_01_statique.php";
$pv['menu_genre']['2'] = "../modules/initial/Menu/module_menu_02_animation.php";
$pv['menu_genre']['3'] = "../modules/initial/Menu/module_menu_03_banner.php";

$pv['i'] = ${$theme_tableau}['B00M']['deco_genre'];
$menu_style_fichier = $pv['menu_genre'][$pv['i']];

$_REQUEST['sql_initiateur'] = "Module menu";
$module_menu_requete = "
SELECT cat.*   
FROM ".$SQL_tab['categorie']." cat, ".$SQL_tab['bouclage']." bcl
WHERE cat.site_id = '".$WebSiteObj->getWebSiteEntry('sw_id')."'
AND cat.cate_lang = '".$WebSiteObj->getWebSiteEntry('sw_lang')."'
AND cat.bouclage_id = bcl.bouclage_id
AND bcl.bouclage_etat = '1' 
AND cat.cate_type IN ('0','1') 
AND cat.groupe_id ".$user['clause_in_groupe']." 
AND cat.cate_etat = '1' 
ORDER BY cat.cate_parent,cat.cate_position
;";

// --------------------------------------------------------------------------------------------
//	Un seule requete pour recuperer toutes les informations necessaires au traitement
// --------------------------------------------------------------------------------------------
$dbquery = requete_sql($_REQUEST['sql_initiateur'], $module_menu_requete );
if ( num_row_sql($dbquery) == 0) { echo ("Pas de menu afficher."); }
else { 
	while ($dbp = fetch_array_sql($dbquery)) { 
		$cate_id_index = $dbp['cate_id'];
		$menu_principal[$cate_id_index] = array (
		"cate_id"		=> $dbp['cate_id'],
		"cate_type"		=> $dbp['cate_type'],
		"cate_titre"	=> $dbp['cate_titre'],
		"cate_desc"		=> $dbp['cate_desc'],
		"cate_parent"	=> $dbp['cate_parent'],
		"cate_position"	=> $dbp['cate_position'],
		"groupe_id" 	=> $dbp['groupe_id'],
		"arti_ref"		=> $dbp['arti_ref']
		);
		if ( $dbp['cate_type'] == $menu_racine ) { $racine_menu = $dbp['cate_id']; }
	}
	$FPRM = array (
		"arti_request"	=> $affdoc_arti_ref,
		"cate_parent" 	=> $racine_menu,
		"module_z"		=> $module_z_index['compteur'] + 1,
		"origine_x"		=> $pres_[$module_['module_nom']]['pos_x_ex22'],
		"origine_y"		=> $pres_[$module_['module_nom']]['pos_y_ex22'],
		"init_x"		=> 0,
		"init_y"		=> 0
	);

	$pv['menu_niveau'] = 0;
	$pv['menu_JSON'] = array();
	$pv['menu_div'] = array();
	echo ("<!-- _______________________________________ DIVs menu (début) _______________________________________ -->");

	$pv['test_routine'] = 0;
	switch ( $pv['test_routine'] ) {										//M Menu; J Javascript. p parent, i id (en cours) , b bloc, d dossier,
	case 0:
// --------------------------------------------------------------------------------------------
		include ( $menu_style_fichier );
		echo ( "\r" . $affiche_module_['contenu_pendant_module'] );
	break;
	case 1:
		echo ("Aucune tache &agrave; executer.");
	break;
	}
	echo ("<!-- _______________________________________ DIVs menu (fin) _______________________________________ -->");
}

$JavaScriptFichier[] = "routines/website/javascript_popmenu.js";
$JavaScriptInitDonnees[] = $pv['menu_JSON_rendu'] . "var ZindexDepart = ".($module_z_index['compteur'] + 1).";\r";
$JavaScriptOnload[] = "\tInitMenuDiv ( ".$pv['menu_JSON_nom'].", TabInfoModule );";

global $CurrentSetObj;
$GeneratedJavaScriptObj = $CurrentSetObj->getInstanceOfGeneratedJavaScriptObj();
$GeneratedJavaScriptObj->insertJavaScript('File', "routines/website/javascript_popmenu.js");
$GeneratedJavaScriptObj->insertJavaScript('Data', $pv['menu_JSON_rendu'] . "var ZindexDepart = ".($module_z_index['compteur'] + 1).";\r");
$GeneratedJavaScriptObj->insertJavaScript('Onload', "\tInitMenuDiv ( ".$pv['menu_JSON_nom'].", TabInfoModule );");



if ( $WebSiteObj->getWebSiteEntry('sw_info_debug') < 10 ) {
	unset (
		$menu_principal, 
		$cate_id_index,
		$FPRM, 
		$dbquery, 
		$dbp,
		$pv
	);
}

$menu_racine = 0;

?>
