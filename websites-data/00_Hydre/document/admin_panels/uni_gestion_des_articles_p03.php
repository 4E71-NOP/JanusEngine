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
//	2005 06 25 : fra_modification_article_p03.php debut
//	2007 08 16 : Derniere modification
// --------------------------------------------------------------------------------------------
$_REQUEST['arti_ref'] = "fra_modification_article" ;
$_REQUEST['arti_page'] = "3" ;
$_REQUEST['M_ARTICL']['arti_ref_selection'] = "fra_acceuil" ;
$_REQUEST['M_ARTICL']['arti_page_selection'] = "2" ;
/*Hydre-contenu_debut*/
$_REQUEST['sql_initiateur'] = "fra_modification_article_p03";

// --------------------------------------------------------------------------------------------
// Mise a jour du document
// --------------------------------------------------------------------------------------------
if ( $_REQUEST['M_ARTICL']['confirmation_modification_oubli'] == 1 ){ 
	$tl_['eng']['err1'] = "You asked for an article update but you didn't click on the confirmation checkbox.";
	$tl_['fra']['err1'] = "Vous avez demand&eacute; la modification de l'article mais vous n'avez pas confirm&eacute;.";
	echo ("<p class='" . $theme_tableau . $_REQUEST['bloc']."_tb3'> <p class='" . $theme_tableau . $_REQUEST['bloc']."_erreur'>".$tl_[$l]['err1']."</p>\r<br>\r<hr>\r"); 
}

if ( $_REQUEST['M_ARTICL']['modification_effectuee'] == 1 ){ 
	$tl_['eng']['err1'] = "The article named ".$_REQUEST['arti_ref_selection']." on page ".$_REQUEST['arti_page_selection']." has been updated.";
	$tl_['fra']['err1'] = "L'article ".$_REQUEST['M_ARTICL']['arti_ref_selection']." page ".$_REQUEST['M_ARTICL']['arti_page_selection']." a &eacute;t&eacute; mis a jour.";
	echo ("<p class='" . $theme_tableau . $_REQUEST['bloc']."_tb3'> <p class='" . $theme_tableau . $_REQUEST['bloc']."_avert'>".$tl_[$l]['err1']."</p><br>\r<hr>\r"); 
}

// --------------------------------------------------------------------------------------------
// Preparation des tables
// --------------------------------------------------------------------------------------------
$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
SELECT * 
FROM ".$SQL_tab_abrege['article']." 
WHERE arti_ref = '".$_REQUEST['M_ARTICL']['arti_ref_selection']."'
AND arti_page = '".$_REQUEST['M_ARTICL']['arti_page_selection']."' 
AND ws_id = '".$website['ws_id']."'
;");
while ($dbp = fetch_array_sql($dbquery)) {	foreach ( $dbp as $A => $B ) { $infos_article[$A] = $B; } }
unset ( $A , $B );


$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
SELECT pre.pres_id,pre.pres_nom,pre.pres_nom_generique  
FROM ".$SQL_tab_abrege['presentation']." pre, ".$SQL_tab_abrege['theme_presentation']." sp , ".$SQL_tab_abrege['theme_website']." ss 
WHERE pre.pres_id = sp.pres_id 
AND sp.theme_id = '".${$theme_tableau}['theme_id']."' 
AND sp.theme_id = ss.theme_id 
AND ss.ws_id = '".$website['ws_id']."'
;");
while ($dbp = fetch_array_sql($dbquery)) {
	$MAA_p[$dbp['pres_id']]['t'] = $MAA_p[$dbp['pres_id']]['db'] = $dbp['pres_nom_generique'];
	if ($infos_article['pres_nom_generique'] == $dbp['pres_nom_generique']) { $MAA_p[$dbp['pres_id']]['s'] = " selected"; }
}


