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


$_REQUEST['CC']['fichier'] = "";
$_REQUEST['requete_insert'] = "show user";

$bts->RequestDataObj->setRequestData('formCommand',
array(
	'command'		=> 'show user',
	)
);

/*Hydre-contenu_debut*/
$localisation = " / uni_command_console_p01";
$bts->MapperObj->AddAnotherLevel($localisation );
$bts->LMObj->logCheckpoint("uni_command_console_p01.php");
$bts->MapperObj->RemoveThisLevel($localisation );
$bts->MapperObj->setSqlApplicant("uni_command_console_p01.php");

switch ($l) {
	case "fra":
	$bts->I18nTransObj->apply(array(
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
		Les entitées sont les suivantes : website, user, group, deadline, document, article, category, module, decoration, keyword.<br>\r
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
		));
	break;
	case "eng":
	$bts->I18nTransObj->apply(array(
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
		Entities are as follow : website, user, group, deadline, document, article, category, module, decoration, keyword.<br>\r
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
		));
	break;
}
		
// --------------------------------------------------------------------------------------------
//	Affichage
// --------------------------------------------------------------------------------------------

$Content .= "<form ACTION='index.php?' method='post' name='formConsole'>\r";
// --------------------------------------------------------------------------------------------
//	Tab 01
$T = array();
$BlockT = $infos['blockT'];

$T['AD']['1']['1']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1_l1');

$T['AD']['1']['2']['1']['cont'] = "<br>\r".$_REQUEST['requete_insert']."<br>\r&nbsp;";
$T['AD']['1']['2']['1']['class'] = $Block."_code ".$Block."_tb3 ";

$T['AD']['1']['3']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1_l3');
$T['AD']['1']['3']['1']['class'] = $Block."_fcta";

$T['AD']['1']['4']['1']['cont'] = "**************";

$T['AD']['1']['5']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t1_l5');
$T['AD']['1']['5']['1']['class'] = $Block."_fcta";

$T['AD']['1']['6']['1']['cont'] = "<textarea name='requete_insert' cols='".floor(($ThemeDataObj->getThemeDataEntry('theme_module_largeur_interne') / $ThemeDataObj->getThemeBlockEntry($BlockT, 'txt_fonte_size' ) ) * 1.35 )."' rows='6' class='".$Block."_t3 ".$Block."_form_1'></textarea>";
$T['AD']['1']['6']['1']['style'] = "text-align:center;";

$SB = array(
	"id"				=> "submitButton",
	"type"				=> "submit",
	"initialStyle"		=> $Block."_t3 ".$Block."_submit_s2_n",
	"hoverStyle"		=> $Block."_t3 ".$Block."_submit_s2_h",
	"onclick"			=> "",
	"message"			=> $bts->I18nTransObj->getI18nTransEntry('btn1'),
	"mode"				=> 0,
	"size" 				=> 0,
	"lastSize"			=> 0,
);
$T['AD']['1']['7']['1']['cont'] .= $bts->InteractiveElementsObj->renderSubmitButton($SB);
$T['AD']['1']['7']['1']['class'] = $Block."_fcd";

$T['ADC']['onglet']['1']['nbr_ligne'] = 7;	$T['ADC']['onglet']['1']['nbr_cellule'] = 1;	$T['ADC']['onglet']['1']['legende'] = 1;

// --------------------------------------------------------------------------------------------
//	Tab 02
$FileSelectorConfig = array(
	"width"				=> 80,	//in %
	"height"			=> 50,	//in %
	"formName"			=> "formConsole",
	"formTargetId"		=> "formConsole[inputFile]",
	"formInputSize"		=> 60 ,
	"formInputVal"		=> $formInputFile,
	"path"				=> $WebSiteObj->getWebSiteEntry('ws_directory')."/document",
	"restrictTo"		=> "websites-data",
	"strRemove"			=> "",
	"strAdd"			=> "../",
	"selectionMode"		=> "file",
	"displayType"		=> "fileList",
	"buttonId"			=> "buttonCommandConsole",
	"case"				=> 1,
	"array"				=> "tableFileSelector[".$CurrentSetObj->getDataEntry('fsIdx')."]",
);
$infos['IconSelectFile'] = $FileSelectorConfig;
$CurrentSetObj->setDataSubEntry('fs', $CurrentSetObj->getDataEntry('fsIdx'),$FileSelectorConfig);
$CurrentSetObj->setDataEntry('fsIdx', $CurrentSetObj->getDataEntry('fsIdx')+1 );



// $T['AD']['2']['1']['1']['style'] = "text-align:center;";

$T['AD']['2']['1']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t2_l1');

$T['AD']['2']['2']['1']['cont'] = $bts->InteractiveElementsObj->renderIconSelectFile($infos);

