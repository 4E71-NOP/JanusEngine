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

$RequestDataObj->setRequestData('formGenericData',
		array(
				'origin'			=> 'AdminDashboard',
				'section'			=> 'WebsiteManagementP01',
				'creation'		=> 'on',
				'modification'	=> 'on',
				'deletion'		=> 'on',
				'mode'			=> 'edit',
//				'mode'			=> 'create',
//				'mode'			=> 'delete',
		)
);


/*Hydre-contenu_debut*/
$localisation = " / uni_gestion_du_site_p01";
$MapperObj->AddAnotherLevel($localisation );
$LMObj->logCheckpoint("uni_gestion_du_site_p01");
$MapperObj->RemoveThisLevel($localisation );
$MapperObj->setSqlApplicant("uni_gestion_du_site_p01");

switch ($l) {
	case "fra":
		$I18nObj->apply(array(
		"invite1"		=> "Cette partie va vous permettre de gérer le site.",
		"msg01"			=> "Le site est actuellement : ",
		"tabTxt1"		=> "Présentation",
		"tabTxt2"		=> "Configuration",
		"tabTxt3"		=> "Langues",
		"tabTxt4"		=> "Etat du site",
		"tabTxt5"		=> "Divers",
		"col_1_txt"		=> "Nom",
		"col_2_txt"		=> "Etat",
		"col_3_txt"		=> "Date",
		
		"select_t1_01_1_0"		=> "Hors ligne",
		"select_t1_01_1_1"		=> "En ligne",
		"select_t1_01_1_2"		=> "Supprimé",
		"select_t1_01_1_3"		=> "Maintenance",
		"select_t1_01_1_1000"	=> "Vérrouillé",
		
		"select_t2_04_1"	=> "Synthèse basique",
		"select_t2_04_2"	=> "Graphique",
		"select_t2_04_3"	=> "Statistique",
		"select_t2_04_4"	=> "Logs",
		"select_t2_04_5"	=> "N/A",
		"select_t2_04_6"	=> "N/A",
		"select_t2_04_7"	=> "Requête",
		"select_t2_04_8"	=> "Commandes",
		"select_t2_04_9"	=> "Internes",
		"select_t2_04_10"	=> "Variables",
	
		"select_t2_05_0"	=> "Statique",
		"select_t2_05_1"	=> "Dynamique",
		
		"updateDone1"		=> "You have modified the site state.<br>\r<br>\rUse this URL to get back on this page:<br>\r",
		"updateDone2"		=> "Return to the site administration page",
		"updateDone3"		=> "Use this link and make it a bookmark.",
		"validation"		=> "Je valide les changements du site.",
		
		't1_l1'				=> "Nom",
		't1_l2'				=> "Nom abrégé",
		't1_l3'				=> "Titre de fenêtre",
		't1_l4'				=> "Barre de status",
		't1_l5'				=> "URL home",
		
		"t2_l1"				=> "Langue par defaut",
		"t2_l2"				=> "Choix du language pour l'utilisateur",
		"t2_l3"				=> "theme par defaut",
		"t2_l4"				=> "Niveau de debug",
		"t2_l5"				=> "Stylesheet",
		
		't3_l1'				=> "Modifer le support des langues.",
		
		"t4_l1"				=> "Etat",
		
		"t5_l1"				=> "Insertion dans les logs du contenu modifié d'un article.",
		));
		break;
		
	case "eng":
		$I18nObj->apply(array(
		"invite1"		=> "This part will allow you to manage the website.",
		"msg01"			=> "The site is actually : ",
		"tabTxt1"		=> "Display",
		"tabTxt2"		=> "Configuration",
		"tabTxt3"		=> "Language",
		"tabTxt4"		=> "Site state",
		"tabTxt5"		=> "Misc",
		"col_1_txt"		=> "Name",
		"col_2_txt"		=> "Status",
		"col_3_txt"		=> "Date",
		
		"select_t1_01_1_0"		=> "Offline",
		"select_t1_01_1_1"		=> "Online",
		"select_t1_01_1_2"		=> "Deleted",
		"select_t1_01_1_3"		=> "Maintenance",
		"select_t1_01_1_1000"	=> "Locked",
		
		"select_t2_04_1"	=> "Basic report",
		"select_t2_04_2"	=> "Graph",
		"select_t2_04_3"	=> "Stats",
		"select_t2_04_4"	=> "Logs",
		"select_t2_04_5"	=> "N/A",
		"select_t2_04_6"	=> "N/A",
		"select_t2_04_7"	=> "Queries",
		"select_t2_04_8"	=> "Commands",
		"select_t2_04_9"	=> "Internal",
		"select_t2_04_10"	=> "Variables",

		"select_t2_05_0"	=> "Static",
		"select_t2_05_1"	=> "Dynamic",

		"updateDone1"		=> "Vous avez modifi&eacute; l'&eacute;tat du site.<br>\r<br>\rPour revenir a cette partie du site utilisez l'URL suivante:<br>\r",
		"updateDone2"		=> "Revenir a l'administration du site",
		"updateDone3"		=> "Utilisez le lien pour en faire un signet.",
		"validation"		=> "I confirm the website modification.",
		
		't1_l1'				=> "Name",
		't1_l2'				=> "Short name",
		't1_l3'				=> "Window title",
		't1_l4'				=> "Status bar",
		't1_l5'				=> "Homepage URL",
		
		"t2_l1"				=> "Default laguage",
		"t2_l2"				=> "User can choose language",
		"t2_l3"				=> "Default theme",
		"t2_l4"				=> "Debug level",
		"t2_l5"				=> "Stylesheet",
		
		't3_l1'				=> "Modify language support.",
		
		"t4_l1"				=> "State",
		
		"t5_l1"				=> "Insert modified content in the log entries.",
		));
		break;
}

