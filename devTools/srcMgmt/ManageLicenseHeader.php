
<?php
require_once("ReplaceTextInFiles.php");
$R = ReplaceTextInFiles::getInstance();

$R->setRegexStr("/\/\*\s*JanusEngine-license-start\s*\*\/(.*)\/\*\s*JanusEngine-license-end\s*\*\//s");

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
	"README.m"
));

$R->setIncludedExtension(array("php"));

$R->setContentStr(file_get_contents('license_header.txt'));

$R->render();

?>