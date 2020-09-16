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
$pv['menucoloneA'] = floor( (${$theme_tableau}['theme_module_largeur_interne'] - 32 ) * 0.6);
$pv['menucoloneB'] = floor( (${$theme_tableau}['theme_module_largeur_interne'] - 32 ) * 0.4);

$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
SELECT * 
FROM ".$SQL_tab_abrege['decoration']." 
WHERE deco_etat ='1'
;");
while ($dbp = fetch_array_sql($dbquery)) { 
	$pv['idx'] = $dbp['deco_ref_id'];
	$pv['decoliste'][$pv['idx']]['idx'] = $pv['idx'];
	$pv['decoliste'][$pv['idx']]['deco_nom'] = $dbp['deco_nom'];
	$pv['decoliste'][$pv['idx']]['deco_type'] = $dbp['deco_type'];
}

$tl_['fra']['MenuGenre1'] = "Statique";					$tl_['eng']['MenuGenre1'] = "Static";
$tl_['fra']['MenuGenre2'] = "DIVs anim&eacute;s";		$tl_['eng']['MenuGenre2'] = "Animated DIVs";
$tl_['fra']['MenuGenre3'] = "Type Banner";				$tl_['eng']['MenuGenre3'] = "Banner style";
$pv['menugenre']['1']['db'] = 1;	$pv['menugenre']['1']['t'] = $tl_[$l]['MenuGenre1'];
$pv['menugenre']['2']['db'] = 2;	$pv['menugenre']['2']['t'] = $tl_[$l]['MenuGenre2'];
$pv['menugenre']['3']['db'] = 3;	$pv['menugenre']['3']['t'] = $tl_[$l]['MenuGenre3'];

$tl_['fra']['AffIcon1'] = "Non";		$tl_['eng']['AffIcon1'] = "No";
$tl_['fra']['AffIcon2'] = "Oui";		$tl_['eng']['AffIcon2'] = "Yes";
$pv['AffIcon']['0']['db'] = 1;	$pv['AffIcon']['0']['t'] = $tl_[$l]['AffIcon1'];
$pv['AffIcon']['1']['db'] = 2;	$pv['AffIcon']['1']['t'] = $tl_[$l]['AffIcon2'];


$tl_['fra']['DCible0'] = "Haut-Gauche";				$tl_['eng']['DCible0'] = "Top-Left";
$tl_['fra']['DCible8'] = "Haut-Centr&eacute;";		$tl_['eng']['DCible8'] = "Top-Center";
$tl_['fra']['DCible4'] = "Haut-Droite";				$tl_['eng']['DCible4'] = "Top-Right";
$tl_['fra']['DCible2'] = "Milieu-Gauche";			$tl_['eng']['DCible2'] = "Middle-Left";
$tl_['fra']['DCible10'] = "Milieu-Centr&eacute;";	$tl_['eng']['DCible10'] = "Middle-Center";
$tl_['fra']['DCible6'] = "Milieu-Droite";			$tl_['eng']['DCible6'] = "Middle-Right";
$tl_['fra']['DCible1'] = "Bas-Gauche";				$tl_['eng']['DCible1'] = "Bottom-Left";
$tl_['fra']['DCible9'] = "Bas-Centr&eacute;";		$tl_['eng']['DCible9'] = "Bottom-Center";
$tl_['fra']['DCible5'] = "Bas-Droite";				$tl_['eng']['DCible5'] = "Bottom-Right";
$pv['DCible']['0']['db'] = 0;	$pv['DCible']['0']['t'] = $tl_[$l]['DCible0'];
$pv['DCible']['8']['db'] = 8;	$pv['DCible']['8']['t'] = $tl_[$l]['DCible8'];
$pv['DCible']['4']['db'] = 4;	$pv['DCible']['4']['t'] = $tl_[$l]['DCible4'];
$pv['DCible']['2']['db'] = 2;	$pv['DCible']['2']['t'] = $tl_[$l]['DCible2'];
$pv['DCible']['10']['db'] = 10;	$pv['DCible']['10']['t'] = $tl_[$l]['DCible10'];
$pv['DCible']['6']['db'] = 6;	$pv['DCible']['6']['t'] = $tl_[$l]['DCible6'];
$pv['DCible']['1']['db'] = 1;	$pv['DCible']['1']['t'] = $tl_[$l]['DCible1'];
$pv['DCible']['9']['db'] = 9;	$pv['DCible']['9']['t'] = $tl_[$l]['DCible9'];
$pv['DCible']['5']['db'] = 5;	$pv['DCible']['5']['t'] = $tl_[$l]['DCible5'];


