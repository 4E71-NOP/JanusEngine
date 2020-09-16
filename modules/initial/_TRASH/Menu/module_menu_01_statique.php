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
$localisation = " / module_menu_01_statique";
$MapperObj->AddAnotherLevel($localisation );
$LMObj->logCheckpoint("module_menu_01_statique");
$MapperObj->RemoveThisLevel($localisation );
$MapperObj->setSqlApplicant("module_menu_01_statique");

$_REQUEST['localisation'] .= $localisation;
// statistique_checkpoint ("module_menu_01_statique");
$_REQUEST['localisation'] = substr ( $_REQUEST['localisation'] , 0 , (0 - strlen( $localisation )) );


//	Menu style 03
$_REQUEST['sql_initiateur'] = "Menu style 03";
// --------------------------------------------------------------------------------------------
$pv['bloc'] = "B" . sprintf("%02u",($module_['module_deco_nbr']));

if ( !function_exists("menu_affichage_statique")) {
	function menu_affichage_statique () {
		global $module_, $theme_tableau, ${$theme_tableau}, $bloc_html, $db_, $menu_principal, $function_parametres, $tl_, $l, $pv, $theme_tableau;
		foreach ( $menu_principal as $A ) {
			if ($A['cate_parent'] == $function_parametres['cate_parent'] ) {
				if ( $A['arti_ref'] == "0" ) {
					echo ("<li><a  class='" . $theme_tableau.$_REQUEST['bloc']."_lien ".$theme_tableau.$_REQUEST['bloc']."_tb3' href=\"#\">".$A['cate_titre']."</a>\r<ul style='padding-left: 5px; list-style: none;'>\r");
					$function_parametres_save = $function_parametres['cate_parent'];
					$function_parametres['cate_parent'] = $A['cate_id'];
					menu_affichage_statique ();
					$function_parametres['cate_parent'] = $function_parametres_save;
					echo ("</ul>\r</li>\r");
				}
				elseif ( $A['arti_ref'] == $function_parametres['arti_request'] ) {
					echo ("<li><a  class='" . $theme_tableau.$_REQUEST['bloc']."_lien ".$theme_tableau.$_REQUEST['bloc']."_t3' href=\"#\">".$A['cate_titre']."</a></li>\r");
				}
				else {
					echo ("<li>	<a  class='" . $theme_tableau.$_REQUEST['bloc']."_lien ".$theme_tableau.$_REQUEST['bloc']."_t3' href=\"index.php?arti_ref=".$A['arti_ref']."&amp;arti_page=1".$bloc_html['url_slup']."\">".$A['cate_titre']."</a></li>\r");	
				}
			}
		}
	}
}

// --------------------------------------------------------------------------------------------
//	Un seule requete pour recuperer toutes les informations necessaires au traitement
// --------------------------------------------------------------------------------------------
$dbquery = requete_sql($_REQUEST['sql_initiateur'], $module_menu_requete );
echo ("<ul id='Admin_Menu_' style='padding-left: 0px; margin-left: 0px; list-style: none;'>\r");
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

	$function_parametres = array (
		"arti_request"	=> $affdoc_arti_ref,
		"cate_parent" 	=> $racine_menu,
		"espacement" 	=> 0
	);
	menu_affichage_statique ();
} 
echo ("
</ul>
");

if ( $WebSiteObj->getWebSiteEntry('sw_info_debug') < 10 ) {
	unset (
		$menu_principal , 
		$function_parametres , 
		$dbquery , 
		$dbp,
		$pv
	);
}

?>
