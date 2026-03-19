<?php
//--------------------------------------------------------------------------------
//	Layout_file
//--------------------------------------------------------------------------------
//@formatter:off
self::$ActionTable['add']['layout_file']		= function (&$a) { return array("INSERT INTO " . $a['sqlTables']['layout_file']	. " (" . $a['columns'] . ") VALUES (" . $a['values'] . ");"); };
self::$ActionTable['update']['layout_file']		= function (&$a) { return array("UPDATE " . $a['sqlTables']['layout_file']		. " SET " . $a['equalities'] . " WHERE layout_file_id = '"	. $a['params']['layout_file_id'] . "';"); };
self::$ActionTable['disable']['layout_file']	= function (&$a) { return array("UPDATE " . $a['sqlTables']['layout_file']		. " SET layout_file_state=0	WHERE layout_file_id = '"	. $a['params']['id'] . "';"); };
self::$ActionTable['delete']['layout_file']		= function (&$a) { return array("UPDATE " . $a['sqlTables']['layout_file']		. " SET layout_file_state=2	WHERE layout_file_id = '"	. $a['params']['id'] . "';"); };
//@formatter:on

?>

