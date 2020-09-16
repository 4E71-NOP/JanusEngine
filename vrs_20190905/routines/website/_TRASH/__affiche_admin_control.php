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

$_REQUEST['sql_initiateur'] = "Affiche admin control";

$affiche_module_mode = "bypass";
$admin_control_['px'] = 0;
$admin_control_['py'] = 0;
$admin_control_['dx'] = 0;
$admin_control_['dy'] = 0;


foreach ( $module_tab_adm_ as $module_ ) {
	$pv['dimAdmModules'] += $pres_[$module_['module_nom']]['dx'];
}

$module_z_index['compteur'] = 1000;		//Contourne les Z-index venant de la présentation
echo ("
<div id='AdminControlSwitch'	
class ='".$theme_tableau."div_AdminControlSwitch'
style='visibility:visible; z-index:".$module_z_index['compteur'].";' 
onClick=\"CommuteAffichageCentre('AdminControlPanel'); DivRemplissageEcran ('AdminControlBG',1);\">
</div>\r

<div id='AdminControlBG' 
class ='".$theme_tableau."div_SelecteurDeFichierConteneur' 
style='display:none; visibility:hidden; z-index:".($module_z_index['compteur']+1).";' 
OnClick=\"CommuteAffichage('AdminControlPanel'); DivRemplissageEcran('AdminControlBG',0);\">\r
</div>\r

<div id='AdminControlPanel' 
class ='".$theme_tableau."div_AdminControlPanel' 
style='display:none; visibility:hidden; overflow:hidden; width:".($pv['dimAdmModules']+16)."px; background-color:#".${$theme_tableau}['theme_bg_color'].";  z-index:".($module_z_index['compteur']+2)."; padding:5px' 
>\r
");
$module_z_index['compteurSauv'] = $module_z_index['compteur'] += 2;
// Position:
// 0 	8	4
// 2	10	6
// 1	9	5
//if ( !isset ( ${$theme_tableau}['theme_admctrl_position'] ) ) {}

$JavaScriptOnload[] = "\tAdminSwitchPosition ( 'AdminControlSwitch', ".${$theme_tableau}['theme_admctrl_position'].", ".${$theme_tableau}['theme_admctrl_size_x'].", ".${$theme_tableau}['theme_admctrl_size_y'].");";
$GeneratedJavaScriptObj->insertJavaScript('Onload', "\tAdminSwitchPosition ( 'AdminControlSwitch', ".${$theme_tableau}['theme_admctrl_position'].", ".${$theme_tableau}['theme_admctrl_size_x'].", ".${$theme_tableau}['theme_admctrl_size_y'].");");

foreach ( $module_tab_adm_ as $module_ ) {
	$_REQUEST['module_nbr'] = 1;
	echo ("<!-- _______________________________________ Debut du module ".$mn." _______________________________________ -->\r");

	if ( $user['groupe'][$module_['module_groupe_pour_voir']] == 1 ) {
		if ( $module_['module_deco'] == 1 ) { 
			$pv['n'] = $module_['module_deco_nbr'];
			$_REQUEST['bloc']	= $pv['bloc']	= decoration_nomage_bloc ( "B", $pv['n'] , ""); 
			$_REQUEST['blocG']	= $pv['blocG']	= $_REQUEST['bloc'] . "G"; 
			$_REQUEST['blocT']	= $pv['blocT']	= $_REQUEST['bloc'] . "T"; 
		}
		else {
			$pv['bloc']	= "B00";
			$pv['blocG']	= "B00G";
			$pv['blocG']	= "B00T";
		}

		$mn = &$module_['module_nom'];
		$pres_[$mn]['pres_module_zindex'] = $module_z_index['compteur'] = $module_z_index['compteurSauv'];
		switch ( ${$theme_tableau}[$pv['blocG']]['deco_type'] ) {
		case 30:	case "1_div":		if ( !function_exists("module_deco_30_1_div") )		{ include ("module_deco_30_1_div.php"); }		module_deco_30_1_div ( $theme_tableau , "pres_" , "module_", 0 );		break;
		case 40:	case "elegance":	if ( !function_exists("module_deco_40_elegance") )	{ include ("module_deco_40_elegance.php"); }	module_deco_40_elegance ( $theme_tableau , "pres_" , "module_", 0 );	break;
		case 50:	case "exquise":		if ( !function_exists("module_deco_50_exquise") )	{ include ("module_deco_50_exquise.php"); }		module_deco_50_exquise ( $theme_tableau , "pres_" , "module_", 0 );		break;
		case 60:	case "elysion":		if ( !function_exists("module_deco_60_elysion") )	{ include ("module_deco_60_elysion.php"); }		module_deco_60_elysion ( $theme_tableau , "pres_" , "module_", 0 );		break;

		default:
			echo ("<div id='".$mn."' class='".$theme_tableau."s0".$module_['module_deco_nbr']."_div_std' style='position:absolute; left:".$pres_[$mn]['px']."px; top:".$pres_[$mn]['py']."px; width:".$pres_[$mn]['dx']."px; height:".$pres_[$mn]['dy']."px; '>\r"); 
		break;
		}

		if ( file_exists( $module_['module_fichier'] ) ) { include ( $module_['module_fichier'] ); }
		else { echo ("!! !! !! !!"); }
		echo ("</div>\r");	// fin du div 22
	}
	echo ("<!-- _______________________________________ Fin du module ".$mn." _______________________________________ -->\r\r\r\r\r");

	$pv['i']++;
	$admin_control_['px'] += $pres_[$mn]['dx'] + 4 ;
	$admin_control_['dx'] += $pres_[$mn]['dx'] ;
	$module_z_index['compteur'] =+ 2;
	if ( $pres_[$mn]['dy'] > $admin_control_['dy'] ) { $admin_control_['dy'] = $pres_[$mn]['dy'] ; }
}

echo ("
</div>\r
");

$JavaScriptInitCommandes[] = "RedimenssioneDiv ( 'AdminControlPanel' , ".$admin_control_['dx']." , ".$admin_control_['dy']." );";
$GeneratedJavaScriptObj->insertJavaScript('Command', "RedimenssioneDiv ( 'AdminControlPanel' , ".$admin_control_['dx']." , ".$admin_control_['dy']." );");

?>
