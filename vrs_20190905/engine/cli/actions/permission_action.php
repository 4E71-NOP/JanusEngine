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
//	permission
//--------------------------------------------------------------------------------
//@formatter:off
self::$ActionTable['add']['permission']			= function (&$a) { return array("INSERT INTO "	. $a['sqlTables']['permission']	. " (" . $a['columns'] . ") VALUES (" . $a['values'] . ");" ); };
self::$ActionTable['update']['permission']		= function (&$a) { return array("UPDATE "		. $a['sqlTables']['permission']	. " SET " . $a['equalities'] . " WHERE permission_id = '"	. $a['params']['permission_id'] . "';"); };
self::$ActionTable['disable']['permission']		= function (&$a) { return array("UPDATE "		. $a['sqlTables']['permission']	. " SET permission_state=0	WHERE permission_id = '"	. $a['params']['id'] . "';"); };
self::$ActionTable['delete']['permission']		= function (&$a) { return array("UPDATE "		. $a['sqlTables']['permission']	. " SET permission_state=2	WHERE permission_id = '"	. $a['params']['id'] . "';"); };
//@formatter:on

?>