// --------------------------------------------------------------------------------------------

$dbquery = $SDDMObj->query("
SELECT ws_state, ws_lang 
FROM ".$SqlTableListObj->getSQLTableName('website')." 
WHERE ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."'
;");
while ($dbp = $SDDMObj->fetch_array_sql($dbquery)) {
	$pv['ws_state2']		= "select_o1_1_" . $dbp['ws_state'];
	$pv['ws_state']		= $dbp['ws_state'];
	$Content .= "<p>".$I18nObj->getI18nEntry('msg_01').$I18nObj->getI18nEntry($pv['ws_state2'])."<br>\r<br>\r</p>\r";
	$WebSiteObj->setWebSiteEntry('sw_default_lang', $dbp['ws_lang']);
}

// --------------------------------------------------------------------------------------------
$Content .= $AdminFormToolObj->checkAdminDashboardForm($infos);

// --------------------------------------------------------------------------------------------
$Content .= $I18nObj->getI18nEntry('invite1')."<br>\r<br>\r";

// if ( $RequestDataObj->getRequestDataSubEntry('formGenericData', 'origin') == 'AdminDashboard' && $RequestDataObj->getRequestDataSubEntry('formGenericData', 'modification') != 'on' ) {
// 	$LMObj->InternalLog('AdminDashboard modification checkbox forgotten');
// 	$Content .= "<p class='".$Block."_erreur ".$Block."_tb3'>".$I18nObj->getI18nEntry('userForgotConfirmation')."</p>\r";
// }

// --------------------------------------------------------------------------------------------

$Content .= "
<form ACTION='index.php?' method='post'>\r"
.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_sw')
.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_l')
.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_arti_ref')
.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_arti_page')
."<input type='hidden' name='formGenericData[origin]'	value='AdminDashboard".$processStep."'>\r"
."<input type='hidden' name='formGenericData[section]'		value='WebsiteManagementP01'>"
."<input type='hidden' name='formCommand1'					value='update'>"
."<input type='hidden' name='formEntity1'					value='website'>"
."<input type='hidden' name='formTarget1[name]'				value='".$WebSiteObj->getWebSiteEntry('ws_name')."'>"
."<input type='hidden' name='formGenericData[mode]'		value='".$processTarget."'>\r"
."<p>\r"
;

$mws_state = array(
	0		=> array( 't'=> $I18nObj->getI18nEntry('select_t1_01_1_0'),		'db' => "OFFLINE",		'v' => 0),
	1		=> array( 't'=> $I18nObj->getI18nEntry('select_t1_01_1_1'),		'db' => "ONLINE",		'v' => 1),
	2		=> array( 't'=> $I18nObj->getI18nEntry('select_t1_01_1_2'),		'db' => "SUPPRIME",		'v' => 2),
	3		=> array( 't'=> $I18nObj->getI18nEntry('select_t1_01_1_3'),		'db' => "MAINTENANCE",	'v' => 3),
	1000	=> array( 't'=> $I18nObj->getI18nEntry('select_t1_01_1_1000'),	'db' => "LOCKED",		'v' => 1000),
);

$Tab = 0;
$T = array();

// --------------------------------------------------------------------------------------------

$langList		= $CMObj->getLanguageList();
$ws_lang_select	= array();

// $dbquery = $SDDMObj->query("
// SELECT sl.lang_id
// FROM ".$SqlTableListObj->getSQLTableName('site_langue')." sl , ".$SqlTableListObj->getSQLTableName('website')." s
// WHERE s.ws_id ='".$WebSiteObj->getWebSiteEntry('ws_id')."'
// AND sl.ws_id = s.ws_id
// ;");
// while ($dbp = $SDDMObj->fetch_array_sql($dbquery)) { $langList[$dbp['lang_id']]['support'] = 1; }
// $LMObj->logDebug($langList, "langList");

// --------------------------------------------------------------------------------------------
// Tab 01
$Tab++;

$T['AD'][$Tab]['1']['1']['cont'] = $I18nObj->getI18nEntry('t1_l1');
$T['AD'][$Tab]['2']['1']['cont'] = $I18nObj->getI18nEntry('t1_l2');
$T['AD'][$Tab]['3']['1']['cont'] = $I18nObj->getI18nEntry('t1_l3');
$T['AD'][$Tab]['4']['1']['cont'] = $I18nObj->getI18nEntry('t1_l4');
$T['AD'][$Tab]['5']['1']['cont'] = $I18nObj->getI18nEntry('t1_l5');

// $T['AD'][$Tab]['1']['2']['cont'] = "<input type='text' name='formParams1[name]'			size='20' maxlength='255' value='".$WebSiteObj->getWebSiteEntry('ws_name')."'			class='" . $Block."_t3 " . $Block."_form_1'>\r";
$T['AD'][$Tab]['1']['2']['cont'] = $WebSiteObj->getWebSiteEntry('ws_name');
$T['AD'][$Tab]['2']['2']['cont'] = "<input type='text' name='formParams1[abrege]'		size='20' maxlength='255' value='".$WebSiteObj->getWebSiteEntry('ws_short')."'			class='" . $Block."_t3 " . $Block."_form_1'>\r";
$T['AD'][$Tab]['3']['2']['cont'] = "<input type='text' name='formParams1[title]'		size='20' maxlength='255' value='".$WebSiteObj->getWebSiteEntry('ws_title')."'			class='" . $Block."_t3 " . $Block."_form_1'>\r";
$T['AD'][$Tab]['4']['2']['cont'] = "<input type='text' name='formParams1[barre_status]'	size='20' maxlength='255' value='".$WebSiteObj->getWebSiteEntry('sw_barre_status')."'	class='" . $Block."_t3 " . $Block."_form_1'>\r";
$T['AD'][$Tab]['5']['2']['cont'] = "<input type='text' name='formParams1[home]'			size='20' maxlength='255' value='".$WebSiteObj->getWebSiteEntry('ws_home')."'			class='" . $Block."_t3 " . $Block."_form_1'>\r";


// --------------------------------------------------------------------------------------------
// Tab 02
$Tab++;

$T['AD'][$Tab]['1']['1']['cont'] = $I18nObj->getI18nEntry('t2_l1');
$T['AD'][$Tab]['2']['1']['cont'] = $I18nObj->getI18nEntry('t2_l2');
$T['AD'][$Tab]['3']['1']['cont'] = $I18nObj->getI18nEntry('t2_l3');
$T['AD'][$Tab]['4']['1']['cont'] = $I18nObj->getI18nEntry('t2_l4');
$T['AD'][$Tab]['5']['1']['cont'] = $I18nObj->getI18nEntry('t2_l5');

$T['AD'][$Tab]['1']['2']['cont'] = "<select name='formParams1[lang]' class='".$Block."_t3 ".$Block."_form_1'>\r";
$langList[$WebSiteObj->getWebSiteEntry('ws_lang')]['s'] = " selected ";

foreach ( $langList as $k => $v ) {
	if ( !is_numeric($k) ) {
		if ( $v['support'] == 1 ) { $T['AD'][$Tab]['1']['2']['cont'] .= "<option value='".$v['langue_639_3']."' ".$v['s']."> ".$v['langue_nom_original']." </option>\r"; }
	}
}
$T['AD'][$Tab]['1']['2']['cont'] .= "</select>\r";



$T['AD'][$Tab]['2']['2']['cont'] = "<select name='formParams1[lang_select]' class='" . $Block."_t3 " . $Block."_form_1'>\r";
$ws_lang_select['0']['t'] = $I18nObj->getI18nEntry('no');		$ws_lang_select['0']['s'] = "";		$ws_lang_select['0']['cmd'] = "NO";
$ws_lang_select['1']['t'] = $I18nObj->getI18nEntry('yes');	$ws_lang_select['1']['s'] = "";		$ws_lang_select['1']['cmd'] = "YES";
$ws_lang_select[$WebSiteObj->getWebSiteEntry('ws_lang_select')]['s'] = " selected ";
foreach ( $ws_lang_select as $A ) { $T['AD'][$Tab]['2']['2']['cont'] .= "<option value='".$A['cmd']."' ".$A['s']."> ".$A['t']."</option>\r"; }
$T['AD'][$Tab]['2']['2']['cont'] .= "</select>\r";

$T['AD'][$Tab]['3']['2']['cont'] = "<select name='formParams1[theme]' class='" . $Block."_t3 " . $Block."_form_1'>\r";
$dbquery = $SDDMObj->query("
SELECT a.theme_id,a.theme_nom,a.theme_titre
FROM ".$SqlTableListObj->getSQLTableName('theme_descripteur')." a, ".$SqlTableListObj->getSQLTableName('site_theme')." b
WHERE b.ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."'
AND a.theme_id  = b.theme_id;
;");
while ($dbp = $SDDMObj->fetch_array_sql($dbquery)) {
	if ( $WebSiteObj->getWebSiteEntry('theme_id') == $dbp['theme_id'] ) { $T['AD'][$Tab]['3']['2']['cont'] .= "<option value='".$dbp['theme_nom']."' selected>".$dbp['theme_titre']."</option>\r"; }
	else { $T['AD'][$Tab]['3']['2']['cont'] .= "<option value='".$dbp['theme_nom']."'>".$dbp['theme_titre']."</option>\r"; }
}
$T['AD'][$Tab]['3']['2']['cont'] .= "</select>\r";



$T['AD'][$Tab]['4']['2']['cont'] = "<select name='formParams1[info_debug]' class='" . $Block."_t3 " . $Block."_form_1'>\r";
$sw_niv_debug = array(
		1	=>	array("t" => $I18nObj->getI18nEntry('select_t2_04_1'),		"s" => "",		"cmd" => "1"),
		2	=>	array("t" => $I18nObj->getI18nEntry('select_t2_04_2'),		"s" => "",		"cmd" => "2"),
		3	=>	array("t" => $I18nObj->getI18nEntry('select_t2_04_3'),		"s" => "",		"cmd" => "3"),
		4	=>	array("t" => $I18nObj->getI18nEntry('select_t2_04_4'),		"s" => "",		"cmd" => "4"),
		5	=>	array("t" => $I18nObj->getI18nEntry('select_t2_04_5'),		"s" => "",		"cmd" => "5"),
		6	=>	array("t" => $I18nObj->getI18nEntry('select_t2_04_6'),		"s" => "",		"cmd" => "6"),
		7	=>	array("t" => $I18nObj->getI18nEntry('select_t2_04_7'),		"s" => "",		"cmd" => "7"),
		8	=>	array("t" => $I18nObj->getI18nEntry('select_t2_04_8'),		"s" => "",		"cmd" => "8"),
		9	=>	array("t" => $I18nObj->getI18nEntry('select_t2_04_9'),		"s" => "",		"cmd" => "9"),
		10	=>	array("t" => $I18nObj->getI18nEntry('select_t2_04_10'),		"s" => "",		"cmd" => "10"),
);
$sw_niv_debug[$WebSiteObj->getWebSiteEntry('ws_info_debug')]['s'] = " selected ";
foreach ( $sw_niv_debug as $A ) { $T['AD'][$Tab]['4']['2']['cont'] .= "<option value='".$A['cmd']."' ".$A['s'].">".$A['t']."</option>\r"; }
$T['AD'][$Tab]['4']['2']['cont'] .= "</select>\r";
$T['AD'][$Tab]['5']['2']['cont'] = "<select name='formParams1[stylesheet]' class='" . $Block."_t3 " . $Block."_form_1'>\r";



$sw_CSS = Array(
		0	=>	array("t" => $I18nObj->getI18nEntry('select_t2_05_0'),		"s" => "",		"cmd" => "STATIC"),
		1	=>	array("t" => $I18nObj->getI18nEntry('select_t2_05_1'),		"s" => "",		"cmd" => "DYNAMIC"),
		);
$sw_CSS[$WebSiteObj->getWebSiteEntry('ws_stylesheet')]['s'] = " selected ";
foreach ( $sw_CSS as $A ) { $T['AD'][$Tab]['5']['2']['cont'] .= "<option value='".$A['cmd']."' ".$A['s'].">".$A['t']."</option>\r"; }
$T['AD'][$Tab]['5']['2']['cont'] .= "</select>\r";

// --------------------------------------------------------------------------------------------
// Tab 03
$Tab++;
reset ($langList);
$i = 1;
$j = 1;
$T['AD'][$Tab]['1']['8']['cont'] = $I18nObj->getI18nEntry('t3_l1')."
<input type='hidden' name='formCommand2'			value='assign'>\r
<input type='hidden' name='formEntity2'				value='language'>\r
<input type='hidden' name='formParams2'				value='to_website'>\r
";
$T['AD'][$Tab][$i][$j]['colspan'] = 8;
$T['AD'][$Tab][$i][$j]['cont'] = "";
$T['AD'][$Tab][$i][$j]['cont'] = "";
$T['AD'][$Tab][$i][$j]['cont'] = "";
$T['AD'][$Tab][$i][$j]['cont'] = "";
$T['AD'][$Tab][$i][$j]['cont'] = "";
$T['AD'][$Tab][$i][$j]['cont'] = "";
$T['AD'][$Tab][$i][$j]['cont'] = "";

$i++;
// <input type='hidden' name='formTarget2'				value=''>\r
$dbquery = $SDDMObj->query("SELECT * FROM ".$SqlTableListObj->getSQLTableName('langues').";");
while ($dbp = $SDDMObj->fetch_array_sql($dbquery)) {
	$B = "";
	if ( $langList[$dbp['langue_id']]['support'] == 1 ) { $B = " checked"; }
	$T['AD'][$Tab][$i][$j]['cont'] = "<input type='checkbox' name='formTarget2[".$dbp['langue_639_3']."]' ".$B.">\r";		$j++;
	$T['AD'][$Tab][$i][$j]['cont'] = $dbp['langue_nom_original'];																		$j++;
	if ( $j == 9 ) { $j = 1; $i++; }
}
$tab3NbrLine = $i;

// --------------------------------------------------------------------------------------------
// Tab 04
$Tab++;

$mws_state[$pv['ws_state']]['s'] = " selected ";

$T['AD'][$Tab]['1']['1']['cont'] = $I18nObj->getI18nEntry('t'.$Tab.'_l1');
$T['AD'][$Tab]['1']['2']['cont'] = "<select name='formParams1[state]' class='" . $Block."_t3 " . $Block."_form_1'>\r";
foreach ( $mws_state as $A ) { $T['AD'][$Tab]['1']['2']['cont'] .= "<option value='".$A['db']."' ".$A['s'].">".$A['t']."</option>\r"; }
$T['AD'][$Tab]['1']['2']['cont'] .= "</select>\r";

// --------------------------------------------------------------------------------------------
// Tab 05
$Tab++;

$T['AD'][$Tab]['1']['1']['cont'] = $I18nObj->getI18nEntry('t5_l1');
$T['AD'][$Tab]['1']['2']['cont'] = "<select name='formParams1[ma_diff]' class='" . $Block."_t3 " . $Block."_form_1'>\r";
$ws_ma_diff = array(
	0	=> array('t' => $I18nObj->getI18nEntry('no'),		's' => "",		'cmd' => "NO"),
	1	=> array('t' => $I18nObj->getI18nEntry('yes'),	's' => "",		'cmd' => "YES"),
);
$ws_ma_diff[$WebSiteObj->getWebSiteEntry('ws_ma_diff')]['s'] = " selected ";
foreach ( $ws_ma_diff as $A ) { $T['AD'][$Tab]['1']['2']['cont'] .= "<option value='".$A['cmd']."' ".$A['s'].">".$A['t']."</option>\r"; }
$T['AD'][$Tab]['1']['2']['cont'] .= "</select>";

// --------------------------------------------------------------------------------------------
//
//	Display
//
//
// --------------------------------------------------------------------------------------------
$T['tab_infos'] = $RenderTablesObj->getDefaultDocumentConfig($infos, 10, 5);
$T['ADC']['onglet'] = array(
		1	=>	$RenderTablesObj->getDefaultTableConfig(5,2,2),
		2	=>	$RenderTablesObj->getDefaultTableConfig(5,2,2),
		3	=>	$RenderTablesObj->getDefaultTableConfig($tab3NbrLine,8,1),
		4	=>	$RenderTablesObj->getDefaultTableConfig(1,2,2),
		5	=>	$RenderTablesObj->getDefaultTableConfig(1,2,2),
);
$Content .= $RenderTablesObj->render($infos, $T);


// --------------------------------------------------------------------------------------------
/*
<input type='hidden' name='UPDATE_action'				value='UPDATE_WEBSITE'>\r
<input type='hidden' name='UPDATE_action_complement'	value='COMPLETE_UPDATE'>\r
<input type='hidden' name='FormWebSite[action]'			value='2'>\r
<input type='hidden' name='FormWebSite[repertoire]'		value='".$WebSiteObj->getWebSiteEntry('ws_directory')."'>\r
<input type='hidden' name='FormWebSite[banner_bypass]'	value='1'>\r

*/
$Content .= "
<input type='hidden' name='site_context[ws_id]'		value='".$WebSiteObj->getWebSiteEntry('ws_id')."'>
<input type='hidden' name='site_context[site_nom]'		value='".$WebSiteObj->getWebSiteEntry('ws_name')."'>

<table cellpadding='8' cellspacing='0' style='width :". ($ThemeDataObj->getThemeDataEntry('theme_module_largeur_interne') - 16) ."px;'>
<tr>\r
<td>\r
<input type='checkbox' name='formGenericData[modification]'>".$I18nObj->getI18nEntry('validation')."\r
</td>\r
<td align='right'>\r
";

$SB = array(
		"id"				=> "updateButton",
		"type"				=> "submit",
		"initialStyle"		=> $Block."_t3 ".$Block."_submit_s3_n",
		"hoverStyle"		=> $Block."_t3 ".$Block."_submit_s3_h",
		"onclick"			=> "",
		"message"			=> $I18nObj->getI18nEntry('btnUpdate'),
		"mode"				=> 1,
		"size" 				=> 128,
		"lastSize"			=> 0,
);
$Content .= $InteractiveElementsObj->renderSubmitButton($SB);

$Content .= "
</table>\r
</form>\r
";

/*Hydre-contenu_fin*/

$LMObj->setInternalLogTarget($logTarget);

?>
