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
// Some definitions in order to ease the IDE work.
/* @var $AdminFormToolObj AdminFormTool             */
/* @var $CMObj ConfigurationManagement              */
/* @var $ClassLoaderObj ClassLoader                 */
/* @var $LMObj LogManagement                        */
/* @var $MapperObj Mapper                           */
/* @var $I18nObj I18n                               */
/* @var $InteractiveElementsObj InteractiveElements */
/* @var $RenderTablesObj RenderTables               */
/* @var $RequestDataObj RequestData                 */
/* @var $SDDMObj DalFacade                          */
/* @var $SqlTableListObj SqlTableList               */
/* @var $StringFormatObj StringFormat               */
/* @var $TimeObj Time                               */

/* @var $CurrentSetObj CurrentSet                   */
/* @var $DocumentDataObj DocumentData               */
/* @var $RenderLayoutObj RenderLayout               */
/* @var $ThemeDataObj ThemeData                     */
/* @var $UserObj User                               */
/* @var $WebSiteObj WebSite                         */

/* @var $Block String                               */
/* @var $infos array                                */
/* @var $l String                                   */
/*Hydre-IDE-end*/

$logTarget = $LMObj->getInternalLogTarget();
$LMObj->setInternalLogTarget("both");

// --------------------------------------------------------------------------------------------
$RequestDataObj->setRequestData('mhForm', 
	array(
		"ok"			=>	"on",
		"avrt"			=>	"on",
		"err"			=>	"on",
		"info"			=>	"on",
		"other"			=>	"on",
		"nbrPerPage"	=>	10,
	)
);
$RequestDataObj->setRequestData('scriptFile', 'uni_recherche_p01.php');

// --------------------------------------------------------------------------------------------
/*Hydre-contenu_debut*/
$localisation = " / uni_gestion_des_historiques_p01.php";
$MapperObj->AddAnotherLevel($localisation );
$LMObj->logCheckpoint("uni_gestion_des_historiques_p01.php");
$MapperObj->RemoveThisLevel($localisation );
$MapperObj->setSqlApplicant("uni_gestion_des_historiques_p01.php");

