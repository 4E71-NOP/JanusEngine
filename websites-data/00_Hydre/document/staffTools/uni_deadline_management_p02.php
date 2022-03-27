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

$bts->RequestDataObj->setRequestData('formGenericData',
		array(
				'origin'		=> 'AdminDashboard',
				'section'		=> 'AdminDeadlineManagementP02',
				// 'mode'			=> 'edit',
				// 'modification'	=> 'on',
				// 'selectionId'	=> 2796541166005555744,
				'mode'			=> 'create',
				)
);

/*Hydr-Content-Begin*/
$localisation = " / uni_deadline_management_p02";
$bts->MapperObj->AddAnotherLevel($localisation );
$bts->LMObj->logCheckpoint("uni_deadline_management_p02.php");
$bts->MapperObj->RemoveThisLevel($localisation );
$bts->MapperObj->setSqlApplicant("uni_deadline_management_p02.php");

$bts->I18nTransObj->apply(
	array(
		"type" => "array",
		"fra" => array(
			"invite1"		=> "Cette partie va vous permettre de gérer le deadline.",
			"invite2"		=> "Cette partie va vous permettre de créer un deadline.",
			"tabTxt1"		=> "Informations",
			"dlState0"		=> "Hors ligne",
			"dlState1"		=> "En ligne",
			"dlState2"		=> "Désactivé",
			
			"t1l1c1"		=>	"ID",
			"t1l2c1"		=>	"Nom",
			"t1l3c1"		=>	"Titre",
			"t1l4c1"		=>	"Etat",
			"t1l5c1"		=>	"Date de cr&eacute;ation",
			"t1l6c1"		=>	"Date limite (YYYY-MM-DD hh:mm:ss)",
			"t1l7c1"		=>	"Créateur",
			"t1l8c1"		=>	"Articles de ce deadline",
			
			"t1l1c2"		=>	"?",
			"t1l2c2"		=>	"Nouveau_deadline",
			"t1l3c2"		=>	"Deadline_",
		),
		"eng" => array(
			"invite1"		=> "This part will allow you to manage this deadline.",
			"invite2"		=> "This part will allow you to create a deadline.",
			"tabTxt1"		=> "Informations",
			"dlState0"		=> "Offline",
			"dlState1"		=> "Online",
			"dlState2"		=> "Disabled",
			
			"t1l1c1"		=>	"ID",
			"t1l2c1"		=>	"Name",
			"t1l3c1"		=>	"Title",
			"t1l4c1"		=>	"State",
			"t1l5c1"		=>	"Creation date",
			"t1l6c1"		=>	"Threshold (YYYY-MM-DD hh:mm:ss)",
			"t1l7c1"		=>	"Creator",
			"t1l8c1"		=>	"Articles in this deadline",
			
			"t1l1c2"		=>	"?",
			"t1l2c2"		=>	"New_deadline",
			"t1l3c2"		=>	"Deadline_",
		)
	)
);

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('AdminFormTool');
$AdminFormToolObj = AdminFormTool::getInstance();
$Content .= $AdminFormToolObj->checkAdminDashboardForm($infos);

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('DeadLine');
$currentArticleObj = new DeadLine();

switch ($bts->RequestDataObj->getRequestDataSubEntry('formGenericData', 'mode')) {
	case "edit":
		$commandType = "update";
		$currentArticleObj->getDataFromDB($bts->RequestDataObj->getRequestDataSubEntry('formGenericData', 'selectionId'));
		unset ( $A , $B );
		$dbquery = $bts->SDDMObj->query("
		SELECT art.arti_name, art.arti_title
		FROM "
		.$SqlTableListObj->getSQLTableName('article')." as art, "
		.$SqlTableListObj->getSQLTableName('menu')." as mnu			
		WHERE art.fk_ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."'
		AND art.fk_deadline_id = '".$currentArticleObj->getDeadLineEntry('deadline_id')."'
		AND art.fk_ws_id = mnu.fk_ws_id
		AND art.arti_ref = mnu.fk_arti_ref
		AND art.arti_page = '1'	
		AND mnu.menu_type IN ('0','1')
		AND mnu.fk_lang_id = '".$CurrentSetObj->getDataEntry('language_id')."'
		;");

		$linkId1 = "<a href='"
		."index.php?"._HYDRLINKURLTAG_."=1"
		."&arti_slug=article_management"
		."&arti_ref=".$CurrentSetObj->getDataSubEntry ( 'article', 'arti_ref')
		."&arti_page=2"
		."&formGenericData[mode]=edit"
		."&formGenericData[selectionId]=";
		
		$articleList = "";
		while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
			$articleList .= $linkId1.$dbp['arti_ref']."&formGenericData[selectionPage]=1'>".$dbp['arti_title']."</a> - ";
		}
		$commandType = "update";
		$Content .= "<p>".$bts->I18nTransObj->getI18nTransEntry('invite1')."</p>\r";
		// $processStep = "";
		// $processTarget = "edit";
		break;
	case "create":
		$commandType = "add";
		$currentArticleObj->setDeadLine(
			array(
				'deadline_state'	=>	1,
				'ws_id'				=>	$WebSiteObj->getWebSiteEntry('ws_id'),
				'user_id'			=>	$CurrentSetObj->getInstanceOfUserObj()->getUserEntry('user_id'),
				'user_login'		=>	$CurrentSetObj->getInstanceOfUserObj()->getUserEntry('user_login'),
			),
		);
		$commandType = "add";
		$Content .= "<p>".$bts->I18nTransObj->getI18nTransEntry('invite2')."</p>\r";
		// $processStep = "Create";
		break;
	}
	
	// $processTarget = "edit";
