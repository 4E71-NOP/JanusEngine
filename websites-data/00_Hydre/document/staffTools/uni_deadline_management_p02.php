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

$bts->RequestDataObj->setRequestData('deadlineForm',
	array(
			'mode'			=> 'edit',
// 			'mode'			=> 'create',
			'selectionId'	=>	4,
	)
);
$bts->RequestDataObj->setRequestData('formGenericData',
		array(
				'origin'				=> 'AdminDashboard',
				'section'				=> 'AdminDeadlineManagementP02',
				'creation'		=> 'on',
				'modification'	=> 'on',
				'deletion'		=> 'on',
				'mode'			=> 'edit',
//				'mode'			=> 'create',
//				'mode'			=> 'delete',
	)
);

/*Hydre-contenu_debut*/
$localisation = " / uni_deadline_management_p02";
$bts->MapperObj->AddAnotherLevel($localisation );
$bts->LMObj->logCheckpoint("uni_deadline_management_p02.php");
$bts->MapperObj->RemoveThisLevel($localisation );
$bts->MapperObj->setSqlApplicant("uni_deadline_management_p02.php");

switch ($l) {
	case "fra":
		$bts->I18nTransObj->apply(array(
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
		));
		break;
	case "eng":
		$bts->I18nTransObj->apply(array(
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
		));
		break;
}

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('AdminFormTool');
$AdminFormToolObj = AdminFormTool::getInstance();
$Content .= $AdminFormToolObj->checkAdminDashboardForm($infos);

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('DeadLine');
$currentArticleObj = new DeadLine();

switch ($bts->RequestDataObj->getRequestDataSubEntry('deadlineForm', 'mode')) {
	case "edit":
		$commandType = "update";
		$currentArticleObj->getDeadLineDataFromDB($bts->RequestDataObj->getRequestDataSubEntry('deadlineForm', 'selectionId'));
		unset ( $A , $B );
		$dbquery = $bts->SDDMObj->query("
		SELECT art.arti_name, art.arti_title
		FROM ".$SqlTableListObj->getSQLTableName('article')." as art, ".$SqlTableListObj->getSQLTableName('category')." as cat
					
		WHERE art.ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."'
		AND art.deadline_id = '".$currentArticleObj->getDeadLineEntry('deadline_id')."'
		AND art.ws_id = cat.ws_id
		AND art.arti_ref = cat.arti_ref
		AND art.arti_page = '1'
					
		AND cat.cate_type IN ('0','1')
		AND cat.lang_id = '".$CurrentSetObj->getDataEntry('language_id')."'
		;");

		$linkId1 = "<a class='".$Block."_lien' href='index.php?sw="
				.$WebSiteObj->getWebSiteEntry('ws_id')
				."&arti_ref=".$CurrentSetObj->getDataEntry('language')."_gestion_des_articles"
				."&arti_page=3"
				."&l=".$CurrentSetObj->getDataEntry('language')
				."&articleForm[mode]=edit"
				;
		
		$articleList = "";
		while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
			$articleList	.= $linkId1."&articleForm[arti_ref_selection]=".$dbp['arti_name']."&articleForm[arti_page_selection]=1' 
		>".$dbp['arti_title']."</a> - ";
		}
		$commandType = "update";
		$Content .= "<p>".$bts->I18nTransObj->getI18nTransEntry('invite1')."</p>\r";
		$processStep = "";
		$processTarget = "edit";
		break;
	case "create":
		$commandType = "add";
		$currentArticleObj->setDeadLine(
				array(
		'deadline_state'	=>	1,
		'ws_id'		=>	$WebSiteObj->getWebSiteEntry('ws_id'),
		'user_id'		=>	$UserObj->getUserEntry('user_id'),
		'user_login'	=>	$UserObj->getUserEntry('user_login'),
				),
		);
		$commandType = "add";
		$Content .= "<p>".$bts->I18nTransObj->getI18nTransEntry('invite2')."</p>\r";
		$processStep = "Create";
		$processTarget = "edit";
		break;
}

// --------------------------------------------------------------------------------------------

$Content .= "
<form ACTION='index.php?' method='post' name='deadlineForm'>\r"
.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_sw')
.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_l')
.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_arti_ref')
.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_arti_page')
."<input type='hidden' name='formGenericData[origin]'	value='AdminDashboard".$processStep."'>\r"
."<input type='hidden' name='formGenericData[section]'	value='AdminDeadlineManagementP02'>"
."<input type='hidden' name='formCommand1'				value='".$commandType."'>"
."<input type='hidden' name='formEntity1'				value='deadline'>"
."<input type='hidden' name='formTarget1[name]'			value='".$currentArticleObj->getDeadLineEntry('deadline_name')."'>\r"
."<input type='hidden' name='formGenericData[mode]'		value='".$processTarget."'>\r"
."<input type='hidden' name='deadlineFrom[selectionId]'	value='".$bts->RequestDataObj->getRequestDataSubEntry('deadlineFrom', 'selectionId')."'>\r"
		
