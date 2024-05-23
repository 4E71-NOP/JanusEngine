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

$bts->RequestDataObj->setRequestData('menuForm',
		array(
				'selectionId'	=> 2098047359813338403,
				'selectionId'	=> 2962598504421245606,
		)
);
$bts->RequestDataObj->setRequestData('formGenericData',
		array(
				'origin'		=> 'AdminDashboard',
				'section'		=> 'AdminmenuManagementP02',
				'creation'		=> 'on',
				'modification'	=> 'on',
				'deletion'		=> 'on',
				'mode'			=> 'edit',
				// 'mode'			=> 'create',
				// 'mode'			=> 'delete',
		)
);

/*Hydr-Content-Begin*/
$bts->mapSegmentLocation(__METHOD__, "uni_menu_management_p02");

$bts->I18nTransObj->apply(
	array(
		"type" => "array",
		"fra" => array(
			"invite1"		=> "Cette partie va vous permettre de gérer les menus.",
			"invite2"		=> "Cette partie va vous permettre de créer un menu.",
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
			),
		"eng" => array(
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
		),
	)
);

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('MenuSelectTable');
$MenuSelectTableObj = MenuSelectTable::getInstance();

$tabDeadline	= $MenuSelectTableObj->getDeadlineList();
$tabArtiRef		= $MenuSelectTableObj->getArtiRefList();
$tabMenu		= $MenuSelectTableObj->getMenuList();
$tabDecoNbr		= $MenuSelectTableObj->getDecorationList();
// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('AdminFormTool');
$AdminFormToolObj = AdminFormTool::getInstance();
$Content .= $AdminFormToolObj->checkAdminDashboardForm($infos);
// --------------------------------------------------------------------------------------------
$T = array();

$ClassLoaderObj->provisionClass('Menu');
$currentMenuObj = new Menu();
switch ($bts->RequestDataObj->getRequestDataSubEntry('formGenericData', 'mode')) {
	case "edit":
		$commandType = "update";
		$currentMenuObj->getDataFromDB($bts->RequestDataObj->getRequestDataSubEntry('menuForm', 'selectionId'));
		
		$T['Content']['1']['2']['2']['cont'] = $currentMenuObj->getMenuEntry('menu_name');
		$Content .= "<p>".$bts->I18nTransObj->getI18nTransEntry('invite1')."</p>\r";
		$processStep = "";
		$processTarget = "edit";
		break;
	case "create":
		$commandType = "add";
		$T['Content']['1']['2']['2']['cont'] = $bts->RenderFormObj->renderInputText('menuForm[name]',	$currentMenuObj->getMenuEntry('menu_name'));
		$Content .= "<p>".$bts->I18nTransObj->getI18nTransEntry('invite2')."</p>\r";
		$processStep = "Create";
		$processTarget = "edit";
		break;
}

// --------------------------------------------------------------------------------------------
$Content .= 
$bts->RenderFormObj->renderformHeader('menuForm')
.$bts->RenderFormObj->renderHiddenInput(	"formGenericData[origin]"	,	"AdminDashboard")
.$bts->RenderFormObj->renderHiddenInput(	"formGenericData[section]"	,	"AdminMenuManagementP02" )
.$bts->RenderFormObj->renderHiddenInput(	"formCommand1"				,	$commandType )
.$bts->RenderFormObj->renderHiddenInput(	"formEntity1"				,	"menu" )
.$bts->RenderFormObj->renderHiddenInput(	"formGenericData[mode]"		,	$processTarget )
.$bts->RenderFormObj->renderHiddenInput(	"formTarget1[name]"			, 	$currentMenuObj->getMenuEntry('menu_name') )
.$bts->RenderFormObj->renderHiddenInput(	"menuForm[selectionId]"		,	$currentMenuObj->getMenuEntry('menu_id') )
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
// $T['Content']['2']['2']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t2l2c1');
$T['Content']['2']['2']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t2l3c1');
$T['Content']['2']['3']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t2l4c1');
$T['Content']['2']['4']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t2l5c1');
$T['Content']['2']['5']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t2l6c1');

