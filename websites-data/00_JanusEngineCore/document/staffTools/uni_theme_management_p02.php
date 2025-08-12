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

$bts->RequestDataObj->setRequestData(
	'themeForm',
	array(
		'selectionId'	=>	2056201610955903802,
	)
);
$bts->RequestDataObj->setRequestData(
	'formGenericData',
	array(
		'origin'		=> 'AdminDashboard',
		'section'		=> 'AdminThemeManagementP02',
		'creation'		=> 'on',
		'modification'	=> 'on',
		'deletion'		=> 'on',
		'mode'			=> 'edit',
		//				'mode'			=> 'create',
		//				'mode'			=> 'delete',
	)
);
$bts->CMObj->setConfigurationEntry('colorSelector', 'system');		//"or Janus Engine"


/*JanusEngine-Content-Begin*/
$bts->mapSegmentLocation(__METHOD__, "uni_theme_management_p02");

$bts->I18nTransObj->apply(
	array(
		"type" => "array",
		"fra" => array(
			"acpUp"			=>	"Haut",
			"acpDown"		=>	"Bas",
			"acpLeft"		=>	"Gauche",
			"acpRight"		=>	"Droite",
			"acpMiddle"		=>	"Milieu",

			"invite1"		=> "Cette partie va vous permettre de gérer le thème.",
			"invite2"		=> "Cette partie va vous permettre de créer un thème.",
			"tabTxt1"		=> "Général",
			"tabTxt2"		=> "Block 1-15",
			"tabTxt3"		=> "Block 16-30",
			"tabTxt4"		=> "Menu 0-9",
			"tabTxt5"		=> "Config",
			"tabTxt6"		=> "Admin",

			"t1l1c1"		=>	"ID",
			"t1l2c1"		=>	"Nom",
			"t1l3c1"		=>	"Titre",
			"t1l4c1"		=>	"Description",
			"t1l5c1"		=>	"Répertoire",

			"t2lxc1"		=>	"Bloc",

			"t5l1c1"		=>	"Répertoire",
			"t5l2c1"		=>	"Feuille de style",
			"t5l7c1"		=>	"Fond",
			"t5l8c1"		=>	"Image de fond",
			"t5l9c1"		=>	"Répetition image",
			"t5l10c1"		=>	"Couleur de fond",
			"t5l11c1"		=>	"Div initial",
			"t5l12c1"		=>	"Image de fond",
			"t5l13c1"		=>	"Répetition image",
			"t5l14c1"		=>	"Dimenssion X",
			"t5l15c1"		=>	"Dimenssion Y",
			"t5l16c1"		=>	"Divers",
			"t5l17c1"		=>	"Logo",
			"t5l18c1"		=>	"Banniere",

			"t6l1c1"		=>	"Fond du panneau d'administration<span class='" . $Block . "_avert'>(1)</span>",
			"t6l2c1"		=>	"Bouton<span class='" . $Block . "_avert'>(1)</span>",
			"t6l3c1"		=>	"Dimenssion X/Y",
			"t6l4c1"		=>	"Position",
			"t6l5c1"		=>	"Fondu de la jauge D&eacute;but / Fin",
			"t6l6c1"		=>	"<span class='" . $Block . "_avert'>(1)</span>Ne laissez que le nom de fichier dans la case.",

			"t1l2c2"		=>	"New_theme",

		),
		"eng" => array(
			"acpUp"			=>	"Up",
			"acpDown"		=>	"Down",
			"acpLeft"		=>	"Left",
			"acpRight"		=>	"Right",
			"acpMiddle"		=>	"Middle",

			"invite1"		=> "This part will allow you to manage this theme.",
			"invite2"		=> "This part will allow you to create a theme.",
			"tabTxt1"		=> "General",
			"tabTxt2"		=> "Block 1-15",
			"tabTxt3"		=> "Block 16-30",
			"tabTxt4"		=> "Menu 0-9",
			"tabTxt5"		=> "Config",
			"tabTxt6"		=> "Admin",
			"raf1"			=> "Nothing to display",

			"t1l1c1"		=>	"ID",
			"t1l2c1"		=>	"Name",
			"t1l3c1"		=>	"Title",
			"t1l4c1"		=>	"Description",
			"t1l5c1"		=>	"Directory",

			"t2lxc1"		=>	"Block",

			"t5l1c1"		=>	"Directory",
			"t5l2c1"		=>	"StyleSheet",
			"t5l7c1"		=>	"Background",
			"t5l8c1"		=>	"Background image",
			"t5l9c1"		=>	"Image repetition",
			"t5l10c1"		=>	"Background color",
			"t5l11c1"		=>	"Div initial",
			"t5l12c1"		=>	"Background image",
			"t5l13c1"		=>	"Image repetition",
			"t5l14c1"		=>	"Dimenssion X",
			"t5l15c1"		=>	"Dimenssion Y",
			"t5l16c1"		=>	"Miscellaneous",
			"t5l17c1"		=>	"Logo",
			"t5l18c1"		=>	"Banner",

			"t6l1c1"		=>	"Admin panel background<span class='" . $Block . "_avert'>(1)</span>",
			"t6l2c1"		=>	"Switch<span class='" . $Block . "_avert'>(1)</span>",
			"t6l3c1"		=>	"Size X/Y",
			"t6l4c1"		=>	"Position",
			"t6l5c1"		=>	"Gauge blend Begin / End",
			"t6l6c1"		=>	"<span class='" . $Block . "_avert'>(1)</span>Leave only the filename.",

			"t1l2c2"		=>	"New_theme",
		),
	)
);

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('AdminFormTool');
$AdminFormToolObj = AdminFormTool::getInstance();
$Content .= $AdminFormToolObj->checkAdminDashboardForm($infos);

