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
// $LMObj->setInternalLogTarget("both");

$bts->RequestDataObj->setRequestData('test',
		array(
				'test'		=> 1,
		)
		);

/*Hydr-Content-Begin*/
$localisation = " / uni_theme_management_p01";
$bts->MapperObj->AddAnotherLevel($localisation );
$bts->LMObj->logCheckpoint("uni_theme_management_p01.php");
$bts->MapperObj->RemoveThisLevel($localisation );
$bts->MapperObj->setSqlApplicant("uni_theme_management_p01.php");

$bts->I18nTransObj->apply(
	array(
		"type" => "array",
		"fra" => array(
			"invite1"		=> "Cette partie va vous permettre de gérer les themes.",
			"col_1_txt"		=> "Nom",
			"col_2_txt"		=> "Titre",
			"col_3_txt"		=> "date",
			"tabTxt1"		=> "Informations",
			"raf1"			=> "Rien a afficher",
			"btn1"			=> "Créer un theme",
		),
		"eng" => array(
			"invite1"		=> "This part will allow you to manage themes.",
			"col_1_txt"		=> "Name",
			"col_2_txt"		=> "Title",
			"col_3_txt"		=> "date",
			"tabTxt1"		=> "Informations",
			"raf1"			=> "Nothing to display",
			"btn1"			=> "Create a theme",
		)
	)
);
$Content .= $bts->I18nTransObj->getI18nTransEntry('invite1')."<br>\r<br>\r";

// --------------------------------------------------------------------------------------------

$dbquery = $bts->SDDMObj->query("
SELECT td.theme_id, td.theme_name, td.theme_title, td.theme_date 
FROM "
.$SqlTableListObj->getSQLTableName('theme_descriptor')." td, "
.$SqlTableListObj->getSQLTableName('theme_website')." tw 
WHERE td.theme_id = tw.fk_theme_id 
AND tw.fk_ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."' 
;");

$i = 1;
if ( $bts->SDDMObj->num_row_sql($dbquery) == 0 ) {
	$T['Content']['1'][$i]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('nothingToDisplay');
	$T['Content']['1'][$i]['2']['cont'] = "";
	$T['Content']['1'][$i]['3']['cont'] = "";
}
else {
	$T['Content']['1'][$i]['1']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_1_txt');
	$T['Content']['1'][$i]['2']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_2_txt');
	$T['Content']['1'][$i]['3']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_3_txt');
	while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) { 
		$i++;
		$T['Content']['1'][$i]['1']['cont']	= "<a class='".$Block."_lien' href='"
		.$CurrentSetObj->getInstanceOfServerInfosObj()->getServerInfosEntry('base_url')
			."index.php?"._HYDRLINKURLTAG_."=1"
			."&arti_slug=".$CurrentSetObj->getDataSubEntry ( 'article', 'arti_slug')
			."&arti_ref=".$CurrentSetObj->getDataSubEntry ( 'article', 'arti_ref')
			."&arti_page=2"
			."&formGenericData[mode]=edit"
			."&themeForm[selectionId]=".$dbp['theme_id']
			."'>"
			.$dbp['theme_name']
			."</a>\r";
		$T['Content']['1'][$i]['2']['cont']	= $dbp['theme_title'];
		$T['Content']['1'][$i]['3']['cont']	= strftime ("%a %d %b %y - %H:%M",$dbp['theme_date'] );		
		$T['Content']['1'][$i]['2']['tc']	= 2;
		$T['Content']['1'][$i]['3']['tc']	= 1;
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
		1	=>	$bts->RenderTablesObj->getDefaultTableConfig($i,3,1),
);
$Content .= $bts->RenderTablesObj->render($infos, $T);

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('Template');
$TemplateObj = Template::getInstance();
$Content .= $TemplateObj->renderAdminCreateButton($infos);

/*Hydr-Content-End*/

// $LMObj->setInternalLogTarget($LOG_TARGET);

?>
