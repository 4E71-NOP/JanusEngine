<?php
// --------------------------------------------------------------------------------------------
//
// Janus Engine 
//
// This file file is part of the Janus-Engine project.
// Source code	: https://github.com/4E71-NOP/JanusEngine
// License 		: Creative Common licence CC-by-nc-sa (http://creativecommons.org)
// Author		: Faust MARIA DE AREVALO (faust@rootwave.com)
//
// See README.md for more information
//
// --------------------------------------------------------------------------------------------
// Replace a text block delimited by tags in a file with the content of another file.
// Used to update the license header of all files in one single stroke.
//

define("__LOG_ERROR__", 1);
define("__LOG_WARNING__", 2);
define("__LOG_INFO__", 3);

class ReplaceTextInFiles
{
	private static $Instance = null;

	private $logLevel = 3;
	private $entryPoint = "";
	private $contentStr = "";

	private $excludeList = array(
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
	);
	private $includedExtension = array("php");

	private $regexStr = "/\/\*\s*JanusEngine-license-start\s*\*\/(.*)\/\*\s*JanusEngine-license-end\s*\*\//s";
	private $fileCount = 0;


	private function __construct() {}

	/**
	 * Singleton : Will return the instance of this class.
	 * @return JanusEngine
	 */
	public static function getInstance()
	{
		if (self::$Instance == null) {
			self::$Instance = new ReplaceTextInFiles();
		}
		return self::$Instance;
	}

	public function render()
	{
		// $this->contentStr = file_get_contents('license_header.txt');
		// $this->logMsg("\n***\n" . $this->contentStr . "\n***\n", __LOG_INFO__);

		chdir('../../');
		$this->entryPoint = getcwd();
		$pathToExplore = $this->entryPoint;
		$this->logMsg("Exploring : " . $pathToExplore . "...", __LOG_INFO__);

		$this->processFiles($pathToExplore, $this->entryPoint);
	}

	private function processFiles($pathToExplore)
	{
		$this->logMsg("Exploring : " . str_replace($this->entryPoint, "", $pathToExplore), __LOG_INFO__);
		$handle = opendir($pathToExplore);
		$localFileCount = 0;
		$locaDirCount = 0;

		while (false !== ($f = readdir($handle))) {
			if ($this->isIncluded($f)) {
				$currentFile = $pathToExplore . "/" . $f;
				if (is_dir($currentFile)) {
					// $this->logMsg(">" . str_replace($this->entryPoint, "", $currentFile) . " is a directory.", __LOG_INFO__);
					$locaDirCount++;
					$this->processFiles($currentFile);
				} else {
					$fileExt = pathinfo($currentFile, PATHINFO_EXTENSION);
					if ($this->hasTargetExension($fileExt)) {
						if (is_link($currentFile)) {
							$linkTargetPath = $pathToExplore . "/" . readlink($currentFile);
							if (file_exists($linkTargetPath)) {
								// $this->logMsg(">" . str_replace($this->entryPoint, "", $currentFile) . " is a valid link (" . $linkTargetPath . ").", __LOG_INFO__);
							} else {
								// $this->logMsg(">" . str_replace($this->entryPoint, "", $currentFile) . " is a bad link.(" . $linkTargetPath . ").", __LOG_INFO__);
							}
						} else {
							$this->fileCount++;
							$localFileCount++;
							// $this->logMsg(">" . str_replace($this->entryPoint, "", $currentFile) . " is a regular file.", __LOG_INFO__);
							$newContent = $this->replace(file_get_contents($currentFile));
							if (strlen($newContent ?? '') > 0 ) {
								file_put_contents($currentFile, $newContent);
							}
						}
					}
				}
			}
		}
		$this->logMsg(str_replace($this->entryPoint, "", $pathToExplore) . "/ Found : " . $locaDirCount . " directories and " . $localFileCount . " targeted type file(s).", __LOG_INFO__);
	}

	private function isIncluded($f)
	{
		$status = true;
		foreach ($this->excludeList as $A) {
			if ($A == $f) {
				$status = false;
			}
		}
		return ($status);
	}

	private function hasTargetExension($f)
	{

		$status = false;
		foreach ($this->includedExtension as $A) {
			if ($A == $f) {
				$status = true;
			}
		}
		return ($status);
	}

	private function replace($fileContent)
	{
		$fileContent = preg_replace($this->regexStr, $this->contentStr, $fileContent);
		return ($fileContent);
	}

	private function logMsg($str, $type)
	{
		if ($this->logLevel >= $type) {
			echo ($str . "\n");
		}
	}

	public function setContentStr($str)
	{
		$this->contentStr = $str;
	}

	public function setRegexStr($str)
	{
		$this->regexStr = $str;
	}

	public function setExcludeList($arr)
	{
		$this->excludeList = $arr;
	}

	public function setIncludedExtension($arr)
	{
		$this->includedExtension = $arr;
	}
}
