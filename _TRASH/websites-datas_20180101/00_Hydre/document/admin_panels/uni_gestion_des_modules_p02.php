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
$_REQUEST['M_MODULE']['id'] = 14 ;
$_REQUEST['uni_gestion_des_modules_p'] = 2;

// --------------------------------------------------------------------------------------------

/*Hydre-contenu_debut*/
$_REQUEST['sql_initiateur'] = "fra_gestion_des_modules_p02";

// --------------------------------------------------------------------------------------------
// Preparation des tables
// --------------------------------------------------------------------------------------------
$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
SELECT a.groupe_id,a.groupe_titre,a.groupe_nom
FROM ".$SQL_tab['groupe']." a , ".$SQL_tab['site_groupe']." b
WHERE a.groupe_id = b.groupe_id
AND site_id = '".$site_web['sw_id']."' 
ORDER BY a.groupe_titre
;");
while ($dbp = fetch_array_sql($dbquery)) { 
	$pv['i'] = $dbp['groupe_id'];
	$table_infos_groupe[$pv['i']]['id']		= $dbp['groupe_id'];
	$table_infos_groupe[$pv['i']]['nom']	= $dbp['groupe_nom'];
	$table_infos_groupe[$pv['i']]['titre']	= $dbp['groupe_titre'];
}

switch ( $_REQUEST['uni_gestion_des_modules_p'] ) {
	case 2:
		$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
		SELECT a.*,b.module_etat 
		FROM ".$SQL_tab['module']." a , ".$SQL_tab['site_module']." b 
		WHERE a.module_id = '".$_REQUEST['M_MODULE']['id']."'  
		AND a.module_id = b.module_id 
		AND b.site_id = '".$site_web['sw_id']."' 
		;");
		
		while ($dbp = fetch_array_sql($dbquery)) { 
			foreach ( $dbp as $A => $B ) { $currentThemeObj[$A] = $B; }
		}
		unset ( $A , $B );
	break;
	case 3:	
		$tl_['eng']['nouveau'] = "New";		$tl_['fra']['nouveau'] = "Nouveau";	
		$currentThemeObj['module_id']						= "";
		$currentThemeObj['module_deco']					= 1;
		$currentThemeObj['module_deco_nbr']				= 1;
		$currentThemeObj['module_nom']						= $tl_[$l]['nouveau'];
		$currentThemeObj['module_titre']					= $tl_[$l]['nouveau'];
		$currentThemeObj['module_fichier']					= "";
		$currentThemeObj['module_desc']					= $tl_[$l]['nouveau'];
		$currentThemeObj['module_groupe_pour_voir']		= 2;
		$currentThemeObj['module_groupe_pour_utiliser']	= 2;
		$currentThemeObj['module_etat']					= 0;
		$currentThemeObj['module_position']				= 1;
		$currentThemeObj['module_adm_control']				= 0;
		$currentThemeObj['module_execution']				= 0;
	break;
}


// --------------------------------------------------------------------------------------------
// Preparation des elements
// --------------------------------------------------------------------------------------------

$tl_['eng']['o1_l1'] = "ID";			$tl_['fra']['o1_l1'] = "ID";	
$tl_['eng']['o1_l2'] = "Name";			$tl_['fra']['o1_l2'] = "Nom";	
$tl_['eng']['o1_l3'] = "Title";			$tl_['fra']['o1_l3'] = "Titre";	
$tl_['eng']['o1_l4'] = "Description";	$tl_['fra']['o1_l4'] = "Description";

$tl_['eng']['o2_l1'] = "File";				$tl_['fra']['o2_l1'] = "Fichier";	
$tl_['eng']['o2_l2'] = "Decoration";		$tl_['fra']['o2_l2'] = "D&eacute;coration";	
$tl_['eng']['o2_l3'] = "Decoration N&deg;";	$tl_['fra']['o2_l3'] = "D&eacute;coration N&deg;";	
$tl_['eng']['o2_l4'] = "Group able to see";	$tl_['fra']['o2_l4'] = "Groupe pour voir";		
$tl_['eng']['o2_l5'] = "Group able to use";	$tl_['fra']['o2_l5'] = "Groupe pour utiliser";	
$tl_['eng']['o2_l6'] = "Admin panel";		$tl_['fra']['o2_l6'] = "Panneau d'admin";
$tl_['eng']['o2_l7'] = "Execution mode";	$tl_['fra']['o2_l7'] = "Mode d'ex&eacute;cution";