// --------------------------------------------------------------------------------------------
// Table preparation
// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('ThemeDescriptor');
$tmpThemeObj = new ThemeDescriptor();
$targetThemeData = new ThemeData();

switch ($bts->RequestDataObj->getRequestDataSubEntry('formGenericData', 'mode')) {
	case "edit":
		$commandType = "update";
		$tmpThemeObj->getDataFromDB($bts->RequestDataObj->getRequestDataSubEntry('themeForm', 'selectionId'));
		$targetThemeData->setThemeData($tmpThemeObj->getThemeDescriptor());
		$targetThemeData->setThemeDefinition($tmpThemeObj->getThemeDefinition());

		$t1l2c2 = $targetThemeData->getThemeDataEntry('theme_name');
		// $t1l2c2 = $bts->RenderFormObj->renderInputText('formParams1[name]',	$targetThemeData->getThemeDataEntry('theme_name'));

		$Content .= "<p>" . $bts->I18nTransObj->getI18nTransEntry('invite1') . "</p>\r";
		$processStep = "";
		$processTarget = "edit";

		$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : ThemeData = `" . $bts->StringFormatObj->arrayToString($targetThemeData->getThemeData()) . "`"));

		break;
	case "create":
		$commandType = "add";
		$tmpThemeObj->setThemeDescriptor(
			array(
				"theme_id"		=> "*",
				"theme_name"	=> $bts->I18nTransObj->getI18nTransEntry('t1l2c2'),
				"theme_title"	=> $bts->I18nTransObj->getI18nTransEntry('t1l2c2'),
				"theme_desc"	=> $bts->I18nTransObj->getI18nTransEntry('t1l2c2'),
			)
		);
		$Content .= "<p>" . $bts->I18nTransObj->getI18nTransEntry('invite2') . "</p>\r";
		$processStep = "Create";
		$processTarget = "edit";
		break;
}
unset($tmpThemeObj);

// --------------------------------------------------------------------------------------------
$n = 1;
$Content .=
	$bts->RenderFormObj->renderformHeader('themeForm')
	. $bts->RenderFormObj->renderHiddenInput("formSubmitted",				"1")
	. $bts->RenderFormObj->renderHiddenInput("formGenericData[origin]",		"AdminDashboard")
	. $bts->RenderFormObj->renderHiddenInput("formGenericData[section]",	"AdminThemeManagementP02")
	. $bts->RenderFormObj->renderHiddenInput("formGenericData[mode]",		$processTarget)
	. $bts->RenderFormObj->renderHiddenInput("themeForm[selectionId]",		$targetThemeData->getThemeDataEntry('theme_id'))
	. $bts->RenderFormObj->renderHiddenInput("formCommand". $n,				$commandType)
	. $bts->RenderFormObj->renderHiddenInput("formEntity" . $n,				"theme")
	. $bts->RenderFormObj->renderHiddenInput("formTarget" . $n . "[name]", 	$targetThemeData->getThemeDataEntry('theme_name'))
	. "<p>\r";

// This list will compile every theme_definition name 
$ThemeDefinitionNameList = array();


// --------------------------------------------------------------------------------------------
$T = array();
$curTab = 1;

