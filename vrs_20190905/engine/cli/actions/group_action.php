<?php
//--------------------------------------------------------------------------------
//	Group
//--------------------------------------------------------------------------------
//@formatter:off
self::$ActionTable['add']['group'] = function (&$a) { return array(
		"INSERT INTO " . $a['sqlTables']['group'] . " (" . $a['columns'] . ") VALUES (" . $a['values'] . ");",
		"INSERT INTO " . $a['sqlTables']['group_website'] . " VALUES ('" . $a['params']['group_webws_id'] . "', '" . $a['Context']['ws_id'] . "', '" . $a['params']['id'] . "', '1' );"
	); 
};

self::$ActionTable['update']['group']	= function (&$a) { return array("UPDATE " . $a['sqlTables']['group']	. " SET " . $a['equalities'] . " WHERE group_id = '"	. $a['params']['group_id'] . "';"); };
self::$ActionTable['disable']['group']	= function (&$a) { return array("UPDATE " . $a['sqlTables']['group']	. " SET group_state=0		WHERE group_id = '"			. $a['params']['id'] . "';"); };
self::$ActionTable['delete']['group']	= function (&$a) { return array("UPDATE " . $a['sqlTables']['group']	. " SET group_state=2		WHERE group_id = '"			. $a['params']['id'] . "';"); };

self::$ActionTable['show']['groups']	= function (&$a) { return array(
		"SELECT "
			. "grp.group_name AS 'Name', "
			. "grp.group_title 'Title', "
			. "grp.group_desc 'Description' "
			. "FROM "
			. $a['sqlTables']['group'] . " grp, "
			. $a['sqlTables']['group_website'] . " wg "
			. "WHERE wg.fk_ws_id = '" . $a['Context']['ws_id'] . "' "
			. "AND grp.group_id = wg.fk_group_id "
			. "AND grp.group_name != 'Server_owner' "
			. "ORDER BY grp.group_name;"
	); 
};

?>