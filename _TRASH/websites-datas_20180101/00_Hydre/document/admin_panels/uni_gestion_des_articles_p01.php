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
$_REQUEST['RA']['SQLlang'] = 48;
$_REQUEST['RA']['SQLbouclage'] = 4;
$_REQUEST['RA']['SQLnom'] = "charg";
$_REQUEST['RA']['action'] = "";
//$_REQUEST['RA']['action'] = "AFFICHAGE";

/*Hydre-contenu_debut*/
$_REQUEST['sql_initiateur'] = "fra_modification_article_p01";

if ( $_REQUEST['RA']['action'] == "AFFICHAGE" ) {
	if ( strlen($_REQUEST['RA']['SQLnom']) > 0 ) { $pv['rch_clause'] .= " AND art.arti_nom LIKE '%".$_REQUEST['RA']['SQLnom']."%'"; }
	if ( $_REQUEST['RA']['SQLlang'] != 0 ) { $pv['rch_clause'] .= " AND cat.cate_lang = '".$_REQUEST['RA']['SQLlang']."'"; }
	if ( $_REQUEST['RA']['SQLbouclage'] != 0 ) { $pv['rch_clause'] .= " AND bcl.bouclage_id = '".$_REQUEST['RA']['SQLbouclage']."'"; }
}

$tl_['txt']['eng']['invite1'] = "This part will allow you to modify articles.";
$tl_['txt']['fra']['invite1'] = "Cette partie va vous permettre de modifier les articles.";

$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
SELECT art.arti_ref, art.arti_id, art.arti_nom, art.arti_titre, art.arti_page , cat.cate_lang, bcl.bouclage_nom, bcl.bouclage_titre, bcl.bouclage_etat
FROM ".$SQL_tab_abrege['article']." art, ".$SQL_tab_abrege['categorie']." cat, ".$SQL_tab_abrege['bouclage']." bcl
WHERE art.arti_ref = cat.arti_ref 
AND art.arti_bouclage = bcl.bouclage_id

AND art.site_id = bcl.site_id
AND bcl.site_id = cat.site_id
AND cat.site_id = '".$site_web['sw_id']."' 

AND cat.cate_etat != '2' 
AND cat.cate_type IN ('1','0') 

".$pv['rch_clause']." 

ORDER BY art.arti_ref,art.arti_page
;");



if ( num_row_sql($dbquery) != 0 ) {
	while ($dbp = fetch_array_sql($dbquery)) { 
		$p = &$pv['liste_article'][$dbp['arti_ref']][$dbp['arti_id']];
		$p['arti_ref'] = $dbp['arti_ref'];
		$p['arti_id'] = $dbp['arti_id'];
		$p['arti_nom'] = $dbp['arti_nom'];
		$p['arti_titre'] = $dbp['arti_titre'];
		$p['arti_page'] = $dbp['arti_page'];
		$p['arti_lang'] = $dbp['cate_lang'];
		$p['bouclage_etat'] = $dbp['bouclage_etat'];
		$p['bouclage_titre'] = $dbp['bouclage_titre'];
	}

	$pv['tab_etat'][0] = "<span class='" . $theme_tableau.$_REQUEST['bloc']."_avert'>";
	$pv['tab_etat'][1] = "<span class='" . $theme_tableau.$_REQUEST['bloc']."_ok'>";
	$pv['tab_etat'][2] = "<span class='" . $theme_tableau.$_REQUEST['bloc']."_erreur'>";

	$tl_['txt']['eng']['col_1_txt'] = "Name";					$tl_['txt']['fra']['col_1_txt'] = "Nom";
	$tl_['txt']['eng']['col_2_txt'] = "Pages";					$tl_['txt']['fra']['col_2_txt'] = "Pages";
	$tl_['txt']['eng']['col_3_txt'] = "Language";				$tl_['txt']['fra']['col_3_txt'] = "Langage";	
	$tl_['txt']['eng']['col_4_txt'] = "Deadline";				$tl_['txt']['fra']['col_4_txt'] = "Bouclage";	

	unset ( $A , $B );
	$i = 1;
	$AD['1'][$i]['1']['cont']	= $tl_['txt'][$l]['col_1_txt'];
	$AD['1'][$i]['2']['cont']	= $tl_['txt'][$l]['col_2_txt'];
	$AD['1'][$i]['3']['cont']	= $tl_['txt'][$l]['col_3_txt'];
	$AD['1'][$i]['4']['cont']	= $tl_['txt'][$l]['col_4_txt'];

	$pv['lien_arti_id1'] = "<a class='" . $theme_tableau . $_REQUEST['bloc']."_lien' href='index.php?arti_ref_selection=";
	$pv['lien_arti_id2'] = "&amp;arti_page_selection=";
	$pv['lien_arti_id3'] = $bloc_html['url_sldup']."&amp;arti_page=2'>";
	$pv['traduction'] = $langues[$l]['id'];
	$pv['traduction'] = $langues[$pv['traduction']]['langue_nom_original'];

	foreach ( $pv['liste_article'] as &$A ) {
		$i++;
		unset ( $pv['article_pages_lien'] );
		$pv['article_pages_lien'] = "";
		unset ( $B );
		foreach ( $A as $B ) { 
			$AD['1'][$i]['1']['cont'] = $B['arti_ref'];
			$pv['article_pages_lien'] .= $pv['lien_arti_id1'] . $B['arti_ref'] . $pv['lien_arti_id2'] . $B['arti_page'] . $pv['lien_arti_id3'] . $B['arti_page'] . "</a>";
			$pv['article_pages_lien'] .= " - ";
			$AD['1'][$i]['3']['cont'] = $langues[$B['arti_lang']][$pv['traduction']];
			$AD['1'][$i]['4']['cont'] = $pv['tab_etat'][$B['bouclage_etat']] . $B['bouclage_titre'] . "</span>";
		}
		$pv['article_pages_lien'] = substr ( $pv['article_pages_lien'] , 0 , -3 );
		$AD['1'][$i]['2']['cont'] = $pv['article_pages_lien'];
	}
}
// --------------------------------------------------------------------------------------------
//	Form
// --------------------------------------------------------------------------------------------
$dbquery = requete_sql($_REQUEST['sql_initiateur'],"SELECT * FROM ".$SQL_tab_abrege['langues'].";");
while ($dbp = fetch_array_sql($dbquery)) {
	$A = $dbp['langue_id'];
	$pv['ListLang'][$A]['id'] = $A;
	$pv['ListLang'][$A]['txt'] = $dbp['langue_nom_original'];
}

