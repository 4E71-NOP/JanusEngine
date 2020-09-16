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
//	uni_gestion_des_themes_p02.php debut
//	Modification theme
// --------------------------------------------------------------------------------------------
$_REQUEST['M_THEME']['theme_id_selection'] = 5 ;
$_REQUEST['uni_gestion_des_theme_p'] = 2;
/*Hydre-contenu_debut*/
$_REQUEST['sql_initiateur'] = "uni_gestion_des_themes_p02.php";
$pv['ConfigSelecCol'] = "systeme"; // ou MWM

// --------------------------------------------------------------------------------------------
// Preparation des tables
// --------------------------------------------------------------------------------------------
switch ( $_REQUEST['uni_gestion_des_theme_p'] ) {
case 2:
	$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
	SELECT * 
	FROM ".$SQL_tab_abrege['theme_descripteur']." 
	WHERE theme_id = '".$_REQUEST['M_THEME']['theme_id_selection']."'
	;");
	while ($dbp = fetch_array_sql($dbquery)) { foreach ( $dbp as $A => $B ) { $infos_theme[$A] = $B; } }
break;
case 3:
break;
}

// --------------------------------------------------------------------------------------------
// Preparation des elements
// --------------------------------------------------------------------------------------------
$tl_['eng']['o1l1'] = "Name";			$tl_['fra']['o1l1'] = "Nom";
$tl_['eng']['o1l2'] = "Directory";		$tl_['fra']['o1l2'] = "R&eacute;pertoire";	
$tl_['eng']['o1l3'] = "Title";			$tl_['fra']['o1l3'] = "Titre";
$tl_['eng']['o1l4'] = "Description";	$tl_['fra']['o1l4'] = "Description";
$tl_['eng']['oblx'] = "Block";			$tl_['fra']['oblx'] = "Bloc";

$tl_['eng']['o5l11'] = "Admin panel background<span class='" . $theme_tableau . $_REQUEST['bloc']."_avert'>(1)</span>";	$tl_['fra']['o5l11'] = "Fond du panneau d'administration<span class='" . $theme_tableau . $_REQUEST['bloc']."_avert'>(1)</span>";		
$tl_['eng']['o5l21'] = "Switch<span class='" . $theme_tableau . $_REQUEST['bloc']."_avert'>(1)</span>";					$tl_['fra']['o5l21'] = "Bouton<span class='" . $theme_tableau . $_REQUEST['bloc']."_avert'>(1)</span>";
$tl_['eng']['o5l31'] = "Size X/Y";					$tl_['fra']['o5l31'] = "Dimenssion X/Y";
$tl_['eng']['o5l41'] = "Position";					$tl_['fra']['o5l41'] = "Position";
$tl_['eng']['o5l51'] = "Gauge blend Begin / End";	$tl_['fra']['o5l51'] = "Fondu de la jauge D&eacute;but / Fin";	
$tl_['eng']['o5l61'] =" <span class='" . $theme_tableau . $_REQUEST['bloc']."_avert'>(1)</span>Leave only the filename.";	$tl_['fra']['o5l61'] = "<span class='" . $theme_tableau . $_REQUEST['bloc']."_avert'>(1)</span>Ne laissez que le nom de fichier dans la case.";	

$pv['o5l42'] = "<select name ='M_THEME['admctrl_position']' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
$tl_['eng']['o5l4_s1'] = "Up";			$tl_['fra']['o5l4_s1'] = "Haut";
$tl_['eng']['o5l4_s2'] = "Down";		$tl_['fra']['o5l4_s2'] = "Bas";
$tl_['eng']['o5l4_s3'] = "Left";		$tl_['fra']['o5l4_s3'] = "Gauche";
$tl_['eng']['o5l4_s4'] = "Right";		$tl_['fra']['o5l4_s4'] = "Droite";
$tl_['eng']['o5l4_s5'] = "Middle";		$tl_['fra']['o5l4_s5'] = "Milieu";

