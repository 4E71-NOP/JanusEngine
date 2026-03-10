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

$bts->RequestDataObj->setRequestData('formGenericData',
		array(
				'origin'		=> 'AdminDashboard',
				'section'		=> 'WebsiteManagementP01',
// 				'creation'		=> 'on',
// 				'modification'	=> 'on',
// 				'deletion'		=> 'on',
// 				'mode'			=> 'edit',
//				'mode'			=> 'create',
//				'mode'			=> 'delete',
		)
);


/*JanusEngine-Content-Begin*/
$bts->mapSegmentLocation(__METHOD__, "uni_website_management_p01");

$bts->I18nTransObj->getI18nTransFromDB("uni_website_management");
$bts->I18nTransObj->getI18nTransFromFile($CurrentSetObj->ServerInfosObj->getServerInfosEntry('DOCUMENT_ROOT') . "/websites-data/00_JanusEngineCore/document/staffTools/i18n/uni_website_management_p01_");

// --------------------------------------------------------------------------------------------

$dbquery = $bts->SDDMObj->query("
SELECT ws_state, fk_lang_id 
FROM ".$SqlTableListObj->getSQLTableName('website')." 
WHERE ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."'
;");
while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
	$pv['ws_state2']	= "select_o1_1_" . $dbp['ws_state'];
	$pv['ws_state']		= $dbp['ws_state'];
	$Content .= "<p>".$bts->I18nTransObj->getI18nTransEntry('msg_01').$bts->I18nTransObj->getI18nTransEntry($pv['ws_state2'])."<br>\r<br>\r</p>\r";
	$WebSiteObj->setWebSiteEntry('sw_default_lang', $dbp['fk_lang_id']);
}

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('AdminFormTool');
$AdminFormToolObj = AdminFormTool::getInstance();
$Content .= $AdminFormToolObj->checkAdminDashboardForm($infos);

// --------------------------------------------------------------------------------------------
$Content .= $bts->I18nTransObj->getI18nTransEntry('invite1')."<br>\r<br>\r";

// --------------------------------------------------------------------------------------------
$Content .= 
$bts->RenderFormObj->renderformHeader('WebsiteForm')
.$bts->RenderFormObj->renderHiddenInput(	"formSubmitted"	,				"1")
.$bts->RenderFormObj->renderHiddenInput(	"formGenericData[origin]"	,	"AdminDashboard")
.$bts->RenderFormObj->renderHiddenInput(	"formGenericData[section]"	,	"WebsiteManagementP01" )
.$bts->RenderFormObj->renderHiddenInput(	"formCommand1"				,	"update" )
.$bts->RenderFormObj->renderHiddenInput(	"formEntity1"				,	"website" )
.$bts->RenderFormObj->renderHiddenInput(	"formGenericData[mode]"		,	$processTarget )
.$bts->RenderFormObj->renderHiddenInput(	"formTarget1[name]"			, 	$WebSiteObj->getWebSiteEntry('ws_name') )
.$bts->RenderFormObj->renderHiddenInput(	"ModuleForm[selectionId]"	,	$WebSiteObj->getWebSiteEntry('ws_id') )
."<p>\r"
;

$mws_state = array(
	0		=> array( 't'=> $bts->I18nTransObj->getI18nTransEntry('select_t1_01_1_0'),		'db' => "OFFLINE",		'v' => 0),
	1		=> array( 't'=> $bts->I18nTransObj->getI18nTransEntry('select_t1_01_1_1'),		'db' => "ONLINE",		'v' => 1),
	2		=> array( 't'=> $bts->I18nTransObj->getI18nTransEntry('select_t1_01_1_2'),		'db' => "SUPPRIME",		'v' => 2),
	3		=> array( 't'=> $bts->I18nTransObj->getI18nTransEntry('select_t1_01_1_3'),		'db' => "MAINTENANCE",	'v' => 3),
	1000	=> array( 't'=> $bts->I18nTransObj->getI18nTransEntry('select_t1_01_1_1000'),	'db' => "LOCKED",		'v' => 1000),
);

