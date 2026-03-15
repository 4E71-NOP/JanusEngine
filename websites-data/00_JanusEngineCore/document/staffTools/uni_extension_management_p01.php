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

// --------------------------------------------------------------------------------------------
/*JanusEngine-Content-Begin*/
$bts->mapSegmentLocation(__METHOD__, "uni_extension_management_p01");

$bts->I18nTransObj->getI18nTransFromDB("uni_extension_management");
$bts->I18nTransObj->getI18nTransFromFile($CurrentSetObj->ServerInfosObj->getServerInfosEntry('DOCUMENT_ROOT') . "/websites-data/00_JanusEngineCore/document/staffTools/i18n/uni_extension_management_p01_");

$Content .= $bts->I18nTransObj->getI18nTransEntry('invite1') . "<br>\r<br>\r";

// --------------------------------------------------------------------------------------------
$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : GroupTag=" . $CurrentSetObj->UserObj->getUserEntry('group_tag')));

// Will be replaced by a proper user permission management.
$permissionOnExtenssion = 0;
$groupList = $CurrentSetObj->UserObj->getGroupList();
// $bts->LMObj->msgLog ( array ('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ ." : GroupList=" . $bts->StringFormatObj->arrayToString($groupList) ));
foreach ($groupList as $A) {
	if ($A['group_tag'] == 3) {
		$permissionOnExtenssion = 1;
	}
}

if ($permissionOnExtenssion == 1) {
	$extensionList = array();
	$extensions_ = array();
	$handle = opendir("extensions/");
	while (false !== ($file = readdir($handle))) {
		if ($file != "." && $file != ".." && !is_file("extensions/" . $file)) {
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : found extension '" . $file . "'"));
			$extensionList[] = $file;
		}
	}

	unset($A);
	$i = 0;
	foreach ($extensionList as $A) {
		$B = "extensions/" . $A . "/extension_config.php";
		if (file_exists($B)) {
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : loading file '" . $B . "'"));
			include($B);
			if (is_array($extension_info)) {
				$extensions_['data'][$i] = $extension_info;
				$extensions_['data'][$i]['ext_directory'] = $A;
				$extensions_['data'][$i]['command'] = "installExtension";
			}
		} else {
			$extensions_['data'][$i]['notFound'] = 1;
		}
		$i++;
	}

	unset($A);
	foreach ($extensions_['data'] as &$A) {
		if ($A['notFound'] != 1) {
			$dbquery = $bts->SDDMObj->query("
			SELECT e.* 
			FROM " . $SqlTableListObj->getSQLTableName('extension') . " e 
			WHERE e.fk_ws_id = '" . $WebSiteObj->getWebSiteEntry('ws_id') . "' 
			AND e.ext_name = '" . $A['ext_name'] . "'
			;");
			if ($bts->SDDMObj->num_row_sql($dbquery) != 0) {
				$A['ext_state'] = 1;
				$A['commmand'] = "uninstallExtension";
			}
		}
	}

	unset($A);
	$i = 1;
	$T['Content']['1'][$i]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('col_1_txt');
	$T['Content']['1'][$i]['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('col_2_txt');
	$T['Content']['1'][$i]['3']['cont'] = $bts->I18nTransObj->getI18nTransEntry('col_3_txt');
	foreach ($extensions_['data'] as $A) {
		$cell2 = "";
		if ($A['notFound'] != 1) {
			$i++;
			$T['Content']['1'][$i]['1']['cont'] = $A['ext_name'];
			$T['Content']['1'][$i]['2']['cont'] = $A['ext_version'];
		}
		$SB = $bts->InteractiveElementsObj->getDefaultSubmitButtonConfig(
			$infos,
			'submit',
			$bts->I18nTransObj->getI18nTransEntry('state' . $A['ext_state']),
			128,
			($A['ext_state'] == 0) ? "enableButton" . $A['ext_name'] : "disableButton" . $A['ext_name'],
			($A['ext_state'] == 0) ? 1 : 3,
			($A['ext_state'] == 0) ? 1 : 3,
			""
		);

		if ($A['ext_state'] == 1) {
			$cell2 = "<td>\r"
			. $bts->RenderFormObj->renderCheckbox("formGenericData[totalCleanup]", 0, $bts->I18nTransObj->getI18nTransEntry('totalCleanup'))
			."</td>\r";
		}

		$T['Content']['1'][$i]['3']['cont'] = "<table class='mt_bareTable'>\r<tr>\r<td>\r"
			. $bts->RenderFormObj->renderformHeader('WebsiteForm')
			. $bts->RenderFormObj->renderHiddenInput("formSubmitted",					"1")
			. $bts->RenderFormObj->renderHiddenInput("formGenericData[origin]",			"AdminDashboard")
			. $bts->RenderFormObj->renderHiddenInput("formGenericData[section]",		"AdminExtensionManagement")
			. $bts->RenderFormObj->renderHiddenInput("formGenericData[action]",			$A['command'])
			. $bts->RenderFormObj->renderHiddenInput("formGenericData[ext_name]",		$A['ext_name'])
			. $bts->RenderFormObj->renderHiddenInput("formGenericData[ext_directory]",	$A['ext_directory'])
			. $bts->InteractiveElementsObj->renderSubmitButton($SB)
			. "</form>\r"
			. "</td>\r"
			. $cell2 
			. "</tr>\r"
			. "</table>\r"
			;

	}

	// --------------------------------------------------------------------------------------------
	//
	//	Display
	//
	//
	// --------------------------------------------------------------------------------------------
	$T['ContentInfos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, 15);
	$T['ContentCfg']['tabs'] = array(
		1 => $bts->RenderTablesObj->getDefaultTableConfig($i, 3, 1),
	);
	$Content .= $bts->RenderTablesObj->render($infos, $T);
} else {
	$Content .= "!!!!!!!!!!!!!!!!";
}

$bts->segmentEnding(__METHOD__);
/*JanusEngine-Content-End*/

?>