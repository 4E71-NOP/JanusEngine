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
//	tag
//--------------------------------------------------------------------------------
//@formatter:off
self::$ActionTable['add']['tag']		= function (&$a) { return array("INSERT INTO "	. $a['sqlTables']['tag']		. " (" . $a['columns'] . ") VALUES (" . $a['values']	. ");"); };
self::$ActionTable['update']['tag']		= function (&$a) { return array("UPDATE "		. $a['sqlTables']['tag']		. " SET " . $a['equalities'] . " WHERE tag_id = '"		. $a['params']['tag_id'] . "';"); };
self::$ActionTable['disable']['tag']	= function (&$a) { return array("UPDATE "		. $a['sqlTables']['tag']		. " SET tag_state=0			WHERE tag_id = '"			. $a['params']['id'] . "';"); };
self::$ActionTable['delete']['tag']		= function (&$a) { return array("UPDATE "		. $a['sqlTables']['tag']		. " SET tag_state=2			WHERE tag_id = '"			. $a['params']['id'] . "';"); };
self::$ActionTable['assign']['tag']		= function (&$a) { return array("INSERT INTO " . $a['sqlTables']['article_tag']	. " (" . $a['columns'] . ") VALUES (" . $a['values'] . ");"); };
//@formatter:on

?>