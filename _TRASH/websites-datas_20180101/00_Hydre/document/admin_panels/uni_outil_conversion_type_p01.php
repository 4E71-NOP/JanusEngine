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
//$_REQUEST['CONV']['Go'] = 1;
//<imput type='hidden' name='CONV[Go]' value='1'>

$_REQUEST['CONV']['src'] = 0;
$_REQUEST['CONV']['dst'] = 1;
$_REQUEST['CONV']['cont'] = "La petite fraülein dans la forêt de l'enchantée.<br>
&agrave;&aacute;&acirc;&atilde;&auml;&aring;&aelig;

aaa

";

/*Hydre-contenu_debut*/
$_REQUEST['sql_initiateur'] = "uni_outil_nettoyage_script_p01.php";

$JavaScriptFichier[] = "routines/website/javascript_lib_outil_conversion.js";

// --------------------------------------------------------------------------------------------
// Preparation des tables
// --------------------------------------------------------------------------------------------
$pv['ttrb'] = &${$theme_tableau}[$_REQUEST['blocT']];
$tl_['eng']['bouton'] = "Convert";					$tl_['fra']['bouton'] = "Convertir";

$tl_['eng']['txt'] = "Text";		$tl_['fra']['txt'] = "Texte";
$tl_['eng']['html'] = "HTML";		$tl_['fra']['html'] = "HTML";
$tl_['eng']['mixed'] = "Mixed";		$tl_['fra']['mixed'] = "Mix&eacute;";
$tl_['eng']['php'] = "PHP";			$tl_['fra']['php'] = "PHP";
$tl_['eng']['mwm'] = "MWM";			$tl_['fra']['mwm'] = "MWM";

$select_type['0']['t'] = $tl_[$l]['txt'];	$select_type['0']['s'] = "";	$select_type['0']['db'] = "0";
$select_type['1']['t'] = $tl_[$l]['html'];	$select_type['1']['s'] = "";	$select_type['1']['db'] = "1";
$select_type['2']['t'] = $tl_[$l]['mixed'];	$select_type['2']['s'] = "";	$select_type['2']['db'] = "2";
$select_type['3']['t'] = $tl_[$l]['php'];	$select_type['3']['s'] = "";	$select_type['3']['db'] = "3";
$select_type['4']['t'] = $tl_[$l]['mwm'];	$select_type['4']['s'] = "";	$select_type['4']['db'] = "4";

foreach ( $select_type as $A ) { $pv['select_option'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$pv['select_option'] .= "</select>\r";

$tl_['eng']['l1c1'] = "From type";	$tl_['fra']['l1c1'] = "Depuis le type";
$tl_['eng']['l1c2'] = "Convert to";	$tl_['fra']['l1c2'] = "Convertir en";

$pv['eng']['instruction'] = "Insert here the text you want to convert";
$pv['fra']['instruction'] = "Ins&eacute;rez ici le texte &agrave; convertir";

echo ("
<form name='formulaire_CONV' ACTION='index.php?' method='post'>\r

<table ".${$theme_tableau}['tab_std_rules'].">\r

<tr>\r
<td class='".$theme_tableau.$_REQUEST['bloc']."_tb4 ".$theme_tableau.$_REQUEST['bloc']."_fcta' style='text-align: center;'>\r".$tl_[$l]['l1c1']."</td>\r
<td class='".$theme_tableau.$_REQUEST['bloc']."_tb4 ".$theme_tableau.$_REQUEST['bloc']."_fcta' style='text-align: center;'>\r".$tl_[$l]['l1c2']."</td>\r
</tr>\r

<tr>\r
<td class='".$theme_tableau.$_REQUEST['bloc']."_fca' style='width:".floor(${$theme_tableau}['theme_module_largeur_interne']/2)."px; text-align: center;'>\r
<select name='conv_type_src' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau.$_REQUEST['bloc'] . "_form_1'>\r".$pv['select_option']."
</td>\r

<td class='".$theme_tableau.$_REQUEST['bloc']."_fca' style='width:".floor(${$theme_tableau}['theme_module_largeur_interne']/2)."px; text-align: center;'>\r
<select name='conv_type_dst' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau.$_REQUEST['bloc'] . "_form_1'>\r".$pv['select_option']."
</td>\r
</tr>\r

<tr>\r
<td class='".$theme_tableau.$_REQUEST['bloc']."_fcb' colspan='2' style='text-align: center;'>\r
".$pv[$l]['instruction']."<br>\r
<textarea name='conv_src' id='conv_src' cols='".floor((${$theme_tableau}['theme_module_largeur_interne'] / $pv['ttrb']['fonte_size_n3'] ) * 1.35 )."' rows='5' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>
".$_REQUEST['CONV']['cont']."
</textarea>
</td>\r
</tr>\r

<tr>\r
<td class='".$theme_tableau.$_REQUEST['bloc']."_fcb' colspan='2' style='text-align: center;'>\r
<textarea name='conv_dst' id='conv_dst' cols='".floor((${$theme_tableau}['theme_module_largeur_interne'] / $pv['ttrb']['fonte_size_n3'] ) * 1.35 )."' rows='5' class='" . $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_form_1'>
".
$_REQUEST['CONV']['converti'].
"</textarea>

</td>\r
</tr>\r

</table>\r

<br>\r
<table ".${$theme_tableau}['tab_std_rules'].">\r
<tr>\r
<td style='width:".(${$theme_tableau}['theme_module_largeur_interne'] - 192)."px;'>\r</td>\r
<td style='text-align: right;'>\r
");
$_REQUEST['BS']['id']				= "bouton_modification";
$_REQUEST['BS']['type']				= "button";
$_REQUEST['BS']['style_initial']	= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s2_n";
$_REQUEST['BS']['style_hover']		= $theme_tableau . $_REQUEST['bloc']."_t3 " . $theme_tableau . $_REQUEST['bloc']."_submit_s2_h";
$_REQUEST['BS']['onclick']			= "ConversionType( 'formulaire_CONV', 'conv_src', 'conv_dst', 'conv_type_src', 'conv_type_dst' );";
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
