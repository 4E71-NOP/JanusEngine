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
				'selectionId'	=> 8878682287057195096,
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
//				'mode'			=> 'delete',
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
		
		$T['Content']['1']['2']['2']['cont'] = $currentArticleObj->getArticleEntry('arti_name');
		$Content .= "<p>".$bts->I18nTransObj->getI18nTransEntry('invite1')."</p>\r";
		$processStep = "";
		$processTarget = "edit";
		break;
	case "create":
		$commandType = "add";
		
		$d = $bts->TimeObj->getMicrotime();
		$e = $bts->TimeObj->timestampToDate($d);
// 		$d = $bts->TimeObj->timestampToDate( $bts->TimeObj->getMicrotime());
				
		$currentArticleObj->setArticle(
				array (
					"arti_ref"				=>	"New_Article_".$e,
					"deadline_id"			=>	0,
					"arti_name"				=>	"New_Article",
					"arti_desc"				=>	"Article",
					"arti_title"			=>	"Title",
					"arti_subtitle"			=>	"Sub Title",
					"arti_page"				=>	1,
					"layout_generic_name"	=>	"",
					"config_id"				=>	"",
					"arti_creator_id"		=>	$CurrentSetObj->getInstanceOfUserObj()->getUserEntry("user_id"),
					"arti_creation_date"	=>	$d,
					"arti_validator_id"		=>	$CurrentSetObj->getInstanceOfUserObj()->getUserEntry("user_id"),
					"arti_validation_date"	=>	$d,
					"arti_validation_state"	=>	0,
					"arti_release_date"		=>	$d,
					"docu_id"				=>	"",
					"ws_id"					=>	$CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_id'),
				)
		);
		$T['Content']['1']['2']['2']['cont'] = "<input type='text' name='formParams[name]' size='35' maxlength='255' value=\"NewKeyword".time()."\">\r";
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

// "<form ACTION='index.php?' method='post' name='articleForm'>\r"
// .$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_sw')
// .$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_l')
// .$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_arti_ref')
// .$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_arti_page')

// ."<input type='hidden' name='formGenericData[origin]'	value='AdminDashboard".$processStep."'>\r"
// ."<input type='hidden' name='formGenericData[section]'	value='AdminArticleManagementP02'>"
// ."<input type='hidden' name='formCommand1'				value='".$commandType."'>"
// ."<input type='hidden' name='formEntity1'				value='article'>"
// ."<input type='hidden' name='formGenericData[mode]'		value='".$processTarget."'>\r"
// ."<input type='hidden' name='formTarget1[name]'			value='".$currentArticleObj->getArticleEntry('article_name')."'>\r"
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


$T['Content']['1']['1']['2']['cont'] = $currentArticleObj->getArticleEntry('arti_id');
$T['Content']['1']['2']['2']['cont'] = $currentArticleObj->getArticleEntry('arti_name');
$T['Content']['1']['3']['2']['cont'] = $bts->RenderFormObj->renderInputText('formParams[reference]',	$currentArticleObj->getArticleEntry('arti_ref'));
$T['Content']['1']['4']['2']['cont'] = $bts->RenderFormObj->renderInputText('formParams[title]',		$currentArticleObj->getArticleEntry('arti_title'));
$T['Content']['1']['5']['2']['cont'] = $bts->RenderFormObj->renderInputText('formParams[subtitle]',	$currentArticleObj->getArticleEntry('arti_subtitle') );
// $T['Content']['1']['3']['2']['cont'] = "<input type='text' name='formParams[reference]'	size='35' maxlength='255' value=\"".$currentArticleObj->getArticleEntry('arti_ref')."\">\r";
// $T['Content']['1']['4']['2']['cont'] = "<input type='text' name='formParams[title]'		size='35' maxlength='255' value=\"".$currentArticleObj->getArticleEntry('arti_title')."\">\r";
// $T['Content']['1']['5']['2']['cont'] = "<input type='text' name='formParams[subtitle]'	size='35' maxlength='255' value=\"".$currentArticleObj->getArticleEntry('arti_subtitle')."\">\r";

$ClassLoaderObj = ClassLoader::getInstance ();

// Deadline
$ClassLoaderObj->provisionClass ( 'DeadLine' );	// Make sure we got it loaded
$deadlineTmpObj = new DeadLine();
$deadlineTmpObj->getDataFromDB($currentArticleObj->getArticleEntry('fk_deadline_id'));
$tabDeadline[$deadlineTmpObj->getDeadLineEntry('deadline_name')]['s'] = " selected ";
$T['Content']['1']['6']['2']['cont'] = "<select name='formParams[deadline]'>\r";
foreach ( $tabDeadline as $A ) { $T['Content']['1']['6']['2']['cont'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$T['Content']['1']['6']['2']['cont'] .= "</select>\r";

// Page
$T['Content']['1']['7']['2']['cont'] = "<input type='text' name='formParams[page]'	size='35' maxlength='255' value=\"".$currentArticleObj->getArticleEntry('arti_page')."\">\r";

// Layout
$tabLayout[$currentArticleObj->getArticleEntry('layout_generic_name')]['s'] = " selected ";
$T['Content']['1']['8']['2']['cont'] = "<select name='formParams[layout_generic_name]'>\r";
foreach ( $tabLayout as $A ) { $T['Content']['1']['8']['2']['cont'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$T['Content']['1']['8']['2']['cont'] .= "</select>\r";

// Document
$ClassLoaderObj->provisionClass ( 'Document' );	// Make sure we got it loaded
$documentTmpObj = new Document();
$documentTmpObj->getDataFromDB($currentArticleObj->getArticleEntry('fk_docu_id'));
$tabDocument[$documentTmpObj->getDocumentEntry('docu_name')]['s'] = " selected ";
$T['Content']['1']['9']['2']['cont'] = "<select name='formParams[document]'>\r";
foreach ( $tabDocument as $A ) { $T['Content']['1']['9']['2']['cont'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$T['Content']['1']['9']['2']['cont'] .= "</select>\r";

// --------------------------------------------------------------------------------------------
$T['Content']['2']['1']['2']['cont'] = $tabUser[$currentArticleObj->getArticleEntry('arti_creator_id')]['t'];
$T['Content']['2']['2']['2']['cont'] = $bts->TimeObj->timestampToDate($currentArticleObj->getArticleEntry('arti_creation_date'));
$T['Content']['2']['3']['2']['cont'] = $tabUser[$currentArticleObj->getArticleEntry('arti_creation_validateur')]['t'];
$T['Content']['2']['4']['2']['cont'] = $bts->TimeObj->timestampToDate($currentArticleObj->getArticleEntry('arti_validation_date'));

$tabState = array(
		0 =>	array ( "t" => $bts->I18nTransObj->getI18nTransEntry('offline'),	"db" => "OFFLINE"),
		1 =>	array ( "t" => $bts->I18nTransObj->getI18nTransEntry('online'),	"db" => "ONLINE"),
);
$tabState[$currentArticleObj->getArticleEntry('arti_validation_state')]['s'] = " selected ";
$T['Content']['2']['5']['2']['cont'] = "<select name='formParams[validation_state]'>\r";
foreach ( $tabState as $A ) { $T['Content']['2']['5']['2']['cont'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$T['Content']['2']['5']['2']['cont'] .= "</select>\r";

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
