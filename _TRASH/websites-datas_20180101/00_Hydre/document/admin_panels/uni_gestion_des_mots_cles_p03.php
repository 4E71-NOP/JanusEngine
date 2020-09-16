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
$_REQUEST['M_MOTCLE']['mot_cle_selection'] = 1 ;
// --------------------------------------------------------------------------------------------
//	2008 03 29 : fra_gestion_des_mots_cles_p03.php debut
//	2008 00 00 : derniere modification
// --------------------------------------------------------------------------------------------
/*Hydre-contenu_debut*/
$_REQUEST['sql_initiateur'] = "fra_gestion_des_mots_cles_p03";

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

// --------------------------------------------------------------------------------------------
// Preparation des elements
// --------------------------------------------------------------------------------------------
$tl_['eng']['l1'] = "State";				$tl_['fra']['l1'] = "Etat";	
$tl_['eng']['l2'] = "Name";					$tl_['fra']['l2'] = "Nom";	
$tl_['eng']['l3'] = "Article";				$tl_['fra']['l3'] = "Article";	
$tl_['eng']['l4'] = "String";				$tl_['fra']['l4'] = "Chaine";	
$tl_['eng']['l5'] = "Count";				$tl_['fra']['l5'] = "Nombre";	
$tl_['eng']['l6'] = "Type";					$tl_['fra']['l6'] = "Type";	
$tl_['eng']['l7'] = "Data";					$tl_['fra']['l7'] = "Donn&eacute;e";	

$info_mc_['mc_nom'] = "Nouveau_mot_cle-" . date ( "Y_m_j_-_G_i_s", mktime() );
$info_mc_['mc_chaine'] = "abcd";
$info_mc_['mc_nbr'] = 1;
$info_mc_['mc_donnee'] = "abcd";

$pv['o1_l2'] = "<select name='M_MOTCLE[etat]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
$tl_['eng']['ms_1_01'] = "Offline";					$tl_['fra']['ms_1_01'] = "Hors ligne";
$tl_['eng']['ms_1_02'] = "Online";					$tl_['fra']['ms_1_02'] = "En ligne";
$gmc_etat['0']['t'] = $tl_[$l]['ms_1_01'];		$gmc_etat['0']['s'] = "";		$gmc_etat['0']['db'] = "OFFLINE";
$gmc_etat['1']['t'] = $tl_[$l]['ms_1_02'];		$gmc_etat['1']['s'] = "";		$gmc_etat['1']['db'] = "ONLINE";
foreach ( $gmc_etat as $A ) { $pv['o1_l2'] .= "<option value='".$A['db']."' ".$A['s'].">".$A['t']."</option>\r"; }
unset ($A);
$pv['o1_l2'] .= "</select>\r";


$pv['o1_l3'] = "<select name='M_MOTCLE[article]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
foreach ( $info_a_ as $A ) { $pv['o1_l3'] .= "<option value='".$A['db']."' ".$A['s'].">".$A['t']."</option>\r"; }
unset ($A);
$pv['o1_l3'] .= "</select>\r";


$pv['o1_l6'] = "<select name='M_MOTCLE[type]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
$tl_['eng']['ms_2_01'] = "Link to a category";				$tl_['fra']['ms_2_01'] = "Vers une cat&eacute;gorie";
$tl_['eng']['ms_2_02'] = "Link to an URL";					$tl_['fra']['ms_2_02'] = "Vers une URL";
$tl_['eng']['ms_2_03'] = "Dynamic help";					$tl_['fra']['ms_2_03'] = "Aide dynamique";
$gmc_type['1']['t'] = $tl_[$l]['ms_2_01'];		$gmc_type['1']['s'] = "";		$gmc_type['1']['db'] = "VERS_CATEGORIE";
$gmc_type['2']['t'] = $tl_[$l]['ms_2_02'];		$gmc_type['2']['s'] = "";		$gmc_type['2']['db'] = "VERS_URL";
$gmc_type['3']['t'] = $tl_[$l]['ms_2_03'];		$gmc_type['3']['s'] = "";		$gmc_type['3']['db'] = "VERS_AIDE_DYNAMIQUE";
foreach ( $gmc_type as $A ) { $pv['o1_l6'] .= "<option value='".$A['db']."' ".$A['s'].">".$A['t']."</option>\r"; }
unset ($A);
$pv['o1_l6'] .= "</select>\r";


