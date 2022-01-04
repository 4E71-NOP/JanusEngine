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

$localisation = " / uni_decoration_management_p01";
$bts->MapperObj->AddAnotherLevel($localisation );
$bts->LMObj->logCheckpoint("uni_decoration_management_p01.php");
$bts->MapperObj->RemoveThisLevel($localisation );
$bts->MapperObj->setSqlApplicant("uni_decoration_management_p01.php");

$bts->I18nTransObj->apply(
	array(
		"type" => "array",
		"fra" => array(
			"invite1"		=> "Cette partie va vous permettre de gerer les décorations.",
			"col_1_txt"		=> "Nom",
			"col_2_txt"		=> "Etat",
			"col_3_txt"		=> "Type",
			"tabTxt1"		=> "Informations",
			"type"			=> array(
				10	=>	"Menu",
				20	=>	"Caligraph",
				30	=>	"1_DIV",
				40	=>	"Elegance",
				50	=>	"Exquisite",
				60	=>	"Elysion",
			),
			"state"			=> array(
				0	=> "HOrs ligne",
				1	=> "En ligne",
				2	=> "Supprimé",
			),
		),
		"eng" => array(
			"invite1"		=> "This part will allow you to manage decoration.",
			"col_1_txt"		=> "Name",
			"col_2_txt"		=> "State",
			"col_3_txt"		=> "Type",
			"tabTxt1"		=> "Informations",
			"type"			=> array(
				10	=>	"Menu",
				20	=>	"Caligraphr",
				30	=>	"1_DIV",
				40	=>	"Elegance",
				50	=>	"Exquisite",
				60	=>	"Elysion",
				),
			"state"			=> array(
				0	=> "Offline",
				1	=> "Online",
				2	=> "Deleted",
			),
		)
	)
);

$Content .= $bts->I18nTransObj->getI18nTransEntry('invite1')."<br>\r<br>\r";

// --------------------------------------------------------------------------------------------
$dbquery = $bts->SDDMObj->query("
SELECT * 
FROM ".$SqlTableListObj->getSQLTableName('decoration')." 
;");

$T = array();
if ( $bts->SDDMObj->num_row_sql($dbquery) == 0 ) {
	$i = 1;
	$T['Content']['1'][$i]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('nothingToDisplay');
	$T['Content']['1'][$i]['2']['cont'] = "";
	$T['Content']['1'][$i]['3']['cont'] = "";
}
else {
	$i = 1;
	$T['Content']['1'][$i]['1']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_1_txt');
	$T['Content']['1'][$i]['2']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_2_txt');
	$T['Content']['1'][$i]['3']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_3_txt');

	$i = 1;
	while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) { 
		$i++;
		$T['Content']['1'][$i]['1']['cont']	= "
		<a class='".$Block."_lien' href='"
		."index.php?"._HYDRLINKURLTAG_."=1"
		."&arti_slug=".$CurrentSetObj->getDataSubEntry ( 'article', 'arti_slug')
		."&arti_ref=".$CurrentSetObj->getDataSubEntry ( 'article', 'arti_ref')
		."&arti_page=2"
		."&formGenericData[mode]=edit"
		."&formGenericData[selectionId]=".$dbp['deco_id']
		."'>".$dbp['deco_name']."</a>";
		$T['Content']['1'][$i]['2']['cont']	= $bts->I18nTransObj->getI18nTransEntry('state')[$dbp['deco_state']];
		$T['Content']['1'][$i]['3']['cont']	= $bts->I18nTransObj->getI18nTransEntry('type')[$dbp['deco_type']];
	}
}

// --------------------------------------------------------------------------------------------
//
//	Display
//
//
// --------------------------------------------------------------------------------------------
$T['ContentInfos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, 15);
$T['ContentCfg']['tabs'] = array(
		1	=>	$bts->RenderTablesObj->getDefaultTableConfig($i,3,1),
);
$Content .= $bts->RenderTablesObj->render($infos, $T);

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('Template');
$TemplateObj = Template::getInstance();
$Content .= $TemplateObj->renderAdminCreateButton($infos);

/*Hydr-Content-End*/

// $LMObj->setInternalLogTarget($LOG_TARGET);

?>
