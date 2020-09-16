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
$_REQUEST['M_GROUPE']['groupe_selection'] = 3;
$_REQUEST['uni_gestion_des_groupe_p'] = 2;

/*Hydre-contenu_debut*/
$_REQUEST['sql_initiateur'] = "uni_gestion_des_groupes_p02.php";

// --------------------------------------------------------------------------------------------
// Preparation des tables
// --------------------------------------------------------------------------------------------
switch ( $_REQUEST['uni_gestion_des_groupe_p'] ) {
case 2:
	$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
	SELECT * 
	FROM ".$SQL_tab_abrege['groupe']." 
	WHERE groupe_id = '".$_REQUEST['M_GROUPE']['groupe_selection']."'
	;");

	while ($dbp = fetch_array_sql($dbquery)) { 
		foreach ( $dbp as $A => $B ) { $groupe[$A] = $B; }
	}
break;
case 3:
	$tl_['eng']['creation_nom'] = "New_group_name";			$tl_['fra']['creation_nom'] = "Nouveau_groupe";
	$tl_['eng']['creation_titre'] = "New_group";			$tl_['fra']['creation_titre'] = "Nouveau_groupe";
	$tl_['eng']['creation_desc'] = "New group desc";		$tl_['fra']['creation_desc'] = "Description nouveau groupe";

	$groupe = array (
		"groupe_id" => "*",
		"groupe_tag" => 0,
		"groupe_nom" => $tl_[$l]['creation_nom'],
		"groupe_titre" => $tl_[$l]['creation_titre'],
		"groupe_desc" => $tl_[$l]['creation_desc']
	);
break;
}

// --------------------------------------------------------------------------------------------
// Preparation des elements
// --------------------------------------------------------------------------------------------
$tl_['eng']['bcl_etat0'] = "Anonymous";			$tl_['fra']['bcl_etat0'] = "Anonyme";	
$tl_['eng']['bcl_etat1'] = "Reader";			$tl_['fra']['bcl_etat1'] = "Lecteur";	
$tl_['eng']['bcl_etat2'] = "Staff";				$tl_['fra']['bcl_etat2'] = "Staff";
$tl_['eng']['bcl_etat3'] = "Senior Staff";		$tl_['fra']['bcl_etat3'] = "Staff Senior";

$tl_['eng']['l1'] = "ID";			$tl_['fra']['l1'] = "ID";		
$tl_['eng']['l2'] = "Name";			$tl_['fra']['l2'] = "Nom";		
$tl_['eng']['l3'] = "Title";		$tl_['fra']['l3'] = "Titre";	
$tl_['eng']['l4'] = "Tag";			$tl_['fra']['l4'] = "Tag";
$tl_['eng']['l5'] = "Description";	$tl_['fra']['l5'] = "Description";
$tl_['eng']['l6'] = "File";			$tl_['fra']['l6'] = "Fichier";

$pv['o1l4'] = "<select name ='M_GROUPE[tag]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
$tab_tag['0']['t'] = $tl_[$l]['bcl_etat0'];	$tab_tag['0']['db'] = "ANONYMOUS";
$tab_tag['1']['t'] = $tl_[$l]['bcl_etat1'];	$tab_tag['1']['db'] = "READER";
$tab_tag['2']['t'] = $tl_[$l]['bcl_etat2'];	$tab_tag['2']['db'] = "STAFF";
$tab_tag['3']['t'] = $tl_[$l]['bcl_etat3'];	$tab_tag['3']['db'] = "SENIOR_STAFF";

