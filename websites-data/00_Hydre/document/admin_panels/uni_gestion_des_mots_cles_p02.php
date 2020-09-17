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

$RequestDataObj->setRequestData('keywordForm',
		array(
				'mode'			=> 'edit',
// 	 			'mode'			=> 'create',
				'selectionId'	=> 1,
		)
);
$RequestDataObj->setRequestData('formGenericData',
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

/*Hydre-contenu_debut*/
$localisation = " / uni_gestion_des_mot_cle_p02";
$MapperObj->AddAnotherLevel($localisation );
$LMObj->logCheckpoint("uni_gestion_des_mot_cle_p02");
$MapperObj->RemoveThisLevel($localisation );
$MapperObj->setSqlApplicant("uni_gestion_des_mot_cle_p02");

switch ($l) {
	case "fra":
		$I18nObj->apply(array(
		"invite1"		=> "Cette partie va vous permettre de gérer les mots clés.",
		"invite2"		=> "Cette partie va vous permettre de créer un mot clé.",
		"tabTxt1"	=> "Informations",
		"raf1"			=> "Rien a afficher",
		"kwState0"		=> "Hors ligne",
		"kwState1"		=> "En ligne",
		"kwType1"		=> "Vers une category",
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
		$I18nObj->apply(array(
		"invite1"		=> "This part will allow you to manage keywords.",
		"invite2"		=> "This part will allow you to create a keyword.",
		"tabTxt1"	=> "Informations",
		"raf1"			=> "Nothing to display",
		"kwState0"		=> "Offline",
		"kwState0"		=> "Online",
		"kwType1"		=> "Link to a category",
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

$Content .= $I18nObj->getI18nEntry('invite1')."<br>\r<br>\r";


$dbquery = $SDDMObj->query("
SELECT art.arti_id, art.arti_nom
FROM ".$SqlTableListObj->getSQLTableName('article')." art, ".$SqlTableListObj->getSQLTableName('categorie')." cat
WHERE art.site_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."'
AND cat.site_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."'
AND cat.arti_ref = art.arti_ref
AND cat.arti_ref != '0'
AND cat.cate_type IN ('0','1')
AND cat.cate_lang = '".$WebSiteObj->getWebSiteEntry('ws_lang')."'
;");
$tabArticle_ = array();
while ($dbp = $SDDMObj->fetch_array_sql($dbquery)) {
	$tabArticle_[$dbp['arti_id']]['t']	=	$tabArticle_[$dbp['arti_id']]['db']	= $dbp['arti_nom'];
}

// --------------------------------------------------------------------------------------------
$Content .= $AdminFormToolObj->checkAdminDashboardForm($infos);

// --------------------------------------------------------------------------------------------
$T = array();

$ClassLoaderObj->provisionClass('KeyWord');
$currentKeyWordObj = new KeyWord();
switch ($RequestDataObj->getRequestDataSubEntry('keywordForm', 'mode')) {
	case "edit":
		$commandType = "update";
		$currentKeyWordObj->getKeyWordDataFromDB($RequestDataObj->getRequestDataSubEntry('keywordForm', 'selectionId'));

		$tabArticle_[$currentKeyWordObj->getKeyWordEntry('arti_id')]['s'] = " selected ";
		
		$T['AD']['1']['2']['2']['cont'] = $currentKeyWordObj->getKeyWordEntry('mc_nom');
		$Content .= "<p>".$I18nObj->getI18nEntry('invite1')."</p>\r";
		$processStep = "";
		$processTarget = "edit";
		break;
	case "create":
		$commandType = "add";
		$currentKeyWordObj->setKeyWord(
			array (
					
					"mc_etat"		=>	1,
					"mc_nom"		=>	"NewKeyword".date(),
					"arti_id"		=>	0,
					"site_id"		=>	$WebSiteObj->getWebSiteEntry('ws_id'),
					"mc_chaine"		=>	"",
					"mc_compteur"	=>	1,
					"mc_type"		=>	3,	
					"mc_donnee"		=>	"",	
			)
		);
		$T['AD']['1']['2']['2']['cont'] = "<input type='text' name='formParams[name]' size='35' maxlength='255' value=\"NewKeyword".date()."\" class='".$Block."_t3 ".$Block."_form_1'>\r";
		$Content .= "<p>".$I18nObj->getI18nEntry('invite2')."</p>\r";
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
."<input type='hidden' name='formTarget1[name]'			value='".$currentKeyWordObj->getKeyWordEntry('mc_nom')."'>\r"
."<input type='hidden' name='formGenericData[mode]'		value='".$processTarget."'>\r"
."<input type='hidden' name='keywordForm[selectionId]'	value='".$RequestDataObj->getRequestDataSubEntry('keywordForm', 'selectionId')."'>\r"
."<p>\r"
;


// --------------------------------------------------------------------------------------------

$T['AD']['1']['1']['1']['cont'] = $I18nObj->getI18nEntry('t1l1c1');
$T['AD']['1']['2']['1']['cont'] = $I18nObj->getI18nEntry('t1l2c1');
$T['AD']['1']['3']['1']['cont'] = $I18nObj->getI18nEntry('t1l3c1');
$T['AD']['1']['4']['1']['cont'] = $I18nObj->getI18nEntry('t1l4c1');
$T['AD']['1']['5']['1']['cont'] = $I18nObj->getI18nEntry('t1l5c1');
$T['AD']['1']['6']['1']['cont'] = $I18nObj->getI18nEntry('t1l6c1');
$T['AD']['1']['7']['1']['cont'] = $I18nObj->getI18nEntry('t1l7c1');
$T['AD']['1']['8']['1']['cont'] = $I18nObj->getI18nEntry('t1l8c1');


// $tabYN = array(
// 		0	=> array ( "t"=>$I18nObj->getI18nEntry('no'],		"db"=>"NO" ),
// 		1	=> array ( "t"=>$I18nObj->getI18nEntry('yes'],	"db"=>"YES" ),
// );
$tabLine = array(
		0	=> array ( "t"=>$I18nObj->getI18nEntry('offline'),	"db"=>"OFFLINE" ),
		1	=> array ( "t"=>$I18nObj->getI18nEntry('online'),		"db"=>"ONLINE" ),
		2	=> array ( "t"=>$I18nObj->getI18nEntry('deleted'),	"db"=>"DELETED" ),
);
// $tabStatus = array(
// 		0	=> array ( "t"=>$I18nObj->getI18nEntry('disabled'],	"db"=>"DISABLED" ),
// 		1	=> array ( "t"=>$I18nObj->getI18nEntry('enabled'],	"db"=>"ENABLED" ),
// );
$tabState = array(
		0 =>	array ( "t" => $I18nObj->getI18nEntry('kwState0'),	"db" => "OFFLINE"),
		1 =>	array ( "t" => $I18nObj->getI18nEntry('kwState1'),	"db" => "ONLINE"),
);


$T['AD']['1']['1']['2']['cont'] = $currentKeyWordObj->getKeyWordEntry('mc_id');

$tabState[$currentKeyWordObj->getKeyWordEntry('mc_etat')]['s'] = " selected ";
$T['AD']['1']['3']['2']['cont'] = "<select name='formParams[state]' class='".$Block."_t3 ".$Block."_form_1'>\r";
foreach ( $tabState as $A ) { $T['AD']['1']['3']['2']['cont'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$T['AD']['1']['3']['2']['cont'] .= "</select>\r";


$tabArticle_[$currentKeyWordObj->getKeyWordEntry('arti_id')]['s'] = " selected ";
$T['AD']['1']['4']['2']['cont'] = "<select name='formParams[article]' class='".$Block."_t3 ".$Block."_form_1'>\r";
foreach ( $tabArticle_ as $A ) { $T['AD']['1']['4']['2']['cont'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$T['AD']['1']['4']['2']['cont'] .= "</select>\r";


$T['AD']['1']['5']['2']['cont'] = "<input type='text' name='formParams[string]' size='35' maxlength='255' value=\"".$currentKeyWordObj->getKeyWordEntry('mc_chaine')."\" class='".$Block."_t3 ".$Block."_form_1'>\r";
$T['AD']['1']['6']['2']['cont'] = "<input type='text' name='formParams[count]' size='35' maxlength='255' value=\"".$currentKeyWordObj->getKeyWordEntry('mc_compteur')."\" class='".$Block."_t3 ".$Block."_form_1'>\r";

$tabType = array(
		1 =>	array ( "t" => $I18nObj->getI18nEntry('kwType1'),	"db" => "TO_CATEGORY"),
		2 =>	array ( "t" => $I18nObj->getI18nEntry('kwType2'),	"db" => "TO_URL"),
		3 =>	array ( "t" => $I18nObj->getI18nEntry('kwType3'),	"db" => "TOOLTIP"),
);
$tabType[$currentKeyWordObj->getKeyWordEntry('mc_type')]['s'] = " selected ";
$T['AD']['1']['7']['2']['cont'] = "<select name='formParams[type]' class='".$Block."_t3 ".$Block."_form_1'>\r";
foreach ( $tabType as $A ) { $T['AD']['1']['7']['2']['cont'] .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$T['AD']['1']['7']['2']['cont'] .= "</select>\r";

$T['AD']['1']['8']['2']['cont'] .= "<input type='text' name='formParams[data]' size='35' maxlength='255' value=\"".$currentKeyWordObj->getKeyWordEntry('mc_donnee')."\" class='".$Block."_t3 ".$Block."_form_1'>\r";

// --------------------------------------------------------------------------------------------
//
//	Display
//
//
// --------------------------------------------------------------------------------------------
$T['tab_infos'] = $RenderTablesObj->getDefaultDocumentConfig($infos, 9);
$T['ADC']['onglet'] = array(
		1	=>	$RenderTablesObj->getDefaultTableConfig(8,2,2),
);
$Content .= $RenderTablesObj->render($infos, $T);

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('Template');
$TemplateObj = Template::getInstance();
$infos['formName'] = "keywordForm";
$Content .= $TemplateObj->renderAdminFormButtons($infos);


/*Hydre-contenu_fin*/

$LMObj->setInternalLogTarget($logTarget);

?>
