<?php
//--------------------------------------------------------------------------------
//	
//--------------------------------------------------------------------------------
//@formatter:off
self::$ActionTable['add']['theme_definition']		= function (&$a) { return array("INSERT INTO "	. $a['sqlTables']['theme_definition']	. " (" . $a['columns'] . ") VALUES (" . $a['values'] . ");",); };
self::$ActionTable['update']['theme_definition']	= function (&$a) { return array("UPDATE "		. $a['sqlTables']['theme_definition']	. " SET " . $a['equalities'] . " WHERE def_id = '" 			. $a['params']['def_id'] . "';"); };
//@formatter:on

?>