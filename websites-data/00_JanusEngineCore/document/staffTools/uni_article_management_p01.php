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

$bts->RequestDataObj->setRequestData('articleForm',
	array(
		'SQLlang'		=> 48,
		'SQLdeadline'	=> 4,
		'SQLnom'		=> "charg",
		'action'		=> "",
	)
);

/*JanusEngine-Content-Begin*/
$bts->mapSegmentLocation(__METHOD__, "uni_article_management_p01");

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
			"pageSelectorQueryLike"		=>	"Filtrer avec",
			"pageSelectorDisplay"		=>	"Affichage",
			"pageSelectorNbrPerPage"	=>	"entrées par page",
			"pageSelectorBtnFilter"		=>	"Filtrer",
			"pageSelectorDeadline"		=>	"Deadline",
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
			"pageSelectorQueryLike"		=>	"Filter with",
			"pageSelectorDisplay"		=>	"Display",
			"pageSelectorNbrPerPage"	=>	"entries per page",
			"pageSelectorBtnFilter"		=>	"Filter",
			"pageSelectorDeadline"		=>	"Deadline",
		)
	)
);

$Content .="<p>". $bts->I18nTransObj->getI18nTransEntry('invite1')."</p>";
// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('Template');
$TemplateObj = Template::getInstance();
$pageSelectorData['query'] = "";
$pageSelectorData['nbrPerPage'] = $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'nbrPerPage');
if ($pageSelectorData['nbrPerPage'] < 1 ) { $pageSelectorData['nbrPerPage'] = _ADMIN_PAGE_TABLE_DEFAULT_NBR_LINE_; }

$pageSelectorData['clauseElements'] = array();
$pageSelectorData['clauseElements'][] = array("left" => "mnu.fk_ws_id",			"operator" => "=",	"right" => "'".$WebSiteObj->getWebSiteEntry('ws_id')."'" );
$pageSelectorData['clauseElements'][] = array("left" => "art.arti_ref",			"operator" => "=",	"right" => "mnu.fk_arti_ref" );
$pageSelectorData['clauseElements'][] = array("left" => "art.fk_deadline_id",	"operator" => "=",	"right" => "dl.deadline_id" );
$pageSelectorData['clauseElements'][] = array("left" => "art.fk_ws_id",			"operator" => "=",	"right" => "dl.fk_ws_id" );
$pageSelectorData['clauseElements'][] = array("left" => "dl.fk_ws_id",			"operator" => "=",	"right" => "mnu.fk_ws_id" );
$pageSelectorData['clauseElements'][] = array("left" => "mnu.menu_state",		"operator" => "=",	"right" => "'1'" );
$pageSelectorData['clauseElements'][] = array("left" => "mnu.menu_type",		"operator" => "IN",	"right" => "('1','0')" );

if ( strlen($bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'query_like'))>0 ) {
	$pageSelectorData['clauseElements'][] = array( "left" => "art.arti_name", "operator" => "LIKE", "right" => "'%".$bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'query_like')."%'" );
}
$formDeadline = $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'deadline');
if ( strlen($formDeadline)>0 && $formDeadline != 0 ) {
	$pageSelectorData['clauseElements'][] = array( "left" => "dl.deadline_id", "operator" => "=", "right" => $formDeadline );
}

$pageSelectorData['query'] = "SELECT"
." COUNT(art.arti_id) AS ItemsCount "
." FROM "
.$SqlTableListObj->getSQLTableName('article')." art, "
.$SqlTableListObj->getSQLTableName('menu')." mnu, "
.$SqlTableListObj->getSQLTableName('deadline')." dl "
.$bts->SddmToolsObj->makeQueryClause($pageSelectorData['clauseElements'])
.";"
;

$dbquery = $bts->SDDMObj->query($pageSelectorData['query']);
while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) { $pageSelectorData['ItemsCount'] = $dbp['ItemsCount']; }

if ( $pageSelectorData['ItemsCount'] > $pageSelectorData['nbrPerPage'] ) {
	if ( strlen($bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'query_like'))>0 )	{$strQueryLike	= "&filterForm[query_like]="	.$bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'query_like');}
	if ( strlen($bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'nbrPerPage'))>0 )	{$strNbrPerPage	= "&filterForm[nbrPerPage]="	.$bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'nbrPerPage');}

	$pageSelectorData['link'] = $strQueryLike . $strGroupId . $strUserStatus . $strNbrPerPage;
	$pageSelectorData['elmIn'] = "<div class='".$Block."_page_selector'>";
	$pageSelectorData['elmInHighlight'] = "<div class='".$Block."_page_selector_highlight'>";
	$pageSelectorData['elmOut'] = "</div>";
	$pageSelectorData['selectionOffset'] = "".$bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'selectionOffset');
	$Content .= $TemplateObj->renderPageSelector($pageSelectorData);
}