$T['Content'][$curTab]['1']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l1c1');
$T['Content'][$curTab]['2']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l2c1');
$T['Content'][$curTab]['3']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l3c1');
$T['Content'][$curTab]['4']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l4c1');
$T['Content'][$curTab]['5']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l5c1');


$T['Content'][$curTab]['1']['2']['cont'] = $targetThemeData->getThemeDataEntry('theme_id');
$T['Content'][$curTab]['2']['2']['cont'] = $t1l2c2;
$T['Content'][$curTab]['3']['2']['cont'] = $bts->RenderFormObj->renderInputText('formParams1[title]',	$targetThemeData->getThemeDataEntry('theme_title'));
$T['Content'][$curTab]['4']['2']['cont'] = $targetThemeData->getThemeDataEntry('theme_desc');
$n++;

// --------------------------------------------------------------------------------------------
$decoCount1 = 1;
for ($i = 2; $i <= 3; $i++) {
	for ($j = 1; $j <= 15; $j++) {
		$decoCount2 = sprintf("%02u", $decoCount1);
		$T['Content'][$i][$j]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t2lxc1') . "_" . $decoCount2;
		$T['Content'][$i][$j]['2']['cont'] =
		$bts->RenderFormObj->renderInputText("formParams" . $n . "[block_" . $decoCount2 . "_name_string]",	$targetThemeData->getThemeDefinitionSubEntry('block_' . $decoCount2 . '_name', 'def_string'))
		. "&nbsp;&nbsp;&nbsp;&nbsp;"
		. $bts->RenderFormObj->renderInputText("formParams" . ($n + 1) . "[block_" . $decoCount2 . "_text_string]",	$targetThemeData->getThemeDefinitionSubEntry('block_' . $decoCount2 . '_text', 'def_string'));
		$ThemeDefinitionNameList[$n] = 'block_' . $decoCount2 . '_name';	$n++;
		$ThemeDefinitionNameList[$n] = 'block_' . $decoCount2 . '_text';	$n++;
		$decoCount1++;
	}
}

// --------------------------------------------------------------------------------------------
$decoCount1 = 0;
for ($j = 1; $j <= 10; $j++) {
	$decoCount2 = sprintf("%02u", $decoCount1);
	$T['Content']['4'][$j]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t2lxc1') . "_" . $decoCount2;
	$T['Content']['4'][$j]['2']['cont'] = $bts->RenderFormObj->renderInputText("formParams" . $n . "[block_" . $decoCount2 . "_menu_string]",	$targetThemeData->getThemeDefinitionSubEntry('block_' . $decoCount2 . '_menu', 'def_string'));
	$ThemeDefinitionNameList[$n] = 'block_' . $decoCount2 . '_menu';	$n++;
	$decoCount1++;
}

// --------------------------------------------------------------------------------------------
$curTab = 5;
$T['Content'][$curTab]['1']['1']['cont']		= $bts->I18nTransObj->getI18nTransEntry('t' . $curTab . 'l1c1');
$T['Content'][$curTab]['2']['1']['cont']		= $bts->I18nTransObj->getI18nTransEntry('t' . $curTab . 'l2c1') . " #1";
$T['Content'][$curTab]['3']['1']['cont']		= $bts->I18nTransObj->getI18nTransEntry('t' . $curTab . 'l2c1') . " #2";
$T['Content'][$curTab]['4']['1']['cont']		= $bts->I18nTransObj->getI18nTransEntry('t' . $curTab . 'l2c1') . " #3";
$T['Content'][$curTab]['5']['1']['cont']		= $bts->I18nTransObj->getI18nTransEntry('t' . $curTab . 'l2c1') . " #4";
$T['Content'][$curTab]['6']['1']['cont']		= $bts->I18nTransObj->getI18nTransEntry('t' . $curTab . 'l2c1') . " #5";
$T['Content'][$curTab]['7']['2']['cont']		= $bts->I18nTransObj->getI18nTransEntry('t' . $curTab . 'l7c1');
$T['Content'][$curTab]['7']['1']['colspan']		= 2;
$T['Content'][$curTab]['8']['1']['cont']		= $bts->I18nTransObj->getI18nTransEntry('t' . $curTab . 'l8c1');
$T['Content'][$curTab]['9']['1']['cont']		= $bts->I18nTransObj->getI18nTransEntry('t' . $curTab . 'l9c1');
$T['Content'][$curTab]['10']['1']['cont']		= $bts->I18nTransObj->getI18nTransEntry('t' . $curTab . 'l10c1');
$T['Content'][$curTab]['11']['2']['cont']		= $bts->I18nTransObj->getI18nTransEntry('t' . $curTab . 'l11c1');
$T['Content'][$curTab]['11']['1']['colspan']	= 2;
$T['Content'][$curTab]['12']['1']['cont']		= $bts->I18nTransObj->getI18nTransEntry('t' . $curTab . 'l12c1');
$T['Content'][$curTab]['13']['1']['cont']		= $bts->I18nTransObj->getI18nTransEntry('t' . $curTab . 'l13c1');
$T['Content'][$curTab]['14']['1']['cont']		= $bts->I18nTransObj->getI18nTransEntry('t' . $curTab . 'l14c1');
$T['Content'][$curTab]['15']['1']['cont']		= $bts->I18nTransObj->getI18nTransEntry('t' . $curTab . 'l15c1');
$T['Content'][$curTab]['16']['2']['cont']		= $bts->I18nTransObj->getI18nTransEntry('t' . $curTab . 'l16c1');
$T['Content'][$curTab]['16']['1']['colspan']	= 2;
$T['Content'][$curTab]['17']['1']['cont']		= $bts->I18nTransObj->getI18nTransEntry('t' . $curTab . 'l17c1');
$T['Content'][$curTab]['18']['1']['cont']		= $bts->I18nTransObj->getI18nTransEntry('t' . $curTab . 'l18c1');