if ( isset($_REQUEST['RA']['SQLlang']) ) { $pv['ListLang'][$_REQUEST['RA']['SQLlang']]['selected'] = "selected"; }

$tl_['eng']['boucl0'] = "Choose a deadline";	$tl_['fra']['boucl0'] = "Choisissez un bouclage";
$pv['ListBoucl']['0']['id'] = 0;
$pv['ListBoucl']['0']['bouclage_titre'] = $tl_[$l]['boucl0'];

$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
SELECT bouclage_id,bouclage_nom,bouclage_titre,bouclage_etat FROM ".$SQL_tab_abrege['bouclage']." 
WHERE site_id = '".$site_web['sw_id']."'
;");
while ($dbp = fetch_array_sql($dbquery)) {
	$A = $dbp['bouclage_id'];
	$pv['ListBoucl'][$A]['id'] = $A;
	$pv['ListBoucl'][$A]['bouclage_nom'] = $dbp['bouclage_nom'];
	$pv['ListBoucl'][$A]['bouclage_titre'] = $dbp['bouclage_titre'];
	$pv['ListBoucl'][$A]['bouclage_etat'] = $dbp['bouclage_etat'];
}
unset ( $A );
foreach ( $pv['ListBoucl'] as $A ) {
	if ( $A['bouclage_etat'] == 0 ) { $A['bouclage_titre'] = "<span class='".$theme_tableau.$_REQUEST['bloc']."_err'>" . $A['bouclage_titre']; }
	else { $A['bouclage_titre'] = "<span class='".$theme_tableau.$_REQUEST['bloc']."_ok'>" . $A['bouclage_titre']; }
	$A['bouclage_titre'] = $A['bouclage_nom'] . "</span>"; 
}
if ( isset($_REQUEST['RA']['SQLbouclage']) ) { $pv['ListBoucl'][$_REQUEST['RA']['SQLbouclage']]['selected'] = "selected"; }

// --------------------------------------------------------------------------------------------
$tl_['eng']['caption'] = "Search";	$tl_['fra']['caption'] = "Recherche";

$tl_['eng']['c1l1'] = "Name contains";	$tl_['fra']['c1l1'] = "Nom contient";
$tl_['eng']['c1l2'] = "Language";		$tl_['fra']['c1l2'] = "Langue";
$tl_['eng']['c1l3'] = "Dead line";		$tl_['fra']['c1l3'] = "Bouclage";

