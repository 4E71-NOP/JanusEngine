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

$bts->RequestDataObj->setRequestData('menuForm',
		array(
				'selectionId'	=> 150,
				'selectionLang'	=> 2,
		)
);
$bts->RequestDataObj->setRequestData('formGenericData',
		array(
				'origin'				=> 'AdminDashboard',
				'section'				=> 'AdminmenuManagementP02',
				'creation'		=> 'on',
				'modification'	=> 'on',
				'deletion'		=> 'on',
				'mode'			=> 'edit',
//				'mode'			=> 'create',
//				'mode'			=> 'delete',
		)
);


/*Hydr-Content-Begin*/
$localisation = " / uni_menu_management_p02";
$bts->MapperObj->AddAnotherLevel($localisation );
$bts->LMObj->logCheckpoint("uni_menu_management_p02.php");
$bts->MapperObj->RemoveThisLevel($localisation );
$bts->MapperObj->setSqlApplicant("uni_menu_management_p02.php");

switch ($l) {
	case "fra":
		$bts->I18nTransObj->apply(array(
		"invite1"		=> "Cette partie va vous permettre de gérer les catégories.",
		"invite2"		=> "Cette partie va vous permettre de créer une catégorie.",
		"tabTxt1"		=> "Général",
		"tabTxt2"		=> "Détail",
		
		"t1l1c1"		=>	"ID",
		"t1l2c1"		=>	"Nom",
		"t1l3c1"		=>	"Titre",
		"t1l4c1"		=>	"Description",
		"t1l5c1"		=>	"Type",
		"t1l6c1"		=>	"Langue",
		"t1l7c1"		=>	"Etat",
		"t1l8c1"		=>	"Parent",
		"t1l9c1"		=>	"Position",

		"t2l1c1"		=>	"Bouclage",
		"t2l2c1"		=>	"Groupe",
		"t2l3c1"		=>	"Dernière modification",
		"t2l4c1"		=>	"Rôle",
		"t2l5c1"		=>	"Document premier",
		"t2l6c1"		=>	"Référence article",
		
		"article_racine"		=> "Article racine",
		"article"				=> "Article",
		"menu_admin_racine"		=> "Menu admin racine",
		"menu_admin"			=> "Menu admin",
		
		"noRole"				=> "Aucun",
		"correction_article"	=> "Correction article",
		"admin_conf_extension"	=> "Configuration extension",
		
		));
		break;
		
	case "eng":
		$bts->I18nTransObj->apply(array(
		"invite1"		=> "This part will allow you to manage menus.",
		"invite2"		=> "This part will allow you to create a menu.",
		"tabTxt1"		=> "General",
		"tabTxt2"		=> "Details",

		"t1l1c1"		=>	"ID",
		"t1l2c1"		=>	"Name",
		"t1l3c1"		=>	"Title",
		"t1l4c1"		=>	"Description",
		"t1l5c1"		=>	"Type",
		"t1l6c1"		=>	"Language",
		"t1l7c1"		=>	"State",
		"t1l8c1"		=>	"Parent",
		"t1l9c1"		=>	"Position",
		
		"t2l1c1"		=>	"Deadline",
		"t2l2c1"		=>	"Group",
		"t2l3c1"		=>	"Last modification",
		"t2l4c1"		=>	"Role",
		"t2l5c1"		=>	"Document premier",
		"t2l6c1"		=>	"Article reference",
		
		"article_racine"		=> "Root article",
		"article"				=> "Article",
		"menu_admin_racine"		=> "Root admin menu ",
		"menu_admin"			=> "Admin menu",
		
		"noRole"				=> "None",
		"correction_article"	=> "Article examination",
		"admin_conf_extension"	=> "Configuration of extension",
		
		));
		break;
}

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('MenuSelectTable');
$MenuSelectTableObj = MenuSelectTable::getInstance();

$tabDeadline	= $MenuSelectTableObj->getDeadlineList();
// $tabDocument	= $MenuSelectTableObj->getDocumentList();
$tabArtiRef		= $MenuSelectTableObj->getArtiRefList();
$tabmenu	= $MenuSelectTableObj->getMenuList();
$tabGroup		= $MenuSelectTableObj->getGroupList();

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('AdminFormTool');
$AdminFormToolObj = AdminFormTool::getInstance();
$Content .= $AdminFormToolObj->checkAdminDashboardForm($infos);
// --------------------------------------------------------------------------------------------
$T = array();

