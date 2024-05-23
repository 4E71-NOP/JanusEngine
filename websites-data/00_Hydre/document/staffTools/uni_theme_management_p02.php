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

$bts->RequestDataObj->setRequestData(
	'themeForm',
	array(
		'selectionId'	=>	87500728700317434,
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
$bts->CMObj->setConfigurationEntry('colorSelector', 'system');		//"or Hydr"


/*Hydr-Content-Begin*/
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
$currentThemeObj = new ThemeDescriptor();
switch ($bts->RequestDataObj->getRequestDataSubEntry('formGenericData', 'mode')) {
	case "edit":
		$commandType = "update";
		$currentThemeObj->getDataFromDB($bts->RequestDataObj->getRequestDataSubEntry('themeForm', 'selectionId'));
		$t1l2c2 = $currentThemeObj->getThemeDescriptorEntry('theme_name');
		$Content .= "<p>" . $bts->I18nTransObj->getI18nTransEntry('invite1') . "</p>\r";
		$processStep = "";
		$processTarget = "edit";
		break;
	case "create":
		$commandType = "add";
		$currentThemeObj->setThemeDescriptor(
			array(
				"theme_id"		=> "*",
				"theme_name"	=> $bts->I18nTransObj->getI18nTransEntry('t1l2c2'),
				"theme_title"	=> $bts->I18nTransObj->getI18nTransEntry('t1l2c2'),
				"theme_desc"	=> $bts->I18nTransObj->getI18nTransEntry('t1l2c2'),
			)
		);
		$t1l2c2 = $bts->RenderFormObj->renderInputText('formParams1[name]',	$currentThemeObj->getThemeDescriptorEntry('theme_name'));
		$Content .= "<p>" . $bts->I18nTransObj->getI18nTransEntry('invite2') . "</p>\r";
		$processStep = "Create";
		$processTarget = "edit";
		break;
}

// --------------------------------------------------------------------------------------------
$Content .=
	$bts->RenderFormObj->renderformHeader('themeForm')
	. $bts->RenderFormObj->renderHiddenInput("formSubmitted",				"1")
	. $bts->RenderFormObj->renderHiddenInput("formGenericData[origin]",	"AdminDashboard")
	. $bts->RenderFormObj->renderHiddenInput("formGenericData[section]",	"AdminThemeManagementP02")
	. $bts->RenderFormObj->renderHiddenInput("formCommand1",	$commandType)
	. $bts->RenderFormObj->renderHiddenInput("formEntity1",	"menu")
	. $bts->RenderFormObj->renderHiddenInput("formGenericData[mode]",	$processTarget)
	. $bts->RenderFormObj->renderHiddenInput("formTarget1[name]", 	$currentThemeObj->getThemeDescriptorEntry('theme_name'))
	. $bts->RenderFormObj->renderHiddenInput("themeForm[selectionId]",	$currentThemeObj->getThemeDescriptorEntry('theme_id'))
	. "<p>\r";

// --------------------------------------------------------------------------------------------
$T = array();
$curTab = 1;

$T['Content'][$curTab]['1']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l1c1');
$T['Content'][$curTab]['2']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l2c1');
$T['Content'][$curTab]['3']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l3c1');
$T['Content'][$curTab]['4']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l4c1');
$T['Content'][$curTab]['5']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l5c1');


$T['Content'][$curTab]['1']['2']['cont'] = $currentThemeObj->getThemeDescriptorEntry('theme_id');
$T['Content'][$curTab]['2']['2']['cont'] = $t1l2c2;
$T['Content'][$curTab]['3']['2']['cont'] = $bts->RenderFormObj->renderInputText('formParams1[title]',	$currentThemeObj->getThemeDescriptorEntry('theme_title'));
$T['Content'][$curTab]['4']['2']['cont'] = $currentThemeObj->getThemeDescriptorEntry('theme_desc');


// --------------------------------------------------------------------------------------------
$decoCount1 = 1;
for ($i = 2; $i <= 3; $i++) {
	for ($j = 1; $j <= 15; $j++) {
		$decoCount2 = sprintf("%02u", $decoCount1);
		$T['Content'][$i][$j]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t2lxc1') . "_" . $decoCount2;
		$T['Content'][$i][$j]['2']['cont'] =
			$bts->RenderFormObj->renderInputText('formParams1[block_".$decoCount2."_nom]',	$currentThemeObj->getThemeDescriptorEntry('block_' . $decoCount2 . '_name'))
			. "&nbsp;&nbsp;&nbsp;&nbsp;"
			. $bts->RenderFormObj->renderInputText('formParams1[block_".$decoCount2."_text]',	$currentThemeObj->getThemeDescriptorEntry('block_' . $decoCount2 . '_text'));
		$decoCount1++;
	}
}

// --------------------------------------------------------------------------------------------
$decoCount1 = 0;
for ($j = 1; $j <= 30; $j++) {
	$decoCount2 = sprintf("%02u", $decoCount1);
	$T['Content']['4'][$j]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t2lxc1') . "_" . $decoCount2;
	$T['Content']['4'][$j]['2']['cont'] = $bts->RenderFormObj->renderInputText('formParams1[block_".$decoCount2."_menu]',	$currentThemeObj->getThemeDescriptorEntry('block_' . $decoCount2 . '_menu'));
	// "<input type='text' name='formParams[theme_bloc_".$decoCount2."_menu]' size='25' maxlength='255' value=\"".$currentThemeObj->getThemeDescriptorEntry('block_'.$decoCount2.'_menu')."\" class='".$Block."_t3 ".$Block."_form_1'>\r";
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
	"formParams[theme_directory]",
	25,
	$currentThemeObj->getThemeDescriptorEntry('theme_directory'),
	"/media/theme/",
	"/media/theme/",
	"t5l1c2",
);
$FileSelectorConfig['selectionMode'] = "directory";
$infos['IconSelectFile'] = $FileSelectorConfig;
$CurrentSetObj->setDataSubEntry('fs', $CurrentSetObj->getDataEntry('fsIdx'), $FileSelectorConfig);
$CurrentSetObj->setDataEntry('fsIdx', $CurrentSetObj->getDataEntry('fsIdx') + 1);
$T['Content'][$curTab]['1']['2']['cont']		= $bts->InteractiveElementsObj->renderIconSelectFile($infos);


$FileSelectorConfig = $bts->InteractiveElementsObj->getDefaultIconSelectFileConfig(
	"themeForm",
	"formParams[theme_stylesheet_1]",
	25,
	$currentThemeObj->getThemeDescriptorEntry('theme_stylesheet_1'),
	"/stylesheets/",
	"/stylesheets/",
	"t5l2c2",
);
$infos['IconSelectFile'] = $FileSelectorConfig;
$CurrentSetObj->setDataSubEntry('fs', $CurrentSetObj->getDataEntry('fsIdx'), $FileSelectorConfig);
$CurrentSetObj->setDataEntry('fsIdx', $CurrentSetObj->getDataEntry('fsIdx') + 1);
$T['Content'][$curTab]['2']['2']['cont']		= $bts->InteractiveElementsObj->renderIconSelectFile($infos);


$FileSelectorConfig = $bts->InteractiveElementsObj->getDefaultIconSelectFileConfig(
	"themeForm",
	"formParams[theme_stylesheet_2]",
	25,
	$currentThemeObj->getThemeDescriptorEntry('theme_stylesheet_2'),
	"/stylesheets/",
	"/stylesheets/",
	"t5l3c2",
);
$infos['IconSelectFile'] = $FileSelectorConfig;
$CurrentSetObj->setDataSubEntry('fs', $CurrentSetObj->getDataEntry('fsIdx'), $FileSelectorConfig);
$CurrentSetObj->setDataEntry('fsIdx', $CurrentSetObj->getDataEntry('fsIdx') + 1);
$T['Content'][$curTab]['3']['2']['cont']		= $bts->InteractiveElementsObj->renderIconSelectFile($infos);


$FileSelectorConfig = $bts->InteractiveElementsObj->getDefaultIconSelectFileConfig(
	"themeForm",
	"formParams[theme_stylesheet_3]",
	25,
	$currentThemeObj->getThemeDescriptorEntry('theme_stylesheet_3'),
	"/stylesheets/",
	"/stylesheets/",
	"t5l4c2",
);
$infos['IconSelectFile'] = $FileSelectorConfig;
$CurrentSetObj->setDataSubEntry('fs', $CurrentSetObj->getDataEntry('fsIdx'), $FileSelectorConfig);
$CurrentSetObj->setDataEntry('fsIdx', $CurrentSetObj->getDataEntry('fsIdx') + 1);
$T['Content'][$curTab]['4']['2']['cont']		= $bts->InteractiveElementsObj->renderIconSelectFile($infos);


$FileSelectorConfig = $bts->InteractiveElementsObj->getDefaultIconSelectFileConfig(
	"themeForm",
	"formParams[theme_stylesheet_4]",
	25,
	$currentThemeObj->getThemeDescriptorEntry('theme_stylesheet_4'),
	"/stylesheets/",
	"/stylesheets/",
	"t5l5c2",
);
$infos['IconSelectFile'] = $FileSelectorConfig;
$CurrentSetObj->setDataSubEntry('fs', $CurrentSetObj->getDataEntry('fsIdx'), $FileSelectorConfig);
$CurrentSetObj->setDataEntry('fsIdx', $CurrentSetObj->getDataEntry('fsIdx') + 1);
$T['Content'][$curTab]['5']['2']['cont']		= $bts->InteractiveElementsObj->renderIconSelectFile($infos);


$FileSelectorConfig = $bts->InteractiveElementsObj->getDefaultIconSelectFileConfig(
	"themeForm",
	"formParams[theme_stylesheet_5]",
	25,
	$currentThemeObj->getThemeDescriptorEntry('theme_stylesheet_5'),
	"/stylesheets/",
	"/stylesheets/",
	"t5l6c2",
);
$infos['IconSelectFile'] = $FileSelectorConfig;
$CurrentSetObj->setDataSubEntry('fs', $CurrentSetObj->getDataEntry('fsIdx'), $FileSelectorConfig);
$CurrentSetObj->setDataEntry('fsIdx', $CurrentSetObj->getDataEntry('fsIdx') + 1);
$T['Content'][$curTab]['6']['2']['cont']		= $bts->InteractiveElementsObj->renderIconSelectFile($infos);



// --------------------------------------------------------------------------------------------

$FileSelectorConfig = array_merge(
	$bts->InteractiveElementsObj->getDefaultIconSelectFileConfig(
		"themeForm",
		"formParams[theme_bg]",
		25,
		$currentThemeObj->getThemeDescriptorEntry('theme_bg'),
		"/media/theme/",
		"/media/theme/",
		"t5l4c2",
	),
	array("displayType"		=> "imageMosaic")
);
$infos['IconSelectFile'] = $FileSelectorConfig;
$CurrentSetObj->setDataSubEntry('fs', $CurrentSetObj->getDataEntry('fsIdx'), $FileSelectorConfig);
$CurrentSetObj->setDataEntry('fsIdx', $CurrentSetObj->getDataEntry('fsIdx') + 1);
$T['Content'][$curTab]['8']['2']['cont']		= $bts->InteractiveElementsObj->renderIconSelectFile($infos);

$T['Content'][$curTab]['9']['2']['cont']		= $bts->RenderFormObj->renderInputText("formParams[theme_bg_repeat]", $currentThemeObj->getThemeDescriptorEntry('theme_bg_repeat'), "", 25);
$T['Content'][$curTab]['10']['2']['cont']		= $bts->RenderFormObj->renderInputText("formParams[theme_bg_color]", $currentThemeObj->getThemeDescriptorEntry('theme_bg_color'), "", 25);
// $T['Content'][$curTab]['9']['2']['cont']		= "<input type='text' name='formParams[theme_bg_repeat]' size='25' maxlength='255' value=\"".$currentThemeObj->getThemeDescriptorEntry('theme_bg_repeat')."\" class='".$Block."_t3 ".$Block."_form_1'>\r"; 
// $T['Content'][$curTab]['10']['2']['cont']		= "<input type='text' name='formParams[theme_bg_color]' size='25' maxlength='255' value=\"".$currentThemeObj->getThemeDescriptorEntry('theme_bg_color')."\" class='".$Block."_t3 ".$Block."_form_1'>\r";

$FileSelectorConfig = array_merge(
	$bts->InteractiveElementsObj->getDefaultIconSelectFileConfig(
		"themeForm",
		"formParams[theme_divinitial_bg]",
		25,
		$currentThemeObj->getThemeDescriptorEntry('theme_divinitial_bg'),
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


$T['Content'][$curTab]['13']['2']['cont']	= $bts->RenderFormObj->renderInputText("formParams[theme_divinitial_repeat]", $currentThemeObj->getThemeDescriptorEntry('theme_divinitial_repeat'), "", 25);
$T['Content'][$curTab]['14']['2']['cont']	= $bts->RenderFormObj->renderInputText("formParams[theme_divinitial_dx]", $currentThemeObj->getThemeDescriptorEntry('theme_divinitial_dx'), "", 25);
$T['Content'][$curTab]['15']['2']['cont']	= $bts->RenderFormObj->renderInputText("formParams[theme_divinitial_dy]", $currentThemeObj->getThemeDescriptorEntry('theme_divinitial_dy'), "", 25);
// $T['Content'][$curTab]['13']['2']['cont']	= "<input type='text' name='formParams[theme_divinitial_repeat]' size='25' maxlength='255' value=\"".$currentThemeObj->getThemeDescriptorEntry('theme_divinitial_repeat')."\" class='".$Block."_t3 ".$Block."_form_1'>\r";
// $T['Content'][$curTab]['14']['2']['cont']	= "<input type='text' name='formParams[theme_divinitial_dx]' size='25' maxlength='255' value=\"".$currentThemeObj->getThemeDescriptorEntry('theme_divinitial_dx')."\" class='".$Block."_t3 ".$Block."_form_1'>\r";
// $T['Content'][$curTab]['15']['2']['cont']	= "<input type='text' name='formParams[theme_divinitial_dy]' size='25' maxlength='255' value=\"".$currentThemeObj->getThemeDescriptorEntry('theme_divinitial_dy')."\" class='".$Block."_t3 ".$Block."_form_1'>\r";

$FileSelectorConfig = array_merge(
	$bts->InteractiveElementsObj->getDefaultIconSelectFileConfig(
		"themeForm",
		"formParams[theme_divinitial_bg]",
		25,
		$currentThemeObj->getThemeDescriptorEntry('theme_divinitial_bg'),
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



$FileSelectorConfig = array_merge(
	$bts->InteractiveElementsObj->getDefaultIconSelectFileConfig(
		"themeForm",
		"formParams[theme_logo]",
		25,
		$currentThemeObj->getThemeDescriptorEntry('theme_logo'),
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


$FileSelectorConfig = array_merge(
	$bts->InteractiveElementsObj->getDefaultIconSelectFileConfig(
		"themeForm",
		"formParams[theme_banner]",
		25,
		$currentThemeObj->getThemeDescriptorEntry('theme_banner'),
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
		"formParams[theme_admctrl_panel_bg]",
		25,
		$currentThemeObj->getThemeDescriptorEntry('theme_admctrl_panel_bg'),
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

$FileSelectorConfig = array_merge(
	$bts->InteractiveElementsObj->getDefaultIconSelectFileConfig(
		"themeForm",
		"formParams[theme_admctrl_switch_bg]",
		25,
		$currentThemeObj->getThemeDescriptorEntry('theme_admctrl_switch_bg'),
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

$T['Content'][$curTab]['3']['2']['cont'] =
	$bts->RenderFormObj->renderInputText("formParams[admctrl_size_x]", $currentThemeObj->getThemeDescriptorEntry('theme_admctrl_size_x'), "", 8) . "px\r / "
	. $bts->RenderFormObj->renderInputText("formParams[admctrl_size_y]", $currentThemeObj->getThemeDescriptorEntry('theme_admctrl_size_y'), "", 8) . "px\r";
// $T['Content'][$curTab]['3']['2']['cont'] = "
// 	<input type='text' name='formParams[admctrl_size_x]' size='8' maxlength='255' value='".$currentThemeObj->getThemeDescriptorEntry('theme_admctrl_size_x')."' class='".$Block."_t3 ".$Block."_form_1'>px\r /
// 	<input type='text' name='formParams[admctrl_size_y]' size='8' maxlength='255' value='".$currentThemeObj->getThemeDescriptorEntry('theme_admctrl_size_y')."' class='".$Block."_t3 ".$Block."_form_1'>px\r"
// ;

$T['Content'][$curTab]['4']['2']['cont'] = "<select name ='formParams['admctrl_position']' class='" . $Block . "_t3 " . $Block . "_form_1'>\r";
$admctrl_position = array();
$admctrl_position[$currentThemeObj->getThemeDescriptorEntry('theme_admctrl_position')] = " selected ";
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


$arrInputText1 = array(
	"id" => "TM_gradient_start_color",
	"name" => "formParams[gradient_start_color]",
	"size" => 8,
	"maxlength" => 6,
	"value" => $currentThemeObj->getThemeDescriptorEntry('theme_gradient_start_color'),
);

$arrInputText3 = $arrInputText2 = $arrInputText1;

$arrInputText2['id'] = "TM_gradient_middle_color";
$arrInputText2['name'] = "formParams[gradient_start_color]";
$arrInputText2['value'] = $currentThemeObj->getThemeDescriptorEntry('theme_gradient_middle_color');

$arrInputText3['id'] = "TM_gradient_end_color";
$arrInputText3['name'] = "formParams[gradient_end_color]";
$arrInputText3['value'] = $currentThemeObj->getThemeDescriptorEntry('theme_gradient_end_color');

switch ($bts->CMObj->getConfigurationEntry('colorSelector')) {
	case "Hydr":
		// $T['Content'][$curTab]['5']['2']['cont'] = "
		// #<input type='text' id='TM_gradient_start_color'	name='formParams[gradient_start_color]'		size='8' maxlength='6' value=\"".$currentThemeObj->getThemeDescriptorEntry('theme_gradient_start_color')."\"	>\r /
		// #<input type='text' id='TM_gradient_middle_color'	name='formParams[gradient_middle_color]'	size='8' maxlength='6' value=\"".$currentThemeObj->getThemeDescriptorEntry('theme_gradient_middle_color')."\"	>\r /
		// #<input type='text' id='TM_gradient_end_color'		name='formParams[gradient_end_color]'		size='8' maxlength='6' value=\"".$currentThemeObj->getThemeDescriptorEntry('theme_gradient_end_color')."\"		>\r
		// ";
		break;
	case "system":
	default:
		$arrInputText3['oninput'] = $arrInputText2['oninput'] = $arrInputText1['oninput'] = "ThemeGradientMgmt()";
		// $T['Content'][$curTab]['5']['2']['cont'] = "
		// <input type='color' id='TM_gradient_start_color'	name='formParams[gradient_start_color]'		value='#".$currentThemeObj->getThemeDescriptorEntry('theme_gradient_start_color')."'	oninput='ThemeGradientMgmt()'>\r /
		// <input type='color' id='TM_gradient_middle_color'	name='formParams[gradient_middle_color]'	value='#".$currentThemeObj->getThemeDescriptorEntry('theme_gradient_middle_color')."'	oninput='ThemeGradientMgmt()'>\r /
		// <input type='color' id='TM_gradient_end_color'		name='formParams[gradient_end_color]'		value='#".$currentThemeObj->getThemeDescriptorEntry('theme_gradient_end_color')."'		oninput='ThemeGradientMgmt()'>\r
		// ";
		break;
}

$T['Content'][$curTab]['5']['2']['cont'] =
 "# " . $bts->RenderFormObj->renderInputTextEnhanced($arrInputText1) . " / \r"
."# " . $bts->RenderFormObj->renderInputTextEnhanced($arrInputText2) . " / \r"
."# " . $bts->RenderFormObj->renderInputTextEnhanced($arrInputText3) . "\r";



$T['Content'][$curTab]['5']['2']['cont'] .= "
<br>\r
<br>\r
<table style='border: 1px solid black; border-collapse: collapse'>\r
<tr>\r";

$gradientNbr = 30;
$gradientWidth = 320;
for ($i = 1; $i <= $gradientNbr; $i++) {
	$T['Content'][$curTab]['5']['2']['cont'] .= "<td id='theme_gradient_" . $i . "' style='width: " . floor($gradientWidth / $gradientNbr) . "px; height: 32px; background-color: #000000; border: 0px'></td>\r";
}
$T['Content'][$curTab]['5']['2']['cont'] .= "</tr>\r</table>\r";

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
/*Hydr-Content-End*/
