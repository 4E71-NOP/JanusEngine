<?php
//--------------------------------------------------------------------------------
//	tag
//--------------------------------------------------------------------------------
//@formatter:off
self::$ActionTable['add']['tag']		= function (&$a) { return array("INSERT INTO "	. $a['sqlTables']['tag']		. " (" . $a['columns'] . ") VALUES (" . $a['values']	. ");"); };
self::$ActionTable['update']['tag']		= function (&$a) { return array("UPDATE "		. $a['sqlTables']['tag']		. " SET " . $a['equalities'] . " WHERE tag_id = '"		. $a['params']['tag_id'] . "';"); };
self::$ActionTable['disable']['tag']	= function (&$a) { return array("UPDATE "		. $a['sqlTables']['tag']		. " SET tag_state=0			WHERE tag_id = '"			. $a['params']['id'] . "';"); };
self::$ActionTable['delete']['tag']		= function (&$a) { return array("UPDATE "		. $a['sqlTables']['tag']		. " SET tag_state=2			WHERE tag_id = '"			. $a['params']['id'] . "';"); };
self::$ActionTable['assign']['tag']		= function (&$a) { return array("INSERT INTO " . $a['sqlTables']['article_tag']	. " (" . $a['columns'] . ") VALUES (" . $a['values'] . ");"); };
//@formatter:on

?>