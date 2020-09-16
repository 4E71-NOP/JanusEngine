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
/* @var $CMObj ConfigurationManagement              */
/* @var $ClassLoaderObj ClassLoader                 */
/* @var $LMObj LogManagement                        */
/* @var $MapperObj Mapper                           */
/* @var $InteractiveElementsObj InteractiveElements */
/* @var $RenderTablesObj RenderTables               */
/* @var $RequestDataObj RequestData                 */
/* @var $SDDMObj DalFacade                          */
/* @var $SqlTableListObj SqlTableList               */
/* @var $StringFormatObj StringFormat               */

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


//add user login "dieu2" perso_name "Dieu2"  password dieu status ACTIVE	image_avatar "../websites-datas/www.rootwave.net/data/images/avatars/public/dieu.gif"	role_function PRIVATE;
//user dieu2 join_group Server_owner primary_group OUI;
//user dieu2 join_group Developpeurs_senior primary_group NON;
//user dieu2 join_group Developpeurs_confirme primary_group NON;
//user dieu2 join_group Developpeurs_debutant primary_group NON;
//show user;


$_REQUEST['CC']['fichier'] = "";
$_REQUEST['requete_insert'] = "show user";

$RequestDataObj->setRequestData('formCommand',
		array(
				'command'		=> 'show user',
		)
);

/*Hydre-contenu_debut*/
$localisation = " / uni_console_de_commande_p01";
$MapperObj->AddAnotherLevel($localisation );
$LMObj->logCheckpoint("uni_console_de_commande_p01");
$MapperObj->RemoveThisLevel($localisation );
$MapperObj->setSqlApplicant("uni_console_de_commande_p01");

switch ($l) {
	case "fra":
		$i18nDoc = array(
		"cell_1_txt"	=> "Mode CLI",
		"cell_2_txt"	=> "Mode fichier",
		"cell_3_txt"	=> "Journaux",
		"cell_4_txt"	=> "Aide",
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
		);
		break;
	case "eng":
		$i18nDoc = array(
		"cell_1_txt"	=> "Command",
		"cell_2_txt"	=> "File mode",
		"cell_3_txt"	=> "Logs",
		"cell_4_txt"	=> "Help",
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
		
		);
		break;
}


// --------------------------------------------------------------------------------------------
//	Affichage
// --------------------------------------------------------------------------------------------

$Content .= "<form ACTION='index.php?' method='post' name='formConsole'>\r";

// if ( $_REQUEST['ICC_controle']['affichage_requis'] == 1 ) {
// 	$Content .= "
// 	<table ".$ThemeDataObj->getThemeDataEntry('tab_std_rules')." width='".$ThemeDataObj->getThemeDataEntry('theme_module_largeur_interne')."'>\r
// 	<caption class='" . $Block."_fctb " . $Block."_tb3'>".$_REQUEST['ICC_caption']."</caption>
// 	";
// 	foreach ( $_REQUEST['ICC'] as $cle => $valeur ) {
// 		$Content .= "
// 		<tr>\r
// 		<td class='".$Block."_fcta ".$Block."_t1'>".$cle."</td>
// 		<td class='".$Block."_fcta ".$Block."_t1'>".$valeur."</td>
// 		</tr>\r
// 		";
// 	}
// 	$Content .= "</table>\r<br>\r";
// }

// --------------------------------------------------------------------------------------------
//	Tab 01
$T = array();
$BlockT = $infos['blockT'];

$T['AD']['1']['1']['1']['cont'] = $i18nDoc['t1_l1'];

$T['AD']['1']['2']['1']['cont'] = "<br>\r".$_REQUEST['requete_insert']."<br>\r&nbsp;";
$T['AD']['1']['2']['1']['class'] = $Block."_code ".$Block."_tb3 ";

$T['AD']['1']['3']['1']['cont'] = $i18nDoc['t1_l3'];
$T['AD']['1']['3']['1']['class'] = $Block."_fcta";

$T['AD']['1']['4']['1']['cont'] = "**************";

$T['AD']['1']['5']['1']['cont'] = $i18nDoc['t1_l5'];
$T['AD']['1']['5']['1']['class'] = $Block."_fcta";

