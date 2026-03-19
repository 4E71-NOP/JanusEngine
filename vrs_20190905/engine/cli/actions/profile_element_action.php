<?php
//--------------------------------------------------------------------------------
//	
//--------------------------------------------------------------------------------
//@formatter:off
self::$ActionTable['add']['profile_element'] = function (&$a) { return array("INSERT INTO " . $a['sqlTables']['profile_element'] . " (" . $a['columns'] . ") VALUES (" . $a['values'] . ");",	);};
//@formatter:on

?>