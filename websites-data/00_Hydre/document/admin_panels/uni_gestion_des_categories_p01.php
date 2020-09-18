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

$RequestDataObj->setRequestData('cate_parent', 39);

// --------------------------------------------------------------------------------------------
/*Hydre-contenu_debut*/
$localisation = " / uni_gestion_des_categories_p01";
$MapperObj->AddAnotherLevel($localisation );
$LMObj->logCheckpoint("uni_gestion_des_categories_p01");
$MapperObj->RemoveThisLevel($localisation );
$MapperObj->setSqlApplicant("uni_gestion_des_categories_p01");

$logTarget = $LMObj->getInternalLogTarget();
$LMObj->setInternalLogTarget("both");

switch ($l) {
	case "fra":
		$I18nObj->apply(array(
		"invite1"		=> "Cette partie va vous permettre de modifier les deadlines.",
		"col_1_txt"		=> "Id",
		"col_2_txt"		=> "Nom",
		"col_3_txt"		=> "Titre",
		"col_4_txt"		=> "Parent",
		"col_5_txt"		=> "Pos",
		"col_6_txt"		=> "▲/▼",
		"col_7_txt"		=> "Etat",
		"cell_1_txt"	=> "Informations",
		"dlState0"		=> "Hors ligne",
		"dlState1"		=> "En ligne",
		"dlState2"		=> "Supprimé",
		));
		break;
	case "eng":
		$I18nObj->apply(array(
		"invite1"		=> "This part will allow you to modify deadlines.",
		"col_1_txt"		=> "Id",
		"col_2_txt"		=> "Name",
		"col_3_txt"		=> "Title",
		"col_4_txt"		=> "Parent",
		"col_5_txt"		=> "Pos",
		"col_6_txt"		=> "▲/▼",
		"col_7_txt"		=> "Status",
		"cell_1_txt"	=> "Informations",
		"dlState0"		=> "Offline",
		"dlState1"		=> "Online",
		"dlState2"		=> "Deleted",
		));
		break;
}

