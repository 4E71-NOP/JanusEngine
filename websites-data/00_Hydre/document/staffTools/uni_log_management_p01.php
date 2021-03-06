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
/* @var $cs CommonSystem                            */
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

// --------------------------------------------------------------------------------------------
$cs->RequestDataObj->setRequestData('mhForm', 
	array(
		"ok"			=>	"on",
		"avrt"			=>	"on",
		"err"			=>	"on",
		"info"			=>	"on",
		"other"			=>	"on",
		"nbrPerPage"	=>	10,
	)
);
$cs->RequestDataObj->setRequestData('scriptFile', 'uni_recherche_p01.php');

// --------------------------------------------------------------------------------------------
/*Hydre-contenu_debut*/
$localisation = " / uni_log_management_p01";
$cs->MapperObj->AddAnotherLevel($localisation );
$cs->LMObj->logCheckpoint("uni_log_management_p01.php");
$cs->MapperObj->RemoveThisLevel($localisation );
$cs->MapperObj->setSqlApplicant("uni_log_management_p01.php");

switch ($l) {
	case "fra":
		$cs->I18nObj->apply(array(
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
		));
		break;
	case "eng":
		$cs->I18nObj->apply(array(
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
		));
		break;
}

// --------------------------------------------------------------------------------------------
//	Realisation des suppresions demandées
// --------------------------------------------------------------------------------------------
if ( strlen($cs->RequestDataObj->getRequestDataSubEntry('mhForm', 'action')) != 0) {
	switch ($cs->RequestDataObj->getRequestDataSubEntry('mhForm', 'action')) {
	case "DELETE":
		$DeleteSelection = " WHERE log_id IN (";
		foreach ( $cs->RequestDataObj->getRequestDataSubEntry('mhForm', 'selection') as $K => $A ) { $DeleteSelection .= $K.", "; }
		unset ($K,$A);
		$DeleteSelection = substr($DeleteSelection, 0, -2) . ") ";
		$dbquery = $cs->SDDMObj->query("
		DELETE FROM ".$SqlTableListObj->getSQLTableName('log'). 
		$DeleteSelection."
		;");
		break;
	}
}
// --------------------------------------------------------------------------------------------
//	Analyse des critere d'affichage
// --------------------------------------------------------------------------------------------
if ( is_array($cs->RequestDataObj->getRequestDataSubEntry('mhForm', 'clause_type')) ) {
	$CheckClauseType = 0;
	foreach ( $cs->RequestDataObj->getRequestDataSubEntry('mhForm', 'clause_type') as $A ) { if ( $A == "on" ) { $CheckClauseType++; } }
	if ( $CheckClauseType == 0 ) {
		$cs->RequestDataObj->setRequestDataSubEntry('mhForm', 'err', 'on');
		$cs->RequestDataObj->setRequestDataSubEntry('mhForm', 'ok', 'on');
		$cs->RequestDataObj->setRequestDataSubEntry('mhForm', 'avrt', 'on');
	}
}
else {
	$cs->RequestDataObj->setRequestDataSubEntry('mhForm', 'err', 'on');
	$cs->RequestDataObj->setRequestDataSubEntry('mhForm', 'ok', 'on');
	$cs->RequestDataObj->setRequestDataSubEntry('mhForm', 'avrt', 'on');
}

$criteriaUrl = ""; 
$ClauseType = " AND log_signal IN (";
$ClauseTmp = array();
if ( $cs->RequestDataObj->getRequestDataSubEntry('mhForm', 'err') == "on" )	{
	$ClauseTmp['1'] = "0"; 
	$criteriaUrl .= "&amp;mhForm[clause_type][err]=".$cs->RequestDataObj->getRequestDataSubEntry('mhForm', 'err');		
	$criteriaPost .= "<input type='hidden' name='mhForm[clause_type][err]'	value='".$cs->RequestDataObj->getRequestDataSubEntry('mhForm', 'err')."'>\r";		
	$cs->RequestDataObj->setRequestDataSubEntry('mhForm', 'err', ' checked ');
}
if ( $cs->RequestDataObj->getRequestDataSubEntry('mhForm', 'ok') == "on" )	{
	$ClauseTmp['2'] = "1";
	$criteriaUrl .= "&amp;mhForm[clause_type][ok]=".$cs->RequestDataObj->getRequestDataSubEntry('mhForm', 'ok');
	$criteriaPost .= "<input type='hidden' name='mhForm[clause_type][ok]'	value='".$cs->RequestDataObj->getRequestDataSubEntry('mhForm', 'ok')."'>\r";		
	$cs->RequestDataObj->setRequestDataSubEntry('mhForm', 'ok', ' checked ');
}
if ( $cs->RequestDataObj->getRequestDataSubEntry('mhForm', 'avrt') == "on" )	{
	$ClauseTmp['3'] = "2";
	$criteriaUrl .= "&amp;mhForm[clause_type][avrt]=".$cs->RequestDataObj->getRequestDataSubEntry('mhForm', 'avrt');
	$criteriaPost .= "<input type='hidden' name='mhForm[clause_type][avrt]'	value='".$cs->RequestDataObj->getRequestDataSubEntry('mhForm', 'avrt')."'>\r";		
	$cs->RequestDataObj->setRequestDataSubEntry('mhForm', 'avrt', ' checked ');
}
if ( $cs->RequestDataObj->getRequestDataSubEntry('mhForm', 'info') == "on" )	{
	$ClauseTmp['4'] = "3";
	$criteriaUrl .= "&amp;mhForm[clause_type][info]=".$cs->RequestDataObj->getRequestDataSubEntry('mhForm', 'info');
	$criteriaPost .= "<input type='hidden' name='mhForm[clause_type][info]'	value='".$cs->RequestDataObj->getRequestDataSubEntry('mhForm', 'info')."'>\r";		
	$cs->RequestDataObj->setRequestDataSubEntry('mhForm', 'info', ' checked ');
}
if ( $cs->RequestDataObj->getRequestDataSubEntry('mhForm', 'autr') == "on" )	{
	$ClauseTmp['5'] = "4";
	$criteriaUrl .= "&amp;mhForm[clause_type][autr]=".$cs->RequestDataObj->getRequestDataSubEntry('mhForm', 'autr');
	$criteriaPost .= "<input type='hidden' name='mhForm[clause_type][autr]'	value='".$cs->RequestDataObj->getRequestDataSubEntry('mhForm', 'autr')."'>\r";		
	$cs->RequestDataObj->setRequestDataSubEntry('mhForm', 'autr', ' checked ');
}

foreach ( $ClauseTmp as $B ) { $ClauseType .= $B.", "; }
$ClauseType = substr($ClauseType, 0, -2) . ") ";
unset ($A,$B);

if ( strlen($cs->RequestDataObj->getRequestDataSubEntry('mhForm', 'nbr_par_page')) == 0 ) { $cs->RequestDataObj->setRequestDataSubEntry('mhForm', 'nbr_par_page', 10);}
$criteriaUrl .= "&amp;mhForm[nbr_par_page]=".$cs->RequestDataObj->getRequestDataSubEntry('mhForm', 'nbr_par_page');
$criteriaPost .= "<input type='hidden' name='mhForm[nbr_par_page]'	value='".$cs->RequestDataObj->getRequestDataSubEntry('mhForm', 'nbr_par_page')."'>\r";		

$Content .= "
<form id='mhForm_001' ACTION='index.php?' method='post'>\r".
$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_sw').
$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_l').
$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_arti_ref').
$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_arti_page').
"<input type='hidden' name='mhForm[action]'	value='DISPLAY'>\r";

// --------------------------------------------------------------------------------------------
$T = array();
$Tab = 1;
$lt = 1;

$T['AD'][$Tab][$lt]['1']['colspan'] = 2;
$T['AD'][$Tab][$lt]['2']['cont'] = $cs->I18nObj->getI18nEntry('t1cap');
// $T['AD'][$Tab][$lt]['2']['cont'] = "";
$lt++;

$T['AD'][$Tab][$lt]['1']['cont'] = $cs->I18nObj->getI18nEntry('t1r1');
$T['AD'][$Tab][$lt]['2']['cont'] = "<input type='checkbox' name ='mhForm[clause_type][ok]'		class='".$Block."_t3 ".$Block."_form_1' ".$cs->RequestDataObj->getRequestDataSubEntry('mhForm', 'ok').">\r".$cs->I18nObj->getI18nEntry('type_ok')."; \r
<input type='checkbox' name ='mhForm[clause_type][avrt]'	class='".$Block."_form_1' ".$cs->RequestDataObj->getRequestDataSubEntry('mhForm', 'avrt').">\r".$cs->I18nObj->getI18nEntry('type_avrt')."; \r
<input type='checkbox' name ='mhForm[clause_type][err]'		class='".$Block."_form_1' ".$cs->RequestDataObj->getRequestDataSubEntry('mhForm', 'err').">\r".$cs->I18nObj->getI18nEntry('type_err')."; \r
<input type='checkbox' name ='mhForm[clause_type][info]'	class='".$Block."_form_1' ".$cs->RequestDataObj->getRequestDataSubEntry('mhForm', 'info').">\r".$cs->I18nObj->getI18nEntry('type_info')."; \r
<input type='checkbox' name ='mhForm[clause_type][autr]'	class='".$Block."_form_1' ".$cs->RequestDataObj->getRequestDataSubEntry('mhForm', 'autr').">\r".$cs->I18nObj->getI18nEntry('type_autr')."\r
";
$lt++;

$T['AD'][$Tab][$lt]['1']['cont'] = $cs->I18nObj->getI18nEntry('t1r2');
$T['AD'][$Tab][$lt]['2']['cont'] = "<input type='text' name='mhForm[nbr_par_page]' size='15' value='".$cs->RequestDataObj->getRequestDataSubEntry('mhForm', 'nbr_par_page')."' class='" . $Block."_t3 ".$Block."_form_1'>";

// $T['ADC']['onglet'][$Tab]['nbr_ligne'] = $lt;	$T['ADC']['onglet'][$Tab]['nbr_cellule'] = 2;	$T['ADC']['onglet'][$Tab]['legende'] = 1;

$T['tab_infos']['EnableTabs']		= 0;
$T['tab_infos']['NbrOfTabs']		= 1;
$T['tab_infos']['TabBehavior']		= 0;
$T['tab_infos']['RenderMode']		= 1;
$T['tab_infos']['HighLightType']	= 0;
$T['tab_infos']['Height']			= 128;
$T['tab_infos']['Width']			= $ThemeDataObj->getThemeDataEntry('theme_module_largeur_interne');
$T['tab_infos']['GroupName']		= "list";
$T['tab_infos']['CellName']			= "log";
$T['tab_infos']['DocumentName']		= "doc";
$T['tab_infos']['cell_1_txt']		= $cs->I18nObj->getI18nEntry('cell_1_txt');

$T['ADC']['onglet']['1']['nbr_ligne']	= $lt;
$T['ADC']['onglet']['1']['nbr_cellule']	= 2;
$T['ADC']['onglet']['1']['legende']		= 1;

$config = array(
		"mode" => 1,
		"affiche_module_mode" => "normal",
		"module_z_index" => 2,
		"block" => $infos['block'],
		"blockG" => $infos['block']."G",
		"blockT" => $infos['block']."T",
		"deco_type" => 50,
		"module" => $infos['module'],
);

$Content .= $cs->RenderTablesObj->render($config, $T) . "<br>\r";

// --------------------------------------------------------------------------------------------

$SB = array(
		"id"				=> "refreshButton",
		"type"				=> "submit",
		"initialStyle"		=> $Block."_t3 ".$Block."_submit_s1_n",
		"hoverStyle"		=> $Block."_t3 ".$Block."_submit_s1_h",
		"onclick"			=> "",
		"message"			=> $cs->I18nObj->getI18nEntry('btnRefresh'),
		"mode"				=> 1,
		"size" 				=> 128,
		"lastSize"			=> 0,
);

$Content .= "
		<table style=' width:".$ThemeDataObj->getThemeDataEntry('theme_module_largeur_interne')."px; border-spacing: 3px;'>\r
		<tr>\r
		<td align='right'>\r"
		.$cs->InteractiveElementsObj->renderSubmitButton($SB)
		."</td>\r</tr>\r</table>\r"
		;

$Content .= "
<br>\r
</form>\r
<form id='mhForm_002' ACTION='index.php?' method='post'>\r".
$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_sw').
$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_l').
$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_arti_ref').
$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_arti_page')

."<input type='hidden' name='mhForm[action]'	value='SUPPRESSION'>\r"
;

if ( strlen($cs->RequestDataObj->getRequestDataSubEntry('mhForm', 'page') == 0 )) { $cs->RequestDataObj->setRequestDataSubEntry('mhForm', 'page', 0 ); }

$dbquery = $cs->SDDMObj->query("
SELECT COUNT(log_id) as nbr_log 
FROM ".$SqlTableListObj->getSQLTableName('log')." 
WHERE ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."'
".$ClauseType.
$pv['clause_msgid']."
;");
while ($dbp = $cs->SDDMObj->fetch_array_sql($dbquery)) { $cs->RequestDataObj->setRequestDataSubEntry('mhForm', 'log_count', $dbp['nbr_log']); } 

if ( $cs->RequestDataObj->getRequestDataSubEntry('mhForm', 'log_count') > $cs->RequestDataObj->getRequestDataSubEntry('mhForm', 'nbr_par_page') ) {
	$cs->RequestDataObj->setRequestDataSubEntry('mhForm', 'selection_page', "<p style='text-align: center;'>\r --\r");
	$cs->RequestDataObj->setRequestDataSubEntry('mhForm', 'nbr_page', $cs->RequestDataObj->getRequestDataSubEntry('mhForm', 'log_count') / $cs->RequestDataObj->getRequestDataSubEntry('mhForm', 'nbr_par_page'));
	$cs->RequestDataObj->setRequestDataSubEntry('mhForm', 'reste', $cs->RequestDataObj->getRequestDataSubEntry('mhForm', 'log_count') % $cs->RequestDataObj->getRequestDataSubEntry('mhForm', 'nbr_par_page'));
	if ( $cs->RequestDataObj->getRequestDataSubEntry('mhForm', 'reste') != 0 ) { $cs->RequestDataObj->setRequestDataSubEntry('mhForm', 'nbr_page', $cs->RequestDataObj->getRequestDataSubEntry('mhForm', 'nbr_page')+1); }
	$cs->RequestDataObj->setRequestDataSubEntry('mhForm', 'compteur_page', 0);
	for ( $i = 1 ; $i <= $cs->RequestDataObj->getRequestDataSubEntry('mhForm', 'nbr_page') ; $i++ ) {
		if ( $cs->RequestDataObj->getRequestDataSubEntry('mhForm', 'page') != $cs->RequestDataObj->getRequestDataSubEntry('mhForm', 'compteur_page') ) {
			$cs->RequestDataObj->setRequestDataSubEntry('mhForm', 'selection_page', "
			<a class='" . $Block."_lien' href='index.php?
			mhForm[page]=".$cs->RequestDataObj->getRequestDataSubEntry('mhForm', 'compteur_page')."
			&amp;arti_page=1".
			$criteriaUrl.
			$CurrentSetObj->getDataSubEntry('block_HTML', 'url_sldup').
			"'>".$i."</a> ");
		}
		else { 
			
			$cs->RequestDataObj->setRequestDataSubEntry('mhForm', 'selection_page', $cs->RequestDataObj->getRequestDataSubEntry('mhForm', 'selection_page'). "<span style='font-weight: bold;'>[".$i."]</span> "); }
			$cs->RequestDataObj->setRequestDataSubEntry('mhForm', 'compteur_page', $cs->RequestDataObj->getRequestDataSubEntry('mhForm', 'compteur_page')+1);
	}
	$cs->RequestDataObj->setRequestDataSubEntry('mhForm', 'selection_page', $cs->RequestDataObj->getRequestDataSubEntry('mhForm', 'selection_page')." --</p>\r");
	$Content .= $cs->RequestDataObj->getRequestDataSubEntry('mhForm', 'selection_page');
}

$dbquery = $cs->SDDMObj->query("
SELECT * 
FROM ".$SqlTableListObj->getSQLTableName('log')." 
WHERE ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."'
".$ClauseType.
$pv['clause_msgid']."
ORDER BY log_date DESC, log_id DESC 
LIMIT ".($cs->RequestDataObj->getRequestDataSubEntry('mhForm', 'page') * $cs->RequestDataObj->getRequestDataSubEntry('mhForm', 'nbr_par_page')).",".$cs->RequestDataObj->getRequestDataSubEntry('mhForm', 'nbr_par_page')."
;");

$config = array(
		"mode" => 1,
		"affiche_module_mode" => "normal",
		"module_z_index" => 2,
		"block" => $infos['block'],
		"blockG" => $infos['block']."G",
		"blockT" => $infos['block']."T",
		"deco_type" => 50,
		"module" => $infos['module'],
);

if ( $cs->SDDMObj->num_row_sql($dbquery) == 0 ) {

	$Tab = 1; $lt = 1;
	$T['AD'][$Tab][$lt]['1']['cont'] = $cs->I18nObj->getI18nEntry('nothingToDisplay');

// 	$T['tab_infos'] = $cs->RenderTablesObj->getDefaultDocumentConfig($infos, 15);
// 	$T['ADC']['onglet'] = array(
// 			1	=>	$cs->RenderTablesObj->getDefaultTableConfig($lt,1,1),
// 	);
// 	$Content .= $cs->RenderTablesObj->render($infos, $T);
	
}
else {
	$tab = array( 
		0 => "<span class='".$Block."_erreur'>Erreur</span>",
		1 => "<span class='".$Block."_ok ".$Block."_t1'>OK</span>",
		2 => "<span class='".$Block."_avert'>Avertissement</span>",
		3 => "Information",
		4 => "Autre",
	);

	$Tab = 1; $lt = 1;

	$T['AD'][$Tab][$lt]['1']['cont'] = $cs->I18nObj->getI18nEntry('col_1_txt');
	$T['AD'][$Tab][$lt]['2']['cont'] = $cs->I18nObj->getI18nEntry('col_2_txt');
	$T['AD'][$Tab][$lt]['3']['cont'] = $cs->I18nObj->getI18nEntry('col_3_txt');
	$T['AD'][$Tab][$lt]['4']['cont'] = $cs->I18nObj->getI18nEntry('col_4_txt');
	$T['AD'][$Tab][$lt]['5']['cont'] = $cs->I18nObj->getI18nEntry('col_5_txt');
	$T['AD'][$Tab][$lt]['6']['cont'] = $cs->I18nObj->getI18nEntry('col_6_txt');
	$T['AD'][$Tab][$lt]['7']['cont'] = $cs->I18nObj->getI18nEntry('col_7_txt');

	while ($dbp = $cs->SDDMObj->fetch_array_sql($dbquery)) { 
		$pv['log_action_longeur'] = strlen($dbp['log_contenu']);
		switch (TRUE) {
		case ($pv['log_action_longeur'] < 128 && $pv['log_action_longeur'] > 64):	$dbp['log_contenu2'] = substr ($dbp['log_contenu'],0,59) . " [...] ";		break;
		case ($pv['log_action_longeur'] > 128):											$dbp['log_contenu2'] = substr ($dbp['log_contenu'],0,59) . " [...] " . substr ($dbp['log_contenu'],($pv['log_action_longeur'] - 64) ,$pv['log_action_longeur'] );		break;
		case ($pv['log_action_longeur'] < 64):											$dbp['log_contenu2'] = $dbp['log_contenu'];	break;
		}

		$lt++;
		$T['AD'][$Tab][$lt]['1']['cont'] = $dbp['log_id']. "<br>\r<input type='checkbox' name='mhForm[selection][".$dbp['log_id']."]'>";
		$T['AD'][$Tab][$lt]['2']['cont'] = date ( "Y m d H:i:s" , $dbp['log_date'] );
		$T['AD'][$Tab][$lt]['3']['cont'] = $tab[$dbp['log_signal']];
		$T['AD'][$Tab][$lt]['4']['cont'] = $dbp['log_msgid'];
		$T['AD'][$Tab][$lt]['5']['cont'] = $dbp['log_initiator'];
		$T['AD'][$Tab][$lt]['6']['cont'] = $dbp['log_action'];
		$T['AD'][$Tab][$lt]['7']['cont'] = "<span
		onMouseOver=\"t.ToolTip('".
		$cs->SDDMObj->escapeString(htmlentities($dbp['log_contenu']))."');\"
		onMouseOut=\"t.ToolTip();\">\r".$dbp['log_contenu2']."</span>\r";

		$T['AD'][$Tab][$lt]['1']['tc'] = 1;
		$T['AD'][$Tab][$lt]['2']['tc'] = 1;
		$T['AD'][$Tab][$lt]['3']['tc'] = 1;
		$T['AD'][$Tab][$lt]['4']['tc'] = 1;
		$T['AD'][$Tab][$lt]['5']['tc'] = 1;
		$T['AD'][$Tab][$lt]['6']['tc'] = 1;
		$T['AD'][$Tab][$lt]['7']['tc'] = 1;
	}
}

// --------------------------------------------------------------------------------------------
//
//	Display
//
//
// --------------------------------------------------------------------------------------------
$T['tab_infos'] = $cs->RenderTablesObj->getDefaultDocumentConfig($infos, 15, $Tab);
$T['ADC']['onglet'] = array(
		1	=>	$cs->RenderTablesObj->getDefaultTableConfig($lt,7,1),
);
$Content .= $cs->RenderTablesObj->render($infos, $T);

$Content .= $criteriaPost."
<input type='hidden' name='mhForm[page]'	value='".$cs->RequestDataObj->getRequestDataSubEntry('mhForm', 'page')."'>\r
<input type='hidden' name='mhForm[action]'	value='DELETE'>\r
<br>\r";

$SB = array(
		"id"				=> "deleteButton",
		"type"				=> "submit",
		"initialStyle"		=> $Block."_t3 ".$Block."_submit_s3_n",
		"hoverStyle"		=> $Block."_t3 ".$Block."_submit_s3_h",
		"onclick"			=> "",
		"message"			=> $cs->I18nObj->getI18nEntry('btnDelete'),
		"mode"				=> 1,
		"size" 				=> 128,
		"lastSize"			=> 0,
);

$Content .= "
		<table style=' width:".$ThemeDataObj->getThemeDataEntry('theme_module_largeur_interne')."px; border-spacing: 3px;'>\r
		<tr>\r
		<td align='right'>\r"
		.$cs->InteractiveElementsObj->renderSubmitButton($SB)
		."</td>\r</tr>\r</table>\r"
		;

$Content .= "
</form>\r
".$cs->RequestDataObj->getRequestDataSubEntry('mhForm', 'selection_page')."
";

$cs->GeneratedJavaScriptObj->insertJavaScript('Init', "var TooltipByPass = { 'State':1, 'X':196, 'Y':256 };");

/*Hydre-contenu_fin*/

// $LMObj->setInternalLogTarget($LOG_TARGET);

?>
