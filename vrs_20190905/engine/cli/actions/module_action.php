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
//	module
//--------------------------------------------------------------------------------
self::$ActionTable['add']['module'] = function (&$a) { return array(
		"INSERT INTO " . $a['sqlTables']['module'] . " (" . $a['columns'] . ") VALUES (" . $a['values'] . ");",
		"INSERT INTO " . $a['sqlTables']['module_website'] . " (module_website_id, fk_ws_id, fk_module_id, module_state) VALUES (" . $a['params']['module_website_id'] . ", " . $a['Context']['ws_id'] . ", " . $a['params']['id'] . ", " . $a['params']['state'] . ");"
	); 
};
//@formatter:off
self::$ActionTable['update']['module']				= function (&$a) { return array("UPDATE " . $a['sqlTables']['module']			. " SET " . $a['equalities'] . " WHERE module_id = "		. $a['params']['module_id'] . ";"); };
//self::$ActionTable['disable']['module']				= function (&$a) { return array ("UPDATE ".$a['sqlTables']['module']					." SET module_state=0		WHERE module_id = '"		.$a['params']['id']."';"); };
//self::$ActionTable['delete']['module']					= function (&$a) { return array ("UPDATE ".$a['sqlTables']['module']					." SET module_state=2		WHERE module_id = '"		.$a['params']['id']."';"); };
//@formatter:on

self::$ActionTable['show']['modules']	= function (&$a) { return array(
		"SELECT "
			. "m.module_name AS 'Name', "
			. "m.module_title AS 'Title', "
			. "m.module_directory AS 'Dir', "
			. "m.module_file AS 'File', "
			. "m.module_desc AS 'Desc', "
			. "p.perm_name AS 'Permission'"
			. "FROM "
			. $a['sqlTables']['module'] . " m , "
			. $a['sqlTables']['module_website'] . " mw, "
			. $a['sqlTables']['permission'] . " p "
			. "WHERE mw.fk_ws_id = " . $a['Context']['ws_id'] . " "
			. "AND m.module_id = mw.fk_module_id "
			. "AND m.fk_perm_id = p.perm_id "
			. "ORDER BY m.module_name;"
	); 
};

?>