."<p>\r"
;


// --------------------------------------------------------------------------------------------
$T = array();

$T['AD']['1']['1']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l1c1');
$T['AD']['1']['2']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l2c1');
$T['AD']['1']['3']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l3c1');
$T['AD']['1']['4']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l4c1');
$T['AD']['1']['5']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l5c1');
$T['AD']['1']['6']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l6c1');
$T['AD']['1']['7']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l7c1');
$T['AD']['1']['8']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l8c1');

switch ( $bts->RequestDataObj->getRequestDataSubEntry('deadlineForm', 'mode') ) {
	case "edit":
		$T['AD']['1']['1']['2']['cont'] = $currentArticleObj->getDeadLineEntry('deadline_id');
		$T['AD']['1']['2']['2']['cont'] = $currentArticleObj->getDeadLineEntry('deadline_name');
		$T['AD']['1']['3']['2']['cont'] = "<input type='text' name='formParams[titre]' size='45' maxlength='255' value=\"".$currentArticleObj->getDeadLineEntry('deadline_title')."\" class='".$Block."_t3 ".$Block."_form_1'>\r";
		$T['AD']['1']['5']['2']['cont'] = date ( "Y-m-d G:i:s" , $currentArticleObj->getDeadLineEntry('deadline_creation_date'));
		$T['AD']['1']['6']['2']['cont'] = "<input type='text' name='formParams[date_limite]' size='45' maxlength='255' value=\"".date ( "Y-m-d G:i:s" , $currentArticleObj->getDeadLineEntry('deadline_end_date'))."\" class='".$Block."_t3 ".$Block."_form_1'>\r";
		$T['AD']['1']['8']['2']['cont'] = $articleList;
		$T['ADC']['onglet']['1']['nbr_ligne'] = 8;	$T['ADC']['onglet']['1']['nbr_cellule'] = 2;	$T['ADC']['onglet']['1']['legende'] = 2;
		break;
	case "create":
		$T['AD']['1']['1']['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1l1c1');
		$T['AD']['1']['2']['2']['cont'] = "<input type='text' name='formParams[nom]' size='45' maxlength='255' value='".$bts->I18nTransObj->getI18nTransEntry('t1l2c2')."' class='".$Block."_t3 ".$Block."_form_1'>\r";
		$T['AD']['1']['3']['2']['cont'] = "<input type='text' name='formParams[titre]' size='45' maxlength='255' value='". $bts->I18nTransObj->getI18nTransEntry('t1l3c2') . date ( "Y-m-d G:i:s" , (mktime()+ (60*60*24*30)) )."' class='".$Block."_t3 ".$Block."_form_1'>\r";
		$T['AD']['1']['5']['2']['cont'] = date ( "Y-m-d G:i:s" , mktime() ) ;
		$T['AD']['1']['6']['2']['cont'] = "<input type='text' name='formParams[date_limite]' size='45' maxlength='255' value='".date ( "Y-m-d G:i:s" , (mktime()+ (60*60*24*30)) )."' class='".$Block."_t3 ".$Block."_form_1'>\r";
		$T['ADC']['onglet']['1']['nbr_ligne'] = 7;	$T['ADC']['onglet']['1']['nbr_cellule'] = 2;	$T['ADC']['onglet']['1']['legende'] = 2;
		break;
}

$stateTab = array(
		0	=>	array(	't'	=>	$bts->I18nTransObj->getI18nTransEntry('dlState0'),	'db'	=>	"OFFLINE",	),
		1	=>	array(	't'	=>	$bts->I18nTransObj->getI18nTransEntry('dlState1'),	'db'	=>	"ONLINE",	),
		2	=>	array(	't'	=>	$bts->I18nTransObj->getI18nTransEntry('dlState2'),	'db'	=>	"DELETED",	),
);
$stateTab[$currentArticleObj->getDeadLineEntry('deadline_state')]['s'] = " selected";
$str = "<select name ='formParams[etat]' class='".$Block."_t3 ".$Block."_form_1'>\r";
foreach ( $stateTab as $A ) { $str .= "<option value='".$A['db']."' ".$A['s']."> ".$A['t']." </option>\r"; }
$str .= "</select>\r";

$T['AD']['1']['4']['2']['cont'] = $str;
$T['AD']['1']['7']['2']['cont'] = $currentArticleObj->getDeadLineEntry('user_login');

// --------------------------------------------------------------------------------------------
//
//	Display
//
//
// --------------------------------------------------------------------------------------------
$T['tab_infos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, 12);
$T['ADC']['onglet'] = array(
		1	=>	$bts->RenderTablesObj->getDefaultTableConfig(8,2,2),
);
$Content .= $bts->RenderTablesObj->render($infos, $T);

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('Template');
$TemplateObj = Template::getInstance();
$infos['formName'] = "deadlineForm";
$Content .= $TemplateObj->renderAdminFormButtons($infos);

/*Hydre-contenu_fin*/

// $LMObj->setInternalLogTarget($LOG_TARGET);

?>
