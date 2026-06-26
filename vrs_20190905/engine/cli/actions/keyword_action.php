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
self::$ActionTable['add']['keyword']		= function (&$a) { return array("INSERT INTO " . $a['sqlTables']['keyword']		. " (" . $a['columns'] . ") VALUES (" . $a['values'] . ");"); };
self::$ActionTable['update']['keyword']		= function (&$a) { return array("UPDATE " . $a['sqlTables']['keyword']			. " SET " . $a['equalities'] . " WHERE keyword_id = '"		. $a['params']['keyword_id'] . "';"); };
self::$ActionTable['disable']['keyword']	= function (&$a) { return array("UPDATE " . $a['sqlTables']['keyword']			. " SET keyword_state=0		WHERE keyword_id = '"		. $a['params']['id'] . "';"); };
self::$ActionTable['delete']['keyword']		= function (&$a) { return array("UPDATE " . $a['sqlTables']['keyword']			. " SET keyword_state=2		WHERE keyword_id = '"		. $a['params']['id'] . "';"); };
//@formatter:on

self::$ActionTable['show']['keywords'] = function (&$a) {
	return array(
		"SELECT "
		. "ws.ws_name AS 'Website', "
		. "art.arti_name AS 'Article', "
		. "kw.keyword_name AS 'Name', "
		. "kw.keyword_string AS 'Needle', "
		. "kw.keyword_count AS 'Count', "
		. "kw.keyword_type AS 'Type', "
		. "kw.keyword_state AS 'State' "
		. "FROM "
		. $a['sqlTables']['keyword'] . " kw, "
		. $a['sqlTables']['article'] . " art, "
		. $a['sqlTables']['website'] . " ws "
		. "WHERE kw.fk_ws_id = " . $a['Context']['ws_id'] . " "
		. "AND kw.keyword_state = '1' "
		. "AND kw.fk_arti_id = art.arti_id "
		. "AND kw.fk_ws_id = ws.ws_id "
		. "ORDER BY kw.keyword_name"
	);
};

?>