echo ("
<form id='MH_001' ACTION='index.php?' method='post'>\r".
$bloc_html['post_hidden_sw'].
$bloc_html['post_hidden_l'].
$bloc_html['post_hidden_arti_ref'].
$bloc_html['post_hidden_arti_page'].
$bloc_html['post_hidden_user_login'].
$bloc_html['post_hidden_user_pass']."
<input type='hidden' name='RA[action]'	value='AFFICHAGE'>\r

<table ".${$theme_tableau}['tab_std_rules']." width='".${$theme_tableau}['theme_module_largeur_interne']."px'>\r
<tr>\r
<td class='" . $theme_tableau.$_REQUEST['bloc']."_fcta' colspan='2'>".$tl_[$l]['caption']."</td>\r
</tr>\r

<tr>\r
<td class='" . $theme_tableau.$_REQUEST['bloc']."_fca'>".$tl_[$l]['c1l1']."</td>\r
<td class='" . $theme_tableau.$_REQUEST['bloc']."_fca'><input type='text' name='RA[SQLnom]' size='15' value='".$_REQUEST['RA']['SQLnom']."' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau.$_REQUEST['bloc']."_form_1'></td>\r
</tr>\r

<tr>\r
<td class='" . $theme_tableau.$_REQUEST['bloc']."_fca'>".$tl_[$l]['c1l2']."</td>\r
<td class='" . $theme_tableau.$_REQUEST['bloc']."_fca'><select name='RA[SQLlang]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau.$_REQUEST['bloc']."_form_1'>
");
unset ( $A , $B );
foreach ( $pv['ListLang'] as $A ) {
	echo ("<option value='".$A['id']."' ".$A['selected'].">".$A['txt']."</option>\r");
}
echo ("</select>
</td>\r
</tr>\r

<tr>\r
<td class='" . $theme_tableau.$_REQUEST['bloc']."_fca'>".$tl_[$l]['c1l3']."</td>\r
<td class='" . $theme_tableau.$_REQUEST['bloc']."_fca'><select name='RA[SQLbouclage]' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau.$_REQUEST['bloc']."_form_1'>
");
unset ( $A , $B );
foreach ( $pv['ListBoucl'] as $A ) {
	echo ("<option value='".$A['id']."' ".$A['selected'].">".$A['bouclage_titre']."/".$A['bouclage_nom']."</option>\r");
}
echo ("</select></tr>\r
</table>\r
<br>\r
");

$tl_['eng']['rfrsh'] = "Refresh display";
$tl_['fra']['rfrsh'] = "Rafraichir la vue";

$_REQUEST['BS']['id']				= "bouton_raffraichir";
$_REQUEST['BS']['type']				= "submit";
$_REQUEST['BS']['style_initial']	= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau.$_REQUEST['bloc']."_submit_s1_n";
$_REQUEST['BS']['style_hover']		= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau.$_REQUEST['bloc']."_submit_s1_h";
$_REQUEST['BS']['onclick']			= "";
$_REQUEST['BS']['message']			= $tl_[$l]['rfrsh'];
$_REQUEST['BS']['mode']				= 1;
$_REQUEST['BS']['taille'] 			= 192;
$_REQUEST['BS']['derniere_taille']	= 0;
echo generation_bouton ();

echo ("
</form>\r
<br>\r
");

// --------------------------------------------------------------------------------------------
$ADC['onglet']['1']['nbr_ligne'] = $i;	$ADC['onglet']['1']['nbr_cellule'] = 4;	$ADC['onglet']['1']['legende'] = 1;
$tl_['eng']['onglet_1'] = "Informations";	$tl_['fra']['onglet_1'] = "Informations";

$tab_infos['AffOnglet']			= 1;
$tab_infos['NbrOnglet']			= 1;
$tab_infos['tab_comportement']	= 0;
$tab_infos['mode_rendu']		= 0;	// 0 echo 1 dans une variable
$tab_infos['TypSurbrillance']	= 1; // 1:ligne, 2:cellule
$tab_infos['doc_height']		= 256;
$tab_infos['doc_width']			= ${$theme_tableau}['theme_module_largeur_interne'];
$tab_infos['groupe']			= "gda_grp1";
$tab_infos['cell_id']			= "tab";
$tab_infos['document']			= "doc";
$tab_infos['cell_1_txt']		= $tl_[$l]['onglet_1'];
include ("routines/website/affichage_donnees.php");

if ( $site_web['sw_info_debug'] < 10 ) {
	unset (
		$dbp, 
		$dbquery, 
		$fc_class_, 
		$fp, 
		$i, 
		$menu_principal, 
		$pv, 
		$tl_, 
		$trr, 
		$WM_MA_table_witdh
	);
}

/*Hydre-contenu_fin*/
?>
