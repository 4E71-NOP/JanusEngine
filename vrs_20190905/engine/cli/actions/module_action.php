<?php
//--------------------------------------------------------------------------------
//	module
//--------------------------------------------------------------------------------
self::$ActionTable['add']['module'] = function (&$a) { return array(
		"INSERT INTO " . $a['sqlTables']['module'] . " (" . $a['columns'] . ") VALUES (" . $a['values'] . ");",
		"INSERT INTO " . $a['sqlTables']['module_website'] . " VALUES ('" . $a['params']['module_website_id'] . "', '" . $a['Context']['ws_id'] . "', '" . $a['params']['id'] . "', '" . $a['params']['state'] . "', '" . $a['params']['position'] . "' );"
	); 
};
//@formatter:off
self::$ActionTable['update']['module']				= function (&$a) { return array("UPDATE " . $a['sqlTables']['module']			. " SET " . $a['equalities'] . " WHERE module_id = '"		. $a['params']['module_id'] . "';"); };
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
			. "WHERE mw.fk_ws_id = '" . $a['Context']['ws_id'] . "' "
			. "AND m.module_id = mw.fk_module_id "
			. "AND m.fk_perm_id = p.perm_id "
			. "ORDER BY m.module_name, mw.module_position;"
	); 
};

?>