$Tab = 0;
$T = array();

// --------------------------------------------------------------------------------------------

$langList		= $bts->CMObj->getLanguageList();
$ws_lang_select	= array();

// --------------------------------------------------------------------------------------------
// Tab 01
$Tab++;

$T['Content'][$Tab]['1']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1_l1');
$T['Content'][$Tab]['2']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1_l2');
$T['Content'][$Tab]['3']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1_l3');
$T['Content'][$Tab]['4']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1_l4');

// $T['Content'][$Tab]['1']['2']['cont'] = "<input type='text' name='formParams1[name]'			size='20' maxlength='255' value='".$WebSiteObj->getWebSiteEntry('ws_name')."'			class='" . $Block."_t3 " . $Block."_form_1'>\r";
$T['Content'][$Tab]['1']['2']['cont'] = $WebSiteObj->getWebSiteEntry('ws_name');
$T['Content'][$Tab]['2']['2']['cont'] = $bts->RenderFormObj->renderInputText('formParams1[abrege]',	$WebSiteObj->getWebSiteEntry('ws_short'), "", 20);
$T['Content'][$Tab]['3']['2']['cont'] = $bts->RenderFormObj->renderInputText('formParams1[title]',	$WebSiteObj->getWebSiteEntry('ws_title'), "" ,20);
$T['Content'][$Tab]['4']['2']['cont'] = $bts->RenderFormObj->renderInputText('formParams1[home]',	$WebSiteObj->getWebSiteEntry('ws_home'), "" ,20);

// $T['Content'][$Tab]['2']['2']['cont'] = "<input type='text' name='formParams1[abrege]'	size='20' maxlength='255' value='".$WebSiteObj->getWebSiteEntry('ws_short')."'			class='" . $Block."_t3 " . $Block."_form_1'>\r";
// $T['Content'][$Tab]['3']['2']['cont'] = "<input type='text' name='formParams1[title]'	size='20' maxlength='255' value='".$WebSiteObj->getWebSiteEntry('ws_title')."'			class='" . $Block."_t3 " . $Block."_form_1'>\r";
// $T['Content'][$Tab]['4']['2']['cont'] = "<input type='text' name='formParams1[home]'	size='20' maxlength='255' value='".$WebSiteObj->getWebSiteEntry('ws_home')."'			class='" . $Block."_t3 " . $Block."_form_1'>\r";


// --------------------------------------------------------------------------------------------
// Tab 02
$Tab++;

$T['Content'][$Tab]['1']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t2_l1');
$T['Content'][$Tab]['2']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t2_l2');
$T['Content'][$Tab]['3']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t2_l3');
$T['Content'][$Tab]['4']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t2_l4');
$T['Content'][$Tab]['5']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t2_l5');

$T['Content'][$Tab]['1']['2']['cont'] = "<select name='formParams1[lang]'>\r";
$langList[$WebSiteObj->getWebSiteEntry('fk_lang_id')]['s'] = " selected ";

foreach ( $langList as $k => $v ) {
	if ( !is_numeric($k) ) {
		if ( $v['support'] == 1 ) { $T['Content'][$Tab]['1']['2']['cont'] .= "<option value='".$v['lang_639_3']."' ".$v['s']."> ".$v['lang_original_name']." </option>\r"; }
	}
}
$T['Content'][$Tab]['1']['2']['cont'] .= "</select>\r";


$T['Content'][$Tab]['2']['2']['cont'] = "<select name='formParams1[lang_select]' class='" . $Block."_t3 " . $Block."_form_1'>\r";
$ws_lang_select['0']['t'] = $bts->I18nTransObj->getI18nTransEntry('no');		$ws_lang_select['0']['s'] = "";		$ws_lang_select['0']['cmd'] = "NO";
$ws_lang_select['1']['t'] = $bts->I18nTransObj->getI18nTransEntry('yes');	$ws_lang_select['1']['s'] = "";		$ws_lang_select['1']['cmd'] = "YES";
$ws_lang_select[$WebSiteObj->getWebSiteEntry('ws_lang_select')]['s'] = " selected ";
foreach ( $ws_lang_select as $A ) { $T['Content'][$Tab]['2']['2']['cont'] .= "<option value='".$A['cmd']."' ".$A['s']."> ".$A['t']."</option>\r"; }
$T['Content'][$Tab]['2']['2']['cont'] .= "</select>\r";

