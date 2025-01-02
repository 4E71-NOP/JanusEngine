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

/*JanusEngine-Content-Begin*/
$bts->mapSegmentLocation(__METHOD__, "uni_website_list_p01");

$bts->I18nTransObj->apply(
	array(
		"type" => "array",
		"fra" => array(
			"invite1"		=> "Cette partie va vous permettre de voir les sites.",
			"col_1_txt"	=> "Nom",
			"col_2_txt"	=> "Répertoire",
			"col_3_txt"	=> "Lien",
			"link"		 => "Visiter le site",
		),
		"eng" => array(
			"invite1"		=> "This part will show you the websites.",
			"col_1_txt"	=> "Name",
			"col_2_txt"	=> "Directory",
			"col_3_txt"	=> "Link",
			"link"		=> "Visit the website",
		)
	)
);

$Content .= $bts->I18nTransObj->getI18nTransEntry('invite1')."<br>\r<br>\r";

$T = array();
$i = 1;
$T['Content']['1'][$i]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('col_1_txt');
$T['Content']['1'][$i]['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('col_2_txt');
$T['Content']['1'][$i]['3']['cont'] = $bts->I18nTransObj->getI18nTransEntry('col_3_txt');
$i++;

$dbquery = $bts->SDDMObj->query("
SELECT ws_id, ws_name, ws_directory 
FROM ".$SqlTableListObj->getSQLTableName('website')." 
ORDER BY ws_id
;");
while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
	$T['Content']['1'][$i]['1']['cont'] = $dbp['ws_name'];
	$T['Content']['1'][$i]['2']['cont'] = $dbp['ws_directory'];
	$T['Content']['1'][$i]['3']['cont'] = "<a class='" .$Block."_lien " .$Block."_t2' href='index.php?sw=".$dbp['ws_id']."' target='new'>".$bts->I18nTransObj->getI18nTransEntry('link')."</a>";
	$i++;
}

$T['ContentInfos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, $i+1, 0);
$T['ContentInfos']['EnableTabs']		= 0;

$T['ContentCfg']['tabs'] = array(
		1	=>	$bts->RenderTablesObj->getDefaultTableConfig($i+1,3,1),
);
$Content .= $bts->RenderTablesObj->render($infos, $T);

$bts->segmentEnding(__METHOD__);
/*JanusEngine-Content-End*/
?>
