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


$bts->RequestDataObj->setRequestDataEntry('scriptSrc',"
add layout_content to_layout		'mwm_aqua_01_layout_par_defaut'		module_name		'blason'
line	'1'	calculus_type 	'STATIC'
				
position_x	'0'	position_y	'0'
dimenssion_x	'192'	dimenssion_y	'128'	minimum_x	'128'	minimum_y	'128'
spacing_border_left	'0'	spacing_border_right	'0'	spacing_border_top	'0'	spacing_border_bottom	'0'
module_zindex	'10';
");

/*JanusEngine-Content-Begin*/
$bts->mapSegmentLocation(__METHOD__, "uni_toolset_cleanup_script_p01");

$bts->I18nTransObj->getI18nTransFromDB("uni_toolset_cleanup_script");
$bts->I18nTransObj->getI18nTransFromFile($CurrentSetObj->ServerInfosObj->getServerInfosEntry('DOCUMENT_ROOT') . "/websites-data/00_JanusEngineCore/document/staffTools/i18n/uni_toolset_cleanup_script_p01_");

$CurrentSetObj->GeneratedScriptObj->insertString('JavaScript-File', 'current/engine/javascript/lib_JnsEngScriptFormatTool.js');

$textAreaCols=50;
$textAreaRows=16;
$Content .= $bts->I18nTransObj->getI18nTransEntry('Invite1').
"<br>\r
<form name='formConvert' ACTION='index.php?' method='post'>\r

<table class='".$Block."bareTable' style='width:100%; text-align:center;'>\r
<tr>\r
<td>\r
<textarea name='scriptSrc' id='scriptSrc' cols='".$textAreaCols."' rows='".$textAreaRows."'>\r
".$bts->RequestDataObj->getRequestDataEntry('scriptSrc')."</textarea>\r
</td>\r
</tr>\r

<tr>\r
<td style='font-size: 8px;'>\r
<textarea name='scriptResult' id='scriptResult' cols='".$textAreaCols."' rows='".$textAreaRows."'>\r
".$pv['converti']."</textarea>\r
</td>\r
</tr>\r
";

$Content .= "</table>\r
<br>\r

<table class='".$Block."bareTable' style='width:100%;'>\r
<tr>\r
<td style='width:60%;'>\r</td>\r
<td style='text-align: right;'>\r
";

$SB = $bts->InteractiveElementsObj->getDefaultSubmitButtonConfig(
	$infos , 'button', 
	$bts->I18nTransObj->getI18nTransEntry('btn1'), 96, 
	'cleanButton', 
	2, 2, 
	"formatJnsEngScript ( 'formConvert' , 'scriptSrc' , 'scriptResult' );" 
);
$Content .= $bts->InteractiveElementsObj->renderSubmitButton($SB);
$Content .= "
</td>\r
</tr>\r
</table>\r
</form>\r
";

$bts->segmentEnding(__METHOD__);
/*JanusEngine-Content-End*/
?>