$T['AD']['1']['6']['1']['cont'] = "<textarea name='requete_insert' cols='".floor(($ThemeDataObj->getThemeDataEntry('theme_module_largeur_interne') / $BlockT['fonte_size_n3'] ) * 1.35 )."' rows='6' class='".$Block."_t3 ".$Block."_form_1'></textarea>";
$T['AD']['1']['6']['1']['style'] = "text-align:center;";

$SB = array(
		"id"				=> "submitButton",
		"type"				=> "submit",
		"initialStyle"		=> $Block."_t3 ".$Block."_submit_s2_n",
		"hoverStyle"		=> $Block."_t3 ".$Block."_submit_s2_h",
		"onclick"			=> "",
		"message"			=> $i18nDoc['btn1'],
		"mode"				=> 0,
		"size" 				=> 0,
		"lastSize"			=> 0,
);
$T['AD']['1']['7']['1']['cont'] .= $InteractiveElementsObj->renderSubmitButton($SB);
$T['AD']['1']['7']['1']['class'] = $Block."_fcd";


$T['ADC']['onglet']['1']['nbr_ligne'] = 7;	$T['ADC']['onglet']['1']['nbr_cellule'] = 1;	$T['ADC']['onglet']['1']['legende'] = 1;

// --------------------------------------------------------------------------------------------
//	Tab 02

$CurrentSetObj->setDataSubEntry('fs', $CurrentSetObj->getDataEntry('fsIdx'),
		array(
				"width"				=> 80,	//in %
				"height"			=> 50,	//in %
				"formName"			=> "formConsole",
				"formTargetId"		=> "inputFile",
				"path"				=> $WebSiteObj->getWebSiteEntry('sw_repertoire')."/script",
				"selectionMode"		=> "file",
		)
);

$infos['IconSelectFile'] = array(
		"case"				=> 1 ,
		"formName"			=> "formConsole",
		"formInputId"		=> "inputFile",
		"formInputSize"		=> 40 ,
		"formInputVal"		=> "",
		"path"				=> $WebSiteObj->getWebSiteEntry('sw_repertoire')."/script",
		"array"				=> "tableFileSelector[".$CurrentSetObj->getDataEntry('fsIdx')."]",
);
$CurrentSetObj->setDataEntry('fsIdx', $CurrentSetObj->getDataEntry('fsIdx')+1);


// $T['AD']['2']['1']['1']['style'] = "text-align:center;";

$T['AD']['2']['1']['1']['cont'] = $i18nDoc['t2_l1'];

$T['AD']['2']['2']['1']['cont'] = $InteractiveElementsObj->renderIconSelectFile($infos);

$T['AD']['2']['3']['1']['cont'] = $i18nDoc['t2_l3'];
$T['AD']['2']['3']['1']['tc'] = 1;

$T['ADC']['onglet']['2']['nbr_ligne'] = 3;	$T['ADC']['onglet']['2']['nbr_cellule'] = 1;	$T['ADC']['onglet']['2']['legende'] = 1;

// --------------------------------------------------------------------------------------------
//	Tab 03

$T['AD']['3']['1']['1']['cont'] = $i18nDoc['c1'];
$T['AD']['3']['1']['2']['cont'] = $i18nDoc['c2'];
$T['AD']['3']['1']['3']['cont'] = $i18nDoc['c3'];
$T['AD']['3']['1']['4']['cont'] = $i18nDoc['c4'];
$T['AD']['3']['1']['5']['cont'] = $i18nDoc['c5'];
$T['AD']['3']['1']['6']['cont'] = $i18nDoc['c6'];
$T['AD']['3']['1']['7']['cont'] = $i18nDoc['c7'];

$tab = array (
	0	=>	"<span class='".$Block."_erreur'>Erreur</span>",
	1	=>	"<span class='".$Block."_ok ".$Block."_t1'>OK</span>",
	2	=>	"<span class='".$Block."_avert'>Avertissement</span>",
	3	=>	"Information",
	4	=>	"Autre",
);

// $tab_signal= array(0 => "ERR", 1 => "OK", 2 => "WARN", 3 => "INFO", 4 => "AUTRE",);
// $signal = $tab[$signal];
// $historique_date = mktime();

