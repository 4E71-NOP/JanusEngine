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
//	Article
//--------------------------------------------------------------------------------
//@formatter:off
self::$ActionTable['add']['article']		= function (&$a) { return array("INSERT INTO " . $a['sqlTables']['article']	. " (" . $a['columns'] . ") VALUES (" . $a['values'] . ");"); };
self::$ActionTable['update']['article']		= function (&$a) { return array("UPDATE " . $a['sqlTables']['article'] 		. " SET " . $a['equalities'] . " WHERE arti_id = '" . $a['params']['arti_id'] . "';"); };
self::$ActionTable['disable']['article']	= function (&$a) { return array("UPDATE " . $a['sqlTables']['article']		. " SET article_state=0		WHERE article_id = '"		. $a['params']['id'] . "';"); };
self::$ActionTable['delete']['article']		= function (&$a) { return array("UPDATE " . $a['sqlTables']['article']		. " SET article_state=2		WHERE article_id = '"		. $a['params']['id'] . "';"); };
//@formatter:on

self::$ActionTable['show']['articles']	= function (&$a) { return array(
		"SELECT "
			. "art.arti_ref AS 'Ref', "
			. "art.arti_id AS Id, "
			. "art.arti_name AS Name, "
			. "art.arti_title AS 'Title', "
			. "art.arti_page AS 'Page', "
			. "mnu.fk_lang_id AS 'Lang', "
			. "dl.deadline_name AS 'Deadline', "
			. "dl.deadline_title AS 'DL Title', "
			. "dl.deadline_state AS 'DL State' "
			. "FROM "
			. $a['sqlTables']['article'] . " art, "
			. $a['sqlTables']['menu'] . " mnu, "
			. $a['sqlTables']['deadline'] . " dl "
			. "WHERE mnu.fk_ws_id = '" . $a['Context']['ws_id'] . "' "
			. "AND art.arti_ref = mnu.fk_arti_ref "
			. "AND art.fk_deadline_id = dl.deadline_id "
			. "AND art.fk_ws_id = dl.fk_ws_id "
			. "AND dl.fk_ws_id = mnu.fk_ws_id "
			. "AND arti_page = 1 "
			. "AND mnu.menu_state = '1' "
			. "AND mnu.menu_type IN ('1', '0') "
			. "ORDER BY art.arti_ref, art.arti_page"
	); 
};

self::$ActionTable['show']['article']	= function (&$a) { return array(
		"SELECT "
			. "art.arti_ref AS 'Ref', "
			. "art.arti_id AS Id, "
			. "art.arti_name AS Name, "
			. "art.arti_title AS 'Title', "
			. "art.arti_page AS 'Page', "
			. "mnu.fk_lang_id AS 'Lang', "
			. "dl.deadline_name AS 'Deadline', "
			. "dl.deadline_title AS 'DL Title', "
			. "dl.deadline_state AS 'DL State' "
			. "FROM "
			. $a['sqlTables']['article'] . " art, "
			. $a['sqlTables']['menu'] . " mnu, "
			. $a['sqlTables']['deadline'] . " dl "
			. "WHERE mnu.fk_ws_id = '" . $a['Context']['ws_id'] . "' "
			. "AND art.arti_ref = mnu.fk_arti_ref "
			. "AND art.fk_deadline_id = dl.deadline_id "
			. "AND art.fk_ws_id = dl.fk_ws_id "
			. "AND dl.fk_ws_id = mnu.fk_ws_id "
			. "AND arti_page = 1 "
			. "AND mnu.menu_state = '1' "
			. "AND mnu.menu_type IN ('1', '0') "
			. (strlen($a['params']['ref'] > 0) ? "AND art.arti_ref = '" . $a['params']['ref'] . "' " : "")
			. (strlen($a['params']['name'] > 0) ? "AND art.arti_name = '" . $a['params']['name'] . "' " : "")
			. (strlen($a['params']['title'] > 0) ? "AND art.arti_title = '" . $a['params']['title'] . "' " : "")
			. (strlen($a['params']['deadline'] > 0) ? "AND dl.deadline_name = '" . $a['params']['deadline'] . "' " : "")
			. "ORDER BY art.arti_ref, art.arti_page"
	); 
};

?>