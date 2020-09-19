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

$RequestDataObj->setRequestData('articleForm',
		array(
				'selectionRef'	=> "fra_doc_concepts",
				'selectionPage'	=> 1,
		)
);
$RequestDataObj->setRequestData('formGenericData',
		array(
				'origin'			=> 'AdminDashboard',
				'section'			=> 'AdminArticleManagementP02',
				'creation'		=> 'on',
				'modification'	=> 'on',
				'deletion'		=> 'on',
				'mode'			=> 'edit',
//				'mode'			=> 'create',
//				'mode'			=> 'delete',
		)
);


/*Hydre-contenu_debut*/
$localisation = " / fra_modification_article_p02";
$MapperObj->AddAnotherLevel($localisation );
$LMObj->logCheckpoint("fra_modification_article_p02");
$MapperObj->RemoveThisLevel($localisation );
$MapperObj->setSqlApplicant("fra_modification_article_p02");

switch ($l) {
	case "fra":
		$I18nObj->apply(array(
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
		"t1l8c1"		=>	"Nom générique de présentaion",
		"t1l9c1"		=>	"Document",

		"t2l1c1"		=>	"Créateur",
		"t2l2c1"		=>	"Date création",
		"t2l3c1"		=>	"Validateur",
		"t2l4c1"		=>	"Date validation",
		"t2l5c1"		=>	"Etat validation",
		"t2l6c1"		=>	"Date de parution",
		
		));
		break;
		
	case "eng":
		$I18nObj->apply(array(
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
		
		));
		break;
}

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('MenuSelectTable');
$MenuSelectTableObj = MenuSelectTable::getInstance();

$tabUser		= $MenuSelectTableObj->getUserList();
$tabDeadline	= $MenuSelectTableObj->getDeadlineList();
$tabLayout		= $MenuSelectTableObj->getLayoutList();
$tabDocument	= $MenuSelectTableObj->getDocumentList();

// --------------------------------------------------------------------------------------------
$Content .= $AdminFormToolObj->checkAdminDashboardForm($infos);

// --------------------------------------------------------------------------------------------
$T = array();

$ClassLoaderObj->provisionClass('Article');
$currentArticleObj = new Article();
switch ($RequestDataObj->getRequestDataSubEntry('formGenericData', 'mode')) {
	case "edit":
		$commandType = "update";
		$currentArticleObj->getArticleDataFromDB(
			$RequestDataObj->getRequestDataSubEntry('articleForm', 'selectionRef'),
			$RequestDataObj->getRequestDataSubEntry('articleForm', 'selectionPage')
		);
		
		$T['AD']['1']['2']['2']['cont'] = $currentArticleObj->getArticleEntry('arti_name');
		$Content .= "<p>".$I18nObj->getI18nEntry('invite1')."</p>\r";
		$processStep = "";
		$processTarget = "edit";
		break;
	case "create":
		$commandType = "add";
		
		$d = date($TimeObj->microtime_chrono());
		$currentArticleObj->setArticle(
				array (
					"arti_ref"						=>	"New_Article".$d,
					"deadline_id"					=>	0,
					"arti_name"						=>	"New_Article",
					"arti_desc"						=>	"Article",
					"arti_title"					=>	"Title",
					"arti_subtitle"				=>	"Sub Title",
					"arti_page"						=>	1,
					"layout_generic_name"			=>	"",
					"config_id"						=>	"",
					"arti_creator_id"		=>	$UserObj->getUserEntry("user_id"),
					"arti_creation_date"			=>	$d,
					"arti_validator_id"	=>	$UserObj->getUserEntry("user_id"),
					"arti_validation_date"			=>	$d,
					"arti_validation_state"			=>	0,
					"arti_release_date"			=>	$d,
					"docu_id"						=>	"",
					"ws_id"						=>	$WebSiteObj->getWebSiteEntry('ws_id'),
				)
		);
		$T['AD']['1']['2']['2']['cont'] = "<input type='text' name='formParams[name]' size='35' maxlength='255' value=\"NewKeyword".date()."\" class='".$Block."_t3 ".$Block."_form_1'>\r";
		$processStep = "Create";
		$processTarget = "edit";
		$Content .= "<p>".$I18nObj->getI18nEntry('invite2')."</p>\r";
		break;
}

