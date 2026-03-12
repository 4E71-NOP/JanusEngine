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
	'userForm',
	array(
		'selectionId'		=>	1039302295286694092,
		// 'selectionLogin'	=>	"auteur_senior",
	)
);
$bts->RequestDataObj->setRequestData(
	'formGenericData',
	array(
		'origin'		=> 'AdminDashboard',
		'section'		=> 'AdminUserManagementP02',
		'creation'		=> 'on',
		'modification'	=> 'on',
		'deletion'		=> 'on',
		'mode'			=> 'edit',
		// 'mode'			=> 'create',
		// 'mode'			=> 'delete',
	)
);

$bts->CMObj->setConfigurationEntry('colorSelector', 'system');		//"or JnsEng"

/*JanusEngine-Content-Begin*/
$bts->mapSegmentLocation(__METHOD__, "uni_user_management_p02");

$bts->I18nTransObj->getI18nTransFromDB("uni_user_management");
$bts->I18nTransObj->getI18nTransFromFile($CurrentSetObj->ServerInfosObj->getServerInfosEntry('DOCUMENT_ROOT') . "/websites-data/00_JanusEngineCore/document/staffTools/i18n/uni_user_management_p02_");

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('AdminFormTool');
$AdminFormToolObj = AdminFormTool::getInstance();
$Content .= $AdminFormToolObj->checkAdminDashboardForm($infos);

// --------------------------------------------------------------------------------------------
$T = array();
$currentUserObj = new User();
$curTab = 1;

switch ($bts->RequestDataObj->getRequestDataSubEntry('formGenericData', 'mode')) {
	case "edit":
		$commandType = "update";
		$currentUserObj->getDataFromDB($bts->RequestDataObj->getRequestDataSubEntry('userForm', 'selectionId'), $WebSiteObj);
		$t1l2c2 = $currentUserObj->getUserEntry('user_name');
		$Content .= "<p>" . $bts->I18nTransObj->getI18nTransEntry('invite1') . "</p>\r";
		$processStep = "";
		$processTarget = "edit";
		$T['Content'][$curTab]['2']['2']['cont'] = $currentUserObj->getUserEntry('user_name');
		$T['Content'][$curTab]['3']['2']['cont'] = $currentUserObj->getUserEntry('user_login');
		break;
	case "create":
		$commandType = "add";
		$Content .= "<p>" . $bts->I18nTransObj->getI18nTransEntry('invite2') . "</p>\r";
		$processStep = "Create";
		$processTarget = "edit";
		$T['Content'][$curTab]['2']['2']['cont'] = $bts->RenderFormObj->renderInputText('formParams1[name]',	$currentUserObj->getUserEntry('user_name'));;
		$T['Content'][$curTab]['3']['2']['cont'] = $bts->RenderFormObj->renderInputText('formParams1[login]',	$currentUserObj->getUserEntry('user_login'));;
		break;
}

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('MenuSelectTable');
$MenuSelectTableObj = MenuSelectTable::getInstance();

$tabGroup		= $MenuSelectTableObj->getGroupList();
$tabLanguage	= $MenuSelectTableObj->getLanguageList();
$tabTheme		= $MenuSelectTableObj->getThemeList();

$tab 			= $currentUserObj->getMenuOptionArray();

// --------------------------------------------------------------------------------------------
$timezone = array(
	0		=> "0 - England, Ireland, Portugal",
	1		=> "+1 - Europe: France, Spain, Germany, Poland, etc.",
	2		=> "+2 - Central Europe: Turkey, Greece, Finland, etc.",
	3		=> "+3 - Moscow, Saudi Arabia",
	4		=> "+4 - Oman",
	5		=> "+5 - Pakistan",
	6		=> "+6 - India",
	7		=> "+7 - Indonesia",
	8		=> "+8 - China, Phillipines, Malaysia, West Australia",
	9		=> "+9 - Japan",
	10		=> "+10 - East Australia",
	11		=> "+11 - Solomon islands, Micronesia",
	12		=> "+12 - Marshall Islands, Fiji",
	13		=> "-11 - Samoa, Midway",
	14		=> "-10 - Hawaii, French Polynesia, Cook island",
	15		=> "-9 - Alaska",
	16		=> "-8 - US Pacific",
	17		=> "-7 - US Mountain",
	18		=> "-6 - US Central",
	19		=> "-5 - US Eastern",
	20		=> "-4 - New Foundland, Venezuela, Chile",
	21		=> "-3 - Brazil, Argentina, Greenland",
	22		=> "-2 - Mid-Atlantic",
	23		=> "-1 - Azores, Cape Verda Is.",
);

