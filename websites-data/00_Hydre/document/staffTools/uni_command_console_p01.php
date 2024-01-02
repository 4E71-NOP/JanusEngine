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


//add user login "dieu2" perso_name "Dieu2"  password dieu status ACTIVE	image_avatar "../websites-datas/www.rootwave.net/data/images/avatars/public/dieu.gif"	role_function PRIVATE;
//user dieu2 join_group Server_owner primary_group OUI;
//user dieu2 join_group Developpeurs_senior primary_group NON;
//user dieu2 join_group Developpeurs_confirme primary_group NON;
//user dieu2 join_group Developpeurs_debutant primary_group NON;
//show user;


// $_REQUEST['CC']['fichier'] = "";
// $_REQUEST['requete_insert'] = "show user";

$bts->RequestDataObj->setRequestData('formConsole',
array(
	"CLiContent"		=> "show user",
	"CLiContentResult"	=> array("result 01", "result 02", "result 03", "result 04", "result 05"),
	)
);

/*Hydr-Content-Begin*/
$localisation = " / uni_command_console_p01";
$bts->MapperObj->AddAnotherLevel($localisation );
$bts->LMObj->logCheckpoint("uni_command_console_p01.php");
$bts->MapperObj->RemoveThisLevel($localisation );
$bts->MapperObj->setSqlApplicant("uni_command_console_p01.php");

$bts->I18nTransObj->apply(
	array(
		"type" => "array",
		"fra" => array(
			"tabTxt1"		=> "Mode CLI",
			"tabTxt2"		=> "Mode fichier",
			"tabTxt3"		=> "Journaux",
			"tabTxt4"		=> "Aide",
			"col_1_txt"		=> "Nom",
			"col_2_txt"		=> "Etat",
			"col_3_txt"		=> "Date",
			"raf1"			=> "Rien à afficher",
			"btn1"			=> "Soumettre",
			"t1_l1"			=> "Dernier tampon de commande",
			"t1_l3"			=> "Résultat",
			"t1_l5"			=> "Commande à exécuter",
			"t2_l1"			=> "Sélectionnez un fichier",
			"t2_l3"			=> "Si un fichier est sélectionné, il prendra la priorité. Seul le contenu du fichier sera exécuté.",
			"t4_l1"			=> "Utilisez '<b>;</b>' comme separateur.<br>\r
			<br>\r
			Les entitées sont les suivantes : website, user, group, deadline, document, article, menu, module, decoration, keyword.<br>\r
			<br>\r
			<span style='text-decoration: underline;'>Liste de commandes basiques:</span>
			<ul>
			<li>show &lt;<i>ENTITÉ</i>&gt;; Affiche la liste du type donné.</li>
			<li>show &lt;<i>ENTITÉ</i>&gt; name '<i>myEntity</i>'; Affiche les détails de l'élément de l'entité donnée.</li>
			</ul>
			",
			"c1"			=> "N",
			"c2"			=> "Date",
			"c3"			=> "Initiateur",
			"c4"			=> "Action",
			"c5"			=> "Signal",
			"c6"			=> "Message ID",
			"c7"			=> "Message",
		),
	"eng" => array(
		"tabTxt1"		=> "Command",
		"tabTxt2"		=> "File mode",
		"tabTxt3"		=> "Logs",
		"tabTxt4"		=> "Help",
		"col_1_txt"		=> "Name",
		"col_2_txt"		=> "Status",
		"col_3_txt"		=> "Date",
		"raf1"			=> "Nothing to display",
		"btn1"			=> "Submit",
		"t1_l1"			=> "Last buffer",
		"t1_l3"			=> "Result",
		"t1_l5"			=> "Commande à exécuter",
		"t2_l1"			=> "Select a file",
		"t2_l3"			=> "If a file is selected, it will take over the console box. Only the file content will be executed.",
		"t4_l1"			=> "Use '<b>;</b>' as separator.<br>\r
		<br>\r
		Entities are as follow : website, user, group, deadline, document, article, menu, module, decoration, keyword.<br>\r
		<br>\r
		<span style='text-decoration: underline;'>Basic command list:</span>
		<ul>
		<li>show &lt;<i>ENTITY</i>&gt;; Display the entity list.</li>
		<li>show &lt;<i>ENTITY</i>&gt; name '<i>myEntity</i>'; Display details about this entity.</li>
		</ul>
		",
		"c1"			=> "N",
		"c2"			=> "Date",
		"c3"			=> "Initiator",
		"c4"			=> "Action",
		"c5"			=> "Signal",
		"c6"			=> "Message ID",
		"c7"			=> "Message",
		)
	)
);
		
