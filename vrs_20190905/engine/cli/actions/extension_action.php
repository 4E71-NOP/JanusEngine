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
//@formatter:off
self::$ActionTable['add']['extension']		= function (&$a) { return array("INSERT INTO " . $a['sqlTables']['extension']		. " (" . $a['columns'] . ") VALUES (" . $a['values'] . ");"); };

self::$ActionTable['delete']['extension'] = function (&$a) { 
	$queries[] = "DELETE FROM " . $a['sqlTables']['extension']				. " WHERE ext_id = '"		. $a['params']['fk_ext_id'] . "';";
	$queries[] = "DELETE FROM " . $a['sqlTables']['extension_file']			. " WHERE fk_ext_id = '"	. $a['params']['fk_ext_id'] . "';";
	$queries[] = "DELETE FROM " . $a['sqlTables']['extension_config']		. " WHERE fk_ext_id = '"	. $a['params']['fk_ext_id'] . "';";
	$queries[] = "DELETE FROM " . $a['sqlTables']['extension_dependency']	. " WHERE fk_ext_id = '"	. $a['params']['fk_ext_id'] . "';";
	return $queries;
};
//@formatter:on

?>