// --------------------------------------------------------------------------------------------

$Content .=
	$bts->RenderFormObj->renderformHeader('userForm')
	. $bts->RenderFormObj->renderHiddenInput("formSubmitted",				"1")
	. $bts->RenderFormObj->renderHiddenInput("formGenericData[origin]",		"AdminDashboard")
	. $bts->RenderFormObj->renderHiddenInput("formGenericData[section]",	"AdminUserManagementP02")
	. $bts->RenderFormObj->renderHiddenInput("formCommand1",				$commandType)
	. $bts->RenderFormObj->renderHiddenInput("formEntity1",					"user")
	. $bts->RenderFormObj->renderHiddenInput("formGenericData[mode]",		$processTarget)
	. $bts->RenderFormObj->renderHiddenInput("formTarget1[name]", 			$currentUserObj->getUserEntry('user_name'))
	. $bts->RenderFormObj->renderHiddenInput("userForm[selectionId]",		$currentUserObj->getUserEntry('user_id'))
	. "<p>\r";

// --------------------------------------------------------------------------------------------
$l = 1;
$T['Content'][$curTab][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l1c1');
$T['Content'][$curTab][$l]['2']['cont'] = $currentUserObj->getUserEntry('user_id');
$l++;

$T['Content'][$curTab][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l2c1');
$l++;

$T['Content'][$curTab][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l3c1');
$l++;

$T['Content'][$curTab][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l4c1');
$infos['IconSelectFile'] = $FileSelectorConfig;
$CurrentSetObj->setDataSubEntry('fs', $CurrentSetObj->getDataEntry('fsIdx'), $FileSelectorConfig);
$CurrentSetObj->setDataEntry('fsIdx', $CurrentSetObj->getDataEntry('fsIdx') + 1);
$T['Content'][$curTab][$l]['2']['cont'] = $bts->InteractiveElementsObj->renderIconSelectFile($infos);
$l++;

$T['Content'][$curTab][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l5c1');
$T['Content'][$curTab][$l]['2']['cont'] = $bts->TimeObj->timestampToDate($currentUserObj->getUserEntry('user_subscription_date'));
$l++;

$T['Content'][$curTab][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l6c1');
$T['Content'][$curTab][$l]['2']['cont'] = "<textarea name='formParams[user_admin_comment]' cols='50' rows='5'>" . $currentUserObj->getUserEntry('user_admin_comment') . "</textarea>";
$l++;

$FileSelectorConfig = array_merge(
	$bts->InteractiveElementsObj->getDefaultIconSelectFileConfig(
		"userForm",
		"formParams[user_avatar_image]",
		25,
		$currentUserObj->getUserEntry('user_avatar_image'),
		"/websites-data/" . $WebSiteObj->getWebSiteEntry('ws_directory') . "/data/images/avatars/",
		"/websites-data/" . $WebSiteObj->getWebSiteEntry('ws_directory') . "/data/images/avatars/",
		"t5l8c2",
	),
	array(
		"strAdd"			=> "..",
		"displayType"		=> "imageMosaic",
		// "strRemove"			=> "/.*\/websites-data\/.*\//",
		"strRemove"			=> "",

	)
);

$T['ContentCfg']['tabs'][$curTab] = $bts->RenderTablesObj->getDefaultTableConfig(6, 2, 2);

// --------------------------------------------------------------------------------------------
$curTab++;

$bts->LMObj->logDebug($currentUserObj, 'currentUserObj');

$l = 1;
$T['Content'][$curTab][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t2l2c1');
$T['Content'][$curTab][$l]['2']['cont'] = $bts->RenderFormObj->renderMenuSelect(array(
	'name' => 'formParams1[status]',
	'defaultSelected' => $currentUserObj->getUserEntry('user_status'),
	'options' => $tab['state'],
));
$l++;

$T['Content'][$curTab][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t2l3c1');
$T['Content'][$curTab][$l]['2']['cont'] = $bts->RenderFormObj->renderMenuSelect(array(
	'name' => 'formParams1[role_function]',
	'defaultSelected' => $currentUserObj->getUserEntry('user_role_function'),
	'options' => $tab['role'],
));
$l++;

$T['ContentCfg']['tabs'][$curTab] = $bts->RenderTablesObj->getDefaultTableConfig(2, 2, 2);

// --------------------------------------------------------------------------------------------
$curTab++;

$T['ContentCfg']['tabs'][$curTab] = $bts->RenderTablesObj->getDefaultTableConfig($l - 1, 2, 2);

// --------------------------------------------------------------------------------------------
$curTab++;
$l = 1;
$T['Content'][$curTab][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5l1c1');
$T['Content'][$curTab][$l]['2']['cont'] = $bts->RenderFormObj->renderMenuSelect(array(
	'name' => 'formParams1[lang]',
	'defaultSelected' => $currentUserObj->getUserEntry('user_lang'),
	'options' => $tabLanguage,
));
$l++;

$T['Content'][$curTab][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5l2c1');
$T['Content'][$curTab][$l]['2']['cont'] = $bts->TimeObj->timestampToDate($currentUserObj->getUserEntry('user_last_visit'));
$l++;

$T['Content'][$curTab][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5l3c1');
$T['Content'][$curTab][$l]['2']['cont'] = $currentUserObj->getUserEntry('user_last_ip');
$l++;

$T['Content'][$curTab][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5l4c1');
$T['Content'][$curTab][$l]['2']['cont'] = $timezone[$currentUserObj->getUserEntry('user_timezone')];
$l++;

$T['ContentCfg']['tabs'][$curTab] = $bts->RenderTablesObj->getDefaultTableConfig($l -1, 2, 2);

// --------------------------------------------------------------------------------------------
$curTab++;
$l = 1;

$T['Content'][$curTab][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t6l1c1');
$T['Content'][$curTab][$l]['2']['cont'] = $bts->RenderFormObj->renderMenuSelect(array(
	'name' => 'formParams1[pref_theme]',
	'defaultSelected' => $currentUserObj->getUserEntry('user_pref_theme'),
	'options' => $tabTheme,
));
$l++;

$T['Content'][$curTab][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t6l2c1');
$T['Content'][$curTab][$l]['2']['cont'] = $bts->RenderFormObj->renderMenuSelect(array(
	'name' => 'formParams1[pref_newsletter]',
	'defaultSelected' => $currentUserObj->getUserEntry('user_pref_newsletter'),
	'options' => $tab['yesno'],
));
$l++;

$T['Content'][$curTab][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t6l3c1');
$T['Content'][$curTab][$l]['2']['cont'] = $bts->RenderFormObj->renderMenuSelect(array(
	'name' => 'formParams1[pref_show_email]',
	'defaultSelected' => $currentUserObj->getUserEntry('user_pref_show_email'),
	'options' => $tab['yesno'],
));
$l++;

$T['Content'][$curTab][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t6l4c1');
$T['Content'][$curTab][$l]['2']['cont'] = $bts->RenderFormObj->renderMenuSelect(array(
	'name' => 'formParams1[pref_show_online_status]',
	'defaultSelected' => $currentUserObj->getUserEntry('user_pref_show_online_status'),
	'options' => $tab['yesno'],
));
$l++;

$T['ContentCfg']['tabs'][$curTab] = $bts->RenderTablesObj->getDefaultTableConfig($l -1, 2, 2);

// --------------------------------------------------------------------------------------------
//
//	Display
//
//
// --------------------------------------------------------------------------------------------
$T['ContentInfos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, 10, 5);
$Content .= $bts->RenderTablesObj->render($infos, $T);

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('Template');
$TemplateObj = Template::getInstance();
$infos['formName'] = "userForm";
$Content .= $TemplateObj->renderAdminFormButtons($infos);

$bts->segmentEnding(__METHOD__);
/*JanusEngine-Content-End*/
