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
//	2005 09 11 : fra_gestion_des_modules_p01.php debut
//	2007 08 16 : Derniere modification
// --------------------------------------------------------------------------------------------
//	1 ARA / 2 CHI / 3 ENG / 4 ESP / 5 FRA / 6 GER / 7 RUS
$tl_['eng'][] = "?";
$tl_['fra'][] = "?";

/*Hydre-contenu_debut*/
$_REQUEST['sql_initiateur'] = "fra_gestion_des_modules_p01";

$tl_['eng']['part1_invite'] = "This part will allow you to create new modules.";
$tl_['fra']['part1_invite'] = "Cette partie va vous permettre de cr&eacute;er des modules.";

$tl_['eng']['part1_submit'] = "Create";
$tl_['fra']['part1_submit'] = "Cr&eacute;er un module";

echo ("
<p>
". $tl_[$l]['part1_invite'] ."</p>\r
<form ACTION='index.php?' method='post'>\r".
$bloc_html['post_hidden_sw'].
$bloc_html['post_hidden_l'].
$bloc_html['post_hidden_arti_ref'].
$bloc_html['post_hidden_user_login'].
$bloc_html['post_hidden_user_pass'].
"<input type='hidden' name='arti_page'					value='2'>\r
<input type='hidden' name='uni_gestion_des_modules_p'	value='3'>\r
<table cellpadding='0' cellspacing='0' style='margin-left: auto; margin-right: 0px; '>
<tr>\r
<td>\r
");
$_REQUEST['BS']['id']				= "bouton_creation";
$_REQUEST['BS']['type']				= "submit";
$_REQUEST['BS']['style_initial']	= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s1_n";
$_REQUEST['BS']['style_hover']		= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s1_h";
$_REQUEST['BS']['onclick']			= "";
$_REQUEST['BS']['message']			= $tl_[$l]['part1_submit'];
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

<hr>
");

$tl_['txt']['eng']['invite1'] = "This part will allow you to modify module properties.";
$tl_['txt']['fra']['invite1'] = "Cette partie va vous permettre de modifier les propri&eacute;t&eacute;s des modules.";

$tl_['txt']['eng']['col_1_txt'] = "Name";						$tl_['txt']['fra']['col_1_txt'] = "Nom";
$tl_['txt']['eng']['col_2_txt'] = "Description";				$tl_['txt']['fra']['col_2_txt'] = "Description";
$tl_['txt']['eng']['col_3_txt'] = "State";						$tl_['txt']['fra']['col_3_txt'] = "Etat";	
$tl_['txt']['eng']['col_4_txt'] = "Decoration";					$tl_['txt']['fra']['col_4_txt'] = "D&eacute;coration";
$tl_['txt']['eng']['col_5_txt'] = "Group who can see";			$tl_['txt']['fra']['col_5_txt'] = "Groupe pour voir";
$tl_['txt']['eng']['col_6_txt'] = "Group who cna use";			$tl_['txt']['fra']['col_6_txt'] = "Groupe pour utiliser";
$tl_['txt']['eng']['col_7_txt'] = "Administration panel";		$tl_['txt']['fra']['col_7_txt'] = "Panneau Admin";


$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
SELECT a.module_id,a.module_deco,a.module_deco_nbr,a.module_nom,a.module_titre,a.module_fichier,a.module_desc,a.module_groupe_pour_voir,a.module_groupe_pour_utiliser,a.module_adm_control,b.module_etat 
FROM ".$SQL_tab['module']." a , ".$SQL_tab['site_module']." b 
WHERE a.module_id = b.module_id 
AND b.site_id = '".$site_web['sw_id']."' 
ORDER BY b.module_position
;");

while ($dbp = fetch_array_sql($dbquery)) { 
	$module_id_index = $dbp['module_id'];
	foreach ( $dbp as $A => $B ) { $table_infos_modules[$module_id_index][$A] = $B; }
}

$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
SELECT * 
FROM ".$SQL_tab['groupe']."
;");
while ($dbp = fetch_array_sql($dbquery)) { 
	$pv['i'] = $dbp['groupe_id'];
	$groupTab[$pv['i']] = $dbp['groupe_titre'];
}

$tl_['eng']['mod_etat0'] = "Inactive";		$tl_['eng']['mod_etat1'] = "Active";	$tl_['eng']['mod_etat2'] = "Description";
$tl_['fra']['mod_etat0'] = "Inactif";	$tl_['fra']['mod_etat1'] = "Actif";	$tl_['fra']['mod_etat2'] = "";

$tl_['eng']['mod_deco0'] = "No";		$tl_['eng']['mod_deco1'] = "Yes";
$tl_['fra']['mod_deco0'] = "Non";	$tl_['fra']['mod_deco1'] = "Oui";

$tab_module_etat['0'] = "<span class='" . $theme_tableau . $_REQUEST['bloc']."_avert " . $theme_tableau . $_REQUEST['bloc']."_t1'>".$tl_[$l]['mod_etat0']."</span>";
$tab_module_etat['1'] = $tl_[$l]['mod_etat1'];
$tab_module_etat['2'] = "<span class='" . $theme_tableau . $_REQUEST['bloc']."_avert " . $theme_tableau . $_REQUEST['bloc']."_t1'>".$tl_[$l]['mod_etat2']."</span>";
$tab_module_deco['0'] = $tl_[$l]['mod_deco0'] ;
$tab_module_deco['1'] = $tl_[$l]['mod_deco1'] ;

$i = 1;
$AD['1'][$i]['1']['cont']	= $tl_['txt'][$l]['col_1_txt'];
$AD['1'][$i]['2']['cont']	= $tl_['txt'][$l]['col_2_txt'];
$AD['1'][$i]['3']['cont']	= $tl_['txt'][$l]['col_3_txt'];
$AD['1'][$i]['4']['cont']	= $tl_['txt'][$l]['col_4_txt'];
$AD['1'][$i]['5']['cont']	= $tl_['txt'][$l]['col_5_txt'];
$AD['1'][$i]['6']['cont']	= $tl_['txt'][$l]['col_6_txt'];
$AD['1'][$i]['7']['cont']	= $tl_['txt'][$l]['col_7_txt'];

foreach ( $table_infos_modules AS $A1 ) {
	$i++;
	$A2 = $A1['module_etat'];
	$A3 = $A1['module_deco'];
	$A4 = $A1['module_adm_control'];
	$gpv = $A1['module_groupe_pour_voir'];
	$gpu = $A1['module_groupe_pour_utiliser'];
	$gpv = $groupTab[$gpv];
	$gpu = $groupTab[$gpu];
	$AD['1'][$i]['1']['cont'] = "
	<a class='" . $theme_tableau . $_REQUEST['bloc']."_lien' href='index.php?
	M_MODULE[id]=".$A1['module_id']."
	&amp;arti_ref=".$DP_['arti_ref']."
	&amp;arti_page=2
	&amp;uni_gestion_des_modules_p=2
	".$bloc_html['url_slup']."'
	>".$A1['module_nom']."</a></td>\r";

	$AD['1'][$i]['2']['cont'] = $A1['module_desc'];
	$AD['1'][$i]['3']['cont'] = $tab_module_etat[$A2];
	$AD['1'][$i]['4']['cont'] = $tab_module_deco[$A3];
	$AD['1'][$i]['5']['cont'] = $gpv;
	$AD['1'][$i]['6']['cont'] = $gpu;
	$AD['1'][$i]['7']['cont'] = $tab_module_deco[$A4];
}

$ADC['onglet']['1']['nbr_ligne'] = $i;	$ADC['onglet']['1']['nbr_cellule'] = 7;	$ADC['onglet']['1']['legende'] = 1;
$tl_['eng']['onglet_1'] = "Informations";	$tl_['fra']['onglet_1'] = "Informations";

$tab_infos['AffOnglet']			= 1;
$tab_infos['NbrOnglet']			= 1;
$tab_infos['tab_comportement']	= 0;
$tab_infos['mode_rendu']		= 0;	// 0 echo 1 dans une variable
$tab_infos['TypSurbrillance']	= 1; // 1:ligne, 2:cellule
$tab_infos['doc_height']		= 256;
$tab_infos['doc_width']			= ${$theme_tableau}['theme_module_largeur_interne'];
$tab_infos['groupe']			= "gdm_grp1";
$tab_infos['cell_id']			= "tab";
$tab_infos['document']			= "doc";
$tab_infos['cell_1_txt']		= $tl_[$l]['onglet_1'];
include ("routines/website/affichage_donnees.php");

// --------------------------------------------------------------------------------------------

if ( $site_web['sw_info_debug'] < 10 ) {
	unset (
		$A1 , 
		$A2 , 
		$A3 , 
		$A4 , 
		$dbp , 
		$dbquery , 
		$fc_class , 
		$gpu , 
		$gpv , 
		$module_id_index , 
 		$table_infos_modules , 
		$tab_module_etat , 
		$tab_module_deco , 
		$groupTab , 
		$tl_  
	);
}

/*Hydre-contenu_fin*/
?>
