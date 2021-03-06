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
/* @var $cs CommonSystem                            */
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

/*Hydre-contenu_debut*/
$localisation = " / uni_website_list_p01";
$cs->MapperObj->AddAnotherLevel($localisation );
$cs->LMObj->logCheckpoint("uni_website_list_p01.php");
$cs->MapperObj->RemoveThisLevel($localisation );
$cs->MapperObj->setSqlApplicant("uni_website_list_p01.php");

switch ($l) {
	case "fra":
		$cs->I18nObj->apply(array(
		"invite1"		=> "Cette partie va vous permettre de voir les sites.",
		"col_1_txt"	=> "Id",
		"col_2_txt"	=> "Nom",
		"col_3_txt"	=> "Répertoire",
		"col_4_txt"	=> "Lien",
		"link"		 => "Visiter le site",
		));
		break;
	case "eng":
		$cs->I18nObj->apply(array(
		"invite1"		=> "This part will show you the websites.",
		"col_1_txt"	=> "Id",
		"col_2_txt"	=> "Name",
		"col_3_txt"	=> "Directory",
		"col_4_txt"	=> "Link",
		"link"		=> "Visit the website",
		));
		break;
}

$Content .= $cs->I18nObj->getI18nEntry('invite1')."<br>\r<br>\r";

$T = array();
$i = 1;
$T['AD']['1'][$i]['1']['cont'] = $cs->I18nObj->getI18nEntry('col_1_txt');
$T['AD']['1'][$i]['2']['cont'] = $cs->I18nObj->getI18nEntry('col_2_txt');
$T['AD']['1'][$i]['3']['cont'] = $cs->I18nObj->getI18nEntry('col_3_txt');
$T['AD']['1'][$i]['4']['cont'] = $cs->I18nObj->getI18nEntry('col_4_txt');
$i++;

$dbquery = $cs->SDDMObj->query("
SELECT ws_id, ws_name, ws_directory 
FROM ".$SqlTableListObj->getSQLTableName('website')." 
ORDER BY ws_id
;");

while ($dbp = $cs->SDDMObj->fetch_array_sql($dbquery)) {
	$T['AD']['1'][$i]['1']['cont'] = $dbp['ws_id'];
	$T['AD']['1'][$i]['2']['cont'] = $dbp['ws_name'];
	$T['AD']['1'][$i]['3']['cont'] = $dbp['ws_directory'];
	$T['AD']['1'][$i]['4']['cont'] = "<a class='" .$Block."_lien " .$Block."_t2' href='index.php?sw=".$dbp['ws_id']."' target='_new'>".$cs->I18nObj->getI18nEntry('link')."</a>";
	$i++;
}
$RenderLayoutObj = RenderLayout::getInstance ();
$T['tab_infos']['EnableTabs']		= 0;
$T['tab_infos']['NbrOfTabs']		= 1;
$T['tab_infos']['TabBehavior']		= 1;
$T['tab_infos']['RenderMode']		= 1;
$T['tab_infos']['HighLightType']	= 1;
$T['tab_infos']['Height']			= $RenderLayoutObj->getLayoutModuleEntry($infos['module_name'], 'dim_y_ex22' ) - $ThemeDataObj->getThemeBlockEntry($infos['blockG'],'tab_y' )-512;
$T['tab_infos']['Width']			= $ThemeDataObj->getThemeDataEntry('theme_module_largeur_interne');
$T['tab_infos']['GroupName']		= "list";
$T['tab_infos']['CellName']			= "site";
$T['tab_infos']['DocumentName']		= "doc";
// $T['tab_infos']['cell_1_txt']		= $cs->I18nObj->getI18nEntry('col_1_txt'];
// $T['tab_infos']['cell_2_txt']		= $cs->I18nObj->getI18nEntry('col_2_txt'];
// $T['tab_infos']['cell_3_txt']		= $cs->I18nObj->getI18nEntry('col_3_txt'];
// $T['tab_infos']['cell_4_txt']		= $cs->I18nObj->getI18nEntry('col_4_txt'];

$T['ADC']['onglet']['1']['nbr_ligne']	= $i-1;	
$T['ADC']['onglet']['1']['nbr_cellule']	= 4;	
$T['ADC']['onglet']['1']['legende']		= 1;

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

$Content .= $cs->RenderTablesObj->render($config, $T);

/*Hydre-contenu_fin*/
?>
