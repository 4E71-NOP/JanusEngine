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

$localisation = " / charge_donnees_theme";
$_REQUEST['localisation'] .= $localisation;
statistique_checkpoint ("charge_donnees_theme");
$_REQUEST['localisation'] = substr ( $_REQUEST['localisation'] , 0 , (0 - strlen( $localisation )) );

$tl_['eng']['si'] = "Load theme datas";
$tl_['fra']['si'] = "Charge les donnees du theme";
$l = $langues[$site_web['sw_lang']]['langue_639_3'];

$_REQUEST['sql_initiateur'] = $tl_[$l]['si'];
// --------------------------------------------------------------------------------------------
//	Determine le nom de la table pour charger les données dedans (modif user profile)
// --------------------------------------------------------------------------------------------
unset ( ${$theme_tableau}, $pv['bloc_deja_charge'] );

if ( $theme_tableau == "theme_princ_" ) {
	if ( $user['pref_theme'] != 0 ) { $Theme_actuel = $user['pref_theme']; }	// On prend par defaut le theme préféré par l'utilisateur
	else { $Theme_actuel = $site_web['theme_id']; }								// cas d'un probleme avec le theme préféré par l'utilisateur.
}
else { $Theme_actuel = $_REQUEST['theme_demande']; }							// C'est une visualisation dans un profil donc on prend le theme demandé

$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
SELECT * 
FROM ".$SQL_tab_abrege['theme_descripteur']." a , ".$SQL_tab_abrege['site_theme']." b 
WHERE a.theme_id = '".$Theme_actuel."' 
AND a.theme_id = b.theme_id 
AND b.theme_etat = '1' 
;");

// --------------------------------------------------------------------------------------------
//	Cas qui n'arrivera que si un admin fait une betise (murphy's law)
// --------------------------------------------------------------------------------------------
if ( num_row_sql($dbquery) == 0 ) {
	$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
	SELECT * 
	FROM ".$SQL_tab_abrege['theme_descripteur']." 
	WHERE theme_id = 2 
	;");
	$tl_['eng']['ok'] = $_REQUEST['sql_initiateur'] . " : Fallback sur theme 02.";
	$tl_['fra']['ok'] = $_REQUEST['sql_initiateur'] . " : Fallback on theme 02.";
	journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom'] . " : ".$_REQUEST['tampon_commande'] , "OK" , "CDT_1_0001" , $tl_[$l]['ok'] );

	if ( num_row_sql($dbquery) == 0 ) {
		$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
		SELECT * 
		FROM ".$SQL_tab_abrege['theme_descripteur']." 
		WHERE theme_id = 1 
		;");
		$tl_['eng']['ok'] = $_REQUEST['sql_initiateur'] . " : Fallback sur theme 01.";
		$tl_['fra']['ok'] = $_REQUEST['sql_initiateur'] . " : Fallback on theme 01.";
		journalisation_evenement ( 1 , $_REQUEST['sql_initiateur'] , $_REQUEST['site_context']['site_nom'] . " : ".$_REQUEST['tampon_commande'] , "OK" , "CDT_1_0001" , $tl_[$l]['ok'] );
	}
}

$theme_tableau_a_ecrire = "theme_princ_";
include ("routines/website/charge_donnees_theme_tableau.php");

// --------------------------------------------------------------------------------------------
//	Rend le stylesheet suivant la demande effectuée
// --------------------------------------------------------------------------------------------
//<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.01 Frameset//EN\"		\"http://www.w3.org/TR/html4/strict.dtd\">\r
//<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\"	\"http://www.w3.org/TR/html4/loose.dtd\">\r
//<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.01//EN\"				\"http://www.w3.org/TR/html4/strict.dtd\">\r
//<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.01 Frameset//EN\"		\"http://www.w3.org/TR/html4/frameset.dtd\">\r
//<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\"		\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\r
//<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\"	\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\r
//<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Frameset//EN\"		\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd\">\r
//<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.1//EN\" \"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd\">\r
//<!DOCTYPE html> (html5)
$pv['doc_type'] = "<!DOCTYPE html>\r";
echo ( $pv['doc_type']);

$html_body = "<body id='MWMbody' ";
if ( strlen ( ${$theme_tableau}['B01T']['deco_txt_col'] ) > 0 ) { $html_body .= "text='".${$theme_tableau}['B01T']['deco_txt_col']."' link='".${$theme_tableau}['B01T']['deco_txt_col']."' vlink='".${$theme_tableau}['B01T']['deco_txt_col']."' alink='".${$theme_tableau}['B01T']['deco_txt_col']."' "; } 
$html_body .= "style='";
if ( strlen ( ${$theme_tableau}['theme_bg'] ) > 0 ) { $html_body .= "background-image: url(../graph/".${$theme_tableau}['theme_repertoire']."/".${$theme_tableau}['theme_bg']."); background-repeat: ".${$theme_tableau}['theme_bg_repeat']."; "; }
if ( strlen ( ${$theme_tableau}['theme_bg_color'] ) > 0 ) { $html_body .= "background-color: #".${$theme_tableau}['theme_bg_color'].";"; } 
$html_body .= " visibility: hidden;'>\r ";

