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

$bts->I18nTransObj->apply(
	array(
		"type" => "array",
		"fra" => array(
			"invite1"		=>	"Janus Engine, de manière a devenir international a besoin de traducteurs pour ses articles, code, commentaires.<br>\r
		<br>\r
		Si vous avez des sujets intéressants pour Janus Engine n'hésitez pas a en proposer.<br>\r
		<br>\r
		Si vous avez des suggestions (constructives) concernant Janus Engine vous pourrez nous contacter à l'adresse suivante.<br>\r
		<br>\r
		<p style='text-align: center;' >\r
		<a class='" . $Block . "_lien " . $Block . "_t4' href='mailto:someone@somedomain.net'>mailto:someone@somedomain.net</a>
		</p>
		<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
		<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
		<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
		"
		),
		"eng" => array(
			"invite1"		=>	"In order to become international Janus Engine needs traducers for article, code, comments.<br>\r
		<br>\r
		If you have interesting topics for  Janus Engine don't hesitate to submit some.<br>\r
		<br>\r
		If you have suggestions for Janus Engine you can write to this address.<br>\r
		<br>\r
		<p style='text-align: center;' >\r
		<a class='" . $Block . "_lien " . $Block . "_t4' href='mailto:someone@somedomain.net'>mailto:someone@somedomain.net</a>
		</p>
		<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
		<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
		<br>\r	<br>\r	<br>\r	<br>\r	<br>\r
		"
		)
	)
);

$Content .= $bts->I18nTransObj->getI18nTransEntry('invite1') . "<br>\r<br>\r";

/*JanusEngine-Content-End*/
