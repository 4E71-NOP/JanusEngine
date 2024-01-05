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

$bts->RequestDataObj->setRequestData('menu_parent', 39);

// --------------------------------------------------------------------------------------------
/*Hydr-Content-Begin*/
$localisation = " / uni_menu_management_p01";
$bts->MapperObj->AddAnotherLevel($localisation );
$bts->LMObj->logCheckpoint("uni_menu_management_p01.php");
$bts->MapperObj->RemoveThisLevel($localisation );
$bts->MapperObj->setSqlApplicant("uni_menu_management_p01.php");

$bts->I18nTransObj->apply(
	array(
		"type" => "array",
		"fra" => array(
			"invite1"		=> "Cette partie va vous permettre de modifier les deadlines.",
			"col_1_txt"		=> "Nom",
			"col_2_txt"		=> "Titre",
			"col_3_txt"		=> "Parent",
			"col_4_txt"		=> "Pos",
			"col_5_txt"		=> "▲/▼",
			"col_6_txt"		=> "Etat",
			"cell_1_txt"	=> "Informations",
			"dlState0"		=> "Hors ligne",
			"dlState1"		=> "En ligne",
			"dlState2"		=> "Supprimé",
		),
		"eng" => array(
			"invite1"		=> "This part will allow you to modify deadlines.",
			"col_1_txt"		=> "Name",
			"col_2_txt"		=> "Title",
			"col_3_txt"		=> "Parent",
			"col_4_txt"		=> "Pos",
			"col_5_txt"		=> "▲/▼",
			"col_6_txt"		=> "Status",
			"cell_1_txt"	=> "Informations",
			"dlState0"		=> "Offline",
			"dlState1"		=> "Online",
			"dlState2"		=> "Deleted",
		)
	)
);
$sqlQuery = "
	SELECT m.fk_lang_id, l.lang_original_name
	FROM ".$SqlTableListObj->getSQLTableName('menu')." m, "
	.$SqlTableListObj->getSQLTableName('language')." l, "
	.$SqlTableListObj->getSQLTableName('language_website')." lw
	WHERE m.menu_type IN ('0','1')
	AND m.menu_state = '1'
	AND m.fk_lang_id = l.lang_id
	AND l.lang_id = lw.fk_lang_id
	AND m.fk_ws_id = lw.fk_ws_id
	AND m.fk_ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."'
	GROUP BY m.fk_lang_id
	;";
	$bts->LMObj->msgLog ( array ('level' => LOGLEVEL_INFORMATION, 'msg' => __METHOD__ . "sqlQuery=`" . $bts->StringFormatObj->formatToLog($sqlQuery)."`."));
	$dbquery = $bts->SDDMObj->query($bts->StringFormatObj->formatToLog($sqlQuery));

