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

/*Hydr-Content-Begin*/

$localisation = " / uni_download_p01";
$bts->MapperObj->AddAnotherLevel($localisation );
$bts->LMObj->logCheckpoint("uni_download_p01.php");
$bts->MapperObj->RemoveThisLevel($localisation );
$bts->MapperObj->setSqlApplicant("uni_download_p01.php");

$bts->I18nTransObj->apply(
	array(
		"type" => "array",
		"fra" => array(
			"invit"		=> "Section téléchargement.",
			"TableCaptionPos1"	=> "Fichier",
			"TableCaptionPos2"	=> "Taille",
			"l2c1"		=> "Répertoire vide",
			"mb"		=> " Mb",
			"tabTxt1"	=> "Fichiers disponibles",
		),
		"eng" => array(
			"invit" => "Download section.",
			"TableCaptionPos1"	=> "File",
			"TableCaptionPos2"	=> "Size",
			"l2c1"		=> "Empty directory",
			"mb"		=> " Mo",
			"tabTxt1"	=> "Available files",
		)
	)
);
		

$i = 1;
$T = array();

$T['Content']['1'][$i]['1']['cont']	= $bts->I18nTransObj->getI18nTransEntry('TableCaptionPos1');
$T['Content']['1'][$i]['2']['cont']	= $bts->I18nTransObj->getI18nTransEntry('TableCaptionPos2');

$realpath = realpath("websites-data/".$WebSiteObj->getWebSiteEntry('ws_directory')."/data/public/");
$handle = opendir($realpath);
while (false !== ($f = readdir($handle))) {
	if ($f != "." && $f != "..") {
		$i++;
		$f_stat = stat($realpath."/".$f);
		$T['Content']['1'][$i]['1']['cont'] = "<a class='" . $Block."_lien' href='../download/".$f."'>".$f."</a>";
		$T['Content']['1'][$i]['2']['cont'] =  ($f_stat['size']/1024/1024).$i18nDoc['mb'];
	}
}

if ($i == 1) {
	$i++;
	$T['Content']['1'][$i]['1']['cont']	= $i18nDoc['l2c1'];
	$T['Content']['1'][$i]['2']['cont']	= "";
}

$T['ContentInfos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, 15);
$T['ContentCfg']['tabs'] = array(
		1	=>	$bts->RenderTablesObj->getDefaultTableConfig($i,4,1),
);


$T['ContentCfg']['tabs']['1']['NbrOfLines'] = $i;		$T['ContentCfg']['tabs']['1']['NbrOfCells'] = 2;	$T['ContentCfg']['tabs']['1']['TableCaptionPos'] = 1;
$Content .= $bts->RenderTablesObj->render($infos, $T);

/*Hydr-Content-End*/
?>