// --------------------------------------------------------------------------------------------
$tl_['fra']['o1l11'] = "D&eacute;coration graphique";	$tl_['eng']['o1l11'] = "Graphic decoration";
$tl_['fra']['o1l21'] = "D&eacute;coration texte";		$tl_['eng']['o1l21'] = "Text decoration";
$tl_['fra']['o1l31'] = "Genre";							$tl_['eng']['o1l31'] = "Flavour";
$tl_['fra']['o1l41'] = "Nom animation";					$tl_['eng']['o1l41'] = "Animation name";

$AD['1']['1']['1']['cont'] = $tl_[$l]['o1l11'];
$AD['1']['2']['1']['cont'] = $tl_[$l]['o1l21'];
$AD['1']['3']['1']['cont'] = $tl_[$l]['o1l31'];
$AD['1']['4']['1']['cont'] = $tl_[$l]['o1l41'];

$AD['1']['1']['2']['cont'] = $theme_GD_['B01M']['deco_graphique'];
$AD['1']['1']['2']['cont'] = "<select name='M_DECORA[deco_graphique]'>\r";
unset ( $A );
reset ( $pv['decoliste'] );
foreach ( $pv['decoliste'] as $A ) {
	if ( $A['deco_type'] != 20 && $A['deco_type'] != 10 ) {
		$pv['selection'] = "";
		if ( $A['idx'] == $theme_GD_['B01M']['deco_graphique'] ) { $pv['selection'] = " selected "; }
		$AD['1']['1']['2']['cont']	.= "<option value='".$A['idx']."'".$pv['selection'].">".$A['deco_type']." > ".$A['deco_nom']."</option>\r";
	}
}
$AD['1']['1']['2']['cont'] .= "</select>\r";

$AD['1']['2']['2']['cont'] = $theme_GD_['B01M']['deco_texte'];
$AD['1']['2']['2']['cont'] = "<select name='M_DECORA[deco_texte]'>\r";
unset ( $A );
reset ( $pv['decoliste'] );
foreach ( $pv['decoliste'] as $A ) {
	if ( $A['deco_type'] == 20 ) {
		$pv['selection'] = "";
		if ( $A['idx'] == $theme_GD_['B01M']['deco_texte'] ) { $pv['selection'] = " selected "; }
		$AD['1']['2']['2']['cont']	.= "<option value='".$A['idx']."'".$pv['selection'].">".$A['deco_type']." > ".$A['deco_nom']."</option>\r";
	}
}
$AD['1']['2']['2']['cont'] .= "</select>\r";

$AD['1']['3']['2']['cont'] = "<select name='M_DECORA[deco_genre]'>\r";
foreach ( $pv['menugenre'] as $A ) {
	$pv['selection'] = "";
	if ( $A['db'] == $theme_GD_['B01M']['deco_genre'] ) { $pv['selection'] = " selected "; }
	$AD['1']['3']['2']['cont']	.= "<option value='".$A['db']."'".$pv['selection'].">".$A['t']."</option>\r";
}
$AD['1']['3']['2']['cont'] .= "</select>\r";

$AD['1']['4']['2']['cont'] = "<input type='text'  ".$pv['deco_nom_form']." name='M_DECORA[deco_anim]' size='35' maxlength='255' value='".$theme_GD_['B01M']['deco_anim']."' class='" . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";

// --------------------------------------------------------------------------------------------
$tl_['fra']['o2l11'] = "Cible";					$tl_['eng']['o2l11'] = "Target";
$tl_['fra']['o2l21'] = "D&eacute;calage X";		$tl_['eng']['o2l21'] = "Dock decal X";
$tl_['fra']['o2l31'] = "D&eacute;calage Y";		$tl_['eng']['o2l31'] = "Dock decal Y";
$tl_['fra']['o2l41'] = "Largeur";				$tl_['eng']['o2l41'] = "Width";
$tl_['fra']['o2l51'] = "Affichage icone";		$tl_['eng']['o2l51'] = "Display icons";
$tl_['fra']['o2l61'] = "Taille icone X";		$tl_['eng']['o2l61'] = "Icon size X";
$tl_['fra']['o2l71'] = "Taille icone Y";		$tl_['eng']['o2l71'] = "Icon size Y";

