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

$_REQUEST['liste_colonne']['tag'] = array (
"tag_id",
"tag_nom",
"tag_html",
"tag_site"
);

$_REQUEST['liste_colonne']['tag_reference'] = array (
"id",
"nom",
"html",
"filtre",
"site"
);

function initialisation_valeurs_tag () {
	$R = &$_REQUEST['M_TAG'];
	$R['id']		= "";
	$R['nom']		= "";
	$R['tag']		= "";
	$R['html']		= "";
	$R['filtre']	= "";
	$R['site']		= $_REQUEST['site_context']['site_id'];

	$R['name']		= &$R['nom'];
	$R['site_id']	= &$R['site'];
	$R['filter']	= &$R['filtre'];

	$R['article']		= "";
	$R['article_nom']	= &$R['article'];
	$R['article_name']	= &$R['article'];

	reset ( $_REQUEST['liste_colonne']['tag_reference'] );
	foreach ( $_REQUEST['liste_colonne']['tag_reference'] as $A ) { $R['tag_'.$A] = &$R[$A]; }
}

function chargement_valeurs_tag () {
// 	$SqlTableListObj = SqlTableList::getInstance(null, null);
	global $SQL_tab , $SQL_tab_abrege;
 	$R = &$_REQUEST['M_TAG'];

	$tl_['eng']['log_init'] = "Loading tag datas";
	$tl_['fra']['log_init'] = "Chargement valeurs du tag";

	$l = $_REQUEST['site_context']['site_lang'];
	$_REQUEST['sql_initiateur'] = $tl_[$l]['log_init'];

	$_REQUEST['sru_ERR']  = &$R['ERR'];
	systeme_requete_unifiee ( 2 , "M_TAG_ret" , $R['tag_nom'] , 0 , "CVT_0001" , $R['tag_id'] );

	if ( $R['ERR'] != 1 ) {
		$dbquery = requete_sql($_REQUEST['sql_initiateur'] ,"
		SELECT * 
		FROM ".$SQL_tab_abrege['tag']." 
		WHERE tag_id = '".$R['tag_id']."' 
		;");
		unset ( $A , $B );
		while ($dbp = fetch_array_sql($dbquery)) { 
			foreach ( $dbp as $A => $B ) { $R[$A] = $B; }
		}
	}
}

?>
