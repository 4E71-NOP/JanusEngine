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
$localisation = " / module_menu_03_banner";
$MapperObj->AddAnotherLevel($localisation );
$LMObj->logCheckpoint("module_menu_03_banner");
$MapperObj->RemoveThisLevel($localisation );
$MapperObj->setSqlApplicant("module_menu_03_banner");

$_REQUEST['localisation'] .= $localisation;
// statistique_checkpoint ("module_menu_03_banner");
$_REQUEST['localisation'] = substr ( $_REQUEST['localisation'] , 0 , (0 - strlen( $localisation )) );

$_REQUEST['sql_initiateur'] = "Menu style banner";

if ( !function_exists("menu_tree_div")) {
	function menu_tree_div () {
		global $bloc_html, $menu_principal, $function_parametres, $theme_tableau, $pv;
		foreach ( $menu_principal as $A ) {
			if ( $A['cate_parent'] == $function_parametres['cate_parent'] ) {
				$pv['NbrMenuDuDossier']++;

				if ( $function_parametres['niveau_image'] != 0 ) { $img = "<img src='../graph/universel/vide.gif' alt'' width='".( ${$theme_tableau}['B01M']['txt_l_01_size'] * ($function_parametres['niveau_image']-1) )."' height='4' border='0'>"; }
				else { $img = ""; }
				$mji = &$pv['menu_JSON']['banner_'.$A['cate_id'].'_A'];
				if ( $function_parametres['niveau'] == 2 ) { $mjp = &$pv['menu_JSON']['banner_'.$A['cate_parent'].'_D']; }
				else { $mjp = &$pv['menu_JSON']['banner_'.$A['cate_parent'].'_A']; }

				$mji['id'] = "banner_" . $A['cate_id'] . "_A";
				//$mji['par'] = $mjp['id'];
				$mji['par'] = $function_parametres['Div_parent'];
				$mji['idNum'] = $A['cate_id'];
				$mji['niv'] = 1;
				$mji['dos'] = "0";
				$mji['typ'] = "a";
				$mji['width'] = ${$theme_tableau}['B01M']['deco_div_width'];

				$mjp['nf']++;
				$mjp['fils'][] = $mji['id'];

				$mji['SessionRecherche'] = $pv['NbrSessionRecherche'];
				$mji['entreeT'] = $img . $A['cate_titre'];
				$mji['entreeA'] = "<a id='".$mji['id']."' class='".$theme_tableau."menu_niv_1_lien' href=\"index.php?arti_ref=".$A['arti_ref']."&amp;arti_page=1".$bloc_html['url_slup']."\">";
				if ( $A['arti_ref'] == $function_parametres['arti_request'] ) { $mji['entreeA'] = "<a id='".$mji['id']."' class='".$theme_tableau."menu_niv_1_lien' href=\"#\">"; }

				if ( $A['arti_ref'] == "0" ) {
					$mji['entreeA'] = "<a id='".$mji['id']."' href=\"#\">";
					//$mji['dos'] = 1;

					$function_parametres['niveau_image']++;	//Niveau 3 (mini) &+
					$function_parametres_save = $function_parametres['cate_parent'];
					$function_parametres['cate_parent'] = $A['cate_id'];
					menu_tree_div ();
					$function_parametres['cate_parent'] = $function_parametres_save;
					$function_parametres['niveau_image']--;
				}
			}
		}
	}
}

// --------------------------------------------------------------------------------------------
//	Un seule requete pour recuperer toutes les informations necessaires au traitement
// --------------------------------------------------------------------------------------------
$dbquery = requete_sql($_REQUEST['sql_initiateur'], $module_menu_requete );
if ( num_row_sql($dbquery) == 0 ) { echo ("Pas de menu afficher."); }

