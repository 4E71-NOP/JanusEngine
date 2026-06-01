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
//	Layout_file
//--------------------------------------------------------------------------------
//@formatter:off
self::$ActionTable['add']['layout_file']		= function (&$a) { return array("INSERT INTO " . $a['sqlTables']['layout_file']	. " (" . $a['columns'] . ") VALUES (" . $a['values'] . ");"); };
self::$ActionTable['update']['layout_file']		= function (&$a) { return array("UPDATE " . $a['sqlTables']['layout_file']		. " SET " . $a['equalities'] . " WHERE layout_file_id = '"	. $a['params']['layout_file_id'] . "';"); };
self::$ActionTable['disable']['layout_file']	= function (&$a) { return array("UPDATE " . $a['sqlTables']['layout_file']		. " SET layout_file_state=0	WHERE layout_file_id = '"	. $a['params']['id'] . "';"); };
self::$ActionTable['delete']['layout_file']		= function (&$a) { return array("UPDATE " . $a['sqlTables']['layout_file']		. " SET layout_file_state=2	WHERE layout_file_id = '"	. $a['params']['id'] . "';"); };
//@formatter:on

?>

