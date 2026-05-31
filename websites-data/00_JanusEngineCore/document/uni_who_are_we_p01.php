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


//http://www.local-janus-engine.com/enroll/1/

/*JanusEngine-Content-Begin*/

$bts->I18nTransObj->apply(
	array(
		"type" => "array",
		"fra" => array(
			"invite1"		=>	"C'est un petit développeur dans sa campagne qui lance ce projet.<br>\r
			<br>\r
			Si vous souhaitez aider, allez sur <a href='" . $CurrentSetObj->ServerInfosObj->getServerInfosEntry('base_url') . "enroll'>cette page</a>.<br>\r
			<br>\r
			<br>\r
			<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
			<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
			<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
			"
		),
		"eng" => array(
			"invite1"		=>	"This is a single developer lost in the jungle who launch this project.<br>\r
			<br>\r
			If you want to help, go to <a href='" . $CurrentSetObj->ServerInfosObj->getServerInfosEntry('base_url') . "enroll'>this page</a>.<br>\r
			<br>\r
			<br>\r
			<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
			<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
			<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
		"
		)
	)
);

$Content .= $bts->I18nTransObj->getI18nTransEntry('invite1') . "<br>\r<br>\r";

/*JanusEngine-Content-End*/
