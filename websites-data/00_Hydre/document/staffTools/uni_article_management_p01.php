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

// $LOG_TARGET = $LMObj->getInternalLogTarget();
// $bts->LMObj->setInternalLogTarget("both");
// $LOG_TARGET = $LMObj->getInternalLogTarget();
$bts->LMObj->setInternalLogTarget("both");

$bts->RequestDataObj->setRequestData('articleForm',
	array(
		'SQLlang'		=> 48,
		'SQLdeadline'	=> 4,
		'SQLnom'		=> "charg",
		'action'		=> "",
	)
);
// 		'action'		=> "AFFICHAGE",

/*Hydr-Content-Begin*/
$localisation = " / uni_article_management_p01";
$bts->MapperObj->AddAnotherLevel($localisation );
$bts->LMObj->logCheckpoint("uni_article_management_p01.php");
$bts->MapperObj->RemoveThisLevel($localisation );
$bts->MapperObj->setSqlApplicant("uni_article_management_p01.php");

$bts->I18nTransObj->apply(
	array(
		"type" => "array",
		"fra" => array(
			"invite1"		=> "Cette partie va vous permettre de modifier les articles.",
			"col_1_txt"		=> "Nom",
			"col_2_txt"		=> "Pages",
			"col_3_txt"		=> "Langage",
			"col_4_txt"		=> "Bouclage",
			"tabTxt1"		=> "Informations",
			"deadline0"		=> "Choisissez une deadline",
			"caption"		=> "Recherche",
			"c1l1"			=> "Nom contient",
			"c1l2"			=> "Langue",
			"c1l3"			=> "Bouclage",
		),
		"eng" => array(
			"invite1"		=> "This part will allow you to modify articles.",
			"col_1_txt"		=> "Name",
			"col_2_txt"		=> "Pages",
			"col_3_txt"		=> "Language",
			"col_4_txt"		=> "Deadline",
			"tabTxt1"		=> "Informations",
			"deadline0"		=> "Choose a deadline",
			"caption"		=> "Search",
			"c1l1"			=> "Name contains",
			"c1l2"			=> "Language",
			"c1l3"			=> "Dead line",
		)
	)
);

$Content .= $bts->I18nTransObj->getI18nTransEntry('invite1')."<br>\r<br>\r";

// --------------------------------------------------------------------------------------------
$langList = $bts->CMObj->getLanguageList();
$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . "langList=" . $bts->StringFormatObj->arrayToString($langList)));

// --------------------------------------------------------------------------------------------
//	Form
// --------------------------------------------------------------------------------------------
if ( strlen($bts->RequestDataObj->getRequestDataEntry('SQLlang')) > 0 ) { $langList[$bts->RequestDataObj->getRequestDataEntry('SQLlang')]['s'] = "selected"; }
else { $langList[$CurrentSetObj->getDataEntry('language_id')]['s'] = "selected"; }

$listDeadline = array(
	0 => array(
		'id' => 0,
		'deadline_title' => $bts->I18nTransObj->getI18nTransEntry('deadline0'),
	),
);

$dbquery = $bts->SDDMObj->query("
SELECT deadline_id,deadline_name,deadline_title,deadline_state FROM "
.$SqlTableListObj->getSQLTableName('deadline')
." WHERE fk_ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."'
;");
while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
	$A = $dbp['deadline_id'];
	$listDeadline[$A]['id'] = $A;
	$listDeadline[$A]['deadline_name']		= $dbp['deadline_name'];
	$listDeadline[$A]['deadline_title']		= $dbp['deadline_title'];
	$listDeadline[$A]['deadline_state']		= $dbp['deadline_state'];
}
unset ( $A );
foreach ( $listDeadline as $A ) {
	if ( $A['deadline_state'] == 0 ) { $A['deadline_title'] = "<span class='".$Block."_err'>" . $A['deadline_title']; }
	else { $A['deadline_title'] = "<span class='".$Block."_ok'>" . $A['deadline_title']; }
	$A['deadline_title'] = $A['deadline_name'] . "</span>";
}
if ( strlen($bts->RequestDataObj->getRequestDataEntry('SQLdeadline')) > 0 ) { $listDeadline[$bts->RequestDataObj->getRequestDataEntry('SQLdeadline')]['s'] = "selected"; }