$ClassLoaderObj->provisionClass('menu');
$currentMenuObj = new Menu();
switch ($bts->RequestDataObj->getRequestDataSubEntry('formGenericData', 'mode')) {
	case "edit":
		$commandType = "update";
		$currentmenuObj->getDataFromDB($bts->RequestDataObj->getRequestDataSubEntry('menuForm', 'selectionId'));
		
		$T['Content']['1']['2']['2']['cont'] = $currentMenuObj->getMenuEntry('menu_name');
		$Content .= "<p>".$bts->I18nTransObj->getI18nTransEntry('invite1')."</p>\r";
		$processStep = "";
		$processTarget = "edit";
		break;
	case "create":
		$commandType = "add";
		$currentMenuObj->setMenu(
			array (
				"menu_id"			=>	"",
				"menu_name"			=>	"New_Menu",
				"menu_title"		=>	"Menu title",
				"menu_desc"			=>	"Menu",
				"menu_type"			=>	1,
				"ws_id"				=>	$WebSiteObj->getWebSiteEntry('ws_id'),
				"lang_id"			=>	"",
				"deadline_id"		=>	1,
				"menu_state"		=>	1,
				"menu_parent"		=>	1,
				"menu_position"		=>	1,
				"group_id"			=>	1,
				"menu_last_update"	=>	"",
				"menu_role"			=>	"",
				"menu_initial_document"	=>	"",
				"arti_ref"			=>	"",
			)
		);
		$T['Content']['1']['2']['2']['cont'] = "<input type='text' name='formParams[name]' size='35' maxlength='255' value=\"Newmenu".date()."\" class='".$Block."_t3 ".$Block."_form_1'>\r";
		$Content .= "<p>".$bts->I18nTransObj->getI18nTransEntry('invite2')."</p>\r";
		$processStep = "Create";
		$processTarget = "edit";
		break;
}


// --------------------------------------------------------------------------------------------

$Content .= "
<form ACTION='index.php?' method='post' name='menuForm'>\r"
.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_sw')
.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_l')
.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_arti_ref')
.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_arti_page')
."<input type='hidden' name='formGenericData[origin]'	value='AdminDashboard".$processStep."'>\r"
."<input type='hidden' name='formGenericData[section]'	value='AdminmenuManagementP02'>"
."<input type='hidden' name='formCommand1'				value='".$commandType."'>"
."<input type='hidden' name='formEntity1'				value='menu'>"
."<input type='hidden' name='formTarget1[name]'			value='".$currentMenuObj->getMenuEntry('menu_name')."'>\r"
."<input type='hidden' name='formGenericData[mode]'		value='".$processTarget."'>\r"
."<input type='hidden' name='menuForm[selectionId]'	value='".$bts->RequestDataObj->getRequestDataSubEntry('menuForm', 'selectionId')."'>\r"
."<p>\r"
;

// --------------------------------------------------------------------------------------------


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

$T['Content']['1']['1']['2']['cont'] = $currentMenuObj->getMenuEntry('menu_id');
$T['Content']['1']['2']['2']['cont'] = $currentMenuObj->getMenuEntry('menu_name');
$T['Content']['1']['3']['2']['cont'] = "<input type='text' name='formParams[title]'	size='35' maxlength='255' value=\"".$currentMenuObj->getMenuEntry('menu_title')."\" class='".$Block."_t3 ".$Block."_form_1'>\r";
$T['Content']['1']['4']['2']['cont'] = "<input type='text' name='formParams[desc]'	size='35' maxlength='255' value=\"".$currentMenuObj->getMenuEntry('menu_desc')."\" class='".$Block."_t3 ".$Block."_form_1'>\r";


