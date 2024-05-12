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

// --------------------------------------------------------------------------------------------
$bts->RequestDataObj->setRequestData(
	'lmForm',
	array(
		"ok"			=>	"on",
		"avrt"			=>	"on",
		"err"			=>	"on",
		"info"			=>	"on",
		"other"			=>	"on",
		"nbrPerPage"	=>	10,
	)
);
$bts->RequestDataObj->setRequestData('scriptFile', 'uni_recherche_p01.php');

// --------------------------------------------------------------------------------------------
/*Hydr-Content-Begin*/
$localisation = " / uni_log_management_p01";
$bts->MapperObj->AddAnotherLevel($localisation);
$bts->LMObj->logCheckpoint("uni_log_management_p01.php");
$bts->MapperObj->RemoveThisLevel($localisation);
$bts->MapperObj->setSqlApplicant("uni_log_management_p01.php");

$bts->I18nTransObj->apply(
	array(
		"type" => "array",
		"fra" => array(
			"invite1"		=>	"Cette partie va vous permettre de gérer les journaux d'évennement.",
			"col_1_txt"		=>	"Id",
			"col_2_txt"		=>	"Date",
			"col_3_txt"		=>	"Signal",
			"col_4_txt"		=>	"Id Msg",
			"col_5_txt"		=>	"Initiateur",
			"col_6_txt"		=>	"Action",
			"col_7_txt"		=>	"Message",
			"tabTxt1"		=> "Informations",
			"type_err"		=>	"Erreur",
			"type_avrt"		=>	"Avertissement",
			"type_ok"		=>	"Ok",
			"type_info"		=>	"Information",
			"type_autr"		=>	"Autre",
			"t1r1"			=>	"Voir signal",
			"t1r2"			=>	"Entrées par page",
			"t1cap"			=>	"Critères de recherche",
		),
		"eng" => array(
			"invite1"		=>	"This part will allow you to manage Logs.",
			"col_1_txt"		=>	"Id",
			"col_2_txt"		=>	"Date",
			"col_3_txt"		=>	"Signal",
			"col_4_txt"		=>	"Id Msg",
			"col_5_txt"		=>	"Initiator",
			"col_6_txt"		=>	"Action",
			"col_7_txt"		=>	"Message",
			"tabTxt1"		=> "Informations",
			"type_err"		=>	"Error",
			"type_avrt"		=>	"Warning",
			"type_ok"		=>	"Ok",
			"type_info"		=>	"Information",
			"type_autr"		=>	"Other",
			"t1r1"			=>	"View signal",
			"t1r2"			=>	"Entries per page",
			"t1cap"			=>	"Search criteria",
		)
	)
);

