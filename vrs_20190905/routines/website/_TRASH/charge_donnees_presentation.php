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

// --------------------------------------------------------------------------------------------
//	Charge et calcule la presentation
//	La définition par le script est basée sur le principe de copie source vers destination
//	module_anchor_e3a "document"	Module qui servira de source
//	anchor_ex3a "LEFT"				Ancre X source du module nomé
//	anchor_ey3a "BOTTOM"			Ancre Y source du module nomé
//	anchor_dx30 "RIGHT" 			Ancre X destination du module en cours
//	anchor_dy30 "BOTTOM"			Ancre Ydestination du module en cours
// X1 X2
// X3 X4
// --------------------------------------------------------------------------------------------
$MapperObj->AddAnotherLevel($localisation );
$LMObj->logCheckpoint("charge_donnees_presentation");
$MapperObj->RemoveThisLevel($localisation );
$MapperObj->setSqlApplicant("Chargement des donnees de la presentation");

$localisation = " / charge_donnees_presentation";
$_REQUEST['localisation'] .= $localisation;
// statistique_checkpoint ("charge_donnees_presentation");
$_REQUEST['localisation'] = substr ( $_REQUEST['localisation'] , 0 , (0 - strlen( $localisation )) );


$tl_['eng']['si'] = "Load presentation datas";
$tl_['fra']['si'] = "Charge les donnees de la presentation";
$_REQUEST['sql_initiateur'] = $tl_[$l]['si'];