switch ( $_REQUEST['uni_gestion_des_groupe_p'] ) {
	case 2 :	$tab_tag[$groupe['groupe_tag']]['s'] = " selected";	break;
	case 3:		$tab_tag[1]['s'] = " selected";	break;
}
foreach ( $tab_tag as $A ) { $pv['o1l4'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$pv['o1l4'] .= "</select>\r";

// --------------------------------------------------------------------------------------------
//	Affichage
// --------------------------------------------------------------------------------------------
if ( $_REQUEST['M_GROUPE']['confirmation_modification_oubli'] == 1 && $_REQUEST['uni_gestion_des_groupe_p'] == 2 ) { 
	$tl_['eng']['err'] = "You didn't confirm the group updates.";
	$tl_['fra']['err'] = "Vous n'avez pas confirm&eacute; la modification du groupes";
	echo ("<p class='".$theme_tableau."s0".$module_['module_deco_nbr']."_erreur2'>".$tl_[$l]['err']."<br>\r"); 
}

// --------------------------------------------------------------------------------------------
switch ( $_REQUEST['uni_gestion_des_groupe_p'] ) {
case 2:
	$tl_['eng']['invite1'] = "This part will allow you to modify groups.";
	$tl_['fra']['invite1'] = "Cette partie va vous permettre de modifier les groupes.";
	$pv['o1l2'] = $groupe['groupe_nom'];
break;
case 3:
	$tl_['eng']['invite1'] = "This part will allow you to create groups.";
	$tl_['fra']['invite1'] = "Cette partie va vous permettre de cr&eacute;er des groupes.";
	$pv['o1l2'] = "<input type='text' name='M_GROUPE[nom]' size='45' maxlength='255' value=\"".$groupe['groupe_nom']."\" class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
break;
}

echo ("
<form ACTION='index.php?' method='post' name='formulaire_ug'>\r
<p>".$tl_[$l]['invite1']."</p>
");

$_REQUEST['FS_index']++;
$fsi = &$_REQUEST['FS_table'][$_REQUEST['FS_index']];
$fsi['left']					= 16;
$fsi['top']						= 16;
$fsi['width']					= 768;
$fsi['height']					= 512;
$fsi['js_cs']					= "";
$fsi['formulaire']				= "formulaire_ug";
$fsi['champs']					= "M_GROUPE[fichier]";
$fsi['lsdf_chemin']				= "../graph/universel/";
$fsi['mode_selection']			= "fichier";
$fsi['lsdf_mode']				= "tout";
$fsi['lsdf_nivmax']				= 5;
$fsi['lsdf_indicatif']			= "SDFGDGP2";
$fsi['lsdf_parent_idx']			= 1;
$fsi['lsdf_parent']['0']		= "TabSDF_".$fsi['lsdf_indicatif'];
$fsi['lsdf_parent']['1']		= "TabSDF_".$fsi['lsdf_indicatif'];
$fsi['lsdf_racine']				= "F";
$fsi['lsdf_coupe_chemin']		= 1;
$fsi['lsdf_conserve_chemin']	= "graph/universel/";
$fsi['lsdf_coupe_repertoire']	= 0;
$fsi['liste_fichier']			= array();

$AD['1']['1']['1']['cont'] = $tl_[$l]['l1'];
$AD['1']['2']['1']['cont'] = $tl_[$l]['l2'];
$AD['1']['3']['1']['cont'] = $tl_[$l]['l3'];
$AD['1']['4']['1']['cont'] = $tl_[$l]['l4'];
$AD['1']['5']['1']['cont'] = $tl_[$l]['l5'];
$AD['1']['6']['1']['cont'] = $tl_[$l]['l6'];

$AD['1']['1']['2']['cont'] = $groupe['groupe_id'];
$AD['1']['2']['2']['cont'] = $pv['o1l2'];
$AD['1']['3']['2']['cont'] = "<input type='text' name='M_GROUPE[titre]' size='45' maxlength='255' value=\"".$groupe['groupe_titre']."\" class='" . $theme_tableau.$_REQUEST['bloc']."_t3 " . $theme_tableau.$_REQUEST['bloc']."_form_1'>\r";
$AD['1']['4']['2']['cont'] = $pv['o1l4'];
$AD['1']['5']['2']['cont'] = "<input type='text' name='M_GROUPE[desc]' size='45' maxlength='255' value=\"".$groupe['groupe_desc']."\" class='" . $theme_tableau.$_REQUEST['bloc']."_t3 " . $theme_tableau.$_REQUEST['bloc']."_form_1'>\r";
$AD['1']['6']['2']['cont'] = generation_icone_selecteur_fichier ( 3 , $fsi['formulaire'] , $fsi['champs'] , 40 , $groupe['groupe_fichier'] , "TabSDF_".$fsi['lsdf_indicatif'] );

$ADC['onglet']['1']['nbr_ligne'] = 6;	$ADC['onglet']['1']['nbr_cellule'] = 2;	$ADC['onglet']['1']['legende'] = 2;

$tl_['eng']['onglet_1'] = "Informations";		$tl_['fra']['onglet_1'] = "Informations";

$tab_infos['AffOnglet']			= 1;
$tab_infos['NbrOnglet']			= 1;
$tab_infos['tab_comportement']	= 0;
$tab_infos['mode_rendu']		= 0;	// 0 echo 1 dans une variable
$tab_infos['TypSurbrillance']	= 0; // 1:ligne, 2:cellule
$tab_infos['doc_height']		= 256;
$tab_infos['doc_width']			= ${$theme_tableau}['theme_module_largeur_interne'];
$tab_infos['groupe']			= "mg_grp1";
$tab_infos['cell_id']			= "tab";
$tab_infos['document']			= "doc";
$tab_infos['cell_1_txt']		= $tl_[$l]['onglet_1'];
include ("routines/website/affichage_donnees.php");

// --------------------------------------------------------------------------------------------
switch ( $_REQUEST['uni_gestion_des_groupe_p'] ) {
case 2:
	$tl_['eng']['text_confirm1'] = "I confirm the group modifications.";			$tl_['eng']['bouton1'] = "Modify";
	$tl_['fra']['text_confirm1'] = "Je valide la modification du groupe.";		$tl_['fra']['bouton1'] = "Modifier";
	$pv['groupe_UPDATE_action'] = "UPDATE_GROUP";
break;
case 3:	
	$tl_['eng']['bouton1'] = "Create";
	$tl_['fra']['bouton1'] = "Cr&eacute;er";
	$pv['groupe_UPDATE_action'] = "ADD_GROUP";
break;
}
$tl_['eng']['bouton2'] = "Return to list";
$tl_['fra']['bouton2'] = "Retour &agrave; la liste";

echo ("
<br>\r
<br>\r

<input type='hidden' name='UPDATE_action'				value='".$pv['groupe_UPDATE_action']."'>\r
<input type='hidden' name='uni_gestion_des_groupe_p'	value='".$_REQUEST['uni_gestion_des_groupe_p']."'>\r

<table ".${$theme_tableau}['tab_std_rules']." width='".${$theme_tableau}['theme_module_largeur_interne']."'>\r
<tr>\r".
$bloc_html['post_hidden_sw'].
$bloc_html['post_hidden_l'].
$bloc_html['post_hidden_arti_ref'].
$bloc_html['post_hidden_arti_page'].
$bloc_html['post_hidden_user_login'].
$bloc_html['post_hidden_user_pass'].
"<td>\r");

switch ( $_REQUEST['uni_gestion_des_groupe_p'] ) {
case 2:
	echo ("
	<input type='checkbox' name='M_GROUPE[confirmation_modification]' value='1'>".$tl_[$l]['text_confirm1']."\r
	<input type='hidden' name='arti_page'	value='2'>\r
	<input type='hidden' name='M_GROUPE[nom]'							value='".$groupe['groupe_nom']."'>\r
	");
break;
case 3:
	echo ("<input type='hidden' name='arti_page'	value='1'>\r");
break;
}

echo ("</td>\r<td>\r");
$_REQUEST['BS']['id']				= "bouton_modification";
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
echo ("<br>\r&nbsp;</td>\r
</tr>\r
</form>\r
</table>\r
");

if ( $site_web['sw_info_debug'] < 10 ) {
	unset (
		$groupe,
		$dbp,
		$dbquery,
		$AD,
		$ADC,
		$pv,
		$tab_tag,
		$tl_
	);
}

/*Hydre-contenu_fin*/
?>
