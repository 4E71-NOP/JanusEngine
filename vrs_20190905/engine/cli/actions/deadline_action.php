<?php
//--------------------------------------------------------------------------------
//	Deadline
//--------------------------------------------------------------------------------
//@formatter:off
self::$ActionTable['add']['deadline']		= function (&$a) { return array("INSERT INTO "	. $a['sqlTables']['deadline']	. " (" . $a['columns'] . ") VALUES (" . $a['values'] . ");"); };
self::$ActionTable['update']['deadline']	= function (&$a) { return array("UPDATE "		. $a['sqlTables']['deadline']	. " SET " . $a['equalities'] . " WHERE deadline_id = '" . $a['params']['deadline_id'] . "';"); };
self::$ActionTable['disable']['deadline']	= function (&$a) { return array("UPDATE "		. $a['sqlTables']['deadline']	. " SET deadline_state=0 	WHERE deadline_id = '"		. $a['params']['id'] . "';"); };
self::$ActionTable['delete']['deadline']	= function (&$a) { return array("UPDATE "		. $a['sqlTables']['deadline']	. " SET deadline_state=2 	WHERE deadline_id = '"		. $a['params']['id'] . "';"); };
//@formatter:on

self::$ActionTable['show']['deadlines']	= function (&$a) { return array(
		"SELECT "
			. "deadline_name AS 'Name', "
			. "deadline_title AS 'Title', "
			. "deadline_state AS 'State', "
			. "FROM_UNIXTIME(deadline_creation_date) AS 'Creation', "
			. "FROM_UNIXTIME(deadline_end_date) AS 'End' "
			. "FROM "
			. $a['sqlTables']['deadline'] . " dl "
			. "WHERE dl.fk_ws_id = '" . $a['Context']['ws_id'] . "' "
			. "ORDER BY dl.deadline_name;"
	); 
};

self::$ActionTable['show']['deadline']	= function (&$a) { return array(
		"SELECT "
			. "deadline_name AS 'Name', "
			. "deadline_title AS 'Title', "
			. "deadline_state AS 'State', "
			. "FROM_UNIXTIME(deadline_creation_date) AS 'Creation', "
			. "FROM_UNIXTIME(deadline_end_date) AS 'End' "
			. "FROM "
			. $a['sqlTables']['deadline'] . " dl "
			. "WHERE dl.fk_ws_id = '" . $a['Context']['ws_id'] . "' "
			. (strlen($a['params']['name'] > 0) ? "AND dl.deadline_name = '" . $a['params']['name'] . "' " : "")
			. (strlen($a['params']['title'] > 0) ? "AND dl.deadline_title = '" . $a['params']['title'] . "' " : "")
			. "ORDER BY dl.deadline_name;"
	); 
};

?>