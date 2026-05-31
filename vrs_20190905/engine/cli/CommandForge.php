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

class CommandForge {
	private static $Instance = null;
	
	private function __construct(){}
	
	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new CommandForge();
		}
		return self::$Instance;
	}
	
	public function forge($data) {
		$bts = BaseToolSet::getInstance();
		$error = FALSE;
		if (strlen ( $data ['command'] ) == 0) { $error = TRUE; }
		if (strlen ( $data ['type'] ) == 0) { $error = TRUE; }
		if (strlen ( $data ['name'] ) == 0) { $error = TRUE; }

		if ($error == FALSE) {
			$RenderingCommandLine = $data ['command'] . " " . $data ['type'] . "name \"" . $data ['name'] . "\" ";
			foreach ( $data ['arguments'] as $A => $B ) {
				if (strlen ( $B ) > 0) {
					$RenderingCommandLine .= $A . " \"" . $B . "\" ";
				}
			}
			return $RenderingCommandLine;
		} else {
			$bts->LMObj = LogManagement::getInstance();
			//Logging 
		}
	}
}

?>