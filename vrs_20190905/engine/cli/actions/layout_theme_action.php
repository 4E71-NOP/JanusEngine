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
//	Add
//--------------------------------------------------------------------------------
self::$ActionTable['assign']['layout']		= function (&$a) {
	$queries = array();
	if ($a['params']['default'] == 1) {
		$queries[] = "UPDATE " . $a['sqlTables']['layout_theme'] . " SET default_layout_content = '0' WHERE fk_theme_id = " . $a['params']['theme_id'] . ";";
	}
	$queries[] = "INSERT INTO " . $a['sqlTables']['layout_theme'] . " (" . $a['columns'] . ") VALUES (" . $a['params']['layout_theme_id'] . ", " . $a['params']['theme_id'] . ", " . $a['params']['layout_id'] . ", " . $a['params']['default'] . ");";
	return $queries; 
};

?>

