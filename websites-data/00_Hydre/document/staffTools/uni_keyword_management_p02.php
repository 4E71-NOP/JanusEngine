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

$bts->RequestDataObj->setRequestData('keywordForm',
		array(
				'selectionId'	=> 5309202433557915355,
		)
);
$bts->RequestDataObj->setRequestData('formGenericData',
		array(
				'origin'		=> 'AdminDashboard',
				'section'		=> 'AdminKeywordManagementP02',
				'creation'		=> 'on',
				'modification'	=> 'on',
				'deletion'		=> 'on',
				'mode'			=> 'edit',
				'mode'			=> 'create',
//				'mode'			=> 'delete',
		)
);

$bts->LMObj->setVectorInternalLevel(LOGLEVEL_STATEMENT);

/*Hydr-Content-Begin*/
$localisation = " / uni_keyword_management_p02";
$bts->MapperObj->AddAnotherLevel($localisation );
$bts->LMObj->logCheckpoint("uni_keyword_management_p02.php");
$bts->MapperObj->RemoveThisLevel($localisation );
$bts->MapperObj->setSqlApplicant("uni_keyword_management_p02.php");


$bts->I18nTransObj->apply(
	array(
		"type" => "array",
		"fra" => array(
			"invite1"		=> "Cette partie va vous permettre de gérer les mots clés.",
			"invite2"		=> "Cette partie va vous permettre de créer un mot clé.",
			"tabTxt1"	=> "Informations",
			"raf1"			=> "Rien a afficher",
			"kwState0"		=> "Hors ligne",
			"kwState1"		=> "En ligne",
			"kwType1"		=> "Vers un menu",
			"kwType2"		=> "Vers une URL",
			"kwType3"		=> "Tooltip",
			
			"t1l1c1"		=>	"ID",
			"t1l2c1"		=>	"Nom",
			"t1l3c1"		=>	"Etat",
			"t1l4c1"		=>	"Article",
			"t1l5c1"		=>	"Chaine",
			"t1l6c1"		=>	"Compteur",
			"t1l7c1"		=>	"Type",
			"t1l8c1"		=>	"Donnée",

		),
		"eng" => array(
			"invite1"		=> "This part will allow you to manage keywords.",
			"invite2"		=> "This part will allow you to create a keyword.",
			"tabTxt1"	=> "Informations",
			"raf1"			=> "Nothing to display",
			"kwState0"		=> "Offline",
			"kwState0"		=> "Online",
			"kwType1"		=> "Link to a menu",
			"kwType2"		=> "Link to an URL",
			"kwType3"		=> "Tooltip",
			
			"t1l1c1"		=>	"ID",
			"t1l2c1"		=>	"Name",
			"t1l3c1"		=>	"State",
			"t1l4c1"		=>	"Article",
			"t1l5c1"		=>	"String",
			"t1l6c1"		=>	"Count",
			"t1l7c1"		=>	"Type",
			"t1l8c1"		=>	"Data",
		)
	)
);

$Content .= $bts->I18nTransObj->getI18nTransEntry('invite1')."<br>\r<br>\r";

$dbquery = $bts->SDDMObj->query("
SELECT art.arti_id, art.arti_name, art.arti_title 
FROM ".$SqlTableListObj->getSQLTableName('article')." art, "
.$SqlTableListObj->getSQLTableName('menu')." mnu
WHERE art.fk_ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."'
AND mnu.fk_ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."'
AND mnu.fk_arti_ref = art.arti_ref
AND mnu.fk_arti_ref != '0'
AND mnu.menu_type IN ('0','1')
AND mnu.fk_lang_id = '".$CurrentSetObj->getDataEntry ( 'language_id')."'
;");
$tabArticle = array();
while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
	$tabArticle[$dbp['arti_name']]['db']	= $dbp['arti_name'];
	$tabArticle[$dbp['arti_name']]['t']		= $dbp['arti_title'];	
}

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('AdminFormTool');
$AdminFormToolObj = AdminFormTool::getInstance();
$Content .= $AdminFormToolObj->checkAdminDashboardForm($infos);

// --------------------------------------------------------------------------------------------
$T = array();

$ClassLoaderObj->provisionClass('KeyWord');
$currentKeyWordObj = new KeyWord();

