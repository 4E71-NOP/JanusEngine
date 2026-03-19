<?php
//--------------------------------------------------------------------------------
//	Add
//--------------------------------------------------------------------------------
//@formatter:off
self::$ActionTable['add']['layout']			= function (&$a) { return array("INSERT INTO "	. $a['sqlTables']['layout']		. " (" . $a['columns'] . ") VALUES (" . $a['values'] . ");"); };
self::$ActionTable['update']['layout']		= function (&$a) { return array("UPDATE "		. $a['sqlTables']['layout']		. " SET " . $a['equalities'] . " WHERE layout_id = '"		. $a['params']['layout_id'] . "';"); };
self::$ActionTable['disable']['layout']		= function (&$a) { return array("UPDATE "		. $a['sqlTables']['layout']		. " SET layout_state=0		WHERE layout_id = '"		. $a['params']['id'] . "';"); };
self::$ActionTable['delete']['layout']		= function (&$a) { return array("UPDATE "		. $a['sqlTables']['layout']		. " SET layout_state=2		WHERE layout_id = '"		. $a['params']['id'] . "';"); };
//@formatter:on

?>

