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

$localisation = " / charge_donnees_theme_tableau";
$_REQUEST['localisation'] .= $localisation;
statistique_checkpoint ("charge_donnees_theme_tableau");
$_REQUEST['localisation'] = substr ( $_REQUEST['localisation'] , 0 , (0 - strlen( $localisation )) );

while ($dbp = fetch_array_sql($dbquery)) { 
	foreach ( $dbp as $A => $B ) { ${$theme_tableau}[$A] = $B; } 
}
${$theme_tableau}['theme_date']		= date ("Y M d - H:i:s",$dbp['theme_date']);

// --------------------------------------------------------------------------------------------
//	Routine spécifique a la gestion des decorations : inclure la decoration selectionnée
// --------------------------------------------------------------------------------------------
switch ( $pv['gestion_deco'] ) {
case 1:
	switch ( $_REQUEST['uni_gestion_des_decorations_p'] ) { 
	case 2:
		$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
		SELECT deco_type,deco_nom,deco_etat 
		FROM ".$SQL_tab_abrege['decoration']."  
		WHERE deco_ref_id = '".$_REQUEST['M_DECORA']['ref_id']."' 
		;");
		while ($dbp = fetch_array_sql($dbquery)) {
			foreach ( $dbp as $A => $B ) { $DEC[$A] = $B; } 
		}
		switch ( $DEC['deco_type'] ) {
		case 10:	${$theme_tableau}['theme_bloc_01_menu']		= $DEC['deco_nom'];	break;
		case 20:	${$theme_tableau}['theme_bloc_02_texte']	= $DEC['deco_nom'];	break;
		case 30:	${$theme_tableau}['theme_bloc_03_nom']		= $DEC['deco_nom'];	break;
		case 40:	${$theme_tableau}['theme_bloc_04_nom']		= $DEC['deco_nom'];	break;
		case 50:	${$theme_tableau}['theme_bloc_05_nom']		= $DEC['deco_nom'];	break;
		case 60:	${$theme_tableau}['theme_bloc_06_nom']		= $DEC['deco_nom'];	break;
		}
	break;
	case 3:
		$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
		SELECT deco_type,deco_nom,deco_etat 
		FROM ".$SQL_tab_abrege['decoration']."  
		WHERE deco_ref_id = '".$_REQUEST['M_DECORA']['ref_id']."' 
		;");
		while ($dbp = fetch_array_sql($dbquery)) {
			foreach ( $dbp as $A => $B ) { $DEC[$A] = $B; } 
		}
	break;
	}
}

$pv['sauve_M_DECORA'] = $_REQUEST['M_DECORA'];
unset ( $_REQUEST['M_DECORA'] );
$pv['restaure_M_DECORA'] = 1;

// --------------------------------------------------------------------------------------------
$_REQUEST['compteur_bloc'] = 0;
$_REQUEST['compteur_bloc_menu'] = 0;
$_REQUEST['compteur_bloc_drapeau'] = 0;

$tab_bgp['0'] = "";									$tab_bgp['1'] = "background-position: bottom left;";	$tab_bgp['2']  = "background-position: center left;";
$tab_bgp['4'] = "background-position: top right;";	$tab_bgp['5'] = "background-position: bottom right;";	$tab_bgp['6']  = "background-position: center right;";
$tab_bgp['8'] = "background-position: top center;";	$tab_bgp['9'] = "background-position: bottom center;";	$tab_bgp['10'] = "background-position: center center;";

$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
SELECT * 
FROM ".$SQL_tab_abrege['decoration']." 
;");
while ($dbp = fetch_array_sql($dbquery)) {
	$pv['deco_nom']									=	$dbp['deco_nom'];
	$pv['deco_ref_id']								=	$dbp['deco_ref_id'];
	$tab_decoration[$pv['deco_nom']]['deco_id']		=	$tab_decoration[$pv['deco_ref_id']]['deco_id']		=	$dbp['deco_id'];
	$tab_decoration[$pv['deco_nom']]['deco_type']	=	$tab_decoration[$pv['deco_ref_id']]['deco_type']	=	$dbp['deco_type'];
}

