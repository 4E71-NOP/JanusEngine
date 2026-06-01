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
//	Article_config
//--------------------------------------------------------------------------------
//@formatter:off
self::$ActionTable['add']['article_config']		= function (&$a) { return array("INSERT INTO "	. $a['sqlTables']['article_config']	. " (" . $a['columns'] . ") VALUES (" . $a['values'] . ");"); };
self::$ActionTable['update']['article_config']	= function (&$a) { return array("UPDATE " 		. $a['sqlTables']['article_config'] . " SET " . $a['equalities'] . " WHERE config_id = '" . $a['params']['config_id'] . "';"); };
self::$ActionTable['disable']['article_config']	= function (&$a) { return array("UPDATE "		. $a['sqlTables']['article_config']	. " SET config_state=0		WHERE config_id = '"		. $a['params']['id'] . "';"); };
self::$ActionTable['delete']['article_config']	= function (&$a) { return array("UPDATE "		. $a['sqlTables']['article_config'] . " SET config_state=2		WHERE config_id = '"		. $a['params']['id'] . "';"); };
//@formatter:on

?>