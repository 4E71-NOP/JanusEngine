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
/* $_REQUEST[module_selection] = 4; */
$_REQUEST['M_MOTCLE']['mot_cle_selection'] = 1 ;
$_REQUEST['M_MOTCLE']['uni_gestion_des_motcle_p'] = 3;

// --------------------------------------------------------------------------------------------
//	2008 03 29 : fra_gestion_des_mots_cles_p02.php debut
//	2008 00 00 : derniere modification
// --------------------------------------------------------------------------------------------
/*Hydre-contenu_debut*/
$_REQUEST['sql_initiateur'] = "fra_gestion_des_mots_cles_p02";

// --------------------------------------------------------------------------------------------
// Preparation des tables
// --------------------------------------------------------------------------------------------

$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
SELECT art.arti_id, art.arti_nom  
FROM ".$SQL_tab['article']." art, ".$SQL_tab['categorie']." cat 
WHERE art.site_id = '".$site_web['sw_id']."'
AND cat.site_id = '".$site_web['sw_id']."'
AND cat.arti_ref = art.arti_ref 
AND cat.arti_ref != '0' 
AND cat.cate_type IN ('0','1') 
AND cat.cate_lang = '".$site_web['sw_lang']."' 
;");
while ($dbp = fetch_array_sql($dbquery)) { 
	$info_a_[$dbp['arti_id']]['t']	=	$info_a_[$dbp['arti_id']]['db']	= $dbp['arti_nom'];
}



switch ( $_REQUEST['M_MOTCLE']['uni_gestion_des_motcle_p'] ) {
case 2:
	$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
	SELECT * 
	FROM ".$SQL_tab['mot_cle']." 
	WHERE mc_id = '".$_REQUEST['M_MOTCLE']['mot_cle_selection']."' 
	AND site_id = '".$site_web['sw_id']."' 
	;");
	while ($dbp = fetch_array_sql($dbquery)) { 
		foreach ( $dbp as $A => $B ) { $info_mc_[$A] = $B; }
	}
	$info_a_[$info_mc_['arti_id']]['s'] = " selected ";

	$tl_['eng']['part1_invite'] = "This part will allow you to modify a keyword.";
	$tl_['fra']['part1_invite'] = "Cette partie va vous permettre de modifier un mot cl&eacute;.";
	$pv['o1_l2'] = $info_mc_['mc_nom'];

break;
case 3:
	$info_mc_['mc_nom'] = "Nouveau_mot_cle-" . date ( "Y_m_j_-_G_i_s", mktime() );
	$info_mc_['mc_etat'] = 1;
	$info_mc_['mc_chaine'] = "abcd";
	$info_mc_['mc_compteur'] = 1;
	$info_mc_['mc_type'] = 3;
	$info_mc_['mc_donnee'] = "abcd";

	$tl_['eng']['part1_invite'] = "This part will allow you to create a keyword.";
	$tl_['fra']['part1_invite'] = "Cette partie va vous permettre de cr&eacute;er un mot cl&eacute;.";

	$pv['o1_l2'] = "<input type='text' name='M_MOTCLE[nom]' size='35' maxlength='255' value='".$info_mc_['mc_nom']."' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";

break;
}

// --------------------------------------------------------------------------------------------
// Preparation des elements
// --------------------------------------------------------------------------------------------
$tl_['eng']['l1'] = "Id";					$tl_['fra']['l1'] = "Id";	
$tl_['eng']['l2'] = "Name";					$tl_['fra']['l2'] = "Nom";	
$tl_['eng']['l3'] = "State";				$tl_['fra']['l3'] = "Etat";	
$tl_['eng']['l4'] = "Article";				$tl_['fra']['l4'] = "Article";	
$tl_['eng']['l5'] = "String";				$tl_['fra']['l5'] = "Chaine";	
$tl_['eng']['l6'] = "Count";				$tl_['fra']['l6'] = "Compteur";	
$tl_['eng']['l7'] = "Type";					$tl_['fra']['l7'] = "Type";	
$tl_['eng']['l8'] = "Data";					$tl_['fra']['l8'] = "Donn&eacute;e";	