// --------------------------------------------------------------------------------------------
//	Affichage
// --------------------------------------------------------------------------------------------

$Content .= "<form ACTION='index.php?' method='post' name='formConsole'>\r";
// --------------------------------------------------------------------------------------------
//	Tab 01
$T = array();
$BlockT = $infos['blockT'];

$T['Content']['1']['1']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1_l1');
$T['Content']['1']['2']['1']['cont'] = "<br>\r>>> ".$bts->RequestDataObj->getRequestDataSubEntry('formConsole', 'CLiContent')."<br>\r&nbsp;";
$T['Content']['1']['3']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1_l3');
$T['Content']['1']['4']['1']['cont'] = $bts->StringFormatObj->arrayToHtmlTable($bts->RequestDataObj->getRequestDataSubEntry('formConsole', 'CLiContentResult'), $infos);
$T['Content']['1']['5']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1_l5');
$T['Content']['1']['6']['1']['cont'] = "<textarea name='formConsole[CLiContent]' style='width:90%' rows='6'></textarea>";
$T['Content']['1']['6']['1']['style'] = "text-align:center;";

$SB = $bts->InteractiveElementsObj->getDefaultSubmitButtonConfig(
	$infos,
	"submit",
	$bts->I18nTransObj->getI18nTransEntry('btn1'),
	0,
	"T01submitButton",
	2,
	2,
	"",
	0
);

$T['Content']['1']['7']['1']['cont'] .= $bts->InteractiveElementsObj->renderSubmitButton($SB);

$T['ContentCfg']['tabs']['1']['NbrOfLines'] = 7;	$T['ContentCfg']['tabs']['1']['NbrOfCells'] = 1;	$T['ContentCfg']['tabs']['1']['TableCaptionPos'] = 1;

// --------------------------------------------------------------------------------------------
//	Tab 02
$FileSelectorConfig = $bts->InteractiveElementsObj->getDefaultIconSelectFileConfig(
	"formConsole",
	"formConsole[inputFile]",
	60,
	$formInputFile,
	$WebSiteObj->getWebSiteEntry('ws_directory')."/document",
	"websites-data",
	"buttonCommandConsole",
);
$FileSelectorConfig['strRemove'] = "";
$FileSelectorConfig['strAdd'] = "../";
$FileSelectorConfig['case'] = 1;

$infos['IconSelectFile'] = $FileSelectorConfig;
$CurrentSetObj->setDataSubEntry('fs', $CurrentSetObj->getDataEntry('fsIdx'),$FileSelectorConfig);
$CurrentSetObj->setDataEntry('fsIdx', $CurrentSetObj->getDataEntry('fsIdx')+1 );

$SB['id'] = "T02submitButton";
$T['Content']['2']['1']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t2_l1');
$T['Content']['2']['2']['1']['cont'] = $bts->InteractiveElementsObj->renderIconSelectFile($infos);
$T['Content']['2']['3']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t2_l3');
$T['Content']['2']['3']['1']['cont'] = $bts->InteractiveElementsObj->renderSubmitButton($SB);
$T['ContentCfg']['tabs']['2']['NbrOfLines'] = 3;	$T['ContentCfg']['tabs']['2']['NbrOfCells'] = 1;	$T['ContentCfg']['tabs']['2']['TableCaptionPos'] = 1;

// --------------------------------------------------------------------------------------------
//	Tab 03

