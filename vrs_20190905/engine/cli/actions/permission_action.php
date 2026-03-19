<?php
//--------------------------------------------------------------------------------
//	permission
//--------------------------------------------------------------------------------
//@formatter:off
self::$ActionTable['add']['permission']			= function (&$a) { return array("INSERT INTO "	. $a['sqlTables']['permission']	. " (" . $a['columns'] . ") VALUES (" . $a['values'] . ");" ); };
self::$ActionTable['update']['permission']		= function (&$a) { return array("UPDATE "		. $a['sqlTables']['permission']	. " SET " . $a['equalities'] . " WHERE permission_id = '"	. $a['params']['permission_id'] . "';"); };
self::$ActionTable['disable']['permission']		= function (&$a) { return array("UPDATE "		. $a['sqlTables']['permission']	. " SET permission_state=0	WHERE permission_id = '"	. $a['params']['id'] . "';"); };
self::$ActionTable['delete']['permission']		= function (&$a) { return array("UPDATE "		. $a['sqlTables']['permission']	. " SET permission_state=2	WHERE permission_id = '"	. $a['params']['id'] . "';"); };
//@formatter:on

?>