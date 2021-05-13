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
// Some definitions in order to ease the IDE work and to provide information about what is already available in this context.
/* @var $bts BaseToolSet                            */
/* @var $CurrentSetObj CurrentSet                   */
/* @var $ClassLoaderObj ClassLoader                 */

/* @var $SqlTableListObj SqlTableList               */
/* @var $UserObj User                               */
/* @var $WebSiteObj WebSite                         */
/* @var $DocumentDataObj DocumentData               */
/* @var $ThemeDataObj ThemeData                     */

/* @var $Content String                             */
/* @var $Block String                               */
/* @var $infos Array                                */
/* @var $l String                                   */
/*Hydre-IDE-end*/

// $LOG_TARGET = $LMObj->getInternalLogTarget();
// $LMObj->setInternalLogTarget("both");

$bts->RequestDataObj->setRequestDataEntry('script_source',"
add layout_content to_layout		'mwm_aqua_01_layout_par_defaut'		module_name		'blason'
line	'1'	calculus_type 	'STATIC'
				
position_x	'0'	position_y	'0'
dimenssion_x	'192'	dimenssion_y	'128'	minimum_x	'128'	minimum_y	'128'
spacing_border_left	'0'	spacing_border_right	'0'	spacing_border_top	'0'	spacing_border_bottom	'0'
module_zindex	'10';
");

/*Hydr-Content-Begin*/
$localisation = " / uni_toolset_cleanup_script_p01";
$bts->MapperObj->AddAnotherLevel($localisation );
$bts->LMObj->logCheckpoint("uni_toolset_cleanup_script_p01.php");
$bts->MapperObj->RemoveThisLevel($localisation );
$bts->MapperObj->setSqlApplicant("uni_toolset_cleanup_script_p01.php");

$bts->I18nTransObj->apply(
	array(
		"type" => "array",
		"fra" => array(
			"invite1"		=>	"Formatting tool for text copied from LibreOffice.",
			"btn1"			=>	"Convertir",
			"instruction"	=>	"Insérer le texte à convertir",
		),
		"eng" => array(
			"invite1"		=>	"Outil de formattage de texte issu de copi&eacute;/coll&eacute; depuis LibreOffice.",
			"btn1"			=>	"Convert",
			"instruction"	=>	"Insert here the text you want to convert",
		)
	)
);
$CurrentSetObj->getInstanceOfGeneratedJavaScriptObj()->insertJavaScript('File', 'engine/javascript/lib_HydrScriptFormatTool.js');

$Content .= $bts->I18nTransObj->getI18nTransEntry('Invite1').
"<br>\r
<form name='formConvert' ACTION='index.php?' method='post'>\r

<table ".$ThemeDataObj->getThemeDataEntry('tab_std_rules').">\r
<tr>\r
<td>\r
<textarea name='script_source' id='script_source' cols='".floor(($ThemeDataObj->getThemeDataEntry('theme_module_internal_width')/ $ThemeDataObj->getThemeBlockEntry($infos['blockT'], 'txt_fonte_size')) * 1.35 )."' rows='16'>
".$bts->RequestDataObj->getRequestDataEntry('script_source')."</textarea>\r
</td>\r
</tr>\r

<tr>\r
<td style='font-size: 8px;'>\r
<textarea name='script_resultat' id='script_resultat' cols='".floor(($ThemeDataObj->getThemeDataEntry('theme_module_internal_width')/ $ThemeDataObj->getThemeBlockEntry($infos['blockT'], 'txt_fonte_size')) * 1.35 )."' rows='16'>
".$pv['converti']."</textarea>\r
</td>\r
</tr>\r
";

$Content .= "</table>\r
<br>\r

<table ".$ThemeDataObj->getThemeDataEntry('tab_std_rules').">\r
<tr>\r
<td style='width:".($ThemeDataObj->getThemeDataEntry('theme_module_internal_width') - 192)."px;'>\r</td>\r
<td style='text-align: right;'>\r
";

$SB = array(
		"id"				=> "cleanButton",
		"type"				=> "button",
		"initialStyle"		=> $Block."_t3 ".$Block."_submit_s2_n",
		"hoverStyle"		=> $Block."_t3 ".$Block."_submit_s2_h",
		"onclick"			=> "FormattageScriptMWM ( 'formConvert' , 'script_source' , 'script_resultat' );",
		"message"			=> $bts->I18nTransObj->getI18nTransEntry('btn1'),
		"mode"				=> 1,
		"size" 				=> 128,
		"lastSize"			=> 0,
);

$Content .= $bts->InteractiveElementsObj->renderSubmitButton($SB);
$Content .= "
</td>\r
</tr>\r
</table>\r
</form>\r
";

/*Hydr-Content-End*/
?>
