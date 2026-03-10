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

$bts->RequestDataObj->setRequestData('articleForm',
		array(
				'selectionId'	=> 1024977694751394116,
		)
);
$bts->RequestDataObj->setRequestData('formGenericData',
		array(
				'origin'		=> 'AdminDashboard',
				'section'		=> 'AdminArticleManagementP02',
				'creation'		=> 'on',
				'modification'	=> 'on',
				'deletion'		=> 'on',
				'mode'			=> 'create',
				'mode'			=> 'edit',
				// 'mode'			=> 'delete',
		)
);

/*JanusEngine-Content-Begin*/
$bts->mapSegmentLocation(__METHOD__, "uni_article_validation_p02");

$bts->I18nTransObj->getI18nTransFromDB("uni_article_validation");
$bts->I18nTransObj->getI18nTransFromFile($CurrentSetObj->ServerInfosObj->getServerInfosEntry('DOCUMENT_ROOT') . "/websites-data/00_JanusEngineCore/document/staffTools/i18n/uni_article_validation_p02_");

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('MenuSelectTable');
$MenuSelectTableObj = MenuSelectTable::getInstance();

$tabUser		= $MenuSelectTableObj->getUserList();
$tabDeadline	= $MenuSelectTableObj->getDeadlineList();
$tabLayout		= $MenuSelectTableObj->getLayoutList();
$tabDocument	= $MenuSelectTableObj->getDocumentList();

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('AdminFormTool');
$AdminFormToolObj = AdminFormTool::getInstance();
$Content .= $AdminFormToolObj->checkAdminDashboardForm($infos);

// --------------------------------------------------------------------------------------------
$T = array();

$ClassLoaderObj->provisionClass('Article');
$currentArticleObj = new Article();
switch ($bts->RequestDataObj->getRequestDataSubEntry('formGenericData', 'mode')) {
	case "edit":
		$commandType = "update";
		$currentArticleObj->getDataFromDB($bts->RequestDataObj->getRequestDataSubEntry('articleForm', 'selectionId'));
		
		$T['Content']['1']['1']['2']['cont'] = $currentArticleObj->getArticleEntry('arti_id');
		$T['Content']['1']['2']['2']['cont'] = $currentArticleObj->getArticleEntry('arti_name');
		$Content .= "<p>".$bts->I18nTransObj->getI18nTransEntry('invite1')."</p>\r";
		$processStep = "";
		$processTarget = "edit";
		break;
	case "create":
		$commandType = "add";
		
		$d = $bts->TimeObj->getMicrotime();
		$e = $bts->TimeObj->timestampToDate($d);

		$T['Content']['1']['1']['2']['cont'] = "***";
		$T['Content']['1']['2']['2']['cont'] = $bts->RenderFormObj->renderInputText('formParams1[name]',	"NewArticle".time() );
		$processStep = "Create";
		$processTarget = "edit";
		$Content .= "<p>".$bts->I18nTransObj->getI18nTransEntry('invite2')."</p>\r";
		break;
}

// --------------------------------------------------------------------------------------------
$Content .= 
$bts->RenderFormObj->renderformHeader('articleForm')
.$bts->RenderFormObj->renderHiddenInput(	"formSubmitted"	,					"1")
.$bts->RenderFormObj->renderHiddenInput(	"formGenericData[origin]"		,	"AdminDashboard")
.$bts->RenderFormObj->renderHiddenInput(	"formGenericData[section]"		,	"AdminArticleValidationP02" )
.$bts->RenderFormObj->renderHiddenInput(	"formCommand1"					,	$commandType )
.$bts->RenderFormObj->renderHiddenInput(	"formEntity1"					,	"article" )
.$bts->RenderFormObj->renderHiddenInput(	"formGenericData[mode]"			,	$processTarget )
.$bts->RenderFormObj->renderHiddenInput(	"formTarget1[name]"				, 	$currentArticleObj->getArticleEntry('arti_name') )
.$bts->RenderFormObj->renderHiddenInput(	"articleForm[selectionId]"		,	$currentArticleObj->getArticleEntry('arti_id'))
.$bts->RenderFormObj->renderHiddenInput(	"formTarget1[validator]"		, 	$CurrentSetObj->UserObj->getUserEntry ( 'user_login' ) )
.$bts->RenderFormObj->renderHiddenInput(	"formTarget1[validation_date]"	, 	time()  )
.$bts->RenderFormObj->renderHiddenInput(	"formTarget1[validation_state]"	, 	"VALID" )
."<p>\r"
;

