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

$bts->RequestDataObj->setRequestData('CONV',
	array(
		'src'		=> 0,
		'dst'		=> 0,
		'cont'		=> "La petite fraülein dans la forêt de l'enchantée.<br>
&agrave;&aacute;&acirc;&atilde;&auml;&aring;&aelig;

aaa

"),
);

/*Hydre-contenu_debut*/
$localisation = " / uni_toolset_type_conversion_p01";
$bts->MapperObj->AddAnotherLevel($localisation );
$bts->LMObj->logCheckpoint("uni_toolset_type_conversion_p01.php");
$bts->MapperObj->RemoveThisLevel($localisation );
$bts->MapperObj->setSqlApplicant("uni_toolset_type_conversion_p01.php");

switch ($l) {
	case "fra":
		$bts->I18nObj->apply(array(
		"invite1"		=>	"Cette partie va vous permettre de gérer les themes.",
		"TypeTxt"		=>	"Texte",
		"TypeHtml"		=>	"HTML (héritage)",
		"TypeMixed"		=>	"Mixé",
		"TypePHP"		=>	"PHP",
		"TypeHydr"		=>	"Hydr",
		"btn1"			=>	"Convertir",
		"l1c1"			=>	"Depuis le type",
		"l1c2"			=>	"Convertir en",
		"instruction"	=>	"Insérer le texte à convertir",
		));
		break;
	case "eng":
		$bts->I18nObj->apply(array(
		"invite1"		=>	"This part will allow you to manage themes.",
		"TypeTxt"		=>	"Text",
		"TypeHtml"		=>	"HTML (old school)",
		"TypeMixed"		=>	"Mixed",
		"TypePHP"		=>	"PHP",
		"TypeHydr"		=>	"Hydr",
		"btn1"			=>	"Convert",
		"l1c1"			=>	"From type",
		"l1c2"			=>	"Convert to",
		"instruction"	=>	"Insert here the text you want to convert",
		));
		break;
}
$bts->GeneratedJavaScriptObj->insertJavaScript('File', 'engine/javascript/lib_ConvertTool.js');

// --------------------------------------------------------------------------------------------
// Preparation des tables
// --------------------------------------------------------------------------------------------
// $pv['ttrb'] = &${$theme_tableau}[$infos['blockT']];

$select_type = array();
$select_type['0']['t'] = $bts->I18nObj->getI18nEntry('TypeTxt');	$select_type['0']['s'] = "";	$select_type['0']['db'] = "0";
$select_type['1']['t'] = $bts->I18nObj->getI18nEntry('TypeHtml');	$select_type['1']['s'] = "";	$select_type['1']['db'] = "1";
$select_type['2']['t'] = $bts->I18nObj->getI18nEntry('TypeMixed');	$select_type['2']['s'] = "";	$select_type['2']['db'] = "2";
$select_type['3']['t'] = $bts->I18nObj->getI18nEntry('TypePHP');	$select_type['3']['s'] = "";	$select_type['3']['db'] = "3";
$select_type['4']['t'] = $bts->I18nObj->getI18nEntry('TypeHydr');	$select_type['4']['s'] = "";	$select_type['4']['db'] = "4";

foreach ( $select_type as $A ) { $pv['select_option'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$pv['select_option'] .= "</select>\r";

$Content .= "
<form name='ConvForm' ACTION='index.php?' method='post'>\r

<table ".$ThemeDataObj->getThemeDataEntry('tab_std_rules').">\r

<tr>\r
<td class='".$Block."_tb4 ".$Block."_fcta' style='text-align: center;'>\r".$bts->I18nObj->getI18nEntry('l1c1')."</td>\r
<td class='".$Block."_tb4 ".$Block."_fcta' style='text-align: center;'>\r".$bts->I18nObj->getI18nEntry('l1c2')."</td>\r
</tr>\r

<tr>\r
<td class='".$Block."_fca' style='width:".floor($ThemeDataObj->getThemeDataEntry('theme_module_largeur_interne')/2)."px; text-align: center;'>\r
<select name='conv_type_src' class='".$Block."_t3 " . $Block . "_form_1'>\r".$pv['select_option']."
</td>\r

<td class='".$Block."_fca' style='width:".floor($ThemeDataObj->getThemeDataEntry('theme_module_largeur_interne')/2)."px; text-align: center;'>\r
<select name='conv_type_dst' class='" . $Block."_t3 " . $Block . "_form_1'>\r".$pv['select_option']."
</td>\r
</tr>\r

<tr>\r
<td class='".$Block."_fcb' colspan='2' style='text-align: center;'>\r
".$bts->I18nObj->getI18nEntry('instruction')."<br>\r
<textarea name='conv_src' id='conv_src' cols='".floor(($ThemeDataObj->getThemeDataEntry('theme_module_largeur_interne')/$ThemeDataObj->getThemeBlockEntry($infos['blockT'], 'fonte_size_n3')) * 1.35 )."' rows='5' class='" . $Block."_t3 " . $Block."_form_1'>
".$bts->RequestDataObj->getRequestDataSubEntry('CONV', 'cont')."
</textarea>
</td>\r
</tr>\r

<tr>\r
<td class='".$Block."_fcb' colspan='2' style='text-align: center;'>\r
<textarea name='conv_dst' id='conv_dst' cols='".floor(($ThemeDataObj->getThemeDataEntry('theme_module_largeur_interne')/$ThemeDataObj->getThemeBlockEntry($infos['blockT'],'fonte_size_n3') * 1.35 ))."' rows='5' class='" . $Block."_t3 " . $Block."_form_1'>
".
$bts->RequestDataObj->getRequestDataSubEntry('CONV', 'converti').
"</textarea>

</td>\r
</tr>\r

</table>\r

<br>\r
<table ".$ThemeDataObj->getThemeDataEntry('tab_std_rules').">\r
<tr>\r
<td style='width:".($ThemeDataObj->getThemeDataEntry('theme_module_largeur_interne') - 192)."px;'>\r</td>\r
<td style='text-align: right;'>\r
";

$SB = array(
		"id"				=> "modifyButton",
		"type"				=> "button",
		"initialStyle"		=> $Block."_t3 ".$Block."_submit_s2_n",
		"hoverStyle"		=> $Block."_t3 ".$Block."_submit_s2_h",
		"onclick"			=> "ConversionType ('ConvForm', 'conv_src', 'conv_dst', 'conv_type_src', 'conv_type_dst');",
		"message"			=> $bts->I18nObj->getI18nEntry('btn1'),
		"mode"				=> 1,
		"size" 				=> 96,
		"lastSize"			=> 0,
);
$Content .= $bts->InteractiveElementsObj->renderSubmitButton($SB);

$Content .= "
</td>\r
</tr>\r
</table>\r
</form>\r
";

/*Hydre-contenu_fin*/
?>