$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
SELECT * 
FROM ".$SQL_tab_abrege['article_config']." 
WHERE ws_id = '".$website['ws_id']."' 
;");
while ($dbp = fetch_array_sql($dbquery)) {
	$MAA_dc[$dbp['config_id']]['t'] = $MAA_dc[$dbp['config_id']]['db'] = $dbp['config_nom'];
}
$MAA_dc[$infos_article['config_id']]['s'] = " selected";


$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
SELECT deadline_id,deadline_title,deadline_name  
FROM ".$SQL_tab_abrege['deadline']." 
WHERE ws_id = '".$website['ws_id']."' 
AND deadline_state != '2' 
;");
while ($dbp = fetch_array_sql($dbquery)) {
	$MAA_b[$dbp['deadline_id']]['t'] = $dbp['deadline_title'];		$MAA_b[$dbp['deadline_id']]['db'] = $dbp['deadline_name'];
}
$MAA_b[$infos_article['arti_deadline']]['s'] = " selected";


$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
SELECT usr.user_id,usr.user_login 
FROM ".$SQL_tab_abrege['user']." usr,  ".$SQL_tab_abrege['groupe_user']." grp , ".$SQL_tab_abrege['group_website']." sgp 
WHERE usr.user_id = grp.user_id 
AND grp.group_id = sgp.group_id
AND sgp.ws_id = '".$website['ws_id']."'
;");

while ($dbp = fetch_array_sql($dbquery)) {
	$user_list[$dbp['user_id']]['user_login'] = $dbp['user_login'];
}


$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
SELECT doc.docu_id,doc.docu_nom,doc.docu_type,shr.share_modification 
FROM ".$SQL_tab_abrege['document']." doc, ".$SQL_tab_abrege['document_share']." shr 
WHERE shr.ws_id = '".$website['ws_id']."' 
AND shr.docu_id = doc.docu_id 
;");
while ($dbp = fetch_array_sql($dbquery)) { $document_list[$dbp['docu_id']]['nom'] = $dbp['docu_nom']; }
$document_list[$infos_article['docu_id']]['s'] = " selected";


$tl_['eng']['link'] = "Link for modifying the associated document (".$document_list[$infos_article['docu_id']]['nom'].").";
$tl_['fra']['link'] = "Lien pour modifier le document associ&eacute; a cet article (".$document_list[$infos_article['docu_id']]['nom'].").";

$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
SELECT cate_role, cate_id, arti_ref 
FROM ".$SQL_tab['categorie']." 
WHERE cate_type IN ('2', '3') 
AND ws_id IN ('1', '".$website['ws_id']."') 
AND cate_lang = '".$website['ws_lang']."' 
AND group_id ".$user['clause_in_groupe']." 
AND cate_etat = '1' 
AND cate_role = '1'
;");
while ($dbp = fetch_array_sql($dbquery)) { $pv['role_article_cible'] = $dbp['arti_ref']; }

$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
SELECT  docu_id,docu_nom
FROM ".$SQL_tab_abrege['document']." 
WHERE  docu_id = '".$infos_article['docu_id']."'
;");
while ($dbp = fetch_array_sql($dbquery)) {
	$pv['PF']['o4l2'] = "<a class='" . $theme_tableau . $_REQUEST['bloc']."_lien " . $theme_tableau . $_REQUEST['bloc']."_tb4' href='index.php?
arti_ref=".$pv['role_article_cible']."
&amp;M_DOCUME[document_selection]=".$infos_article['docu_id'].
$bloc_html['url_slup']."
&amp;arti_page=2'
>".$tl_[$l]['link']."</a>\r";
}



