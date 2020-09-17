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
$localisation = " / uni_gestion_des_bouclages_p01";
$MapperObj->AddAnotherLevel($localisation );
$LMObj->logCheckpoint("uni_gestion_des_bouclages_p01");
$MapperObj->RemoveThisLevel($localisation );
$MapperObj->setSqlApplicant("uni_gestion_des_bouclages_p01");

switch ($l) {
	case "fra":
		$I18nObj->apply(array(
		"invite1"		=> "Cette partie va vous permettre de gérer les bouclages.",
		"col_1_txt"		=> "Nom",
		"col_2_txt"		=> "Etat",
		"col_3_txt"		=> "Date",
		"tabTxt1"		=> "Informations",
		"dlState0"		=> "Hors ligne",
		"dlState1"		=> "En ligne",
		"dlState2"		=> "Supprimé",
		));
		break;
	case "eng":
		$I18nObj->apply(array(
		"invite1"		=> "This part will allow you to manage deadlines.",
		"col_1_txt"		=> "Name",
		"col_2_txt"		=> "Status",
		"col_3_txt"		=> "Date",
		"tabTxt1"		=> "Informations",
		"dlState0"		=> "Offline",
		"dlState1"		=> "Online",
		"dlState2"		=> "Deleted",
		));
		break;
}

// --------------------------------------------------------------------------------------------
$dbquery = $SDDMObj->query("
SELECT bcl.*,usr.user_login 
FROM ".$SqlTableListObj->getSQLTableName('bouclage')." bcl , ".$SqlTableListObj->getSQLTableName('user')." usr 
WHERE site_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."' 
AND usr.user_id = bcl.user_id
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

	
	$linkId1 = "<a class='".$Block."_lien' href='index.php?sw="
			.$WebSiteObj->getWebSiteEntry('ws_id')
			."&arti_ref=".$CurrentSetObj->getDataSubEntry('article','arti_ref')
			."&arti_page=2"
			."&l=".$CurrentSetObj->getDataEntry('language')
			."&deadlineForm[mode]=edit"
			."&deadlineForm[selectionId]="
			;
	
	$tabState = array(
		0	=> $I18nObj->getI18nEntry('dlState0'),
		1	=> $I18nObj->getI18nEntry('dlState1'),
		2	=> $I18nObj->getI18nEntry('dlState2'),
	);
	while ($dbp = $SDDMObj->fetch_array_sql($dbquery)) {
		$i++;
		$T['AD']['1'][$i]['1']['cont']	= $linkId1.$dbp['bouclage_id']."'>".$dbp['bouclage_titre']."</a>";
		$T['AD']['1'][$i]['2']['cont']	= $tabState[$dbp['bouclage_etat']];
		$T['AD']['1'][$i]['3']['cont']	= date ( "Y m d H:i:s" , $dbp['bouclage_date_limite']);
		$T['AD']['1'][$i]['2']['tc']	= 1;
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

$LMObj->setInternalLogTarget($logTarget);

?>
