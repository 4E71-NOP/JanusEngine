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

// $RequestDataObj->setRequestDataEntry('script_source',"");
$bts->RequestDataObj->setRequestDataEntry('RenderCSS',
		array(
				'CssSelection' => 2,
				'go' => 1,
			),
		);

/*Hydr-Content-Begin*/
$localisation = " / uni_article_validation_p01.php";
$bts->MapperObj->AddAnotherLevel($localisation );
$bts->LMObj->logCheckpoint("uni_article_validation_p01.php");
$bts->MapperObj->RemoveThisLevel($localisation );
$bts->MapperObj->setSqlApplicant("uni_article_validation_p01.php");


$bts->I18nTransObj->apply(
	array(
		"type" => "array",
		"fra" => array(
			"invite1"		=>	"Cette partie va vous permettre de valider des articles.",
			"raf1"			=>	"Rien à afficher",
			"tabTxt1"		=>	"Informations",
			"col_1_txt"		=>	"Nom",
			"col_2_txt"		=>	"Page",
			"col_3_txt"		=>	"Référence",
			"col_4_txt"		=>	"Titre",
			"col_5_txt"		=>	"Bouclage",
			"btnCreate"		=>	"Créer un article",
		),
		"eng" => array(
			"invite1"		=>	"This part will allow you to validate documents.",
			"raf1"			=>	"Nothing to display",
			"tabTxt1"		=>	"Informations",
			"col_1_txt"		=>	"Name",
			"col_2_txt"		=>	"Page",
			"col_3_txt"		=>	"Reference",
			"col_4_txt"		=>	"Title",
			"col_5_txt"		=>	"Deadline",
			"btnCreate"		=>	"Create a article",
		),
	)
);

// --------------------------------------------------------------------------------------------
$T = array();

$dbquery = $bts->SDDMObj->query("
SELECT art.* , dl.deadline_name 
FROM ".$SqlTableListObj->getSQLTableName('article')." art, "
.$SqlTableListObj->getSQLTableName('deadline')." dl 
WHERE art.arti_validation_state = 0 
AND dl.deadline_id = art.fk_deadline_id 
AND art.fk_ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."' 
;");

$i = 1;
if ( $bts->SDDMObj->num_row_sql($dbquery) == 0 ) {

	$T['Content']['1'][$i]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('nothingToDisplay');
	$T['Content']['1'][$i]['2']['cont'] = "";
	$T['Content']['1'][$i]['3']['cont'] = "";
	$T['Content']['1'][$i]['4']['cont'] = "";
	$T['Content']['1'][$i]['5']['cont'] = "";
}
else {
	$T['Content']['1'][$i]['1']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_1_txt');
	$T['Content']['1'][$i]['2']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_2_txt');
	$T['Content']['1'][$i]['3']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_3_txt');
	$T['Content']['1'][$i]['4']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_4_txt');
	$T['Content']['1'][$i]['5']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_5_txt');
	while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) { 
		$i++;
		$T['Content']['1'][$i]['1']['cont']	= "
		<a href='index.php?"
		."index.php?"._HYDRLINKURLTAG_."=1"
		."&arti_slug=".$CurrentSetObj->getDataSubEntry ( 'article', 'arti_slug')
		."&arti_ref=".$CurrentSetObj->getDataSubEntry ( 'article', 'arti_ref')
		."&arti_page=2"
		."&formGenericData[mode]=edit"
		."&articleForm[selectionId]=".$dbp['arti_id']
		."'>".$dbp['arti_name']."</a>";
		$T['Content']['1'][$i]['2']['cont']	= $dbp['arti_page'];
		$T['Content']['1'][$i]['3']['cont']	= $dbp['arti_ref'];
		$T['Content']['1'][$i]['4']['cont']	= $dbp['arti_title'];
		$T['Content']['1'][$i]['5']['cont']	= $dbp['deadline_name'];
	}
}

$T['ContentInfos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, 10);
$T['ContentCfg']['tabs'] = array(
		1	=>	$bts->RenderTablesObj->getDefaultTableConfig($i,5,1),
);
$Content .= $bts->RenderTablesObj->render($infos, $T);
$Content .= "<br>\r";


// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('Template');
$TemplateObj = Template::getInstance();
$Content .= $TemplateObj->renderAdminCreateButton($infos);


/*Hydr-Content-End*/
?>