// --------------------------------------------------------------------------------------------
$Content .= "
<form id='MH_001' ACTION='/' method='post'>\r
<input type='hidden' name='formGenericData[mode]'	value='create'>
<input type='hidden' name='arti_page'	value='2'>\r
<table class='".$Block._CLASS_TABLE01_." ".$Block._CLASS_TBL_LGND_TOP_."'>\r
<tr>\r
<td colspan='2'>".$bts->I18nTransObj->getI18nTransEntry('caption')."</td>\r
</tr>\r

<tr>\r
<td>".$bts->I18nTransObj->getI18nTransEntry('c1l1')."</td>\r
<td><input type='text' name='articleForm[SQLnom]' size='15' value='".$bts->RequestDataObj->getRequestDataEntry('SQLnom')."' class='".$Block."_t3 " . $Block."_form_1'></td>\r
</tr>\r

<tr>\r
<td>".$bts->I18nTransObj->getI18nTransEntry('c1l2')."</td>\r
<td><select name='articleForm[SQLlang]' class='".$Block."_t3 " . $Block."_form_1'>
";
// unset ( $A , $B );
reset( $langList );
foreach ( $langList as $k => $v ) {
	if ( !is_numeric($k) ) {
		if ( $v['support'] == 1 ) { $Content .= "<option value='".$v['lang_639_3']."' ".$v['s'].">".$v['lang_original_name']."</option>\r"; }
	}
}
$Content .= "</select>
</td>\r
</tr>\r

<tr>\r
<td>".$bts->I18nTransObj->getI18nTransEntry('c1l3')."</td>\r
<td><select name='articleForm[SQLdeadline]' class='".$Block."_t3 " . $Block."_form_1'>
";
unset ( $A , $B );
foreach ( $listDeadline as $A ) {
	$Content .= "<option value='".$A['id']."' ".$A['selected'].">".$A['deadline_title']." / ".$A['deadline_name']."</option>\r";
}
$Content .= "</select></tr>\r
</table>\r

<table width='100%' cellpadding='16' cellspacing='0' style='margin-left: auto; margin-right: auto; padding:8px'>
<tr>\r
<td align='right'>\r
";

$SB = array(
		"id"				=> "refreshButton",
		"type"				=> "submit",
		"initialStyle"		=> $Block."_t3 ".$Block."_submit_s2_n",
		"hoverStyle"		=> $Block."_t3 ".$Block."_submit_s2_h",
		"onclick"			=> "",
		"message"			=> $bts->I18nTransObj->getI18nTransEntry('btnRefresh'),
		"mode"				=> 1,
		"size" 				=> 128,
		"lastSize"			=> 0,
);
$Content .= $bts->InteractiveElementsObj->renderSubmitButton($SB);
$Content .= "
</td>\r
</tr>\r
</table>\r
</form>\r
";
// --------------------------------------------------------------------------------------------

$articleFormData = $bts->RequestDataObj->getRequestDataEntry('articleForm');
$sqlClause = "";

if ( $articleFormData['action'] == "AFFICHAGE" ) {
	if ( strlen($articleFormData['SQLnom']) > 0 ) { $sqlClause .= " AND art.arti_name LIKE '%".$articleFormData['SQLnom']."%'"; }
	if ( $articleFormData['SQLlang'] != 0 ) { $sqlClause .= " AND mnu.fk_lang_id = '".$articleFormData['SQLlang']."'"; }
	if ( $articleFormData['SQLdeadline'] != 0 ) { $sqlClause .= " AND bcl.deadline_id = '".$articleFormData['SQLdeadline']."'"; }
}


