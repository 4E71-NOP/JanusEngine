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
	'formConsole',
	array(
		"CLiContent" => "show users",
		"CLiContentResult" => array(
			"1" => array(
				"1" => array("Name" => "redacteur_en_chef_debutant", "Login" => "redacteur_en_chef_debutant", "Subscription" => "2025-03-19 12:41:23", "Status" => "1", "Last visit" => "1970-01-01 00:00:00", "Last IP" => "0.0.0.0"),
				"2" => array("Name" => "anonymous", "Login" => "anonymous", "Subscription" => "2025-03-19 12:41:23", "Status" => "1", "Last visit" => "1970-01-01 00:00:00", "Last IP" => "0.0.0.0"),
				"3" => array("Name" => "admin_confirme", "Login" => "admin_confirme", "Subscription" => "2025-03-19 12:41:23", "Status" => "1", "Last visit" => "1970-01-01 00:00:00", "Last IP" => "0.0.0.0"),
				"4" => array("Name" => "validateur_confirme", "Login" => "validateur_confirme", "Subscription" => "2025-03-19 12:41:23", "Status" => "1", "Last visit" => "1970-01-01 00:00:00", "Last IP" => "0.0.0.0"),
				"5" => array("Name" => "auteur_confirme", "Login" => "auteur_confirme", "Subscription" => "2025-03-19 12:41:23", "Status" => "1", "Last visit" => "1970-01-01 00:00:00", "Last IP" => "0.0.0.0"),
				"6" => array("Name" => "correcteur_debutant", "Login" => "correcteur_debutant", "Subscription" => "2025-03-19 12:41:23", "Status" => "1", "Last visit" => "1970-01-01 00:00:00", "Last IP" => "0.0.0.0"),
				"7" => array("Name" => "chef_de_rubrique_senior", "Login" => "chef_de_rubrique_senior", "Subscription" => "2025-03-19 12:41:23", "Status" => "1", "Last visit" => "1970-01-01 00:00:00", "Last IP" => "0.0.0.0"),
				"8" => array("Name" => "Lecteur", "Login" => "Lecteur", "Subscription" => "2025-03-19 12:41:23", "Status" => "1", "Last visit" => "1970-01-01 00:00:00", "Last IP" => "0.0.0.0"),
				"9" => array("Name" => "redacteur_en_chef_confirme", "Login" => "redacteur_en_chef_confirme", "Subscription" => "2025-03-19 12:41:23", "Status" => "1", "Last visit" => "1970-01-01 00:00:00", "Last IP" => "0.0.0.0"),
				"10" => array("Name" => "admin_debutant", "Login" => "admin_debutant", "Subscription" => "2025-03-19 12:41:23", "Status" => "1", "Last visit" => "1970-01-01 00:00:00", "Last IP" => "0.0.0.0"),
				"11" => array("Name" => "auteur_senior", "Login" => "auteur_senior", "Subscription" => "2025-03-19 12:41:23", "Status" => "1", "Last visit" => "1970-01-01 00:00:00", "Last IP" => "0.0.0.0"),
				"12" => array("Name" => "correcteur_senior", "Login" => "correcteur_senior", "Subscription" => "2025-03-19 12:41:23", "Status" => "1", "Last visit" => "1970-01-01 00:00:00", "Last IP" => "0.0.0.0"),
				"13" => array("Name" => "redacteur_en_chef_senior", "Login" => "redacteur_en_chef_senior", "Subscription" => "2025-03-19 12:41:23", "Status" => "1", "Last visit" => "1970-01-01 00:00:00", "Last IP" => "0.0.0.0"),
				"14" => array("Name" => "admin_forum_confirme", "Login" => "admin_forum_confirme", "Subscription" => "2025-03-19 12:41:23", "Status" => "1", "Last visit" => "1970-01-01 00:00:00", "Last IP" => "0.0.0.0"),
				"15" => array("Name" => "correcteur_confirme", "Login" => "correcteur_confirme", "Subscription" => "2025-03-19 12:41:23", "Status" => "1", "Last visit" => "1970-01-01 00:00:00", "Last IP" => "0.0.0.0"),
				"16" => array("Name" => "chef_de_rubrique_confirme", "Login" => "chef_de_rubrique_confirme", "Subscription" => "2025-03-19 12:41:23", "Status" => "1", "Last visit" => "1970-01-01 00:00:00", "Last IP" => "0.0.0.0"),
				"17" => array("Name" => "admin_senior", "Login" => "admin_senior", "Subscription" => "2025-03-19 12:41:23", "Status" => "1", "Last visit" => "1970-01-01 00:00:00", "Last IP" => "0.0.0.0"),
				"18" => array("Name" => "dev_confirme", "Login" => "dev_confirme", "Subscription" => "2025-03-19 12:41:23", "Status" => "1", "Last visit" => "1970-01-01 00:00:00", "Last IP" => "0.0.0.0"),
				"19" => array("Name" => "chef_de_rubrique_debutant", "Login" => "chef_de_rubrique_debutant", "Subscription" => "2025-03-19 12:41:23", "Status" => "1", "Last visit" => "1970-01-01 00:00:00", "Last IP" => "0.0.0.0"),
				"20" => array("Name" => "dev_debutant", "Login" => "dev_debutant", "Subscription" => "2025-03-19 12:41:23", "Status" => "1", "Last visit" => "1970-01-01 00:00:00", "Last IP" => "0.0.0.0"),
				"21" => array("Name" => "dbadmin", "Login" => "dbadmin", "Subscription" => "2025-03-19 12:41:14", "Status" => "1", "Last visit" => "1970-01-01 00:00:00", "Last IP" => "0.0.0.0"),
				"22" => array("Name" => "auteur_debutant", "Login" => "auteur_debutant", "Subscription" => "2025-03-19 12:41:23", "Status" => "1", "Last visit" => "1970-01-01 00:00:00", "Last IP" => "0.0.0.0"),
				"23" => array("Name" => "dev_senior", "Login" => "dev_senior", "Subscription" => "2025-03-19 12:41:23", "Status" => "1", "Last visit" => "1970-01-01 00:00:00", "Last IP" => "0.0.0.0"),
				"24" => array("Name" => "validateur_senior", "Login" => "validateur_senior", "Subscription" => "2025-03-19 12:41:23", "Status" => "1", "Last visit" => "1970-01-01 00:00:00", "Last IP" => "0.0.0.0"),
				"25" => array("Name" => "O'Brian", "Login" => "O'Brian", "Subscription" => "2025-03-19 12:41:23", "Status" => "1", "Last visit" => "1970-01-01 00:00:00", "Last IP" => "0.0.0.0"),
				"26" => array("Name" => "admin_forum_debutant", "Login" => "admin_forum_debutant", "Subscription" => "2025-03-19 12:41:23", "Status" => "1", "Last visit" => "1970-01-01 00:00:00", "Last IP" => "0.0.0.0"),
				"27" => array("Name" => "admin_forum_senior", "Login" => "admin_forum_senior", "Subscription" => "2025-03-19 12:41:23", "Status" => "1", "Last visit" => "1970-01-01 00:00:00", "Last IP" => "0.0.0.0"),
				"28" => array("Name" => "validateur_debutant", "Login" => "validateur_debutant", "Subscription" => "2025-03-19 12:41:23", "Status" => "1", "Last visit" => "1970-01-01 00:00:00", "Last IP" => "0.0.0.0"),
				"29" => array("Name" => "dieu", "Login" => "dieu", "Subscription" => "2025-03-19 12:41:23", "Status" => "1", "Last visit" => "2025-03-19 12:48:35", "Last IP" => "192.168.1.52")
			)
		),
	)
);