$T['AD']['2']['3']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t2_l3');

$T['AD']['2']['3']['1']['cont'] = $bts->InteractiveElementsObj->renderSubmitButton($SB);
// $T['AD']['2']['3']['1']['tc'] = 1;

$T['ADC']['onglet']['2']['nbr_ligne'] = 3;	$T['ADC']['onglet']['2']['nbr_cellule'] = 1;	$T['ADC']['onglet']['2']['legende'] = 1;

// --------------------------------------------------------------------------------------------
//	Tab 03

$T['AD']['3']['1']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('c1');
$T['AD']['3']['1']['2']['cont'] = $bts->I18nTransObj->getI18nTransEntry('c2');
$T['AD']['3']['1']['3']['cont'] = $bts->I18nTransObj->getI18nTransEntry('c3');
$T['AD']['3']['1']['4']['cont'] = $bts->I18nTransObj->getI18nTransEntry('c4');
$T['AD']['3']['1']['5']['cont'] = $bts->I18nTransObj->getI18nTransEntry('c5');
$T['AD']['3']['1']['6']['cont'] = $bts->I18nTransObj->getI18nTransEntry('c6');
$T['AD']['3']['1']['7']['cont'] = $bts->I18nTransObj->getI18nTransEntry('c7');

$tab = array (
	0	=>	"<span class='".$Block."_erreur'>Erreur</span>",
	1	=>	"<span class='".$Block."_ok ".$Block."_t1'>OK</span>",
	2	=>	"<span class='".$Block."_avert'>Avertissement</span>",
	3	=>	"Information",
	4	=>	"Autre",
);

$dbquery = $bts->SDDMObj->query("
SELECT *
FROM ".$SqlTableListObj->getSQLTableName('log')."
WHERE ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."'
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
	$T['AD']['3'][$l]['1']['cont'] = $dbp['log_id'];
	$T['AD']['3'][$l]['1']['tc'] = 1;
	$T['AD']['3'][$l]['2']['cont'] = date ( "Y m d H:i:s" , $dbp['log_date'] );
	$T['AD']['3'][$l]['2']['tc'] = 1;
	$T['AD']['3'][$l]['3']['cont'] = $dbp['log_initiator'];
	$T['AD']['3'][$l]['3']['tc'] = 1;
	$T['AD']['3'][$l]['4']['cont'] = $dbp['log_action'];
	$T['AD']['3'][$l]['4']['tc'] = 1;
	$T['AD']['3'][$l]['5']['cont'] = $tab[$dbp['log_signal']];
	$T['AD']['3'][$l]['5']['tc'] = 1;
	$T['AD']['3'][$l]['6']['cont'] = $dbp['log_msgid'];
	$T['AD']['3'][$l]['6']['tc'] = 1;
	$T['AD']['3'][$l]['7']['cont'] = $dbp['log_contenu'];
	$T['AD']['3'][$l]['7']['tc'] = 1;
	
// 	$tabfc_['tmp'] = $tabfc_['a'] ; $tabfc_['a'] = $tabfc_['c'] ; $tabfc_['c'] = $tabfc_['tmp'] ;
// 	$tabfc_['tmp'] = $tabfc_['b'] ; $tabfc_['b'] = $tabfc_['d'] ; $tabfc_['d'] = $tabfc_['tmp'] ;
	$l++;
}
$T['ADC']['onglet']['3']['nbr_ligne'] = 10;	$T['ADC']['onglet']['3']['nbr_cellule'] = 7;	$T['ADC']['onglet']['3']['legende'] = 1;

// --------------------------------------------------------------------------------------------
//	Tab 04
$T['AD']['4']['1']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t4_l1');
$T['ADC']['onglet']['4']['nbr_ligne'] = 1;	$T['ADC']['onglet']['4']['nbr_cellule'] = 1;	$T['ADC']['onglet']['4']['legende'] = 0;


// --------------------------------------------------------------------------------------------
$T['tab_infos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, 15, 4);

$T['ADC']['onglet'] = array(
		1	=>	$bts->RenderTablesObj->getDefaultTableConfig(7,1,1),
		2	=>	$bts->RenderTablesObj->getDefaultTableConfig(3,1,1),
		3	=>	$bts->RenderTablesObj->getDefaultTableConfig(10,7,1),
		4	=>	$bts->RenderTablesObj->getDefaultTableConfig(1,1,0),
);
$Content .= $bts->RenderTablesObj->render($infos, $T);


$Content .= "
<input type='hidden' name='CC_interface'				value='1'>\r
".
$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_sw').
$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_l').
$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_arti_ref').
$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_arti_page').
$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_user_login').
$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_user_pass')
;

$Content .= "</form>\r";

// --------------------------------------------------------------------------------------------

/*Hydre-contenu_fin*/
?>