switch ( $site_web['sw_stylesheet'] ) {
case 1: // dynamique
	echo ("
	<html>\r
	<head>\r
	<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>\r
	<title>".$site_web['sw_titre']."</title>\r
	");

	include ("routines/website/charge_donnees_theme_stylesheet.php");
	echo ($stylesheet."
	</head>\r" . $html_body );
	unset (	$stylesheet );
break;
case 0: // statique
	echo ("
	<html>\r
	<head>\r
	<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>\r
	<title>".$site_web['sw_titre']."</title>\r
	");

	if ( strlen ( ${$theme_tableau}['theme_stylesheet_1'] ) > 0 ) { echo ("<link rel='stylesheet' type='text/css' href='../stylesheets/".${$theme_tableau}['theme_stylesheet_1']."' >\r"); }
	if ( strlen ( ${$theme_tableau}['theme_stylesheet_2'] ) > 0 ) { echo ("<link rel='stylesheet' type='text/css' href='../stylesheets/".${$theme_tableau}['theme_stylesheet_2']."' >\r"); }
	if ( strlen ( ${$theme_tableau}['theme_stylesheet_3'] ) > 0 ) { echo ("<link rel='stylesheet' type='text/css' href='../stylesheets/".${$theme_tableau}['theme_stylesheet_3']."' >\r"); }
	if ( strlen ( ${$theme_tableau}['theme_stylesheet_4'] ) > 0 ) { echo ("<link rel='stylesheet' type='text/css' href='../stylesheets/".${$theme_tableau}['theme_stylesheet_4']."' >\r"); }
	if ( strlen ( ${$theme_tableau}['theme_stylesheet_5'] ) > 0 ) { echo ("<link rel='stylesheet' type='text/css' href='../stylesheets/".${$theme_tableau}['theme_stylesheet_5']."' >\r"); }

	echo ("
	</head>\r" . $html_body );

	for ( $pv['n'] = 1 ; $pv['n'] <= $_REQUEST['compteur_bloc'] ; $pv['n']++ ) {
		$_REQUEST['bloc'] = decoration_nomage_bloc ( "B", $_REQUEST['compteur_bloc_mumero'][$pv['n']] , "");
		$_REQUEST['blocG'] = $_REQUEST['bloc'] . "G";
		$_REQUEST['blocT'] = $_REQUEST['bloc'] . "T";
		$pv['stae'] = $theme_tableau_a_ecrire . $_REQUEST['bloc'];

		if ( is_array( ${$theme_tableau}[$_REQUEST['blocT']] ) ) {
			${$theme_tableau}[$_REQUEST['blocT']]['ttd'] = "
			<table style='height:".${$theme_tableau}[$_REQUEST['blocT']]['deco_ft_y']."px;' border='0' cellspacing='0' cellpadding='0'>\r
			<tr>\r
			<td style='width:".${$theme_tableau}[$_REQUEST['blocT']]['deco_ft1_x']."px;	background-image: url(../graph/".${$theme_tableau}['theme_repertoire']."/".${$theme_tableau}[$_REQUEST['blocT']]['deco_ft1'].");'></td>\r
			<td style='background-image: url(../graph/".${$theme_tableau}['theme_repertoire']."/".${$theme_tableau}[$_REQUEST['blocT']]['deco_ft2'].");'>\r
			<span class='".$pv['stae']."_tb4' style='color:".${$theme_tableau}[$_REQUEST['blocT']]['deco_txt_titre_col'].";'>\r
			";

			${$theme_tableau}[$_REQUEST['blocT']]['ttf'] = "
			</span>\r
			</td>\r
			<td style='width:".${$theme_tableau}[$_REQUEST['blocT']]['deco_ft3_x']."px;	background-image: url(../graph/".${$theme_tableau}['theme_repertoire']."/".${$theme_tableau}[$_REQUEST['blocT']]['deco_ft3'].");'></td>\r
			</tr>\r
			</table>\r
			<br>\r
			";
		}
	}
break;
}

if ( $site_web['sw_info_debug'] < 10 ) {
	unset (
		$dbquery,
		$dbp,
		$handle,
		$html_body,
		$liste_css,
		$pv,
		$stylesheet,
		$stylesheet_entete
	);
}

?>