$T['Content'][$Tab]['3']['2']['cont'] = "<select name='formParams1[theme]' class='" . $Block."_t3 " . $Block."_form_1'>\r";
$dbquery = $bts->SDDMObj->query("
SELECT td.theme_id,td.theme_name,td.theme_title 
FROM ".$SqlTableListObj->getSQLTableName('theme_descriptor')." td, " 
.$SqlTableListObj->getSQLTableName('theme_website')." tw 
WHERE tw.fk_ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."' 
AND td.theme_id  = tw.fk_theme_id;
;");
while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
	if ( $WebSiteObj->getWebSiteEntry('theme_id') == $dbp['theme_id'] ) { $T['Content'][$Tab]['3']['2']['cont'] .= "<option value='".$dbp['theme_name']."' selected>".$dbp['theme_title']."</option>\r"; }
	else { $T['Content'][$Tab]['3']['2']['cont'] .= "<option value='".$dbp['theme_name']."'>".$dbp['theme_title']."</option>\r"; }
}
$T['Content'][$Tab]['3']['2']['cont'] .= "</select>\r";


$T['Content'][$Tab]['4']['2']['cont'] = "<select name='formParams1[stylesheet]' class='" . $Block."_t3 " . $Block."_form_1'>\r";
$sw_CSS = Array(
		0	=>	array("t" => $bts->I18nTransObj->getI18nTransEntry('select_t2_04_0'),		"s" => "",		"cmd" => "STATIC"),
		1	=>	array("t" => $bts->I18nTransObj->getI18nTransEntry('select_t2_04_1'),		"s" => "",		"cmd" => "DYNAMIC"),
		);
$sw_CSS[$WebSiteObj->getWebSiteEntry('ws_stylesheet')]['s'] = " selected ";
foreach ( $sw_CSS as $A ) { $T['Content'][$Tab]['4']['2']['cont'] .= "<option value='".$A['cmd']."' ".$A['s'].">".$A['t']."</option>\r"; }
$T['Content'][$Tab]['4']['2']['cont'] .= "</select>\r";



$wsdbg = $WebSiteObj->getWebSiteEntry('ws_info_debug');
$arrayDbg = array(
		2 => (($wsdbg & 2 ) != 0 ) ? "checked":"", 
		3 => (($wsdbg & 4 ) != 0 ) ? "checked":"", 
		4 => (($wsdbg & 8 ) != 0 ) ? "checked":"", 
		5 => (($wsdbg & 16 ) != 0 ) ? "checked":"", 
		6 => (($wsdbg & 32 ) != 0 ) ? "checked":"", 
		7 => (($wsdbg & 16384 ) != 0 ) ? "checked":"", 
		8 => (($wsdbg & 32768 ) != 0 ) ? "checked":"", 
);