// --------------------------------------------------------------------------------------------

$Content .= "
<form ACTION='index.php?' method='post' name='deadlineForm'>\r"
."<input type='hidden' name='formSubmitted'					value='1'>\r"
."<input type='hidden' name='formGenericData[origin]'		value='AdminDashboard'>\r"
."<input type='hidden' name='formGenericData[section]'		value='AdminDeadlineManagementP02'>"
."<input type='hidden' name='formCommand1'					value='".$commandType."'>"
."<input type='hidden' name='formEntity1'					value='deadline'>"
."<input type='hidden' name='formGenericData[mode]'			value='edit'>\r"
."<input type='hidden' name='formGenericData[selectionId]'	value='".$bts->RequestDataObj->getRequestDataSubEntry('formGenericData', 'selectionId')."'>\r"
."<p>\r"
;

// --------------------------------------------------------------------------------------------
$T = array();

$T['Content']['1']['1']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l1c1');
$T['Content']['1']['2']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l2c1');
$T['Content']['1']['3']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l3c1');
$T['Content']['1']['4']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l4c1');
$T['Content']['1']['5']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l5c1');
$T['Content']['1']['6']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l6c1');
$T['Content']['1']['7']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l8c1');

switch ( $bts->RequestDataObj->getRequestDataSubEntry('formGenericData', 'mode') ) {
	case "edit":
		$T['Content']['1']['1']['2']['cont'] = $currentArticleObj->getDeadLineEntry('deadline_id');
		$T['Content']['1']['2']['2']['cont'] = $currentArticleObj->getDeadLineEntry('deadline_name')
		."<input type='hidden' name='formParams1[name]' value='".$currentArticleObj->getDeadLineEntry('deadline_name')."'>\r"
		;
		$T['Content']['1']['3']['2']['cont'] = "<input type='text' name='formParams1[title]' size='45' maxlength='255' value=\"".$currentArticleObj->getDeadLineEntry('deadline_title')."\">\r";
		$T['Content']['1']['5']['2']['cont'] = date ( "Y-m-d G:i:s" , $currentArticleObj->getDeadLineEntry('deadline_creation_date'));
		$T['Content']['1']['6']['2']['cont'] = "<input type='text' name='formParams1[end_date]' size='45' maxlength='255' value=\"".date ( "Y-m-d G:i:s" , $currentArticleObj->getDeadLineEntry('deadline_end_date'))."\">\r";
		$T['Content']['1']['7']['2']['cont'] = $articleList;
		break;
	case "create":
		$T['Content']['1']['1']['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l1c1');
		$T['Content']['1']['2']['2']['cont'] = "<input type='text' name='formParams1[name]' size='45' maxlength='255' value='".$bts->I18nTransObj->getI18nTransEntry('t1l2c2')."''>\r";
		$T['Content']['1']['3']['2']['cont'] = "<input type='text' name='formParams1[title]' size='45' maxlength='255' value='". $bts->I18nTransObj->getI18nTransEntry('t1l3c2') . date ( "Y-m-d G:i:s" , (time()+ (60*60*24*30)) )."'>\r";
		$T['Content']['1']['5']['2']['cont'] = date ( "Y-m-d G:i:s" , time() ) ;
		$T['Content']['1']['7']['2']['cont'] = "<input type='text' name='formParams1[end_date]' size='45' maxlength='255' value='".date ( "Y-m-d G:i:s" , (time()+ (60*60*24*3650)) )."'>\r";
		break;
}

$stateTab = array(
		0	=>	array(	't'	=>	$bts->I18nTransObj->getI18nTransEntry('dlState0'),	'db'	=>	"OFFLINE",	),
		1	=>	array(	't'	=>	$bts->I18nTransObj->getI18nTransEntry('dlState1'),	'db'	=>	"ONLINE",	),
		2	=>	array(	't'	=>	$bts->I18nTransObj->getI18nTransEntry('dlState2'),	'db'	=>	"DELETED",	),
);
$stateTab[$currentArticleObj->getDeadLineEntry('deadline_state')]['s'] = " selected";
$str = "<select name ='formParams1[state]'>\r";
foreach ( $stateTab as $A ) { $str .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$str .= "</select>\r";

$T['Content']['1']['4']['2']['cont'] = $str;

// --------------------------------------------------------------------------------------------
//
//	Display
//
//
// --------------------------------------------------------------------------------------------
$T['ContentInfos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, 10);
$T['ContentCfg']['tabs'] = array(
		1	=>	$bts->RenderTablesObj->getDefaultTableConfig(7,2,2),
);
$Content .= $bts->RenderTablesObj->render($infos, $T);

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('Template');
$TemplateObj = Template::getInstance();
$infos['formName'] = "deadlineForm";
$Content .= $TemplateObj->renderAdminFormButtons($infos);

/*Hydr-Content-End*/


?>
