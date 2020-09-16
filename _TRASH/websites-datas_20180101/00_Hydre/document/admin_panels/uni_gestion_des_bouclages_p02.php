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
// --------------------------------------------------------------------------------------------
//	2008 04 19 : uni_gestion_des_bouclages_p02.php debut										*/
//	2008 04 19 : Derniere modification															*/
// --------------------------------------------------------------------------------------------
$_REQUEST['M_BOUCLG']['bouclage_selection'] = 3;
$_REQUEST['uni_gestion_des_bouclages_p'] = 2;

/*Hydre-contenu_debut*/
$_REQUEST['sql_initiateur'] = "uni_gestion_des_bouclages_p02.php";

// --------------------------------------------------------------------------------------------

switch ( $_REQUEST['uni_gestion_des_bouclages_p'] ) {
case 2:
	if ( $_REQUEST['M_BOUCLG']['confirmation_modification_oubli'] == 1 ) { 
		$tl_['eng']['err'] = "You didn't confirm the deadline update.";
		$tl_['fra']['err'] = "Vous n'avez pas confirm&eacute; la modification du bouclage";
		echo ("<p class='".$theme_tableau."s0".$module_['module_deco_nbr']."_erreur2'>".$tl_[$l]['err']."<br>\r"); 
	}
// --------------------------------------------------------------------------------------------
// Preparation des tables																		*/
// --------------------------------------------------------------------------------------------
	$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
	SELECT bcl.*,usr.user_login 
	FROM ".$SQL_tab_abrege['bouclage']." bcl , ".$SQL_tab_abrege['user']." usr 
	WHERE site_id = '".$site_web['sw_id']."' 
	AND usr.user_id = bcl.user_id 
	AND bouclage_id ='".$_REQUEST['M_BOUCLG']['bouclage_selection']."' 
	;");

	while ($dbp = fetch_array_sql($dbquery)) {
		foreach ( $dbp as $A => $B ) { $bouclage[$A] = $B; }
	}
	unset ( $A , $B );

	$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
	SELECT art.arti_titre   
	FROM ".$SQL_tab_abrege['article']." as art, ".$SQL_tab_abrege['categorie']." as cat  

	WHERE art.site_id = '".$site_web['sw_id']."' 
	AND art.arti_bouclage = '".$bouclage['bouclage_id']."' 
	AND art.site_id = cat.site_id  
	AND art.arti_ref = cat.arti_ref 
	AND art.arti_page = '1' 

	AND cat.cate_type IN ('0','1') 
	AND cat.cate_lang = '".$user['lang']."' 
	;");
	while ($dbp = fetch_array_sql($dbquery)) {	
		$pv['liste_article']	.= "<a class='" . $theme_tableau . $_REQUEST['bloc']."_lien' href=\"index.php?arti_ref=fra_gestion_des_articles&arti_page=3&M_ARTICL[arti_ref_selection]=".$dbp['arti_nom']."&M_ARTICL[arti_page_selection]=1".$bloc_html['url_slup']."\" 
		onMouseOver = \"window.status = '".$A['arti_titre']."'; return true;\" 
		onMouseOut = \"window.status = '".$site_web['sw_barre_status']."'; return true;\"
		>".$dbp['arti_titre']."</a> - "; 
	}

break;
case 3:
	$bouclage['bouclage_etat'] = 1;
	$bouclage['site_id'] = $site_web['site_id'];
	$bouclage['user_id'] = $user['id'];
	$bouclage['user_login'] = $user['login_decode'];
break;
}

// --------------------------------------------------------------------------------------------
// Preparation des elements																		*/
// --------------------------------------------------------------------------------------------
$tl_['eng']['bcl_etat0'] = "Offline";		$tl_['fra']['bcl_etat0'] = "Hors ligne";	
$tl_['eng']['bcl_etat1'] = "Online";		$tl_['fra']['bcl_etat1'] = "En ligne";	
$tl_['eng']['bcl_etat2'] = "Deleted";		$tl_['fra']['bcl_etat2'] = "Supprim&eacute;";

