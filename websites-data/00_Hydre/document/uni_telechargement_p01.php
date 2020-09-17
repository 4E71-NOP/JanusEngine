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
// Some definitions in order to ease the IDE's work.
/* @var $CMObj ConfigurationManagement              */
/* @var $ClassLoaderObj ClassLoader                 */
/* @var $LMObj LogManagement                        */
/* @var $MapperObj Mapper                           */
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

/*Hydre-contenu_debut*/

$localisation = " / uni_telechargement_p01";
$MapperObj->AddAnotherLevel($localisation );
$LMObj->logCheckpoint("uni_telechargement_p01");
$MapperObj->RemoveThisLevel($localisation );
$MapperObj->setSqlApplicant("uni_telechargement_p01");

switch ($l) {
	case "fra":
		$i18nDoc = array(
		"invit"		=> "Section t&eacute;l&eacute;chargement.",
		"legende1"	=> "Fichier",
		"legende2"	=> "Taille",
		"l2c1"		=> "Répertoire vide",
		"mb"		=> " Mb",
		"tab1"		=> "Fichiers disponibles",
		);
		break;
	case "eng":
		$i18nDoc = array(
		"invit" => "Download section.",
		"legende1"	=> "File",
		"legende2"	=> "Size",
		"l2c1"		=> "Empty directory",
		"mb"		=> " Mo",
		"tab1"		=> "Available files",
		);
		break;
}

$i = 1;
$T = array();

$T['AD']['1'][$i]['1']['cont']	= $i18nDoc['legende1'];
$T['AD']['1'][$i]['2']['cont']	= $i18nDoc['legende2'];

$realpath = realpath("../websites-data/".$WebSiteObj->getWebSiteEntry('ws_directory')."/data/public/");
$handle = opendir($realpath);
while (false !== ($f = readdir($handle))) {
	if ($f != "." && $f != "..") {
		$i++;
		$f_stat = stat($realpath."/".$f);
		$T['AD']['1'][$i]['1']['cont'] = "<a class='" . $Block."_lien' href='../download/".$f."'>".$f."</a>";
		$T['AD']['1'][$i]['2']['cont'] =  ($f_stat['size']/1024/1024).$i18nDoc['mb'];
	}
}

if ($i == 1) {
	$i++;
	$T['AD']['1'][$i]['1']['cont']	= $i18nDoc['l2c1'];
	$T['AD']['1'][$i]['2']['cont']	= "";
}

$T['ADC']['onglet']['1']['nbr_ligne'] = $i;		$T['ADC']['onglet']['1']['nbr_cellule'] = 2;	$T['ADC']['onglet']['1']['legende'] = 1;

$T['tab_infos']['EnableTabs']		= 1;
$T['tab_infos']['NbrOfTabs']		= 1;
$T['tab_infos']['TabBehavior']		= 1;
$T['tab_infos']['RenderMode']		= 1;
$T['tab_infos']['HighLightType']	= 0;
$T['tab_infos']['Height']			= $RenderLayoutObj->getLayoutModuleEntry($infos['module_nom'], 'dim_y_ex22' ) - $ThemeDataObj->getThemeBlockEntry($infos['blockT'],'tab_y' )-256;
$T['tab_infos']['Width']			= $ThemeDataObj->getThemeDataEntry('theme_module_largeur_interne');
$T['tab_infos']['GroupName']		= "g";
$T['tab_infos']['CellName']			= "c";
$T['tab_infos']['DocumentName']		= "d";
$T['tab_infos']['cell_1_txt']		= $i18nDoc['tab1'];

$Content .= $RenderTablesObj->render($infos, $T);

/*Hydre-contenu_fin*/
?>
