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

$LOG_TARGET = $LMObj->getInternalLogTarget();
$LMObj->setInternalLogTarget("both");

$RequestDataObj->setRequestData('test',
		array(
				'test'		=> 1,
		)
		);

/*Hydre-contenu_debut*/
$localisation = " / uni_gestion_des_themes_p01";
$MapperObj->AddAnotherLevel($localisation );
$LMObj->logCheckpoint("uni_gestion_des_themes_p01");
$MapperObj->RemoveThisLevel($localisation );
$MapperObj->setSqlApplicant("uni_gestion_des_themes_p01");

switch ($l) {
	case "fra":
		$I18nObj->apply(array(
		"invite1"		=> "Cette partie va vous permettre de gérer les themes.",
		"col_1_txt"		=> "Nom",
		"col_2_txt"		=> "Titre",
		"col_3_txt"		=> "date",
		"tabTxt1"		=> "Informations",
		"raf1"			=> "Rien a afficher",
		"btn1"			=> "Créer un theme",
		));
		break;
	case "eng":
		$I18nObj->apply(array(
		"invite1"		=> "This part will allow you to manage themes.",
		"col_1_txt"		=> "Name",
		"col_2_txt"		=> "Title",
		"col_3_txt"		=> "date",
		"tabTxt1"		=> "Informations",
		"raf1"			=> "Nothing to display",
		"btn1"			=> "Create a theme",
		));
		break;
}
$Content .= $I18nObj->getI18nEntry('invite1')."<br>\r<br>\r";

// --------------------------------------------------------------------------------------------

$dbquery = $SDDMObj->query("
SELECT s.theme_id, s.theme_name, s.theme_title, s.theme_date 
FROM ".$SqlTableListObj->getSQLTableName('theme_descriptor')." s, ".$SqlTableListObj->getSQLTableName('theme_website')." ss 
WHERE s.theme_id = ss.theme_id 
AND ss.ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."' 
;");

$i = 1;
if ( $SDDMObj->num_row_sql($dbquery) == 0 ) {
	$T['AD']['1'][$i]['1']['cont'] = $I18nObj->getI18nEntry('nothingToDisplay');
	$T['AD']['1'][$i]['2']['cont'] = "";
	$T['AD']['1'][$i]['3']['cont'] = "";
}
else {
	$T['AD']['1'][$i]['1']['cont']	= $I18nObj->getI18nEntry('col_1_txt');
	$T['AD']['1'][$i]['2']['cont']	= $I18nObj->getI18nEntry('col_2_txt');
	$T['AD']['1'][$i]['3']['cont']	= $I18nObj->getI18nEntry('col_3_txt');
	while ($dbp = $SDDMObj->fetch_array_sql($dbquery)) { 
		$i++;
		$T['AD']['1'][$i]['1']['cont']	= "<a class='".$Block."_lien' href='index.php?"
			."sw=".$WebSiteObj->getWebSiteEntry('ws_id')
			."&l=".$CurrentSetObj->getDataEntry('language')
			."&arti_ref=".$CurrentSetObj->getDataSubEntry('article','arti_ref')
			."&arti_page=2"
			."&formGenericData[mode]=edit"
			."&themeForm[selectionId]=".$dbp['theme_id']
			."'>"
			.$dbp['theme_name']
			."</a>\r";
		$T['AD']['1'][$i]['2']['cont']	= $dbp['theme_title'];
		$T['AD']['1'][$i]['3']['cont']	= strftime ("%a %d %b %y - %H:%M",$dbp['theme_date'] );		
		$T['AD']['1'][$i]['2']['tc']	= 2;
		$T['AD']['1'][$i]['3']['tc']	= 1;
	}
}

// --------------------------------------------------------------------------------------------
//
//	Display
//
//
// --------------------------------------------------------------------------------------------
$T['tab_infos'] = $RenderTablesObj->getDefaultDocumentConfig($infos, 15);
$T['ADC']['onglet'] = array(
		1	=>	$RenderTablesObj->getDefaultTableConfig($i,3,1),
);
$Content .= $RenderTablesObj->render($infos, $T);

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('Template');
$TemplateObj = Template::getInstance();
$Content .= $TemplateObj->renderAdminCreateButton($infos);

/*Hydre-contenu_fin*/

$LMObj->setInternalLogTarget($LOG_TARGET);

?>