$AD['2']['1']['1']['cont'] = $tl_[$l]['o2l11'];
$AD['2']['2']['1']['cont'] = $tl_[$l]['o2l21'];
$AD['2']['3']['1']['cont'] = $tl_[$l]['o2l31'];
$AD['2']['4']['1']['cont'] = $tl_[$l]['o2l41'];
$AD['2']['5']['1']['cont'] = $tl_[$l]['o2l51'];
$AD['2']['6']['1']['cont'] = $tl_[$l]['o2l61'];
$AD['2']['7']['1']['cont'] = $tl_[$l]['o2l71'];

$AD['2']['1']['2']['cont'] = "<select name='M_DECORA[deco_genre]'>\r";
foreach ( $pv['DCible'] as $A ) {
	$pv['selection'] = "";
	if ( $A['db'] == $theme_GD_['B01M']['deco_dock_cible'] ) { $pv['selection'] = " selected "; }
	$AD['2']['1']['2']['cont']	.= "<option value='".$A['db']."'".$pv['selection'].">".$A['t']."</option>\r";
}
$AD['2']['1']['2']['cont'] .= "</select>\r";

$AD['2']['2']['2']['cont'] = "<input type='text'  ".$pv['deco_nom_form']." name='M_DECORA[deco_dock_decal_x]' size='35' maxlength='255' value='".$theme_GD_['B01M']['deco_dock_decal_x']."' class='" . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
$AD['2']['3']['2']['cont'] = "<input type='text'  ".$pv['deco_nom_form']." name='M_DECORA[deco_dock_decal_y]' size='35' maxlength='255' value='".$theme_GD_['B01M']['deco_dock_decal_y']."' class='" . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
$AD['2']['4']['2']['cont'] = "<input type='text'  ".$pv['deco_nom_form']." name='M_DECORA[deco_div_width]' size='35' maxlength='255' value='".$theme_GD_['B01M']['deco_div_width']."' class='" . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
$AD['2']['5']['2']['cont'] = "<select name='M_DECORA[deco_genre]'>\r";
foreach ( $pv['AffIcon'] as $A ) {
	$pv['selection'] = "";
	if ( $A['db'] == $theme_GD_['B01M']['deco_affiche_icones'] ) { $pv['selection'] = " selected "; }
	$AD['2']['5']['2']['cont']	.= "<option value='".$A['db']."'".$pv['selection'].">".$A['t']."</option>\r";
}
$AD['2']['5']['2']['cont'] .= "</select>\r";

$AD['2']['6']['2']['cont'] = "<input type='text'  ".$pv['deco_nom_form']." name='M_DECORA[deco_icone_taille_x]' size='35' maxlength='255' value='".$theme_GD_['B01M']['deco_icone_taille_x']."' class='" . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
$AD['2']['7']['2']['cont'] = "<input type='text'  ".$pv['deco_nom_form']." name='M_DECORA[deco_icone_taille_y]' size='35' maxlength='255' value='".$theme_GD_['B01M']['deco_icone_taille_y']."' class='" . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";

// --------------------------------------------------------------------------------------------
$ADC['onglet']['1']['nbr_ligne'] = 4;	$ADC['onglet']['1']['nbr_cellule'] = 2;	$ADC['onglet']['1']['legende'] = 2;
$ADC['onglet']['2']['nbr_ligne'] = 7;	$ADC['onglet']['2']['nbr_cellule'] = 2;	$ADC['onglet']['2']['legende'] = 2;	

$tl_['fra']['cell_1_txt'] = "G&eacute;n&eacute;ral";	$tl_['eng']['cell_1_txt'] = "Main";
$tl_['fra']['cell_2_txt'] = "R&eacute;glages";			$tl_['eng']['cell_2_txt'] = "Settings";

$tab_infos['AffOnglet']			= 1;
$tab_infos['NbrOnglet']			= 2;
$tab_infos['tab_comportement']	= 1
$tab_infos['mode_rendu']		= 0;
$tab_infos['TypSurbrillance']	= 0; // 1:ligne, 2:cellule
$tab_infos['doc_height']		= $tab_infos['doc_height'] - 32;
$tab_infos['doc_width']			= floor( (${$theme_tableau}['theme_module_largeur_interne'] - 32 ) * 0.6) ;
$tab_infos['groupe']			= "decomenu";
$tab_infos['cell_id']			= "tab";
$tab_infos['document']			= "menu";
$tab_infos['cell_1_txt']		= $tl_[$l]['cell_1_txt'];
$tab_infos['cell_2_txt']		= $tl_[$l]['cell_2_txt'];

include ("routines/website/affichage_donnees.php");

?>