$T['Content']['1']['1']['2']['cont'] = $currentMenuObj->getMenuEntry('menu_id');
$T['Content']['1']['2']['2']['cont'] = $currentMenuObj->getMenuEntry('menu_name');
$T['Content']['1']['3']['2']['cont'] = $bts->RenderFormObj->renderInputText('formParams1[title]',	$currentMenuObj->getMenuEntry('menu_title'));
$T['Content']['1']['4']['2']['cont'] = $bts->RenderFormObj->renderInputText('formParams1[desc]',	$currentMenuObj->getMenuEntry('menu_desc'));


$tab = $currentMenuObj->getMenuOptionArray();

$T['Content']['1']['5']['2']['cont'] = $bts->RenderFormObj->renderMenuSelect(array(
	'name' => 'formParams1[type]',
	'defaultSelected' => $currentMenuObj->getMenuEntry('menu_type'),
	'options' => $tab['type'],
));

$T['Content']['1']['7']['2']['cont'] = $bts->RenderFormObj->renderMenuSelect(array(
	'name' => 'formParams1[state]',
	'defaultSelected' => $currentMenuObj->getMenuEntry('menu_state'),
	'options' => $tab['state'],
));


$T['Content']['1']['8']['2']['cont'] = $bts->RenderFormObj->renderMenuSelect(array(
	'name' => 'formParams1[parent]',
	'defaultSelected' => $currentMenuObj->getMenuEntry('menu_parent'),
	'options' => $tabMenu,
));

$T['Content']['1']['9']['2']['cont'] = $currentMenuObj->getMenuEntry('menu_position');
// --------------------------------------------------------------------------------------------

$T['Content']['2']['1']['2']['cont'] = $bts->RenderFormObj->renderMenuSelect(array(
	'name' => 'formParams1[deadline]',
	'defaultSelected' => $currentMenuObj->getMenuEntry('fk_deadline_id'),
	'options' => $tabDeadline,
));

$T['Content']['2']['2']['2']['cont'] = $bts->TimeObj->timestampToDate($currentMenuObj->getMenuEntry('menu_last_update'));

$T['Content']['2']['3']['2']['cont'] = $bts->RenderFormObj->renderMenuSelect(array(
	'name' => 'formParams1[role]',
	'defaultSelected' => $currentMenuObj->getMenuEntry('menu_role'),
	'options' => $tab['role'],
));

$T['Content']['2']['4']['2']['cont'] = $bts->RenderFormObj->renderMenuSelect(array(
	'name' => 'formParams1[initial_document]',
	'defaultSelected' => $currentMenuObj->getMenuEntry('menu_initial_document'),
	'options' => $tab['yesno'],
));

$T['Content']['2']['5']['2']['cont'] = $bts->RenderFormObj->renderMenuSelect(array(
	'name' => 'formParams1[arti_ref]',
	'defaultSelected' => $currentMenuObj->getMenuEntry('fk_arti_ref'),
	'options' => $tabArtiRef,
));

// --------------------------------------------------------------------------------------------
//
//	Display
//
//
// --------------------------------------------------------------------------------------------
$T['ContentInfos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, 10, 2);
$T['ContentCfg']['tabs'] = array(
		1	=>	$bts->RenderTablesObj->getDefaultTableConfig(9,2,2),
		2	=>	$bts->RenderTablesObj->getDefaultTableConfig(5,2,2),
);
$Content .= $bts->RenderTablesObj->render($infos, $T);

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('Template');
$TemplateObj = Template::getInstance();
$infos['formName'] = "menuForm";
$Content .= $TemplateObj->renderAdminFormButtons($infos, $bts->i18nDoc);


$bts->segmentEnding(__METHOD__);
/*Hydr-Content-End*/
?>