$admctrl_position[$infos_theme['theme_admctrl_position']] = " selected ";
$pv['o5l42'] .= "
<option value='1' ".$admctrl_position['1']."> ".$tl_[$l]['o5l4_s1']." - ".$tl_[$l]['o5l4_s3']." </option>\r
<option value='2' ".$admctrl_position['2']."> ".$tl_[$l]['o5l4_s1']." - ".$tl_[$l]['o5l4_s5']." </option>\r
<option value='3' ".$admctrl_position['3']."> ".$tl_[$l]['o5l4_s1']." - ".$tl_[$l]['o5l4_s4']." </option>\r
<option value='4' ".$admctrl_position['4']."> ".$tl_[$l]['o5l4_s5']." - ".$tl_[$l]['o5l4_s4']." </option>\r
<option value='5' ".$admctrl_position['5']."> ".$tl_[$l]['o5l4_s2']." - ".$tl_[$l]['o5l4_s4']." </option>\r
<option value='6' ".$admctrl_position['6']."> ".$tl_[$l]['o5l4_s2']." - ".$tl_[$l]['o5l4_s5']." </option>\r
<option value='7' ".$admctrl_position['7']."> ".$tl_[$l]['o5l4_s2']." - ".$tl_[$l]['o5l4_s3']." </option>\r
<option value='8' ".$admctrl_position['8']."> ".$tl_[$l]['o5l4_s5']." - ".$tl_[$l]['o5l4_s3']." </option>\r
</select>\r";


switch ( $pv['ConfigSelecCol'] ) {
case "MWM":
	$pv['o5l52'] = "
	#<input type='text' id='MS_couleur_jauge_depart'	name='M_THEME[couleur_jauge_depart]'	size='8' maxlength='6' value=\"".$infos_theme['theme_couleur_jauge_depart']."\"	class='".$theme_tableau.$_REQUEST['bloc']."_t3 ".$theme_tableau.$_REQUEST['bloc']."_form_1'>\r /
	#<input type='text' id='MS_couleur_jauge_milieu'	name='M_THEME[couleur_jauge_milieu]'	size='8' maxlength='6' value=\"".$infos_theme['theme_couleur_jauge_milieu']."\"	class='".$theme_tableau.$_REQUEST['bloc']."_t3 ".$theme_tableau.$_REQUEST['bloc']."_form_1'>\r /
	#<input type='text' id='MS_couleur_jauge_fin'		name='M_THEME[couleur_jauge_fin]'		size='8' maxlength='6' value=\"".$infos_theme['theme_couleur_jauge_fin']."\"	class='".$theme_tableau.$_REQUEST['bloc']."_t3 ".$theme_tableau.$_REQUEST['bloc']."_form_1'>\r
	<br>\r
	<br>\r
	<table style='border: 1px solid black; border-collapse: collapse'>\r
	<tr>\r";
break;
case "systeme":
	$pv['o5l52'] = "
	<input type='color' id='MS_couleur_jauge_depart'	name='M_THEME[couleur_jauge_depart]'	value='#".$infos_theme['theme_couleur_jauge_depart']."'	oninput='GestionThemeMAJJauge()' class='" . $theme_tableau.$_REQUEST['bloc']."_t3 ".$theme_tableau.$_REQUEST['bloc']."_form_1'>\r /
	<input type='color' id='MS_couleur_jauge_milieu'	name='M_THEME[couleur_jauge_milieu]'	value='#".$infos_theme['theme_couleur_jauge_milieu']."'	oninput='GestionThemeMAJJauge()' class='" . $theme_tableau.$_REQUEST['bloc']."_t3 ".$theme_tableau.$_REQUEST['bloc']."_form_1'>\r /
	<input type='color' id='MS_couleur_jauge_fin'		name='M_THEME[couleur_jauge_fin]'		value='#".$infos_theme['theme_couleur_jauge_fin']."'	oninput='GestionThemeMAJJauge()' class='" . $theme_tableau.$_REQUEST['bloc']."_t3 ".$theme_tableau.$_REQUEST['bloc']."_form_1'>\r
	<br>\r
	<br>\r
	<table style='border: 1px solid black; border-collapse: collapse'>\r
	<tr>\r";
break;
}


