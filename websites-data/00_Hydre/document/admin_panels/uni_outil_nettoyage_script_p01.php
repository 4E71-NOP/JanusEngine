<?php
/*Hydre-licence-begin*/
// --------------------------------------------------------------------------------------------
//
//	Hydre - Le petit moteur de web
//	licence Creative Common licence, CC-by-nc-sa (http://creativecommons.org)
//	Author : Faust MARIA DE AREVALO, mailto:faust@rootwave.net
//
// --------------------------------------------------------------------------------------------
/*Hydre-licence-fin*/

/*Hydre-IDE-begin*/
// Some definitions in order to ease the IDE work.
/* @var $AdminFormToolObj AdminFormTool             */
/* @var $CMObj ConfigurationManagement              */
/* @var $ClassLoaderObj ClassLoader                 */
/* @var $LMObj LogManagement                        */
/* @var $MapperObj Mapper                           */
/* @var $I18nObj I18n                               */
/* @var $InteractiveElementsObj InteractiveElements */
/* @var $RenderTablesObj RenderTables               */
/* @var $RequestDataObj RequestData                 */
/* @var $SDDMObj DalFacade                          */
/* @var $SqlTableListObj SqlTableList               */
/* @var $StringFormatObj StringFormat               */
/* @var $TimeObj Time                               */

/* @var $CurrentSetObj CurrentSet                   */
/* @var $DocumentDataObj DocumentData               */
/* @var $RenderLayoutObj RenderLayout               */
/* @var $ThemeDataObj ThemeData                     */
/* @var $UserObj User                               */
/* @var $WebSiteObj WebSite                         */

/* @var $Block String                               */
/* @var $infos array                                */
/* @var $l String                                   */
/*Hydre-IDE-end*/

$logTarget = $LMObj->getInternalLogTarget();
$LMObj->setInternalLogTarget("both");

$RequestDataObj->setRequestDataEntry('script_source',"
add layout_content to_layout		'mwm_aqua_01_presentation_par_defaut'		module_name		'blason'
line	'1'	calculus_type 	'STATIC'
				
position_x	'0'	position_y	'0'
dimenssion_x	'192'	dimenssion_y	'128'	minimum_x	'128'	minimum_y	'128'
spacing_border_left	'0'	spacing_border_right	'0'	spacing_border_top	'0'	spacing_border_bottom	'0'
module_zindex	'10';
");

/*Hydre-contenu_debut*/
$localisation = " / uni_outil_conversion_type_p01";
$MapperObj->AddAnotherLevel($localisation );
$LMObj->logCheckpoint("uni_outil_conversion_type_p01");
$MapperObj->RemoveThisLevel($localisation );
$MapperObj->setSqlApplicant("uni_outil_conversion_type_p01");

switch ($l) {
	case "fra":
		$I18nObj->apply(array(
		"invite1"		=>	"Formatting tool for text copied from LibreOffice.",
		"btn1"			=>	"Convertir",
		"instruction"	=>	"Insérer le texte à convertir",
		));
		break;
	case "eng":
		$I18nObj->apply(array(
		"invite1"		=>	"Outil de formattage de texte issu de copi&eacute;/coll&eacute; depuis LibreOffice.",
		"btn1"			=>	"Convert",
		"instruction"	=>	"Insert here the text you want to convert",
		));
		break;
}
$GeneratedJavaScriptObj->insertJavaScript('File', 'routines/website/javascript/lib_HydrScriptFormatTool.js');

$Content .= $I18nObj->getI18nEntry('Invite1').
"<br>\r
<form name='formConvert' ACTION='index.php?' method='post'>\r

<table ".$ThemeDataObj->getThemeDataEntry('tab_std_rules').">\r
<tr>\r
<td>\r
<textarea name='script_source' id='script_source' cols='".floor(($ThemeDataObj->getThemeDataEntry('theme_module_largeur_interne')/ $ThemeDataObj->getThemeDataEntry('fonte_size_n3') ) * 1.35 )."' rows='16' class='".$Block."_t3 ".$Block."_form_1'>
".$RequestDataObj->getRequestDataEntry('script_source')."</textarea>\r
</td>\r
</tr>\r

<tr>\r
<td style='font-size: 8px;'>\r
<textarea name='script_resultat' id='script_resultat' cols='".floor(($ThemeDataObj->getThemeDataEntry('theme_module_largeur_interne')/ $ThemeDataObj->getThemeDataEntry('fonte_size_n3') ) * 1.35 )."' rows='16' class='".$Block."_t3 ".$Block."_form_1'>
".$pv['converti']."</textarea>\r
</td>\r
</tr>\r
";

$Content .= "</table>\r
<br>\r

<table ".$ThemeDataObj->getThemeDataEntry('tab_std_rules').">\r
<tr>\r
<td style='width:".($ThemeDataObj->getThemeDataEntry('theme_module_largeur_interne') - 192)."px;'>\r</td>\r
<td style='text-align: right;'>\r
";

$SB = array(
		"id"				=> "cleanButton",
		"type"				=> "button",
		"initialStyle"		=> $Block."_t3 ".$Block."_submit_s2_n",
		"hoverStyle"		=> $Block."_t3 ".$Block."_submit_s2_h",
		"onclick"			=> "FormattageScriptMWM ( 'formConvert' , 'script_source' , 'script_resultat' );",
		"message"			=> $I18nObj->getI18nEntry('btn1'),
		"mode"				=> 1,
		"size" 				=> 128,
		"lastSize"			=> 0,
);

$Content .= $InteractiveElementsObj->renderSubmitButton($SB);
$Content .= "
</td>\r
</tr>\r
</table>\r
</form>\r
";

/*Hydre-contenu_fin*/
?>
