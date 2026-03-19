<?php
//--------------------------------------------------------------------------------
//	
//--------------------------------------------------------------------------------
self::$ActionTable['add']['theme']			= function (&$a) { return array(
	"INSERT INTO " . $a['sqlTables']['theme_descriptor'] . " (" . $a['columns'] . ") VALUES (" . $a['values'] . ");",
	"INSERT INTO " . $a['sqlTables']['theme_website'] . " (theme_website_id, fk_ws_id, fk_theme_id, theme_state) VALUES ('" . $a['params']['theme_website_id'] . "','" . $a['Context']['ws_id'] . "','" . $a['params']['id'] . "','" . $a['params']['state'] . "');"
	); 
	};
//@formatter:off
self::$ActionTable['update']['theme']		= function (&$a) { return array("UPDATE " . $a['sqlTables']['theme_descriptor']		. " SET " . $a['equalities'] . " WHERE theme_id = '"	. $a['params']['theme_id'] . "';"); };
self::$ActionTable['disable']['theme']		= function (&$a) { return array("UPDATE " . $a['sqlTables']['theme']				. " SET theme_state=0		WHERE theme_id = '"			. $a['params']['id'] . "';"); };
self::$ActionTable['delete']['theme']		= function (&$a) { return array("UPDATE " . $a['sqlTables']['theme']				. " SET theme_state=2		WHERE theme_id = '"			. $a['params']['id'] . "';"); };
self::$ActionTable['assign']['theme']		= function (&$a) { return array("UPDATE " . $a['sqlTables']['website']				. " SET fk_theme_id = '" . $a['params']['theme_id'] . "' WHERE ws_id = '" . $a['params']['ws_id'] . "';"); };
//@formatter:on

?>