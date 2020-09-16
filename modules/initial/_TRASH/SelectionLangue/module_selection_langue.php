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

$localisation = " / module_selection_langue";
$MapperObj->AddAnotherLevel($localisation );
$LMObj->logCheckpoint("module_selection_langue");
$MapperObj->RemoveThisLevel($localisation );
$MapperObj->setSqlApplicant("module_selection_langue");

$_REQUEST['localisation'] .= $localisation;
// statistique_checkpoint ("fonctions_universelles");
$_REQUEST['localisation'] = substr ( $_REQUEST['localisation'] , 0 , (0 - strlen( $localisation )) );

$_REQUEST['sql_initiateur'] = "Selection langue"; 

if ( $WebSiteObj->getWebSiteEntry('sw_lang_select') == 1 ) {
	$dbquery = requete_sql($_REQUEST['sql_initiateur'],"SELECT * FROM ".$SQL_tab['langues'].";");
	$pv['1'] = 1;
	while ($dbp = fetch_array_sql($dbquery)) {
		$site_lang_[$pv['1']]['langue_id']				= $dbp['langue_id'];
		$site_lang_[$pv['1']]['langue_639_3']			= $dbp['langue_639_3'];
		$site_lang_[$pv['1']]['langue_image']			= $dbp['langue_image'];
		$site_lang_[$pv['1']]['langue_nom_original']	= $dbp['langue_nom_original'];
		$pv['1']++;
	}

	unset ( $site_lang_support );
	$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
	SELECT b.langue_id 
	FROM ".$SQL_tab['site_langue']." a, ".$SQL_tab['langues']." b 
	WHERE a.site_id = '".$WebSiteObj->getWebSiteEntry('sw_id')."' 
	AND a.lang_id = b.langue_id
	;");

	if ( num_row_sql($dbquery) > 1 ) {
		while ($dbp = fetch_array_sql($dbquery)) {
			$pv['offset'] = $dbp['langue_id'];
			$site_lang_support[$pv['offset']] = $pv['offset'];
		}
		foreach ( $site_lang_support as $A ) {
			if ( $A == $site_lang_[$A]['langue_id'] && $A != $user['lang'] ) {
				$pv['1'] = $WebSiteObj->getWebSiteEntry('sw_lang');
				$pv['1'] = $site_lang_[$pv['offset']][$pv['1']];
				if ( !file_exists ( "../graph/".${$theme_tableau}['theme_repertoire']."/".$site_lang_[$A]['langue_image'] ) ) { $pv['img_src'] = "../graph/universel/".$site_lang_[$A]['langue_image']; }
				else { $pv['img_src'] = "../graph/".${$theme_tableau}['theme_repertoire']."/".$site_lang_[$A]['langue_image']; }
				echo ("
	<a class='".$theme_tableau."s0".$function_parametres['module_deco_nbr']."_a_t2' 
	href='index.php?".$bloc_html['url_sdup']."&amp;M_UTILIS[login]=".$user['login_decode']."&amp;M_UTILIS[lang]=".$site_lang_[$A]['langue_639_3']."&amp;UPDATE_action=UPDATE_USER&amp;M_UTILIS[confirmation_modification]=1' 
	onMouseOver=\"Bulle('".$site_lang_[$A]['langue_nom_original']."')\" 
	onMouseOut='Bulle()' 
	>
	<img src='".$pv['img_src']."' alt='".$site_lang_[$A]['langue_639_3']."' height='64' width='64' border='0'>
	</a>\r");
			}
		}
	}
	if ( $WebSiteObj->getWebSiteEntry('sw_info_debug') < 10 ) { 
		unset ( 
			$site_lang_support, 
			$site_lang_ , 
			$pv 
		);
	}
}

?>
