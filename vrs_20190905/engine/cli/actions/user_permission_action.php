<?php
//--------------------------------------------------------------------------------
//	user
//--------------------------------------------------------------------------------
self::$ActionTable['assign']['user_permission']		= function (&$a) {
	if (strtolower($a['params']['to_all_users']) == "yes") {
		$queries = array();
		foreach ($a['params']['allIds'] as $B) {
			$queries[] = "INSERT INTO " . $a['sqlTables']['user_permission'] . " (" . $a['columns'] . ") VALUES (" . $B['uid'] . ", " . $a['params']['perm_id'] . ", " . $B['user_id'] . " );";
		}
		return $queries;
	} else {
		return array("INSERT INTO " . $a['sqlTables']['user_permission'] . " (" . $a['columns'] . ") VALUES (" . $a['values'] . ");");
	} 
};

?>