function charge_donnees_brutes ( $presentation_selection ) {
	global $SQL_tab_abrege, $PL, $module_tab_, $module_tab_n_ ;

	$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
	SELECT * 
	FROM ".$SQL_tab_abrege['presentation_contenu']." 
	WHERE pres_id = '".$presentation_selection."' 
	ORDER BY pres_ligne
	;");
	while ($dbp = fetch_array_sql($dbquery)) { 
		$l = $dbp['pres_ligne'];
		foreach ( $dbp as $A => $B ) { $PL[$l][$A] = $B; } 
		$PL[$l]['pres_module_ancre_e10']			= "";
		$PL[$l]['pres_module_ancre_e20']			= "";
		$PL[$l]['pres_module_ancre_e30']			= "";
	}

// Selection des successeurs si les modules nominaux ne sont pas disponibles
	unset ($A);
	foreach ( $PL as &$A ) {
		if ( strlen($A['pres_module_ancre_e1a']) > 0 && $module_tab_n_[$A['pres_module_ancre_e1a']]['module_id'] != 0 )		{ $A['pres_module_ancre_e10']	=  $A['pres_module_ancre_e1a'];	$A['pres_ancre_ex10']	=  $A['pres_ancre_ex1a'];	$A['pres_ancre_ey10']	=  $A['pres_ancre_ey1a']; } 
		elseif ( strlen($A['pres_module_ancre_e1b']) > 0 && $module_tab_n_[$A['pres_module_ancre_e1b']]['module_id'] != 0 )	{ $A['pres_module_ancre_e10']	=  $A['pres_module_ancre_e1b'];	$A['pres_ancre_ex10']	=  $A['pres_ancre_ex1b'];	$A['pres_ancre_ey10']	=  $A['pres_ancre_ey1b']; }
		elseif ( strlen($A['pres_module_ancre_e1c']) > 0 && $module_tab_n_[$A['pres_module_ancre_e1c']]['module_id'] != 0 )	{ $A['pres_module_ancre_e10']	=  $A['pres_module_ancre_e1c'];	$A['pres_ancre_ex10']	=  $A['pres_ancre_ex1c'];	$A['pres_ancre_ey10']	=  $A['pres_ancre_ey1c']; }
		elseif ( strlen($A['pres_module_ancre_e1d']) > 0 && $module_tab_n_[$A['pres_module_ancre_e1d']]['module_id'] != 0 )	{ $A['pres_module_ancre_e10']	=  $A['pres_module_ancre_e1d'];	$A['pres_ancre_ex10']	=  $A['pres_ancre_ex1d'];	$A['pres_ancre_ey10']	=  $A['pres_ancre_ey1d']; }
		elseif ( strlen($A['pres_module_ancre_e1e']) > 0 && $module_tab_n_[$A['pres_module_ancre_e1e']]['module_id'] != 0 )	{ $A['pres_module_ancre_e10']	=  $A['pres_module_ancre_e1e'];	$A['pres_ancre_ex10']	=  $A['pres_ancre_ex1e'];	$A['pres_ancre_ey10']	=  $A['pres_ancre_ey1e']; }

		if ( strlen($A['pres_module_ancre_e2a']) > 0 && $module_tab_n_[$A['pres_module_ancre_e2a']]['module_id'] != 0 )		{ $A['pres_module_ancre_e20']	=  $A['pres_module_ancre_e2a'];	$A['pres_ancre_ex20']	=  $A['pres_ancre_ex2a'];	$A['pres_ancre_ey20']	=  $A['pres_ancre_ey2a']; } 
		elseif ( strlen($A['pres_module_ancre_e2b']) > 0 && $module_tab_n_[$A['pres_module_ancre_e2b']]['module_id'] != 0 )	{ $A['pres_module_ancre_e20']	=  $A['pres_module_ancre_e2b'];	$A['pres_ancre_ex20']	=  $A['pres_ancre_ex2b'];	$A['pres_ancre_ey20']	=  $A['pres_ancre_ey2b']; }
		elseif ( strlen($A['pres_module_ancre_e2c']) > 0 && $module_tab_n_[$A['pres_module_ancre_e2c']]['module_id'] != 0 )	{ $A['pres_module_ancre_e20']	=  $A['pres_module_ancre_e2c'];	$A['pres_ancre_ex20']	=  $A['pres_ancre_ex2c'];	$A['pres_ancre_ey20']	=  $A['pres_ancre_ey2c']; }
		elseif ( strlen($A['pres_module_ancre_e2d']) > 0 && $module_tab_n_[$A['pres_module_ancre_e2d']]['module_id'] != 0 )	{ $A['pres_module_ancre_e20']	=  $A['pres_module_ancre_e2d'];	$A['pres_ancre_ex20']	=  $A['pres_ancre_ex2d'];	$A['pres_ancre_ey20']	=  $A['pres_ancre_ey2d']; }
		elseif ( strlen($A['pres_module_ancre_e2e']) > 0 && $module_tab_n_[$A['pres_module_ancre_e2e']]['module_id'] != 0 )	{ $A['pres_module_ancre_e20']	=  $A['pres_module_ancre_e2e'];	$A['pres_ancre_ex20']	=  $A['pres_ancre_ex2e'];	$A['pres_ancre_ey20']	=  $A['pres_ancre_ey2e']; }

		if ( strlen($A['pres_module_ancre_e3a']) > 0 && $module_tab_n_[$A['pres_module_ancre_e3a']]['module_id'] != 0 )		{ $A['pres_module_ancre_e30']	=  $A['pres_module_ancre_e3a'];	$A['pres_ancre_ex30']	=  $A['pres_ancre_ex3a'];	$A['pres_ancre_ey30']	=  $A['pres_ancre_ey3a']; } 
		elseif ( strlen($A['pres_module_ancre_e3b']) > 0 && $module_tab_n_[$A['pres_module_ancre_e3b']]['module_id'] != 0 )	{ $A['pres_module_ancre_e30']	=  $A['pres_module_ancre_e3b'];	$A['pres_ancre_ex30']	=  $A['pres_ancre_ex3b'];	$A['pres_ancre_ey30']	=  $A['pres_ancre_ey3b']; }
		elseif ( strlen($A['pres_module_ancre_e3c']) > 0 && $module_tab_n_[$A['pres_module_ancre_e3c']]['module_id'] != 0 )	{ $A['pres_module_ancre_e30']	=  $A['pres_module_ancre_e3c'];	$A['pres_ancre_ex30']	=  $A['pres_ancre_ex3c'];	$A['pres_ancre_ey30']	=  $A['pres_ancre_ey3c']; }
		elseif ( strlen($A['pres_module_ancre_e3d']) > 0 && $module_tab_n_[$A['pres_module_ancre_e3d']]['module_id'] != 0 )	{ $A['pres_module_ancre_e30']	=  $A['pres_module_ancre_e3d'];	$A['pres_ancre_ex30']	=  $A['pres_ancre_ex3d'];	$A['pres_ancre_ey30']	=  $A['pres_ancre_ey3d']; }
		elseif ( strlen($A['pres_module_ancre_e3e']) > 0 && $module_tab_n_[$A['pres_module_ancre_e3e']]['module_id'] != 0 )	{ $A['pres_module_ancre_e30']	=  $A['pres_module_ancre_e3e'];	$A['pres_ancre_ex30']	=  $A['pres_ancre_ex3e'];	$A['pres_ancre_ey30']	=  $A['pres_ancre_ey3e']; }
	}
}

