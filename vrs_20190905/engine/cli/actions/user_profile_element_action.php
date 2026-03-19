<?php
//--------------------------------------------------------------------------------
//	profile_element
//--------------------------------------------------------------------------------
//@formatter:off
self::$ActionTable['add']['user_profile_element']	= function (&$a) { return array("INSERT INTO " . $a['sqlTables']['user_profile_element'] . " (" . $a['columns'] . ") VALUES (" . $a['values'] . ");"); };
self::$ActionTable['delete']['user_profile_element']	= function (&$a) { return array("UPDATE " . $a['sqlTables']['user_profile_element']	. " SET upe_state=0			WHERE upe_id = '"			. $a['params']['id'] . "';"); };
//@formatter:on

?>