else { 
	$pv['JSFxHoverMenuD'] = "onmouseover='this.style.backgroundImage = \"url(../graph/".${$theme_tableau}['B00M']['deco_repertoire']."/".${$theme_tableau}['B00M']['deco_tab_hover_b'].")\";' onmouseout='this.style.backgroundImage = \"url(../graph/".${$theme_tableau}['B00M']['deco_repertoire']."/".${$theme_tableau}['B00M']['deco_tab_up_b'].")\";'";
	$pv['JSFxHoverMenuA'] = "style='line-height: ".${$theme_tableau}['B00M']['deco_tab_y']."px;' onmouseover='this.parentNode.style.backgroundImage = \"url(../graph/".${$theme_tableau}['B00M']['deco_repertoire']."/".${$theme_tableau}['B00M']['deco_tab_hover_b'].")\";' onmouseout='this.parentNode.style.backgroundImage = \"url(../graph/".${$theme_tableau}['B00M']['deco_repertoire']."/".${$theme_tableau}['B00M']['deco_tab_up_b'].")\";'";

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
		"espacement" 	=> 0,
		"niveau"		=> 0,
		"niveau_image"	=> 1
	);

	foreach ( $menu_principal as $A ) {
		if ( $A['cate_parent'] == 0 ) {
			$pv['rendu']['root']['txt'] = $A['cate_titre'];
			$pv['rendu']['premier_niveau_parent'] = $A['cate_id'];
		}
	}
	unset ( $A );
	$mji = &$pv['menu_JSON']['banner_'.$pv['rendu']['premier_niveau_parent'].'_D'];
	$mji['par'] = "racine";
	$mji['id'] = "banner_" . $pv['rendu']['premier_niveau_parent'] ."_D";
 	$mji['niv'] = 0;
	$mji['dos'] = 0;
	$mji['typ'] = "div";
	$mji['anim'] = ${$theme_tableau}['B00M']['deco_anim'];
	$pv['AlignRef'] = $mji['id']; // Aligne les DIV sur cet element et non le pere naturel

	$pv['BarNbr'] = 0;
	$pv['LigneHauteur'] = ${$theme_tableau}['B01M']['deco_txt_l_01_size'] + ${$theme_tableau}['B01M']['deco_txt_l_01_margin_top'] + ${$theme_tableau}['B01M']['deco_txt_l_01_margin_bottom'] + 4;
	$pv['DivBannerHauteur'] = ${$theme_tableau}['B01M']['deco_div_height'];
	$pv['DivBannerNbrligne'] = floor ( $pv['DivBannerHauteur'] / $pv['LigneHauteur'] );
	$pv['NbrSessionRecherche'] = 1;
	foreach ( $menu_principal as $A ) {
		if ( $A['cate_parent'] == $pv['rendu']['premier_niveau_parent'] ) {
// Niveau 0 on crée le DIV qui va contenur le lien de niveau 0
			$mji = &$pv['menu_JSON']['banner_'.$A['cate_id'].'_B'];
			$mjp = &$pv['menu_JSON']['banner_'.$A['cate_parent'].'_D'];
			$mji['id'] = "banner_" . $A['cate_id'] ."_B";
			$mji['par'] = $mjp['id'];
			$mji['idNum'] = $A['cate_id'];
			$mji['niv'] = 0;
			$mji['dos'] = 0;
			$mji['typ'] = "div";
			$mji['entreeT'] = "";
			$mji['entreeA'] = ""; 
			$mjp['nf']++;
			$mjp['fils'][] = $mji['id'];


// Niveau 0 on crée le lien qui activera les DIV des niveaux suivant
			$mji = &$pv['menu_JSON']['banner_'.$A['cate_id'].'_A'];
			$mjp = &$pv['menu_JSON']['banner_'.$A['cate_id'].'_B'];
			$mji['id'] = "banner_" . $A['cate_id'] ."_A";
			$mji['par'] = $mjp['id'];
			$mji['idNum'] = $A['cate_id'];
			$mji['niv'] = 0;
			$mji['dos'] = 0;
			$mji['typ'] = "a";
			$mji['entreeT'] = $A['cate_titre'];
			$mji['entreeA'] = "<a id='".$mji['id']."' href='#'>"; 

			$mjp['nf']++;
			$mjp['fils'][] = $mji['id'];

			$pv['renduBar'][$pv['BarNbr']]['id'] = $mjp['id'];
			if ( $A['arti_ref'] != $function_parametres['arti_request'] ) { $pv['renduBar'][$pv['BarNbr']]['txt'] = "<a id='".$mji['id']."' class='".$theme_tableau."menu_niv_0_lien' href=\"index.php?arti_ref=".$A['arti_ref']."&amp;arti_page=1".$bloc_html['url_slup']."\" ".$pv['JSFxHoverMenuA'].">".$A['cate_titre']."</a>\r"; }
			else { 
				$pv['renduBar'][$pv['BarNbr']]['txt'] = "<a id='".$mji['id']."' class='" . $theme_tableau ."menu_niv_0_lien' style='line-height: ".${$theme_tableau}['B00M']['deco_tab_y']."px;' href='#'>".$A['cate_titre']."</a>\r"; 
				$pv['renduBar'][$pv['BarNbr']]['arti_ref'] = 1;
			}


			if ( $A['arti_ref'] == "0" ) {
// Niveau 0 on crée le DIV qui contiendra les liens
				$mji['dos'] = 1;
				$mji = &$pv['menu_JSON']['banner_'.$A['cate_id'].'_D'];
				$mjp = &$pv['menu_JSON']['banner_'.$A['cate_id'].'_A'];

				$mji['id'] = "banner_" . $A['cate_id'] ."_D";
				$mji['par'] = $mjp['id'];
				$mji['idNum'] = $A['cate_id'];
				$mji['niv'] = 1;
				$mji['dos'] = 1;
				$mji['typ'] = "div";
				$mji['dock_cible'] = ${$theme_tableau}['B01M']['deco_dock_cible'];
				$mji['dock_decal_x'] = ${$theme_tableau}['B01M']['deco_dock_decal_x'];
				$mji['dock_decal_y'] = ${$theme_tableau}['B01M']['deco_dock_decal_y'];
				$mji['anim'] = ${$theme_tableau}['B00M']['deco_anim'];
				$mji['width'] = ${$theme_tableau}['B00M']['deco_div_width'];

				$mjp['nf']++;
				$mjp['fils'][] = $mji['id'];

				$pv['renduBar'][$pv['BarNbr']]['txt'] = "<a id='".$mjp['id']."' class='" . $theme_tableau ."menu_niv_0_lien' href='#' ".$pv['JSFxHoverMenuA'].">".$A['cate_titre']."</a>\r";
				$function_parametres['cate_parent_premier'] = $function_parametres['cate_parent'] = $A['cate_id'];
				$pv['renduDiv'][$mji['id']] .= "<div id='".$mji['id']."' class='" . $theme_tableau ."menu_niv_1 ".$theme_tableau."B01M_1_div' style='visibility: hidden; display: block; z-index: ".($module_z_index['compteur']+3)."; width: ".${$theme_tableau}['B01M']['deco_div_width']."px; height: ".${$theme_tableau}['B01M']['deco_div_height']."px;'>\r";

				$pv['NbrMenuDuDossier'] = 1;
				//$function_parametres['niveau']++;				//Niveau 2 &+
				$function_parametres_save = $function_parametres['cate_parent'];
				$function_parametres['Div_parent'] = $mji['id'];
				$function_parametres['cate_parent'] = $A['cate_id'];
				menu_tree_div ();
				$function_parametres['cate_parent'] = $function_parametres_save;
				//$function_parametres['niveau']--;

				$pv['NbrMenuDuDossier']--;
				$pv['col_largeur'] = floor ( ${$theme_tableau}['B01M']['deco_div_width'] / ceil ( $pv['NbrMenuDuDossier'] / $pv['DivBannerNbrligne'] ) );

				$pv['l'] = 1;
				$pv['NbrColonne'] = 1;
				unset ( $pv['UniteMenuBanner'] );
				$pv['UniteMenuBanner'] = array();
				reset ( $pv['menu_JSON'] );
				unset ( $B );
				foreach ( $pv['menu_JSON'] as $B ) { 
					if ( $B['SessionRecherche'] == $pv['NbrSessionRecherche'] ) {
						$pv['UniteMenuBanner'][$pv['NbrColonne']][$pv['l']] = $B['entreeA'] . $B['entreeT'] . "</a>\r";
						$pv['l']++;
						if ( $pv['l'] > $pv['DivBannerNbrligne'] ) { $pv['l'] = 1; $pv['NbrColonne']++; }
					}
				}
				$pv['cible'] = &$pv['renduDiv'][$mji['id']];
				$pv['td_style'] = "style='width: ".$pv['col_largeur']."px; height: ".$pv['LigneHauteur']."px; white-space: nowrap;'";
				$pv['cible'] .= "<table style='border-spacing: 0px; vertical-align: top;'>\r";
				
				for ( $pv['l'] = 1 ; $pv['l'] <= $pv['DivBannerNbrligne'] ; $pv['l']++ ){
					$pv['cible'] .= "<tr>\r";
					for ( $pv['c'] = 1 ; $pv['c'] <= $pv['NbrColonne'] ; $pv['c']++ ){
						$pv['cible'] .= "<td ".$pv['td_style'].">". $pv['UniteMenuBanner'][$pv['c']][$pv['l']] . "</td>\r";
					}
					$pv['cible'] .= "</tr>\r";
				}
				$pv['cible'] .= "</table>\r</div>\r";
				$pv['NbrSessionRecherche']++;
			}
			$pv['BarNbr']++;
		}
	}
	unset ( $A );
}

