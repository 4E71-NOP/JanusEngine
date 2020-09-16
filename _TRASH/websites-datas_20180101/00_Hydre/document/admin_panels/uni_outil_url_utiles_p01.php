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
$tl_['eng']['invite1'] = "JavaScript";				$tl_['fra']['invite1'] = "Liste d'URL utiles";

echo ( $tl_[$l]['invite1']."<br>\r<br>\r<br>\r");

$pv['collection']['JavaScript']['0']['nom']	= "JSFiddle";
$pv['collection']['JavaScript']['0']['url']	= "http://jsfiddle.net";
$pv['collection']['JavaScript']['1']['nom']	= "CodeBeautify";
$pv['collection']['JavaScript']['1']['url']	= "https://codebeautify.org/jsvalidate ";
$pv['collection']['JavaScript']['2']['nom']	= "JSLint";
$pv['collection']['JavaScript']['2']['url']	= "http://jslint.com/";
$pv['collection']['JavaScript']['3']['nom']	= "Esprima validate";
$pv['collection']['JavaScript']['3']['url']	= "http://esprima.org/demo/validate.html";
$pv['collection']['JavaScript']['4']['nom']	= "DevDocs";
$pv['collection']['JavaScript']['4']['url']	= "http://devdocs.io/javascript/";

$pv['collection']['CSS']['0']['nom']		= "CSS-Tricks";
$pv['collection']['CSS']['0']['url']		= "https://css-tricks.com/snippets/css/a-guide-to-flexbox/ ";
$pv['collection']['CSS']['1']['nom']		= "W3Schools";
$pv['collection']['CSS']['1']['url']		= "https://www.w3schools.com/cssref/pr_class_display.asp ";

$pv['collection']['Validation']['0']['nom']	= "JSONFormatter";
$pv['collection']['Validation']['0']['url']	= "https://jsonformatter.org/";
$pv['collection']['Validation']['1']['nom']	= "Regex101";
$pv['collection']['Validation']['1']['url']	= "https://regex101.com/";
$pv['collection']['Validation']['2']['nom']	= "W3";
$pv['collection']['Validation']['2']['url']	= "https://validator.w3.org/";

$pv['collection']['CSS']['0']['nom']		= "CanIUse";
$pv['collection']['CSS']['0']['url']		= "https://caniuse.com/";
$pv['collection']['CSS']['1']['nom']		= "Wikipedia Couleur du Web";
$pv['collection']['CSS']['1']['url']		= "https://fr.wikipedia.org/wiki/Couleur_du_Web";

$pv['collection']['Free']['0']['nom']		= "GoogleFonts";
$pv['collection']['Free']['0']['url']		= "https://fonts.google.com/";
$pv['collection']['Free']['1']['nom']		= "Lorem Ipsum";
$pv['collection']['Free']['1']['url']		= "https://fr.lipsum.com/";
$pv['collection']['Free']['2']['nom']		= "CSS Colors";
$pv['collection']['Free']['2']['url']		= "https://www.w3schools.com/cssref/css_colors.asp";

// --------------------------------------------------------------------------------------------
$o = 1;
unset ( $A );
foreach ( $pv['collection'] as $key => &$A ) {
	$i = 1;
	unset ( $B );
	foreach ( $A as $B ) {
		$AD[$o][$i]['1']['cont']	= "<a class='".$theme_tableau.$_REQUEST['bloc']."_lien' style='display:block;' target='_blank' href='".$B['url']."'>".$B['nom']."</a>";
		$AD[$o][$i]['1']['style']	= "padding:4px;";
		$i++;
	}
	$ADC['onglet'][$o]['nbr_ligne'] = ($i-1);	$ADC['onglet'][$o]['nbr_cellule'] = 1;	$ADC['onglet'][$o]['legende'] = 0;
	$o++;
}

$tl_['eng']['onglet_1'] = "JavaScript";				$tl_['fra']['onglet_1'] = "JavaScript";
$tl_['eng']['onglet_2'] = "CSS";					$tl_['fra']['onglet_2'] = "CSS";
$tl_['eng']['onglet_3'] = "Validation";				$tl_['fra']['onglet_3'] = "Validation";
$tl_['eng']['onglet_4'] = "Free stuff";				$tl_['fra']['onglet_4'] = "Gratuit";


$tab_infos['AffOnglet']			= 1;
$tab_infos['NbrOnglet']			= ($o-1);
$tab_infos['tab_comportement']	= 1;
$tab_infos['TypSurbrillance']	= 1; // 1:ligne, 2:cellule
$tab_infos['mode_rendu']		= 0;	// 0 echo 1 dans une variable
$tab_infos['doc_height']		= 256;
$tab_infos['doc_width']			= ${$theme_tableau}['theme_module_largeur_interne'];
$tab_infos['groupe']			= "gdd_grp1";
$tab_infos['cell_id']			= "tab";
$tab_infos['document']			= "doc";
$tab_infos['cell_1_txt']		= $tl_[$l]['onglet_1'];
$tab_infos['cell_2_txt']		= $tl_[$l]['onglet_2'];
$tab_infos['cell_3_txt']		= $tl_[$l]['onglet_3'];
$tab_infos['cell_4_txt']		= $tl_[$l]['onglet_4'];
include ("routines/website/affichage_donnees.php");

/*Hydre-contenu_fin*/
?>