// --------------------------------------------------------------------------------------------

$Content .= "
<form ACTION='index.php?' method='post' name='articleForm'>\r"
.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_sw')
.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_l')
.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_arti_ref')
.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_arti_page')
."<input type='hidden' name='formGenericData[origin]'	value='AdminDashboard".$processStep."'>\r"
."<input type='hidden' name='formGenericData[section]'	value='AdminArticleManagementP02'>"
."<input type='hidden' name='formCommand1'				value='".$commandType."'>"
."<input type='hidden' name='formEntity1'				value='article'>"
."<input type='hidden' name='formGenericData[mode]'		value='".$processTarget."'>\r"
."<input type='hidden' name='formTarget1[name]'			value='".$currentArticleObj->getArticleEntry('article_nom')."'>\r"
."<p>\r"
;


$T['AD']['1']['1']['1']['cont'] = $I18nObj->getI18nEntry('t1l1c1');
$T['AD']['1']['2']['1']['cont'] = $I18nObj->getI18nEntry('t1l2c1');
$T['AD']['1']['3']['1']['cont'] = $I18nObj->getI18nEntry('t1l3c1');
$T['AD']['1']['4']['1']['cont'] = $I18nObj->getI18nEntry('t1l4c1');
$T['AD']['1']['5']['1']['cont'] = $I18nObj->getI18nEntry('t1l5c1');
$T['AD']['1']['6']['1']['cont'] = $I18nObj->getI18nEntry('t1l6c1');
$T['AD']['1']['7']['1']['cont'] = $I18nObj->getI18nEntry('t1l7c1');
$T['AD']['1']['8']['1']['cont'] = $I18nObj->getI18nEntry('t1l8c1');
$T['AD']['1']['9']['1']['cont'] = $I18nObj->getI18nEntry('t1l9c1');

$T['AD']['2']['1']['1']['cont'] = $I18nObj->getI18nEntry('t2l1c1');
$T['AD']['2']['2']['1']['cont'] = $I18nObj->getI18nEntry('t2l2c1');
$T['AD']['2']['3']['1']['cont'] = $I18nObj->getI18nEntry('t2l3c1');
$T['AD']['2']['4']['1']['cont'] = $I18nObj->getI18nEntry('t2l4c1');
$T['AD']['2']['5']['1']['cont'] = $I18nObj->getI18nEntry('t2l5c1');
$T['AD']['2']['6']['1']['cont'] = $I18nObj->getI18nEntry('t2l6c1');


$T['AD']['1']['1']['2']['cont'] = $currentArticleObj->getArticleEntry('arti_id');
$T['AD']['1']['2']['2']['cont'] = $currentArticleObj->getArticleEntry('arti_name');
$T['AD']['1']['3']['2']['cont'] = "<input type='text' name='formParams[reference]'	size='35' maxlength='255' value=\"".$currentArticleObj->getArticleEntry('arti_ref')."\" class='".$Block."_t3 ".$Block."_form_1'>\r";
$T['AD']['1']['4']['2']['cont'] = "<input type='text' name='formParams[title]'		size='35' maxlength='255' value=\"".$currentArticleObj->getArticleEntry('arti_title')."\" class='".$Block."_t3 ".$Block."_form_1'>\r";
$T['AD']['1']['5']['2']['cont'] = "<input type='text' name='formParams[subtitle]'	size='35' maxlength='255' value=\"".$currentArticleObj->getArticleEntry('arti_subtitle')."\" class='".$Block."_t3 ".$Block."_form_1'>\r";