$FileSelectorConfig = $bts->InteractiveElementsObj->getDefaultIconSelectFileConfig(
	"themeForm",
	"formParams" . $n . "[directory_string]",
	25,
	$targetThemeData->getThemeDefinitionSubEntry('directory', 'def_string'),
	"/media/theme/",
	"/media/theme/",
	"t5l1c2",
);

$FileSelectorConfig['selectionMode'] = "directory";
$infos['IconSelectFile'] = $FileSelectorConfig;
$CurrentSetObj->setDataSubEntry('fs', $CurrentSetObj->getDataEntry('fsIdx'), $FileSelectorConfig);
$CurrentSetObj->setDataEntry('fsIdx', $CurrentSetObj->getDataEntry('fsIdx') + 1);
$T['Content'][$curTab]['1']['2']['cont']		= $bts->InteractiveElementsObj->renderIconSelectFile($infos);
$ThemeDefinitionNameList[$n] = 'directory';	$n++;

// --------------------------------------------------------------------------------------------
// Stylesheets
$j = 1;
for ($i = 2; $i <= 6; $i++) {
	$FileSelectorConfig = $bts->InteractiveElementsObj->getDefaultIconSelectFileConfig(
		"themeForm",
		"formParams" . $n . "[stylesheet_" . $j . "_string]",
		25,
		$targetThemeData->getThemeDefinitionSubEntry('stylesheet_' . $j, 'def_string'),
		"/stylesheets/",
		"/stylesheets/",
		"t5l" . $i . "c2",
	);

	$ThemeDefinitionNameList[$n] = "stylesheet_" . $j;	$n++;

	$infos['IconSelectFile'] = $FileSelectorConfig;
	$CurrentSetObj->setDataSubEntry('fs', $CurrentSetObj->getDataEntry('fsIdx'), $FileSelectorConfig);
	$CurrentSetObj->setDataEntry('fsIdx', $CurrentSetObj->getDataEntry('fsIdx') + 1);
	$T['Content'][$curTab][$i]['2']['cont']		= $bts->InteractiveElementsObj->renderIconSelectFile($infos);
	$j++;

}

// --------------------------------------------------------------------------------------------
$FileSelectorConfig = array_merge(
	$bts->InteractiveElementsObj->getDefaultIconSelectFileConfig(
		"themeForm",
		"formParams" . $n . "[bg_string]",
		25,
		$targetThemeData->getThemeDefinitionSubEntry('bg', 'def_string'),
		"/media/theme/",
		"/media/theme/",
		"t5l4c2",
	),
	array("displayType"		=> "imageMosaic")
);

$ThemeDefinitionNameList[$n] = "bg";	$n++;


$infos['IconSelectFile'] = $FileSelectorConfig;
$CurrentSetObj->setDataSubEntry('fs', $CurrentSetObj->getDataEntry('fsIdx'), $FileSelectorConfig);
$CurrentSetObj->setDataEntry('fsIdx', $CurrentSetObj->getDataEntry('fsIdx') + 1);
$T['Content'][$curTab]['8']['2']['cont']		= $bts->InteractiveElementsObj->renderIconSelectFile($infos);