// --------------------------------------------------------------------------------------------
// Preparation des elements
// --------------------------------------------------------------------------------------------
$pv['PF']['o2l1'] = "<select name ='M_ARTICL[pres_nom_generique]' class='" . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
foreach ( $MAA_p as $A ) { $pv['PF']['o2l1'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$pv['PF']['o2l1'] .= "</select>\r";
unset ($A);

$pv['PF']['o2l2'] = "<select name ='M_ARTICL[config_id]' class='" . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
foreach ( $MAA_dc as $A ) { $pv['PF']['o2l2'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$pv['PF']['o2l2'] .= "</select>\r";
unset ($A);

$pv['PF']['o2l3'] = "<select name ='M_ARTICL[deadline]' class='" . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
foreach ( $MAA_b as $A ) { $pv['PF']['o2l3'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$pv['PF']['o2l3'] .= "</select>\r";
unset ($A);

$MA_validation['fra']['0'] = "Non valid&eacute;";	$MA_validation['eng']['0'] = "Not validated";
$MA_validation['fra']['1'] = "Valid&eacute;";		$MA_validation['eng']['1'] = "Validated";

$pv['PF']['o4l1'] = "<select name ='M_ARTICL[document]' class='" . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
foreach ( $document_list as $A ) { $pv['PF']['o4l1'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$pv['PF']['o4l1'] .= "</select>\r";
unset ($A);


//$MA_correction['fra']['0'] = "Non corrig&eacute;";	$MA_correction['eng']['0'] = "Not examined";
//$MA_correction['fra']['1'] = "Corrig&eacute;";		$MA_correction['eng']['1'] = "Examined";

// --------------------------------------------------------------------------------------------
//	Affichage
// --------------------------------------------------------------------------------------------
$tl_['eng']['invite1'] = "This component allows you to modify an online article. You can modify more parameter than a validator. Don't forget your modifycation will be visible online directly.";
$tl_['fra']['invite1'] = "Cette partie va vous permettre de mettre a jour un article d&eacute;j&agrave; en ligne. Vous pouvez modifier un plus grand nombre de param&egrave;tres de l'article qu'un validateur. N'oubliez pas que vos modifications vont &ecirc;tre vues directement en ligne.";

echo ("
<form ACTION='index.php?' method='post'>\r
<p>
".$tl_[$l]['invite1']."<br>\r
</p>\r

<br>\r
<hr>\r
");


$tl_['eng']['d1_01'] = "Name";		$tl_['eng']['d1_02'] = "Description";		$tl_['eng']['d1_03'] = "Title";		$tl_['eng']['d1_04'] = "?";					$tl_['eng']['d1_05'] = "Page";
$tl_['fra']['d1_01'] = "Nom";	$tl_['fra']['d1_02'] = "Description";	$tl_['fra']['d1_03'] = "Titre";	$tl_['fra']['d1_04'] = "Sous-titre";	$tl_['fra']['d1_05'] = "Page";

$tl_['eng']['d2_01'] = "Display";					$tl_['eng']['d2_02'] = "Article configuration";		$tl_['eng']['d2_03'] = "Deadline";
$tl_['fra']['d2_01'] = "Pr&eacute;sentation";	$tl_['fra']['d2_02'] = "Configuration article";	$tl_['fra']['d2_03'] = "Bouclage";

$tl_['eng']['d3_01'] = "Creation";				$tl_['eng']['d3_02'] = "Validation";		$tl_['eng']['d3_03'] = "Publication";
$tl_['fra']['d3_01'] = "Cr&eacute;ation";	$tl_['fra']['d3_02'] = "Validation";	$tl_['fra']['d3_03'] = "Parution";


$PF_['1']['1']['1']['cont'] = $tl_[$l]['d1_01'];
$PF_['1']['2']['1']['cont'] = $tl_[$l]['d1_02'];
$PF_['1']['3']['1']['cont'] = $tl_[$l]['d1_03'];
$PF_['1']['4']['1']['cont'] = $tl_[$l]['d1_04'];
$PF_['1']['5']['1']['cont'] = $tl_[$l]['d1_05'];

$PF_['2']['1']['1']['cont'] = $tl_[$l]['d2_01'];
$PF_['2']['2']['1']['cont'] = $tl_[$l]['d2_02'];
$PF_['2']['3']['1']['cont'] = $tl_[$l]['d2_03'];

$PF_['3']['1']['1']['cont'] = $tl_[$l]['d3_01'];
$PF_['3']['2']['1']['cont'] = $tl_[$l]['d3_02'];
$PF_['3']['3']['1']['cont'] = $tl_[$l]['d3_03'];

$PF_['4']['1']['1']['cont'] = $tl_[$l]['d4_01'];
$PF_['4']['2']['1']['cont'] = $tl_[$l]['d4_02'];


$PF_['1']['1']['2']['cont'] = $infos_article['arti_nom'];
$PF_['1']['2']['2']['cont'] = "<input type='text' name='M_ARTICL[desc]' value=\"".$infos_article['arti_desc']."\" size='35' maxlength='255' class='" . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
$PF_['1']['3']['2']['cont'] = "<input type='text' name='M_ARTICL[titre]' value=\"".$infos_article['arti_titre']."\" size='35' maxlength='255' class='" . $theme_tableau . $_REQUEST['bloc']."_form_1'></td>\r";
$PF_['1']['4']['2']['cont'] = "<input type='text' name='M_ARTICL[sous_titre]' value=\"".$infos_article['arti_sous_titre']."\" size='35' maxlength='255' class='" . $theme_tableau . $_REQUEST['bloc']."_form_1'></td>\r";
$PF_['1']['5']['2']['cont'] = $infos_article['arti_page'];

$PF_['2']['1']['2']['cont'] = $pv['PF']['o2l1'];
$PF_['2']['2']['2']['cont'] = $pv['PF']['o2l2'];
$PF_['2']['3']['2']['cont'] = $pv['PF']['o2l3'];

$PF_['3']['1']['2']['cont'] = $user_list[$infos_article['arti_creation_createur']]['user_login'] . " - " . strftime ("%a %d %b %y - %H:%M", $infos_article['arti_creation_date']) ;
$PF_['3']['2']['2']['cont'] = $user_list[$infos_article['arti_validation_validateur']]['user_login'] . " - " . strftime ("%a %d %b %y - %H:%M", $infos_article['arti_validation_date']) . "(" . $MA_validation[$l][$infos_article['arti_validation_etat']] .")";
$PF_['3']['3']['2']['cont'] = strftime ("%a %d %b %y - %H:%M", $infos_article['arti_parution_date']);

$PF_['4']['1']['2']['cont'] = $pv['PF']['o4l1'];
$PF_['4']['2']['2']['cont'] = $pv['PF']['o4l2'];

$PFC_['onglet']['1']['nbr_ligne'] = 5;
$PFC_['onglet']['1']['nbr_cellule'] = 2;
$PFC_['onglet']['1']['legende'] = 2;
$PFC_['onglet']['2']['nbr_ligne'] = 3;
$PFC_['onglet']['2']['nbr_cellule'] = 2;
$PFC_['onglet']['2']['legende'] = 2;
$PFC_['onglet']['3']['nbr_ligne'] = 3;
$PFC_['onglet']['3']['nbr_cellule'] = 2;
$PFC_['onglet']['3']['legende'] = 2;
$PFC_['onglet']['4']['nbr_ligne'] = 2;
$PFC_['onglet']['4']['nbr_cellule'] = 2;
$PFC_['onglet']['4']['legende'] = 2;


$tl_['eng']['onglet1'] = "Informations";
$tl_['eng']['onglet2'] = "Options";
$tl_['eng']['onglet3'] = "Historic / State";
$tl_['eng']['onglet4'] = "Document";
$tl_['fra']['onglet1'] = "Informations";
$tl_['fra']['onglet2'] = "Options";
$tl_['fra']['onglet3'] = "Historique / &eacute;tat";
$tl_['fra']['onglet4'] = "Document";

$tab_infos['nbr']			= 4;
$tab_infos['tab_comportement'] = 1;
$tab_infos['mode_rendu']		= 0;	// 0 echo 1 dans une variable
$tab_infos['doc_height']	= 224;
$tab_infos['doc_width']	= ${$theme_tableau}['theme_module_largeur_interne'];
$tab_infos['groupe']		= "maa_grp1";
$tab_infos['cell_id']		= "tab";
$tab_infos['document']	= "doc";
$tab_infos['cell_1_txt']	= $tl_[$l]['onglet1'];
$tab_infos['cell_2_txt']	= $tl_[$l]['onglet2'];
$tab_infos['cell_3_txt']	= $tl_[$l]['onglet3'];
$tab_infos['cell_4_txt']	= $tl_[$l]['onglet4'];

include ("routines/website/presentation_formulaire.php");

// --------------------------------------------------------------------------------------------
// $docu_ancien_contenu  = addslashes($MAA_['docu_cont_brut']) ;

$tl_['eng']['bouton1'] = "Modify";		$tl_['eng']['text_confirm1'] = "I confirm the article modifications.";	
$tl_['fra']['bouton1'] = "Modifier";	$tl_['fra']['text_confirm1'] = "Je valide la modification de l'article.";	

$tl_['eng']['retour'] = "Return to list";
$tl_['fra']['retour'] = "Retour &agrave; la liste";

echo ("
<br>\r".
$bloc_html['post_hidden_sw'].
$bloc_html['post_hidden_l'].
$bloc_html['post_hidden_arti_ref'].
$bloc_html['post_hidden_arti_page'].
$bloc_html['post_hidden_user_login'].
$bloc_html['post_hidden_user_pass']."

<input type='hidden' name='M_ARTICL[nom]'						value='".$infos_article['arti_nom']."'>\r
<input type='hidden' name='M_ARTICL[ref]'						value='".$infos_article['arti_ref']."'>\r
<input type='hidden' name='UPDATE_action'				value='UPDATE_ARTICLE'>\r

<table ".${$theme_tableau}['tab_std_rules']." width='".${$theme_tableau}['theme_module_largeur_interne']."px;'>\r
<tr>\r
<td class='".$theme_tableau."s0".$module_['module_deco_nbr']."_fc2'>\r<input type='checkbox' name='M_ARTICL[confirmation_modification]' value='1'>".$tl_[$l]['text_confirm1']."\r</td>\r
<td class='".$theme_tableau."s0".$module_['module_deco_nbr']."_fc2' style='text-align: right;'>\r");
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
echo ("<br>\r&nbsp;
</td>\r
</tr>\r
</form>\r

<form ACTION='index.php?' method='post'>\r".
$bloc_html['post_hidden_sw'].
$bloc_html['post_hidden_l'].
$bloc_html['post_hidden_arti_ref']."
<input type='hidden' name='arti_page'	value='1'>\r.".
$bloc_html['post_hidden_user_login'].
$bloc_html['post_hidden_user_pass']."
<tr>\r
<td>\r</td>\r
<td class='".$theme_tableau."s0".$module_['module_deco_nbr']."_fc2' style='text-align: right;'>\r");
$_REQUEST['BS']['id']				= "bouton_retour_liste";
$_REQUEST['BS']['type']				= "submit";
$_REQUEST['BS']['style_initial']	= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s1_n";
$_REQUEST['BS']['style_hover']		= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s1_h";
$_REQUEST['BS']['onclick']			= "";
$_REQUEST['BS']['message']			= $tl_[$l]['retour'];
$_REQUEST['BS']['mode']				= 1;
$_REQUEST['BS']['taille'] 			= 0;
echo generation_bouton ();
echo ("<br>\r&nbsp;
</td>\r
</tr>\r
</form>\r
</table>\r
");

if ( $website['ws_info_debug'] < 10 ) { 
	unset (
		$A , 
		$dbp , 
		$dbquery , 
		$MAA_type , 
		$MAA_b , 
		$MAA_dc , 
		$MAA_p , 
		$MA_correction ,
		$MA_validation ,
		$PF_,
		$PFC_,
		$pv , 
		$tab_infos , 
		$tl_ , 
		$user_list
	); 
}

/*Hydre-contenu_fin*/
?>