$dbquery = $SDDMObj->query("
SELECT c.cate_lang, l.lang_original_name
FROM ".$SqlTableListObj->getSQLTableName('categorie')." c, ".$SqlTableListObj->getSQLTableName('language')." l, ".$SqlTableListObj->getSQLTableName('language_website')." sl
WHERE c.cate_type IN ('0','1')
AND c.cate_etat = '1'
AND c.ws_id = '2'
AND c.cate_lang = l.lang_id
AND l.lang_id = sl.lang_id
AND c.ws_id = sl.ws_id
AND c.ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."'
GROUP BY c.cate_lang
;");

$CateTabList = array();
$langClause = "";
$i = 1;
while ($dbp = $SDDMObj->fetch_array_sql($dbquery)) { 
	$CateTabList[$dbp['cate_lang']]['tab'] = $i; 
	$CateTabList[$dbp['cate_lang']]['id'] = $dbp['cate_lang']; 
	$CateTabList[$dbp['cate_lang']]['nom'] = $dbp['lang_original_name']; 
	$CateTabList[$dbp['cate_lang']]['count'] = 1;
	$CateTabList[$dbp['cate_lang']]['linePtr'] = 2;
	$langClause .= $dbp['cate_lang'].", ";
	$i++;
}

$LMObj->logDebug($CateTabList, "CateTabList");

$langClause = substr($langClause, 0, -2);
$nbrTabs = $i-1;

// Prepare the chart first line.
$T = array();

reset ($CateTabList);
unset ($A);
foreach ( $CateTabList as $A ) {
	$Tab = $A['tab'];
	$T['AD'][$Tab]['1']['1']['cont'] = $I18nObj->getI18nEntry('col_1_txt');
	$T['AD'][$Tab]['1']['2']['cont'] = $I18nObj->getI18nEntry('col_2_txt');
	$T['AD'][$Tab]['1']['3']['cont'] = $I18nObj->getI18nEntry('col_3_txt');
	$T['AD'][$Tab]['1']['4']['cont'] = $I18nObj->getI18nEntry('col_4_txt');
	$T['AD'][$Tab]['1']['5']['cont'] = $I18nObj->getI18nEntry('col_5_txt');
	$T['AD'][$Tab]['1']['6']['cont'] = $I18nObj->getI18nEntry('col_6_txt');
	$T['AD'][$Tab]['1']['7']['cont'] = $I18nObj->getI18nEntry('col_7_txt');
}

$dbquery = $SDDMObj->query("SELECT * 
FROM ".$SqlTableListObj->getSQLTableName('categorie')." c, ".$SqlTableListObj->getSQLTableName('language_website')." sl, ".$SqlTableListObj->getSQLTableName('website')." sw 
WHERE c.cate_type IN (0,1) 
AND c.cate_etat = '1' 
AND c.cate_lang IN (".$langClause.") 
AND c.cate_lang = sl.lang_id 
AND sl.ws_id = sw.ws_id 
AND sw.ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."' 
ORDER BY c.cate_lang, c.cate_parent, c.cate_position 
;");

$stateTab = array(
	0	=>	$I18nObj->getI18nEntry('disabled'),
	1	=>	$I18nObj->getI18nEntry('enabled'),
);

$buttonLink = "<a href='index.php?arti_ref=".$CurrentSetObj->getDataSubEntry('article', 'arti_ref')."&arti_page=".$CurrentSetObj->getDataSubEntry('article', 'arti_page'); 
$buttonUp = "'><img src='../graph/".$ThemeDataObj->getThemeBlockEntry($infos['blockT'],'repertoire')."/".$ThemeDataObj->getThemeBlockEntry($infos['blockT'],'icone_haut')."' width='16' height='16'>"; 
$buttonDown = "'><img src='../graph/".$ThemeDataObj->getThemeBlockEntry($infos['blockT'],'repertoire')."/".$ThemeDataObj->getThemeBlockEntry($infos['blockT'],'icone_bas')."' width='16' height='16'>";

while ($dbp = $SDDMObj->fetch_array_sql($dbquery) ) {
	$Tab = $CateTabList[$dbp['cate_lang']]['tab'];
	$l = $CateTabList[$dbp['cate_lang']]['linePtr'];
	$T['AD'][$Tab][$l]['1']['cont'] = $dbp['cate_id'];
	$T['AD'][$Tab][$l]['1']['tc'] = 1;
	$T['AD'][$Tab][$l]['1']['style'] = "text-align:center;";
	$T['AD'][$Tab][$l]['2']['cont'] =
		"<a class='".$Block."_lien' href='index.php?"
		."sw=".$WebSiteObj->getWebSiteEntry('ws_id')
		."&l=".$CurrentSetObj->getDataEntry('language')
		."&arti_ref=".$CurrentSetObj->getDataSubEntry('article','arti_ref')
		."&arti_page=2"
		."&formGenericData[mode]=edit"
		."&categoryForm[selectionId]=".$dbp['cate_id']
		."'>".$dbp['cate_nom']."</a>";
	$T['AD'][$Tab][$l]['3']['cont'] = $dbp['cate_titre'];
	$T['AD'][$Tab][$l]['4']['cont'] = $dbp['cate_parent'];
	$T['AD'][$Tab][$l]['4']['tc'] = 1;
	$T['AD'][$Tab][$l]['4']['style'] = "text-align:center;";
	$T['AD'][$Tab][$l]['5']['cont'] = $dbp['cate_position'];
	$T['AD'][$Tab][$l]['5']['tc'] = 1;
	$T['AD'][$Tab][$l]['5']['style'] = "text-align:center;";
	$T['AD'][$Tab][$l]['6']['cont'] = $buttonLink."&categoryForm[cate_id]=".$dbp['cate_id']."&categoryForm[command]=moveUp".$buttonUp."</a>\r - \r".$buttonLink."&categoryForm[cate_id]=".$dbp['cate_id']."&categoryForm[command]=moveDown".$buttonDown."</a>\r";
	$T['AD'][$Tab][$l]['7']['cont'] = $stateTab[$dbp['cate_etat']];
	$T['AD'][$Tab][$l]['7']['tc'] = 1;
	$l++;
	$CateTabList[$dbp['cate_lang']]['count'] = $CateTabList[$dbp['cate_lang']]['linePtr'] = $l;
}


// --------------------------------------------------------------------------------------------
//
//	Display
//
//
// --------------------------------------------------------------------------------------------
reset ($CateTabList);
unset ($A);
foreach ( $CateTabList as $A ) {
	$Tab = $A['tab'];
	$T['ADC']['onglet'][$Tab] = $RenderTablesObj->getDefaultTableConfig($A['count']-1,7,1);
	$I18nObj->setI18nEntry('tabTxt'.$Tab, $A['nom']);
}
$T['tab_infos'] = $RenderTablesObj->getDefaultDocumentConfig($infos, 15,$nbrTabs );
$Content .= $RenderTablesObj->render($infos, $T);

// --------------------------------------------------------------------------------------------
// DEPRECATED : 
// Data sorting. Was useful at some point during migration. 
// Wil be removed some day.
function CateRchRacine ( $cate_type, &$src , &$dst ) {
	foreach ( $src as $A ) {
		if ( $A['cate_type'] == $cate_type ) { 
			foreach ( $A as $B => $C ) { $dst['0'][$B] = $C ; }
		}
	}
}

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('Template');
$TemplateObj = Template::getInstance();
$Content .= $TemplateObj->renderAdminCreateButton($infos);

/*Hydre-contenu_fin*/

$LMObj->setInternalLogTarget($logTarget);

?>
