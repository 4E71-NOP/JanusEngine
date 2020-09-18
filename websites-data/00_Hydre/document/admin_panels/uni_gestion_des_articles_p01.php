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

$logTarget = $LMObj->getInternalLogTarget();
$LMObj->setInternalLogTarget("both");

$RequestDataObj->setRequestData('articleForm',
	array(
		'SQLlang'		=> 48,
		'SQLdeadline'	=> 4,
		'SQLnom'		=> "charg",
		'action'		=> "",
	)
);
// 		'action'		=> "AFFICHAGE",

/*Hydre-contenu_debut*/
$localisation = " / uni_gestion_des_articles_p01";
$MapperObj->AddAnotherLevel($localisation );
$LMObj->logCheckpoint("uni_gestion_des_articles_p01");
$MapperObj->RemoveThisLevel($localisation );
$MapperObj->setSqlApplicant("uni_gestion_des_articles_p01");

switch ($l) {
	case "fra":
		$I18nObj->apply(array(
		"invite1"		=> "Cette partie va vous permettre de modifier les articles.",
		"col_1_txt"		=> "Nom",
		"col_2_txt"		=> "Pages",
		"col_3_txt"		=> "Langage",
		"col_4_txt"		=> "Bouclage",
		"tabTxt1"		=> "Informations",
		"boucl0"		=> "Choisissez un deadline",
		"caption"		=> "Recherche",
		"c1l1"			=> "Nom contient",
		"c1l2"			=> "Langue",
		"c1l3"			=> "Bouclage",
		
		));
		break;
	case "eng":
		$I18nObj->apply(array(
		"invite1"		=> "This part will allow you to modify articles.",
		"col_1_txt"		=> "Name",
		"col_2_txt"		=> "Pages",
		"col_3_txt"		=> "Language",
		"col_4_txt"		=> "Deadline",
		"tabTxt1"		=> "Informations",
		"boucl0"		=> "Choose a deadline",
		"caption"		=> "Search",
		"c1l1"			=> "Name contains",
		"c1l2"			=> "Language",
		"c1l3"			=> "Dead line",
		));
		break;
}

$Content .= $I18nObj->getI18nEntry('invite1')."<br>\r<br>\r";

// --------------------------------------------------------------------------------------------
$langList = $CMObj->getLanguageList();

// --------------------------------------------------------------------------------------------
//	Form
// --------------------------------------------------------------------------------------------

if ( strlen($RequestDataObj->getRequestDataEntry('SQLlang')) > 0 ) { $langList[$RequestDataObj->getRequestDataEntry('SQLlang')]['s'] = "selected"; }
else { $langList[$CurrentSetObj->getDataEntry('language_id')]['s'] = "selected"; }

$listDeadline = array(
		0 => array(
				'id' => 0,
				'deadline_title' => $I18nObj->getI18nEntry('boucl0'),
		),
);

