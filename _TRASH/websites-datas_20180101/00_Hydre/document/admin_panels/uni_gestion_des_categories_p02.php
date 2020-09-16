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
$_REQUEST['M_CATEGO']['id'] = "64"; /* 71 64 */
$_REQUEST['M_CATEGO']['lang'] = "2";
// --------------------------------------------------------------------------------------------
/*	2005 07 20 : fra_modification_de_categorie_p02.php debut									*/
// --------------------------------------------------------------------------------------------
/*Hydre-contenu_debut*/
$_REQUEST['sql_initiateur'] = "fra_modification_de_categorie_p02";

// --------------------------------------------------------------------------------------------
/* Preparation des tables																		*/
// --------------------------------------------------------------------------------------------
$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
SELECT * 
FROM ".$SQL_tab_abrege['categorie']." 
WHERE cate_id = '".$_REQUEST['M_CATEGO']['id']."' 
;");
while ($dbp = fetch_array_sql($dbquery)) {	foreach ( $dbp as $A => $B ) { $MC[$A] = $B; } }
unset ( $A , $B );

// --------------------------------------------------------------------------------------------
/* Preparation des elements																		*/
// --------------------------------------------------------------------------------------------
$tl_['eng']['l_nom'] = "Name";						$tl_['fra']['l_nom'] = "Nom";
$tl_['eng']['l_titre'] = "Title";					$tl_['fra']['l_titre'] = "Titre";
$tl_['eng']['l_desc'] = "Description";				$tl_['fra']['l_desc'] = "Description";
$tl_['eng']['l_parent'] = "Parent directory";		$tl_['fra']['l_parent'] = "Dossier parent";
$tl_['eng']['l_arti_ref'] = "Reference article";	$tl_['fra']['l_arti_ref'] = "Article de reference";

$tl_['eng']['l_type'] = "Type";						$tl_['fra']['l_type'] = "Type";
$tl_['eng']['l_bouclage'] = "Deadline";				$tl_['fra']['l_bouclage'] = "Bouclage";
$tl_['eng']['l_position'] = "Position";				$tl_['fra']['l_position'] = "Position";
$tl_['eng']['l_etat'] = "State";					$tl_['fra']['l_etat'] = "Etat";
$tl_['eng']['l_groupe_id'] = "Group who can see";	$tl_['fra']['l_groupe_id'] = "Groupe qui peut voir";

//$tl_['eng']['select_artiref1']	= "Select an article";	$tl_['fra']['select_artiref1'] = "S&eacute;lectionnez un article";
$tl_['eng']['select_type1'] = "Folder";				$tl_['fra']['select_type1'] = "Dossier";
$tl_['eng']['select_type2'] = "Simple category";	$tl_['fra']['select_type2'] = "Cat&eacute;gorie simple";	

$tl_['eng']['select_etat0'] = "Inactive state (NOT seen by public)";	$tl_['fra']['select_etat0'] = "Etat inactif (inaccessible pour le public)";
$tl_['eng']['select_etat1'] = "Active state (seen by public)";			$tl_['fra']['select_etat1'] = "Etat actif (visible par le public)";
$tl_['eng']['select_etat2'] = "Deleted";								$tl_['fra']['select_etat2'] = "Supprim&eacute;";

$pv['o1l_parent'] = "<select name='M_CATEGO[form_parent]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
SELECT * 
FROM ".$SQL_tab_abrege['categorie']." 
WHERE site_id = '".$site_web['sw_id']."' 
AND cate_type IN ('0','1')  
AND arti_ref = '0' 
AND cate_lang = '".$MC['cate_lang']."'
AND cate_id != '".$MC['cate_id']."' 
AND cate_etat != '2' 
;");

$tl_['eng']['select_cate0'] = "-*-Root level-*-";	
$tl_['fra']['select_cate0'] = "-*-Niveau racine-*-";	
$menu_select[$i]['db'] = 0; $menu_select[$i]['t'] = $tl_[$l]['select_cate0'];

