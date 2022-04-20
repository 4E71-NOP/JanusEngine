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

/*
http://www.local-hydr.net/script-execution/1/index.php
?HydrLink=1&arti_slug=script-execution
&arti_ref=fra_script_execution
&arti_page=2
&formGenericData[mode]=edit
&formGenericData[selectionId]=738544661492181301
&formGenericData[selectionPage]=9
*/

$bts->LMObj->saveVectorSystemLogLevel();
$bts->LMObj->setVectorSystemLogLevel(LOGLEVEL_BREAKPOINT);

$bts->RequestDataObj->setRequestData('articleForm',
		array(
				'selectionId'	=> 7517174913115681722,
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


/*Hydr-Content-Begin*/
$localisation = " / uni_article_management_p02";
$bts->MapperObj->AddAnotherLevel($localisation );
$bts->LMObj->logCheckpoint("uni_article_management_p02.php");
$bts->MapperObj->RemoveThisLevel($localisation );
$bts->MapperObj->setSqlApplicant("uni_article_management_p02.php");

$bts->I18nTransObj->apply(
	array(
		"type" => "array",
		"fra" => array(
			"invite1"		=> "Cette partie va vous permettre de gérer les articles.",
			"invite2"		=> "Cette partie va vous permettre de créer un article.",
			"tabTxt1"		=> "Article",
			"tabTxt2"		=> "Utilisateurs",
			
			"t1l1c1"		=>	"ID",
			"t1l2c1"		=>	"Nom",
			"t1l3c1"		=>	"Référence",
			"t1l4c1"		=>	"Titre",
			"t1l5c1"		=>	"Sous-titre",
			"t1l6c1"		=>	"Bouclage",
			"t1l7c1"		=>	"Page",
			"t1l8c1"		=>	"Nom générique de présentation",
			"t1l9c1"		=>	"Document",

			"t2l1c1"		=>	"Créateur",
			"t2l2c1"		=>	"Date création",
			"t2l3c1"		=>	"Validateur",
			"t2l4c1"		=>	"Date validation",
			"t2l5c1"		=>	"Etat validation",
			"t2l6c1"		=>	"Date de parution",
			"valid"			=>	"Validé",
			"invalid"		=>	"non validé",

		),
		"eng" => array(
			"invite1"		=> "This part will allow you to manage articles.",
			"invite2"		=> "This part will allow you to create an article.",
			"col_1_txt"		=> "Name",
			"col_2_txt"		=> "Type",
			"col_3_txt"		=> "State",
			"tabTxt1"		=> "Article",
			"tabTxt2"		=> "Users",
			
			"t1l1c1"		=>	"ID",
			"t1l2c1"		=>	"Name",
			"t1l3c1"		=>	"Reference",
			"t1l4c1"		=>	"Title",
			"t1l5c1"		=>	"Sub-title",
			"t1l6c1"		=>	"Deadline",
			"t1l7c1"		=>	"Page",
			"t1l8c1"		=>	"Presentation generic name",
			"t1l9c1"		=>	"Document",
			
			"t2l1c1"		=>	"Creator",
			"t2l2c1"		=>	"Creation date",
			"t2l3c1"		=>	"Validator",
			"t2l4c1"		=>	"Validation date",
			"t2l5c1"		=>	"Validation state",
			"t2l6c1"		=>	"Publishing date",
			"valid"			=>	"Valid",
			"invalid"		=>	"Invalid",
		),

	)
);


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
.$bts->RenderFormObj->renderHiddenInput(	"formGenericData[origin]"	,	"AdminDashboard".$processStep )
.$bts->RenderFormObj->renderHiddenInput(	"formGenericData[section]"	,	"AdminArticleManagementP02" )
.$bts->RenderFormObj->renderHiddenInput(	"formCommand1"				,	$commandType )
.$bts->RenderFormObj->renderHiddenInput(	"formEntity1"				,	"article" )
.$bts->RenderFormObj->renderHiddenInput(	"formGenericData[mode]"		,	$processTarget )
.$bts->RenderFormObj->renderHiddenInput(	"formTarget1[name]"			, 	$currentArticleObj->getArticleEntry('arti_name') )
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

$T['Content']['2']['1']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t2l1c1');
$T['Content']['2']['2']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t2l2c1');
$T['Content']['2']['3']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t2l3c1');
$T['Content']['2']['4']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t2l4c1');
$T['Content']['2']['5']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t2l5c1');
$T['Content']['2']['6']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t2l6c1');


$T['Content']['1']['3']['2']['cont'] = $bts->RenderFormObj->renderInputText('formParams1[reference]',	$currentArticleObj->getArticleEntry('arti_ref'));
$T['Content']['1']['4']['2']['cont'] = $bts->RenderFormObj->renderInputText('formParams1[title]',		$currentArticleObj->getArticleEntry('arti_title'));
$T['Content']['1']['5']['2']['cont'] = $bts->RenderFormObj->renderInputText('formParams1[subtitle]',	$currentArticleObj->getArticleEntry('arti_subtitle') );

$ClassLoaderObj = ClassLoader::getInstance ();

// Deadline
$ClassLoaderObj->provisionClass ( 'DeadLine' );	// Make sure we got it loaded
$deadlineTmpObj = new DeadLine();
$deadlineTmpObj->getDataFromDB($currentArticleObj->getArticleEntry('fk_deadline_id'));
$T['Content']['1']['6']['2']['cont'] = $bts->RenderFormObj->renderMenuSelect(array(
	'name' => 'formParams1[deadline]',
	'defaultSelected' => $deadlineTmpObj->getDeadLineEntry('deadline_id'),
	'options' => $tabDeadline,
));

// Page
$T['Content']['1']['7']['2']['cont'] = $bts->RenderFormObj->renderInputText('formParams1[page]',	$currentArticleObj->getArticleEntry('arti_page'));

// Layout
$T['Content']['1']['8']['2']['cont'] = $currentArticleObj->getArticleEntry('layout_generic_name');


// Document
$ClassLoaderObj->provisionClass ( 'Document' );	// Make sure we got it loaded
$documentTmpObj = new Document();
$documentTmpObj->getDataFromDBNoOriginCheck($currentArticleObj->getArticleEntry('fk_docu_id'));
$T['Content']['1']['9']['2']['cont'] = $bts->RenderFormObj->renderMenuSelect(array(
	'name' => 'formParams1[document]',
	'defaultSelected' => $documentTmpObj->getDocumentEntry('docu_name'),
	'options' => $tabDocument,
));

// --------------------------------------------------------------------------------------------
$T['Content']['2']['1']['2']['cont'] = $tabUser[$currentArticleObj->getArticleEntry('arti_creator_id')]['t'];
$T['Content']['2']['2']['2']['cont'] = $bts->TimeObj->timestampToDate($currentArticleObj->getArticleEntry('arti_creation_date'));
$T['Content']['2']['3']['2']['cont'] = $tabUser[$currentArticleObj->getArticleEntry('arti_creation_validateur')]['t'];
$T['Content']['2']['4']['2']['cont'] = $bts->TimeObj->timestampToDate($currentArticleObj->getArticleEntry('arti_validation_date'));

$tabState = array(
		0 =>	array ( "t" => $bts->I18nTransObj->getI18nTransEntry('invalid'),	"db" => "OFFLINE"),
		1 =>	array ( "t" => $bts->I18nTransObj->getI18nTransEntry('valid'),		"db" => "ONLINE"),
);

$T['Content']['2']['5']['2']['cont'] = $bts->RenderFormObj->renderMenuSelect(array(
	'name' => 'formParams1[validation_state]',
	'defaultSelected' => $currentArticleObj->getArticleEntry('arti_validation_state'),
	'options' => $tabState,
));




$T['Content']['2']['6']['2']['cont'] = $bts->TimeObj->timestampToDate($currentArticleObj->getArticleEntry('arti_release_date'));


// --------------------------------------------------------------------------------------------
//
//	Display
//
//
// --------------------------------------------------------------------------------------------
$T['ContentInfos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, 10, 2);
$T['ContentCfg']['tabs'] = array(
		1	=>	$bts->RenderTablesObj->getDefaultTableConfig(9,2,2),
		2	=>	$bts->RenderTablesObj->getDefaultTableConfig(6,2,2),
);
$Content .= $bts->RenderTablesObj->render($infos, $T);

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('Template');
$TemplateObj = Template::getInstance();
$infos['formName'] = "articleForm";
$Content .= $TemplateObj->renderAdminFormButtons($infos);

/*Hydr-Content-End*/
$bts->LMObj->restoreVectorSystemLogLevel();

?>
