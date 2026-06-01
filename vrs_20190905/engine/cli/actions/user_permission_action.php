<?php
// @JanusEngine:license-start
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

//--------------------------------------------------------------------------------
//	user
//--------------------------------------------------------------------------------
self::$ActionTable['assign']['user_permission']		= function (&$a) {
	if (strtolower($a['params']['to_all_users']) == "yes") {
		$queries = array();
		foreach ($a['params']['allIds'] as $B) {
			$queries[] = "INSERT INTO " . $a['sqlTables']['user_permission'] . " (" . $a['columns'] . ") VALUES (" . $B['uid'] . ", " . $a['params']['perm_id'] . ", " . $B['user_id'] . " );";
		}
		return $queries;
	} else {
		return array("INSERT INTO " . $a['sqlTables']['user_permission'] . " (" . $a['columns'] . ") VALUES (" . $a['values'] . ");");
	} 
};

?>