$T['Content']['3']['1']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('c1');
$T['Content']['3']['1']['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('c2');
$T['Content']['3']['1']['3']['cont'] = $bts->I18nTransObj->getI18nTransEntry('c3');
$T['Content']['3']['1']['4']['cont'] = $bts->I18nTransObj->getI18nTransEntry('c4');
$T['Content']['3']['1']['5']['cont'] = $bts->I18nTransObj->getI18nTransEntry('c5');
$T['Content']['3']['1']['6']['cont'] = $bts->I18nTransObj->getI18nTransEntry('c6');
$T['Content']['3']['1']['7']['cont'] = $bts->I18nTransObj->getI18nTransEntry('c7');

$tab = array (
	0	=>	"<span class='".$Block."_error'>Erreur</span>",
	1	=>	"<span class='".$Block."_ok ".$Block."_t1'>OK</span>",
	2	=>	"<span class='".$Block."_warning'>Avertissement</span>",
	3	=>	"Information",
	4	=>	"Autre",
);

$dbquery = $bts->SDDMObj->query("
SELECT *
FROM ".$SqlTableListObj->getSQLTableName('log')."
WHERE fk_ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."'
ORDER BY log_id DESC
LIMIT 0,10
;");


$l = 2;
while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
	$log_action_longeur = strlen($dbp['log_action']);
	switch (TRUE) {
		case ($log_action_longeur < 128 && $log_action_longeur > 64):	$dbp['log_action'] = substr ($dbp['log_action'],0,59) . " [...] ";		break;
		case ($log_action_longeur > 128):								$dbp['log_action'] = substr ($dbp['log_action'],0,59) . " [...] " . substr ($dbp['log_action'],($log_action_longeur - 64) ,$log_action_longeur );		break;
	}
	$T['Content']['3'][$l]['1']['cont'] = $dbp['log_id'];
	$T['Content']['3'][$l]['2']['cont'] = date ( "Y m d H:i:s" , $dbp['log_date'] );
	$T['Content']['3'][$l]['3']['cont'] = $dbp['log_initiator'];
	$T['Content']['3'][$l]['4']['cont'] = $dbp['log_action'];
	$T['Content']['3'][$l]['5']['cont'] = $tab[$dbp['log_signal']];
	$T['Content']['3'][$l]['6']['cont'] = $dbp['log_msgid'];
	$T['Content']['3'][$l]['7']['cont'] = $dbp['log_contenu'];
	
	$l++;
}
$T['ContentCfg']['tabs']['3']['NbrOfLines'] = 10;	$T['ContentCfg']['tabs']['3']['NbrOfCells'] = 7;	$T['ContentCfg']['tabs']['3']['TableCaptionPos'] = 1;

// --------------------------------------------------------------------------------------------
//	Tab 04
$T['Content']['4']['1']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4_l1');
$T['ContentCfg']['tabs']['4']['NbrOfLines'] = 1;	$T['ContentCfg']['tabs']['4']['NbrOfCells'] = 1;	$T['ContentCfg']['tabs']['4']['TableCaptionPos'] = 0;


// --------------------------------------------------------------------------------------------
$T['ContentInfos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, 15, 4);

$T['ContentCfg']['tabs'] = array(
		1	=>	$bts->RenderTablesObj->getDefaultTableConfig(7,1,1),
		2	=>	$bts->RenderTablesObj->getDefaultTableConfig(3,1,1),
		3	=>	$bts->RenderTablesObj->getDefaultTableConfig(10,7,1),
		4	=>	$bts->RenderTablesObj->getDefaultTableConfig(1,1,0),
);
$Content .= $bts->RenderTablesObj->render($infos, $T);

$Content .= 
$bts->RenderFormObj->renderformHeader('ConsoleCommandForm')
.$bts->RenderFormObj->renderHiddenInput(	"formSubmitted"	,				"1")
.$bts->RenderFormObj->renderHiddenInput(	"formGenericData[origin]"	,	"AdminDashboard")
.$bts->RenderFormObj->renderHiddenInput(	"formGenericData[section]"	,	"CommandConsole" )
// .$bts->RenderFormObj->renderHiddenInput(	"formCommand1"				,	"" )
// .$bts->RenderFormObj->renderHiddenInput(	"formEntity1"				,	"" )
;

$Content .= "</form>\r";

// --------------------------------------------------------------------------------------------

/*Hydr-Content-End*/
?>