// --------------------------------------------------------------------------------------------
// LEFT	1		RIGHT	2		middle	3	TOP		1		BOTTOM	2		middle	3
function calcul_1_ancre_prepare_tableau_source ( $m , $axe ) {
	global $pres_, $ms;
	if ( $axe == "x" ) { $da = "cdx"; $pa = "cpx"; }
	else { $da = "cdy"; $pa = "cpy"; }
	$ms['SA']	= $pres_[$m][$pa];
	$ms['SB']	= $pres_[$m][$pa] + ( $pres_[$m][$da] / 2 );
	$ms['SC']	= $pres_[$m][$pa] + $pres_[$m][$da];
	$ms['D']	= $pres_[$m][$da];
}

// --------------------------------------------------------------------------------------------
//	0-6-3			0-6-3		0-6-3		  0-6-3		    0-6-3	
//	    0-1-2	  0-1-2			0-1-2		0-1-2		0-1-2		
//		3			6 4			0 7 5		  1 8			2		
// --------------------------------------------------------------------------------------------
function calcul_1_ancre ( $note , $m , $axe ) {
	global $pres_, $ms;
	if ( $axe == "x" ) { $da = "cdx"; $pa = "cpx"; } else { $da = "cdy"; $pa = "cpy"; }
	switch ( $note ) {
	case "3":	$pres_[$m][$pa] = $ms['SA'] - $pres_[$m][$da];			break;
	case "6":
	case "5":	$pres_[$m][$pa] = $ms['SA'] - ( $pres_[$m][$da] / 2 );	break;
	case "0":
	case "8":
	case "4":	$pres_[$m][$pa] = $ms['SA'];							break; 
	case "2":
	case "7":	$pres_[$m][$pa] = $ms['SB'];							break;
	case "1":	$pres_[$m][$pa] = $ms['SC'];							break; 
	}
}

// --------------------------------------------------------------------------------------------
function trouve_ancre_source ( $m , $x , $y ) {
	global $pres_, $qs;

	switch ( $x ) {
	case "1": 	$qs['x'] = $pres_[$m]['cpx'];								break;
	case "3": 	$qs['x'] = $pres_[$m]['cpx'] + ( $pres_[$m]['cdx'] / 2 );	break;
	case "2": 	$qs['x'] = $pres_[$m]['cpx'] + $pres_[$m]['cdx'];			break;
	}
	switch ( $y ) {
	case "1": 	$qs['y'] = $pres_[$m]['cpy'];								break;
	case "3": 	$qs['y'] = $pres_[$m]['cpy'] + ( $pres_[$m]['cdy'] / 2 );	break;
	case "2": 	$qs['y'] = $pres_[$m]['cpy'] + $pres_[$m]['cdy'];			break;
	}
}

function aligne_x1x3 () { global $qd, $qs;	$qd['x1'] = $qd['x3'] = $qs['x']; }
function aligne_x2x4 () { global $qd, $qs;	$qd['x2'] = $qd['x4'] = $qs['x']; }
function aligne_y1y2 () { global $qd, $qs;	$qd['y1'] = $qd['y2'] = $qs['y']; }
function aligne_y3y4 () { global $qd, $qs;	$qd['y3'] = $qd['y4'] = $qs['y']; }


