<?php
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

require_once("ReplaceTextInFiles.php");
$R = ReplaceTextInFiles::getInstance();

$R->setRegexStr("/\/\*\s*JanusEngine-IDE-begin\s*\*\/(.*)\/\*\s*JanusEngine-IDE-end\s*\*\//s");

$R->setExcludeList(array(
	".",
	"..",
	"current",
	"deploymentScripts",
	"DeveloperDocs",
	"devTools",
	".git",
	".gitignore",
	"__help__",
	".htaccess",
	".htpasswd",
	".metadata",
	".phpdoc",
	".project",
	"README.md"
));

$R->setIncludedExtension(array("php"));

$R->setContentStr(file_get_contents('ideVars.txt'));

$R->render();

?>