// --------------------------------------------------------------------------------------------
$langList = $bts->CMObj->getLanguageList();
$bts->LMObj->msgLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . "langList=" . $bts->StringFormatObj->arrayToString($langList)));

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
if ( strlen($bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'deadline')) > 0 ) { $listDeadline[$bts->RequestDataObj->getRequestDataEntry('SQLdeadline')]['s'] = "selected"; }

$tdStyle = " style='margin:0.1cm;'";
$infos['insertLines'] = "<!-- deadline select -->"
."<tr>\r"
."<td ".$tdStyle.">".$bts->I18nTransObj->getI18nTransEntry('pageSelectorDeadline')."</td>\r"
."<td ".$tdStyle.">"
."<select name='articleForm[SQLdeadline]'>"
;

unset ( $A , $B );
foreach ( $listDeadline as $A ) {
	$infos['insertLines'] .= "<option value='".$A['id']."' ".$A['selected'].">".$A['deadline_title']." / ".$A['deadline_name']."</option>\r";
}

$infos['insertLines'] .= $bts->I18nTransObj->getI18nTransEntry('pageSelectorNbrPerPage')
."</select>\r"
."</td>\r"
."</tr>\r"
;
// --------------------------------------------------------------------------------------------

$dbquery = $bts->SDDMObj->query("SELECT "
."art.arti_ref, art.arti_id, art.arti_name, art.arti_title, art.arti_page, "
."mnu.fk_lang_id, "
."dl.deadline_name, dl.deadline_title, dl.deadline_state "
."FROM "
.$SqlTableListObj->getSQLTableName('article')." art, "
.$SqlTableListObj->getSQLTableName('menu')." mnu, "
.$SqlTableListObj->getSQLTableName('deadline')." dl "
.$bts->SddmToolsObj->makeQueryClause($pageSelectorData['clauseElements'])
." ORDER BY art.arti_ref,art.arti_page"
." LIMIT ".$pageSelectorData['nbrPerPage'].", OFFSET ".($pageSelectorData['nbrPerPage'] * $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'selectionOffset'))
.";");

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
	
	$linkId1 = "<a href='"
	."index.php?"._JNSENGLINKURLTAG_."=1"
	."&arti_slug=".$CurrentSetObj->getDataSubEntry ( 'article', 'arti_slug')
	."&arti_ref=".$CurrentSetObj->getDataSubEntry ( 'article', 'arti_ref')
	."&arti_page=2"
	."&formGenericData[mode]=edit"
	."&articleForm[selectionId]=";
	
	// $linkId2 = "&formGenericData[selectionPage]=";
	// $tranlation = $bts->CMObj->getLanguageListSubEntry($l, 'id');
	// $tranlation = $bts->CMObj->getLanguageListSubEntry($tranlation, 'lang_original_name');
	
	foreach ( $articleList as &$A ) {
		$i++;
		$articlePageLink = "";
		unset ($B);
		foreach ( $A as $B ) {
			$T['Content']['1'][$i]['1']['cont'] = $B['arti_ref'];
			$articlePageLink .= $linkId1.$B['arti_id']."'>".$B['arti_page']."</a>";
			// $articlePageLink .= $linkId1.$B['arti_id'].$linkId2.$B['arti_page']."'>".$B['arti_page']."</a>";
			$articlePageLink .= " - ";
			$T['Content']['1'][$i]['3']['cont'] = $langList[$B['arti_lang']]['txt'];
			$T['Content']['1'][$i]['4']['cont'] = $colorState[$B['deadline_state']] . $B['deadline_title'] . "</span>";
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
$Content .= $bts->RenderTablesObj->render($infos, $T)
."<br>\r"
.$TemplateObj->renderFilterForm($infos)
.$TemplateObj->renderAdminCreateButton($infos)
;

$bts->segmentEnding(__METHOD__);

// --------------------------------------------------------------------------------------------
/*JanusEngine-Content-End*/
?>