// --------------------------------------------------------------------------------------------
//	Affichage
// --------------------------------------------------------------------------------------------
$tl_['eng']['part1_invite'] = "This part will allow you to create a keyword.";
$tl_['fra']['part1_invite'] = "Cette partie va vous permettre de cr&eacute;er un mot cl&eacute;.";
echo ("
<form ACTION='index.php?' method='post' name='formulaire_mot_cle'>\r
<p>\r
". $tl_[$l]['part1_invite'] ."<br>\r
<br>\r
</p>\r
");

$PF_['1']['1']['1']['cont'] = $tl_[$l]['l1'];
$PF_['1']['2']['1']['cont'] = $tl_[$l]['l2'];
$PF_['1']['3']['1']['cont'] = $tl_[$l]['l3'];
$PF_['1']['4']['1']['cont'] = $tl_[$l]['l4'];
$PF_['1']['5']['1']['cont'] = $tl_[$l]['l5'];
$PF_['1']['6']['1']['cont'] = $tl_[$l]['l6'];
$PF_['1']['7']['1']['cont'] = $tl_[$l]['l7'];
$PF_['1']['8']['1']['cont'] = $tl_[$l]['l8'];

$PF_['1']['1']['2']['cont'] = "<input type='text' name='M_MOTCLE[nom]' size='35' maxlength='255' value='".$info_mc_['mc_nom']."' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
$PF_['1']['2']['2']['cont'] = $pv['o1_l2'];
$PF_['1']['3']['2']['cont'] = $pv['o1_l3'];
$PF_['1']['4']['2']['cont'] = "<input type='text' name='M_MOTCLE[chaine]' size='35' maxlength='255' value='".$info_mc_['mc_chaine']."' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
$PF_['1']['5']['2']['cont'] = "<input type='text' name='M_MOTCLE[nombre]' size='35' maxlength='255' value='".$info_mc_['mc_nbr']."' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
$PF_['1']['6']['2']['cont'] = $pv['o1_l6'];
$PF_['1']['7']['2']['cont'] = "<input type='text' name='M_MOTCLE[donnee]' size='35' maxlength='255' value='".$info_mc_['mc_donnee']."' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";

$PFC_['onglet']['1']['nbr_ligne'] = 7;
$PFC_['onglet']['1']['nbr_cellule'] = 2;
$PFC_['onglet']['1']['legende'] = 2;

$tl_['eng']['onglet1'] = "Informations";
$tl_['fra']['onglet1'] = "Informations";

$tab_infos['nbr']			= 1;
$tab_infos['tab_comportement'] = 0;
$tab_infos['mode_rendu']		= 0;	// 0 echo 1 dans une variable
$tab_infos['doc_height']	= 256;
$tab_infos['doc_width']		= ${$theme_tableau}['theme_module_largeur_interne'];
$tab_infos['groupe']		= "mmc_grp1";
$tab_infos['cell_id']		= "tab";
$tab_infos['document']		= "doc";
$tab_infos['cell_1_txt']	= $tl_[$l]['onglet1'];

include ("routines/website/presentation_formulaire.php");
// --------------------------------------------------------------------------------------------

$tl_['eng']['bouton1'] = "Create";	
$tl_['fra']['bouton1'] = "Cr&eacute;er";

$tl_['eng']['bouton2'] = "Back to the list";
$tl_['fra']['bouton2'] = "Retour &agrave; la liste";

echo (
$bloc_html['post_hidden_sw'].
$bloc_html['post_hidden_l'].
$bloc_html['post_hidden_arti_ref']."
<input type='hidden' name='arti_page'				value='1'>\r
<input type='hidden' name='M_MOTCLE[mot_cle_selection]'	value='".$_REQUEST['M_MOTCLE']['mot_cle_selection']."'>\r".
$bloc_html['post_hidden_user_login'].
$bloc_html['post_hidden_user_pass']."
<input type='hidden' name='UPDATE_action'	value='ADD_KEYWORD'>\r

<br>\r
<br>\r

<table cellpadding='0' cellspacing='0' style='margin-left: auto; margin-right: 0px; '>
<tr>\r

<td style='width: ".(${$theme_tableau}['theme_module_largeur_interne'] - 200)."px;'>\r
</td>\r
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
</form>\r
<br>&nbsp;\r
</td>\r
</tr>\r

</table>\r
<br>\r

");

if ( $site_web['sw_info_debug'] < 10 ) {
	unset (
		$dbp , 
		$dbquery , 
		$gmc_etat, 
		$gmc_type, 
		$info_a_,
		$PF_,
		$PFC_,
		$pv , 
		$tl_  
	);
}

/*Hydre-contenu_fin*/
?>