$pv['o1_l3'] = "<select name='M_MOTCLE[etat]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
$tl_['eng']['ms_1_01'] = "Offline";					$tl_['fra']['ms_1_01'] = "Hors ligne";
$tl_['eng']['ms_1_02'] = "Online";					$tl_['fra']['ms_1_02'] = "En ligne";
$gmc_etat['0']['t'] = $tl_[$l]['ms_1_01'];		$gmc_etat['0']['s'] = "";		$gmc_etat['0']['db'] = "OFFLINE";
$gmc_etat['1']['t'] = $tl_[$l]['ms_1_02'];		$gmc_etat['1']['s'] = "";		$gmc_etat['1']['db'] = "ONLINE";
$gmc_etat[$info_mc_['mc_etat']]['s'] = " selected ";
foreach ( $gmc_etat as $A ) { $pv['o1_l3'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
unset ($A);
$pv['o1_l3'] .= "</select>\r";


$pv['o1_l4'] = "<select name='M_MOTCLE[article]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
foreach ( $info_a_ as $A ) { $pv['o1_l4'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
unset ($A);
$pv['o1_l4'] .= "</select>\r";


$pv['o1_l7'] = "<select name='M_MOTCLE[type]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
$tl_['eng']['ms_2_01'] = "Link to a category";				$tl_['fra']['ms_2_01'] = "Vers une cat&eacute;gorie";
$tl_['eng']['ms_2_02'] = "Link to an URL";					$tl_['fra']['ms_2_02'] = "Vers une URL";
$tl_['eng']['ms_2_03'] = "Dynamic help";					$tl_['fra']['ms_2_03'] = "Aide dynamique";
$gmc_type['1']['t'] = $tl_[$l]['ms_2_01'];		$gmc_type['1']['s'] = "";		$gmc_type['1']['db'] = "VERS_CATEGORIE";
$gmc_type['2']['t'] = $tl_[$l]['ms_2_02'];		$gmc_type['2']['s'] = "";		$gmc_type['2']['db'] = "VERS_URL";
$gmc_type['3']['t'] = $tl_[$l]['ms_2_03'];		$gmc_type['3']['s'] = "";		$gmc_type['3']['db'] = "VERS_AIDE_DYNAMIQUE";
$gmc_type[$info_mc_['mc_type']]['s'] = " selected ";
foreach ( $gmc_type as $A ) { $pv['o1_l7'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
unset ($A);
$pv['o1_l7'] .= "</select>\r";

// --------------------------------------------------------------------------------------------
//	Affichage
// --------------------------------------------------------------------------------------------
echo ("
<form ACTION='index.php?' method='post' name='formulaire_mot_cle'>\r
<p>\r
". $tl_[$l]['part1_invite'] ."<br>\r
<br>\r
</p>\r
");

if ( $_REQUEST['M_MOTCLE']['confirmation_modification_oubli'] == 1 ) { 
	$tl_['eng']['confirmation_modification_oubli'] = "You forgot to confirm the keyword modification.";
	$tl_['fra']['confirmation_modification_oubli'] = "Vous n'avez pas confirm&eacute; la modification du mot cl&eacute;.";
	echo ("<p class='" . $theme_tableau . $_REQUEST['bloc']."_erreur " . $theme_tableau . $_REQUEST['bloc']."_tb3'>".$tl_[$l]['confirmation_modification_oubli']."</p>\r"); 
}

$AD['1']['1']['1']['cont'] = $tl_[$l]['l1'];
$AD['1']['2']['1']['cont'] = $tl_[$l]['l2'];
$AD['1']['3']['1']['cont'] = $tl_[$l]['l3'];
$AD['1']['4']['1']['cont'] = $tl_[$l]['l4'];
$AD['1']['5']['1']['cont'] = $tl_[$l]['l5'];
$AD['1']['6']['1']['cont'] = $tl_[$l]['l6'];
$AD['1']['7']['1']['cont'] = $tl_[$l]['l7'];
$AD['1']['8']['1']['cont'] = $tl_[$l]['l8'];

$AD['1']['1']['2']['cont'] = $info_mc_['mc_id'];
$AD['1']['2']['2']['cont'] = $pv['o1_l2'];
$AD['1']['3']['2']['cont'] = $pv['o1_l3'];
$AD['1']['4']['2']['cont'] = $pv['o1_l4'];
$AD['1']['5']['2']['cont'] = "<input type='text' name='M_MOTCLE[chaine]' size='35' maxlength='255' value='".$info_mc_['mc_chaine']."' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
$AD['1']['6']['2']['cont'] = "<input type='text' name='M_MOTCLE[compteur]' size='35' maxlength='255' value='".$info_mc_['mc_compteur']."' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
$AD['1']['7']['2']['cont'] = $pv['o1_l7'];
$AD['1']['8']['2']['cont'] = "<input type='text' name='M_MOTCLE[donnee]' size='35' maxlength='255' value='".$info_mc_['mc_donnee']."' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";

$ADC['onglet']['1']['nbr_ligne'] = 8;	$ADC['onglet']['1']['nbr_cellule'] = 2;	$ADC['onglet']['1']['legende'] = 2;

$tl_['eng']['onglet_1'] = "Informations";	$tl_['fra']['onglet_1'] = "Informations";

$tab_infos['AffOnglet']			= 1;
$tab_infos['NbrOnglet']			= 1;
$tab_infos['tab_comportement']	= 1		// Comportement des onglets
$tab_infos['mode_rendu']		= 0;	// 0 echo 1 dans une variable
$tab_infos['TypSurbrillance']	= 0; // 1:ligne, 2:cellule
$tab_infos['doc_height']		= 320;
$tab_infos['doc_width']			= ${$theme_tableau}['theme_module_largeur_interne'] -24 ;
$tab_infos['groupe']			= "mcc_grp1";
$tab_infos['cell_id']			= "tab";
$tab_infos['document']			= "doc";
$tab_infos['cell_1_txt']		= $tl_[$l]['onglet_1'];
include ("routines/website/affichage_donnees.php");


// --------------------------------------------------------------------------------------------

switch ( $_REQUEST['M_MOTCLE']['uni_gestion_des_motcle_p'] ) {
case 2:
	$tl_['eng']['bouton1'] = "Modify";			$tl_['eng']['text_confirm1'] = "I confirm the keyword modifications.";	
	$tl_['fra']['bouton1'] = "Modifier";	$tl_['fra']['text_confirm1'] = "Je valide la modification du mot cl&eacute;.";
	$pv['bouton1_action'] = "UPDATE_KEYWORD";
	$pv['check_modif1'] = "<td style='width: ".(${$theme_tableau}['theme_module_largeur_interne'] - 256)."px;'>\r
	<input type='checkbox' name='M_MOTCLE[confirmation_modification]'> ".$tl_[$l]['text_confirm1']."\r
	</td>\r";
	$pv['bouton1_page'] = 2;
	$pv['uni_gestion_des_motcle_p'] = "<input type='hidden' name='M_MOTCLE[uni_gestion_des_motcle_p]'	value='2'>\r";

	$tl_['eng']['bouton3'] = "Delete";			$tl_['eng']['text_confirm3'] = "I confirm the keyword deletion. Confirm with the checkbox and click on delete. <span class='" . $theme_tableau . $_REQUEST['bloc']."_avert " . $theme_tableau . $_REQUEST['bloc']."_tb3'>ATTENTION</span> There is <span style='font-weight: bold;'>NO</span> turning back with this operation.</span>";	
	$tl_['fra']['bouton3'] = "Supprimer";	$tl_['fra']['text_confirm3'] = "Je valide la suppression du mot cl&eacute;. Confirmez avec le checkbox et cliquez sur supprimer. <span class='" . $theme_tableau . $_REQUEST['bloc']."_avert " . $theme_tableau . $_REQUEST['bloc']."_tb3'>ATTENTION</span> il n'y a <span style='font-weight: bold;'>PAS</span> de retour arri&egrave;re pour cette op&eacute;ration.</span>";	
break;
case 3:
	$tl_['eng']['bouton1'] = "Create";	
	$tl_['fra']['bouton1'] = "Cr&eacute;er";
	$pv['bouton1_action'] = "ADD_KEYWORD";
	$pv['check_modif1'] = "<td style='width: ".(${$theme_tableau}['theme_module_largeur_interne'] - 256)."px;'>\r&nbsp</td>\r";
	$pv['bouton1_page'] = 1;
	$pv['uni_gestion_des_motcle_p'] = "";
break;
}

$tl_['eng']['bouton2'] = "Back to the list";
$tl_['fra']['bouton2'] = "Retour &agrave; la liste";


echo (
$bloc_html['post_hidden_sw'].
$bloc_html['post_hidden_l'].
$bloc_html['post_hidden_arti_ref']."
<input type='hidden' name='arti_page'						value='".$pv['bouton1_page']."'>\r".
$pv['uni_gestion_des_motcle_p']."
<input type='hidden' name='M_MOTCLE[mot_cle_selection]'			value='".$_REQUEST['M_MOTCLE']['mot_cle_selection']."'>\r
<input type='hidden' name='M_MOTCLE[nom]'						value='".$info_mc_['mc_nom']."'>\r
<input type='hidden' name='UPDATE_action'					value='".$pv['bouton1_action']."'>\r
".
$bloc_html['post_hidden_user_login'].
$bloc_html['post_hidden_user_pass']."

<br>\r
<br>\r
<table cellpadding='0' cellspacing='0' style='margin-left: auto; margin-right: 0px;'>
<tr>\r

".$pv['check_modif1']."
<td>\r
");
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
echo ("<br>&nbsp;\r
</form>\r
</td>\r
</tr>\r

<tr>\r
<td style='width: ".(${$theme_tableau}['theme_module_largeur_interne'] - 200)."px;'>\r
</td>\r
<td>\r

<form ACTION='index.php?' method='post'>\r".
$bloc_html['post_hidden_sw'].
$bloc_html['post_hidden_l'].
$bloc_html['post_hidden_arti_ref']."
<input type='hidden' name='arti_page' value='1'>\r".
$bloc_html['post_hidden_user_login'].
$bloc_html['post_hidden_user_pass']
);
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
<br>&nbsp;\r
</td>\r
</tr>\r
</form>\r
");

switch ( $_REQUEST['M_MOTCLE']['uni_gestion_des_motcle_p'] ) {
case 2:
	echo ("
	<form ACTION='index.php?' method='post'>\r".
	$bloc_html['post_hidden_sw'].
	$bloc_html['post_hidden_l'].
	$bloc_html['post_hidden_arti_ref']."
	<input type='hidden' name='arti_page'				value='1'>\r
	<input type='hidden' name='M_MOTCLE[nom]'				value='".$info_mc_['mc_nom']."'>\r".
	$bloc_html['post_hidden_user_login'].
	$bloc_html['post_hidden_user_pass']."
	<input type='hidden' name='UPDATE_action'	value='DELETE_KEYWORD'>\r

	<tr>\r
	<td style='width: ".(${$theme_tableau}['theme_module_largeur_interne'] - 200)."px;'>\r
	<input type='checkbox' name='M_MOTCLE[confirmation_suppression]' value='1'>".$tl_[$l]['text_confirm3']."\r
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
	");
break;
}

echo ("
</table>\r
<br>\r
</form>\r

");

if ( $site_web['sw_info_debug'] < 10 ) {
	unset (
		$dbp, 
		$dbquery, 
		$gmc_etat, 
		$gmc_type, 
		$info_a_,
		$info_mc_,
		$AD,
		$ADC,
		$pv, 
		$tl_  
	);
}

/*Hydre-contenu_fin*/
?>