$T['Content'][$curTab]['9']['2']['cont']		= $bts->RenderFormObj->renderInputText("formParams" . $n . "[theme_bg_repeat_string]", $targetThemeData->getThemeDataEntry('theme_bg_repeat'), "", 25);
$ThemeDefinitionNameList[$n] = "theme_bg_repeat";	$n++;

$T['Content'][$curTab]['10']['2']['cont']		= $bts->RenderFormObj->renderInputText("formParams" . $n . "[theme_bg_color_string]", $targetThemeData->getThemeDataEntry('theme_bg_color'), "", 25);
$ThemeDefinitionNameList[$n] = "theme_bg_color";	$n++;

$FileSelectorConfig = array_merge(
	$bts->InteractiveElementsObj->getDefaultIconSelectFileConfig(
		"themeForm",
		"formParams" . $n . "[divinitial_bg_string]",
		25,
		$targetThemeData->getThemeDataEntry('theme_divinitial_bg'),
		"/media/theme/",
		"/media/theme/",
		"t5l12c2",
	),
	array("displayType"		=> "imageMosaic")
);
$ThemeDefinitionNameList[$n] = "divinitial_bg";	$n++;

$infos['IconSelectFile'] = $FileSelectorConfig;
$CurrentSetObj->setDataSubEntry('fs', $CurrentSetObj->getDataEntry('fsIdx'), $FileSelectorConfig);
$CurrentSetObj->setDataEntry('fsIdx', $CurrentSetObj->getDataEntry('fsIdx') + 1);
$T['Content'][$curTab]['12']['2']['cont']		= $bts->InteractiveElementsObj->renderIconSelectFile($infos);


$T['Content'][$curTab]['13']['2']['cont']	= $bts->RenderFormObj->renderInputText("formParams" . $n . "[theme_divinitial_repeat_string]", $targetThemeData->getThemeDataEntry('theme_divinitial_repeat'), "", 25);
$ThemeDefinitionNameList[$n] = "theme_divinitial_repeat";	$n++;

$T['Content'][$curTab]['14']['2']['cont']	= $bts->RenderFormObj->renderInputText("formParams" . $n . "[theme_divinitial_dx_number]", $targetThemeData->getThemeDataEntry('theme_divinitial_dx'), "", 25);
$ThemeDefinitionNameList[$n] = "theme_divinitial_dx";	$n++;

$T['Content'][$curTab]['15']['2']['cont']	= $bts->RenderFormObj->renderInputText("formParams" . $n . "[theme_divinitial_dy_number]", $targetThemeData->getThemeDataEntry('theme_divinitial_dy'), "", 25);
$ThemeDefinitionNameList[$n] = "theme_divinitial_dy";	$n++;

$FileSelectorConfig = array_merge(
	$bts->InteractiveElementsObj->getDefaultIconSelectFileConfig(
		"themeForm",
		"formParams" . $n . "[divinitial_bg_string]",
		25,
		$targetThemeData->getThemeDataEntry('theme_divinitial_bg'),
		"/media/theme/",
		"/media/theme/",
		"t5l12c2",
	),
	array("displayType"		=> "imageMosaic")
);
$infos['IconSelectFile'] = $FileSelectorConfig;
$CurrentSetObj->setDataSubEntry('fs', $CurrentSetObj->getDataEntry('fsIdx'), $FileSelectorConfig);
$CurrentSetObj->setDataEntry('fsIdx', $CurrentSetObj->getDataEntry('fsIdx') + 1);
$T['Content'][$curTab]['12']['2']['cont']		= $bts->InteractiveElementsObj->renderIconSelectFile($infos);
$ThemeDefinitionNameList[$n] = "divinitial_bg";	$n++;

$FileSelectorConfig = array_merge(
	$bts->InteractiveElementsObj->getDefaultIconSelectFileConfig(
		"themeForm",
		"formParams" . $n . "[logo_string]",
		25,
		$targetThemeData->getThemeDefinitionSubEntry('logo', 'def_string'),
		"/media/theme/",
		"/media/theme/",
		"t5l17c2",
	),
	array("displayType"		=> "imageMosaic")
);
$infos['IconSelectFile'] = $FileSelectorConfig;
$CurrentSetObj->setDataSubEntry('fs', $CurrentSetObj->getDataEntry('fsIdx'), $FileSelectorConfig);
$CurrentSetObj->setDataEntry('fsIdx', $CurrentSetObj->getDataEntry('fsIdx') + 1);
$T['Content'][$curTab]['17']['2']['cont']		= $bts->InteractiveElementsObj->renderIconSelectFile($infos);
$ThemeDefinitionNameList[$n] = "logo";	$n++;

