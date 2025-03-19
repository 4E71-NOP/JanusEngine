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
		"CLiContent"		=> "show user",
		"CLiContentResult"	=> array(
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

$bts->I18nTransObj->apply(
	array(
		"type" => "array",
		"fra" => array(
			"inviteErr"		=>	"Ce site ne permet pas l'utilisation de la console de commandes.'",
			"tabTxt1"		=> "Mode CLI",
			"tabTxt2"		=> "Mode fichier",
			"tabTxt3"		=> "Résultats",
			"tabTxt4"		=> "Journaux",
			"tabTxt5"		=> "Aide",
			"col_1_txt"		=> "Nom",
			"col_2_txt"		=> "Etat",
			"col_3_txt"		=> "Date",
			"raf1"			=> "Rien à afficher",
			"btn1"			=> "Soumettre",
			"cmd_l1"		=> "Dernier tampon de commande",
			"cmd_result"	=> "Résultat",
			"cmd_CmdToExec"	=> "Commande à exécuter",
			"file_select"	=> "Sélectionnez un fichier",
			"file_info"		=> "Si un fichier est sélectionné, il prendra la priorité. Seul le contenu du fichier sera exécuté.",
			"help01"		=> "Utilisez '<b>;</b>' comme separateur.<br>\r
			<br>\r
			Les entitées sont les suivantes : website, user, group, deadline, document, article, menu, module, decoration, keyword.<br>\r
			<br>\r
			<span style='text-decoration: underline;'>Liste de commandes basiques:</span>
			<ul>
			<li>show &lt;<i>ENTITÉ<b>S</b></i>&gt;; Affiche la liste du type donné.</li>
			<li>show &lt;<i>ENTITÉ</i>&gt; name '<i>myEntity</i>'; Affiche les détails de l'élément de l'entité donnée.</li>
			</ul>
			",
			"Logs_c1"			=> "N",
			"Logs_c2"			=> "Date",
			"Logs_c3"			=> "Initiateur",
			"Logs_c4"			=> "Action",
			"Logs_c5"			=> "Signal",
			"Logs_c6"			=> "Message ID",
			"Logs_c7"			=> "Message",
		),
		"eng" => array(
			"inviteErr"		=>	"This website does not allow the use of command console.'",
			"tabTxt1"		=> "Command",
			"tabTxt2"		=> "File mode",
			"tabTxt3"		=> "Results",
			"tabTxt4"		=> "Logs",
			"tabTxt5"		=> "Help",
			"col_1_txt"		=> "Name",
			"col_2_txt"		=> "Status",
			"col_3_txt"		=> "Date",
			"raf1"			=> "Nothing to display",
			"btn1"			=> "Submit",
			"cmd_l1"		=> "Last buffer",
			"cmd_result"	=> "Result",
			"cmd_CmdToExec"	=> "Commande à exécuter",
			"file_select"	=> "Select a file",
			"file_info"		=> "If a file is selected, it will take over the console box. Only the file content will be executed.",
			"help01"		=> "Use '<b>;</b>' as separator.<br>\r
			<br>\r
			Entities are as follow : website, user, group, deadline, document, article, menu, module, decoration, keyword.<br>\r
			<br>\r
			<span style='text-decoration: underline;'>Basic command list:</span>
			<ul>
			<li>show &lt;<i>ENTITIES</i>&gt;; Display the entity list.</li>
			<li>show &lt;<i>ENTITY</i>&gt; name '<i>myEntity</i>'; Display details about this entity.</li>
			</ul>
			",
			"Logs_c1"			=> "N",
			"Logs_c2"			=> "Date",
			"Logs_c3"			=> "Initiator",
			"Logs_c4"			=> "Action",
			"Logs_c5"			=> "Signal",
			"Logs_c6"			=> "Message ID",
			"Logs_c7"			=> "Message",
		)
	)
);

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

	$SB = $bts->InteractiveElementsObj->getDefaultSubmitButtonConfig(
		$infos,
		"submit",
		$bts->I18nTransObj->getI18nTransEntry('btn1'),
		0,
		"T01submitButton",
		2,
		2,
		"",
		0
	);


	// --------------------------------------------------------------------------------------------
	// Formatting results (if any)

	$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . "**************************************************************"));
	$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : CLiContentResult " .
	$bts->StringFormatObj->arrayToString(
		$bts->RequestDataObj->getRequestDataSubEntry('formConsole', 'CLiContentResult')
		)
		. "`"));
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

	$T['Content'][$Tab]['1']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('cmd_l1');
	$T['Content'][$Tab]['2']['1']['cont'] = "<br>\r>>> " . $bts->RequestDataObj->getRequestDataSubEntry('formConsole', 'CLiContent') . "<br>\r&nbsp;";
	$T['Content'][$Tab]['3']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('cmd_CmdToExec');
	$T['Content'][$Tab]['4']['1']['cont'] = "<textarea name='formConsole[CLiContent]' style='width:97%' rows='6'></textarea>";
	$T['Content'][$Tab]['4']['1']['style'] = "text-align:center;";
	$T['Content'][$Tab]['5']['1']['cont'] .= $bts->InteractiveElementsObj->renderSubmitButton($SB);


	$T['ContentCfg']['tabs'][$Tab]['NbrOfLines'] = 5;
	$T['ContentCfg']['tabs'][$Tab]['NbrOfCells'] = 1;
	$T['ContentCfg']['tabs'][$Tab]['TableCaptionPos'] = 1;

	// --------------------------------------------------------------------------------------------
	//	Tab File mode
	$Tab = 2;
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
	$FileSelectorConfig['case'] = 1;

	$infos['IconSelectFile'] = $FileSelectorConfig;
	$CurrentSetObj->setDataSubEntry('fs', $CurrentSetObj->getDataEntry('fsIdx'), $FileSelectorConfig);
	$CurrentSetObj->setDataEntry('fsIdx', $CurrentSetObj->getDataEntry('fsIdx') + 1);

	$SB['id'] = "T02submitButton";
	$T['Content'][$Tab]['1']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('file_select');
	$T['Content'][$Tab]['2']['1']['cont'] = $bts->InteractiveElementsObj->renderIconSelectFile($infos);
	$T['Content'][$Tab]['3']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('file_info');
	$T['Content'][$Tab]['3']['1']['cont'] = $bts->InteractiveElementsObj->renderSubmitButton($SB);
	$T['ContentCfg']['tabs'][$Tab]['NbrOfLines'] = 3;
	$T['ContentCfg']['tabs'][$Tab]['NbrOfCells'] = 1;
	$T['ContentCfg']['tabs'][$Tab]['TableCaptionPos'] = 1;

	// --------------------------------------------------------------------------------------------
	//	Tab Results
	$Tab = 3;

	$T['Content'][$Tab]['1']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('cmd_result');
	$T['Content'][$Tab]['2']['1']['cont'] = $strResult;
	$T['ContentCfg']['tabs'][$Tab]['NbrOfLines'] = 2;
	$T['ContentCfg']['tabs'][$Tab]['NbrOfCells'] = 1;
	$T['ContentCfg']['tabs'][$Tab]['TableCaptionPos'] = 1;

	// --------------------------------------------------------------------------------------------
	//	Tab Logs
	$Tab = 4;

	$T['Content'][$Tab]['1']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('Logs_c1');
	$T['Content'][$Tab]['1']['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('Logs_c2');
	$T['Content'][$Tab]['1']['3']['cont'] = $bts->I18nTransObj->getI18nTransEntry('Logs_c3');
	$T['Content'][$Tab]['1']['4']['cont'] = $bts->I18nTransObj->getI18nTransEntry('Logs_c4');
	$T['Content'][$Tab]['1']['5']['cont'] = $bts->I18nTransObj->getI18nTransEntry('Logs_c5');
	$T['Content'][$Tab]['1']['6']['cont'] = $bts->I18nTransObj->getI18nTransEntry('Logs_c6');
	$T['Content'][$Tab]['1']['7']['cont'] = $bts->I18nTransObj->getI18nTransEntry('Logs_c7');

	$tab = array(
		0	=>	"<span class='" . $Block . "_error'>Erreur</span>",
		1	=>	"<span class='" . $Block . "_ok " . $Block . "_t1'>OK</span>",
		2	=>	"<span class='" . $Block . "_warning'>Avertissement</span>",
		3	=>	"Information",
		4	=>	"Autre",
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
	$Tab = 5;

	$T['Content'][$Tab]['1']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('help01');
	$T['ContentCfg']['tabs'][$Tab]['NbrOfLines'] = 1;
	$T['ContentCfg']['tabs'][$Tab]['NbrOfCells'] = 1;
	$T['ContentCfg']['tabs'][$Tab]['TableCaptionPos'] = 0;


	// --------------------------------------------------------------------------------------------
	$T['ContentInfos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, 15, 5);

	$T['ContentCfg']['tabs'] = array(
		1	=>	$bts->RenderTablesObj->getDefaultTableConfig(5, 1, 1),
		2	=>	$bts->RenderTablesObj->getDefaultTableConfig(3, 1, 1),
		3	=>	$bts->RenderTablesObj->getDefaultTableConfig(2, 1, 1),
		4	=>	$bts->RenderTablesObj->getDefaultTableConfig(10, 7, 1),
		5	=>	$bts->RenderTablesObj->getDefaultTableConfig(1, 1, 0),
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
		. $bts->RenderFormObj->renderHiddenInput("formSubmitted",				"1")
		. $bts->RenderFormObj->renderHiddenInput("formGenericData[origin]",		"AdminDashboard")
		. $bts->RenderFormObj->renderHiddenInput("formGenericData[section]",	"CommandConsole")
		. $bts->RenderFormObj->renderHiddenInput("formGenericData[token]",		$SecurityTokenObj->getSecurityTokenEntry('st_content'))
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
