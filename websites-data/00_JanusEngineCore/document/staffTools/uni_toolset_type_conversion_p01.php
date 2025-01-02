<?php
/*JanusEngine-license-start*/
// --------------------------------------------------------------------------------------------
//
//	Janus Engine - Le petit moteur de web
//	licence Creative Common licence, CC-by-nc-sa (http://creativecommons.org)
//	Author : Faust MARIA DE AREVALO, mailto:faust@rootwave.net
//
// --------------------------------------------------------------------------------------------
/*JanusEngine-license-end*/

/*JanusEngine-IDE-begin*/
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
/*JanusEngine-IDE-end*/

$bts->RequestDataObj->setRequestData('CONV',
	array(
		'src'		=> 0,
		'dst'		=> 0,
		'cont'		=> "La petite fraülein dans la forêt de l'enchantée.<br>
&agrave;&aacute;&acirc;&atilde;&auml;&aring;&aelig;

aaa

"),
);

/*JanusEngine-Content-Begin*/
$bts->mapSegmentLocation(__METHOD__, "uni_toolset_type_conversion_p01");

$bts->I18nTransObj->apply(
	array(
		"type" => "array",
		"fra" => array(
			"invite1"		=>	"Cette partie va vous permettre de gérer les themes.",
			"TypeTxt"		=>	"Texte",
			"TypeHtml"		=>	"HTML (héritage)",
			"TypeMixed"		=>	"Mixé",
			"TypePHP"		=>	"PHP",
			"TypeJnsEng"	=>	"Janus Engine",
			"btn1"			=>	"Convertir",
			"l1c1"			=>	"Depuis le type",
			"l1c2"			=>	"Convertir en",
			"instruction"	=>	"Insérer le texte à convertir",
		),
		"eng" => array(
			"invite1"		=>	"This part will allow you to manage themes.",
			"TypeTxt"		=>	"Text",
			"TypeHtml"		=>	"HTML (old school)",
			"TypeMixed"		=>	"Mixed",
			"TypePHP"		=>	"PHP",
			"TypeJnsEng"	=>	"Janus Engine",
			"btn1"			=>	"Convert",
			"l1c1"			=>	"From type",
			"l1c2"			=>	"Convert to",
			"instruction"	=>	"Insert here the text you want to convert",
		)
	)
);

$CurrentSetObj->GeneratedScriptObj->insertString('JavaScript-File', 'engine/javascript/lib_ConvertTool.js');

// --------------------------------------------------------------------------------------------
// Preparation des tables
// --------------------------------------------------------------------------------------------

$select_type = array();
$select_type['0']['t'] = $bts->I18nTransObj->getI18nTransEntry('TypeTxt');		$select_type['0']['s'] = "";	$select_type['0']['db'] = "0";
$select_type['1']['t'] = $bts->I18nTransObj->getI18nTransEntry('TypeHtml');		$select_type['1']['s'] = "";	$select_type['1']['db'] = "1";
$select_type['2']['t'] = $bts->I18nTransObj->getI18nTransEntry('TypeMixed');	$select_type['2']['s'] = "";	$select_type['2']['db'] = "2";
$select_type['3']['t'] = $bts->I18nTransObj->getI18nTransEntry('TypePHP');		$select_type['3']['s'] = "";	$select_type['3']['db'] = "3";
$select_type['4']['t'] = $bts->I18nTransObj->getI18nTransEntry('TypeJnsEng');	$select_type['4']['s'] = "";	$select_type['4']['db'] = "4";

foreach ( $select_type as $A ) { $pv['select_option'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$pv['select_option'] .= "</select>\r";

$Content .= "
<form name='ConvForm' ACTION='index.php?' method='post'>\r

<table class='".$Block."_TableStd' style='text-align:center;'>\r

<tr>\r
<td style='text-align: center;'>\r".$bts->I18nTransObj->getI18nTransEntry('l1c1')."</td>\r
<td style='text-align: center;'>\r".$bts->I18nTransObj->getI18nTransEntry('l1c2')."</td>\r
</tr>\r

<tr>\r
<td style='width:50%; text-align: center;'>\r
<select name='conv_type_src' class='".$Block."_form_1'>\r".$pv['select_option']."
</td>\r

<td style='width:50%; text-align: center;'>\r
<select name='conv_type_dst' class='".$Block."_form_1'>\r".$pv['select_option']."
</td>\r
</tr>\r

<tr>\r
<td colspan='2' style='text-align: center;'>\r
".$bts->I18nTransObj->getI18nTransEntry('instruction')."<br>\r
<textarea name='conv_src' id='conv_src' style='width:100%' rows='5'>
".$bts->RequestDataObj->getRequestDataSubEntry('CONV', 'cont')."
</textarea>
</td>\r
</tr>\r

<tr>\r
<td colspan='2' style='text-align: center;'>\r
<textarea name='conv_dst' id='conv_dst' style='width:100%' rows='5'>
".
$bts->RequestDataObj->getRequestDataSubEntry('CONV', 'converti').
"</textarea>

</td>\r
</tr>\r

</table>\r

<br>\r
<table class='".$Block."_TableStd' style='text-align:center;'>\r
<tr>\r
<td style='width:70%'>\r</td>\r
<td style='text-align: right;'>\r
";


$SB = $bts->InteractiveElementsObj->getDefaultSubmitButtonConfig(
	$infos , 'button', 
	$bts->I18nTransObj->getI18nTransEntry('btn1'), 96, 
	'modifyButton', 
	2, 2, 
	"ConversionType ('ConvForm', 'conv_src', 'conv_dst', 'conv_type_src', 'conv_type_dst');" 
);
$Content .= $bts->InteractiveElementsObj->renderSubmitButton($SB);

$Content .= "
</td>\r
</tr>\r
</table>\r
</form>\r
";

$bts->segmentEnding(__METHOD__);
/*JanusEngine-Content-End*/
?>