$FileSelectorConfig = array_merge(
	$bts->InteractiveElementsObj->getDefaultIconSelectFileConfig(
		"themeForm",
		"formParams" . $n . "[banner_string]",
		25,
		$targetThemeData->getThemeDefinitionSubEntry('banner', 'def_string'),
		"/media/theme/",
		"/media/theme/",
		"t5l18c2",
	),
	array("displayType"		=> "imageMosaic")
);
$infos['IconSelectFile'] = $FileSelectorConfig;
$CurrentSetObj->setDataSubEntry('fs', $CurrentSetObj->getDataEntry('fsIdx'), $FileSelectorConfig);
$CurrentSetObj->setDataEntry('fsIdx', $CurrentSetObj->getDataEntry('fsIdx') + 1);
$T['Content'][$curTab]['18']['2']['cont']		= $bts->InteractiveElementsObj->renderIconSelectFile($infos);
$ThemeDefinitionNameList[$n] = "banner";	$n++;


// --------------------------------------------------------------------------------------------
$curTab++;
$T['Content'][$curTab]['1']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t6l1c1');
$T['Content'][$curTab]['2']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t6l2c1');
$T['Content'][$curTab]['3']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t6l3c1');
$T['Content'][$curTab]['4']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t6l4c1');
$T['Content'][$curTab]['5']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t6l5c1');
$T['Content'][$curTab]['6']['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t6l6c1');

$FileSelectorConfig = array_merge(
	$bts->InteractiveElementsObj->getDefaultIconSelectFileConfig(
		"themeForm",
		"formParams" . $n . "[admctrl_panel_bg_string]",
		25,
		$targetThemeData->getThemeDataEntry('admctrl_panel_bg'),
		"/media/theme/",
		"/media/theme/",
		"t6l1c2",
	),
	array("displayType"		=> "imageMosaic")
);
$infos['IconSelectFile'] = $FileSelectorConfig;
$CurrentSetObj->setDataSubEntry('fs', $CurrentSetObj->getDataEntry('fsIdx'), $FileSelectorConfig);
$CurrentSetObj->setDataEntry('fsIdx', $CurrentSetObj->getDataEntry('fsIdx') + 1);
$T['Content'][$curTab]['1']['2']['cont'] = $bts->InteractiveElementsObj->renderIconSelectFile($infos);
$ThemeDefinitionNameList[$n] = "admctrl_panel_bg";	$n++;



$FileSelectorConfig = array_merge(
	$bts->InteractiveElementsObj->getDefaultIconSelectFileConfig(
		"themeForm",
		"formParams" . $n . "[admctrl_switch_bg_string]",
		25,
		$targetThemeData->getThemeDefinitionSubEntry('admctrl_switch_bg', 'def_string'),
		"/media/theme/",
		"/media/theme/",
		"t6l2c2",
	),
	array("displayType"		=> "imageMosaic")
);
$infos['IconSelectFile'] = $FileSelectorConfig;
$CurrentSetObj->setDataSubEntry('fs', $CurrentSetObj->getDataEntry('fsIdx'), $FileSelectorConfig);
$CurrentSetObj->setDataEntry('fsIdx', $CurrentSetObj->getDataEntry('fsIdx') + 1);
$T['Content'][$curTab]['2']['2']['cont'] = $bts->InteractiveElementsObj->renderIconSelectFile($infos);
$ThemeDefinitionNameList[$n] = "admctrl_switch_bg"; $n++;


$T['Content'][$curTab]['3']['2']['cont'] =
	$bts->RenderFormObj->renderInputText("formParams" . $n . "[admctrl_size_x_number]", $targetThemeData->getThemeDefinitionSubEntry('admctrl_width', 'def_number'), "", 8) . "px\r / "
	. $bts->RenderFormObj->renderInputText("formParams" . $n . "[admctrl_size_y_number]", $targetThemeData->getThemeDefinitionSubEntry('admctrl_height', 'def_number'), "", 8) . "px\r";
$ThemeDefinitionNameList[$n] = "admctrl_size_x"; $n++;
$ThemeDefinitionNameList[$n] = "admctrl_size_y"; $n++;


