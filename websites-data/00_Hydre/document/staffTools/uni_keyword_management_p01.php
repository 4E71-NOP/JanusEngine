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

$bts->RequestDataObj->setRequestData('test',
		array(
				'test'		=> 1,
		)
);

/*Hydr-Content-Begin*/
$localisation = " / uni_keyword_management_p01";
$bts->MapperObj->AddAnotherLevel($localisation );
$bts->LMObj->logCheckpoint("uni_keyword_management_p01.php");
$bts->MapperObj->RemoveThisLevel($localisation );
$bts->MapperObj->setSqlApplicant("uni_keyword_management_p01.php");

$bts->I18nTransObj->apply(
	array(
		"type" => "array",
		"fra" => array(
			"invite1"		=> "Cette partie va vous permettre de gérer les mots clés.",
			"col_1_txt"		=> "Nom",
			"col_2_txt"		=> "Type",
			"col_3_txt"		=> "Etat",
			"tabTxt1"		=> "Informations",
			"kwState0"		=> "Hors ligne",
			"kwState1"		=> "En ligne",
			"kwType1"		=> "Vers une menu",
			"kwType2"		=> "Vers une URL",
			"kwType3"		=> "Tooltip",
		),
		"eng" => array(
			"invite1"		=> "This part will allow you to manage keywords.",
			"col_1_txt"		=> "Name",
			"col_2_txt"		=> "Type",
			"col_3_txt"		=> "State",
			"tabTxt1"		=> "Informations",
			"kwState0"		=> "Offline",
			"kwState0"		=> "Online",
			"kwType1"		=> "Link to a menu",
			"kwType2"		=> "Link to an URL",
			"kwType3"		=> "Tooltip",
		)
	)
);

$Content .= $bts->I18nTransObj->getI18nTransEntry('invite1')."<br>\r<br>\r";

// --------------------------------------------------------------------------------------------
$Content .="<form ACTION='index.php?' method='post' name='formulaire_module'>\r";

$clause = "";
if ( strlen($bts->RequestDataObj->getRequestDataSubEntry('M_MOTCLE','filtre')) > 0) { $clause = " AND keyword_name like '%".$bts->RequestDataObj->getRequestDataSubEntry('M_MOTCLE','filtre')."%' "; }
$dbquery = $bts->SDDMObj->query("
SELECT *  
FROM ".$SqlTableListObj->getSQLTableName('keyword')." 
WHERE fk_ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."' 
AND keyword_state != '2' 
".$clause." 
;");

if ( $bts->SDDMObj->num_row_sql($dbquery) == 0 ) {
	$i = 1;
	$T['Content']['1'][$i]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('raf1');
	$T['Content']['1'][$i]['2']['cont'] = "";
	$T['Content']['1'][$i]['3']['cont'] = "";
}
else {
	
	$tabState = array(
			0	=> $bts->I18nTransObj->getI18nTransEntry('kwState0'),
			1	=> $bts->I18nTransObj->getI18nTransEntry('kwState1'),
	);
	$tabType = array(
			1	=> $bts->I18nTransObj->getI18nTransEntry('kwType1'),
			2	=> $bts->I18nTransObj->getI18nTransEntry('kwType2'),
			3	=> $bts->I18nTransObj->getI18nTransEntry('kwType3'),
	);
	$i = 1;
	$T['Content']['1'][$i]['1']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_1_txt');
	$T['Content']['1'][$i]['2']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_2_txt');
	$T['Content']['1'][$i]['3']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_3_txt');
	while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) { 
		$i++;
		$T['Content']['1'][$i]['1']['cont']	= "<a href='"
		."index.php?"._HYDRLINKURLTAG_."=1"
		."&arti_slug=".$CurrentSetObj->getDataSubEntry ( 'article', 'arti_slug')
		."&arti_ref=".$CurrentSetObj->getDataSubEntry ( 'article', 'arti_ref')
		."&arti_page=2"
		."&formGenericData[mode]=edit"
		."&formGenericData[selectionId]=".$A1['keyword_id']
		."'>"
		.$dbp['keyword_name']
		."</a>\r";
		$T['Content']['1'][$i]['2']['cont']	= $tabType[$dbp['keyword_type']];
		$T['Content']['1'][$i]['3']['cont']	= $tabState[$dbp['keyword_state']];
	}
}

$T['ContentInfos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, 10 ,1, 0);
$T['ContentCfg']['tabs'] = array(
		1	=>	$bts->RenderTablesObj->getDefaultTableConfig($i,3,1),
);
$Content .= $bts->RenderTablesObj->render($infos, $T);

// --------------------------------------------------------------------------------------------

$Content .= 
$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_sw').
$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_l').
$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_arti_ref').
"<input type='hidden' name='arti_page'	value='2'>\r
<br>\r
<table width='100%' cellpadding='16' cellspacing='0' style='margin-left: auto; margin-right: auto;'>
<tr>\r
<td>\r <input type='text' name='keywordForm[filter]' size='35' maxlength='255' value='".$bts->RequestDataObj->getRequestDataSubEntry('keywordForm','filter')."' class='".$Block."_t3 ".$Block."_form_1'>\r
</td>\r

<td align='right'>\r";
$SB = array(
		"id"				=> "filterButton",
		"type"				=> "submit",
		"initialStyle"		=> $Block."_t3 ".$Block."_submit_s1_n",
		"hoverStyle"		=> $Block."_t3 ".$Block."_submit_s1_h",
		"onclick"			=> "",
		"message"			=> $bts->I18nTransObj->getI18nTransEntry('btnFilter'),
		"mode"				=> 1,
		"size" 				=> 128,
		"lastSize"			=> 0,
);
$Content .= $bts->InteractiveElementsObj->renderSubmitButton($SB);
$Content .= "</form>\r
</td>\r
</tr>\r
</table>\r
";

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('Template');
$TemplateObj = Template::getInstance();
$Content .= $TemplateObj->renderAdminCreateButton($infos);

/*Hydr-Content-End*/

// $LMObj->setInternalLogTarget($LOG_TARGET);

?>
