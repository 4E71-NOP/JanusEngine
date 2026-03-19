<?php
//--------------------------------------------------------------------------------
//	Add
//--------------------------------------------------------------------------------
//@formatter:off
self::$ActionTable['add']['extension']		= function (&$a) { return array("INSERT INTO " . $a['sqlTables']['extension']		. " (" . $a['columns'] . ") VALUES (" . $a['values'] . ");"); };

self::$ActionTable['delete']['extension'] = function (&$a) { 
	$queries[] = "DELETE FROM " . $a['sqlTables']['extension']				. " WHERE ext_id = '"		. $a['params']['fk_ext_id'] . "';";
	$queries[] = "DELETE FROM " . $a['sqlTables']['extension_file']			. " WHERE fk_ext_id = '"	. $a['params']['fk_ext_id'] . "';";
	$queries[] = "DELETE FROM " . $a['sqlTables']['extension_config']		. " WHERE fk_ext_id = '"	. $a['params']['fk_ext_id'] . "';";
	$queries[] = "DELETE FROM " . $a['sqlTables']['extension_dependency']	. " WHERE fk_ext_id = '"	. $a['params']['fk_ext_id'] . "';";
	return $queries;
};
//@formatter:on

?>