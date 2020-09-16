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

/*Hydre-contenu_debut*/
$localisation = " / uni_liste_des_sites_p01";
$MapperObj->AddAnotherLevel($localisation );
$LMObj->logCheckpoint("uni_liste_des_sites_p01");
$MapperObj->RemoveThisLevel($localisation );
$MapperObj->setSqlApplicant("uni_liste_des_sites_p01");

switch ($l) {
	case "fra":
		$I18nObj->apply(array(
		"invite1"		=> "Cette partie va vous permettre de voir les sites.",
		"col_1_txt"	=> "Id",
		"col_2_txt"	=> "Nom",
		"col_3_txt"	=> "Répertoire",
		"col_4_txt"	=> "Lien",
		"link"		 => "Visiter le site",
		));
		break;
	case "eng":
		$I18nObj->apply(array(
		"invite1"		=> "This part will show you the websites.",
		"col_1_txt"	=> "Id",
		"col_2_txt"	=> "Name",
		"col_3_txt"	=> "Directory",
		"col_4_txt"	=> "Link",
		"link"		=> "Visit the website",
		));
		break;
}

$Content .= $I18nObj->getI18nEntry('invite1')."<br>\r<br>\r";

$T = array();
$i = 1;
$T['AD']['1'][$i]['1']['cont'] = $I18nObj->getI18nEntry('col_1_txt');
$T['AD']['1'][$i]['2']['cont'] = $I18nObj->getI18nEntry('col_2_txt');
$T['AD']['1'][$i]['3']['cont'] = $I18nObj->getI18nEntry('col_3_txt');
$T['AD']['1'][$i]['4']['cont'] = $I18nObj->getI18nEntry('col_4_txt');
$i++;

$dbquery = $SDDMObj->query("
SELECT sw_id, sw_nom, sw_repertoire 
FROM ".$SqlTableListObj->getSQLTableName('site_web')." 
ORDER BY sw_id
;");

while ($dbp = $SDDMObj->fetch_array_sql($dbquery)) {
	$T['AD']['1'][$i]['1']['cont'] = $dbp['sw_id'];
	$T['AD']['1'][$i]['2']['cont'] = $dbp['sw_nom'];
	$T['AD']['1'][$i]['3']['cont'] = $dbp['sw_repertoire'];
	$T['AD']['1'][$i]['4']['cont'] = "<a class='" .$Block."_lien " .$Block."_t2' href='index.php?sw=".$dbp['sw_id']."' target='_new'>".$I18nObj->getI18nEntry('link')."</a>";
	$i++;
}

$T['tab_infos']['EnableTabs']		= 0;
$T['tab_infos']['NbrOfTabs']		= 1;
$T['tab_infos']['TabBehavior']		= 1;
$T['tab_infos']['RenderMode']		= 1;
$T['tab_infos']['HighLightType']	= 1;
$T['tab_infos']['Height']			= $RenderLayoutObj->getLayoutModuleEntry($infos['module_nom'], 'dim_y_ex22' ) - $ThemeDataObj->getThemeBlockEntry($infos['blockG'],'tab_y' )-512;
$T['tab_infos']['Width']			= $ThemeDataObj->getThemeDataEntry('theme_module_largeur_interne');
$T['tab_infos']['GroupName']		= "list";
$T['tab_infos']['CellName']			= "site";
$T['tab_infos']['DocumentName']		= "doc";
// $T['tab_infos']['cell_1_txt']		= $I18nObj->getI18nEntry('col_1_txt'];
// $T['tab_infos']['cell_2_txt']		= $I18nObj->getI18nEntry('col_2_txt'];
// $T['tab_infos']['cell_3_txt']		= $I18nObj->getI18nEntry('col_3_txt'];
// $T['tab_infos']['cell_4_txt']		= $I18nObj->getI18nEntry('col_4_txt'];

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

$Content .= $RenderTablesObj->render($config, $T);

/*Hydre-contenu_fin*/
?>
