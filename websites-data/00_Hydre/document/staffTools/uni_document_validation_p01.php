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

// --------------------------------------------------------------------------------------------
$bts->RequestDataObj->setRequestData('scriptFile', '01020203110001_p02.wmcode');
$bts->RequestDataObj->setRequestData('scriptFile', 'uni_recherche_p01.php');

// --------------------------------------------------------------------------------------------
/*Hydr-Content-Begin*/
$localisation = " / uni_document_validation_p01";
$bts->MapperObj->AddAnotherLevel($localisation );
$bts->LMObj->logCheckpoint("uni_document_validation_p01.php");
$bts->MapperObj->RemoveThisLevel($localisation );
$bts->MapperObj->setSqlApplicant("uni_document_validation_p01.php");

$bts->I18nTransObj->apply(
	array(
		"type" => "array",
		"fra" => array(
			"invite1"		=>	"Cette partie va vous permettre de modifier les documents.",
			"type0"			=>	"Hydr",
			"type1"			=>	"Pas de code",
			"type2"			=>	"PHP",
			"type3"			=>	"Mixed",
			"modif0"		=>	"Non",
			"modif1"		=>	"Oui",
			"tabTxt1"		=>	"Informations",
			"col_1_txt"		=>	"Nom",
			"col_2_txt"		=>	"Type",
			"col_3_txt"		=>	"Modifiable",
			"raf1"			=>	"Rien a afficher",
			"btn1"			=>	"Créer un document",
		),
		"eng" => array(
			"invite1"		=>	"This part will allow you to modify documents.",
			"type0"			=>	"Hydr",
			"type1"			=>	"No code",
			"type2"			=>	"PHP",
			"type3"			=>	"Mixed",
			"modif0"		=>	"No",
			"modif1"		=>	"Yes",
			"tabTxt1"		=>	"Informations",
			"col_1_txt"		=>	"Name",
			"col_2_txt"		=>	"Type",
			"col_3_txt"		=>	"Can be modified",
			"raf1"			=>	"Nothing to display",
			"btn1"			=>	"Create a document",
		)
	)
);


// --------------------------------------------------------------------------------------------

$dbquery = $bts->SDDMObj->query("
SELECT doc.docu_id,doc.docu_name,doc.docu_type,shr.share_modification 
FROM "
.$SqlTableListObj->getSQLTableName('document')." doc, "
.$SqlTableListObj->getSQLTableName('document_share')." shr 
WHERE shr.fk_ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."' 
AND shr.fk_docu_id = doc.docu_id 
AND doc.docu_examination = '0' 
AND doc.docu_origin = '".$WebSiteObj->getWebSiteEntry('ws_id')."' 
;");

$tab_modif = array(
		0 => $bts->I18nTransObj->getI18nTransEntry('modif0'),
		1 => $bts->I18nTransObj->getI18nTransEntry('modif1'),
);
$tab_type = array(
		0 => $bts->I18nTransObj->getI18nTransEntry('type0'),
		1 => $bts->I18nTransObj->getI18nTransEntry('type1'),
		2 => $bts->I18nTransObj->getI18nTransEntry('type2'),
		3 => $bts->I18nTransObj->getI18nTransEntry('type3'),
);

$T = array();
$i = 1;
if ( $bts->SDDMObj->num_row_sql($dbquery) == 0 ) {
	$T['Content']['1'][$i]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('nothingToDisplay');
	$T['Content']['1'][$i]['2']['cont'] = "";
	$T['Content']['1'][$i]['3']['cont'] = "";
}
else {
	$T['Content']['1'][$i]['1']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_1_txt');
	$T['Content']['1'][$i]['2']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_2_txt');
	$T['Content']['1'][$i]['3']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_3_txt');
	while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) { 
		$i++;
		$T['Content']['1'][$i]['1']['cont']	= "<a class='" . $Block."_lien " . $Block."_t1' href='index.php?&amp;M_DOCUME[document_selection]=".$dbp['docu_id'].$bloc_html['url_sldup']."&amp;arti_page=2'>".$dbp['docu_name']."</a>";
		$T['Content']['1'][$i]['2']['cont']	= $tab_type[$dbp['docu_type']];
		$T['Content']['1'][$i]['3']['cont']	= $tab_modif[$dbp['part_modification']];
	}
}


$T['ContentInfos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, 15);
$T['ContentCfg']['tabs'] = array(
		1	=>	$bts->RenderTablesObj->getDefaultTableConfig($i,3,1),
);
$Content .= $bts->RenderTablesObj->render($infos, $T);

// --------------------------------------------------------------------------------------------
$Content .= "
<br>\r
<br>\r

<table cellpadding='0' cellspacing='0' style='margin-left: auto; margin-right: 0px; '>
<tr>\r
<td>\r
<form ACTION='index.php?' method='post'>\r".
$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_sw').
$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_l').
$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_arti_ref').
"<input type='hidden' name='arti_page'	value='2'>\r".
$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_user_login').
$CurrentSetObj->getDataSubEntry('block_HTML', 'post_hidden_user_pass')
;

$SB = array(
		"id"				=> "createButton",
		"type"				=> "submit",
		"initialStyle"		=> $Block."_t3 ".$Block."_submit_s2_n",
		"hoverStyle"		=> $Block."_t3 ".$Block."_submit_s2_h",
		"onclick"			=> "",
		"message"			=> $bts->I18nTransObj->getI18nTransEntry('btn1'),
		"mode"				=> 0,
		"size" 				=> 0,
		"lastSize"			=> 0,
);
$Content .= $bts->InteractiveElementsObj->renderSubmitButton($SB);

$Content .= "<br>\r&nbsp;
</form>\r
</td>\r
</tr>\r
</table>\r
<br>\r
";

/*Hydr-Content-End*/
?>
