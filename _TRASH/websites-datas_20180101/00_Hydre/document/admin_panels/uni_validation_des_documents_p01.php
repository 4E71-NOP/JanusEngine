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
//	2008 04 21 : uni_correction_des_documents_p01.php debut
//	2008 04 21 : Derniere modification
// --------------------------------------------------------------------------------------------
/*Hydre-contenu_debut*/
$_REQUEST['sql_initiateur'] = "uni_correction_des_documents_p01.php";

// docu_modif					WMCODE 0	NOCODE 1	PHP 2	MIXED 3
$tl_['eng']['type0'] = "MWM code";			$tl_['eng']['type1'] = "No code";			$tl_['eng']['type2'] = "PHP";			$tl_['eng']['type3'] = "Mixed";
$tl_['fra']['type0'] = "Code MWM";		$tl_['fra']['type1'] = "Pas de code";	$tl_['fra']['type2'] = "PHP";		$tl_['fra']['type3'] = "Mix&eacute;";

$tl_['eng']['modif0'] = "No";				$tl_['eng']['modif1'] = "Yes";
$tl_['fra']['modif0'] = "Non";			$tl_['fra']['modif1'] = "Oui";

// --------------------------------------------------------------------------------------------

$tl_['txt']['eng']['invite1'] = "This part will allow you to modify documents.";
$tl_['txt']['fra']['invite1'] = "Cette partie va vous permettre de modifier les documents.";

$tl_['txt']['eng']['col_1_txt'] = "Name";				$tl_['txt']['fra']['col_1_txt'] = "Nom";
$tl_['txt']['eng']['col_2_txt'] = "Type";				$tl_['txt']['fra']['col_2_txt'] = "Type";
$tl_['txt']['eng']['col_3_txt'] = "Can be modified";	$tl_['txt']['fra']['col_3_txt'] = "Modifiable?";

$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
SELECT doc.docu_id,doc.docu_nom,doc.docu_type,part.part_modification 
FROM ".$SQL_tab_abrege['document']." doc, ".$SQL_tab_abrege['document_partage']." part 
WHERE part.site_id = '".$site_web['sw_id']."' 
AND part.docu_id = doc.docu_id 
AND doc.docu_correction = '0' 
AND doc.docu_origine = '".$site_web['sw_id']."' 
;");

$tab_modif['0'] = $tl_[$l]['modif0'];	$tab_modif['1'] = $tl_[$l]['modif1'];	
$tab_type['0'] = $tl_[$l]['type0'];	$tab_type['1'] = $tl_[$l]['type1'];	$tab_type['2'] = $tl_[$l]['type2'];	$tab_type['3'] = $tl_[$l]['type3'];

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
		$AD['1'][$i]['1']['cont']	= "<a class='" . $theme_tableau . $_REQUEST['bloc']."_lien " . $theme_tableau . $_REQUEST['bloc']."_t1' href='index.php?&amp;M_DOCUME[document_selection]=".$dbp['docu_id'].$bloc_html['url_sldup']."&amp;arti_page=2' onMouseOver = \"window.status = 'Execution du script'; return true;\"  onMouseOut=\"window.status = '".$site_web['sw_barre_status']."'; return true;\" >".$dbp['docu_nom']."</a>";
		$AD['1'][$i]['2']['cont']	= $tab_type[$dbp['docu_type']];
		$AD['1'][$i]['3']['cont']	= $tab_modif[$dbp['part_modification']];
	}
}

$ADC['onglet']['1']['nbr_ligne'] = $i;	$ADC['onglet']['1']['nbr_cellule'] = 3;	$ADC['onglet']['1']['legende'] = 1;
$tl_['eng']['onglet_1'] = "Informations";	$tl_['fra']['onglet_1'] = "Informations";

$tab_infos['AffOnglet']			= 1;
$tab_infos['NbrOnglet']			= 1;
$tab_infos['tab_comportement']	= 0;
$tab_infos['TypSurbrillance']	= 1; // 1:ligne, 2:cellule
$tab_infos['mode_rendu']		= 0;	// 0 echo 1 dans une variable
$tab_infos['doc_height']		= 256;
$tab_infos['doc_width']			= ${$theme_tableau}['theme_module_largeur_interne'];
$tab_infos['groupe']			= "edc_grp1";
$tab_infos['cell_id']			= "tab";
$tab_infos['document']			= "doc";
$tab_infos['cell_1_txt']		= $tl_[$l]['onglet_1'];
include ("routines/website/affichage_donnees.php");

// --------------------------------------------------------------------------------------------

$tl_['eng']['bouton1'] = "Create a document";
$tl_['fra']['bouton1'] = "Cr&eacute;er un document";

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
<input type='hidden' name='arti_page'	value='2'>\r".
$bloc_html['post_hidden_user_login'].
$bloc_html['post_hidden_user_pass']);

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
