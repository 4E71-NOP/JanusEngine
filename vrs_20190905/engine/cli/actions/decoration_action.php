<?php
//--------------------------------------------------------------------------------
//	Decoration
//--------------------------------------------------------------------------------
self::$ActionTable['add']['decoration']			= function (&$a) {
	switch ($a['params']['type']) {
		//@formatter:off
		case 10:		$targetTable = "deco_10_menu";			$idv = "10_id";			break;
		case 20:		$targetTable = "deco_20_caligraph";		$idv = "20_id";			break;
		case 30:		$targetTable = "deco_30_1_div";			$idv = "30_id";			break;
		case 40:		$targetTable = "deco_40_elegance";		$idv = "40_id";			break;
		case 50:		$targetTable = "deco_50_exquisite";		$idv = "50_id";			break;
		case 60:		$targetTable = "deco_60_elysion";		$idv = "60_id";			break;
		//@formatter:on
	}

	$vl = &$a['listVars'][$a['params']['type']];
	$a['values2'] = "";
	$l = &$a['params'][$idv];

	foreach ($vl as $V) {
		if (strlen($a['params'][$V] ?? '') != 0) {
			$a['values2'] .= "('" . $l . "','" . $a['params']['id'] . "','" . $V . "','" . $a['params'][$V] . "'),";
			$l++;
		}
	}
	$a['values2'] = substr($a['values2'], 0, -1);
	$a['columns2'] = "deco_line_number, fk_deco_id, deco_variable_name, deco_value";

	return array(
		"INSERT INTO " . $a['sqlTables']['decoration'] . " (" . $a['columns'] . ") VALUES (" . $a['values'] . ");",
		"INSERT INTO " . $a['sqlTables'][$targetTable] . " (" . $a['columns2'] . ") VALUES " . $a['values2'] . ";",
	); 
};

self::$ActionTable['show']['decorations']	= function (&$a) { return array(
		"SELECT "
			. "deco_name AS 'Name', "
			. "deco_state AS 'State', "
			. "deco_type AS 'Type' "
			. "FROM "
			. $a['sqlTables']['decoration'] . " d "
			. "ORDER BY d.deco_name;"
	); 
};

self::$ActionTable['show']['decoration']	= function (&$a) { return array(
		"SELECT "
			. "deco_name AS 'Name', "
			. "deco_state AS 'State', "
			. "deco_type AS 'Type' "
			. "FROM "
			. $a['sqlTables']['decoration'] . " d "
			. "WHERE 1=1 "
			. (strlen($a['params']['name'] > 0) ? "AND d.deco_name = '" . $a['params']['name'] . "' " : "")
			. (($a['params']['type'] > 0) ? "AND d.deco_type = '" . $a['params']['type'] . "' " : "")
			. "ORDER BY d.deco_name;"
	); 
};

?>