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
$_REQUEST['script_source'] = "
add layout_content to_layout		'mwm_aqua_01_presentation_par_defaut'		module_name		'blason'			
line	'1'	calculus_type 	'STATIC'						
									
position_x	'0'	position_y	'0'						
dimenssion_x	'192'	dimenssion_y	'128'	minimum_x	'128'	minimum_y	'128'		
spacing_border_left	'0'	spacing_border_right	'0'	spacing_border_top	'0'	spacing_border_bottom	'0'		
module_zindex	'10'								
									
;
";

/*Hydre-contenu_debut*/
$_REQUEST['sql_initiateur'] = "uni_outil_conversion_type_p01.php";

$JavaScriptFichier[] = "routines/website/javascript_lib_outil_formattage_script_mwm.js";

$tl_['fra']['Invite1'] = "Outil de formattage de texte issu de copi&eacute;/coll&eacute; depuis LibreOffice.";
$tl_['eng']['Invite1'] = "Formatting tool for text copied from LibreOffice.";

$pv['ttrb'] = &${$theme_tableau}[$_REQUEST['blocT']];

echo (
$tl_[$l]['Invite1'].
"<br>\r
<form name='formulaire_CONV' ACTION='index.php?' method='post'>\r

<table ".${$theme_tableau}['tab_std_rules'].">\r
<tr>\r
<td>\r
<textarea name='script_source' id='script_source' cols='".floor((${$theme_tableau}['theme_module_largeur_interne'] / $pv['ttrb']['fonte_size_n3'] ) * 1.35 )."' rows='16' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>
".$_REQUEST['script_source']."</textarea>\r
</td>\r
</tr>\r

<tr>\r
<td style='font-size: 8px;'>\r
<textarea name='script_resultat' id='script_resultat' cols='".floor((${$theme_tableau}['theme_module_largeur_interne'] / $pv['ttrb']['fonte_size_n3'] ) * 1.35 )."' rows='16' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>
".$pv['converti']."</textarea>\r
</td>\r
</tr>\r
");

$tl_['eng']['bouton'] = "Convert";					$tl_['fra']['bouton'] = "Convertir";

echo ("</table>\r
<br>\r

<table ".${$theme_tableau}['tab_std_rules'].">\r
<tr>\r
<td style='width:".(${$theme_tableau}['theme_module_largeur_interne'] - 192)."px;'>\r</td>\r
<td style='text-align: right;'>\r
");
$_REQUEST['BS']['id']				= "bouton_soumission";
$_REQUEST['BS']['type']				= "button";
$_REQUEST['BS']['style_initial']	= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s2_n";
$_REQUEST['BS']['style_hover']		= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s2_h";
$_REQUEST['BS']['onclick']			= "FormattageScriptMWM ( 'formulaire_CONV' , 'script_source' , 'script_resultat' );";
$_REQUEST['BS']['message']			= $tl_[$l]['bouton'];
$_REQUEST['BS']['mode']				= 1;
$_REQUEST['BS']['taille'] 			= 128;
$_REQUEST['BS']['derniere_taille']	= 0;
echo generation_bouton ();

echo ("
</td>\r
</tr>\r
</table>\r
</form>\r
");

/*Hydre-contenu_fin*/
?>
