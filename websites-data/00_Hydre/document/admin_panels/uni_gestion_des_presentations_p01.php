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

$RequestDataObj->setRequestData('test',
		array(
				'test'		=> 1,
		)
		);

/*Hydre-contenu_debut*/
$localisation = " / uni_gestion_des_presentations_p01";
$MapperObj->AddAnotherLevel($localisation );
$LMObj->logCheckpoint("uni_gestion_des_presentations_p01");
$MapperObj->RemoveThisLevel($localisation );
$MapperObj->setSqlApplicant("uni_gestion_des_presentations_p01");

switch ($l) {
	case "fra":
		$I18nObj->apply(array(
		"invite1"		=> "Cette partie va vous permettre de gérer les présentations.",
		"col_1_txt"		=> "Nom",
		"col_2_txt"		=> "Nom générique",
		"col_3_txt"		=> "Theme",
		"tabTxt1"		=> "Informations",
		"raf1"			=> "Rien a afficher",
		"btn1"			=> "Filtrer",
		));
		break;
	case "eng":
		$I18nObj->apply(array(
		"invite1"		=> "This part will allow you to manage layouts.",
		"col_1_txt"		=> "Name",
		"col_2_txt"		=> "Generic name",
		"col_3_txt"		=> "Theme",
		"tabTxt1"		=> "Informations",
		"raf1"			=> "Nothing to display",
		"btn1"			=> "Filter",
		));
		break;
}

$Content .="<p>". $I18nObj->getI18nEntry('invite1')."</p>";

$dbquery = $SDDMObj->query("
SELECT pr.*, sd.theme_titre
FROM ".$SqlTableListObj->getSQLTableName('presentation')." pr, ".$SqlTableListObj->getSQLTableName('theme_presentation')." sp, ".$SqlTableListObj->getSQLTableName('site_theme')." ss, ".$SqlTableListObj->getSQLTableName('theme_descripteur')." sd 
WHERE ss.site_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."' 
AND sp.theme_id = ss.theme_id 
AND ss.theme_id = sd.theme_id
AND sp.pres_id = pr.pres_id 
ORDER BY pr.pres_id
;");

if ( $SDDMObj->num_row_sql($dbquery) == 0 ) {
	$i = 1;
	$T['AD']['1'][$i]['1']['cont'] = $I18nObj->getI18nEntry('raf1');
	$T['AD']['1'][$i]['2']['cont'] = "";
	$T['AD']['1'][$i]['3']['cont'] = "";
}
else {
	$i = 1;
	$T['AD']['1'][$i]['1']['cont']	= $I18nObj->getI18nEntry('col_1_txt');
	$T['AD']['1'][$i]['2']['cont']	= $I18nObj->getI18nEntry('col_2_txt');
	$T['AD']['1'][$i]['3']['cont']	= $I18nObj->getI18nEntry('col_3_txt');
	while ($dbp = $SDDMObj->fetch_array_sql($dbquery)) { 
		$i++;
		$T['AD']['1'][$i]['1']['cont']	= "
		<a class='".$Block."_lien' href='index.php?
		&amp;uni_gestion_des_presentation_p=2
		&amp;M_PRESNT[pres_id]=".$dbp['pres_id']. 
		$CurrentSetObj->getDataSubEntry('block_HTML', 'url_sldup').
		"&amp;arti_page=2'
		>".$dbp['pres_nom']."</a>";
		$T['AD']['1'][$i]['2']['cont']	= $dbp['pres_titre'];
		$T['AD']['1'][$i]['3']['cont']	= $dbp['theme_titre'];
	}
}


$T['tab_infos'] = $RenderTablesObj->getDefaultDocumentConfig($infos, 10, 1);
$T['ADC']['onglet'] = array(
		1	=>	$RenderTablesObj->getDefaultTableConfig($i,3,1),
);
$Content .= $RenderTablesObj->render($infos, $T);

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('Template');
$TemplateObj = Template::getInstance();
$Content .= $TemplateObj->renderAdminCreateButton($infos);

/*Hydre-contenu_fin*/

$LMObj->setInternalLogTarget($logTarget);

?>