$T['Content'][$Tab]['5']['2']['cont'] = "
<input type='checkbox' id='info_debug_default' checked									disabled='disabled'	>".	$bts->I18nTransObj->getI18nTransEntry('checkbox_t2_05_default')."<br>\r 
<input type='checkbox' id='info_debug_graph'			".$arrayDbg['2']."	onclick='computeInfoDebug()'	>".	$bts->I18nTransObj->getI18nTransEntry('checkbox_t2_05_graph')."<br>\r 
<input type='checkbox' id='info_debug_stats'			".$arrayDbg['3']."	onclick='computeInfoDebug()'	>".	$bts->I18nTransObj->getI18nTransEntry('checkbox_t2_05_stats')."<br>\r 
<input type='checkbox' id='info_debug_sql'				".$arrayDbg['4']."	onclick='computeInfoDebug()'	>".	$bts->I18nTransObj->getI18nTransEntry('checkbox_t2_05_sql')."<br>\r 
<input type='checkbox' id='info_debug_commandbuffer'	".$arrayDbg['5']."	onclick='computeInfoDebug()'	>".	$bts->I18nTransObj->getI18nTransEntry('checkbox_t2_05_commandbuffer')."<br>\r 
<input type='checkbox' id='info_debug_commandlogs'		".$arrayDbg['6']."	onclick='computeInfoDebug()'	>".	$bts->I18nTransObj->getI18nTransEntry('checkbox_t2_05_commandlogs')."<br>\r 
<input type='checkbox' id='info_debug_internallogs'		".$arrayDbg['7']."	onclick='computeInfoDebug()'	>".	$bts->I18nTransObj->getI18nTransEntry('checkbox_t2_05_internallogs')."<br>\r 
<input type='checkbox' id='info_debug_variables'		".$arrayDbg['8']."	onclick='computeInfoDebug()'	>".	$bts->I18nTransObj->getI18nTransEntry('checkbox_t2_05_variables')."<br>\r 
";

// --------------------------------------------------------------------------------------------
// Tab 03
$Tab++;
reset ($langList);
$i = 1;
$j = 1;
$T['Content'][$Tab]['1']['8']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t3_l1')."
<input type='hidden' name='formCommand2'			value='assign'>\r
<input type='hidden' name='formEntity2'				value='language'>\r
<input type='hidden' name='formParams2'				value='to_website'>\r
";
$T['Content'][$Tab][$i][$j]['colspan'] = 8;
$T['Content'][$Tab][$i][$j]['cont'] = "";
$T['Content'][$Tab][$i][$j]['cont'] = "";
$T['Content'][$Tab][$i][$j]['cont'] = "";
$T['Content'][$Tab][$i][$j]['cont'] = "";
$T['Content'][$Tab][$i][$j]['cont'] = "";
$T['Content'][$Tab][$i][$j]['cont'] = "";
$T['Content'][$Tab][$i][$j]['cont'] = "";

$i++;

$dbquery = $bts->SDDMObj->query("SELECT * FROM ".$SqlTableListObj->getSQLTableName('language').";");
while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
	$B = "";
	if ( $langList[$dbp['lang_id']]['support'] == 1 ) { $B = " checked"; }
	$T['Content'][$Tab][$i][$j]['cont'] = "<input type='checkbox' name='formTarget2[".$dbp['lang_639_3']."]' ".$B.">\r";		$j++;
	$T['Content'][$Tab][$i][$j]['cont'] = $dbp['lang_original_name'];																		$j++;
	if ( $j == 9 ) { $j = 1; $i++; }
}
$tab3NbrLine = $i;

// --------------------------------------------------------------------------------------------
// Tab 04
$Tab++;

$mws_state[$pv['ws_state']]['s'] = " selected ";

$T['Content'][$Tab]['1']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t'.$Tab.'_l1');
$T['Content'][$Tab]['1']['2']['cont'] = "<select name='formParams1[state]' class='" . $Block."_t3 " . $Block."_form_1'>\r";
foreach ( $mws_state as $A ) { $T['Content'][$Tab]['1']['2']['cont'] .= "<option value='".$A['db']."' ".$A['s'].">".$A['t']."</option>\r"; }
$T['Content'][$Tab]['1']['2']['cont'] .= "</select>\r";

// --------------------------------------------------------------------------------------------
// Tab 05
$Tab++;

