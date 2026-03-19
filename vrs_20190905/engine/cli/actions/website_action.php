<?php
//--------------------------------------------------------------------------------
//	
//--------------------------------------------------------------------------------
self::$ActionTable['add']['website'] = function (&$a) {
	$CurrentSetObj = CurrentSet::getInstance();
	$CurrentSetObj->setDataSubEntry('install', 'websitePostCreation', 1);
	return array("INSERT INTO " . $a['sqlTables']['website'] . " (" . $a['columns'] . ") VALUES (" . $a['values'] . ");");
};

self::$ActionTable['update']['website'] = function (&$a) {
	$queries = array();
	if ($a['params']['updateGO'] == 1) {
		$queries[] = "UPDATE " . $a['sqlTables']['website'] . " SET " . $a['equalities'] . " WHERE ws_id = '" . $a['params']['ws_id'] . "';";
	}

	return $queries;
};

self::$ActionTable['disable']['website'] = function (&$a) {
	return array("UPDATE " . $a['sqlTables']['website'] . " SET ws_state=0			WHERE ws_id = '" . $a['params']['id'] . "';"); };

self::$ActionTable['delete']['website'] = function (&$a) {
	return array("UPDATE " . $a['sqlTables']['website'] . " SET ws_state=2			WHERE ws_id = '" . $a['params']['id'] . "';"); };

self::$ActionTable['show']['websites'] = function (&$a) {
	return array(
		"SELECT " .
		"ws_name AS 'Name', "
		. "ws_directory AS 'Directory' "
		. "FROM "
		. $a['sqlTables']['website'] . " "
		. "ORDER BY ws_id;"
	);
};

self::$ActionTable['website']['context'] = function (&$a) {
	$CurrentSetObj = CurrentSet::getInstance();
	$CurrentSetObj->setWebSiteContextObj(new WebSite());
	$CurrentSetObj->WebSiteContextObj->changeWebSiteContext($a['params']['ws_id']);
	return 0;
};

