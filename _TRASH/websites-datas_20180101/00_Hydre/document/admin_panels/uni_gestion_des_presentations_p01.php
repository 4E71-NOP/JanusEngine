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
/*Hydre-contenu_debut*/
$tl_['eng']['invite1'] = "This part will alow you to modify displays.";
$tl_['fra']['invite1'] = "Cette partie va vous permettre de modifier les pr&eacute;sentation.";

echo ("<p>". $tl_[$l]['invite1']."</p>");

$dbquery = requete_sql( $_REQUEST['sql_initiateur'],"
SELECT pr.*, sd.theme_titre
FROM ".$SQL_tab_abrege['presentation']." pr, ".$SQL_tab_abrege['theme_presentation']." sp, ".$SQL_tab_abrege['site_theme']." ss, ".$SQL_tab_abrege['theme_descripteur']." sd 
WHERE ss.site_id = '".$site_web['sw_id']."' 
AND sp.theme_id = ss.theme_id 
AND ss.theme_id = sd.theme_id
AND sp.pres_id = pr.pres_id 
ORDER BY pr.pres_id
;");

$tl_['txt']['eng']['col_1_txt'] = "Name";				$tl_['txt']['fra']['col_1_txt'] = "Nom";
$tl_['txt']['eng']['col_2_txt'] = "Generic name";		$tl_['txt']['fra']['col_2_txt'] = "Nom g&eacute;n&eacute;rique";
$tl_['txt']['eng']['col_3_txt'] = "Theme";				$tl_['txt']['fra']['col_3_txt'] = "Theme";

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
		&amp;uni_gestion_des_presentation_p=2
		&amp;M_PRESNT[pres_id]=".$dbp['pres_id']. 
		$bloc_html['url_sldup'].
		"&amp;arti_page=2
		'
		 onMouseOver = \"window.status = 'Execution du script'; return true;\"
		 onMouseOut=\"window.status = '".$site_web['sw_barre_status']."'; return true;\" >".$dbp['pres_nom']."</a>";
		$AD['1'][$i]['2']['cont']	= $dbp['pres_titre'];
		$AD['1'][$i]['3']['cont']	= $dbp['theme_titre'];
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
$tab_infos['groupe']			= "gdp_grp1";
$tab_infos['cell_id']			= "tab";
$tab_infos['document']			= "doc";
$tab_infos['cell_1_txt']		= $tl_[$l]['onglet_1'];
include ("routines/website/affichage_donnees.php");

if ( $site_web['sw_info_debug'] < 10 ) {
	unset (
		$dbp,
		$dbquery,
		$pv,
		$trr,
		$tl_
	);
}

/*Hydre-contenu_fin*/
?>
