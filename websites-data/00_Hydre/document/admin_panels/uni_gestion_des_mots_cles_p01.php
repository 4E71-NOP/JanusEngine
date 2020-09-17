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

$RequestDataObj->setRequestData('test',
		array(
				'test'		=> 1,
		)
);

/*Hydre-contenu_debut*/
$localisation = " / uni_gestion_des_mot_cle_p01";
$MapperObj->AddAnotherLevel($localisation );
$LMObj->logCheckpoint("uni_gestion_des_mot_cle_p01");
$MapperObj->RemoveThisLevel($localisation );
$MapperObj->setSqlApplicant("uni_gestion_des_mot_cle_p01");

switch ($l) {
	case "fra":
		$I18nObj->apply(array(
		"invite1"		=> "Cette partie va vous permettre de gérer les mots clés.",
		"col_1_txt"		=> "Nom",
		"col_2_txt"		=> "Type",
		"col_3_txt"		=> "Etat",
		"tabTxt1"		=> "Informations",
		"kwState0"		=> "Hors ligne",
		"kwState1"		=> "En ligne",
		"kwType1"		=> "Vers une category",
		"kwType2"		=> "Vers une URL",
		"kwType3"		=> "Tooltip",
		));
		break;
	case "eng":
		$I18nObj->apply(array(
		"invite1"		=> "This part will allow you to manage keywords.",
		"col_1_txt"		=> "Name",
		"col_2_txt"		=> "Type",
		"col_3_txt"		=> "State",
		"tabTxt1"		=> "Informations",
		"kwState0"		=> "Offline",
		"kwState0"		=> "Online",
		"kwType1"		=> "Link to a category",
		"kwType2"		=> "Link to an URL",
		"kwType3"		=> "Tooltip",
		));
		break;
}

$Content .= $I18nObj->getI18nEntry('invite1')."<br>\r<br>\r";

// --------------------------------------------------------------------------------------------
$Content .="<form ACTION='index.php?' method='post' name='formulaire_module'>\r";

$clause = "";
if ( strlen($RequestDataObj->getRequestDataSubEntry('M_MOTCLE','filtre')) > 0) { $clause = " AND mc_nom like '%".$RequestDataObj->getRequestDataSubEntry('M_MOTCLE','filtre')."%' "; }
$dbquery = $SDDMObj->query("
SELECT *  
FROM ".$SqlTableListObj->getSQLTableName('mot_cle')." 
WHERE site_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."' 
AND mc_etat != '2' 
".$clause." 
;");

if ( $SDDMObj->num_row_sql($dbquery) == 0 ) {
	$i = 1;
	$T['AD']['1'][$i]['1']['cont'] = $I18nObj->getI18nEntry('raf1');
	$T['AD']['1'][$i]['2']['cont'] = "";
	$T['AD']['1'][$i]['3']['cont'] = "";
}
else {
	
	$tabState = array(
			0	=> $I18nObj->getI18nEntry('kwState0'),
			1	=> $I18nObj->getI18nEntry('kwState1'),
	);
	$tabType = array(
			1	=> $I18nObj->getI18nEntry('kwType1'),
			2	=> $I18nObj->getI18nEntry('kwType2'),
			3	=> $I18nObj->getI18nEntry('kwType3'),
	);
	$i = 1;
	$T['AD']['1'][$i]['1']['cont']	= $I18nObj->getI18nEntry('col_1_txt');
	$T['AD']['1'][$i]['2']['cont']	= $I18nObj->getI18nEntry('col_2_txt');
	$T['AD']['1'][$i]['3']['cont']	= $I18nObj->getI18nEntry('col_3_txt');
	while ($dbp = $SDDMObj->fetch_array_sql($dbquery)) { 
		$i++;
		$T['AD']['1'][$i]['1']['cont']	= "<a class='".$Block."_lien' href='index.php?
		&amp;M_MOTCLE[mot_cle_selection]=".$dbp['mc_id'].
		"&amp;M_MOTCLE[uni_gestion_des_motcle_p]=2".
		$CurrentSetObj->getDataSubEntry('block_HTML', 'url_sldup')."
		&amp;arti_page=2'
		>".$dbp['mc_nom']."</a>";
		$T['AD']['1'][$i]['2']['cont']	= $tabType[$dbp['mc_type']];
		$T['AD']['1'][$i]['3']['cont']	= $tabState[$dbp['mc_etat']];
	}
}


$T['tab_infos'] = $RenderTablesObj->getDefaultDocumentConfig($infos, 10 ,1, 0);
$T['ADC']['onglet'] = array(
		1	=>	$RenderTablesObj->getDefaultTableConfig($i,3,1),
);
$Content .= $RenderTablesObj->render($infos, $T);

// --------------------------------------------------------------------------------------------

$Content .= 
$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_sw').
$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_l').
$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_arti_ref').
"<input type='hidden' name='arti_page'	value='2'>\r
<br>\r
<table width='100%' cellpadding='16' cellspacing='0' style='margin-left: auto; margin-right: auto;'>
<tr>\r
<td>\r <input type='text' name='keywordForm[filter]' size='35' maxlength='255' value='".$RequestDataObj->getRequestDataSubEntry('keywordForm','filter')."' class='".$Block."_t3 ".$Block."_form_1'>\r
</td>\r

<td align='right'>\r";
$SB = array(
		"id"				=> "filterButton",
		"type"				=> "submit",
		"initialStyle"		=> $Block."_t3 ".$Block."_submit_s1_n",
		"hoverStyle"		=> $Block."_t3 ".$Block."_submit_s1_h",
		"onclick"			=> "",
		"message"			=> $I18nObj->getI18nEntry('btnFilter'),
		"mode"				=> 1,
		"size" 				=> 128,
		"lastSize"			=> 0,
);
$Content .= $InteractiveElementsObj->renderSubmitButton($SB);
$Content .= "</form>\r
</td>\r
</tr>\r
</table>\r
";

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('Template');
$TemplateObj = Template::getInstance();
$Content .= $TemplateObj->renderAdminCreateButton($infos);

/*Hydre-contenu_fin*/

$LMObj->setInternalLogTarget($logTarget);

?>