while ($dbp = fetch_array_sql($dbquery)) { 
	$i = $dbp['cate_id'];
	$menu_select[$i]['db'] = $dbp['cate_nom'];
	$menu_select[$i]['t'] = $dbp['cate_titre'];
}
$menu_select[$MC['cate_parent']]['s'] = " selected ";
foreach ( $menu_select as $A) { $pv['o1l_parent'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']."</option>\r";}
$pv['o1l_parent'] .= "</select>\r";
unset ($menu_select);


if ( $MC['arti_ref'] == "0" ) { 
	$tl_['eng']['err'] = "Folders don't have article";
	$tl_['fra']['err'] = "Pas d'article pour un dossier.";
	$pv['o1l_arti_ref'] = $tl_[$l]['err']; 
	}
else {
	$pv['o1l_arti_ref'] = "<select name='M_CATEGO[arti_ref]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
	$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
	SELECT arti_id,arti_nom,arti_ref
	FROM ".$SQL_tab_abrege['article']." 
	WHERE site_id = '".$site_web['sw_id']."' 
	AND arti_page = '1'
	;");

	$tl_['eng']['select_artiref1'] = "Folder (no article)";	
	$tl_['fra']['select_artiref1'] = "Dossier (pas d'article)";	
	$menu_select['0']['db'] = 0;
	$menu_select['0']['t'] = $tl_[$l]['select_artiref1'];
	while ($dbp = fetch_array_sql($dbquery)) { 
		$i = $dbp['arti_ref'];
		$menu_select[$i]['db'] = $dbp['arti_ref'];
		$menu_select[$i]['t'] = $dbp['arti_nom'];
	}
	$menu_select[$MC['arti_ref']]['s'] = " selected ";
	foreach ( $menu_select as $A) { $pv['o1l_arti_ref'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']."</option>\r";}
	$pv['o1l_arti_ref'] .= "</select>\r";
}
unset ($menu_select);


$menu_select['0']['t'] = $tl_[$l]['select_type1'];	$menu_select['0']['db'] = 0;
$menu_select['1']['t'] = $tl_[$l]['select_type2'];	$menu_select['1']['db'] = 1;
$menu_select[$MC['cate_type']]['s'] = " selected ";
$pv['o1l_type'] = "<select name='M_CATEGO[type]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
foreach ( $menu_select as $A) { $pv['o1l_type'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']."</option>\r";}
$pv['o1l_type'] .= "</select>\r";
unset ($menu_select);


$pv['o1l_bouclage'] = "<select name='M_CATEGO[bouclage_id]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
SELECT bouclage_id,bouclage_nom,bouclage_titre 
FROM ".$SQL_tab_abrege['bouclage']." 
WHERE site_id = '".$site_web['sw_id']."'
;");
unset ($menu_select);
while ($dbp = fetch_array_sql($dbquery)) { 
	$i = $dbp['bouclage_id'];
	$menu_select[$i]['db'] = $dbp['bouclage_nom'];
	$menu_select[$i]['t'] = $dbp['bouclage_titre'];
}
$menu_select[$MC['bouclage_id']]['s'] = " selected ";
foreach ( $menu_select as $A) { $pv['o1l_bouclage'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']."</option>\r";}
$pv['o1l_bouclage'] .= "</select>\r";
unset ($menu_select);


$pv['o1l_etat'] = "<select name='M_CATEGO[etat]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
unset ($menu_select);
$menu_select['0']['t'] = $tl_[$l]['select_etat0'];	$menu_select['0']['db'] = "OFFLINE";
$menu_select['1']['t'] = $tl_[$l]['select_etat1'];	$menu_select['1']['db'] = "ONLINE";
$menu_select['2']['t'] = $tl_[$l]['select_etat2'];	$menu_select['2']['db'] = "DELETED";
$menu_select[$MC['cate_etat']]['s'] = " selected ";
foreach ( $menu_select as $A ) { $pv['o1l_etat'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']."</option>\r";}
$pv['o1l_etat'] .= "</select>\r";
unset ($menu_select);


$pv['o1l_groupe_id'] = "<select name='M_CATEGO[groupe_id]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
unset ($menu_select);
$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
SELECT a.groupe_id,a.groupe_nom,a.groupe_titre 
FROM ".$SQL_tab_abrege['groupe']." a, ".$SQL_tab_abrege['site_groupe']." b 
WHERE b.site_id = '".$site_web['sw_id']."' 
AND a.groupe_id = b.groupe_id
;");
while ($dbp = fetch_array_sql($dbquery)) { 
	$i = $dbp['groupe_id'];
	$menu_select[$i]['db']	= $dbp['groupe_nom'];
	$menu_select[$i]['t']		= $dbp['groupe_titre'];
}
$menu_select[$MC['groupe_id']]['s'] = " selected ";
foreach ( $menu_select as $A) { $pv['o1l_groupe_id'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']."</option>\r";}
$pv['o1l_groupe_id'] .= "</select>\r";


// --------------------------------------------------------------------------------------------
/*	Affichage																				*/
// --------------------------------------------------------------------------------------------
$tl_['eng']['invite1'] = "Modify the category : ";
$tl_['fra']['invite1'] = "Modification de la cat&eacute;gorie : ";
echo ("
<p>
<form ACTION='index.php?' method='post'>\r".$tl_[$l]['invite1']."".$MC['cate_nom'].".<br>\r
<br>\r
</p>\r
");

// --------------------------------------------------------------------------------------------
if ( $_REQUEST['M_CATEGO']['confirmation_modification_oubli'] == 1 ) { 
	$tl_['eng']['err'] = "You didn't confirm the category updates.";
	$tl_['fra']['err'] = "Vous n'avez pas confirm&eacute; la modification de la cat&eacute;gorie.";
	echo ("<p class='".$theme_tableau."s0".$module_['module_deco_nbr']."_erreur2'>".$tl_[$l]['err']."<br>\r"); 
}

if ( $_REQUEST['M_CATEGO']['confirmation_suppression_oubli'] == 1 ) { 
	$tl_['eng']['err'] = "You didn't confirm the category deletion.";
	$tl_['fra']['err'] = "Vous n'avez pas confirm&eacute; la suppression de la cat&eacute;gorie.";
	echo ("<p class='".$theme_tableau."s0".$module_['module_deco_nbr']."_erreur2'>".$tl_[$l]['err']."<br>\r");
}
$AD['1']['1']['1']['cont'] = $tl_[$l]['l_nom'];
$AD['1']['2']['1']['cont'] = $tl_[$l]['l_titre'];
$AD['1']['3']['1']['cont'] = $tl_[$l]['l_desc'];
$AD['1']['4']['1']['cont'] = $tl_[$l]['l_parent'];
$AD['1']['5']['1']['cont'] = $tl_[$l]['l_arti_ref'];
$AD['1']['6']['1']['cont'] = $tl_[$l]['l_type'];
$AD['1']['7']['1']['cont'] = $tl_[$l]['l_bouclage'];
$AD['1']['8']['1']['cont'] = $tl_[$l]['l_position'];
$AD['1']['9']['1']['cont'] = $tl_[$l]['l_etat'];
$AD['1']['10']['1']['cont'] = $tl_[$l]['l_groupe_id'];

$AD['1']['1']['2']['cont'] = $MC['cate_nom'];
$AD['1']['2']['2']['cont'] = "<input type='text' name='M_CATEGO[titre]' size='25' maxlength='255' value=\"".$MC['cate_titre']."\" class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
$AD['1']['3']['2']['cont'] = "<input type='text' name='M_CATEGO[desc]' size='25' maxlength='255' value=\"".$MC['cate_desc']."\" class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
$AD['1']['4']['2']['cont'] = $pv['o1l_parent'];
$AD['1']['5']['2']['cont'] = $pv['o1l_arti_ref'];
$AD['1']['6']['2']['cont'] = $pv['o1l_type'];
$AD['1']['7']['2']['cont'] = $pv['o1l_bouclage'];
$AD['1']['8']['2']['cont'] = $MC['cate_position'];
$AD['1']['9']['2']['cont'] = $pv['o1l_etat'];
$AD['1']['10']['2']['cont'] = $pv['o1l_groupe_id'];

$ADC['onglet']['1']['nbr_ligne'] = 10;
$ADC['onglet']['1']['nbr_cellule'] = 2;
$ADC['onglet']['1']['legende'] = 2;

$tl_['eng']['onglet_1'] = "Informations";		$tl_['fra']['onglet_1'] = "Informations";



$tab_infos['AffOnglet']			= 1;
$tab_infos['NbrOnglet']			= 1;
$tab_infos['tab_comportement']	= 0;
$tab_infos['mode_rendu']		= 0;	// 0 echo 1 dans une variable
$tab_infos['TypSurbrillance']	= 0; // 1:ligne, 2:cellule
$tab_infos['doc_height']		= 336;
$tab_infos['doc_width']			= ${$theme_tableau}['theme_module_largeur_interne'] -24 ;
$tab_infos['groupe']			= "mc_grp1";
$tab_infos['cell_id']			= "tab";
$tab_infos['document']			= "doc";
$tab_infos['cell_1_txt']		= $tl_[$l]['onglet_1'];
include ("routines/website/affichage_donnees.php");

// --------------------------------------------------------------------------------------------
$tl_['eng']['modifmsg1'] = "I confirm the category updates.";	$tl_['fra']['modifmsg1'] = "Je valide la modification de la cat&eacute;gorie.";	
$tl_['eng']['submitmodif1'] = "Update";							$tl_['fra']['submitmodif1'] = "Modifier";
$tl_['eng']['submitretour1'] = "Return to list";				$tl_['fra']['submitretour1'] = "Retour &agrave; la liste";
$tl_['eng']['supmsg1'] = "I confirm the category deletion.";	$tl_['fra']['supmsg1'] = "Je valide la suppression de la cat&eacute;gorie.";
$tl_['eng']['submitsup1'] = "Delete";							$tl_['fra']['submitsup1'] = "Supprimer";

echo ("
<table ".${$theme_tableau}['tab_std_rules']." width='".${$theme_tableau}['theme_module_largeur_interne']."'>\r
<tr>\r
<td>\r
<input type='hidden' name='M_CATEGO[id]'			value='".$MC['cate_id']."'>\r
<input type='hidden' name='M_CATEGO[nom]'			value='".$MC['cate_nom']."'>\r
<input type='hidden' name='UPDATE_action'	value='UPDATE_CATEGORY'>\r".
$bloc_html['post_hidden_sw'].
$bloc_html['post_hidden_l'].
$bloc_html['post_hidden_arti_ref'].
$bloc_html['post_hidden_arti_page'].
$bloc_html['post_hidden_user_login'].
$bloc_html['post_hidden_user_pass']."
<input type='checkbox' name='M_CATEGO[confirmation_modification]' value='1'>".$tl_[$l]['modifmsg1']."
</td>\r
<td>\r");

$_REQUEST['BS']['id']				= "bouton_modification";
$_REQUEST['BS']['type']				= "submit";
$_REQUEST['BS']['style_initial']	= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s2_n";
$_REQUEST['BS']['style_hover']		= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s2_h";
$_REQUEST['BS']['onclick']			= "";
$_REQUEST['BS']['message']			= $tl_[$l]['submitmodif1'];
$_REQUEST['BS']['mode']				= 1;
$_REQUEST['BS']['taille'] 			= 128;
$_REQUEST['BS']['derniere_taille']	= 0;
echo generation_bouton ();
echo ("
</form>\r
<br>\r&nbsp;\r
</td>\r
</tr>\r


<tr>\r
<td>\r
<form ACTION='index.php?' method='post'>\r".
$bloc_html['post_hidden_sw'].
$bloc_html['post_hidden_l'].
$bloc_html['post_hidden_arti_ref']."
<input type='hidden' name='arti_page' value='1'>\r".
$bloc_html['post_hidden_user_login'].
$bloc_html['post_hidden_user_pass']."
</td>\r
<td>\r");
$_REQUEST['BS']['id']				= "bouton_retour_liste";
$_REQUEST['BS']['type']				= "submit";
$_REQUEST['BS']['style_initial']	= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s1_n";
$_REQUEST['BS']['style_hover']		= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s1_h";
$_REQUEST['BS']['onclick']			= "";
$_REQUEST['BS']['message']			= $tl_[$l]['submitretour1'];
$_REQUEST['BS']['mode']				= 1;
$_REQUEST['BS']['taille'] 			= 0;
echo generation_bouton ();
echo ("
</form>\r
<br>\r&nbsp;\r
</td>\r
</tr>\r


<tr>\r
<td>\r
<form ACTION='index.php?' method='post'>\r
<input type='hidden' name='M_CATEGO[id]'			value='".$MC['cate_id']."'>\r
<input type='hidden' name='M_CATEGO[nom]'			value='".$MC['cate_nom']."'>\r
<input type='hidden' name='UPDATE_action'	value='DELETE_CATEGORY'>\r".
$bloc_html['post_hidden_sw'].
$bloc_html['post_hidden_l'].
$bloc_html['post_hidden_arti_ref'].
$bloc_html['post_hidden_arti_page'].
$bloc_html['post_hidden_user_login'].
$bloc_html['post_hidden_user_pass']."
<input type='checkbox' name='M_CATEGO[confirmation_suppression]' value='1'>".$tl_[$l]['supmsg1']."\r
</td>\r
<td>\r");
$_REQUEST['BS']['id']				= "bouton_suppression";
$_REQUEST['BS']['type']				= "submit";
$_REQUEST['BS']['style_initial']	= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s3_n";
$_REQUEST['BS']['style_hover']		= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s3_h";
$_REQUEST['BS']['onclick']			= "";
$_REQUEST['BS']['message']			= $tl_[$l]['submitsup1'];
$_REQUEST['BS']['mode']				= 1;
$_REQUEST['BS']['taille'] 			= 0;
echo generation_bouton ();
echo ("
</form>\r
<br>\r&nbsp;\r
</td>\r
</tr>\r
</table>\r
<br>\r
<br>\r
<br>\r
");


$tl_['eng']['note1'] = "The deletion of a category doesn't delete the folder sons. 
However these seeds are no longer browsable as menu's elements.
This works as a filesystem. 
By deleting a directory it doesn't delete the files under, but it prevent from accessing the files. <br>\r
<br>\r
To make these lost categories browsable again, go in the category list page 1 (bottom).
";
$tl_['fra']['note1'] = "Note: <br>\r
La suppression d'une cat&eacute;gorie parente (en gras) ne supprime pas ses fils. 
Ses fils ne sont cependant plus accessibles ni visibles dans la pr&eacute;sentation des menus. 
Cela fonctionne a la mani&egrave;re d'un syst&egrave;me de fichier. 
En supprimant un r&eacute;pertoire on ne supprime pas les fichiers se trouvant dedans; n&eacute;anmoins on y a plus acc&egrave;s.<br>\r
<br>\r
Pour r&eacute;cup&eacute;rer ces cat&eacute;gories et les r&eacute;associer de nouveau; il faut aller dans la liste de la page 1 (en bas).<br>\r";

echo ("
<p style='text-align: justify;'>".$tl_[$l]['note1']."</p>
");

if ( $site_web['sw_info_debug'] < 10 ) { 
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
		$menu_select ,
		$AD,
		$ADC,
		$pv , 
		$tab_infos , 
		$tl_ , 
		$user_list
	); 
}

/*Hydre-contenu_fin*/
?>
