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

$bts->RequestDataObj->setRequestData('keywordForm',
		array(
				'mode'			=> 'edit',
// 	 			'mode'			=> 'create',
				'selectionId'	=> 1,
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
//				'mode'			=> 'create',
//				'mode'			=> 'delete',
		)
);

/*Hydr-Content-Begin*/
$localisation = " / uni_keyword_management_p02";
$bts->MapperObj->AddAnotherLevel($localisation );
$bts->LMObj->logCheckpoint("uni_keyword_management_p02.php");
$bts->MapperObj->RemoveThisLevel($localisation );
$bts->MapperObj->setSqlApplicant("uni_keyword_management_p02.php");

switch ($l) {
	case "fra":
		$bts->I18nTransObj->apply(array(
		"invite1"		=> "Cette partie va vous permettre de gérer les mots clés.",
		"invite2"		=> "Cette partie va vous permettre de créer un mot clé.",
		"tabTxt1"	=> "Informations",
		"raf1"			=> "Rien a afficher",
		"kwState0"		=> "Hors ligne",
		"kwState1"		=> "En ligne",
		"kwType1"		=> "Vers une menu",
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
		
		));
		break;
		
	case "eng":
		$bts->I18nTransObj->apply(array(
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
		
		));
		break;
}

$Content .= $bts->I18nTransObj->getI18nTransEntry('invite1')."<br>\r<br>\r";


$dbquery = $bts->SDDMObj->query("
SELECT art.arti_id, art.arti_name
FROM ".$SqlTableListObj->getSQLTableName('article')." art, ".$SqlTableListObj->getSQLTableName('menu')." cat
WHERE art.ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."'
AND mnu.ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."'
AND mnu.arti_ref = art.arti_ref
AND mnu.arti_ref != '0'
AND mnu.menu_type IN ('0','1')
AND mnu.lang_id = '".$WebSiteObj->getWebSiteEntry('ws_lang')."'
;");
$tabArticle_ = array();
while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
	$tabArticle_[$dbp['arti_id']]['t']	=	$tabArticle_[$dbp['arti_id']]['db']	= $dbp['arti_name'];
}

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('AdminFormTool');
$AdminFormToolObj = AdminFormTool::getInstance();
$Content .= $AdminFormToolObj->checkAdminDashboardForm($infos);

// --------------------------------------------------------------------------------------------
$T = array();

$ClassLoaderObj->provisionClass('KeyWord');
$currentKeyWordObj = new KeyWord();
switch ($bts->RequestDataObj->getRequestDataSubEntry('keywordForm', 'mode')) {
	case "edit":
		$commandType = "update";
		$currentKeyWordObj->getDataFromDB($bts->RequestDataObj->getRequestDataSubEntry('keywordForm', 'selectionId'));

		$tabArticle_[$currentKeyWordObj->getKeyWordEntry('arti_id')]['s'] = " selected ";
		
		$T['Content']['1']['2']['2']['cont'] = $currentKeyWordObj->getKeyWordEntry('keyword_name');
		$Content .= "<p>".$bts->I18nTransObj->getI18nTransEntry('invite1')."</p>\r";
		$processStep = "";
		$processTarget = "edit";
		break;
	case "create":
		$commandType = "add";
		$currentKeyWordObj->setKeyWord(
			array (
					
					"keyword_state"		=>	1,
					"keyword_name"		=>	"NewKeyword".date(),
					"arti_id"		=>	0,
					"ws_id"		=>	$WebSiteObj->getWebSiteEntry('ws_id'),
					"keyword_string"		=>	"",
					"keyword_count"	=>	1,
					"keyword_type"		=>	3,	
					"keyword_data"		=>	"",	
			)
		);
		$T['Content']['1']['2']['2']['cont'] = "<input type='text' name='formParams[name]' size='35' maxlength='255' value=\"NewKeyword".date()."\" class='".$Block."_t3 ".$Block."_form_1'>\r";
		$Content .= "<p>".$bts->I18nTransObj->getI18nTransEntry('invite2')."</p>\r";
		$processStep = "Create";
		$processTarget = "edit";
		break;
}

// --------------------------------------------------------------------------------------------
$Content .= "
<form ACTION='index.php?' method='post' name='keyword'>\r"
.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_sw')
.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_l')
.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_arti_ref')
.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_arti_page')
."<input type='hidden' name='formGenericData[origin]'	value='AdminDashboard".$processStep."'>\r"
."<input type='hidden' name='formGenericData[section]'	value='AdminKeywordManagementP02'>"
."<input type='hidden' name='formCommand1'				value='".$commandType."'>"
."<input type='hidden' name='formEntity1'				value='keyword'>"
."<input type='hidden' name='formTarget1[name]'			value='".$currentKeyWordObj->getKeyWordEntry('keyword_name')."'>\r"
."<input type='hidden' name='formGenericData[mode]'		value='".$processTarget."'>\r"
."<input type='hidden' name='keywordForm[selectionId]'	value='".$bts->RequestDataObj->getRequestDataSubEntry('keywordForm', 'selectionId')."'>\r"
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


