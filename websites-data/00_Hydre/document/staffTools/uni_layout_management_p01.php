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

/*Hydre-contenu_debut*/
$localisation = " / uni_layout_management_p01";
$bts->MapperObj->AddAnotherLevel($localisation );
$bts->LMObj->logCheckpoint("uni_layout_management_p01.php");
$bts->MapperObj->RemoveThisLevel($localisation );
$bts->MapperObj->setSqlApplicant("uni_layout_management_p01.php");

switch ($l) {
	case "fra":
		$bts->I18nObj->apply(array(
		"invite1"		=> "Cette partie va vous permettre de gérer les présentations.",
		"col_1_txt"		=> "Nom",
		"col_2_txt"		=> "Nom générique",
		"col_3_txt"		=> "Theme",
		"tabTxt1"		=> "Informations",
		"raf1"			=> "Rien a afficher",
		"btn1"			=> "Filtrer",
		));
		break;
	case "eng":
		$bts->I18nObj->apply(array(
		"invite1"		=> "This part will allow you to manage layouts.",
		"col_1_txt"		=> "Name",
		"col_2_txt"		=> "Generic name",
		"col_3_txt"		=> "Theme",
		"tabTxt1"		=> "Informations",
		"raf1"			=> "Nothing to display",
		"btn1"			=> "Filter",
		));
		break;
}

$Content .="<p>". $bts->I18nObj->getI18nEntry('invite1')."</p>";

$dbquery = $bts->SDDMObj->query("
SELECT pr.*, sd.theme_title
FROM ".$SqlTableListObj->getSQLTableName('layout')." pr, ".$SqlTableListObj->getSQLTableName('layout_theme')." sp, ".$SqlTableListObj->getSQLTableName('theme_website')." ss, ".$SqlTableListObj->getSQLTableName('theme_descriptor')." sd 
WHERE ss.ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."' 
AND sp.theme_id = ss.theme_id 
AND ss.theme_id = sd.theme_id
AND sp.layout_id = pr.layout_id 
ORDER BY pr.layout_id
;");

if ( $bts->SDDMObj->num_row_sql($dbquery) == 0 ) {
	$i = 1;
	$T['AD']['1'][$i]['1']['cont'] = $bts->I18nObj->getI18nEntry('raf1');
	$T['AD']['1'][$i]['2']['cont'] = "";
	$T['AD']['1'][$i]['3']['cont'] = "";
}
else {
	$i = 1;
	$T['AD']['1'][$i]['1']['cont']	= $bts->I18nObj->getI18nEntry('col_1_txt');
	$T['AD']['1'][$i]['2']['cont']	= $bts->I18nObj->getI18nEntry('col_2_txt');
	$T['AD']['1'][$i]['3']['cont']	= $bts->I18nObj->getI18nEntry('col_3_txt');
	while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) { 
		$i++;
		$T['AD']['1'][$i]['1']['cont']	= "
		<a class='".$Block."_lien' href='index.php?
		&amp;uni_gestion_des_layout_p=2
		&amp;M_PRESNT[layout_id]=".$dbp['layout_id']. 
		$CurrentSetObj->getDataSubEntry('block_HTML', 'url_sldup').
		"&amp;arti_page=2'
		>".$dbp['layout_name']."</a>";
		$T['AD']['1'][$i]['2']['cont']	= $dbp['layout_title'];
		$T['AD']['1'][$i]['3']['cont']	= $dbp['theme_title'];
	}
}


$T['tab_infos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, 10, 1);
$T['ADC']['onglet'] = array(
		1	=>	$bts->RenderTablesObj->getDefaultTableConfig($i,3,1),
);
$Content .= $bts->RenderTablesObj->render($infos, $T);

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('Template');
$TemplateObj = Template::getInstance();
$Content .= $TemplateObj->renderAdminCreateButton($infos);

/*Hydre-contenu_fin*/

// $LMObj->setInternalLogTarget($LOG_TARGET);

?>
