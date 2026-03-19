<?php
//--------------------------------------------------------------------------------
//	Add
//--------------------------------------------------------------------------------
self::$ActionTable['assign']['layout']		= function (&$a) {
	$queries = array();
	if ($a['params']['default'] == 1) {
		$queries[] = "UPDATE " . $a['sqlTables']['layout_theme'] . " SET default_layout_content = '0' WHERE fk_theme_id = '" . $a['params']['theme_id'] . "';";
	}
	$queries[] = "INSERT INTO " . $a['sqlTables']['layout_theme'] . " VALUES ('" . $a['params']['layout_theme_id'] . "','" . $a['params']['theme_id'] . "','" . $a['params']['layout_id'] . "','" . $a['params']['default'] . "');";
	return $queries; 
};

?>

