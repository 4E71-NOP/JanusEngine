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

// --------------------------------------------------------------------------------------------
/*Hydre-contenu_debut*/
$localisation = " / uni_document_management_p01";
$bts->MapperObj->AddAnotherLevel($localisation );
$bts->LMObj->logCheckpoint("uni_document_management_p01.php");
$bts->MapperObj->RemoveThisLevel($localisation );
$bts->MapperObj->setSqlApplicant("uni_document_management_p01.php");

switch ($l) {
	case "fra":
		$bts->I18nTransObj->apply(array(
		"invite1"		=> "Cette partie va vous permettre de gérer les documents.",
		"col_1_txt"		=> "Nom",
		"col_2_txt"		=> "Type",
		"col_3_txt"		=> "Modifiable",
		"tabTxt1"		=> "Informations",
		"docTyp0"		=> "HydrCode",
		"docTyp1"		=> "NoCode",
		"docTyp2"		=> "PHP",
		"docTyp3"		=> "Mixed",
		"docModif0"		=> "Non",
		"docModif1"		=> "Oui",
		));
		break;
	case "eng":
		$bts->I18nTransObj->apply(array(
		"invite1"		=> "This part will allow you to manage documents.",
		"col_1_txt"		=> "Name",
		"col_2_txt"		=> "Type",
		"col_3_txt"		=> "Can be modified",
		"tabTxt1"		=> "Informations",
		"docTyp0"		=> "HydrCode",
		"docTyp1"		=> "NoCode",
		"docTyp2"		=> "PHP",
		"docTyp3"		=> "Mixed",
		"docModif0"		=> "No",
		"docModif1"		=> "Yes",
		));
		break;
}
$Content .= $bts->I18nTransObj->getI18nTransEntry('invite1')."<br>\r<br>\r";

$dbquery = $bts->SDDMObj->query("
SELECT doc.docu_id,doc.docu_name,doc.docu_type,shr.share_modification 
FROM ".$SqlTableListObj->getSQLTableName('document')." doc, ".$SqlTableListObj->getSQLTableName('document_share')." shr 
WHERE shr.ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."' 
AND shr.docu_id = doc.docu_id 
AND doc.docu_origin = '".$WebSiteObj->getWebSiteEntry('ws_id')."' 
;");

$T = array();
if ( $bts->SDDMObj->num_row_sql($dbquery) == 0 ) {
	$i = 1;
	$T['AD']['1'][$i]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('nothingToDisplay');
	$T['AD']['1'][$i]['2']['cont'] = "";
	$T['AD']['1'][$i]['3']['cont'] = "";
}
else {
	
	$type = array (
		0 => $bts->I18nTransObj->getI18nTransEntry('docTyp0'),
		1 => $bts->I18nTransObj->getI18nTransEntry('docTyp1'),
		2 => $bts->I18nTransObj->getI18nTransEntry('docTyp2'),
		3 => $bts->I18nTransObj->getI18nTransEntry('docTyp3'),
	);
	
	$modif = array(
		0 => $bts->I18nTransObj->getI18nTransEntry('docModif0'),
		1 => $bts->I18nTransObj->getI18nTransEntry('docModif1'),
	);
	
	$i = 1;
	$T['AD']['1'][$i]['1']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_1_txt');
	$T['AD']['1'][$i]['2']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_2_txt');
	$T['AD']['1'][$i]['3']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_3_txt');
	
	while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
		$i++;
		$T['AD']['1'][$i]['1']['cont']	= "
		<a class='" . $Block."_lien' href='index.php?"
			."sw=".$WebSiteObj->getWebSiteEntry('ws_id')
			."&l=".$CurrentSetObj->getDataEntry('language')
			."&arti_ref=".$CurrentSetObj->getDataSubEntry('article','arti_ref')
			."&arti_page=2"
			."&formGenericData[mode]=edit"
			."&documentForm[selectionId]=".$dbp['docu_id']
			."'>".$dbp['docu_name']."</a>";
		$T['AD']['1'][$i]['2']['cont']	= $type[$dbp['docu_type']];
		$T['AD']['1'][$i]['3']['cont']	= $modif[$dbp['part_modification']];
	}
}
// --------------------------------------------------------------------------------------------
//
//	Display
//
//
// --------------------------------------------------------------------------------------------
$T['tab_infos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, 15);
$T['ADC']['onglet'] = array(
		1	=>	$bts->RenderTablesObj->getDefaultTableConfig($i,3,1),
);
$Content .= $bts->RenderTablesObj->render($infos, $T);

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('Template');
$TemplateObj = Template::getInstance();
$Content .= $TemplateObj->renderAdminCreateButton($infos);

/*Hydre-contenu_fin*/

// $LMObj->setInternalLogTarget($LOG_TARGET);

?>
