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

$_REQUEST['sql_initiateur'] = "Forge de commande update website";
$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
SELECT * FROM ".$SQL_tab_abrege['langues']." 
;");
while ($dbp = fetch_array_sql($dbquery)) {
	$pv['idx'] = $dbp['langue_id'];
	foreach ( $dbp as $A => $B ) { $langues[$pv['idx']][$A] = $B; }
}
$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
SELECT sl.lang_id FROM ".$SQL_tab_abrege['site_langue']." sl , ".$SQL_tab_abrege['site_web']." s 
WHERE s.sw_id ='".$WebSiteObj->getWebSiteEntry('sw_id')."'
AND sl.site_id = s.sw_id
;");
while ($dbp = fetch_array_sql($dbquery)) { $langues[$dbp['lang_id']]['support'] = 1; }

foreach ( $langues as $A ) {
	if ( !isset($_REQUEST['M_SITWEB']['ajout_lang'][$A['langue_id']]) ) { $_REQUEST['M_SITWEB']['ajout_lang'][$A['langue_id']] = "off"; }
}

foreach ( $_REQUEST['M_SITWEB']['ajout_lang'] as $A => $B ) {
	$pv['etat'] = $langues[$A]['support'];
	$pv['form'] = 0;
	if ( $B == "on" ) { $pv['form'] = 2; }
	$pv['action'] = ( $pv['etat'] + $pv['form'] );

	switch ( $pv['action'] ) {
	case 0:	break;
	case 1:	$ligne++; $tampon_commande_buffer[$ligne] = "update site name \"".$_REQUEST['site_context']['site_nom']."\" del_lang \"".$langues[$A]['langue_639_3']."\"\n";	break;
	case 2:	$ligne++; $tampon_commande_buffer[$ligne] = "update site name \"".$_REQUEST['site_context']['site_nom']."\" add_lang \"".$langues[$A]['langue_639_3']."\"\n";	break;
	case 3:	break;
	}
}

$ligne++;
$tampon_commande_buffer[$ligne] = "update site name \"".$_REQUEST['site_context']['site_nom']. "\"	";
if ( isset($_REQUEST['M_SITWEB']['etat']))			{ $tampon_commande_buffer[$ligne] .= "state					\"".$_REQUEST['M_SITWEB']['etat'].			"\"	\n";}
if ( isset($_REQUEST['M_SITWEB']['lang']) )			{ $tampon_commande_buffer[$ligne] .= "lang					\"".$_REQUEST['M_SITWEB']['lang'].			"\"	\n";}
if ( isset($_REQUEST['M_SITWEB']['lang_select']) )	{ $tampon_commande_buffer[$ligne] .= "lang_select			\"".$_REQUEST['M_SITWEB']['lang_select'].	"\"	\n";}
if ( isset($_REQUEST['M_SITWEB']['theme']) )		{ $tampon_commande_buffer[$ligne] .= "theme					\"".$_REQUEST['M_SITWEB']['theme'].			"\"	\n";}
if ( isset($_REQUEST['M_SITWEB']['info_debug']) )	{ $tampon_commande_buffer[$ligne] .= "debug_info_level		\"".$_REQUEST['M_SITWEB']['info_debug'].		"\"	\n";}
if ( isset($_REQUEST['M_SITWEB']['stylesheet']) )	{ $tampon_commande_buffer[$ligne] .= "stylesheet			\"".$_REQUEST['M_SITWEB']['stylesheet'].		"\"	\n";}
if ( isset($_REQUEST['M_SITWEB']['gal_mode']) )		{ $tampon_commande_buffer[$ligne] .= "gal_mode				\"".$_REQUEST['M_SITWEB']['gal_mode'].		"\"	\n";}
if ( isset($_REQUEST['M_SITWEB']['ma_diff']) )		{ $tampon_commande_buffer[$ligne] .= "ma_diff				\"".$_REQUEST['M_SITWEB']['ma_diff'].		"\"	\n";}
if ( isset($_REQUEST['M_SITWEB']['directory']) )	{ $tampon_commande_buffer[$ligne] .= "directory				\"".$_REQUEST['M_SITWEB']['repertoire'].		"\"	\n";}

//		if ( strlen($_REQUEST['M_SITWEB']['nom']) > 0 )		{ $tampon_commande_buffer[$ligne] .= "	nom				\"".$_REQUEST['M_SITWEB']['nom']."\"\n"; }
if ( strlen($_REQUEST['M_SITWEB']['abrege']) > 0 )			{ $tampon_commande_buffer[$ligne] .= "abrege			\"".$_REQUEST['M_SITWEB']['abrege']."	\"\n"; }
if ( strlen($_REQUEST['M_SITWEB']['titre']) > 0 )			{ $tampon_commande_buffer[$ligne] .= "title				\"".$_REQUEST['M_SITWEB']['titre']."	\"\n"; }
if ( strlen($_REQUEST['M_SITWEB']['barre_status']) > 0 )	{ $tampon_commande_buffer[$ligne] .= "barre_status		\"".$_REQUEST['M_SITWEB']['barre_status']."	\"\n"; }
if ( strlen($_REQUEST['M_SITWEB']['home']) > 0 )			{ $tampon_commande_buffer[$ligne] .= "home				\"".$_REQUEST['M_SITWEB']['home']."	\"\n"; }
if ( strlen($_REQUEST['M_SITWEB']['aide_dynamique']) > 0 )	{ $tampon_commande_buffer[$ligne] .= "dynamic_help		\"".$_REQUEST['M_SITWEB']['aide_dynamique']."	\"\n"; }
if ( strlen($_REQUEST['M_SITWEB']['gal_fichier_tag']) > 0 )	{ $tampon_commande_buffer[$ligne] .= "gal_fichier_tag	\"".$_REQUEST['M_SITWEB']['gal_fichier_tag']."	\"\n"; }
if ( strlen($_REQUEST['M_SITWEB']['gal_qualite']) > 0 )		{ $tampon_commande_buffer[$ligne] .= "gal_qualite		\"".$_REQUEST['M_SITWEB']['gal_qualite']."	\"\n"; }
if ( strlen($_REQUEST['M_SITWEB']['gal_x']) > 0 )			{ $tampon_commande_buffer[$ligne] .= "gal_x				\"".$_REQUEST['M_SITWEB']['gal_x']."	\"\n"; }
if ( strlen($_REQUEST['M_SITWEB']['gal_y']) > 0 )			{ $tampon_commande_buffer[$ligne] .= "gal_y				\"".$_REQUEST['M_SITWEB']['gal_y']."	\"\n"; }
if ( strlen($_REQUEST['M_SITWEB']['gal_liserai']) > 0 )		{ $tampon_commande_buffer[$ligne] .= "gal_liserai		\"".$_REQUEST['M_SITWEB']['gal_liserai']."	\"\n"; }

//echo ("<!--\n" . print_r_debug ($tampon_commande_buffer) . "\n-->");

?>
