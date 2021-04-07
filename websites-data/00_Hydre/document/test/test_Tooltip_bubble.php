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

$_REQUEST['BS']['id']				= "bouton_suppression_log1";
$_REQUEST['BS']['type']				= "button";
$_REQUEST['BS']['style_initial']	= $theme_tableau.$_REQUEST['bloc']."_submit_s1_n";
$_REQUEST['BS']['style_hover']		= $theme_tableau.$_REQUEST['bloc']."_submit_s1_h";
$_REQUEST['BS']['onclick']			= "JSGeneralDebug=1; TabInfoModule.AideDynamique.DimConteneurX=128; TabInfoModule.AideDynamique.DimConteneurY=256; CalculeDecoModule ( TabInfoModule , 'AideDynamique' );";
$_REQUEST['BS']['message']			= "A";
$_REQUEST['BS']['mode']				= 1;
$_REQUEST['BS']['taille'] 			= 64;
$_REQUEST['BS']['derniere_taille']	= 0;
echo ( generation_bouton()."Taille = 128x256" );

echo ("<br>\r<br>\r<br>\r");

$_REQUEST['BS']['id']				= "bouton_suppression_log2";
$_REQUEST['BS']['type']				= "button";
$_REQUEST['BS']['style_initial']	= $theme_tableau.$_REQUEST['bloc']."_submit_s2_n";
$_REQUEST['BS']['style_hover']		= $theme_tableau.$_REQUEST['bloc']."_submit_s2_h";
$_REQUEST['BS']['onclick']			= "JSGeneralDebug=1; TabInfoModule.AideDynamique.DimConteneurX=256; TabInfoModule.AideDynamique.DimConteneurY=128; CalculeDecoModule ( TabInfoModule , 'AideDynamique' );";
$_REQUEST['BS']['message']			= "B";
$_REQUEST['BS']['mode']				= 1;
$_REQUEST['BS']['taille'] 			= 64;
$_REQUEST['BS']['derniere_taille']	= 0;
echo ( generation_bouton()."Taille = 256x128" );

$JavaScriptInitDonnees[] = "var AideDynamiqueDerogation = { 'Etat':1, 'X':196, 'Y':256 };\r";

?>