unset ( $pv['bloc_deja_charge'] );
$pv['bloc_deja_charge'] = array();
// --------------------------------------------------------------------------------------------
for ( $pv['i'] = 1 ; $pv['i'] <= 30 ; $pv['i']++ ) {
	$_REQUEST['bloc'] = decoration_nomage_bloc ( "", $pv['i'] , "");
	$_REQUEST['blocG'] = "B" . $_REQUEST['bloc'] . "G";
	$_REQUEST['blocT'] = "B" . $_REQUEST['bloc'] . "T";

	$pv['bloc_en_cours']['nom'] = ${$theme_tableau}['theme_bloc_'.$_REQUEST['bloc'].'_nom'];

	if ( strlen($pv['bloc_en_cours']['nom']) > 0 ) {
		$pv['becn'] = $pv['bloc_en_cours']['nom'];
		$pv['bloc_en_cours']['deco_type']	= $tab_decoration[$pv['becn']]['deco_type'];
		$pv['bloc_en_cours']['deco_id']		= $tab_decoration[$pv['becn']]['deco_id'];

		$pv['bdcec'] = &$pv['bloc_deja_charge'][$pv['bloc_en_cours']['deco_type']][$pv['bloc_en_cours']['deco_id']];
		if ( !isset( $pv['bdcec'] ) ) {
			$pv['bdcec'] = $_REQUEST['blocG'];
			switch ( $pv['bloc_en_cours']['deco_type'] ) {
			case 30:	case "1_div":		include ("charge_donnees_theme_tableau-deco_30_1_div.php");		CDS_traitement_couleurs();		break;
			case 40:	case "elegance":	include ("charge_donnees_theme_tableau-deco_40_elegance.php");	break;
			case 50:	case "exquise":		include ("charge_donnees_theme_tableau-deco_50_exquise.php");	break;
			case 60:	case "elysion":		include ("charge_donnees_theme_tableau-deco_60_elysion.php");	break;
			}
		}
		else {
			${$theme_tableau}[$pv['bdcec']]['liste_doublon'] .= " " . $_REQUEST['blocG'];
			${$theme_tableau}[$pv['bdcec']]['liste_bloc'] .= " B" . $_REQUEST['bloc'];
			${$theme_tableau}[$_REQUEST['blocG']] = &${$theme_tableau}[$pv['bdcec']];
		}
	}

	$pv['bloc_en_cours']['nom'] = ${$theme_tableau}['theme_bloc_'.$_REQUEST['bloc'].'_texte'];
	if ( strlen($pv['bloc_en_cours']['nom']) > 0 ) {
		$pv['becn'] = $pv['bloc_en_cours']['nom'];
		$pv['bloc_en_cours']['deco_type']	= $tab_decoration[$pv['becn']]['deco_type'];
		$pv['bloc_en_cours']['deco_id']		= $tab_decoration[$pv['becn']]['deco_id'];

		$pv['bdcec'] = &$pv['bloc_deja_charge'][$pv['bloc_en_cours']['deco_type']][$pv['bloc_en_cours']['deco_id']];
		if ( !isset( $pv['bdcec'] ) ) {
			$pv['bdcec'] = $_REQUEST['blocT'];
			switch ( $pv['bloc_en_cours']['deco_type'] ) {
			case 20:	case "caligraphe":	include ("charge_donnees_theme_tableau-deco_20_caligraphe.php");			break;
			default:																									break;
			}
			CDS_traitement_couleurs();
		}
		else {
			${$theme_tableau}[$pv['bdcec']]['liste_doublon'] .= " " . $_REQUEST['blocT'];
			${$theme_tableau}[$pv['bdcec']]['liste_bloc'] .= " B" . $_REQUEST['bloc'];
			${$theme_tableau}[$_REQUEST['blocT']] = &${$theme_tableau}[$pv['bdcec']];
		}
	}

	if ( $_REQUEST['compteur_bloc_drapeau'] == 1 ) { 
		$_REQUEST['compteur_bloc']++; 
		$_REQUEST['compteur_bloc_mumero'][$_REQUEST['compteur_bloc']] = $pv['i'];
		$_REQUEST['compteur_bloc_drapeau'] = 0; 
	}
}

// --------------------------------------------------------------------------------------------
//
//	Les blocs menu
//
// --------------------------------------------------------------------------------------------

unset ( $pv['bloc_deja_charge'] );
$pv['bloc_deja_charge'] = array();