// --------------------------------------------------------------------------------------------
//	Realisation des suppresions demandées
// --------------------------------------------------------------------------------------------
if (strlen($bts->RequestDataObj->getRequestDataSubEntry('lmForm', 'action')) != 0) {
	switch ($bts->RequestDataObj->getRequestDataSubEntry('lmForm', 'action')) {
		case "DELETE":
			$DeleteSelection = " WHERE log_id IN (";
			foreach ($bts->RequestDataObj->getRequestDataSubEntry('lmForm', 'selection') as $K => $A) {
				$DeleteSelection .= $K . ", ";
			}
			unset($K, $A);
			$DeleteSelection = substr($DeleteSelection, 0, -2) . ") ";
			$dbquery = $bts->SDDMObj->query("
		DELETE FROM " . $SqlTableListObj->getSQLTableName('log') .
				$DeleteSelection . "
		;");
			break;
	}
}
// --------------------------------------------------------------------------------------------
//	Analysis of display criterias
// --------------------------------------------------------------------------------------------
$criteriaUrl = "";
$ClauseTmp = array();

$CheckClauseType = 0;
if (is_array($bts->RequestDataObj->getRequestDataSubEntry('lmForm', 'clause_type'))) {
	$tabClauseTypes = array("err" => 0, "ok" => 1, "avrt" => 2, "info" => 3, "autr" => 4);

	foreach ($bts->RequestDataObj->getRequestDataSubEntry('lmForm', 'clause_type') as $k => $v) {
		if ($v == "on") {
			$CheckClauseType++;
			$bts->RequestDataObj->setRequestDataSubEntry('lmForm', $k, ' checked ');
			$criteriaUrl .= "&amp;lmForm[clause_type][" . $k . "]=on";
			$criteria2ndPost .= "<input type='hidden' name='lmForm[clause_type][" . $k . "]'	value='on'>\r";
			$ClauseTmp[] = $tabClauseTypes[$k];
		}
	}
}
if ($CheckClauseType == 0) {
	$bts->RequestDataObj->setRequestDataSubEntry('lmForm', 'err', ' checked ');
	$bts->RequestDataObj->setRequestDataSubEntry('lmForm', 'ok', ' checked ');
	$bts->RequestDataObj->setRequestDataSubEntry('lmForm', 'avrt', ' checked ');
}

$ClauseType = "";
if ($CheckClauseType > 0) {
	$ClauseType = " AND log_signal IN (";
	foreach ($ClauseTmp as $B) {
		$ClauseType .= $B . ", ";
	}
	$ClauseType = substr($ClauseType, 0, -2) . ") ";
}
unset($A, $B);

if (strlen($bts->RequestDataObj->getRequestDataSubEntry('lmForm', 'nbr_par_page')) == 0) {
	$bts->RequestDataObj->setRequestDataSubEntry('lmForm', 'nbr_par_page', 10);
}
$criteriaUrl .= "&amp;lmForm[nbr_par_page]=" . $bts->RequestDataObj->getRequestDataSubEntry('lmForm', 'nbr_par_page');
$criteria2ndPost .= "<input type='hidden' name='lmForm[nbr_par_page]'	value='" . $bts->RequestDataObj->getRequestDataSubEntry('lmForm', 'nbr_par_page') . "'>\r";

$Content .= "
<form id='lmForm_001' ACTION='index.php?' method='post'>\r
<input type='hidden' name='lmForm[action]'	value='DISPLAY'>\r";

// --------------------------------------------------------------------------------------------
$T = array();
$Tab = 1;
$lt = 1;

$T['Content'][$Tab][$lt]['1']['colspan'] = 2;
$T['Content'][$Tab][$lt]['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1cap');
// $T['Content'][$Tab][$lt]['2']['cont'] = "";
$lt++;

$T['Content'][$Tab][$lt]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1r1');
$T['Content'][$Tab][$lt]['2']['cont'] = "
<input type='checkbox' name ='lmForm[clause_type][ok]'		class='" . $Block . "_form_1' " . $bts->RequestDataObj->getRequestDataSubEntry('lmForm', 'ok') . ">\r" . $bts->I18nTransObj->getI18nTransEntry('type_ok') . "; \r
<input type='checkbox' name ='lmForm[clause_type][avrt]'	class='" . $Block . "_form_1' " . $bts->RequestDataObj->getRequestDataSubEntry('lmForm', 'avrt') . ">\r" . $bts->I18nTransObj->getI18nTransEntry('type_avrt') . "; \r
<input type='checkbox' name ='lmForm[clause_type][err]'		class='" . $Block . "_form_1' " . $bts->RequestDataObj->getRequestDataSubEntry('lmForm', 'err') . ">\r" . $bts->I18nTransObj->getI18nTransEntry('type_err') . "; \r
<input type='checkbox' name ='lmForm[clause_type][info]'	class='" . $Block . "_form_1' " . $bts->RequestDataObj->getRequestDataSubEntry('lmForm', 'info') . ">\r" . $bts->I18nTransObj->getI18nTransEntry('type_info') . "; \r
<input type='checkbox' name ='lmForm[clause_type][autr]'	class='" . $Block . "_form_1' " . $bts->RequestDataObj->getRequestDataSubEntry('lmForm', 'autr') . ">\r" . $bts->I18nTransObj->getI18nTransEntry('type_autr') . "\r
";
$lt++;

$T['Content'][$Tab][$lt]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1r2');
$T['Content'][$Tab][$lt]['2']['cont'] = $bts->RenderFormObj->renderInputText("lmForm[nbr_par_page]", $bts->RequestDataObj->getRequestDataSubEntry('lmForm', 'nbr_par_page'), "", 15);
// ."<input type='text' name='lmForm[nbr_par_page]' size='15' value='".$bts->RequestDataObj->getRequestDataSubEntry('lmForm', 'nbr_par_page')."' class='" . $Block."_t3 ".$Block."_form_1'>";

// $T['ContentCfg']['tabs'][$Tab]['NbrOfLines'] = $lt;	$T['ContentCfg']['tabs'][$Tab]['NbrOfCells'] = 2;	$T['ContentCfg']['tabs'][$Tab]['TableCaptionPos'] = 1;

$T['ContentInfos']['EnableTabs']	= 0;
$T['ContentInfos']['NbrOfTabs']		= 1;
$T['ContentInfos']['TabBehavior']	= 0;
$T['ContentInfos']['RenderMode']	= 1;
$T['ContentInfos']['HighLightType']	= 0;
$T['ContentInfos']['Height']		= 128;
$T['ContentInfos']['Width']			= $ThemeDataObj->getDefinitionValue('module_internal_width');
$T['ContentInfos']['GroupName']		= "list";
$T['ContentInfos']['CellName']		= "log";
$T['ContentInfos']['DocumentName']	= "doc";
$T['ContentInfos']['cell_1_txt']	= $bts->I18nTransObj->getI18nTransEntry('cell_1_txt');

$T['ContentCfg']['tabs']['1']['NbrOfLines']	= $lt;
$T['ContentCfg']['tabs']['1']['NbrOfCells']	= 2;
$T['ContentCfg']['tabs']['1']['TableCaptionPos']		= 1;

$config = array(
	"mode" => 1,
	"module_display_mode" => "normal",
	"module_z_index" => 2,
	"block" => $infos['block'],
	"blockG" => $infos['block'] . "G",
	"blockT" => $infos['block'] . "T",
	"deco_type" => 50,
	"module" => $infos['module'],
);

$Content .= $bts->RenderTablesObj->render($config, $T) . "<br>\r";

// --------------------------------------------------------------------------------------------

$SB = array(
	"id"				=> "refreshButton",
	"type"				=> "submit",
	"initialStyle"		=> $Block . "_t3 " . $Block . "_submit_s1_n",
	"hoverStyle"		=> $Block . "_t3 " . $Block . "_submit_s1_h",
	"onclick"			=> "",
	"message"			=> $bts->I18nTransObj->getI18nTransEntry('btnRefresh'),
	"mode"				=> 1,
	"size" 				=> 128,
	"lastSize"			=> 0,
);

$Content .= "
	<table style=' width:100%; border-spacing: 3px;'>\r
	<tr>\r
	<td align='right'>\r"
	. $bts->InteractiveElementsObj->renderSubmitButton($SB)
	. "</td>\r</tr>\r</table>\r
<br>\r
</form>\r

<form id='lmForm_002' ACTION='index.php?' method='post'>\r
<input type='hidden' name='lmForm[action]'	value='SUPPRESSION'>\r";

if (strlen($bts->RequestDataObj->getRequestDataSubEntry('lmForm', 'page') == 0)) {
	$bts->RequestDataObj->setRequestDataSubEntry('lmForm', 'page', 0);
}

$dbquery = $bts->SDDMObj->query("
SELECT COUNT(log_id) as nbr_log 
FROM " . $SqlTableListObj->getSQLTableName('log') . " 
WHERE fk_ws_id = '" . $WebSiteObj->getWebSiteEntry('ws_id') . "'
" . $ClauseType .
	$pv['clause_msgid'] . "
;");
while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
	$bts->RequestDataObj->setRequestDataSubEntry('lmForm', 'log_count', $dbp['nbr_log']);
}

if ($bts->RequestDataObj->getRequestDataSubEntry('lmForm', 'log_count') > $bts->RequestDataObj->getRequestDataSubEntry('lmForm', 'nbr_par_page')) {
	$bts->RequestDataObj->setRequestDataSubEntry('lmForm', 'selection_page', "<p style='text-align: center;'>\r --\r");
	$bts->RequestDataObj->setRequestDataSubEntry('lmForm', 'nbr_page', $bts->RequestDataObj->getRequestDataSubEntry('lmForm', 'log_count') / $bts->RequestDataObj->getRequestDataSubEntry('lmForm', 'nbr_par_page'));
	$bts->RequestDataObj->setRequestDataSubEntry('lmForm', 'reste', $bts->RequestDataObj->getRequestDataSubEntry('lmForm', 'log_count') % $bts->RequestDataObj->getRequestDataSubEntry('lmForm', 'nbr_par_page'));
	if ($bts->RequestDataObj->getRequestDataSubEntry('lmForm', 'reste') != 0) {
		$bts->RequestDataObj->setRequestDataSubEntry('lmForm', 'nbr_page', $bts->RequestDataObj->getRequestDataSubEntry('lmForm', 'nbr_page') + 1);
	}
	$bts->RequestDataObj->setRequestDataSubEntry('lmForm', 'compteur_page', 0);
	for ($i = 1; $i <= $bts->RequestDataObj->getRequestDataSubEntry('lmForm', 'nbr_page'); $i++) {
		if ($bts->RequestDataObj->getRequestDataSubEntry('lmForm', 'page') != $bts->RequestDataObj->getRequestDataSubEntry('lmForm', 'compteur_page')) {
			$bts->RequestDataObj->setRequestDataSubEntry('lmForm', 'selection_page', "
			<a class='" . $Block . "_lien' href='index.php?
			lmForm[page]=" . $bts->RequestDataObj->getRequestDataSubEntry('lmForm', 'compteur_page')
				. $criteriaUrl
				. "'>" . $i . "</a> ");
		} else {

			$bts->RequestDataObj->setRequestDataSubEntry('lmForm', 'selection_page', $bts->RequestDataObj->getRequestDataSubEntry('lmForm', 'selection_page') . "<span style='font-weight: bold;'>[" . $i . "]</span> ");
		}
		$bts->RequestDataObj->setRequestDataSubEntry('lmForm', 'compteur_page', $bts->RequestDataObj->getRequestDataSubEntry('lmForm', 'compteur_page') + 1);
	}
	$bts->RequestDataObj->setRequestDataSubEntry('lmForm', 'selection_page', $bts->RequestDataObj->getRequestDataSubEntry('lmForm', 'selection_page') . " --</p>\r");
	$Content .= $bts->RequestDataObj->getRequestDataSubEntry('lmForm', 'selection_page');
}

$dbquery = $bts->SDDMObj->query("
SELECT * 
FROM " . $SqlTableListObj->getSQLTableName('log') . " 
WHERE fk_ws_id = '" . $WebSiteObj->getWebSiteEntry('ws_id') . "'
" . $ClauseType .
	$pv['clause_msgid'] . "
ORDER BY log_date DESC, log_id DESC 
LIMIT " . $bts->RequestDataObj->getRequestDataSubEntry('lmForm', 'nbr_par_page') . " OFFSET " . ($bts->RequestDataObj->getRequestDataSubEntry('lmForm', 'page') * $bts->RequestDataObj->getRequestDataSubEntry('lmForm', 'nbr_par_page'))
	. ";");

$config = array(
	"mode" => 1,
	"module_display_mode" => "normal",
	"module_z_index" => 2,
	"block" => $infos['block'],
	"blockG" => $infos['block'] . "G",
	"blockT" => $infos['block'] . "T",
	"deco_type" => 50,
	"module" => $infos['module'],
);

if ($bts->SDDMObj->num_row_sql($dbquery) == 0) {

	$Tab = 1;
	$lt = 1;
	$T['Content'][$Tab][$lt]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('nothingToDisplay');

	// 	$T['ContentInfos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, 15);
	// 	$T['ContentCfg']['tabs'] = array(
	// 			1	=>	$bts->RenderTablesObj->getDefaultTableConfig($lt,1,1),
	// 	);
	// 	$Content .= $bts->RenderTablesObj->render($infos, $T);

} else {
	$tab = array(
		0 => "<span class='" . $Block . "_erreur'>Erreur</span>",
		1 => "<span class='" . $Block . "_ok " . $Block . "_t1'>OK</span>",
		2 => "<span class='" . $Block . "_avert'>Avertissement</span>",
		3 => "Information",
		4 => "Autre",
	);

	$Tab = 1;
	$lt = 1;

	$T['Content'][$Tab][$lt]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('col_1_txt');
	$T['Content'][$Tab][$lt]['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('col_2_txt');
	$T['Content'][$Tab][$lt]['3']['cont'] = $bts->I18nTransObj->getI18nTransEntry('col_3_txt');
	$T['Content'][$Tab][$lt]['4']['cont'] = $bts->I18nTransObj->getI18nTransEntry('col_4_txt');
	$T['Content'][$Tab][$lt]['5']['cont'] = $bts->I18nTransObj->getI18nTransEntry('col_5_txt');
	$T['Content'][$Tab][$lt]['6']['cont'] = $bts->I18nTransObj->getI18nTransEntry('col_6_txt');
	$T['Content'][$Tab][$lt]['7']['cont'] = $bts->I18nTransObj->getI18nTransEntry('col_7_txt');

	while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
		$pv['log_action_longeur'] = strlen($dbp['log_contenu']);
		switch (TRUE) {
			case ($pv['log_action_longeur'] < 128 && $pv['log_action_longeur'] > 64):
				$dbp['log_contenu2'] = substr($dbp['log_contenu'], 0, 59) . " [...] ";
				break;
			case ($pv['log_action_longeur'] > 128):
				$dbp['log_contenu2'] = substr($dbp['log_contenu'], 0, 59) . " [...] " . substr($dbp['log_contenu'], ($pv['log_action_longeur'] - 64), $pv['log_action_longeur']);
				break;
			case ($pv['log_action_longeur'] < 64):
				$dbp['log_contenu2'] = $dbp['log_contenu'];
				break;
		}

		$lt++;
		$T['Content'][$Tab][$lt]['1']['cont'] = $dbp['log_id'] . "<br>\r<input type='checkbox' name='lmForm[selection][" . $dbp['log_id'] . "]'>";
		$T['Content'][$Tab][$lt]['2']['cont'] = date("Y m d H:i:s", $dbp['log_date']);
		$T['Content'][$Tab][$lt]['3']['cont'] = $tab[$dbp['log_signal']];
		$T['Content'][$Tab][$lt]['4']['cont'] = $dbp['log_msgid'];
		$T['Content'][$Tab][$lt]['5']['cont'] = $dbp['log_initiator'];
		$T['Content'][$Tab][$lt]['6']['cont'] = $dbp['log_action'];
		$T['Content'][$Tab][$lt]['7']['cont'] = "<span
		onMouseOver=\"t.ToolTip('" .
			$bts->SDDMObj->escapeString(htmlentities($dbp['log_contenu'])) . "', 'logMgmt');\"
		onMouseOut=\"t.ToolTip('', 'logMgmt');\">\r" . $dbp['log_contenu2'] . "</span>\r";

		$T['Content'][$Tab][$lt]['1']['tc'] = 1;
		$T['Content'][$Tab][$lt]['2']['tc'] = 1;
		$T['Content'][$Tab][$lt]['3']['tc'] = 1;
		$T['Content'][$Tab][$lt]['4']['tc'] = 1;
		$T['Content'][$Tab][$lt]['5']['tc'] = 1;
		$T['Content'][$Tab][$lt]['6']['tc'] = 1;
		$T['Content'][$Tab][$lt]['7']['tc'] = 1;
	}
}

// --------------------------------------------------------------------------------------------
//
//	Display
//
//
// --------------------------------------------------------------------------------------------
$T['ContentInfos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, 15, $Tab);
$T['ContentCfg']['tabs'] = array(
	1	=>	$bts->RenderTablesObj->getDefaultTableConfig($lt, 7, 1),
);
$Content .= $bts->RenderTablesObj->render($infos, $T);

$Content .= $criteria2ndPost . "
<input type='hidden' name='lmForm[page]'	value='" . $bts->RequestDataObj->getRequestDataSubEntry('lmForm', 'page') . "'>\r
<input type='hidden' name='lmForm[action]'	value='DELETE'>\r
<br>\r";

$SB = array(
	"id"				=> "deleteButton",
	"type"				=> "submit",
	"initialStyle"		=> $Block . "_t3 " . $Block . "_submit_s3_n",
	"hoverStyle"		=> $Block . "_t3 " . $Block . "_submit_s3_h",
	"onclick"			=> "",
	"message"			=> $bts->I18nTransObj->getI18nTransEntry('btnDelete'),
	"mode"				=> 1,
	"size" 				=> 128,
	"lastSize"			=> 0,
);

$Content .= "
		<table style=' width:100%; border-spacing: 3px;'>\r
		<tr>\r
		<td align='right'>\r"
	. $bts->InteractiveElementsObj->renderSubmitButton($SB)
	. "</td>\r</tr>\r</table>\r";

$Content .= "
</form>\r
" . $bts->RequestDataObj->getRequestDataSubEntry('lmForm', 'selection_page') . "
";
// $CurrentSetObj->GeneratedScriptObj->insertString('JavaScript-Init', "var TooltipByPass = { logMgmt : { 'State':1, 'X':196, 'Y':256 }};");
$CurrentSetObj->GeneratedScriptObj->AddObjectEntry('TooltipConfig', "'logMgmt' : { 'State':1, 'X':'196', 'Y':'256' }");


/*Hydr-Content-End*/