$dbquery = $SDDMObj->query("
SELECT *
FROM ".$SqlTableListObj->getSQLTableName('historique')."
WHERE site_id = '".$WebSiteObj->getWebSiteEntry('sw_id')."'
ORDER BY historique_id DESC
LIMIT 0,10
;");


$l = 2;
while ($dbp = $SDDMObj->fetch_array_sql($dbquery)) {
	$historique_action_longeur = strlen($dbp['historique_action']);
	switch (TRUE) {
		case ($historique_action_longeur < 128 && $historique_action_longeur > 64):	$dbp['historique_action'] = substr ($dbp['historique_action'],0,59) . " [...] ";		break;
		case ($historique_action_longeur > 128):									$dbp['historique_action'] = substr ($dbp['historique_action'],0,59) . " [...] " . substr ($dbp['historique_action'],($historique_action_longeur - 64) ,$historique_action_longeur );		break;
	}
	$T['AD']['3'][$l]['1']['cont'] = $dbp['historique_id'];
	$T['AD']['3'][$l]['1']['tc'] = 1;
	$T['AD']['3'][$l]['2']['cont'] = date ( "Y m d H:i:s" , $dbp['historique_date'] );
	$T['AD']['3'][$l]['2']['tc'] = 1;
	$T['AD']['3'][$l]['3']['cont'] = $dbp['historique_initiateur'];
	$T['AD']['3'][$l]['3']['tc'] = 1;
	$T['AD']['3'][$l]['4']['cont'] = $dbp['historique_action'];
	$T['AD']['3'][$l]['4']['tc'] = 1;
	$T['AD']['3'][$l]['5']['cont'] = $tab[$dbp['historique_signal']];
	$T['AD']['3'][$l]['5']['tc'] = 1;
	$T['AD']['3'][$l]['6']['cont'] = $dbp['historique_msgid'];
	$T['AD']['3'][$l]['6']['tc'] = 1;
	$T['AD']['3'][$l]['7']['cont'] = $dbp['historique_contenu'];
	$T['AD']['3'][$l]['7']['tc'] = 1;
	
// 	$tabfc_['tmp'] = $tabfc_['a'] ; $tabfc_['a'] = $tabfc_['c'] ; $tabfc_['c'] = $tabfc_['tmp'] ;
// 	$tabfc_['tmp'] = $tabfc_['b'] ; $tabfc_['b'] = $tabfc_['d'] ; $tabfc_['d'] = $tabfc_['tmp'] ;
	$l++;
}

$T['ADC']['onglet']['3']['nbr_ligne'] = 10;	$T['ADC']['onglet']['3']['nbr_cellule'] = 7;	$T['ADC']['onglet']['3']['legende'] = 1;

// --------------------------------------------------------------------------------------------
//	Tab 04
$T['AD']['4']['1']['1']['cont'] = $i18nDoc['t4_l1'];
$T['ADC']['onglet']['4']['nbr_ligne'] = 1;	$T['ADC']['onglet']['4']['nbr_cellule'] = 1;	$T['ADC']['onglet']['4']['legende'] = 0;


// --------------------------------------------------------------------------------------------
$T['tab_infos']['EnableTabs']		= 1;
$T['tab_infos']['NbrOfTabs']		= 4;
$T['tab_infos']['TabBehavior']		= 1;
$T['tab_infos']['RenderMode']		= 1;
$T['tab_infos']['HighLightType']	= 0;
$T['tab_infos']['Height']			= $RenderLayoutObj->getLayoutModuleEntry($infos['module_nom'], 'dim_y_ex22' ) - $ThemeDataObj->getThemeBlockEntry($infos['blockG'],'tab_y' )-512;
$T['tab_infos']['Width']			= $ThemeDataObj->getThemeDataEntry('theme_module_largeur_interne');
$T['tab_infos']['GroupName']		= "list";
$T['tab_infos']['CellName']			= "dl";
$T['tab_infos']['DocumentName']		= "doc";
$T['tab_infos']['cell_1_txt']		= $i18nDoc['cell_1_txt'];
$T['tab_infos']['cell_2_txt']		= $i18nDoc['cell_2_txt'];
$T['tab_infos']['cell_3_txt']		= $i18nDoc['cell_3_txt'];
$T['tab_infos']['cell_4_txt']		= $i18nDoc['cell_4_txt'];

$config = array(
		"mode" => 1,
		"affiche_module_mode" => "normal",
		"module_z_index" => 2,
		"block" => $infos['block'],
		"blockG" => $infos['block']."G",
		"blockT" => $infos['block']."T",
		"deco_type" => 50,
		"module" => $infos['module'],
);

$Content .= $RenderTablesObj->render($config, $T);

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