$pv['nbrJauge'] = 30;
$pv['largJauge'] = 320;
for ( $pv['i'] = 1 ; $pv['i'] <= $pv['nbrJauge']; $pv['i']++ ) { $pv['o5l52'] .= "<td id='jauge_theme_".$pv['i']."' style='width: ".floor( $pv['largJauge'] / $pv['nbrJauge'])."px; height: 32px; background-color: #000000; border: 0px'></td>\r"; }
$pv['o5l52'] .= "</tr>\r</table>\r";

// --------------------------------------------------------------------------------------------
//	Affichage
// --------------------------------------------------------------------------------------------
$tl_['eng']['invite1'] = "This part will allow you to modify a theme.";
$tl_['fra']['invite1'] = "Cette partie va vous permettre de modifier une theme.";

echo ("
<form ACTION='index.php?' name='formulaire_gds' method='post'>\r
<p>".$tl_[$l]['invite1']."</p>
");

if ( $_REQUEST['M_THEME']['confirmation_modification_oubli'] == 1 ) { 
	$tl_['eng']['err'] = "You didn't confirm the modification.";
	$tl_['fra']['err'] = "Vous n'avez pas confirm&eacute; la modification";
	echo ("<p class='" . $theme_tableau . $_REQUEST['bloc']."_erreur " . $theme_tableau . $_REQUEST['bloc']."_tb3'>".$tl_[$l]['err']."<br>\r"); 
}


$_REQUEST['FS_index']++;
$fsi = &$_REQUEST['FS_table'][$_REQUEST['FS_index']];
$fsi['left']					= 16;
$fsi['top']						= 16;
$fsi['width']					= 768;
$fsi['height']					= 512;
$fsi['js_cs']					= "";
$fsi['formulaire']				= "formulaire_gds";
$fsi['champs']					= "M_THEME[repertoire]";
$fsi['lsdf_chemin']				= "../graph/";
$fsi['mode_selection']			= "repertoire";
$fsi['lsdf_mode']				= "repertoire";
$fsi['lsdf_nivmax']				= 2;
$fsi['lsdf_indicatif']			= "SDFGDTP2a";
$fsi['lsdf_parent_idx']			= 1;
$fsi['lsdf_parent']['0']		= "TabSDF_".$fsi['lsdf_indicatif'];
$fsi['lsdf_parent']['1']		= "TabSDF_".$fsi['lsdf_indicatif'];
$fsi['lsdf_racine']				= "F";
$fsi['lsdf_coupe_chemin']		= 0;
$fsi['lsdf_conserve_chemin']	= "graph/universel/";
$fsi['lsdf_coupe_repertoire']	= 1;
$fsi['liste_fichier']			= array();


$AD['1']['1']['1']['cont'] = $tl_[$l]['o1l1'];
$AD['1']['2']['1']['cont'] = $tl_[$l]['o1l2'];
$AD['1']['3']['1']['cont'] = $tl_[$l]['o1l3'];
$AD['1']['4']['1']['cont'] = $tl_[$l]['o1l4'];


switch ( $_REQUEST['uni_gestion_des_theme_p'] ) {
case 2: $AD['1']['1']['2']['cont'] = $infos_theme['theme_nom'];	break;
case 3:	$AD['1']['1']['2']['cont'] = "<input type='text' name='M_THEME[nom]' size='45' maxlength='255' value=\"theme_". date ( "Y_m_j_-_G_i_s", mktime() )."\" class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";		break;
}
$AD['1']['2']['2']['cont'] = generation_icone_selecteur_fichier ( 1 , $fsi['formulaire'] , $fsi['champs'] , 20 , $infos_theme['theme_repertoire'] , "TabSDF_".$fsi['lsdf_indicatif'] );
$AD['1']['3']['2']['cont'] = "<input type='text' name='M_THEME[titre]' size='45' maxlength='255' value='".$infos_theme['theme_titre']."' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
$AD['1']['4']['2']['cont'] = "<input type='text' name='M_THEME[desc]' size='45' maxlength='255' value='".$infos_theme['theme_desc']."' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";

$pv['compte_deco'] = 1;
for ( $i = 2 ; $i <= 3 ; $i++ ) { 
	for ( $j = 1 ; $j <= 15 ; $j++ ) { 
		$pv['compte_deco_2'] = sprintf("%02u", $pv['compte_deco'] );
		$AD[$i][$j]['1']['cont'] = $tl_[$l]['oblx'] . "_" . $pv['compte_deco_2']; 
		$AD[$i][$j]['2']['cont'] = "
		<input type='text' name='M_THEME[theme_bloc_".$pv['compte_deco_2']."_nom]' size='25' maxlength='255' value=\"".$infos_theme['theme_bloc_'.$pv['compte_deco_2'].'_nom']."\" class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r
		&nbsp;&nbsp;&nbsp;&nbsp;
		<input type='text' name='M_THEME[theme_bloc_".$pv['compte_deco_2']."_texte]' size='25' maxlength='255' value=\"".$infos_theme['theme_bloc_'.$pv['compte_deco_2'].'_texte']."\" class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
		$pv['compte_deco']++;
	}
}

$pv['compte_deco'] = 0;
for ( $j = 1 ; $j <= 30 ; $j++ ) { 
	$pv['compte_deco_2'] = sprintf("%02u", $pv['compte_deco'] );
	$AD['4'][$j]['1']['cont'] = $tl_[$l]['oblx'] . "_" . $pv['compte_deco_2']; 
	$AD['4'][$j]['2']['cont'] = "<input type='text' name='M_THEME[theme_bloc_".$pv['compte_deco_2']."_menu]' size='25' maxlength='255' value=\"".$infos_theme['theme_bloc_'.$pv['compte_deco_2'].'_menu']."\" class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
	$pv['compte_deco']++;
}

$AD['5']['1']['1']['cont'] = $tl_[$l]['o5l11'];
$AD['5']['2']['1']['cont'] = $tl_[$l]['o5l21'];
$AD['5']['3']['1']['cont'] = $tl_[$l]['o5l31'];
$AD['5']['4']['1']['cont'] = $tl_[$l]['o5l41'];
$AD['5']['5']['1']['cont'] = $tl_[$l]['o5l51'];
$AD['5']['6']['1']['cont'] = $tl_[$l]['o5l61'];



$_REQUEST['FS_index']++;
$fsi = &$_REQUEST['FS_table'][$_REQUEST['FS_index']];
$fsi['left']					= 16;
$fsi['top']						= 16;
$fsi['width']					= 768;
$fsi['height']					= 512;
$fsi['js_cs']					= "";
$fsi['formulaire']				= "formulaire_gds";
$fsi['champs']					= "MS[admctrl_panel_bg]";
$fsi['lsdf_chemin']				= "../graph";
$fsi['mode_selection']			= "fichier";
$fsi['lsdf_mode']				= "tout";
$fsi['lsdf_nivmax']				= 5;
$fsi['lsdf_indicatif']			= "SDFGDTP2b";
$fsi['lsdf_parent_idx']			= 1;
$fsi['lsdf_parent']['0']		= "TabSDF_".$fsi['lsdf_indicatif'];
$fsi['lsdf_parent']['1']		= "TabSDF_".$fsi['lsdf_indicatif'];
$fsi['lsdf_racine']				= "F";
$fsi['lsdf_coupe_chemin']		= 0;
$fsi['lsdf_conserve_chemin']	= "";
$fsi['lsdf_coupe_repertoire']	= 1;
$fsi['liste_fichier']			= array();
$AD['5']['1']['2']['cont'] = generation_icone_selecteur_fichier ( 3 , $fsi['formulaire'] , $fsi['champs'] , 30 , $infos_theme['theme_admctrl_panel_bg'] , "TabSDF_".$fsi['lsdf_indicatif'] );

$_REQUEST['FS_index']++;
$fsi = &$_REQUEST['FS_table'][$_REQUEST['FS_index']];
$fsi['left']					= 16;
$fsi['top']						= 16;
$fsi['width']					= 768;
$fsi['height']					= 512;
$fsi['js_cs']					= "";
$fsi['formulaire']				= "formulaire_gds";
$fsi['champs']					= "MS[admctrl_switch_bg]";
$fsi['lsdf_chemin']				= "../graph/";
$fsi['mode_selection']			= "fichier";
$fsi['lsdf_mode']				= "tout";
$fsi['lsdf_nivmax']				= 5;
$fsi['lsdf_indicatif']			= "SDFGDTP2c";
$fsi['lsdf_parent_idx']			= 1;
$fsi['lsdf_parent']['0']		= "TabSDF_".$fsi['lsdf_indicatif'];
$fsi['lsdf_parent']['1']		= "TabSDF_".$fsi['lsdf_indicatif'];
$fsi['lsdf_racine']				= "F";
$fsi['lsdf_coupe_chemin']		= 0;
$fsi['lsdf_conserve_chemin']	= "";
$fsi['lsdf_coupe_repertoire']	= 1;
$fsi['liste_fichier']			= array();

$AD['5']['2']['2']['cont'] = generation_icone_selecteur_fichier ( 3 , $fsi['formulaire'] , $fsi['champs'] , 30 , $infos_theme['theme_admctrl_switch_bg'] , "TabSDF_".$fsi['lsdf_indicatif'] );
$AD['5']['3']['2']['cont'] = "<input type='text' name='M_THEME[admctrl_size_x]' size='8' maxlength='255' value='".$infos_theme['theme_admctrl_size_x']."' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>px\r / 
<input type='text' name='M_THEME[admctrl_size_y]' size='8' maxlength='255' value='".$infos_theme['theme_admctrl_size_y']."' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>px\r";
$AD['5']['4']['2']['cont'] = $pv['o5l42'];
$AD['5']['5']['2']['cont'] = $pv['o5l52'];

$ADC['onglet']['1']['nbr_ligne'] = 4;	$ADC['onglet']['1']['nbr_cellule'] = 2;	$ADC['onglet']['1']['legende'] = 2;
$ADC['onglet']['2']['nbr_ligne'] = 15;	$ADC['onglet']['2']['nbr_cellule'] = 2;	$ADC['onglet']['2']['legende'] = 2;
$ADC['onglet']['3']['nbr_ligne'] = 15;	$ADC['onglet']['3']['nbr_cellule'] = 2;	$ADC['onglet']['3']['legende'] = 2;
$ADC['onglet']['4']['nbr_ligne'] = 10;	$ADC['onglet']['4']['nbr_cellule'] = 2;	$ADC['onglet']['4']['legende'] = 2;
$ADC['onglet']['5']['nbr_ligne'] = 6;	$ADC['onglet']['5']['nbr_cellule'] = 2;	$ADC['onglet']['5']['legende'] = 2;

$tl_['eng']['cell_1_txt'] = "G&eacute;n&eacute;ral";	$tl_['fra']['cell_1_txt'] = "General"; 
$tl_['eng']['cell_2_txt'] = "Block 01-15"; 				$tl_['fra']['cell_2_txt'] = "Bloc 01-15"; 
$tl_['eng']['cell_3_txt'] = "Block 15-30"; 				$tl_['fra']['cell_3_txt'] = "Bloc 15-30"; 
$tl_['eng']['cell_4_txt'] = "Menu 0-9"; 				$tl_['fra']['cell_4_txt'] = "Menu 0-9"; 
$tl_['eng']['cell_5_txt'] = "Admin"; 					$tl_['fra']['cell_5_txt'] = "Admin"; 

$tab_infos['AffOnglet']			= 1;
$tab_infos['NbrOnglet']			= 5;
$tab_infos['tab_comportement']	= 1;
$tab_infos['mode_rendu']		= 0;	// 0 echo 1 dans une variable
$tab_infos['TypSurbrillance']	= 0; // 1:ligne, 2:cellule
$tab_infos['doc_height']		= 320;
$tab_infos['doc_width']			= ${$theme_tableau}['theme_module_largeur_interne'] -24 ;
$tab_infos['groupe']			= "gt_grp1";
$tab_infos['cell_id']			= "tab";
$tab_infos['document']			= "doc";
$tab_infos['cell_1_txt']		= $tl_[$l]['cell_1_txt'];
$tab_infos['cell_2_txt']		= $tl_[$l]['cell_2_txt'];
$tab_infos['cell_3_txt']		= $tl_[$l]['cell_3_txt'];
$tab_infos['cell_4_txt']		= $tl_[$l]['cell_4_txt'];
$tab_infos['cell_5_txt']		= $tl_[$l]['cell_5_txt'];
include ("routines/website/affichage_donnees.php");

// --------------------------------------------------------------------------------------------
$tl_['eng']['bouton2'] = "Return to list";						$tl_['fra']['bouton2'] = "Retour &agrave; la liste";

switch ( $_REQUEST['uni_gestion_des_theme_p'] ) {
case 2:
	$tl_['eng']['bouton1'] = "Modify";								$tl_['fra']['bouton1'] = "Modifier";
	$tl_['eng']['text_confirm1'] = "I confirm the modifications";	$tl_['fra']['text_confirm1'] = "Je confirme les modifications";
	echo ("
	<input type='hidden' name='M_THEME[id]'						value='".$infos_theme['theme_id']."'>\r
	<input type='hidden' name='M_THEME[nom]'						value='".$infos_theme['theme_nom']."'>\r
	<input type='hidden' name='UPDATE_action'				value='UPDATE_THEME'>\r
	".
	$bloc_html['post_hidden_sw'].
	$bloc_html['post_hidden_l'].
	$bloc_html['post_hidden_arti_ref'].
	$bloc_html['post_hidden_arti_page'].
	$bloc_html['post_hidden_user_login'].
	$bloc_html['post_hidden_user_pass']."
	<table ".${$theme_tableau}['tab_std_rules']." width='". $tab_infos['doc_width'] ."'>\r
	<tr>\r
	<td>\r<input type='checkbox' name='M_THEME[confirmation_modification]'>".$tl_[$l]['text_confirm1']."\r</td>\r
	<td>\r
	");
	$_REQUEST['BS']['id']				= "bouton_creation";
	$_REQUEST['BS']['type']				= "submit";
	$_REQUEST['BS']['style_initial']	= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s2_n";
	$_REQUEST['BS']['style_hover']		= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s2_h";
	$_REQUEST['BS']['onclick']			= "";
	$_REQUEST['BS']['message']			= $tl_[$l]['bouton1'];
	$_REQUEST['BS']['mode']				= 1;
	$_REQUEST['BS']['taille'] 			= 128;
	$_REQUEST['BS']['derniere_taille']	= 0;
	echo generation_bouton ();
	echo ("<br>\r&nbsp;</td>\r
	</tr>\r
	</form>\r
	");
break;
case 3:
	$tl_['eng']['bouton1'] = "Create";				$tl_['fra']['bouton1'] = "Cr&eacute;er";
	echo ("
	<input type='hidden' name='UPDATE_action'				value='ADD_theme'>\r".
	$bloc_html['post_hidden_sw'].
	$bloc_html['post_hidden_l'].
	$bloc_html['post_hidden_arti_ref'].
	$bloc_html['post_hidden_arti_page'].
	$bloc_html['post_hidden_user_login'].
	$bloc_html['post_hidden_user_pass']."
	<table cellpadding='0' cellspacing='0' style='margin-left: auto; margin-right: 0px; '>
	<tr>\r
	<td>\r</td>\r
	<td>\r
	");
	$_REQUEST['BS']['id']				= "bouton_creation";
	$_REQUEST['BS']['type']				= "submit";
	$_REQUEST['BS']['style_initial']	= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s2_n";
	$_REQUEST['BS']['style_hover']		= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s2_h";
	$_REQUEST['BS']['onclick']			= "";
	$_REQUEST['BS']['message']			= $tl_[$l]['bouton1'];
	$_REQUEST['BS']['mode']				= 1;
	$_REQUEST['BS']['taille'] 			= 0;
	echo generation_bouton ();
	echo ("<br>\r&nbsp;</td>\r
	</tr>\r
	</form>\r
	");
break;
}

echo ("
<form ACTION='index.php?' method='post'>\r".
$bloc_html['post_hidden_sw'].
$bloc_html['post_hidden_l'].
$bloc_html['post_hidden_arti_ref']."
<input type='hidden' name='arti_page'	value='1'>\r".
$bloc_html['post_hidden_user_login'].
$bloc_html['post_hidden_user_pass']."

<tr>\r
<td>\r</td>\r
<td>\r");
$_REQUEST['BS']['id']				= "bouton_retour_liste";
$_REQUEST['BS']['type']				= "submit";
$_REQUEST['BS']['style_initial']	= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s1_n";
$_REQUEST['BS']['style_hover']		= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s1_h";
$_REQUEST['BS']['onclick']			= "";
$_REQUEST['BS']['message']			= $tl_[$l]['bouton2'];
$_REQUEST['BS']['mode']				= 1;
$_REQUEST['BS']['taille'] 			= 0;
echo generation_bouton ();
echo ("
<br>\r&nbsp;
</form>\r

</td>\r
</tr>\r
</table>\r
<br>\r
");

$JavaScriptFichier[] = "routines/website/javascript_lib_gestion_themes.js";
$JavaScriptOnload[] = "GestionThemeMAJJauge();\r";

switch ( $pv['ConfigSelecCol'] ) {
case "MWM":
	$JavaScriptInitDonnees[] = "
	MWMCPAttacheSurElement ( 'MS_couleur_jauge_depart' , GestionDecorationSpecial );\r
	MWMCPAttacheSurElement ( 'MS_couleur_jauge_milieu' , GestionDecorationSpecial );\r
	MWMCPAttacheSurElement ( 'MS_couleur_jauge_fin' , GestionDecorationSpecial );\r
	";
	$JavaScriptFichier[] = "routines/website/javascript_ColorPicker.js";
	$JavaScriptPHPElements[] = "routines/website/javascript_ColorPicker_elements.php";
break;
}

/*
$_REQUEST['FS_index']++;
$pv['i'] = &$_REQUEST['FS_table'][$_REQUEST['FS_index']];			
$pv['i']['left']					= 16;                           
$pv['i']['top']						= 16;                           
$pv['i']['width']					= 768;                          
$pv['i']['height']					= 512;                          
$pv['i']['js_cs']					= "";                           
$pv['i']['formulaire']				= "formulaire_gds";             
$pv['i']['champs']					= "MS[admctrl_panel_bg]";       
$pv['i']['lsdf_chemin']				= "../graph";                   
$pv['i']['mode_selection']			= "fichier";                    
$pv['i']['lsdf_mode']				= "tout";                       
$pv['i']['lsdf_nivmax']				= 5;                            
$pv['i']['lsdf_parent']				= "GDS21_LF0";                  
$pv['i']['lsdf_racine']				= "GDS21_LF";                   
$pv['i']['lsdf_coupe_chemin']		= 0;                            
$pv['i']['lsdf_coupe_repertoire']	= 1;                            
$pv['i']['liste_fichier']			= array();                      

$_REQUEST['FS_index']++;
$pv['i'] = &$_REQUEST['FS_table'][$_REQUEST['FS_index']];				
$pv['i']['left']					= 16;                               
$pv['i']['top']						= 16;                               
$pv['i']['width']					= 768;                              
$pv['i']['height']					= 512;                              
$pv['i']['js_cs']					= "";                               
$pv['i']['formulaire']				= "formulaire_gds";                 
$pv['i']['champs']					= "MS[admctrl_switch_bg]";          
$pv['i']['lsdf_chemin']				= "../graph";                       
$pv['i']['mode_selection']			= "fichier";                        
$pv['i']['lsdf_mode']				= "tout";                           
$pv['i']['lsdf_nivmax']				= 5;                                
$pv['i']['lsdf_parent']				= "GDS22_LF0";                      
$pv['i']['lsdf_racine']				= "GDS22_LF";                       
$pv['i']['lsdf_coupe_chemin']		= 0;                                
$pv['i']['lsdf_coupe_repertoire']	= 1;                                
$pv['i']['liste_fichier']			= array();                          
*/


if ( $site_web['sw_info_debug'] < 10 ) {
	unset (
		$admctrl_position,
		$bouclage,
		$dbp,
		$dbquery,
		$file,
		$file_stat,
		$handle,
		$infos_theme,
		$liste_fichier,
		$AD,
		$ADC,
		$pv,
		$tab_etat,
		$tl_
	);
}

/*Hydre-contenu_fin*/
?>