$T['Content'][$Tab]['1']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5_l1');
$T['Content'][$Tab]['1']['2']['cont'] = "<select name='formParams1[ma_diff]' class='" . $Block."_t3 " . $Block."_form_1'>\r";
$ws_ma_diff = array(
	0	=> array('t' => $bts->I18nTransObj->getI18nTransEntry('no'),		's' => "",		'cmd' => "NO"),
	1	=> array('t' => $bts->I18nTransObj->getI18nTransEntry('yes'),	's' => "",		'cmd' => "YES"),
);
$ws_ma_diff[$WebSiteObj->getWebSiteEntry('ws_ma_diff')]['s'] = " selected ";
foreach ( $ws_ma_diff as $A ) { $T['Content'][$Tab]['1']['2']['cont'] .= "<option value='".$A['cmd']."' ".$A['s'].">".$A['t']."</option>\r"; }
$T['Content'][$Tab]['1']['2']['cont'] .= "</select>";

// --------------------------------------------------------------------------------------------
//
//	Display
//
//
// --------------------------------------------------------------------------------------------
$T['ContentInfos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, 13, 5);
$T['ContentCfg']['tabs'] = array(
		1	=>	$bts->RenderTablesObj->getDefaultTableConfig(4,2,2),
		2	=>	$bts->RenderTablesObj->getDefaultTableConfig(5,2,2),
		3	=>	$bts->RenderTablesObj->getDefaultTableConfig($tab3NbrLine,8,1),
		4	=>	$bts->RenderTablesObj->getDefaultTableConfig(1,2,2),
		5	=>	$bts->RenderTablesObj->getDefaultTableConfig(1,2,2),
);
$Content .= $bts->RenderTablesObj->render($infos, $T);


// --------------------------------------------------------------------------------------------

// A Javascript is inserted for computing the final 'info_debug' value. 
// This is a specific case that does not require a separated script file.
$Content .= "
<input type='hidden' id='formParams1_info_debug' name='formParams1[info_debug]'				value='UPDATE_WEBSITE'>\r

<script type='text/javascript'>\r
function computeInfoDebug () {\r
	const listInfoDebug = {\r
	'1' : { 'n' : 'info_debug_graph',			'v' : '2' },\r
	'2' : { 'n' : 'info_debug_stats',			'v' : '4' },\r
	'3' : { 'n' : 'info_debug_sql',				'v' : '8' },\r
	'4' : { 'n' : 'info_debug_commandbuffer',	'v' : '16' },\r
	'5' : { 'n' : 'info_debug_commandlogs',		'v' : '32' },\r
	'6' : { 'n' : 'info_debug_internallogs',	'v' : '16384' },\r
	'7' : { 'n' : 'info_debug_variables',		'v' : '32768' }\r
	};\r
	\r
	var scoreInfoDebug = 1;\r
	for (let f in listInfoDebug) {\r
		// console.log ('processing: ' + listInfoDebug[f].n) \r
		if ( elm.Gebi(listInfoDebug[f].n).checked ) {\r
			scoreInfoDebug += Number(listInfoDebug[f].v);\r
		}\r
	}\r
	elm.Gebi('formParams1_info_debug').value = scoreInfoDebug;\r
	l.Log[cfg.CoreDbg]('formParams1_info_debug=' + elm.Gebi('formParams1_info_debug').value);\r
}\r
</script>\r
\r
<input type='hidden' name='site_context[ws_id]'		value='".$WebSiteObj->getWebSiteEntry('ws_id')."'>
<input type='hidden' name='site_context[site_name]'	value='".$WebSiteObj->getWebSiteEntry('ws_name')."'>

<table cellpadding='8' cellspacing='0' style='width :100%;'>
<tr>\r
<td>\r
<input type='checkbox' name='formGenericData[modification]'>".$bts->I18nTransObj->getI18nTransEntry('validation')."\r
</td>\r
<td align='right'>\r
";

$SB = $bts->InteractiveElementsObj->getDefaultSubmitButtonConfig(
	$infos , 'submit', 
	$bts->I18nTransObj->getI18nTransEntry('btnUpdate'), 128, 
	'WebsiteUpdateButton', 
	3, 3, 
	"" 
);
$Content .= $bts->InteractiveElementsObj->renderSubmitButton($SB);

$Content .= "
</table>\r
</form>\r
";

$bts->segmentEnding(__METHOD__);
/*JanusEngine-Content-End*/
?>