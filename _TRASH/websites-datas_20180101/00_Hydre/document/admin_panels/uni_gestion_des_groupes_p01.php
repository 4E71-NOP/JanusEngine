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
//	2008 04 19 : uni_gestion_des_groupes_p01.php debut
//	2008 04 19 : Derniere modification
// --------------------------------------------------------------------------------------------
/*Hydre-contenu_debut*/
$_REQUEST['sql_initiateur'] = "uni_gestion_des_groupes_p01.php";

$tl_['txt']['eng']['invite1'] = "This part will allow you to modify groups.";
$tl_['txt']['fra']['invite1'] = "Cette partie va vous permettre de modifier les groupes.";

$tl_['txt']['eng']['col_1_txt'] = "Name";					$tl_['txt']['fra']['col_1_txt'] = "Nom";
$tl_['txt']['eng']['col_2_txt'] = "Title";					$tl_['txt']['fra']['col_2_txt'] = "Titre";
$tl_['txt']['eng']['col_3_txt'] = "Tag";					$tl_['txt']['fra']['col_3_txt'] = "Tag";

$tl_['eng']['tag0']	= "Anonymous";		$tl_['fra']['tag0']	= "Anonyme";
$tl_['eng']['tag1']	= "Reader";			$tl_['fra']['tag1']	= "Lecteur";
$tl_['eng']['tag2']	= "Staff";			$tl_['fra']['tag2']	= "Staff";
$tl_['eng']['tag3']	= "Senior staff";	$tl_['fra']['tag3']	= "Staff senior";
$tab_tag['0'] = $tl_[$l]['tag0'];
$tab_tag['1'] = $tl_[$l]['tag1'];
$tab_tag['2'] = $tl_[$l]['tag2'];
$tab_tag['3'] = $tl_[$l]['tag3'];

$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
SELECT grp.*, sg.groupe_etat 
FROM ".$SQL_tab_abrege['groupe']." grp, ".$SQL_tab_abrege['site_groupe']." sg 
WHERE sg.site_id = '".$site_web['sw_id']."' 
AND grp.groupe_id = sg.groupe_id 
and grp.groupe_nom != 'Server_owner' 
;");
$i = 1;
$AD['1'][$i]['1']['cont']	= $tl_['txt'][$l]['col_1_txt'];
$AD['1'][$i]['2']['cont']	= $tl_['txt'][$l]['col_2_txt'];
$AD['1'][$i]['3']['cont']	= $tl_['txt'][$l]['col_3_txt'];
while ($dbp = fetch_array_sql($dbquery)) { 
	$i++;
	$AD['1'][$i]['1']['cont'] = "<a class='" . $theme_tableau . $_REQUEST['bloc']."_lien " . $theme_tableau . $_REQUEST['bloc']."_t1' href='index.php?
	&amp;M_GROUPE[groupe_selection]=".$dbp['groupe_id'].$bloc_html['url_sldup']."
	&amp;arti_page=2&amp;uni_gestion_des_groupe_p=2'>".$dbp['groupe_nom']."</a>";
	$AD['1'][$i]['2']['cont'] = $dbp['groupe_titre'];
	$AD['1'][$i]['3']['cont'] = $tab_tag[$dbp['groupe_tag']];
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
$tab_infos['groupe']			= "gdd_grp1";
$tab_infos['cell_id']			= "tab";
$tab_infos['document']			= "doc";
$tab_infos['cell_1_txt']		= $tl_[$l]['onglet_1'];
include ("routines/website/affichage_donnees.php");

// --------------------------------------------------------------------------------------------

$tl_['eng']['bouton1'] = "Create a group";
$tl_['fra']['bouton1'] = "Cr&eacute;er un groupe";

echo ("
<form ACTION='index.php?' method='post'>\r".
$bloc_html['post_hidden_sw'].
$bloc_html['post_hidden_l'].
$bloc_html['post_hidden_arti_ref']."
<input type='hidden' name='arti_page'	value='2'>\r
<input type='hidden' name='uni_gestion_des_groupe_p'	value='3'>\r
".
$bloc_html['post_hidden_user_login'].
$bloc_html['post_hidden_user_pass']."
<table cellpadding='0' cellspacing='0' style='margin-left: auto; margin-right: 0px; '>
<tr>\r
<td>\r
");
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
echo ("
</td>\r
</tr>\r
</table>\r
<br>\r
</form> 
");

if ( $site_web['sw_info_debug'] < 10 ) {
	unset (
		$bouclage,
		$dbp,
		$dbquery,
		$fc_class_,
		$tab_tag,
		$tl_
	);
}
/*Hydre-contenu_fin*/
?>