$tl_['eng']['l1'] = "ID";								$tl_['fra']['l1'] = "ID";
$tl_['eng']['l2'] = "Name";								$tl_['fra']['l2'] = "Nom";
$tl_['eng']['l3'] = "Title";							$tl_['fra']['l3'] = "Titre";
$tl_['eng']['l4'] = "State";							$tl_['fra']['l4'] = "Etat";
$tl_['eng']['l5'] = "Creation date";					$tl_['fra']['l5'] = "Date de cr&eacute;ation";
$tl_['eng']['l6'] = "Threshold (YYYY-MM-DD hh:mm:ss)";	$tl_['fra']['l6'] = "Date limite (YYYY-MM-DD hh:mm:ss)";
$tl_['eng']['l7'] = "Creator";							$tl_['fra']['l7'] = "Cr&eacute;ateur";
$tl_['eng']['l8'] = "Articles in this deadline";		$tl_['fra']['l8'] = "Articles de ce bouclage";

$tab_etat['0']['t'] = $tl_[$l]['bcl_etat0'];	$tab_etat['0']['db'] = "OFFLINE";
$tab_etat['1']['t'] = $tl_[$l]['bcl_etat1'];	$tab_etat['1']['db'] = "ONLINE";
$tab_etat['2']['t'] = $tl_[$l]['bcl_etat2'];	$tab_etat['2']['db'] = "DELETED";
$tab_etat[$bouclage['bouclage_etat']]['s'] = " selected";
$pv['o1l4'] = "<select name ='M_BOUCLG[etat]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
foreach ( $tab_etat as $A ) { $pv['o1l4'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$pv['o1l4'] .= "</select>\r";

// --------------------------------------------------------------------------------------------
//	Affichage																					*/
// --------------------------------------------------------------------------------------------
switch ( $_REQUEST['uni_gestion_des_bouclages_p'] ) {
case 2:
	$tl_['eng']['invite1'] = "This part will allow you to modify deadlines.";
	$tl_['fra']['invite1'] = "Cette partie va vous permettre de modifier les bouclages.";
break;
case 3:
	$tl_['eng']['invite1'] = "This part will allow you to create deadlines.";
	$tl_['fra']['invite1'] = "Cette partie va vous permettre de cr&eacute;er les bouclages.";
break;
}

echo ("
<form ACTION='index.php?' method='post'>\r
<p>
".$tl_[$l]['invite1']."<br>\r
</p>\r
<hr>\r
");

$AD['1']['1']['1']['cont'] = $tl_[$l]['l1'];
$AD['1']['2']['1']['cont'] = $tl_[$l]['l2'];
$AD['1']['3']['1']['cont'] = $tl_[$l]['l3'];
$AD['1']['4']['1']['cont'] = $tl_[$l]['l4'];
$AD['1']['5']['1']['cont'] = $tl_[$l]['l5'];
$AD['1']['6']['1']['cont'] = $tl_[$l]['l6'];
$AD['1']['7']['1']['cont'] = $tl_[$l]['l7'];
$AD['1']['8']['1']['cont'] = $tl_[$l]['l8'];

switch ( $_REQUEST['uni_gestion_des_bouclages_p'] ) {
case 2:
	$AD['1']['1']['2']['cont'] = $bouclage['bouclage_id'];
	$AD['1']['2']['2']['cont'] = $bouclage['bouclage_nom'];
	$AD['1']['3']['2']['cont'] = "<input type='text' name='M_BOUCLG[titre]' size='45' maxlength='255' value=\"".$bouclage['bouclage_titre']."\" class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
	$AD['1']['5']['2']['cont'] = date ( "Y-m-j G:i:s" , $bouclage['bouclage_date_creation']);
	$AD['1']['6']['2']['cont'] = "<input type='text' name='M_BOUCLG[date_limite]' size='45' maxlength='255' value=\"".date ( "Y-m-j G:i:s" , $bouclage['bouclage_date_limite'])."\" class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
	$AD['1']['8']['2']['cont'] = $pv['liste_article'];
	$ADC['onglet']['1']['nbr_ligne'] = 8;	$ADC['onglet']['1']['nbr_cellule'] = 2;	$ADC['onglet']['1']['legende'] = 2;
break;
case 3:
	$tl_['eng']['bouclage_id'] = "?";						$tl_['fra']['bouclage_id'] = "?";
	$tl_['eng']['bouclage_nom'] = "New deadline";			$tl_['fra']['bouclage_nom'] = "Nouveau bouclage";
	$tl_['eng']['bouclage_titre'] = "Deadline_";			$tl_['fra']['bouclage_titre'] = "Bouclage_";
	$AD['1']['1']['2']['cont'] = $tl_[$l]['bouclage_id'];
	$AD['1']['2']['2']['cont'] = "<input type='text' name='M_BOUCLG[nom]' size='45' maxlength='255' value='".$tl_[$l]['bouclage_nom']."' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
	$AD['1']['3']['2']['cont'] = "<input type='text' name='M_BOUCLG[titre]' size='45' maxlength='255' value='". $tl_[$l]['bouclage_titre'] . date ( "Y-m-j G:i:s" , (mktime()+ (60*60*24*30)) )."' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
	$AD['1']['5']['2']['cont'] = date ( "Y-m-j G:i:s" , mktime() ) ;
	$AD['1']['6']['2']['cont'] = "<input type='text' name='M_BOUCLG[date_limite]' size='45' maxlength='255' value='".date ( "Y-m-j G:i:s" , (mktime()+ (60*60*24*30)) )."' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r";
	$ADC['onglet']['1']['nbr_ligne'] = 7;	$ADC['onglet']['1']['nbr_cellule'] = 2;	$ADC['onglet']['1']['legende'] = 2;
break;
}
$AD['1']['4']['2']['cont'] = $pv['o1l4'];
$AD['1']['7']['2']['cont'] = $bouclage['user_login'];

$tl_['eng']['onglet_1'] = "Informations";		$tl_['fra']['onglet_1'] = "Informations";

$tab_infos['AffOnglet']			= 1;
$tab_infos['NbrOnglet']			= 1;
$tab_infos['tab_comportement']	= 0;
$tab_infos['mode_rendu']		= 0;	// 0 echo 1 dans une variable
$tab_infos['TypSurbrillance']	= 0; // 1:ligne, 2:cellule
$tab_infos['doc_height']		= 320;
$tab_infos['doc_width']			= ${$theme_tableau}['theme_module_largeur_interne'] -24 ;
$tab_infos['groupe']			= "mb_grp1";
$tab_infos['cell_id']			= "tab";
$tab_infos['document']			= "doc";
$tab_infos['cell_1_txt']		= $tl_[$l]['onglet_1'];
include ("routines/website/affichage_donnees.php");


// --------------------------------------------------------------------------------------------
$tl_['eng']['bouton2'] = "Return to list";			$tl_['fra']['bouton2'] = "Retour &agrave; la liste";

switch ( $_REQUEST['uni_gestion_des_bouclages_p'] ) {
case 2:
	$tl_['eng']['bouton1'] = "Modify";		$tl_['fra']['bouton1'] = "Modifier";
	$tl_['eng']['text_confirm1'] = "<input type='checkbox' name='M_BOUCLG[confirmation_modification]' value='1'>I confirm the article modifications.";
	$tl_['fra']['text_confirm1'] = "<input type='checkbox' name='M_BOUCLG[confirmation_modification]' value='1'>Je valide la modification de l'article.";
	$pv['hidden_form_data'] = "<input type='hidden' name='UPDATE_action'	value='UPDATE_DEADLINE'>\r";
break;
case 3:
	$tl_['eng']['bouton1'] = "create";		$tl_['fra']['bouton1'] = "Cr&eacute;er";
	$tl_['eng']['text_confirm1'] = "Create and edit the new deadline.";
	$tl_['fra']['text_confirm1'] = "Cr&eacute;er et modifer le nouveau bouclage.";
	$pv['hidden_form_data'] = "<input type='hidden' name='UPDATE_action'	value='CREATE_DEADLINE'>\r";
break;
}


echo ("
<input type='hidden' name='M_BOUCLG[nom]'							value='".$bouclage['bouclage_nom']."'>\r
<input type='hidden' name='uni_gestion_des_bouclages_p'		value='".$_REQUEST['uni_gestion_des_bouclages_p']."'>\r".
$pv['hidden_form_data']
."<table ".${$theme_tableau}['tab_std_rules']." width='".${$theme_tableau}['theme_module_largeur_interne']."'>\r
<tr>\r".
$bloc_html['post_hidden_sw'].
$bloc_html['post_hidden_l'].
$bloc_html['post_hidden_arti_ref'].
$bloc_html['post_hidden_arti_page'].
$bloc_html['post_hidden_user_login'].
$bloc_html['post_hidden_user_pass'].
"
<td>\r".$tl_[$l]['text_confirm1']."\r</td>\r
<td>\r");
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
$bloc_html['post_hidden_arti_ref'].
"<input type='hidden' name='arti_page'	value='1'>\r".
$bloc_html['post_hidden_user_login'].
$bloc_html['post_hidden_user_pass'].
"<tr>\r
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
		$bouclage,
		$dbp,
		$dbquery,
		$AD,
		$ADC,
		$pv,
		$tab_etat,
		$tl_
	);
}

/*Hydre-contenu_fin*/
?>