switch ($l) {
	case "fra":
		$I18nObj->apply(array(
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
		$I18nObj->apply(array(
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
if ( strlen($RequestDataObj->getRequestDataSubEntry('mhForm', 'action')) != 0) {
	switch ($RequestDataObj->getRequestDataSubEntry('mhForm', 'action')) {
	case "DELETE":
		$DeleteSelection = " WHERE historique_id IN (";
		foreach ( $RequestDataObj->getRequestDataSubEntry('mhForm', 'selection') as $K => $A ) { $DeleteSelection .= $K.", "; }
		unset ($K,$A);
		$DeleteSelection = substr($DeleteSelection, 0, -2) . ") ";
		$dbquery = $SDDMObj->query("
		DELETE FROM ".$SqlTableListObj->getSQLTableName('historique'). 
		$DeleteSelection."
		;");
		break;
	}
}
// --------------------------------------------------------------------------------------------
//	Analyse des critere d'affichage
// --------------------------------------------------------------------------------------------
if ( is_array($RequestDataObj->getRequestDataSubEntry('mhForm', 'clause_type')) ) {
	$CheckClauseType = 0;
	foreach ( $RequestDataObj->getRequestDataSubEntry('mhForm', 'clause_type') as $A ) { if ( $A == "on" ) { $CheckClauseType++; } }
	if ( $CheckClauseType == 0 ) {
		$RequestDataObj->setRequestDataSubEntry('mhForm', 'err', 'on');
		$RequestDataObj->setRequestDataSubEntry('mhForm', 'ok', 'on');
		$RequestDataObj->setRequestDataSubEntry('mhForm', 'avrt', 'on');
	}
}
else {
	$RequestDataObj->setRequestDataSubEntry('mhForm', 'err', 'on');
	$RequestDataObj->setRequestDataSubEntry('mhForm', 'ok', 'on');
	$RequestDataObj->setRequestDataSubEntry('mhForm', 'avrt', 'on');
}

$criteriaUrl = ""; 
$ClauseType = " AND historique_signal IN (";
$ClauseTmp = array();
if ( $RequestDataObj->getRequestDataSubEntry('mhForm', 'err') == "on" )	{
	$ClauseTmp['1'] = "0"; 
	$criteriaUrl .= "&amp;mhForm[clause_type][err]=".$RequestDataObj->getRequestDataSubEntry('mhForm', 'err');		
	$criteriaPost .= "<input type='hidden' name='mhForm[clause_type][err]'	value='".$RequestDataObj->getRequestDataSubEntry('mhForm', 'err')."'>\r";		
	$RequestDataObj->setRequestDataSubEntry('mhForm', 'err', ' checked ');
}
if ( $RequestDataObj->getRequestDataSubEntry('mhForm', 'ok') == "on" )	{
	$ClauseTmp['2'] = "1";
	$criteriaUrl .= "&amp;mhForm[clause_type][ok]=".$RequestDataObj->getRequestDataSubEntry('mhForm', 'ok');
	$criteriaPost .= "<input type='hidden' name='mhForm[clause_type][ok]'	value='".$RequestDataObj->getRequestDataSubEntry('mhForm', 'ok')."'>\r";		
	$RequestDataObj->setRequestDataSubEntry('mhForm', 'ok', ' checked ');
}
if ( $RequestDataObj->getRequestDataSubEntry('mhForm', 'avrt') == "on" )	{
	$ClauseTmp['3'] = "2";
	$criteriaUrl .= "&amp;mhForm[clause_type][avrt]=".$RequestDataObj->getRequestDataSubEntry('mhForm', 'avrt');
	$criteriaPost .= "<input type='hidden' name='mhForm[clause_type][avrt]'	value='".$RequestDataObj->getRequestDataSubEntry('mhForm', 'avrt')."'>\r";		
	$RequestDataObj->setRequestDataSubEntry('mhForm', 'avrt', ' checked ');
}
if ( $RequestDataObj->getRequestDataSubEntry('mhForm', 'info') == "on" )	{
	$ClauseTmp['4'] = "3";
	$criteriaUrl .= "&amp;mhForm[clause_type][info]=".$RequestDataObj->getRequestDataSubEntry('mhForm', 'info');
	$criteriaPost .= "<input type='hidden' name='mhForm[clause_type][info]'	value='".$RequestDataObj->getRequestDataSubEntry('mhForm', 'info')."'>\r";		
	$RequestDataObj->setRequestDataSubEntry('mhForm', 'info', ' checked ');
}
if ( $RequestDataObj->getRequestDataSubEntry('mhForm', 'autr') == "on" )	{
	$ClauseTmp['5'] = "4";
	$criteriaUrl .= "&amp;mhForm[clause_type][autr]=".$RequestDataObj->getRequestDataSubEntry('mhForm', 'autr');
	$criteriaPost .= "<input type='hidden' name='mhForm[clause_type][autr]'	value='".$RequestDataObj->getRequestDataSubEntry('mhForm', 'autr')."'>\r";		
	$RequestDataObj->setRequestDataSubEntry('mhForm', 'autr', ' checked ');
}

foreach ( $ClauseTmp as $B ) { $ClauseType .= $B.", "; }
$ClauseType = substr($ClauseType, 0, -2) . ") ";
unset ($A,$B);

if ( strlen($RequestDataObj->getRequestDataSubEntry('mhForm', 'nbr_par_page')) == 0 ) { $RequestDataObj->setRequestDataSubEntry('mhForm', 'nbr_par_page', 10);}
$criteriaUrl .= "&amp;mhForm[nbr_par_page]=".$RequestDataObj->getRequestDataSubEntry('mhForm', 'nbr_par_page');
$criteriaPost .= "<input type='hidden' name='mhForm[nbr_par_page]'	value='".$RequestDataObj->getRequestDataSubEntry('mhForm', 'nbr_par_page')."'>\r";		

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
$T['AD'][$Tab][$lt]['2']['cont'] = $I18nObj->getI18nEntry('t1cap');
// $T['AD'][$Tab][$lt]['2']['cont'] = "";
$lt++;

$T['AD'][$Tab][$lt]['1']['cont'] = $I18nObj->getI18nEntry('t1r1');
$T['AD'][$Tab][$lt]['2']['cont'] = "<input type='checkbox' name ='mhForm[clause_type][ok]'		class='".$Block."_t3 ".$Block."_form_1' ".$RequestDataObj->getRequestDataSubEntry('mhForm', 'ok').">\r".$I18nObj->getI18nEntry('type_ok')."; \r
<input type='checkbox' name ='mhForm[clause_type][avrt]'	class='".$Block."_form_1' ".$RequestDataObj->getRequestDataSubEntry('mhForm', 'avrt').">\r".$I18nObj->getI18nEntry('type_avrt')."; \r
<input type='checkbox' name ='mhForm[clause_type][err]'		class='".$Block."_form_1' ".$RequestDataObj->getRequestDataSubEntry('mhForm', 'err').">\r".$I18nObj->getI18nEntry('type_err')."; \r
<input type='checkbox' name ='mhForm[clause_type][info]'	class='".$Block."_form_1' ".$RequestDataObj->getRequestDataSubEntry('mhForm', 'info').">\r".$I18nObj->getI18nEntry('type_info')."; \r
<input type='checkbox' name ='mhForm[clause_type][autr]'	class='".$Block."_form_1' ".$RequestDataObj->getRequestDataSubEntry('mhForm', 'autr').">\r".$I18nObj->getI18nEntry('type_autr')."\r
";
$lt++;

$T['AD'][$Tab][$lt]['1']['cont'] = $I18nObj->getI18nEntry('t1r2');
$T['AD'][$Tab][$lt]['2']['cont'] = "<input type='text' name='mhForm[nbr_par_page]' size='15' value='".$RequestDataObj->getRequestDataSubEntry('mhForm', 'nbr_par_page')."' class='" . $Block."_t3 ".$Block."_form_1'>";

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
$T['tab_infos']['cell_1_txt']		= $I18nObj->getI18nEntry('cell_1_txt');

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

$Content .= $RenderTablesObj->render($config, $T) . "<br>\r";

// --------------------------------------------------------------------------------------------

$SB = array(
		"id"				=> "refreshButton",
		"type"				=> "submit",
		"initialStyle"		=> $Block."_t3 ".$Block."_submit_s1_n",
		"hoverStyle"		=> $Block."_t3 ".$Block."_submit_s1_h",
		"onclick"			=> "",
		"message"			=> $I18nObj->getI18nEntry('btnRefresh'),
		"mode"				=> 1,
		"size" 				=> 128,
		"lastSize"			=> 0,
);

$Content .= "
		<table style=' width:".$ThemeDataObj->getThemeDataEntry('theme_module_largeur_interne')."px; border-spacing: 3px;'>\r
		<tr>\r
		<td align='right'>\r"
		.$InteractiveElementsObj->renderSubmitButton($SB)
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

if ( strlen($RequestDataObj->getRequestDataSubEntry('mhForm', 'page') == 0 )) { $RequestDataObj->setRequestDataSubEntry('mhForm', 'page', 0 ); }

$dbquery = $SDDMObj->query("
SELECT COUNT(historique_id) as nbr_historique 
FROM ".$SqlTableListObj->getSQLTableName('historique')." 
WHERE site_id = '".$WebSiteObj->getWebSiteEntry('sw_id')."'
".$ClauseType.
$pv['clause_msgid']."
;");
while ($dbp = $SDDMObj->fetch_array_sql($dbquery)) { $RequestDataObj->setRequestDataSubEntry('mhForm', 'historique_count', $dbp['nbr_historique']); } 

if ( $RequestDataObj->getRequestDataSubEntry('mhForm', 'historique_count') > $RequestDataObj->getRequestDataSubEntry('mhForm', 'nbr_par_page') ) {
	$RequestDataObj->setRequestDataSubEntry('mhForm', 'selection_page', "<p style='text-align: center;'>\r --\r");
	$RequestDataObj->setRequestDataSubEntry('mhForm', 'nbr_page', $RequestDataObj->getRequestDataSubEntry('mhForm', 'historique_count') / $RequestDataObj->getRequestDataSubEntry('mhForm', 'nbr_par_page'));
	$RequestDataObj->setRequestDataSubEntry('mhForm', 'reste', $RequestDataObj->getRequestDataSubEntry('mhForm', 'historique_count') % $RequestDataObj->getRequestDataSubEntry('mhForm', 'nbr_par_page'));
	if ( $RequestDataObj->getRequestDataSubEntry('mhForm', 'reste') != 0 ) { $RequestDataObj->setRequestDataSubEntry('mhForm', 'nbr_page', $RequestDataObj->getRequestDataSubEntry('mhForm', 'nbr_page')+1); }
	$RequestDataObj->setRequestDataSubEntry('mhForm', 'compteur_page', 0);
	for ( $i = 1 ; $i <= $RequestDataObj->getRequestDataSubEntry('mhForm', 'nbr_page') ; $i++ ) {
		if ( $RequestDataObj->getRequestDataSubEntry('mhForm', 'page') != $RequestDataObj->getRequestDataSubEntry('mhForm', 'compteur_page') ) {
			$RequestDataObj->setRequestDataSubEntry('mhForm', 'selection_page', "
			<a class='" . $Block."_lien' href='index.php?
			mhForm[page]=".$RequestDataObj->getRequestDataSubEntry('mhForm', 'compteur_page')."
			&amp;arti_page=1".
			$criteriaUrl.
			$CurrentSetObj->getDataSubEntry('block_HTML', 'url_sldup').
			"'>".$i."</a> ");
		}
		else { 
			
			$RequestDataObj->setRequestDataSubEntry('mhForm', 'selection_page', $RequestDataObj->getRequestDataSubEntry('mhForm', 'selection_page'). "<span style='font-weight: bold;'>[".$i."]</span> "); }
			$RequestDataObj->setRequestDataSubEntry('mhForm', 'compteur_page', $RequestDataObj->getRequestDataSubEntry('mhForm', 'compteur_page')+1);
	}
	$RequestDataObj->setRequestDataSubEntry('mhForm', 'selection_page', $RequestDataObj->getRequestDataSubEntry('mhForm', 'selection_page')." --</p>\r");
	$Content .= $RequestDataObj->getRequestDataSubEntry('mhForm', 'selection_page');
}

$dbquery = $SDDMObj->query("
SELECT * 
FROM ".$SqlTableListObj->getSQLTableName('historique')." 
WHERE site_id = '".$WebSiteObj->getWebSiteEntry('sw_id')."'
".$ClauseType.
$pv['clause_msgid']."
ORDER BY historique_date DESC, historique_id DESC 
LIMIT ".($RequestDataObj->getRequestDataSubEntry('mhForm', 'page') * $RequestDataObj->getRequestDataSubEntry('mhForm', 'nbr_par_page')).",".$RequestDataObj->getRequestDataSubEntry('mhForm', 'nbr_par_page')."
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

if ( $SDDMObj->num_row_sql($dbquery) == 0 ) {

	$Tab = 1; $lt = 1;
	$T['AD'][$Tab][$lt]['1']['cont'] = $I18nObj->getI18nEntry('nothingToDisplay');

// 	$T['tab_infos'] = $RenderTablesObj->getDefaultDocumentConfig($infos, 15);
// 	$T['ADC']['onglet'] = array(
// 			1	=>	$RenderTablesObj->getDefaultTableConfig($lt,1,1),
// 	);
// 	$Content .= $RenderTablesObj->render($infos, $T);
	
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

	$T['AD'][$Tab][$lt]['1']['cont'] = $I18nObj->getI18nEntry('col_1_txt');
	$T['AD'][$Tab][$lt]['2']['cont'] = $I18nObj->getI18nEntry('col_2_txt');
	$T['AD'][$Tab][$lt]['3']['cont'] = $I18nObj->getI18nEntry('col_3_txt');
	$T['AD'][$Tab][$lt]['4']['cont'] = $I18nObj->getI18nEntry('col_4_txt');
	$T['AD'][$Tab][$lt]['5']['cont'] = $I18nObj->getI18nEntry('col_5_txt');
	$T['AD'][$Tab][$lt]['6']['cont'] = $I18nObj->getI18nEntry('col_6_txt');
	$T['AD'][$Tab][$lt]['7']['cont'] = $I18nObj->getI18nEntry('col_7_txt');

	while ($dbp = $SDDMObj->fetch_array_sql($dbquery)) { 
		$pv['historique_action_longeur'] = strlen($dbp['historique_contenu']);
		switch (TRUE) {
		case ($pv['historique_action_longeur'] < 128 && $pv['historique_action_longeur'] > 64):	$dbp['historique_contenu2'] = substr ($dbp['historique_contenu'],0,59) . " [...] ";		break;
		case ($pv['historique_action_longeur'] > 128):											$dbp['historique_contenu2'] = substr ($dbp['historique_contenu'],0,59) . " [...] " . substr ($dbp['historique_contenu'],($pv['historique_action_longeur'] - 64) ,$pv['historique_action_longeur'] );		break;
		case ($pv['historique_action_longeur'] < 64):											$dbp['historique_contenu2'] = $dbp['historique_contenu'];	break;
		}

		$lt++;
		$T['AD'][$Tab][$lt]['1']['cont'] = $dbp['historique_id']. "<br>\r<input type='checkbox' name='mhForm[selection][".$dbp['historique_id']."]'>";
		$T['AD'][$Tab][$lt]['2']['cont'] = date ( "Y m d H:i:s" , $dbp['historique_date'] );
		$T['AD'][$Tab][$lt]['3']['cont'] = $tab[$dbp['historique_signal']];
		$T['AD'][$Tab][$lt]['4']['cont'] = $dbp['historique_msgid'];
		$T['AD'][$Tab][$lt]['5']['cont'] = $dbp['historique_initiateur'];
		$T['AD'][$Tab][$lt]['6']['cont'] = $dbp['historique_action'];
		$T['AD'][$Tab][$lt]['7']['cont'] = "<span
		onMouseOver=\"t.ToolTip('".
		$SDDMObj->escapeString(htmlentities($dbp['historique_contenu']))."');\"
		onMouseOut=\"t.ToolTip();\">\r".$dbp['historique_contenu2']."</span>\r";

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
$T['tab_infos'] = $RenderTablesObj->getDefaultDocumentConfig($infos, 15, $Tab);
$T['ADC']['onglet'] = array(
		1	=>	$RenderTablesObj->getDefaultTableConfig($lt,7,1),
);
$Content .= $RenderTablesObj->render($infos, $T);

$Content .= $criteriaPost."
<input type='hidden' name='mhForm[page]'	value='".$RequestDataObj->getRequestDataSubEntry('mhForm', 'page')."'>\r
<input type='hidden' name='mhForm[action]'	value='DELETE'>\r
<br>\r";

$SB = array(
		"id"				=> "deleteButton",
		"type"				=> "submit",
		"initialStyle"		=> $Block."_t3 ".$Block."_submit_s3_n",
		"hoverStyle"		=> $Block."_t3 ".$Block."_submit_s3_h",
		"onclick"			=> "",
		"message"			=> $I18nObj->getI18nEntry('btnDelete'),
		"mode"				=> 1,
		"size" 				=> 128,
		"lastSize"			=> 0,
);

$Content .= "
		<table style=' width:".$ThemeDataObj->getThemeDataEntry('theme_module_largeur_interne')."px; border-spacing: 3px;'>\r
		<tr>\r
		<td align='right'>\r"
		.$InteractiveElementsObj->renderSubmitButton($SB)
		."</td>\r</tr>\r</table>\r"
		;

$Content .= "
</form>\r
".$RequestDataObj->getRequestDataSubEntry('mhForm', 'selection_page')."
";

$GeneratedJavaScriptObj->insertJavaScript('Init', "var TooltipByPass = { 'State':1, 'X':196, 'Y':256 };");

/*Hydre-contenu_fin*/

$LMObj->setInternalLogTarget($logTarget);

?>