/*JanusEngine-Content-Begin*/
$bts->mapSegmentLocation(__METHOD__, "uni_command_console_p01");

$bts->I18nTransObj->getI18nTransFromDB("uni_command_console");
$bts->I18nTransObj->getI18nTransFromFile($CurrentSetObj->ServerInfosObj->getServerInfosEntry('DOCUMENT_ROOT') . "/websites-data/00_JanusEngineCore/document/staffTools/i18n/uni_command_console_p01_");

// --------------------------------------------------------------------------------------------
//	Affichage
// --------------------------------------------------------------------------------------------
if ($bts->CMObj->getConfigurationSubEntry('functions', 'commandLineEngine') == 'enabled') {
	$Content .= "<form ACTION='index.php?' method='post' name='formConsole'>\r";
	// --------------------------------------------------------------------------------------------
	//	Tab CLI mode
	$Tab = 1;
	$T = array();
	$BlockT = $infos['blockT'];

	// --------------------------------------------------------------------------------------------
	// Formatting results (if any)

	$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . "**************************************************************"));
	$bts->LMObj->msgLog(array(
		'level' => LOGLEVEL_BREAKPOINT,
		'msg' => __METHOD__ . " : CLiContentResult " .
			$bts->StringFormatObj->arrayToString(
				$bts->RequestDataObj->getRequestDataSubEntry('formConsole', 'CLiContentResult')
			)
			. "`"
	));
	$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . "**************************************************************"));

	$resultData = $bts->RequestDataObj->getRequestDataSubEntry('formConsole', 'CLiContentResult');
	$strResult = "Empty";
	if (is_array($resultData)) {
		$strResult = "";
		foreach ($resultData as $RDCmd) {
			$strResult .= "<table class='" . $Block . _CLASS_TABLE01_ . "' style='width:90%;'>\r";
			$i = 1;
			foreach ($RDCmd as $RDPayload) {
				if ($i == 1) {
					$tmpCol = $RDPayload;
					$strResult .= "<tr>\r";
					foreach ($tmpCol as $A => $B) {
						$strResult .= "<td>" . $A . "</td>\r";
					}
					$strResult .= "</tr>\r";
					unset($A, $B);
					$i++;
				}
				$strResult .= "<tr>\r";
				foreach ($RDPayload as $A => $B) {
					$strResult .= "<td>" . $B . "</td>\r";
				}
				$strResult .= "</tr>\r";
			}
			$strResult .= "</table>\r<br>\r<hr>\r<br>\r";
		}
	}

	// --------------------------------------------------------------------------------------------
	$SB = $bts->InteractiveElementsObj->getDefaultSubmitButtonConfig(
		$infos,
		"button",
		$bts->I18nTransObj->getI18nTransEntry('btnCopy'),
		192,
		"T01submitButton",
		1,
		1,
		"document.forms['formConsole'].elements['formConsole[CLiContent]'].value = '" . $bts->StringFormatObj->escapeQuotes( $bts->RequestDataObj->getRequestDataSubEntry('formConsole', 'CLiContent')) . "';",
		1
	);

	$baretable = $CurrentSetObj->ThemeDataObj->getThemeName() . "bareTable";

	$l = 1;
	$T['Content'][$Tab][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('cmd_l1');
	$l++;
	$T['Content'][$Tab][$l]['1']['cont'] = "<table class='" . $baretable . "' style='width:100%' style='margin-left:auto; margin-right:auto;'>"
		. "<tr class='" . $baretable . "'>"
		. "<td class='" . $baretable . "' style='width:70%'>" . $bts->RequestDataObj->getRequestDataSubEntry('formConsole', 'CLiContent'). "</td>"
		. "<td class='" . $baretable . "'>" . $bts->InteractiveElementsObj->renderSubmitButton($SB) . "</td>"
		. "</tr>"
		. "</table>";
	$l++;


	$SB = $bts->InteractiveElementsObj->getDefaultSubmitButtonConfig(
		$infos,
		"submit",
		$bts->I18nTransObj->getI18nTransEntry('btnCmd'),
		192,
		"T02submitButton",
		1,
		2,
		"",
		1
	);
	$T['Content'][$Tab][$l]['1']['cont'] = "<table class='" . $baretable . "' style='width:100%' style='margin-left:auto; margin-right:auto;'>"
		. "<tr class='" . $baretable . "'>"
		. "<td class='" . $baretable . "' style='width:70%'>" . $bts->I18nTransObj->getI18nTransEntry('cmd_CmdToExec') . "<br>\r"
		. "<textarea name='formConsole[CLiContent]' style='width:100%; height:100%;' rows='3'></textarea>" . "</td>"
		. "<td class='" . $baretable . "'>" . $bts->InteractiveElementsObj->renderSubmitButton($SB) . "</td>"
		. "</tr>"
		. "</table>";
	$l++;

	// --------------------------------------------------------------------------------------------
	// File mode
	$FileSelectorConfig = $bts->InteractiveElementsObj->getDefaultIconSelectFileConfig(
		"formConsole",
		"formConsole[inputFile]",
		60,
		$formInputFile,
		$WebSiteObj->getWebSiteEntry('ws_directory') . "/document",
		"websites-data",
		"buttonCommandConsole",
	);
	$FileSelectorConfig['strRemove'] = "";
	$FileSelectorConfig['strAdd'] = "../";
	$FileSelectorConfig['case'] = 3;

	$infos['IconSelectFile'] = $FileSelectorConfig;
	$CurrentSetObj->setDataSubEntry('fs', $CurrentSetObj->getDataEntry('fsIdx'), $FileSelectorConfig);
	$CurrentSetObj->setDataEntry('fsIdx', $CurrentSetObj->getDataEntry('fsIdx') + 1);

	$SB = $bts->InteractiveElementsObj->getDefaultSubmitButtonConfig(
		$infos,
		"submit",
		$bts->I18nTransObj->getI18nTransEntry('btnFile'),
		192,
		"T03submitButton",
		1,
		2,
		"",
		1
	);
	$T['Content'][$Tab][$l]['1']['cont'] = "<table class='" . $baretable . "' style='width:100%' style='margin-left:auto; margin-right:auto;'>"
		. "<tr class='" . $baretable . "'>"
		. "<td class='" . $baretable . "' style='width:70%'>" . $bts->I18nTransObj->getI18nTransEntry('file_select')
		. $bts->InteractiveElementsObj->renderIconSelectFile($infos) . "<br>\r"
		. $bts->I18nTransObj->getI18nTransEntry('file_info')
		. "</td>"
		. "<td class='" . $baretable . "'>"
		. $bts->InteractiveElementsObj->renderSubmitButton($SB) . "</td>"
		. "</tr>"
		. "</table>";
	$l++;

	// --------------------------------------------------------------------------------------------
	// Results
	$T['Content'][$Tab][$l]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('cmd_result') . "<br>\r" . $strResult;

	// --------------------------------------------------------------------------------------------
	//	Tab Logs
	$Tab = 2;

	$T['Content'][$Tab]['1']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('Logs_c1');
	$T['Content'][$Tab]['1']['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('Logs_c2');
	$T['Content'][$Tab]['1']['3']['cont'] = $bts->I18nTransObj->getI18nTransEntry('Logs_c3');
	$T['Content'][$Tab]['1']['4']['cont'] = $bts->I18nTransObj->getI18nTransEntry('Logs_c4');
	$T['Content'][$Tab]['1']['5']['cont'] = $bts->I18nTransObj->getI18nTransEntry('Logs_c5');
	$T['Content'][$Tab]['1']['6']['cont'] = $bts->I18nTransObj->getI18nTransEntry('Logs_c6');
	$T['Content'][$Tab]['1']['7']['cont'] = $bts->I18nTransObj->getI18nTransEntry('Logs_c7');

	$tab = array(
		0 => "<span class='" . $Block . "_error'>Erreur</span>",
		1 => "<span class='" . $Block . "_ok " . $Block . "_t1'>OK</span>",
		2 => "<span class='" . $Block . "_warning'>Avertissement</span>",
		3 => "Information",
		4 => "Autre",
	);

	$dbquery = $bts->SDDMObj->query("
	SELECT *
	FROM " . $SqlTableListObj->getSQLTableName('log') . "
	WHERE fk_ws_id = '" . $WebSiteObj->getWebSiteEntry('ws_id') . "'
	ORDER BY log_id DESC
	LIMIT 10
	;");


	$l = 2;
	while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
		$log_action_longeur = strlen($dbp['log_action'] ?? '');
		switch (TRUE) {
			case ($log_action_longeur < 128 && $log_action_longeur > 64):
				$dbp['log_action'] = substr($dbp['log_action'], 0, 59) . " [...] ";
				break;
			case ($log_action_longeur > 128):
				$dbp['log_action'] = substr($dbp['log_action'], 0, 59) . " [...] " . substr($dbp['log_action'], ($log_action_longeur - 64), $log_action_longeur);
				break;
		}
		$T['Content'][$Tab][$l]['1']['cont'] = $dbp['log_id'];
		$T['Content'][$Tab][$l]['2']['cont'] = date("Y m d H:i:s", $dbp['log_date']);
		$T['Content'][$Tab][$l]['3']['cont'] = $dbp['log_initiator'];
		$T['Content'][$Tab][$l]['4']['cont'] = $dbp['log_action'];
		$T['Content'][$Tab][$l]['5']['cont'] = $tab[$dbp['log_signal']];
		$T['Content'][$Tab][$l]['6']['cont'] = $dbp['log_msgid'];
		$T['Content'][$Tab][$l]['7']['cont'] = $dbp['log_contenu'];

		$l++;
	}
	$T['ContentCfg']['tabs'][$Tab]['NbrOfLines'] = 10;
	$T['ContentCfg']['tabs'][$Tab]['NbrOfCells'] = 7;
	$T['ContentCfg']['tabs'][$Tab]['TableCaptionPos'] = 1;

	// --------------------------------------------------------------------------------------------
	//	Tab Help
	$Tab = 3;

	$T['Content'][$Tab]['1']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('help01');
	$T['ContentCfg']['tabs'][$Tab]['NbrOfLines'] = 1;
	$T['ContentCfg']['tabs'][$Tab]['NbrOfCells'] = 1;
	$T['ContentCfg']['tabs'][$Tab]['TableCaptionPos'] = 0;


	// --------------------------------------------------------------------------------------------
	$T['ContentInfos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, 15, 3);

	$T['ContentCfg']['tabs'] = array(
		1 => $bts->RenderTablesObj->getDefaultTableConfig(6, 1, 1),
		2 => $bts->RenderTablesObj->getDefaultTableConfig(10, 7, 1),
		3 => $bts->RenderTablesObj->getDefaultTableConfig(1, 1, 0),
	);
	$Content .= $bts->RenderTablesObj->render($infos, $T);

	$ClassLoaderObj->provisionClass('SecurityToken');
	$SecurityTokenObj = new SecurityToken();
	$SecurityTokenObj->createTokenContent();
	$SecurityTokenObj->setSecurityTokenEntry('st_id', $bts->SDDMObj->createUniqueId());
	$SecurityTokenObj->setSecurityTokenEntry('st_action', 'commandConsoleForm');
	$SecurityTokenObj->setSecurityTokenEntry('st_login', $CurrentSetObj->UserObj->getUserEntry('user_login'));
	$SecurityTokenObj->sendToDB();

	$Content .=
		$bts->RenderFormObj->renderformHeader('ConsoleCommandForm')
		. $bts->RenderFormObj->renderHiddenInput("formSubmitted", "1")
		. $bts->RenderFormObj->renderHiddenInput("formGenericData[origin]", "AdminDashboard")
		. $bts->RenderFormObj->renderHiddenInput("formGenericData[section]", "CommandConsole")
		. $bts->RenderFormObj->renderHiddenInput("formGenericData[token]", $SecurityTokenObj->getSecurityTokenEntry('st_content'))
	;

	$Content .= "</form>\r";

} else {
	$bts->LMObj->msgLog(array('level' => LOGLEVEL_WARNING, 'msg' => __METHOD__ . " Somebody is trying to use console while it is disabled."));
	$Content .= "<table style='margin-right: auto; margin-left: auto'>\r"
		. "<tr>\r<td style='padding:15px;'>"
		. "<img width='64' heigth='64' src='" . $CurrentSetObj->ServerInfosObj->getServerInfosEntry('base_url') . "media/theme/" . $ThemeDataObj->getThemeBlockEntry($infos['blockT'], 'directory') . "/" . $ThemeDataObj->getThemeBlockEntry($infos['blockT'], 'icon_nok') . "'>"
		. "</td>\r"
		. "<td style='padding:15px;'>"
		. $bts->I18nTransObj->getI18nTransEntry('inviteErr')
		. "</td>\r</tr>\r"
		. "</table>\r";
}

$bts->segmentEnding(__METHOD__);

// --------------------------------------------------------------------------------------------

/*JanusEngine-Content-End*/
