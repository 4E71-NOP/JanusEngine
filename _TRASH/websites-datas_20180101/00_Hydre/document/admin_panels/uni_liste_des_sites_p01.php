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
//	uni_liste_des_sites_p01.php debut
// --------------------------------------------------------------------------------------------
/*Hydre-contenu_debut*/
//$l = $langues[$site_web['sw_lang']]['langue_639_3'];
$_REQUEST['sql_initiateur'] = "uni_liste_des_sites_p01.php";

$tl_['txt']['eng']['invite1'] = "This part will show you the websites.";
$tl_['txt']['fra']['invite1'] = "Cette partie va vous permettre de voir les sites.";

$tl_['txt']['eng']['col_1_txt'] = "ID";				$tl_['txt']['fra']['col_1_txt'] = "ID";
$tl_['txt']['eng']['col_2_txt'] = "Name";			$tl_['txt']['fra']['col_2_txt'] = "Nom";
$tl_['txt']['eng']['col_3_txt'] = "Directory";		$tl_['txt']['fra']['col_3_txt'] = "R&eacute;pertoire";	
$tl_['txt']['eng']['col_4_txt'] = "Link";			$tl_['txt']['fra']['col_4_txt'] = "Lien";

$tl_['eng']['lien'] = "Go the the website";		$tl_['fra']['lien'] = "Aller au site web";

// --------------------------------------------------------------------------------------------
$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
SELECT sw_id, sw_nom, sw_repertoire 
FROM ".$SQL_tab_abrege['site_web']." 
ORDER BY sw_id
;");

$i = 1;
$AD['1'][$i]['1']['cont']	= $tl_['txt'][$l]['col_1_txt'];
$AD['1'][$i]['2']['cont']	= $tl_['txt'][$l]['col_2_txt'];
$AD['1'][$i]['3']['cont']	= $tl_['txt'][$l]['col_3_txt'];
$AD['1'][$i]['4']['cont']	= $tl_['txt'][$l]['col_4_txt'];
while ($dbp = fetch_array_sql($dbquery)) { 
	$i++;
	$AD['1'][$i]['1']['cont'] = $dbp['sw_id'];
	$AD['1'][$i]['2']['cont'] = $dbp['sw_nom'];
	$AD['1'][$i]['3']['cont'] = $dbp['sw_repertoire'];
	$AD['1'][$i]['4']['cont'] = "<a class='" . $theme_tableau . $_REQUEST['bloc']."_lien " . $theme_tableau . $_REQUEST['bloc']."_t2' href='index.php?sw=".$dbp['sw_id']."' target='_new'>".$tl_[$l]['lien']."</a>";
}

$ADC['onglet']['1']['nbr_ligne'] = $i;	$ADC['onglet']['1']['nbr_cellule'] = 4;	$ADC['onglet']['1']['legende'] = 1;
$tl_['eng']['onglet_1'] = "Informations";	$tl_['fra']['onglet_1'] = "Informations";

$tab_infos['AffOnglet']			= 1;
$tab_infos['NbrOnglet']			= 1;
$tab_infos['tab_comportement']	= 0;
$tab_infos['mode_rendu']		= 0;	// 0 echo 1 dans une variable
$tab_infos['TypSurbrillance']	= 1; // 1:ligne, 2:cellule
$tab_infos['doc_height']		= 256;
$tab_infos['doc_width']			= ${$theme_tableau}['theme_module_largeur_interne'];
$tab_infos['groupe']			= "lds_grp1";
$tab_infos['cell_id']			= "tab";
$tab_infos['document']			= "doc";
$tab_infos['cell_1_txt']		= $tl_[$l]['onglet_1'];
include ("routines/website/affichage_donnees.php");

// --------------------------------------------------------------------------------------------

if ( $site_web['sw_info_debug'] < 10 ) {
	unset (
		$dbp,
		$dbquery,
		$fc_class_,
		$tl_
	);
}
/*Hydre-contenu_fin*/
?>