$dbquery = $bts->SDDMObj->query("
SELECT 
art.arti_ref, art.arti_id, art.arti_name, art.arti_title, art.arti_page, 
mnu.fk_lang_id, 
bcl.deadline_name, bcl.deadline_title, bcl.deadline_state
FROM "
.$SqlTableListObj->getSQLTableName('article')." art, "
.$SqlTableListObj->getSQLTableName('menu')." mnu, "
.$SqlTableListObj->getSQLTableName('deadline')." bcl
WHERE art.arti_ref = mnu.fk_arti_ref
AND art.fk_deadline_id = bcl.deadline_id

AND art.fk_ws_id = bcl.fk_ws_id
AND bcl.fk_ws_id = mnu.fk_ws_id
AND mnu.fk_ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."'

AND mnu.menu_state != '2'
AND mnu.menu_type IN ('1','0')

".$sqlClause."
ORDER BY art.arti_ref,art.arti_page
;");
$T = array();
$articleList = array();
if ( $bts->SDDMObj->num_row_sql($dbquery) != 0 ) {
	while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
		$p = &$articleList[$dbp['arti_ref']][$dbp['arti_id']];
		$p['arti_ref']			= $dbp['arti_ref'];
		$p['arti_id']			= $dbp['arti_id'];
		$p['arti_name']			= $dbp['arti_name'];
		$p['arti_title']		= $dbp['arti_title'];
		$p['arti_page']			= $dbp['arti_page'];
		$p['arti_lang']			= $dbp['lang_id'];
		$p['deadline_state']	= $dbp['deadline_state'];
		$p['deadline_title']	= $dbp['deadline_title'];
	}
	
	$colorState = array(
		"0" => "<span class='".$Block."_avert'>",
		"1" => "<span class='".$Block."_ok'>",
		"2" => "<span class='".$Block."_erreur'>",
	);
	
	unset ($A,$B);
	$i = 1;
	$T['Content']['1'][$i]['1']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_1_txt');
	$T['Content']['1'][$i]['2']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_2_txt');
	$T['Content']['1'][$i]['3']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_3_txt');
	$T['Content']['1'][$i]['4']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_4_txt');
	
	$linkId1 = "<a href='".
	$CurrentSetObj->getInstanceOfServerInfosObj()->getServerInfosEntry('base_url').
	"index.php?"._HYDRLINKURLTAG_."=1".
	"&arti_slug=".$CurrentSetObj->getDataSubEntry ( 'article', 'arti_slug').
	"&arti_ref=".$CurrentSetObj->getDataSubEntry ( 'article', 'arti_ref').
	"&arti_page=2".
	"&formGenericData[mode]=edit".
	"&articleForm[selectionRef]=";
	
	$linkId2 = "&articleForm[selectionPage]=";
	$tranlation = $bts->CMObj->getLanguageListSubEntry($l, 'id');
	$tranlation = $bts->CMObj->getLanguageListSubEntry($tranlation, 'lang_original_name');
	
	foreach ( $articleList as &$A ) {
		$i++;
		$articlePageLink = "";
		unset ($B);
		foreach ( $A as $B ) {
			$T['Content']['1'][$i]['1']['cont'] = $B['arti_ref'];
			$articlePageLink .= $linkId1.$B['arti_ref'].$linkId2.$B['arti_page']."'>".$B['arti_page']."</a>";
			$articlePageLink .= " - ";
			$T['Content']['1'][$i]['3']['cont'] = $langList[$B['arti_lang']]['txt'];
// 			$T['Content']['1'][$i]['3']['tc'] = 1;
			$T['Content']['1'][$i]['4']['cont'] = $colorState[$B['deadline_state']] . $B['deadline_title'] . "</span>";
// 			$T['Content']['1'][$i]['4']['tc'] = 1;
		}
		$articlePageLink = substr ( $articlePageLink , 0 , -3 );
		$T['Content']['1'][$i]['2']['cont'] = $articlePageLink;
	}
}
// --------------------------------------------------------------------------------------------
//
//	Display
//
//
// --------------------------------------------------------------------------------------------
$T['ContentInfos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, 15);
$T['ContentCfg']['tabs'] = array(
		1	=>	$bts->RenderTablesObj->getDefaultTableConfig($i,4,1),
);
$Content .= $bts->RenderTablesObj->render($infos, $T);
$Content .= "<br>\r";

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('Template');
$TemplateObj = Template::getInstance();
$Content .= $TemplateObj->renderAdminCreateButton($infos);

/*Hydr-Content-End*/

// $bts->LMObj->setInternalLogTarget($LOG_TARGET);

?>
