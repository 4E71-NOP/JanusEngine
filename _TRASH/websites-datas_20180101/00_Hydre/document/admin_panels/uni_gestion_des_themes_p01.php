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
//	2005 08 08 : fra_modification_de_theme_p01.php debut
//	Modification theme
// --------------------------------------------------------------------------------------------
/*Hydre-contenu_debut*/

$_REQUEST['sql_initiateur'] = "uni_gestion_des_themes_p01.php";

// --------------------------------------------------------------------------------------------

$tl_['txt']['eng']['invite1'] = "This part will allow you to manage themes.";
$tl_['txt']['fra']['invite1'] = "Cette partie va vous permettre de gerer les themes.";

$tl_['txt']['eng']['col_1_txt'] = "Name";		$tl_['txt']['eng']['col_2_txt'] = "Title";		$tl_['txt']['eng']['col_3_txt'] = "Date";
$tl_['txt']['fra']['col_1_txt'] = "Nom";	$tl_['txt']['fra']['col_2_txt'] = "Titre";	$tl_['txt']['fra']['col_3_txt'] = "Date";

$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
SELECT s.theme_id, s.theme_nom, s.theme_titre, s.theme_date 
FROM ".$SQL_tab_abrege['theme_descripteur']." s, ".$SQL_tab_abrege['site_theme']." ss 
WHERE s.theme_id = ss.theme_id 
AND ss.site_id = '".$site_web['sw_id']."' 
;");

if ( num_row_sql($dbquery) == 0 ) {
	$tl_['txt']['eng']['raf1'] = "Nothing to display";			$tl_['txt']['fra']['raf1'] = "Rien a afficher";

	$i = 1;
	$AD['1'][$i]['1']['cont'] = $tl_['txt'][$l]['raf1'];
	$AD['1'][$i]['2']['cont'] = "";
	$AD['1'][$i]['3']['cont'] = "";
}
else {
	$i = 1;
	$AD['1'][$i]['1']['cont']	= $tl_['txt'][$l]['col_1_txt'];
	$AD['1'][$i]['2']['cont']	= $tl_['txt'][$l]['col_2_txt'];
	$AD['1'][$i]['3']['cont']	= $tl_['txt'][$l]['col_3_txt'];
	while ($dbp = fetch_array_sql($dbquery)) { 
		$i++;
		$AD['1'][$i]['1']['cont']	= "
		<a class='" . $theme_tableau . $_REQUEST['bloc']."_lien' href='index.php?
		&amp;M_THEME[theme_id_selection]=".$dbp['theme_id']."
		&amp;M_THEME[theme_nom_selection]=".$dbp['theme_nom'].$bloc_html['url_sldup']."
		&amp;arti_page=2
		&amp;uni_gestion_des_theme_p=2' 
		 onMouseOver = \"window.status = 'Execution du script'; return true;\"
		 onMouseOut=\"window.status = '".$site_web['sw_barre_status']."'; return true;\" >".$dbp['theme_nom']."</a>";
		$AD['1'][$i]['2']['cont']	= $dbp['theme_titre'];
		$AD['1'][$i]['3']['cont']	= strftime ("%a %d %b %y - %H:%M",$dbp['theme_date'] );		
		$AD['1'][$i]['2']['tc']	= 2;
		$AD['1'][$i]['3']['tc']	= 1;

	}
}

$ADC['onglet']['1']['nbr_ligne'] = $i;	$ADC['onglet']['1']['nbr_cellule'] = 3;	$ADC['onglet']['1']['legende'] = 1;
$tl_['eng']['onglet_1'] = "Informations";	$tl_['fra']['onglet_1'] = "Informations";

$tab_infos['AffOnglet']			= 1;
$tab_infos['NbrOnglet']			= 1;
$tab_infos['tab_comportement']	= 0;
$tab_infos['mode_rendu']		= 0;	// 0 echo 1 dans une variable
$tab_infos['TypSurbrillance']	= 1; // 1:ligne, 2:cellule
$tab_infos['doc_height']		= 256;
$tab_infos['doc_width']			= ${$theme_tableau}['theme_module_largeur_interne'];
$tab_infos['groupe']			= "edc_grp1";
$tab_infos['cell_id']			= "tab";
$tab_infos['document']			= "doc";
$tab_infos['cell_1_txt']		= $tl_[$l]['onglet_1'];
include ("routines/website/affichage_donnees.php");

// --------------------------------------------------------------------------------------------
$tl_['eng']['bouton1'] = "Create a theme";
$tl_['fra']['bouton1'] = "Cr&eacute;er un theme";

echo ("
<br>\r

<table cellpadding='0' cellspacing='0' style='margin-left: auto; margin-right: 0px; '>
<tr>\r
<td>\r
<form ACTION='index.php?' method='post'>\r".
$bloc_html['post_hidden_sw'].
$bloc_html['post_hidden_l'].
$bloc_html['post_hidden_arti_ref'].
"
<input type='hidden' name='arti_page'				value='2'>\r
<input type='hidden' name='uni_gestion_des_theme_p'	value='3'>\r
".
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
