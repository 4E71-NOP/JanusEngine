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

// $RequestDataObj->setRequestDataEntry('script_source',"");
$bts->RequestDataObj->setRequestDataEntry('RenderCSS',
		array(
				'CssSelection' => 2,
				'go' => 1,
			),
		);

/*Hydre-contenu_debut*/
$localisation = " / uni_article_validation_p01.php";
$bts->MapperObj->AddAnotherLevel($localisation );
$bts->LMObj->logCheckpoint("uni_article_validation_p01.php");
$bts->MapperObj->RemoveThisLevel($localisation );
$bts->MapperObj->setSqlApplicant("uni_article_validation_p01.php");

switch ($l) {
	case "fra":
		$bts->I18nTransObj->apply(array(
		"invite1"		=>	"Cette partie va vous permettre de valider des articles.",
		"raf1"			=>	"Rien à afficher",
		"cell_1_txt"	=> "Informations",
		"col_1_txt"		=>	"Nom",
		"col_2_txt"		=>	"Référence",
		"col_3_txt"		=>	"Titre",
		"col_4_txt"		=>	"Bouclage",
		"btnCreate"		=>	"Créer un article",
		));
		break;
	case "eng":
		$bts->I18nTransObj->apply(array(
		"invite1"		=>	"This part will allow you to validate documents.",
		"raf1"			=>	"Nothing to display",
		"cell_1_txt"	=> "Informations",
		"col_1_txt"		=>	"Name",
		"col_2_txt"		=>	"Reference",
		"col_3_txt"		=>	"Title",
		"col_4_txt"		=>	"Deadline",
		"btnCreate"		=>	"Create a article",
		));
		break;
}

// --------------------------------------------------------------------------------------------
$T = array();

$dbquery = $bts->SDDMObj->query("
SELECT art.* , bcl.deadline_name 
FROM ".$SqlTableListObj->getSQLTableName('article')." art, ".$SqlTableListObj->getSQLTableName('deadline')." bcl 
WHERE art.arti_validation_state = '0' 
AND bcl.deadline_id = art.deadline_id 
AND art.ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."' 
;");

$i = 1;
if ( $bts->SDDMObj->num_row_sql($dbquery) == 0 ) {

	$T['AD']['1'][$i]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('nothingToDisplay');
	$T['AD']['1'][$i]['2']['cont'] = "";
	$T['AD']['1'][$i]['3']['cont'] = "";
	$T['AD']['1'][$i]['4']['cont'] = "";
}
else {
	$T['AD']['1'][$i]['1']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_1_txt');
	$T['AD']['1'][$i]['2']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_2_txt');
	$T['AD']['1'][$i]['3']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_3_txt');
	$T['AD']['1'][$i]['4']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_4_txt');
	while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) { 
		$i++;
		$T['AD']['1'][$i]['1']['cont']	= "
		<a class='" . $Block."_lien' href='index.php?
		&amp;M_ARTICL[arti_id_selection]=".$dbp['arti_id']."
		&amp;M_ARTICL[arti_ref_selection]=".$dbp['arti_ref']."
		&amp;M_ARTICL[arti_page_selection]=".$dbp['arti_page'].
		$CurrentSetObj->getDataSubEntry('block_HTML', 'url_sldup')."
		&amp;arti_page=2'
		>".$dbp['arti_name']."</a>";
		$T['AD']['1'][$i]['2']['cont']	= $dbp['arti_ref'];
		$T['AD']['1'][$i]['3']['cont']	= $dbp['arti_title'];
		$T['AD']['1'][$i]['4']['cont']	= $dbp['deadline_name'];
	}
}

$T['tab_infos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, 10);
$T['ADC']['onglet'] = array(
		1	=>	$bts->RenderTablesObj->getDefaultTableConfig($i,4,1),
);
$Content .= $bts->RenderTablesObj->render($infos, $T);
$Content .= "<br>\r";


// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('Template');
$TemplateObj = Template::getInstance();
$Content .= $TemplateObj->renderAdminCreateButton($infos);


/*Hydre-contenu_fin*/
?>
