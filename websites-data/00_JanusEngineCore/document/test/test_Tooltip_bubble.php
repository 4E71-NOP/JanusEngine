<?php
 // // // @JanusEngine:license-start
// --------------------------------------------------------------------------------------------
// Janus Engine 
//
// This file file is part of the Janus-Engine project.
// @see       : https://github.com/4E71-NOP/JanusEngine
//
// @license   : Creative Commons licence CC-by-nc-sa (https://creativecommons.org/licenses/by-nc-sa/4.0/)
// @author    : Faust MARIA DE AREVALO (original founder) <faust@rootwave.com>
// @copyright : 2005 - ∞ Faust MARIA DE AREVALO
//
// @note      : This program is distributed in the hope that it will be useful - WITHOUT ANY WARRANTY; 
//              without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
//
// Check README.md for more details
// --------------------------------------------------------------------------------------------
// @JanusEngine:license-end

// @JanusEngine:IDE-begin
// Some definitions in order to ease the IDE work and to provide details about what is available.
//
// @var $bts BaseToolSet
// @var $CurrentSetObj CurrentSet
// @var $ClassLoaderObj ClassLoader
//
// @var $RequestDataObj RequestData
// @var $SDDMObj DalFacade
// @var $SqlTableListObj SqlTableList
//
// @var $StringFormatObj StringFormat
// @var $MapperObj Mapper
// @var $DocumentDataObj DocumentData
// @var $ThemeDataObj ThemeData
// @var $UserObj User
// @var $WebSiteObj WebSite
//
// @var $CMObj ConfigurationManagement
// @var $LMObj LogManagement
//
// @var $InteractiveElementsObj InteractiveElements
// @var $RenderTablesObj RenderTables
//
// @var $Content String
// @var $Block String
// @var $infos array
// @var $l String
//
// @JanusEngine:IDE-end



/*JanusEngine-Content-Begin*/
$SB = array(
		"id"				=> "bouton_suppression_log1",
		"type"				=> "button",
		"initialStyle"		=> $Block."_submit_s1_n",
		"hoverStyle"		=> $Block."_submit_s1_h",
		"onclick"			=> "dm.dbgCalcDeco=1; TooltipConfig.test01={ 'State':1, 'X':'128', 'Y':'256' };",
		"message"			=> "128x256",
		"mode"				=> 1,
		"size" 				=> 96,
		"lastSize"			=> 0,
);
$Content .= $bts->InteractiveElementsObj->renderSubmitButton($SB);

$Content .=  ("<br>\r");

$SB = array(
		"id"				=> "bouton_suppression_log2",
		"type"				=> "button",
		"initialStyle"		=> $Block."_submit_s2_n",
		"hoverStyle"		=> $Block."_submit_s2_h",
		"onclick"			=> "dm.dbgCalcDeco=1; TooltipConfig.test01={ 'State':1, 'X':'256', 'Y':'96' };",
		"message"			=> "256x96",
		"mode"				=> 1,
		"size" 				=> 96,
		"lastSize"			=> 0,
);
$Content .= $bts->InteractiveElementsObj->renderSubmitButton($SB);
$Content .=  ("<br>\r<br>\r<br>\r
<div style='display:block; text-align:center;'>
<span
		style= 'margin:1cm; padding:0.5cm; background-color:#FF800080; border-radius: 0.5cm;'
		onMouseOver=\"t.ToolTip('Testing...', 'test01');\"
		onMouseOut=\"t.ToolTip('', 'test01');\">
Hover on me and test the tooltip!</span>\r
</div>\r
<br>\r
<br>\r
");
/*JanusEngine-Content-End*/

?>
