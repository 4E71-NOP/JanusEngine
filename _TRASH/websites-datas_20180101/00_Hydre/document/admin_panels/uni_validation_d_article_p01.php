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
//	2005 09 22 : uni_validation_d_article_p01.php debut
//	2007 05 31 : derniere modification
// --------------------------------------------------------------------------------------------
/*Hydre-contenu_debut*/
$_REQUEST['sql_initiateur'] = "uni_validation_d_article_p01";

// --------------------------------------------------------------------------------------------
$tl_['txt']['eng']['invite1'] = "This part will allow you to validate documents.";
$tl_['txt']['fra']['invite1'] = "Cette partie va vous permettre de valider des articles.";

$tl_['txt']['eng']['col_1_txt'] = "Name";		$tl_['txt']['eng']['col_2_txt'] = "Reference";		$tl_['txt']['eng']['col_3_txt'] = "Title";		$tl_['txt']['eng']['col_4_txt'] = "Deadline";	
$tl_['txt']['fra']['col_1_txt'] = "Nom";	$tl_['txt']['fra']['col_2_txt'] = "Reference";	$tl_['txt']['fra']['col_3_txt'] = "Titre";	$tl_['txt']['fra']['col_4_txt'] = "Bouclage";

//$trr['nbr_col'] = 4 ;

$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
SELECT art.* , bcl.bouclage_nom 
FROM ".$SQL_tab_abrege['article']." art, ".$SQL_tab_abrege['bouclage']." bcl 
WHERE art.arti_validation_etat = '0' 
AND bcl.bouclage_id = art.arti_bouclage 
AND art.site_id = '".$site_web['sw_id']."' 
;");

if ( num_row_sql($dbquery) == 0 ) {
	$tl_['txt']['eng']['raf1'] = "Nothing to display";			$tl_['txt']['fra']['raf1'] = "Rien a afficher";

	$i = 1;
	$AD['1'][$i]['1']['cont'] = $tl_['txt'][$l]['raf1'];
	$AD['1'][$i]['2']['cont'] = "";
	$AD['1'][$i]['3']['cont'] = "";
	$AD['1'][$i]['4']['cont'] = "";
}
else {
	$i = 1;
	$AD['1'][$i]['1']['cont']	= $tl_['txt'][$l]['col_1_txt'];
	$AD['1'][$i]['2']['cont']	= $tl_['txt'][$l]['col_2_txt'];
	$AD['1'][$i]['3']['cont']	= $tl_['txt'][$l]['col_3_txt'];
	$AD['1'][$i]['4']['cont']	= $tl_['txt'][$l]['col_4_txt'];
	while ($dbp = fetch_array_sql($dbquery)) { 
		$i++;
		$AD['1'][$i]['1']['cont']	= "
		<a class='" . $theme_tableau . $_REQUEST['bloc']."_lien' href='index.php?
		&amp;M_ARTICL[arti_id_selection]=".$dbp['arti_id']."
		&amp;M_ARTICL[arti_ref_selection]=".$dbp['arti_ref']."
		&amp;M_ARTICL[arti_page_selection]=".$dbp['arti_page'].
		$bloc_html['url_sldup']."
		&amp;arti_page=2'
		 onMouseOver = \"window.status = 'Execution du script'; return true;\"
		  onMouseOut=\"window.status = '".$site_web['sw_barre_status']."'; return true;\" >".$dbp['arti_nom']."</a>";
		$AD['1'][$i]['2']['cont']	= $dbp['arti_ref'];
		$AD['1'][$i]['3']['cont']	= $dbp['arti_titre'];
		$AD['1'][$i]['4']['cont']	= $dbp['bouclage_nom'];
	}
}

$ADC['onglet']['1']['nbr_ligne'] = $i;	$ADC['onglet']['1']['nbr_cellule'] = 4;	$ADC['onglet']['1']['legende'] = 1;
$tl_['eng']['onglet_1'] = "Informations";	$tl_['fra']['onglet_1'] = "Informations";

$tab_infos['AffOnglet']			= 1;
$tab_infos['NbrOnglet']			= 1;
$tab_infos['tab_comportement']	= 0;
$tab_infos['mode_rendu']		= 0;	// 0 echo 1 dans une variable
$tab_infos['TypSurbrillance']	= 1; // 1:ligne, 2:cellule
$tab_infos['doc_height']		= 512;
$tab_infos['doc_width']			= ${$theme_tableau}['theme_module_largeur_interne'];
$tab_infos['groupe']			= "vda_grp1";
$tab_infos['cell_id']			= "tab";
$tab_infos['document']			= "doc";
$tab_infos['cell_1_txt']		= $tl_[$l]['onglet_1'];
include ("routines/website/affichage_donnees.php");

// --------------------------------------------------------------------------------------------

$tl_['eng']['bouton1'] = "Create a article";
$tl_['fra']['bouton1'] = "Cr&eacute;er un article";

echo ("
<br>\r
<br>\r

<table cellpadding='0' cellspacing='0' style='margin-left: auto; margin-right: 0px; '>
<tr>\r
<td>\r
<form ACTION='index.php?' method='post'>\r".
$bloc_html['post_hidden_sw'].
$bloc_html['post_hidden_l'].
$bloc_html['post_hidden_arti_ref']."
<input type='hidden' name='arti_page'	value='2'>\r
<input type='hidden' name='uni_gestion_des_articles_p' value='3';".
$bloc_html['post_hidden_user_login'].
$bloc_html['post_hidden_user_pass']
);
$_REQUEST['BS']['id']				= "bouton_creation";
$_REQUEST['BS']['type']				= "submit";
$_REQUEST['BS']['style_initial']	= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s2_n";
$_REQUEST['BS']['style_hover']		= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s2_h";
$_REQUEST['BS']['onclick']			= "";
$_REQUEST['BS']['message']			= $tl_[$l]['bouton1'];
$_REQUEST['BS']['mode']				= 0;
$_REQUEST['BS']['taille'] 			= 0;
$_REQUEST['BS']['derniere_taille']	= 0;
echo generation_bouton ();
echo ("<br>\r&nbsp;
</form>\r
</td>\r
</tr>\r
</table>\r
<br>\r
");

if ( $site_web['sw_info_debug'] < 10 ) {
	unset (
		$dbp,
		$dbquery,
		$fc_class_,
		$tab_etat,
		$trr,
		$tl_
	);
}

/*Hydre-contenu_fin*/
?>
