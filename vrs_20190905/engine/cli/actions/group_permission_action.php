<?php
//--------------------------------------------------------------------------------
//	Group
//--------------------------------------------------------------------------------
self::$ActionTable['assign']['group_permission']		= function (&$a) {
	if (strtolower($a['params']['to_all_groups']) == "yes") {
		$queries = array();
		foreach ($a['params']['allIds'] as $B) {
			$queries[] = "INSERT INTO " . $a['sqlTables']['group_permission'] . " (" . $a['columns'] . ") VALUES (" . $B['uid'] . ", " . $a['params']['perm_id'] . ", " . $B['group_id'] . " );";
		}
		return $queries;
	} else {
		return array("INSERT INTO " . $a['sqlTables']['group_permission'] . " (" . $a['columns'] . ") VALUES (" . $a['values'] . ");");
	} 
};


?>