switch ($bts->RequestDataObj->getRequestDataSubEntry('formGenericData', 'mode')) {
	case "edit":
		$commandType = "update";
		$currentKeyWordObj->getDataFromDB($bts->RequestDataObj->getRequestDataSubEntry('keywordForm', 'selectionId'));
		$T['Content']['1']['2']['2']['cont'] = $currentKeyWordObj->getKeyWordEntry('keyword_name');
		$Content .= "<p>".$bts->I18nTransObj->getI18nTransEntry('invite1')."</p>\r";
		$processStep = "";
		$processTarget = "edit";
		break;
	case "create":
		$commandType = "add";
		$T['Content']['1']['2']['2']['cont'] = $bts->RenderFormObj->renderInputText('keywordForm[name]',	$currentKeyWordObj->getKeyWordEntry('keyword_name'));
		$Content .= "<p>".$bts->I18nTransObj->getI18nTransEntry('invite2')."</p>\r";
		$processStep = "Create";
		$processTarget = "edit";
		break;
}

// --------------------------------------------------------------------------------------------
$Content .= 
$bts->RenderFormObj->renderformHeader('keywordForm')
.$bts->RenderFormObj->renderHiddenInput(	"formSubmitted"	,				"1")
.$bts->RenderFormObj->renderHiddenInput(	"formGenericData[origin]"	,	"AdminDashboard")
.$bts->RenderFormObj->renderHiddenInput(	"formGenericData[section]"	,	"AdminKeywordManagementP02" )
.$bts->RenderFormObj->renderHiddenInput(	"formCommand1"				,	$commandType )
.$bts->RenderFormObj->renderHiddenInput(	"formEntity1"				,	"keyword" )
.$bts->RenderFormObj->renderHiddenInput(	"formGenericData[mode]"		,	$processTarget )
.$bts->RenderFormObj->renderHiddenInput(	"formTarget1[name]"			, 	$currentKeyWordObj->getKeywordEntry('keyword_name') )
.$bts->RenderFormObj->renderHiddenInput(	"keywordForm[selectionId]"	,	$currentKeyWordObj->getKeywordEntry('keyword_id') )
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

$T['Content']['1']['1']['2']['cont'] = $currentKeyWordObj->getKeyWordEntry('keyword_id');

$Tab = $currentKeyWordObj->getMenuOptionArray();
$T['Content']['1']['3']['2']['cont'] = $bts->RenderFormObj->renderMenuSelect(array(
	'name' => 'formParams1[state]',
	'defaultSelected' => $currentKeyWordObj->getKeyWordEntry('keyword_state'),
	'options' => $Tab['state'],
));

$articleTmpObj = new Article();
$articleTmpObj->getDataFromDB($currentKeyWordObj->getKeyWordEntry('fk_arti_id'));
$T['Content']['1']['4']['2']['cont'] = $bts->RenderFormObj->renderMenuSelect(array(
	'name' => 'formParams1[article]',
	'defaultSelected' => $articleTmpObj->getArticleEntry('arti_name'),
	'options' => $tabArticle,
));

$T['Content']['1']['5']['2']['cont'] = $bts->RenderFormObj->renderInputText('formParams1[string]',	$currentKeyWordObj->getKeyWordEntry('keyword_string'));
$T['Content']['1']['6']['2']['cont'] = $bts->RenderFormObj->renderInputText('formParams1[count]',	$currentKeyWordObj->getKeyWordEntry('keyword_count'));

$T['Content']['1']['7']['2']['cont'] = $bts->RenderFormObj->renderMenuSelect(array(
	'name' => 'formParams1[type]',
	'defaultSelected' => $currentKeyWordObj->getKeyWordEntry('keyword_type'),
	'options' => $Tab['type'],
));

$T['Content']['1']['8']['2']['cont'] .= $bts->RenderFormObj->renderInputText('formParams1[data]',	$currentKeyWordObj->getKeyWordEntry('keyword_data'));

// --------------------------------------------------------------------------------------------
//
//	Display
//
//
// --------------------------------------------------------------------------------------------
$T['ContentInfos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, 9);
$T['ContentCfg']['tabs'] = array(
		1	=>	$bts->RenderTablesObj->getDefaultTableConfig(8,2,2),
);
$Content .= $bts->RenderTablesObj->render($infos, $T);

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('Template');
$TemplateObj = Template::getInstance();
$infos['formName'] = "keywordForm";
$Content .= $TemplateObj->renderAdminFormButtons($infos);


/*Hydr-Content-End*/
$bts->LMObj->setVectorInternalLevel(LOGLEVEL_WARNING);

?>