$tl_['eng']['o3_l1'] = "State";	$tl_['fra']['o3_l1'] = "Etat";


$pv['o2_l2'] = "<select name='M_MODULE[deco]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
$tl_['eng']['oui'] = "Yes";		$tl_['fra']['oui'] = "Oui";	
$tl_['eng']['non'] = "No";		$tl_['fra']['non'] = "Non";
$gm_deco['0']['t'] = $tl_[$l]['non'];	$gm_deco['0']['s'] = "";		$gm_deco['0']['db'] = "NO";
$gm_deco['1']['t'] = $tl_[$l]['oui'];	$gm_deco['1']['s'] = "";		$gm_deco['1']['db'] = "YES";
$A = $currentThemeObj['module_deco'];
$gm_deco[$A]['s'] = " selected ";
foreach ( $gm_deco as $A ) { $pv['o2_l2'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$pv['o2_l2'] .= "</select>\r";

$pv['o2_l3'] = "<select name='M_MODULE[deco_nbr]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
for ( $pv['n'] = 1 ; $pv['n'] <= $_REQUEST['compteur_bloc'] ; $pv['n']++ ) {
	$pv['b'] = "B" . sprintf("%02u",($_REQUEST['compteur_bloc_mumero'][$pv['n']]));
	$pv['NumBloc'] = decoration_nomage_bloc ( "bloc_" , $_REQUEST['compteur_bloc_mumero'][$pv['n']] , "_nom" );
	$gm_deco_nbr[$pv['n']]['t'] = $pv['b'] . " - " . ${$theme_tableau}['theme_' . $pv['NumBloc']] ;
	if ( $currentThemeObj['module_deco_nbr'] == $_REQUEST['compteur_bloc_mumero'][$pv['n']] ) { $gm_deco_nbr[$pv['n']]['s'] = " selected "; }
	else { $gm_deco_nbr[$pv['n']]['s'] = ""; }
	$gm_deco_nbr[$pv['n']]['db'] = $_REQUEST['compteur_bloc_mumero'][$pv['n']];
	$pv['b'] = $theme_tableau_a_ecrire . $_REQUEST['bloc'];
}
foreach ( $gm_deco_nbr as $A ) { $pv['o2_l3'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$pv['o2_l3'] .= "</select>\r";


$pv['o2_l4'] = "<select name='M_MODULE[groupe_pour_voir]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
$index_selection[$currentThemeObj['module_groupe_pour_voir']] = " selected";
foreach ( $table_infos_groupe as $A1 ) {
	$pv['o2_l4'] .= "<option value='".$A1['nom']."' ".$index_selection[$A1['id']]."> ".$A1['titre']." </option>\r";
}
$pv['o2_l4'] .= "</select>\r";


$pv['o2_l5'] = "<select name='M_MODULE[groupe_pour_utiliser]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
unset ($index_selection);
$index_selection[$currentThemeObj['module_groupe_pour_utiliser']] = " selected";
foreach ( $table_infos_groupe as $A1 ) {
	$pv['o2_l5'] .= "<option value='".$A1['nom']."' ".$index_selection[$A1['id']]."> ".$A1['titre']." </option>\r";
}
$pv['o2_l5'] .= "</select>\r";


$pv['o2_l6'] = "<select name='M_MODULE[module_adm_control]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
$gm_admctrl['0']['t'] = $tl_[$l]['non'];	$gm_admctrl['0']['s'] = "";		$gm_admctrl['0']['db'] = "NO";
$gm_admctrl['1']['t'] = $tl_[$l]['oui'];	$gm_admctrl['1']['s'] = "";		$gm_admctrl['1']['db'] = "YES";
$gm_admctrl[$currentThemeObj['module_adm_control']]['s'] = " selected";
foreach ( $gm_admctrl as $A1 ) {
	$pv['o2_l6'] .= "<option value='".$A1['db']."' ".$A1['s']."> ".$A1['t']." </option>\r";
}
$pv['o2_l6'] .= "</select>\r";


$tl_['eng']['o2_l7_pd'] = "During";				$tl_['fra']['o2_l7_pd'] = "Pendant";
$tl_['eng']['o2_l7_av'] = "Before";				$tl_['fra']['o2_l7_av'] = "Avant";
$tl_['eng']['o2_l7_ap'] = "After";				$tl_['fra']['o2_l7_ap'] = "Apr&egrave;s";
$pv['o2_l7'] = "<select name='M_MODULE[module_execution]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
$gm_admctrl['0']['t'] = $tl_[$l]['o2_l7_pd'];	$gm_admctrl['0']['s'] = "";		$gm_admctrl['0']['db'] = "DURING";
$gm_admctrl['1']['t'] = $tl_[$l]['o2_l7_av'];	$gm_admctrl['1']['s'] = "";		$gm_admctrl['1']['db'] = "BEFORE";
$gm_admctrl['2']['t'] = $tl_[$l]['o2_l7_ap'];	$gm_admctrl['2']['s'] = "";		$gm_admctrl['2']['db'] = "AFTER";
$gm_admctrl[$currentThemeObj['module_execution']]['s'] = " selected ";
foreach ( $gm_admctrl as $A1 ) {
	$pv['o2_l7'] .= "<option value='".$A1['db']."' ".$A1['s']."> ".$A1['t']." </option>\r";
}
$pv['o2_l7'] .= "</select>\r";


$pv['o3_l1'] = "<select name='M_MODULE[etat]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
$tl_['eng']['etat01'] = "Disabled";				$tl_['eng']['etat02'] = "Active";	$tl_['eng']['etat03'] = "Deleted";	
$tl_['fra']['etat01'] = "D&eacute;sactiv&eacute;";	$tl_['fra']['etat02'] = "Actif";	$tl_['fra']['etat03'] = "Supprim&eacute;";	

$gm_etat['0']['t'] = "D&eacute;sactiv&eacute;";	$gm_etat['0']['s'] = "";		$gm_etat['0']['db'] = "OFFLINE";
$gm_etat['1']['t'] = "Actif";					$gm_etat['1']['s'] = "";		$gm_etat['1']['db'] = "ONLINE";
$gm_etat['2']['t'] = "Supprim&eacute;";			$gm_etat['2']['s'] = "";		$gm_etat['2']['db'] = "DELETED";
$gm_etat[$currentThemeObj['module_etat']]['s'] = " selected ";
foreach ( $gm_etat as $A ) { $pv['o3_l1'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$pv['o3_l1'] .= "</select>\r";

// --------------------------------------------------------------------------------------------
//	Affichage
// --------------------------------------------------------------------------------------------
switch ( $_REQUEST['uni_gestion_des_modules_p'] ) {
	case 2:	$tl_['eng']['part1_invite'] = "This part will allow you to modify module properties.";	$tl_['fra']['part1_invite'] = "Cette partie va vous permettre de modifier les propri&eacute;t&eacute;s du module.";	break;
	case 3:	$tl_['eng']['part1_invite'] = "This part will allow you to create a module.";			$tl_['fra']['part1_invite'] = "Cette partie va vous permettre de cr&eacute;er un module.";	break;
}

echo ("
<form ACTION='index.php?' method='post' name='formulaire_module'>\r
<p>\r
". $tl_[$l]['part1_invite'] ."<br>\r
<br>\r
</p>\r
");

if ( $_REQUEST['M_MODULE']['confirmation_modification_oubli'] == 1 ) { 
	$tl_['eng']['confirmation_modification_oubli'] = "You forgot to confirm the module modification.";
	$tl_['fra']['confirmation_modification_oubli'] = "Vous n'avez pas confirm&eacute; la modification du module.";
	echo ("<p class='" . $theme_tableau . $_REQUEST['bloc']."_erreur " . $theme_tableau . $_REQUEST['bloc']."_tb3'>".$tl_[$l]['confirmation_modification_oubli']."</p>\r"); 
}
if ( $_REQUEST['M_MODULE']['confirmation_suppression_oubli'] == 1 ) {
	$tl_['eng']['confirmation_suppression_oubli'] = "You forgot to confirm the module deletion.";
	$tl_['fra']['confirmation_suppression_oubli'] = "Vous n'avez pas confirm&eacute; la suppression du module.";
	echo ("<p class='" . $theme_tableau . $_REQUEST['bloc']."_erreur " . $theme_tableau . $_REQUEST['bloc']."_tb3'>".$tl_[$l]['confirmation_suppression_oubli']."</p>\r");
}


$AD['1']['1']['1']['cont'] = $tl_[$l]['o1_l1'];
$AD['1']['2']['1']['cont'] = $tl_[$l]['o1_l2'];
$AD['1']['3']['1']['cont'] = $tl_[$l]['o1_l3'];
$AD['1']['4']['1']['cont'] = $tl_[$l]['o1_l4'];


$AD['1']['1']['2']['cont'] = $currentThemeObj['module_id'];
switch ( $_REQUEST['uni_gestion_des_modules_p'] ) {
	case 2:		$AD['1']['2']['2']['cont'] = $currentThemeObj['module_nom'];			break;
	case 3:		$AD['1']['2']['2']['cont'] = "<input type='text' name='M_MODULE[nom]' size='35' maxlength='255' value=\"".$currentThemeObj['module_titre']."\" class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";		
				$AD['1']['1']['2']['cont'] = "*";
	break;
}
$AD['1']['3']['2']['cont'] = "<input type='text' name='M_MODULE[titre]' size='35' maxlength='255' value=\"".$currentThemeObj['module_titre']."\" class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
$AD['1']['4']['2']['cont'] = "<input type='text' name='M_MODULE[desc]' size='35' maxlength='255' value=\"".$currentThemeObj['module_desc']."\" class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";

$_REQUEST['FS_index']++;
$fsi = &$_REQUEST['FS_table'][$_REQUEST['FS_index']];
$fsi['left']					= 16;
$fsi['top']						= 16;
$fsi['width']					= 768;
$fsi['height']					= 512;
$fsi['js_cs']					= "";
$fsi['formulaire']				= "formulaire_module";
$fsi['champs']					= "M_MODULE[fichier]";
$fsi['lsdf_chemin']				= "../modules/";
$fsi['mode_selection']			= "fichier";
$fsi['lsdf_mode']				= "tout";
$fsi['lsdf_nivmax']				= 10;
$fsi['lsdf_indicatif']			= "SDFGDMP2";
$fsi['lsdf_parent_idx']			= 1;
$fsi['lsdf_parent']['0']		= "TabSDF_".$fsi['lsdf_indicatif'];
$fsi['lsdf_parent']['1']		= "TabSDF_".$fsi['lsdf_indicatif'];
$fsi['lsdf_racine']				= "F";
$fsi['lsdf_coupe_chemin']		= 0;
$fsi['lsdf_conserve_chemin']	= "";
$fsi['lsdf_coupe_repertoire']	= 0;
$fsi['liste_fichier']			= array();

$AD['2']['1']['1']['cont'] = $tl_[$l]['o2_l1'];
$AD['2']['2']['1']['cont'] = $tl_[$l]['o2_l2'];
$AD['2']['3']['1']['cont'] = $tl_[$l]['o2_l3'];
$AD['2']['4']['1']['cont'] = $tl_[$l]['o2_l4'];
$AD['2']['5']['1']['cont'] = $tl_[$l]['o2_l5'];
$AD['2']['6']['1']['cont'] = $tl_[$l]['o2_l6'];
$AD['2']['7']['1']['cont'] = $tl_[$l]['o2_l7'];

$AD['2']['1']['2']['cont'] = generation_icone_selecteur_fichier ( 1 , $fsi['formulaire'] , $fsi['champs'] , 20 , $currentThemeObj['module_fichier'] , "TabSDF_".$fsi['lsdf_indicatif'] );
$AD['2']['2']['2']['cont'] = $pv['o2_l2'];
$AD['2']['3']['2']['cont'] = $pv['o2_l3'];
$AD['2']['4']['2']['cont'] = $pv['o2_l4'];
$AD['2']['5']['2']['cont'] = $pv['o2_l5'];
$AD['2']['6']['2']['cont'] = $pv['o2_l6'];
$AD['2']['7']['2']['cont'] = $pv['o2_l7'];


$AD['3']['1']['1']['cont'] = $tl_[$l]['o3_l1'];
$AD['3']['1']['2']['cont'] = $pv['o3_l1'];


$ADC['onglet']['1']['nbr_ligne'] = 4;	$ADC['onglet']['1']['nbr_cellule'] = 2;	$ADC['onglet']['1']['legende'] = 2;
$ADC['onglet']['2']['nbr_ligne'] = 7;	$ADC['onglet']['2']['nbr_cellule'] = 2;	$ADC['onglet']['2']['legende'] = 2;
$ADC['onglet']['3']['nbr_ligne'] = 1;	$ADC['onglet']['3']['nbr_cellule'] = 2;	$ADC['onglet']['3']['legende'] = 2;

$tl_['eng']['onglet_1'] = "Informations";	$tl_['fra']['onglet_1'] = "Informations";
$tl_['eng']['onglet_2'] = "Configuration";	$tl_['fra']['onglet_2'] = "Configuration";	
$tl_['eng']['onglet_3'] = "State";			$tl_['fra']['onglet_3'] = "Etat";	

$tab_infos['AffOnglet']			= 1;
$tab_infos['NbrOnglet']			= 3;
$tab_infos['tab_comportement']	= 1;
$tab_infos['mode_rendu']		= 0;	// 0 echo 1 dans une variable
$tab_infos['TypSurbrillance']	= 0; // 1:ligne, 2:cellule
$tab_infos['doc_height']		= 320;
$tab_infos['doc_width']			= ${$theme_tableau}['theme_module_largeur_interne'] -16 ;
$tab_infos['groupe']			= "mm_grp1";
$tab_infos['cell_id']			= "tab";
$tab_infos['document']			= "doc";
$tab_infos['cell_1_txt']		= $tl_[$l]['onglet_1'];
$tab_infos['cell_2_txt']		= $tl_[$l]['onglet_2'];
$tab_infos['cell_3_txt']		= $tl_[$l]['onglet_3'];
include ("routines/website/affichage_donnees.php");

// --------------------------------------------------------------------------------------------
$tl_['eng']['bouton2'] = "Return to list";		$tl_['fra']['bouton2'] = "Retour &agrave; la liste";	
$tl_['eng']['bouton3'] = "Delete";				$tl_['eng']['text_confirm3'] = "I confirm the module deletion. Confirm with the checkbox and click on delete. <span class='" . $theme_tableau . $_REQUEST['bloc']."_avert " . $theme_tableau . $_REQUEST['bloc']."_tb3'>ATTENTION</span> There is <span style='font-weight: bold;'>NO</span> turning back with this operation.</span>";	
$tl_['fra']['bouton3'] = "Supprimer";		$tl_['fra']['text_confirm3'] = "Je valide la suppression du module. Confirmez avec le checkbox et cliquez sur supprimer. <span class='" . $theme_tableau . $_REQUEST['bloc']."_avert " . $theme_tableau . $_REQUEST['bloc']."_tb3'>ATTENTION</span> il n'y a <span style='font-weight: bold;'>PAS</span> de retour arri&egrave;re pour cette op&eacute;ration.</span>";	

switch ( $_REQUEST['uni_gestion_des_modules_p'] ) {
case 2:
	$tl_['eng']['bouton1'] = "Modify";
	$tl_['fra']['bouton1'] = "Modifier";		
	$tl_['eng']['text_confirm1'] = "I confirm the module modifications.";	$tl_['fra']['text_confirm1'] = "Je valide la modification du module.";	
	$pv['update_action'] = "UPDATE_MODULE";	 
break;
case 3:		
	$tl_['eng']['bouton1'] = "Create";		
	$tl_['fra']['bouton1'] = "Cr&eacute;er";	
	$tl_['eng']['text_confirm1'] = "I confirm the module modifications.";	$tl_['fra']['text_confirm1'] = "Je valide la modification du module.";	
	$pv['update_action'] = "ADD_MODULE";
break;
}

echo (
$bloc_html['post_hidden_sw'].
$bloc_html['post_hidden_l'].
$bloc_html['post_hidden_arti_ref'].
$bloc_html['post_hidden_arti_page'].
$bloc_html['post_hidden_user_login'].
$bloc_html['post_hidden_user_pass'].
"
<br>\r
<table ".${$theme_tableau}['tab_std_rules']." width='".${$theme_tableau}['theme_module_largeur_interne']."px;'>\r

<tr>\r
<td style='width: ".(${$theme_tableau}['theme_module_largeur_interne'] - 200)."px;'>\r
<input type='hidden' name='UPDATE_action'				value='".$pv['update_action']."'>\r
");
switch ( $_REQUEST['uni_gestion_des_modules_p'] ) {
case 2;
	echo ("
	<input type='hidden' name='M_MODULE[nom]'						value='".$currentThemeObj['module_nom']."'>\r
	<input type='hidden' name='arti_page'					value='2'>\r
	<input type='hidden' name='uni_gestion_des_modules_p'	value='".$_REQUEST['uni_gestion_des_modules_p']."'>\r
	<input type='checkbox' name='M_MODULE[confirmation_modification]'> ".$tl_[$l]['text_confirm1']."\r
	");
break;
case 3; 
	echo ("
	<input type='hidden' name='arti_page'	value='1'>\r
	<input type='hidden' name='uni_gestion_des_modules_p'	value='".$_REQUEST['uni_gestion_des_modules_p']."'>\r
	");
break;
}
echo ("
</td>\r
<td style='width: 200px;'>\r
");
$_REQUEST['BS']['id']				= "bouton_modification_module";
$_REQUEST['BS']['type']				= "submit";
$_REQUEST['BS']['style_initial']	= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s2_n";
$_REQUEST['BS']['style_hover']		= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s2_h";
$_REQUEST['BS']['onclick']			= "";
$_REQUEST['BS']['message']			= $tl_[$l]['bouton1'];
$_REQUEST['BS']['mode']				= 1;
$_REQUEST['BS']['taille'] 			= 128;
$_REQUEST['BS']['derniere_taille']	= 0;
echo generation_bouton ();
echo ("
<br>\r&nbsp;
</td>\r
</tr>\r
</table>\r
</form>\r


<form ACTION='index.php?' method='post'>\r
".
$bloc_html['post_hidden_sw'].
$bloc_html['post_hidden_l'].
$bloc_html['post_hidden_arti_ref'].
"<input type='hidden' name='arti_page' value='1'>\r".
$bloc_html['post_hidden_user_login'].
$bloc_html['post_hidden_user_pass'].
"<table ".${$theme_tableau}['tab_std_rules']." width='".${$theme_tableau}['theme_module_largeur_interne']."px;'>\r
<tr>\r
<td style='width: ".(${$theme_tableau}['theme_module_largeur_interne'] - 200)."px;'>\r
</td>\r
<td style='width: 200px;'>\r
");
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
</td>\r
</tr>\r
</table>\r
</form>\r
");

switch ( $_REQUEST['uni_gestion_des_modules_p'] ) {
	case 2:
		echo ("
		<form ACTION='index.php?' method='post'>\r
		".
		$bloc_html['post_hidden_sw'].
		$bloc_html['post_hidden_l'].
		$bloc_html['post_hidden_arti_ref'].
		$bloc_html['post_hidden_arti_page'].
		$bloc_html['post_hidden_user_login'].
		$bloc_html['post_hidden_user_pass'].
		"
		<input type='hidden' name='UPDATE_action'		value='DELETE_MODULE'>\r
		<input type='hidden' name='M_MODULE[nom]'				value='".$currentThemeObj['module_nom']."'>\r
		<table ".${$theme_tableau}['tab_std_rules']." width='".${$theme_tableau}['theme_module_largeur_interne']."px;'>\r
		<tr>\r
		<td style='width: ".(${$theme_tableau}['theme_module_largeur_interne'] - 200)."px;'>\r
		<input type='checkbox' name='M_MODULE[confirmation_suppression]' value='1'>".$tl_[$l]['text_confirm3']."\r
		</td>\r
		<td style='width: 200px;'>\r
		");
		$_REQUEST['BS']['id']				= "bouton_suppression";
		$_REQUEST['BS']['type']				= "submit";
		$_REQUEST['BS']['style_initial']	= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s3_n";
		$_REQUEST['BS']['style_hover']		= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s3_h";
		$_REQUEST['BS']['onclick']			= "";
		$_REQUEST['BS']['message']			= $tl_[$l]['bouton3'];
		$_REQUEST['BS']['mode']				= 1;
		$_REQUEST['BS']['taille'] 			= 0;
		echo generation_bouton ();
		echo ("
		<br>\r&nbsp;
		</td>\r
		</tr>\r
		</table>\r
		</form>\r
		");
	break;
}



if ( $site_web['sw_info_debug'] < 10 ) {
	unset (
		$A, 
		$A1, 
		$A2, 
		$dbp, 
		$dbquery , 
		$gm_admctrl, 
		$gm_deco, 
		$gm_deco_nbr, 
		$gm_etat, 
		$index_selection, 
		$MM_oubli_confirmation_mod, 
		$MM_oubli_confirmation_sup, 
		$module_cible_, 
		$AD,
		$ADC,
		$pv, 
		$tab_infos, 
		$table_infos_groupe, 
		$currentThemeObj, 
		$tl_  
	);
}

/*Hydre-contenu_fin*/
?>
