<?php
//--------------------------------------------------------------------------------
//	Article_config
//--------------------------------------------------------------------------------
//@formatter:off
self::$ActionTable['add']['article_config']		= function (&$a) { return array("INSERT INTO "	. $a['sqlTables']['article_config']	. " (" . $a['columns'] . ") VALUES (" . $a['values'] . ");"); };
self::$ActionTable['update']['article_config']	= function (&$a) { return array("UPDATE " 		. $a['sqlTables']['article_config'] . " SET " . $a['equalities'] . " WHERE config_id = '" . $a['params']['config_id'] . "';"); };
self::$ActionTable['disable']['article_config']	= function (&$a) { return array("UPDATE "		. $a['sqlTables']['article_config']	. " SET config_state=0		WHERE config_id = '"		. $a['params']['id'] . "';"); };
self::$ActionTable['delete']['article_config']	= function (&$a) { return array("UPDATE "		. $a['sqlTables']['article_config'] . " SET config_state=2		WHERE config_id = '"		. $a['params']['id'] . "';"); };
//@formatter:on

?>