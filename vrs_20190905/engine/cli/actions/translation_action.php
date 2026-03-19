<?php
//--------------------------------------------------------------------------------
//	Add
//--------------------------------------------------------------------------------
//@formatter:off
self::$ActionTable['add']['translation']		= function (&$a) { return array("INSERT INTO "	. $a['sqlTables']['i18n']			. " (" . $a['columns'] . ") VALUES (" . $a['values'] . ");"); };
self::$ActionTable['update']['translation']		= function (&$a) { return array("UPDATE "		. $a['sqlTables']['translation']	. " SET " . $a['equalities'] . " WHERE translation_id = '"	. $a['params']['translation_id'] . "';"); };
self::$ActionTable['disable']['translation']	= function (&$a) { return array("UPDATE "		. $a['sqlTables']['translation']	. " SET translation_state=0	WHERE translation_id = '"	. $a['params']['id'] . "';"); };
self::$ActionTable['delete']['translation']		= function (&$a) { return array("UPDATE "		. $a['sqlTables']['translation']	. " SET translation_state=2	WHERE translation_id = '"	. $a['params']['id'] . "';"); };
//@formatter:on

?>