$T['Content']['1']['1']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l1c1');
$T['Content']['1']['2']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l2c1');
$T['Content']['1']['3']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l3c1');
$T['Content']['1']['4']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l4c1');
$T['Content']['1']['5']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l5c1');
$T['Content']['1']['6']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l6c1');
$T['Content']['1']['7']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l7c1');
$T['Content']['1']['8']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l8c1');
$T['Content']['1']['9']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l9c1');

$T['Content']['1']['10']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t2l1c1');
$T['Content']['1']['11']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t2l2c1');
$T['Content']['1']['12']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t2l3c1');
$T['Content']['1']['13']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t2l4c1');
$T['Content']['1']['14']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t2l5c1');
$T['Content']['1']['15']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t2l6c1');


$T['Content']['1']['3']['2']['cont'] = $currentArticleObj->getArticleEntry('arti_ref');
$T['Content']['1']['4']['2']['cont'] = $currentArticleObj->getArticleEntry('arti_title');
$T['Content']['1']['5']['2']['cont'] = $currentArticleObj->getArticleEntry('arti_subtitle');

$ClassLoaderObj = ClassLoader::getInstance ();

// Deadline
$ClassLoaderObj->provisionClass ( 'DeadLine' );	// Make sure we got it loaded
$deadlineTmpObj = new DeadLine();
$deadlineTmpObj->getDataFromDB($currentArticleObj->getArticleEntry('fk_deadline_id'));
$T['Content']['1']['6']['2']['cont'] = $deadlineTmpObj->getDeadLineEntry('deadline_title');

// Page
$T['Content']['1']['7']['2']['cont'] = $currentArticleObj->getArticleEntry('arti_page');

// Layout
$T['Content']['1']['8']['2']['cont'] = $tabLayout[$currentArticleObj->getArticleEntry('layout_generic_name')]['t'];

// Document
$ClassLoaderObj->provisionClass ( 'Document' );	// Make sure we got it loaded
$documentTmpObj = new Document();
$documentTmpObj->getDataFromDBNoOriginCheck($currentArticleObj->getArticleEntry('fk_docu_id'));
$T['Content']['1']['9']['2']['cont'] = $documentTmpObj->getDocumentEntry('docu_name');

// --------------------------------------------------------------------------------------------
$T['Content']['1']['10']['2']['cont'] = $tabUser[$currentArticleObj->getArticleEntry('arti_creator_id')]['t'];
$T['Content']['1']['11']['2']['cont'] = $bts->TimeObj->timestampToDate($currentArticleObj->getArticleEntry('arti_creation_date'));
$T['Content']['1']['12']['2']['cont'] = $tabUser[$currentArticleObj->getArticleEntry('arti_validator_id')]['t'];
$T['Content']['1']['13']['2']['cont'] = $bts->TimeObj->timestampToDate($currentArticleObj->getArticleEntry('arti_validation_date'));

$tabState = $currentArticleObj->getMenuOptionArray();
$T['Content']['1']['14']['2']['cont'] = $tabState['validation'][$currentArticleObj->getArticleEntry('arti_validation_state')]['t'];

// --------------------------------------------------------------------------------------------
//
//	Display
//
//
// --------------------------------------------------------------------------------------------
$T['ContentInfos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, 12, 1);
$T['ContentCfg']['tabs'] = array(
		1	=>	$bts->RenderTablesObj->getDefaultTableConfig(14,2,2),
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