$tabDeadline[$currentArticleObj->getArticleEntry('deadline_id')]['s'] = " selected ";
$T['AD']['1']['6']['2']['cont'] = "<select name='formParams[deadline]' class='".$Block."_t3 ".$Block."_form_1'>\r";
foreach ( $tabDeadline as $A ) { $T['AD']['1']['6']['2']['cont'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$T['AD']['1']['6']['2']['cont'] .= "</select>\r";

$T['AD']['1']['7']['2']['cont'] = "<input type='text' name='formParams[page]'	size='35' maxlength='255' value=\"".$currentArticleObj->getArticleEntry('arti_page')."\" class='".$Block."_t3 ".$Block."_form_1'>\r";


$tabLayout[$currentArticleObj->getArticleEntry('layout_generic_name')]['s'] = " selected ";
$T['AD']['1']['8']['2']['cont'] = "<select name='formParams[layout_generic_name]' class='".$Block."_t3 ".$Block."_form_1'>\r";
foreach ( $tabLayout as $A ) { $T['AD']['1']['8']['2']['cont'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$T['AD']['1']['8']['2']['cont'] .= "</select>\r";



$tabDocument[$currentArticleObj->getArticleEntry('docu_id')]['s'] = " selected ";
$T['AD']['1']['9']['2']['cont'] = "<select name='formParams[document]' class='".$Block."_t3 ".$Block."_form_1'>\r";
foreach ( $tabDocument as $A ) { $T['AD']['1']['9']['2']['cont'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$T['AD']['1']['9']['2']['cont'] .= "</select>\r";

// --------------------------------------------------------------------------------------------
$T['AD']['2']['1']['2']['cont'] = $tabUser[$currentArticleObj->getArticleEntry('arti_creator_id')]['t'];
$T['AD']['2']['2']['2']['cont'] = $TimeObj->timestampToDate($currentArticleObj->getArticleEntry('arti_creation_date'));
$T['AD']['2']['3']['2']['cont'] = $tabUser[$currentArticleObj->getArticleEntry('arti_creation_validateur')]['t'];
$T['AD']['2']['4']['2']['cont'] = $TimeObj->timestampToDate($currentArticleObj->getArticleEntry('arti_validation_date'));

$tabState = array(
		0 =>	array ( "t" => $I18nObj->getI18nEntry('offline'),	"db" => "OFFLINE"),
		1 =>	array ( "t" => $I18nObj->getI18nEntry('online'),	"db" => "ONLINE"),
);
$tabState[$currentArticleObj->getArticleEntry('arti_validation_state')]['s'] = " selected ";
$T['AD']['2']['5']['2']['cont'] = "<select name='formParams[validation_state]' class='".$Block."_t3 ".$Block."_form_1'>\r";
foreach ( $tabState as $A ) { $T['AD']['2']['5']['2']['cont'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$T['AD']['2']['5']['2']['cont'] .= "</select>\r";

$T['AD']['2']['6']['2']['cont'] = $TimeObj->timestampToDate($currentArticleObj->getArticleEntry('arti_release_date'));


// --------------------------------------------------------------------------------------------
//
//	Display
//
//
// --------------------------------------------------------------------------------------------
$T['tab_infos'] = $RenderTablesObj->getDefaultDocumentConfig($infos, 10, 2);
$T['ADC']['onglet'] = array(
		1	=>	$RenderTablesObj->getDefaultTableConfig(9,2,2),
		2	=>	$RenderTablesObj->getDefaultTableConfig(6,2,2),
);
$Content .= $RenderTablesObj->render($infos, $T);

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('Template');
$TemplateObj = Template::getInstance();
$infos['formName'] = "articleForm";
$Content .= $TemplateObj->renderAdminFormButtons($infos);

/*Hydre-contenu_fin*/

$LMObj->setInternalLogTarget($logTarget);

?>