$T['Content'][$curTab]['4']['2']['cont'] = "<select name ='formParams" . $n . "['admctrl_position_string']' class='" . $Block . "_t3 " . $Block . "_form_1'>\r";
$admctrl_position = array();
$admctrl_position[$targetThemeData->getThemeDefinitionSubEntry('admctrl_position', 'def_string')] = " selected ";
$T['Content'][$curTab]['4']['2']['cont'] .= "
<option value='1' " . $admctrl_position['1'] . "> " . $bts->I18nTransObj->getI18nTransEntry('acpUp') . " - " .		$bts->I18nTransObj->getI18nTransEntry('acpLeft')	. " </option>\r
<option value='2' " . $admctrl_position['2'] . "> " . $bts->I18nTransObj->getI18nTransEntry('acpUp') . " - " .		$bts->I18nTransObj->getI18nTransEntry('acpMiddle')	. " </option>\r
<option value='3' " . $admctrl_position['3'] . "> " . $bts->I18nTransObj->getI18nTransEntry('acpUp') . " - " .		$bts->I18nTransObj->getI18nTransEntry('acpRight')	. " </option>\r
<option value='4' " . $admctrl_position['4'] . "> " . $bts->I18nTransObj->getI18nTransEntry('acpMiddle') . " - " .	$bts->I18nTransObj->getI18nTransEntry('acpRight')	. " </option>\r
<option value='5' " . $admctrl_position['5'] . "> " . $bts->I18nTransObj->getI18nTransEntry('acpDown') . " - " .	$bts->I18nTransObj->getI18nTransEntry('acpRight')	. " </option>\r
<option value='6' " . $admctrl_position['6'] . "> " . $bts->I18nTransObj->getI18nTransEntry('acpDown') . " - " .	$bts->I18nTransObj->getI18nTransEntry('acpMiddle')	. " </option>\r
<option value='7' " . $admctrl_position['7'] . "> " . $bts->I18nTransObj->getI18nTransEntry('acpDown') . " - " .	$bts->I18nTransObj->getI18nTransEntry('acpLeft')	. " </option>\r
<option value='8' " . $admctrl_position['8'] . "> " . $bts->I18nTransObj->getI18nTransEntry('acpMiddle') . " - " .	$bts->I18nTransObj->getI18nTransEntry('acpLeft')	. " </option>\r
</select>\r";
$ThemeDefinitionNameList[$n] = "admctrl_position"; $n++;

$arrInputText1 = array(
	"id" => "TM_gradient_color_start",
	"name" => "formParams" . $n . "[gradient_color_start_string]",
	"size" => 8,
	"maxlength" => 6,
	"value" =>
	$targetThemeData->getThemeDefinitionSubEntry('gradient_color_start', 'def_string'),
);
$ThemeDefinitionNameList[$n] = "gradient_color_start"; $n++;

$arrInputText3 = $arrInputText2 = $arrInputText1;

$arrInputText2['id'] = "TM_gradient_color_middle";
$arrInputText2['name'] = "formParams" . $n . "[gradient_color_middle_string]";
$arrInputText2['value'] = $targetThemeData->getThemeDefinitionSubEntry('gradient_color_middle', 'def_string');
$ThemeDefinitionNameList[$n] = "gradient_color_middle"; $n++;

$arrInputText3['id'] = "TM_gradient_color_end";
$arrInputText3['name'] = "formParams" . $n . "[gradient_color_end_string]";
$arrInputText3['value'] = $targetThemeData->getThemeDefinitionSubEntry('gradient_color_end', 'def_string');
$ThemeDefinitionNameList[$n] = "gradient_color_end"; $n++;


switch ($bts->CMObj->getConfigurationEntry('colorSelector')) {
	case "JnsEng":
		// $T['Content'][$curTab]['5']['2']['cont'] = "
		// #<input type='text' id='TM_gradient_start_color'	name='formParams2[gradient_start_color]'		size='8' maxlength='6' value=\"".$targetThemeData->getThemeDataEntry('theme_gradient_start_color')."\"	>\r /
		// #<input type='text' id='TM_gradient_middle_color'	name='formParams2[gradient_middle_color]'	size='8' maxlength='6' value=\"".$targetThemeData->getThemeDataEntry('theme_gradient_middle_color')."\"	>\r /
		// #<input type='text' id='TM_gradient_end_color'		name='formParams2[gradient_end_color]'		size='8' maxlength='6' value=\"".$targetThemeData->getThemeDataEntry('theme_gradient_end_color')."\"		>\r
		// ";
		break;
	case "system":
	default:
		$arrInputText3['oninput'] = $arrInputText2['oninput'] = $arrInputText1['oninput'] = "ThemeGradientMgmt()";
		// $T['Content'][$curTab]['5']['2']['cont'] = "
		// <input type='color' id='TM_gradient_start_color'	name='formParams2[gradient_start_color]'		value='#".$targetThemeData->getThemeDataEntry('theme_gradient_start_color')."'	oninput='ThemeGradientMgmt()'>\r /
		// <input type='color' id='TM_gradient_middle_color'	name='formParams2[gradient_middle_color]'	value='#".$targetThemeData->getThemeDataEntry('theme_gradient_middle_color')."'	oninput='ThemeGradientMgmt()'>\r /
		// <input type='color' id='TM_gradient_end_color'		name='formParams2[gradient_end_color]'		value='#".$targetThemeData->getThemeDataEntry('theme_gradient_end_color')."'		oninput='ThemeGradientMgmt()'>\r
		// ";
		break;
}