// --------------------------------------------------------------------------------------------
// Stocke les informations des modules pour permettre à la présentation d'être dynamique
// --------------------------------------------------------------------------------------------
$dbquery = $SDDMObj->query("
SELECT * 
FROM ".$SqlTableListObj->getSQLTableName('module')." m, ".$SqlTableListObj->getSQLTableName('site_module')." sm 
WHERE sm.site_id = '".$WebSiteObj->getWebSiteEntry('sw_id')."' 
AND m.module_id = sm.module_id
AND sm.module_etat = '1' 
AND m.module_groupe_pour_voir ".$UserObj->getUserEntry('clause_in_groupe')." 
AND m.module_adm_control = '0' 
ORDER BY module_position
;");

$pv['i'] = 1;
while ($dbp = fetch_array_sql($dbquery)) { 
	foreach ( $dbp as $A => $B ) { $module_tab_[$pv['i']][$A] = $B; } 
	$module_tab_n_[$dbp['module_nom']]					= &$module_tab_[$pv['i']];
	$pv['i']++;
}
// $LMObj->logDebug($module_tab_n_ , "\$module_tab_n_");
// --------------------------------------------------------------------------------------------
// Ordre de choix de la présentation
//		1 Document, 2 Utilisateur, 3 theme choisi, 4 site
// --------------------------------------------------------------------------------------------
$PL = array();
$switch_score = 10;
if ( isset($_REQUEST['arti_ref']) ) { 
	$dbquery = $SDDMObj->query("
	SELECT 
	pr.pres_id as pr_pres_id,pr.pres_nom,pr.pres_titre,pr.pres_nom_generique, 
	sp.* 
	FROM ".$SqlTableListObj->getSQLTableName('presentation')." pr, ".$SqlTableListObj->getSQLTableName('theme_presentation')." sp, ".$SqlTableListObj->getSQLTableName('article')." art 
	WHERE art.arti_ref = '".$_REQUEST['arti_ref']."' 
	AND art.arti_page = '".$_REQUEST['arti_page']."' 
	AND art.site_id = '".$WebSiteObj->getWebSiteEntry('sw_id')."'
	AND art.pres_nom_generique = pr.pres_nom_generique 
	AND pr.pres_id = sp.pres_id 
	AND sp.theme_id = '".${$theme_tableau}['theme_id']."' 
	;");
// 	$dbquery = requete_sql( $_REQUEST['sql_initiateur'],"
// 	SELECT 
// 	pr.pres_id as pr_pres_id,pr.pres_nom,pr.pres_titre,pr.pres_nom_generique, 
// 	sp.* 
// 	FROM ".$SQL_tab_abrege['presentation']." pr, ".$SQL_tab_abrege['theme_presentation']." sp, ".$SQL_tab_abrege['article']." art 
// 	WHERE art.arti_ref = '".$_REQUEST['arti_ref']."' 
// 	AND art.arti_page = '".$_REQUEST['arti_page']."' 
// 	AND art.site_id = '".$site_web['sw_id']."'
// 	AND art.pres_nom_generique = pr.pres_nom_generique 
// 	AND pr.pres_id = sp.pres_id 
// 	AND sp.theme_id = '".${$theme_tableau}['theme_id']."' 
// 	;");
	while ($dbp = fetch_array_sql($dbquery)) { $presentation_selection = $dbp['pres_id']; }
	if ( $presentation_selection != 0 ) { $switch_score += 1000; }
}
if ( isset($user['pres_id']) ) { $switch_score += 100; }  

// --------------------------------------------------------------------------------------------
switch ($switch_score) {
case 1010 :
case 1110 :
	charge_donnees_brutes ( $presentation_selection );
break;

case 110 :
	charge_donnees_brutes ( $user['pres_id'] );
break;

case 10 :
	$dbquery = $SDDMObj->query("
	SELECT pres_id 
	FROM ".$SqlTableListObj->getSQLTableName('theme_presentation')." 
	WHERE theme_id = '".${$theme_tableau}['theme_id']."' 
	AND pres_defaut = '1'
	;");
// 	$dbquery = requete_sql( $_REQUEST['sql_initiateur'],"
// 	SELECT pres_id 
// 	FROM ".$SQL_tab['theme_presentation']." 
// 	WHERE theme_id = '".${$theme_tableau}['theme_id']."' 
// 	AND pres_defaut = '1'
// 	;");
	while ($dbp = fetch_array_sql($dbquery)) {
		charge_donnees_brutes ( $dbp['pres_id'] );
	}
break;
}
// $LMObj->logDebug($PL , "\$PL");

// --------------------------------------------------------------------------------------------
//$ms = $qd = $qs = 0;
// $LMObj->logDebug($module_tab_n_ , "\$module_tab_n_");
foreach ( $PL as $A )  {
	$m = $A['pres_module_nom'];
	switch ( $A['pres_type_calcul'] ) {
	case "0":
		$pres_[$m]['pres_espacement_bord_gauche']	= $A['pres_espacement_bord_gauche'];
		$pres_[$m]['pres_espacement_bord_droite']	= $A['pres_espacement_bord_droite'];
		$pres_[$m]['pres_espacement_bord_haut']	= $A['pres_espacement_bord_haut'];
		$pres_[$m]['pres_espacement_bord_bas']	= $A['pres_espacement_bord_bas'];

		$pres_[$m]['px']	= $A['pres_position_x'] + $pres_[$m]['pres_espacement_bord_gauche'];
		$pres_[$m]['py']	= $A['pres_position_y'] + $pres_[$m]['pres_espacement_bord_droite'];
		$pres_[$m]['dx']	= $A['pres_dimenssion_x'] - $pres_[$m]['pres_espacement_bord_gauche'] - $pres_[$m]['pres_espacement_bord_droite'];
		$pres_[$m]['dy']	= $A['pres_dimenssion_y'] - $pres_[$m]['pres_espacement_bord_haut'] - $pres_[$m]['pres_espacement_bord_bas'];

		$pres_[$m]['cpx']	= $A['pres_position_x'];
		$pres_[$m]['cpy']	= $A['pres_position_y'];
		$pres_[$m]['cdx']	= $A['pres_dimenssion_x'];
		$pres_[$m]['cdy']	= $A['pres_dimenssion_y'];
	break;

	case "1":
		$pres_[$m]['pres_espacement_bord_gauche']	= $A['pres_espacement_bord_gauche'];
		$pres_[$m]['pres_espacement_bord_droite']	= $A['pres_espacement_bord_droite'];
		$pres_[$m]['pres_espacement_bord_haut']	= $A['pres_espacement_bord_haut'];
		$pres_[$m]['pres_espacement_bord_bas']	= $A['pres_espacement_bord_bas'];

		$pres_[$m]['cdx']	= $A['pres_dimenssion_x'];
		$pres_[$m]['cdy']	= $A['pres_dimenssion_y'];

		$dynamic_['note'] = 0;
		if ( strlen($A['pres_module_ancre_e10']) > 0 ) { $dynamic_['note'] += 1; }
		if ( strlen($A['pres_module_ancre_e20']) > 0 ) { $dynamic_['note'] += 2; }
		if ( strlen($A['pres_module_ancre_e30']) > 0 ) { $dynamic_['note'] += 4; }

		switch ( $dynamic_['note'] ) {
		case "0":		break;

		case "1":
		case "2":
		case "4":
			calcul_1_ancre_prepare_tableau_source ( $A['pres_module_ancre_e10'] , "x" );
			$dynamic_['note_2'] = ( $A['pres_ancre_ex10'] - 1 ) + ( ( $A['pres_ancre_dx10'] - 1 ) * 3 );
			calcul_1_ancre ( $dynamic_['note_2'] , $m , "x" );

			calcul_1_ancre_prepare_tableau_source ( $A['pres_module_ancre_e10'] , "y" );
			$dynamic_['note_2'] = ( $A['pres_ancre_ey10'] - 1 ) + ( ( $A['pres_ancre_dy10'] - 1 ) * 3 );
			calcul_1_ancre ( $dynamic_['note_2'] , $m , "y" );

			$pres_[$m]['px']	= $pres_[$m]['cpx'] + $pres_[$m]['pres_espacement_bord_gauche'];
			$pres_[$m]['py']	= $pres_[$m]['cpy'] + $pres_[$m]['pres_espacement_bord_haut'];
			$pres_[$m]['dx']	= $pres_[$m]['cdx'] - $pres_[$m]['pres_espacement_bord_gauche'] - $pres_[$m]['pres_espacement_bord_droite']; 
			$pres_[$m]['dy']	= $pres_[$m]['cdy'] - $pres_[$m]['pres_espacement_bord_haut'] - $pres_[$m]['pres_espacement_bord_bas'];
 		break;

		//2 ancres
		case "3":
		case "5":
		case "6":
			if ( strlen($A['pres_module_ancre_e10']) > 0 ) {
				trouve_ancre_source ( $A['pres_module_ancre_e10'] , $A['pres_ancre_ex10'] , $A['pres_ancre_ey10'] ); 
				switch ( $A['pres_ancre_dx10'] ) {
				case "1":	aligne_x1x3();	break;
				case "2":	aligne_x2x4();	break;
				}
				switch ( $A['pres_ancre_dy10'] ) {
				case "1":	aligne_y1y2();	break;
				case "2":	aligne_y3y4();	break;
				}
			}
			if ( strlen($A['pres_module_ancre_e20']) > 0 ) {
				trouve_ancre_source ( $A['pres_module_ancre_e20'] , $A['pres_ancre_ex20'] , $A['pres_ancre_ey20'] );
				switch ( $A['pres_ancre_dx20'] ) {
				case "1":	aligne_x1x3();	break;
				case "2":	aligne_x2x4();	break;
				}
				switch ( $A['pres_ancre_dy20'] ) {
				case "1":	aligne_y1y2();	break;
				case "2":	aligne_y3y4();	break;
				}
			}

			$pres_[$m]['cpx']	= $qd['x1'];
			$pres_[$m]['cpy']	= $qd['y1'];
			$pres_[$m]['px']	= $qd['x1'] + $pres_[$m]['pres_espacement_bord_gauche'];
			$pres_[$m]['py']	= $qd['y1'] + $pres_[$m]['pres_espacement_bord_haut'];

			if ( $pres_[$m]['cdx'] > 0 ) { $qd['x2'] = $qd['x4'] = $qd['x1'] + $pres_[$m]['cdx']; }
			if ( $pres_[$m]['cdy'] > 0 ) { $qd['y3'] = $qd['y4'] = $qd['y1'] + $pres_[$m]['cdy']; }

			$pres_[$m]['cdx']	= $qd['x2'] - $qd['x1']; 
			$pres_[$m]['cdy']	= $qd['y3'] - $qd['y1'];
			$pres_[$m]['dx']	= $qd['x2'] - $qd['x1'] - $pres_[$m]['pres_espacement_bord_gauche'] - $pres_[$m]['pres_espacement_bord_droite']; 
			$pres_[$m]['dy']	= $qd['y3'] - $qd['y1'] - $pres_[$m]['pres_espacement_bord_haut'] - $pres_[$m]['pres_espacement_bord_bas'];
		break;

		//3 ancres
		case "7":
			trouve_ancre_source ( $A['pres_module_ancre_e10'] , $A['pres_ancre_ex10'] , $A['pres_ancre_ey10'] ); 
			switch ( $A['pres_ancre_dx10'] ) {
			case "1":	aligne_x1x3();	break;
			case "2":	aligne_x2x4();	break;
			}
			switch ( $A['pres_ancre_dy10'] ) {
			case "1":	aligne_y1y2();	break;
			case "2":	aligne_y3y4();	break;
			}
			trouve_ancre_source ( $A['pres_module_ancre_e20'] , $A['pres_ancre_ex20'] , $A['pres_ancre_ey20'] ); 
			switch ( $A['pres_ancre_dx20'] ) {
			case "1":	aligne_x1x3();	break;
			case "2":	aligne_x2x4();	break;
			}
			switch ( $A['pres_ancre_dy20'] ) {
			case "1":	aligne_y1y2();	break;
			case "2":	aligne_y3y4();	break;
			}
			trouve_ancre_source ( $A['pres_module_ancre_e30'] , $A['pres_ancre_ex30'] , $A['pres_ancre_ey30'] ); 
			switch ( $A['pres_ancre_dx30'] ) {
			case "1":	aligne_x1x3();	break;
			case "2":	aligne_x2x4();	break;
			}
			switch ( $A['pres_ancre_dy30'] ) {
			case "1":	aligne_y1y2();	break;
			case "2":	aligne_y3y4();	break;
			}
			$pres_[$m]['cpx']	= $qd['x1'];
			$pres_[$m]['cpy']	= $qd['y1'];
			$pres_[$m]['px']	= $qd['x1'] + $pres_[$m]['pres_espacement_bord_gauche'];
			$pres_[$m]['py']	= $qd['y1'] + $pres_[$m]['pres_espacement_bord_haut'];

			if ( $pres_[$m]['cdx'] > 0 ) { $qd['x2'] = $qd['x4'] = $qd['x1'] + $pres_[$m]['cdx']; }
			if ( $pres_[$m]['cdy'] > 0 ) { $qd['y3'] = $qd['y4'] = $qd['y1'] + $pres_[$m]['cdy']; }

			$pres_[$m]['cdx']	= $qd['x2'] - $qd['x1']; 
			$pres_[$m]['cdy']	= $qd['y3'] - $qd['y1'];
			$pres_[$m]['dx']	= $qd['x2'] - $qd['x1'] - $pres_[$m]['pres_espacement_bord_gauche'] - $pres_[$m]['pres_espacement_bord_droite']; 
			$pres_[$m]['dy']	= $qd['y3'] - $qd['y1'] - $pres_[$m]['pres_espacement_bord_haut'] - $pres_[$m]['pres_espacement_bord_bas'];
		break;
		}
	break;
	
	}

	if ( $pres_[$m]['dx'] < $A['pres_minimum_x'] ) { 
		$pres_[$m]['dx'] = $A['pres_minimum_x']; 
		$pres_[$m]['cdx'] = $A['pres_minimum_x'] + $pres_[$m]['pres_espacement_bord_gauche'] + $pres_[$m]['pres_espacement_bord_droite']; 
	}
	if ( $pres_[$m]['dy'] < $A['pres_minimum_y'] ) { 
		$pres_[$m]['dy'] = $A['pres_minimum_y'];
		$pres_[$m]['cdy'] = $A['pres_minimum_y'] + $pres_[$m]['pres_espacement_bord_haut'] + $pres_[$m]['pres_espacement_bord_bas'];
	}
	$pres_[$m]['pres_module_zindex'] = $A['pres_module_zindex'];
// 	$LMObj->logDebug( $pres_[$m] , "\$pres_[".$m."]");
	
}

$_REQUEST['document_dx'] = 100;
$_REQUEST['document_dy'] = 100;
unset ( $A );
foreach ( $module_tab_ as $A ) { 
	if ( $A['module_adm_control'] == 0 ) {
		$m = &$pres_[$A['module_nom']];
		$pv['doc_max_x'] = ( $m['cpx'] + $m['cdx'] );	if ( $pv['doc_max_x'] > $_REQUEST['document_dx'] ) { $_REQUEST['document_dx'] = $pv['doc_max_x']; } 
		$pv['doc_max_y'] = ( $m['cpy'] + $m['cdy'] );	if ( $pv['doc_max_y'] > $_REQUEST['document_dy'] ) { $_REQUEST['document_dy'] = $pv['doc_max_y']; } 
// 		$LMObj->logDebug( $pres_[$A['module_nom']] , "\$pres_[".$A['module_nom']."]");
	}
}

// $LMObj->logDebug($PL, "\$PL");
// $LMObj->logDebug($pres_, "\$pres_(FINAL)");

//echo (print_r_html($pres_));
if ( $WebSiteObj->getWebSiteEntry('sw_info_debug') < 10 ) {
	unset (
		$A,
		$B,
		$dbp,
		$dbquery,
		$dynamic_,
		$module_tab_n_,
		$ms,
		$presentation_selection,
		$qd,
		$qs,
		$switch_score,
		$txt_local_
	);
}
/*
		$PL,
*/
?>
