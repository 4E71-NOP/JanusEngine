<?php
 // // @JanusEngine:license-start
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



class FileContent {
	private static $Instance = null;
	private $fileContent = null;

	public function __construct() {}
	
	/**
	 * Singleton : Will return the instance of this class.
	 * @return FileContent
	 */
	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new FileContent ();
		}
		return self::$Instance;
	}
	
   	//@formatter:off
    public function getFileContent (){return ($this->fileContent); }
    public function setFileContent ($data){$this->fileContent = $data; }
	//@formatter:on



}
?>
