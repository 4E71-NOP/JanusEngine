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
self::$ActionTable['add']['layout']			= function (&$a) { return array("INSERT INTO "	. $a['sqlTables']['layout']		. " (" . $a['columns'] . ") VALUES (" . $a['values'] . ");"); };
self::$ActionTable['update']['layout']		= function (&$a) { return array("UPDATE "		. $a['sqlTables']['layout']		. " SET " . $a['equalities'] . " WHERE layout_id = '"	. $a['params']['layout_id'] . "';"); };
self::$ActionTable['disable']['layout']		= function (&$a) { return array("UPDATE "		. $a['sqlTables']['layout']		. " SET layout_state=0 WHERE layout_id = '"				. $a['params']['id'] . "';"); };
self::$ActionTable['delete']['layout']		= function (&$a) { return array("UPDATE "		. $a['sqlTables']['layout']		. " SET layout_state=2 WHERE layout_id = '"				. $a['params']['id'] . "';"); };
//@formatter:on

?>

