<?php
 // @JanusEngine:license-start
// --------------------------------------------------------------------------------------------
// Janus Engine 
//
// This file file is part of the Janus-Engine project.
// @see      : https://github.com/4E71-NOP/JanusEngine
//
// @license  : Creative Commons licence CC-by-nc-sa (https://creativecommons.org/licenses/by-nc-sa/4.0/)
// @author   : Faust MARIA DE AREVALO (original founder) <faust@rootwave.com>
// @copyright : 2005 - ∞ Faust MARIA DE AREVALO
//
// @note     : This program is distributed in the hope that it will be useful - WITHOUT ANY WARRANTY; 
//             without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
//
// Check README.md for more details
// --------------------------------------------------------------------------------------------
// @JanusEngine:license-end

/*JanusEngine-IDE-begin*/
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
/*JanusEngine-IDE-end*/


/*JanusEngine-Content-Begin*/
$bts->I18nTransObj->apply(
	array(
		"type" => "array",
		"fra" => array(
			"invite1"		=> "Invite #01",
			"col_1_txt"		=> "1",
			"col_2_txt"		=> "2",
			"col_3_txt"		=> "3",
			"col_4_txt"		=> "4",
			"col_5_txt"		=> "5",
			"tabTxt1"		=> "1",
			"tabTxt2"		=> "2",
			"tabTxt3"		=> "3",
			"tabTxt4"		=> "4",
			"tabTxt5"		=> "5",
		),
		"eng" => array(
			"invite1"		=> "Invite #01",
			"col_1_txt"		=> "1",
			"col_2_txt"		=> "2",
			"col_3_txt"		=> "3",
			"col_4_txt"		=> "4",
			"col_5_txt"		=> "5",
			"tabTxt1"		=> "1",
			"tabTxt2"		=> "2",
			"tabTxt3"		=> "3",
			"tabTxt4"		=> "4",
			"tabTxt5"		=> "5",
		)
	)
);

$Content .= $bts->I18nTransObj->getI18nTransEntry('invite1')."<br>\r<br>\r";

$T = array();

$maxTabs=2;
$maxLines=10;
$maxCells=2;

for ( $tab=1; $tab<=$maxTabs; $tab++) {
	for ( $line=1; $line<=$maxLines; $line++) {
		for ( $cell=1; $cell<=$maxCells; $cell+=2) {
			$T['Content'][$tab][$line][$cell]['cont']	=  $tab."_".$line."_".$cell.":";
			$T['Content'][$tab][$line][$cell+1]['cont']	=  "<input type='text' value='".$tab."/".$line."/".$cell."'>";
		}
	}
}

$T['ContentInfos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, 10, $maxTabs);
$T['ContentCfg']['tabs'] = array(
		1	=>	$bts->RenderTablesObj->getDefaultTableConfig($maxLines,$maxCells,1),
		2	=>	$bts->RenderTablesObj->getDefaultTableConfig($maxLines,$maxCells,1),
		3	=>	$bts->RenderTablesObj->getDefaultTableConfig($maxLines,$maxCells,1),
		4	=>	$bts->RenderTablesObj->getDefaultTableConfig($maxLines,$maxCells,1),
		5	=>	$bts->RenderTablesObj->getDefaultTableConfig($maxLines,$maxCells,1),
);
$Content .= $bts->RenderTablesObj->render($infos, $T);


/*JanusEngine-Content-End*/

?>