$pv['i'] = 0;
$pv['DivBarSize'] = floor( ${$theme_tableau}['theme_module_largeur_interne'] / $pv['BarNbr']);

// Forge du menu racine
unset ( $A );
foreach ( $pv['menu_JSON'] as $A ) {	if ( $A['par'] == "racine" ) { $pv['div_racine'] = $A['id']; } }
echo ("\r<div id='".$pv['div_racine']."' class='" . $theme_tableau ."menu_niv_0' style='position: absolute; visibility: hidden; z-index: ".($module_z_index['compteur']+2).";
width: ".${$theme_tableau}['theme_module_largeur_interne']."px; height: ".${$theme_tableau}['B00M']['deco_div_height']."px; '>\r");
$JavaScriptOnload[] = "\telm.Gebi( '".$pv['div_racine']."' ).style.visibility = 'visible';";
$GeneratedJavaScriptObj->insertJavaScript ("Onload", "\telm.Gebi( '".$pv['div_racine']."' ).style.visibility = 'visible';");
// Forge du reste des DIV
$pv['menudock']  = ${$theme_tableau}['B01M']['deco_dock_cible'];
if ( ${$theme_tableau}['B01M']['deco_anim'] == "bottom-banner" ) { $pv['menudock'] = 10; }
unset ( $A );
foreach ( $pv['renduBar'] as $A ) { 
	echo ( "<div id='".$A['id']."' class='" . $theme_tableau ."menu_niv_0' style='position: absolute; width : ".$pv['DivBarSize']."px; top: 0px; height: ".${$theme_tableau}['B00M']['deco_tab_y']."px; left: ".( floor(${$theme_tableau}['theme_module_largeur_interne'] / $pv['BarNbr']) * $pv['i'])."px; ");
	if ( $A['arti_ref'] == 1 ) { echo ("background-image: url(../graph/".${$theme_tableau}['B00M']['deco_repertoire']."/".${$theme_tableau}['B00M']['deco_tab_hover_b']."); text-align: center; '>\r" . $A['txt'] . "</div>\r"); }
	else { echo ("background-image: url(../graph/".${$theme_tableau}['B00M']['deco_repertoire']."/".${$theme_tableau}['B00M']['deco_tab_up_b']."); text-align: center; '".$pv['JSFxHoverMenuD'].">\r" . $A['txt'] . "</div>\r" ); }
	$pv['i']++;
}
echo ( "</div>\r" ); 

// Génération de la table des objets pour le javascript.
unset ( $A, $B, $C );
$pv['menu_JSON_nom'] = "TabMenuBanner";
$pv['menu_JSON_rendu'] .= "\rvar ".$pv['menu_JSON_nom']." = {\r";
reset ( $pv['menu_JSON'] );
foreach ( $pv['menu_JSON'] as &$A ) { 
	$pv['menu_JSON_rendu'] .= "\t'".$A['id']."':	{ 'id':'".$A['id']."',	'p':'".$A['par']."',	'niv':'".$A['niv']."',	'deco':'',	'anim':'".$A['anim']."',	'ent':'".$A['entree']."',	'nbent':'".$A['nf']."',	'width':'".$A['width']."',	'AlignRef' : '".$pv['AlignRef']."',	'cible':'".$A['dock_cible']."',	'decal_x':'".$A['dock_decal_x']."',	'decal_y':'".$A['dock_decal_y']."',	'le':'".$A['le']."', 'dos':'".$A['dos']."',	'typ':'".$A['typ']."'";
	if ( $A['nf'] > 0 ) { 
		$pv['menu_JSON_rendu'] .= ",	f:{ ";
		foreach ( $A['fils'] as $B => &$C ) { $pv['menu_JSON_rendu'] .= "'a".( $B + 1 )."':'".$C."',	"; } // par reference obligatoire 
		$pv['menu_JSON_rendu'] = substr ( $pv['menu_JSON_rendu'] , 0 , -2 ) . "} ";
	}
	$pv['menu_JSON_rendu'] .= "},\r";
}
$pv['menu_JSON_rendu'] = substr ( $pv['menu_JSON_rendu'] , 0 , -2 ) . "\r};\r\r";
unset ( $A, $B, $C );

foreach ( $pv['renduDiv'] as $A ) { $affiche_module_['contenu_apres_module'] .= $A ; }

if ( $WebSiteObj->getWebSiteEntry('sw_info_debug') < 10 ) {
	unset (
		$menu_principal , 
		$function_parametres , 
		$dbquery , 
		$dbp
	);
}

?>