// $tabYN = array(
// 		0	=> array ( "t"=>$I18nObj->getI18nTransEntry('no'],		"db"=>"NO" ),
// 		1	=> array ( "t"=>$I18nObj->getI18nTransEntry('yes'],	"db"=>"YES" ),
// );
$tabLine = array(
		0	=> array ( "t"=>$bts->I18nTransObj->getI18nTransEntry('offline'),	"db"=>"OFFLINE" ),
		1	=> array ( "t"=>$bts->I18nTransObj->getI18nTransEntry('online'),		"db"=>"ONLINE" ),
		2	=> array ( "t"=>$bts->I18nTransObj->getI18nTransEntry('deleted'),	"db"=>"DELETED" ),
);
// $tabStatus = array(
// 		0	=> array ( "t"=>$I18nObj->getI18nTransEntry('disabled'],	"db"=>"DISABLED" ),
// 		1	=> array ( "t"=>$I18nObj->getI18nTransEntry('enabled'],	"db"=>"ENABLED" ),
// );
$tabState = array(
		0 =>	array ( "t" => $bts->I18nTransObj->getI18nTransEntry('kwState0'),	"db" => "OFFLINE"),
		1 =>	array ( "t" => $bts->I18nTransObj->getI18nTransEntry('kwState1'),	"db" => "ONLINE"),
);


$T['Content']['1']['1']['2']['cont'] = $currentKeyWordObj->getKeyWordEntry('keyword_id');

$tabState[$currentKeyWordObj->getKeyWordEntry('keyword_state')]['s'] = " selected ";
$T['Content']['1']['3']['2']['cont'] = "<select name='formParams[state]' class='".$Block."_t3 ".$Block."_form_1'>\r";
foreach ( $tabState as $A ) { $T['Content']['1']['3']['2']['cont'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$T['Content']['1']['3']['2']['cont'] .= "</select>\r";


$tabArticle_[$currentKeyWordObj->getKeyWordEntry('arti_id')]['s'] = " selected ";
$T['Content']['1']['4']['2']['cont'] = "<select name='formParams[article]' class='".$Block."_t3 ".$Block."_form_1'>\r";
foreach ( $tabArticle_ as $A ) { $T['Content']['1']['4']['2']['cont'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$T['Content']['1']['4']['2']['cont'] .= "</select>\r";


$T['Content']['1']['5']['2']['cont'] = "<input type='text' name='formParams[string]' size='35' maxlength='255' value=\"".$currentKeyWordObj->getKeyWordEntry('keyword_string')."\" class='".$Block."_t3 ".$Block."_form_1'>\r";
$T['Content']['1']['6']['2']['cont'] = "<input type='text' name='formParams[count]' size='35' maxlength='255' value=\"".$currentKeyWordObj->getKeyWordEntry('keyword_count')."\" class='".$Block."_t3 ".$Block."_form_1'>\r";

$tabType = array(
		1 =>	array ( "t" => $bts->I18nTransObj->getI18nTransEntry('kwType1'),	"db" => "TO_MENU"),
		2 =>	array ( "t" => $bts->I18nTransObj->getI18nTransEntry('kwType2'),	"db" => "TO_URL"),
		3 =>	array ( "t" => $bts->I18nTransObj->getI18nTransEntry('kwType3'),	"db" => "TOOLTIP"),
);
$tabType[$currentKeyWordObj->getKeyWordEntry('keyword_type')]['s'] = " selected ";
$T['Content']['1']['7']['2']['cont'] = "<select name='formParams[type]' class='".$Block."_t3 ".$Block."_form_1'>\r";
foreach ( $tabType as $A ) { $T['Content']['1']['7']['2']['cont'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$T['Content']['1']['7']['2']['cont'] .= "</select>\r";

$T['Content']['1']['8']['2']['cont'] .= "<input type='text' name='formParams[data]' size='35' maxlength='255' value=\"".$currentKeyWordObj->getKeyWordEntry('keyword_data')."\" class='".$Block."_t3 ".$Block."_form_1'>\r";

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

// $LMObj->setInternalLogTarget($LOG_TARGET);

?>