$TabListLang = array();
$langClause = "";
$i = 1;
while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) { 
	$TabListLang[$dbp['fk_lang_id']]['tab'] = $i; 
	$TabListLang[$dbp['fk_lang_id']]['id'] = $dbp['fk_lang_id']; 
	$TabListLang[$dbp['fk_lang_id']]['nom'] = $dbp['lang_original_name']; 
	$TabListLang[$dbp['fk_lang_id']]['count'] = 1;
	$TabListLang[$dbp['fk_lang_id']]['linePtr'] = 2;
	$langClause .= $dbp['fk_lang_id'].", ";
	$i++;
}
$bts->LMObj->msgLog ( array ('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . "CateTabList=".$bts->StringFormatObj->arrayToString($TabListLang)));
$bts->LMObj->logDebug($TabListLang, "CateTabList");
$langClause = substr($langClause, 0, -2);
$nbrTabs = $i-1;

// Prepare the chart first line.
$T = array();

reset ($TabListLang);
unset ($A);
foreach ( $TabListLang as $A ) {
	$Tab = $A['tab'];
	$T['Content'][$Tab]['1']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('col_1_txt');
	$T['Content'][$Tab]['1']['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('col_2_txt');
	$T['Content'][$Tab]['1']['3']['cont'] = $bts->I18nTransObj->getI18nTransEntry('col_3_txt');
	$T['Content'][$Tab]['1']['4']['cont'] = $bts->I18nTransObj->getI18nTransEntry('col_4_txt');
	$T['Content'][$Tab]['1']['5']['cont'] = $bts->I18nTransObj->getI18nTransEntry('col_5_txt');
	$T['Content'][$Tab]['1']['6']['cont'] = $bts->I18nTransObj->getI18nTransEntry('col_6_txt');
}
$sqlQuery = "
SELECT m.* 
FROM ".$SqlTableListObj->getSQLTableName('menu')." m, "
.$SqlTableListObj->getSQLTableName('language_website')." lw 
WHERE m.menu_type IN (0,1) 
AND m.menu_state = '1' 
AND m.fk_lang_id IN (".$langClause.") 
AND m.fk_lang_id = lw.fk_lang_id 
AND lw.fk_ws_id = m.fk_ws_id 
AND m.fk_ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."' 
ORDER BY m.fk_lang_id, m.menu_parent, m.menu_position 
;";
$bts->LMObj->msgLog ( array ('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . "sqlQuery=`" . $bts->StringFormatObj->formatToLog($sqlQuery)."`."));
$dbquery = $bts->SDDMObj->query($sqlQuery);

$stateTab = array(
	0	=>	$bts->I18nTransObj->getI18nTransEntry('disabled'),
	1	=>	$bts->I18nTransObj->getI18nTransEntry('enabled'),
);

$buttonLink = "<a href='"
."index.php?"._HYDRLINKURLTAG_."=1"
."&arti_slug=".$CurrentSetObj->getDataSubEntry ( 'article', 'arti_slug')
."&arti_ref=".$CurrentSetObj->getDataSubEntry ( 'article', 'arti_ref')
."&arti_page=1"
;

$buttonUp = "'><img src='".$CurrentSetObj->getInstanceOfServerInfosObj()->getServerInfosEntry('base_url')."media/theme/".$ThemeDataObj->getThemeDataEntry('theme_directory')."/".$ThemeDataObj->getThemeBlockEntry($infos['blockT'],'icon_top')."' width='16' height='16'>"; 
$buttonDown = "'><img src='".$CurrentSetObj->getInstanceOfServerInfosObj()->getServerInfosEntry('base_url')."media/theme/".$ThemeDataObj->getThemeDataEntry('theme_directory')."/".$ThemeDataObj->getThemeBlockEntry($infos['blockT'],'icon_bottom')."' width='16' height='16'>";

$tabListMenu = array();
while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery) ) {
	$tabListMenu[$dbp['menu_id']] = array( 
		'menu_id'		=> $dbp['menu_id'],
		'menu_name'		=> $dbp['menu_name'],
		'menu_title'	=> $dbp['menu_title'],
		'menu_parent'	=> $dbp['menu_parent'],
		'menu_position'	=> $dbp['menu_position'],
		'menu_state'	=> $dbp['menu_state'],
		'fk_lang_id'	=> $dbp['fk_lang_id'],
	);
}


foreach ($tabListMenu as $A ) {
	$Tab = $TabListLang[$A['fk_lang_id']]['tab'];
	$l = $TabListLang[$A['fk_lang_id']]['linePtr'];
	$T['Content'][$Tab][$l]['1']['cont'] = "<a href='"
	."index.php?"._HYDRLINKURLTAG_."=1"
	."&arti_slug=".$CurrentSetObj->getDataSubEntry ('article', 'arti_slug')
	."&arti_ref=".$CurrentSetObj->getDataSubEntry ('article', 'arti_ref')
	."&arti_page=2"
	."&formGenericData[mode]=edit"
	."&menuForm[selectionId]=".$A['menu_id']
	."'>"
	.$A['menu_name']
	."</a>\r";
	$T['Content'][$Tab][$l]['2']['cont'] = $A['menu_title'];
	$T['Content'][$Tab][$l]['3']['cont'] = $tabListMenu[$A['menu_parent']]['menu_name'];
	$T['Content'][$Tab][$l]['4']['cont'] = $A['menu_position'];
	$T['Content'][$Tab][$l]['5']['cont'] = $buttonLink."&menuForm[selection_id]=".$A['menu_id']."&formGenericData[command]=moveUp".$buttonUp."</a>\r - \r".$buttonLink."&menuForm[menu_id]=".$A['menu_id']."&formGenericData[command]=moveDown".$buttonDown."</a>\r";
	$T['Content'][$Tab][$l]['6']['cont'] = $stateTab[$dbp['menu_state']];
	$l++;
	$TabListLang[$A['fk_lang_id']]['count'] = $TabListLang[$A['fk_lang_id']]['linePtr'] = $l;
}

// --------------------------------------------------------------------------------------------
//
//	Display
//
//
// --------------------------------------------------------------------------------------------
reset ($TabListLang);
unset ($A);
foreach ( $TabListLang as $A ) {
	$Tab = $A['tab'];
	$T['ContentCfg']['tabs'][$Tab] = $bts->RenderTablesObj->getDefaultTableConfig($A['count']-1,7,1);
	$bts->I18nTransObj->setI18nTransEntry('tabTxt'.$Tab, $A['nom']);
}
$T['ContentInfos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, 15,$nbrTabs );
$Content .= $bts->RenderTablesObj->render($infos, $T);

// --------------------------------------------------------------------------------------------
// DEPRECATED : 
// Data sorting. Was useful at some point during migration. 
// Wil be removed some day.
function CateRchRacine ( $menu_type, &$src , &$dst ) {
	foreach ( $src as $A ) {
		if ( $A['menu_type'] == $menu_type ) { 
			foreach ( $A as $B => $C ) { $dst['0'][$B] = $C ; }
		}
	}
}

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('Template');
$TemplateObj = Template::getInstance();
$Content .= "<br>\r" . $TemplateObj->renderAdminCreateButton($infos);

/*Hydr-Content-End*/

?>
