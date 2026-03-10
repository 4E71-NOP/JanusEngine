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



$bts->LMObj->saveVectorSystemLogLevel();
$bts->LMObj->setVectorSystemLogLevel(LOGLEVEL_BREAKPOINT);

$bts->RequestDataObj->setRequestData('layoutForm',
		array(
				'selectionId'	=> 4097719268898732606,
		)
);
$bts->RequestDataObj->setRequestData('formGenericData',
		array(
				'origin'		=> 'AdminDashboard',
				'section'		=> 'AdminLayoutManagementP02',
				'creation'		=> 'on',
				'modification'	=> 'on',
				'deletion'		=> 'on',
				'mode'			=> 'create',
				'mode'			=> 'edit',
				// 'mode'			=> 'delete',
		)
);


/*JanusEngine-Content-Begin*/
$bts->mapSegmentLocation(__METHOD__, "uni_layout_management_p02");

$bts->I18nTransObj->getI18nTransFromDB("uni_layout_management");
$bts->I18nTransObj->getI18nTransFromFile($CurrentSetObj->ServerInfosObj->getServerInfosEntry('DOCUMENT_ROOT') . "/websites-data/00_JanusEngineCore/document/staffTools/i18n/uni_layout_management_p02_");

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('MenuSelectTable');
$MenuSelectTableObj = MenuSelectTable::getInstance();
$tabLayoutFile	= $MenuSelectTableObj->getLayoutFileList();

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('AdminFormTool');
$AdminFormToolObj = AdminFormTool::getInstance();
$Content .= $AdminFormToolObj->checkAdminDashboardForm($infos);

// --------------------------------------------------------------------------------------------
$T = array();

$ClassLoaderObj->provisionClass('Layout');
$currentLayoutObj = new Layout();
switch ($bts->RequestDataObj->getRequestDataSubEntry('formGenericData', 'mode')) {
	case "edit":
		$commandType = "update";
		$currentLayoutObj->getDataFromDB($bts->RequestDataObj->getRequestDataSubEntry('layoutForm', 'selectionId'));		
		$T['Content']['1']['1']['2']['cont'] = $currentLayoutObj->getLayoutEntry('layout_id');
		$T['Content']['1']['2']['2']['cont'] = $currentLayoutObj->getLayoutEntry('layout_name');
		$Content .= "<p>".$bts->I18nTransObj->getI18nTransEntry('invite1')."</p>\r";
		$processStep = "";
		$processTarget = "edit";
		break;
	case "create":
		$commandType = "add";
		
		$d = $bts->TimeObj->getMicrotime();
		$e = $bts->TimeObj->timestampToDate($d);

		$T['Content']['1']['1']['2']['cont'] = "***";
		$T['Content']['1']['2']['2']['cont'] = $bts->RenderFormObj->renderInputText('formParams1[name]',	$currentLayoutObj->getLayoutEntry('layout_name') );
		$processStep = "Create";
		$processTarget = "edit";
		$Content .= "<p>".$bts->I18nTransObj->getI18nTransEntry('invite2')."</p>\r";
		break;
}

// --------------------------------------------------------------------------------------------


$Content .= 
$bts->RenderFormObj->renderformHeader('layoutForm')
.$bts->RenderFormObj->renderHiddenInput(	"formSubmitted"	,				"1")
.$bts->RenderFormObj->renderHiddenInput(	"formGenericData[origin]"	,	"AdminDashboard")
.$bts->RenderFormObj->renderHiddenInput(	"formGenericData[section]"	,	"AdminLayoutManagementP02" )
.$bts->RenderFormObj->renderHiddenInput(	"formCommand1"				,	$commandType )
.$bts->RenderFormObj->renderHiddenInput(	"formEntity1"				,	"layout" )
.$bts->RenderFormObj->renderHiddenInput(	"formGenericData[mode]"		,	$processTarget )
.$bts->RenderFormObj->renderHiddenInput(	"formTarget1[name]"			, 	$currentLayoutObj->getLayoutEntry('layout_name') )
.$bts->RenderFormObj->renderHiddenInput(	"layoutForm[selectionId]"	,	$currentLayoutObj->getLayoutEntry('layout_id') )
."<p>\r"
;


$T['Content']['1']['1']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l1c1');
$T['Content']['1']['2']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l2c1');
$T['Content']['1']['3']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l3c1');
$T['Content']['1']['4']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l4c1');
$T['Content']['1']['5']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l5c1');
$T['Content']['1']['6']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l6c1');

$T['Content']['1']['3']['2']['cont'] = $bts->RenderFormObj->renderInputText('formParams1[title]',			$currentLayoutObj->getLayoutEntry('layout_title'));
$T['Content']['1']['4']['2']['cont'] = $bts->RenderFormObj->renderInputText('formParams1[generic_name]',	$currentLayoutObj->getLayoutEntry('layout_generic_name') );
$T['Content']['1']['5']['2']['cont'] = "<textarea name='formParams1[desc]' style='min-width:384px; min-height:32px;width=100%; height:100%;'>".$currentLayoutObj->getLayoutEntry('layout_desc')."</textarea>\r";


$ClassLoaderObj = ClassLoader::getInstance ();

// LayoutFile
$ClassLoaderObj->provisionClass ( 'LayoutFile' );	// Make sure we got it loaded
$layoutFileTmpObj = new LayoutFile();
$layoutFileTmpObj->getDataFromDB($currentLayoutObj->getLayoutEntry('fk_layout_file_id'));
$T['Content']['1']['6']['2']['cont'] = $bts->RenderFormObj->renderMenuSelect(array(
	'name' => 'formParams1[layout_file_name]',
	'defaultSelected' => $layoutFileTmpObj->getLayoutFileEntry('layout_file_name'),
	'options' => $tabLayoutFile,
));

// --------------------------------------------------------------------------------------------
//
//	Display
//
//
// --------------------------------------------------------------------------------------------
$T['ContentInfos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, 10, 1);
$T['ContentCfg']['tabs'] = array(
		1	=>	$bts->RenderTablesObj->getDefaultTableConfig(6,2,2),
);
$Content .= $bts->RenderTablesObj->render($infos, $T);

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('Template');
$TemplateObj = Template::getInstance();
$infos['formName'] = "articleForm";
$Content .= $TemplateObj->renderAdminFormButtons($infos);

$bts->segmentEnding(__METHOD__);
/*JanusEngine-Content-End*/
$bts->LMObj->restoreVectorSystemLogLevel();

?>