$tabType = array(
		0 =>	array ( "t" => $bts->I18nTransObj->getI18nTransEntry('article_racine'),		"db" => "article_racine"),
		1 =>	array ( "t" => $bts->I18nTransObj->getI18nTransEntry('article'),				"db" => "article"),
		2 =>	array ( "t" => $bts->I18nTransObj->getI18nTransEntry('menu_admin_racine'),	"db" => "menu_admin_racine"),
		3 =>	array ( "t" => $bts->I18nTransObj->getI18nTransEntry('menu_admin'),			"db" => "menu_admin"),
);
$tabType[$currentMenuObj->getMenuEntry('menu_type')]['s'] = " selected ";
$T['Content']['1']['5']['2']['cont'] = "<select name='formParams[type]' class='".$Block."_t3 ".$Block."_form_1'>\r";
foreach ( $tabType as $A ) { $T['Content']['1']['5']['2']['cont'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$T['Content']['1']['5']['2']['cont'] .= "</select>\r";



$tabState = array(
		0 =>	array ( "t" => $bts->I18nTransObj->getI18nTransEntry('offline'),	"db" => "OFFLINE"),
		1 =>	array ( "t" => $bts->I18nTransObj->getI18nTransEntry('online'),	"db" => "ONLINE"),
);
$tabState[$currentMenuObj->getMenuEntry('menu_state')]['s'] = " selected ";
$T['Content']['1']['7']['2']['cont'] = "<select name='formParams[state]' class='".$Block."_t3 ".$Block."_form_1'>\r";
foreach ( $tabState as $A ) { $T['Content']['1']['7']['2']['cont'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$T['Content']['1']['7']['2']['cont'] .= "</select>\r";

$tabMenu[$currentMenuObj->getMenuEntry('menu_parent')]['s'] = " selected ";
$T['Content']['1']['8']['2']['cont'] = "<select name='formParams[parent]' class='".$Block."_t3 ".$Block."_form_1'>\r";
foreach ( $tabMenu as $A ) { $T['Content']['1']['8']['2']['cont'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$T['Content']['1']['8']['2']['cont'] .= "</select>\r";

$T['Content']['1']['9']['2']['cont'] = $currentMenuObj->getMenuEntry('menu_position');
// --------------------------------------------------------------------------------------------


$tabDeadline[$currentMenuObj->getMenuEntry('deadline_id')]['s'] = " selected ";
$T['Content']['2']['1']['2']['cont'] = "<select name='formParams[deadline]' class='".$Block."_t3 ".$Block."_form_1'>\r";
foreach ( $tabDeadline as $A ) { $T['Content']['2']['1']['2']['cont'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$T['Content']['2']['1']['2']['cont'] .= "</select>\r";

$tabGroup[$currentMenuObj->getMenuEntry('group_id')]['s'] = " selected ";
$T['Content']['2']['2']['2']['cont'] = "<select name='formParams[group]' class='".$Block."_t3 ".$Block."_form_1'>\r";
foreach ( $tabGroup as $A ) { $T['Content']['2']['2']['2']['cont'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$T['Content']['2']['2']['2']['cont'] .= "</select>\r";

$T['Content']['2']['3']['2']['cont'] = $bts->TimeObj->timestampToDate($currentMenuObj->getMenuEntry('menu_last_update'));


$tabRole = array(
		0	=> array ( "t"=>$bts->I18nTransObj->getI18nTransEntry('noRole'),					"db"=>0 ),
		1	=> array ( "t"=>$bts->I18nTransObj->getI18nTransEntry('correction_article'),		"db"=>"correction_article" ),
		2	=> array ( "t"=>$bts->I18nTransObj->getI18nTransEntry('admin_conf_extension'),	"db"=>"admin_conf_extension" ),
);
$tabRole[$currentMenuObj->getMenuEntry('menu_role')]['s'] = " selected ";
$T['Content']['2']['4']['2']['cont'] = "<select name='formParams[first_doc]' class='".$Block."_t3 ".$Block."_form_1'>\r";
foreach ( $tabRole as $A ) { $T['Content']['2']['4']['2']['cont'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$T['Content']['2']['4']['2']['cont'] .= "</select>\r";


$tabYN = array(
		0	=> array ( "t"=>$bts->I18nTransObj->getI18nTransEntry('no'),		"db"=>"NO" ),
		1	=> array ( "t"=>$bts->I18nTransObj->getI18nTransEntry('yes'),	"db"=>"YES" ),
);
$tabYN[$currentMenuObj->getMenuEntry('menu_initial_document')]['s'] = " selected ";
$T['Content']['2']['5']['2']['cont'] = "<select name='formParams[first_doc]' class='".$Block."_t3 ".$Block."_form_1'>\r";
foreach ( $tabYN as $A ) { $T['Content']['2']['5']['2']['cont'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$T['Content']['2']['5']['2']['cont'] .= "</select>\r";



$tabArtiRef[$currentMenuObj->getMenuEntry('arti_ref')]['s'] = " selected ";
$T['Content']['2']['6']['2']['cont'] = "<select name='formParams[arti_ref]' class='".$Block."_t3 ".$Block."_form_1'>\r";
foreach ( $tabArtiRef as $A ) { $T['Content']['2']['6']['2']['cont'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$T['Content']['2']['6']['2']['cont'] .= "</select>\r";


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
$infos['formName'] = "menuForm";
$Content .= $TemplateObj->renderAdminFormButtons($infos, $bts->i18nDoc);


/*Hydr-Content-End*/

// $LMObj->setInternalLogTarget($LOG_TARGET);

?>
