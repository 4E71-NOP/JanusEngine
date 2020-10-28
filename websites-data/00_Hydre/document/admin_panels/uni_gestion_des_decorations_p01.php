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

$localisation = " / uni_gestion_des_decorations_p01";
$MapperObj->AddAnotherLevel($localisation );
$LMObj->logCheckpoint("uni_gestion_des_decorations_p01");
$MapperObj->RemoveThisLevel($localisation );
$MapperObj->setSqlApplicant("uni_gestion_des_decorations_p01");

switch ($l) {
	case "fra":
		$I18nObj->apply(array(
		"invite1"		=> "Cette partie va vous permettre de gerer les d&eacute;corations.",
		"col_1_txt"		=> "Nom",
		"col_2_txt"		=> "Etat",
		"col_3_txt"		=> "Type",
		"tabTxt1"		=> "Informations",
		"type"			=> array(
			10	=>	"Menu",
			20	=>	"Caligraphe",
			30	=>	"1_DIV",
			40	=>	"Elegance",
			50	=>	"Exquise",
			60	=>	"Elysion",
		),
		"state"			=> array(
			0	=> "Offline",
			1	=> "Online",
			2	=> "Deleted",
			),
		));
		break;
	case "eng":
		$I18nObj->apply(array(
		"invite1"		=> "This part will allow you to manage decoration.",
		"col_1_txt"		=> "Name",
		"col_2_txt"		=> "State",
		"col_3_txt"		=> "Type",
		"tabTxt1"		=> "Informations",
		"type"			=> array(
			10	=>	"Menu",
			20	=>	"Caligrapher",
			30	=>	"1_DIV",
			40	=>	"Elegance",
			50	=>	"Exquisite",
			60	=>	"Elysion",
			),
		"state"			=> array(
			0	=> "Offline",
			1	=> "Online",
			2	=> "Deleted",
			),
		));
		break;
}
$Content .= $I18nObj->getI18nEntry('invite1')."<br>\r<br>\r";

// --------------------------------------------------------------------------------------------
$dbquery = $SDDMObj->query("
SELECT * 
FROM ".$SqlTableListObj->getSQLTableName('decoration')." 
;");

$T = array();
if ( $SDDMObj->num_row_sql($dbquery) == 0 ) {
	$i = 1;
	$T['AD']['1'][$i]['1']['cont'] = $I18nObj->getI18nEntry('nothingToDisplay');
	$T['AD']['1'][$i]['2']['cont'] = "";
	$T['AD']['1'][$i]['3']['cont'] = "";
}
else {
	$i = 1;
	$T['AD']['1'][$i]['1']['cont']	= $I18nObj->getI18nEntry('col_1_txt');
	$T['AD']['1'][$i]['2']['cont']	= $I18nObj->getI18nEntry('col_2_txt');
	$T['AD']['1'][$i]['3']['cont']	= $I18nObj->getI18nEntry('col_3_txt');

	$i = 1;
	while ($dbp = $SDDMObj->fetch_array_sql($dbquery)) { 
		$i++;
		$T['AD']['1'][$i]['1']['cont']	= "
		<a class='".$Block."_lien' href='index.php?"
		."sw=".$WebSiteObj->getWebSiteEntry('ws_id')
		."&l=".$CurrentSetObj->getDataEntry('language')
		."&arti_ref=".$CurrentSetObj->getDataSubEntry('article','arti_ref')
		."&arti_page=2"
		."&formGenericData[mode]=edit"
		."&decorationForm[selectionId]=".$dbp['deco_ref_id']
		."'>".$dbp['deco_name']."</a>";
		$T['AD']['1'][$i]['2']['cont']	= $I18nObj->getI18nEntry('state')[$dbp['deco_state']];
		$T['AD']['1'][$i]['3']['cont']	= $I18nObj->getI18nEntry('type')[$dbp['deco_type']];
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