$dbquery = $SDDMObj->query("
SELECT deadline_id,deadline_name,deadline_title,deadline_state FROM ".$SqlTableListObj->getSQLTableName('deadline')."
WHERE ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."'
;");
while ($dbp = $SDDMObj->fetch_array_sql($dbquery)) {
	$A = $dbp['deadline_id'];
	$listDeadline[$A]['id'] = $A;
	$listDeadline[$A]['deadline_name']		= $dbp['deadline_name'];
	$listDeadline[$A]['deadline_title']		= $dbp['deadline_title'];
	$listDeadline[$A]['deadline_state']		= $dbp['deadline_state'];
}
unset ( $A );
foreach ( $listDeadline as $A ) {
	if ( $A['deadline_state'] == 0 ) { $A['deadline_title'] = "<span class='".$Block."_err'>" . $A['deadline_title']; }
	else { $A['deadline_title'] = "<span class='".$Block."_ok'>" . $A['deadline_title']; }
	$A['deadline_title'] = $A['deadline_name'] . "</span>";
}
if ( strlen($RequestDataObj->getRequestDataEntry('SQLdeadline')) > 0 ) { $listDeadline[$RequestDataObj->getRequestDataEntry('SQLdeadline')]['s'] = "selected"; }

// --------------------------------------------------------------------------------------------
$Content .= "
<form id='MH_001' ACTION='index.php?' method='post'>\r"
.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_sw')
.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_l')
.$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_arti_ref')
."<input type='hidden' name='formGenericData[mode]'	value='create'>"
."<input type='hidden' name='arti_page'	value='2'>\r"
."<table ".$ThemeDataObj->getThemeDataEntry('tab_std_rules')." width='".$ThemeDataObj->getThemeDataEntry('theme_module_largeur_interne')."px'>\r
<tr>\r
<td class='" . $Block."_fcta' colspan='2'>".$I18nObj->getI18nEntry('caption')."</td>\r
</tr>\r
		
<tr>\r
<td class='" . $Block."_fca'>".$I18nObj->getI18nEntry('c1l1')."</td>\r
<td class='" . $Block."_fca'><input type='text' name='articleForm[SQLnom]' size='15' value='".$RequestDataObj->getRequestDataEntry('SQLnom')."' class='".$Block."_t3 " . $Block."_form_1'></td>\r
</tr>\r
		
<tr>\r
<td class='" . $Block."_fca'>".$I18nObj->getI18nEntry('c1l2')."</td>\r
<td class='" . $Block."_fca'><select name='articleForm[SQLlang]' class='".$Block."_t3 " . $Block."_form_1'>
";
// unset ( $A , $B );
foreach ( $langList as $k => $v ) {
	if ( !is_numeric($k) ) {
		if ( $v['support'] == 1 ) { $Content .= "<option value='".$v['lang_639_3']."' ".$v['s']."> ".$v['lang_original_name']." </option>\r"; }
	}
}
$Content .= "</select>
</td>\r
</tr>\r
		
<tr>\r
<td class='" . $Block."_fca'>".$I18nObj->getI18nEntry('c1l3')."</td>\r
<td class='" . $Block."_fca'><select name='articleForm[SQLdeadline]' class='".$Block."_t3 " . $Block."_form_1'>
";
unset ( $A , $B );
foreach ( $listDeadline as $A ) {
	$Content .= "<option value='".$A['id']."' ".$A['selected'].">".$A['deadline_title']."/".$A['deadline_name']."</option>\r";
}
$Content .= "</select></tr>\r
</table>\r

<table width='100%' cellpadding='16' cellspacing='0' style='margin-left: auto; margin-right: auto; padding:8px'>
<tr>\r
<td align='right'>\r
";

$SB = array(
		"id"				=> "refreshButton",
		"type"				=> "submit",
		"initialStyle"		=> $Block."_t3 ".$Block."_submit_s2_n",
		"hoverStyle"		=> $Block."_t3 ".$Block."_submit_s2_h",
		"onclick"			=> "",
		"message"			=> $I18nObj->getI18nEntry('btnRefresh'),
		"mode"				=> 1,
		"size" 				=> 128,
		"lastSize"			=> 0,
);
$Content .= $InteractiveElementsObj->renderSubmitButton($SB);
$Content .= "
</td>\r
</tr>\r
</table>\r
</form>\r
";
// --------------------------------------------------------------------------------------------

$articleFormData = $RequestDataObj->getRequestDataEntry('articleForm');
$sqlClause = "";

if ( $articleFormData['action'] == "AFFICHAGE" ) {
	if ( strlen($articleFormData['SQLnom']) > 0 ) { $sqlClause .= " AND art.arti_nom LIKE '%".$articleFormData['SQLnom']."%'"; }
	if ( $articleFormData['SQLlang'] != 0 ) { $sqlClause .= " AND cat.cate_lang = '".$articleFormData['SQLlang']."'"; }
	if ( $articleFormData['SQLdeadline'] != 0 ) { $sqlClause .= " AND bcl.deadline_id = '".$articleFormData['SQLdeadline']."'"; }
}


$dbquery = $SDDMObj->query("
SELECT art.arti_ref, art.arti_id, art.arti_nom, art.arti_titre, art.arti_page , cat.cate_lang, bcl.deadline_name, bcl.deadline_title, bcl.deadline_state
FROM ".$SqlTableListObj->getSQLTableName('article')." art, ".$SqlTableListObj->getSQLTableName('categorie')." cat, ".$SqlTableListObj->getSQLTableName('deadline')." bcl
WHERE art.arti_ref = cat.arti_ref
AND art.arti_deadline = bcl.deadline_id

AND art.ws_id = bcl.ws_id
AND bcl.ws_id = cat.ws_id
AND cat.ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."'

AND cat.cate_etat != '2'
AND cat.cate_type IN ('1','0')

".$sqlClause."
ORDER BY art.arti_ref,art.arti_page
;");
$T = array();
$articleList = array();
if ( $SDDMObj->num_row_sql($dbquery) != 0 ) {
	while ($dbp = $SDDMObj->fetch_array_sql($dbquery)) {
		$p = &$articleList[$dbp['arti_ref']][$dbp['arti_id']];
		$p['arti_ref']			= $dbp['arti_ref'];
		$p['arti_id']			= $dbp['arti_id'];
		$p['arti_nom']			= $dbp['arti_nom'];
		$p['arti_titre']		= $dbp['arti_titre'];
		$p['arti_page']			= $dbp['arti_page'];
		$p['arti_lang']			= $dbp['cate_lang'];
		$p['deadline_state']		= $dbp['deadline_state'];
		$p['deadline_title']	= $dbp['deadline_title'];
	}
	
	$colorState = array(
		"0" => "<span class='".$Block."_avert'>",
		"1" => "<span class='".$Block."_ok'>",
		"2" => "<span class='".$Block."_erreur'>",
	);
	
	unset ($A,$B);
	$i = 1;
	$T['AD']['1'][$i]['1']['cont']	= $I18nObj->getI18nEntry('col_1_txt');
	$T['AD']['1'][$i]['2']['cont']	= $I18nObj->getI18nEntry('col_2_txt');
	$T['AD']['1'][$i]['3']['cont']	= $I18nObj->getI18nEntry('col_3_txt');
	$T['AD']['1'][$i]['4']['cont']	= $I18nObj->getI18nEntry('col_4_txt');
	
	$linkId1 = "<a class='".$Block."_lien' href='index.php?"
			."sw=".$WebSiteObj->getWebSiteEntry('ws_id')
			."&l=".$CurrentSetObj->getDataEntry('language')
			."&arti_ref=".$CurrentSetObj->getDataSubEntry('article','arti_ref')
			."&arti_page=2"
			."&formGenericData[mode]=edit"
			."&articleForm[selectionRef]="
			;
	$linkId2 = "&articleForm[selectionPage]=";
	$tranlation = $CMObj->getLanguageListSubEntry($l, 'id');
	$tranlation = $CMObj->getLanguageListSubEntry($tranlation, 'lang_original_name');
	
	foreach ( $articleList as &$A ) {
		$i++;
		$articlePageLink = "";
		unset ($B);
		foreach ( $A as $B ) {
			$T['AD']['1'][$i]['1']['cont'] = $B['arti_ref'];
			$articlePageLink .= $linkId1.$B['arti_ref'].$linkId2.$B['arti_page']."'>".$B['arti_page']."</a>";
			$articlePageLink .= " - ";
			$T['AD']['1'][$i]['3']['cont'] = $langList[$B['arti_lang']]['txt'];
			$T['AD']['1'][$i]['3']['tc'] = 1;
			$T['AD']['1'][$i]['4']['cont'] = $colorState[$B['deadline_state']] . $B['deadline_title'] . "</span>";
			$T['AD']['1'][$i]['4']['tc'] = 1;
		}
		$articlePageLink = substr ( $articlePageLink , 0 , -3 );
		$T['AD']['1'][$i]['2']['cont'] = $articlePageLink;
	}
}
// --------------------------------------------------------------------------------------------
//
//	Display
//
//
// --------------------------------------------------------------------------------------------
$T['tab_infos'] = $RenderTablesObj->getDefaultDocumentConfig($infos, 15);
$T['ADC']['onglet'] = array(
		1	=>	$RenderTablesObj->getDefaultTableConfig($i,4,1),
);
$Content .= $RenderTablesObj->render($infos, $T);

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('Template');
$TemplateObj = Template::getInstance();
$Content .= $TemplateObj->renderAdminCreateButton($infos);

/*Hydre-contenu_fin*/

$LMObj->setInternalLogTarget($logTarget);

?>