for ( $pv['i'] = 0 ; $pv['i'] <= 9 ; $pv['i']++ ) {
	$_REQUEST['bloc'] = decoration_nomage_bloc ( "", $pv['i'] , "");
	$pv['bloc_en_cours']['nom'] = ${$theme_tableau}["theme_bloc_".$_REQUEST['bloc']."_menu"];
	if ( strlen($pv['bloc_en_cours']['nom']) > 0 ) {
		$_REQUEST['blocM'] = "B" . $_REQUEST['bloc'] . "M";
		$pv['becn'] = &$pv['bloc_en_cours']['nom'];
		$pv['bloc_en_cours']['deco_id']		= $tab_decoration[$pv['becn']]['deco_id'];

		$pv['bdcec'] = &$pv['bloc_deja_charge']['10'][$pv['bloc_en_cours']['deco_id']];
		if ( !isset( $pv['bdcec'] ) ) {
			$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
			SELECT * 
			FROM ".$SQL_tab_abrege['deco_10_menu']." 
			WHERE deco_id = '".$pv['bloc_en_cours']['deco_id']."'
			;");
			$p = &${$theme_tableau}[$_REQUEST['blocM']];

			unset ( $A );
			while ($dbp = fetch_array_sql($dbquery)) { $p['deco_'.$dbp['deco_variable']] = $dbp['deco_valeur']; }

			$p['niveau'] = sprintf("%01u", $pv['i'] );
			$pv['bdcec'] = $_REQUEST['blocT'] = $_REQUEST['blocG'] = $_REQUEST['blocM'];

			$pv['bloc_en_cours']['deco_id'] = $tab_decoration[$p['deco_texte']]['deco_id'];
			$p['deco_type'] = $pv['bloc_en_cours']['deco_type'] = $tab_decoration[$p['deco_texte']]['deco_type'];
			include ("charge_donnees_theme_tableau-deco_20_caligraphe.php");

// --------------------------------------------------------------------------------------------
//	bloc de code identique sur charge_donnes_theme_tableau.php et charge_donnees_theme_stylesheet-deco_20_caligraphe.php
			$pv['fonte_plage']	= $p['deco_txt_fonte_size_max'] - $p['deco_txt_fonte_size_min'];
			$pv['fonte_coef']	= $pv['fonte_plage'] / 6;
			$pv['fonte_depart']	= $p['deco_txt_fonte_size_min'];
			$pv['taille_liens'] = floor ( $pv['fonte_depart'] + ( $pv['fonte_coef'] * 2 ) );			// Equivalent T3

			if ( $p['deco_txt_l_01_size'] == 0 )		{ $p['deco_txt_l_01_size'] = $pv['taille_liens']; }
			if ( $p['deco_txt_l_01_hover_size'] == 0 )	{ $p['deco_txt_l_01_hover_size'] = $pv['taille_liens']; }
			if ( $p['deco_txt_l_td_size'] == 0 )		{ $p['deco_txt_l_td_size'] = $pv['taille_liens']; }
			if ( $p['deco_txt_l_td_hover_size'] == 0 )	{ $p['deco_txt_l_td_hover_size'] = $pv['taille_liens']; }

			$pv['bloc_en_cours']['deco_id'] = $tab_decoration[$p['deco_graphique']]['deco_id'];
			$p['deco_type'] = $pv['bloc_en_cours']['deco_type'] = $tab_decoration[$p['deco_graphique']]['deco_type'];
			switch ( $pv['bloc_en_cours']['deco_type'] ) {
			case 30:	case "1_div":		include ("charge_donnees_theme_tableau-deco_30_1_div.php");		break;
			case 40:	case "elegance":	include ("charge_donnees_theme_tableau-deco_40_elegance.php");	break;
			case 50:	case "exquise":		include ("charge_donnees_theme_tableau-deco_50_exquise.php");	break;
			case 60:	case "elysion":		include ("charge_donnees_theme_tableau-deco_60_elysion.php");	break;
			}

			$_REQUEST['compteur_bloc_menu']++;
			$_REQUEST['compteur_bloc_menu_mumero'][$_REQUEST['compteur_bloc']] = $pv['i'];
			$_REQUEST['compteur_bloc_drapeau'] = 0; 

			$_REQUEST['Bloc_a_traiter_couleur'] = &${$theme_tableau}[$_REQUEST['blocM']];
			CDS_traitement_couleurs();
		}
		else {
			${$theme_tableau}[$pv['bdcec']]['liste_doublon'] .= $_REQUEST['blocM'] . " ";
			${$theme_tableau}[$pv['bdcec']]['liste_niveaux'] .= $pv['i'] . " ";
			${$theme_tableau}[$_REQUEST['blocM']] = &${$theme_tableau}[$pv['bdcec']];
		}
		${$theme_tableau}[$pv['bdcec']]['liste_bloc_menu'] .= $_REQUEST['blocM'] . " ";
	}
}
//$DEC,
if ( $pv['restaure_M_DECORA'] == 1) { 
	unset ( $_REQUEST['M_DECORA'] );
	$_REQUEST['M_DECORA'] = $pv['sauve_M_DECORA'];
}

unset (
	$A, $B , $AA , $BB,
	$dbp,
	$dbquery,
	$tab_bgp,
	$tab_decoration,
	$p,
	$_REQUEST['Bloc_a_traiter_couleur'],
	$pv
);

// --------------------------------------------------------------------------------------------
${$theme_tableau}['tab_std_rules'] = " style='table-layout: auto; border-spacing: 1px; empty-cells: show; vertical-align: top;' ";

?>