$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : ThemeDefinition = `" . $bts->StringFormatObj->arrayToString($arrInputText1) . "`"));
$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : ThemeDefinition = `" . $bts->StringFormatObj->arrayToString($arrInputText2) . "`"));
$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : ThemeDefinition = `" . $bts->StringFormatObj->arrayToString($arrInputText3) . "`"));

$T['Content'][$curTab]['5']['2']['cont'] =
	"# " . $bts->RenderFormObj->renderInputTextEnhanced($arrInputText1) . " / \r"
	. "# " . $bts->RenderFormObj->renderInputTextEnhanced($arrInputText2) . " / \r"
	. "# " . $bts->RenderFormObj->renderInputTextEnhanced($arrInputText3) . "\r";



$T['Content'][$curTab]['5']['2']['cont'] .= "
<br>\r
<br>\r
<table style='border: 1px solid black; border-collapse: collapse'>\r
<tr>\r";

$gradientNbr = 30;
$gradientWidth = 320;
for ($i = 1; $i <= $gradientNbr; $i++) {
	$T['Content'][$curTab]['5']['2']['cont'] .= "<td id='gfx_gradient_" . $i . "' style='width: " . floor($gradientWidth / $gradientNbr) . "px; height: 32px; background-color: #000000; border: 0px'></td>\r";
}
$T['Content'][$curTab]['5']['2']['cont'] .= "</tr>\r</table>\r";


// --------------------------------------------------------------------------------------------
// Making the hidden form definition for generating lot's of console commands
$n = 2; // re-using
foreach ($ThemeDefinitionNameList as $tdnl) {
	$Content .= $bts->RenderFormObj->renderHiddenInput("formCommand" . $n,			$commandType)
		. $bts->RenderFormObj->renderHiddenInput("formEntity" . $n,						"theme_definition")
		. $bts->RenderFormObj->renderHiddenInput("formTarget" . $n . "[name]", 			$tdnl)
		. $bts->RenderFormObj->renderHiddenInput("formParams" . $n . "[fk_theme_id]", 	$targetThemeData->getThemeDataEntry('theme_id'));
	$n++;
}

// --------------------------------------------------------------------------------------------
//
//	Display
//
//
// --------------------------------------------------------------------------------------------
$T['ContentInfos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, 16, 6);
$T['ContentCfg']['tabs'] = array(
	1	=>	$bts->RenderTablesObj->getDefaultTableConfig(4, 2, 2),
	2	=>	$bts->RenderTablesObj->getDefaultTableConfig(15, 2, 2),
	3	=>	$bts->RenderTablesObj->getDefaultTableConfig(15, 2, 2),
	4	=>	$bts->RenderTablesObj->getDefaultTableConfig(10, 2, 2),
	5	=>	$bts->RenderTablesObj->getDefaultTableConfig(18, 2, 2),
	6	=>	$bts->RenderTablesObj->getDefaultTableConfig(6, 2, 2),
);
$Content .= $bts->RenderTablesObj->render($infos, $T);

// --------------------------------------------------------------------------------------------

$CurrentSetObj->GeneratedScriptObj->insertString('JavaScript-File', "current/engine/javascript/lib_themeManagement.js");
$CurrentSetObj->GeneratedScriptObj->insertString('JavaScript-OnLoad', 'ThemeGradientMgmt();');
// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('Template');
$TemplateObj = Template::getInstance();
$infos['formName'] = "themeForm";
$Content .= $TemplateObj->renderAdminFormButtons($infos);

$bts->segmentEnding(__METHOD__);
/*JanusEngine-Content-End*/
