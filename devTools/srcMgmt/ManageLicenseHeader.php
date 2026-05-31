
<?php
require_once("ReplaceTextInFiles.php");
$R = ReplaceTextInFiles::getInstance();

$R->setRegexStr("/@JanusEngine:license-start(.*)@JanusEngine:license-end/s");

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

$R->setContentStr(file_get_contents('license_header.txt'));

$R->render();

?>