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
//	2008 04 19 : uni_gestion_des_mot_cle_p01.php debut
//	2008 04 19 : Derniere modification
// --------------------------------------------------------------------------------------------
//$_REQUEST[M_MOTCLE][filtre] = "p01_001";
/*Hydre-contenu_debut*/
$_REQUEST['sql_initiateur'] = "uni_gestion_des_mot_cle_p01.php";

// --------------------------------------------------------------------------------------------
echo ("<form ACTION='index.php?' method='post' name='formulaire_module'>\r");

if ( isset($_REQUEST['M_MOTCLE']['filtre']) ) { $pv['clause']  = " AND mc_nom like '%".$_REQUEST['M_MOTCLE']['filtre']."%' "; }
$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
SELECT *  
FROM ".$SQL_tab_abrege['mot_cle']." 
WHERE site_id = '".$site_web['sw_id']."' 
AND mc_etat != '2' 
".$pv['clause']." 
;");

if ( num_row_sql($dbquery) == 0 ) {
	$tl_['txt']['eng']['raf1'] = "Nothing to display";			$tl_['txt']['fra']['raf1'] = "Rien a afficher";

	$i = 1;
	$AD['1'][$i]['1']['cont'] = $tl_['txt'][$l]['raf1'];
	$AD['1'][$i]['2']['cont'] = "";
	$AD['1'][$i]['3']['cont'] = "";
}
else {

	$tl_['txt']['eng']['invite1'] = "This part will allow you to modify keywords.";
	$tl_['txt']['fra']['invite1'] = "Cette partie va vous permettre de modifier les mots cl&eacute;s.";

	$tl_['txt']['eng']['col_1_txt'] = "Name";		$tl_['txt']['eng']['col_2_txt'] = "Type";		$tl_['txt']['eng']['col_3_txt'] = "State";
	$tl_['txt']['fra']['col_1_txt'] = "Nom";	$tl_['txt']['fra']['col_2_txt'] = "Type";	$tl_['txt']['fra']['col_3_txt'] = "Etat";

	$tl_['type']['1']['eng'] = "Link to a category";				$tl_['type']['2']['eng'] = "Link to an URL";		$tl_['type']['3']['eng'] = "Dynamic help";
	$tl_['type']['1']['fra'] = "Vers une cat&eacute;gorie";	$tl_['type']['2']['fra'] = "Vers une URL";	$tl_['type']['3']['fra'] = "Aide dynamique";

	$tl_['etat']['0']['eng'] = "Offline";			$tl_['etat']['1']['eng'] = "Online";
	$tl_['etat']['0']['fra'] = "Hors ligne";	$tl_['etat']['1']['fra'] = "En ligne";

	$i = 1;
	$AD['1'][$i]['1']['cont']	= $tl_['txt'][$l]['col_1_txt'];
	$AD['1'][$i]['2']['cont']	= $tl_['txt'][$l]['col_2_txt'];
	$AD['1'][$i]['3']['cont']	= $tl_['txt'][$l]['col_3_txt'];
	while ($dbp = fetch_array_sql($dbquery)) { 
		$i++;
		$AD['1'][$i]['1']['cont']	= "<a class='" . $theme_tableau . $_REQUEST['bloc']."_lien' href='index.php?
&amp;M_MOTCLE[mot_cle_selection]=".$dbp['mc_id'].
"&amp;M_MOTCLE[uni_gestion_des_motcle_p]=2".
$bloc_html['url_sldup']."
&amp;arti_page=2'
 onMouseOver = \"window.status = 'Execution du script'; return true;\" 
 onMouseOut=\"window.status = '".$site_web['sw_barre_status']."'; return true;\" 
>".$dbp['mc_nom']."</a>";
		$AD['1'][$i]['2']['cont']	= $tl_['type'][$dbp['mc_type']][$l];
		$AD['1'][$i]['3']['cont']	= $tl_['etat'][$dbp['mc_etat']][$l];
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
$tl_['eng']['bouton1'] = "Filter";
$tl_['fra']['bouton1'] = "Filtrer";	

$tl_['eng']['bouton2'] = "Create";
$tl_['fra']['bouton2'] = "Cr&eacute;er";

echo ("
<br>\r".
$bloc_html['post_hidden_sw'].
$bloc_html['post_hidden_l'].
$bloc_html['post_hidden_arti_ref']."
<input type='hidden' name='arti_page' value='1'>\r".
$bloc_html['post_hidden_user_login'].
$bloc_html['post_hidden_user_pass']."

<br>\r
<table cellpadding='0' cellspacing='0' style='margin-left: auto; margin-right: auto; '>
<tr>\r
<td>\r <input type='text' name='M_MOTCLE[filtre]' size='25' maxlength='255' value='".$_REQUEST['M_MOTCLE']['filtre']."' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>\r
</td>\r
</tr>\r
</table>\r

<table cellpadding='0' cellspacing='0' style='margin-left: auto; margin-right: 0px; '>
<tr>\r
<td>\r
");
$_REQUEST['BS']['id']				= "bouton_filtrage";
$_REQUEST['BS']['type']				= "submit";
$_REQUEST['BS']['style_initial']	= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s2_n";
$_REQUEST['BS']['style_hover']		= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s2_h";
$_REQUEST['BS']['onclick']			= "";
$_REQUEST['BS']['message']			= $tl_[$l]['bouton1'];
$_REQUEST['BS']['mode']				= 1;
$_REQUEST['BS']['taille'] 			= 128;
$_REQUEST['BS']['derniere_taille']	= 0;
echo generation_bouton ();
echo ("<br>&nbsp;\r
</form>\r
</td>\r
</tr>\r

<tr>\r
<td>\r
<form ACTION='index.php?' method='post'>\r".
$bloc_html['post_hidden_sw'].
$bloc_html['post_hidden_l'].
$bloc_html['post_hidden_arti_ref']."
<input type='hidden' name='arti_page'						value='2'>\r
<input type='hidden' name='M_MOTCLE[uni_gestion_des_motcle_p]'	value='3'>\r".
$bloc_html['post_hidden_user_login'].
$bloc_html['post_hidden_user_pass']
);
$_REQUEST['BS']['id']				= "bouton_creation";
$_REQUEST['BS']['type']				= "submit";
$_REQUEST['BS']['style_initial']	= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s1_n";
$_REQUEST['BS']['style_hover']		= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s1_h";
$_REQUEST['BS']['onclick']			= "";
$_REQUEST['BS']['message']			= $tl_[$l]['bouton2'];
$_REQUEST['BS']['mode']				= 1;
$_REQUEST['BS']['taille'] 			= 0;
echo generation_bouton ();
echo ("
<br>&nbsp;\r
</td>\r
</tr>\r

</table>\r
<br>\r
</form>\r
");

if ( $site_web['sw_info_debug'] < 10 ) {
	unset (
		$dbp,
		$dbquery,
		$tl_,
		$trr
	);
}
/*Hydre-contenu_fin*/
?>
