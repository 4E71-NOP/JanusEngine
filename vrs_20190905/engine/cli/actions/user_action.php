<?php
//--------------------------------------------------------------------------------
//	user
//--------------------------------------------------------------------------------
self::$ActionTable['add']['user'] = function (&$a) {
	$queries = array();
	$b = 1;
	$c = 1;
	$queries[] = "INSERT INTO " . $a['sqlTables']['user'] . " (" . $a['columns'] . ") VALUES (" . $a['values'] . ");";
	if ($a['params']['name'] != "anonymous") {
		$queries[] = "INSERT INTO " . $a['sqlTables']['group_user'] . " VALUES ('" . ($a['params']['group_user_id'] + $b) . "','" . $a['params']['reader_id'] . "','" . $a['params']['id'] . "','1');";
		$b++;
		$c = 0;
	}
	$queries[] = "INSERT INTO " . $a['sqlTables']['group_user'] . " VALUES ('" . ($a['params']['group_user_id'] + $b) . "','" . $a['params']['anonymous_id'] . "','" . $a['params']['id'] . "','" . $c . "');";

	return $queries;
};

self::$ActionTable['update']['user'] = function (&$a) {
	$queries[] = "UPDATE " . $a['sqlTables']['user'] . " SET " . $a['equalities'] . " WHERE user_id = '" . $a['params']['user_id'] . "';";

	$bts = BaseToolSet::getInstance();
	$bts->InitClass('MiscTools');

	$tab = $bts->MiscTools->makeInfosConfigList('user', 'adr_', '');
	foreach ($tab as $IC) {
		if (strlen($a['params'][$IC['info_field']] ?? '') > 0) {
			$queries[] = "UPDATE " . $a['sqlTables']['infos'] . " "
				. "SET "
				. "info_string = '" . $a['params'][$IC['info_field']] . "', "
				. "info_number = " . $a['params'][$IC['info_field']] . " "
				. "WHERE fk_infcfg_section = 'user' "
				. "AND info_ref_obj = " . $a['params']['user_id'] . " "
				. "AND info_field = " . $IC['info_field']
				. ";";
		}
	}

	return $queries;
};

self::$ActionTable['disable']['user'] = function (&$a) {
	return array("UPDATE " . $a['sqlTables']['user'] . " SET user_state=0		WHERE user_id = '" . $a['params']['id'] . "';"); };

self::$ActionTable['delete']['user'] = function (&$a) {
	return array("UPDATE " . $a['sqlTables']['user'] . " SET user_state=2		WHERE user_id = '" . $a['params']['id'] . "';"); };

self::$ActionTable['assign']['user'] = function (&$a) {
	$queries = array();
	if ($a['params']['primary_group'] == 1) {
		$queries[] = "UPDATE " . $a['sqlTables']['group_user'] . " SET group_user_initial_group = '0' WHERE fk_user_id = '" . $a['params']['user_id'] . "';";
	}
	$queries[] = "INSERT INTO " . $a['sqlTables']['group_user'] . " VALUES ('" . $a['params']['group_user_id'] . "','" . $a['params']['group_id'] . "','" . $a['params']['user_id'] . "','" . $a['params']['primary_group'] . "');";
	return $queries;
};

self::$ActionTable['show']['users'] = function (&$a) {
	return array(
		"SELECT "
		. "usr.user_name AS 'Name', "
		. "usr.user_login AS 'Login', "
		. "FROM_UNIXTIME(usr.user_subscription_date) AS 'Subscription', "
		. "usr.user_status AS 'Status', "
		. "usr.user_name AS 'Name', "
		. "FROM_UNIXTIME(usr.user_last_visit) AS 'Last visit', "
		. "usr.user_last_ip AS 'Last IP' "
		. "FROM "
		. $a['sqlTables']['user'] . " usr,"
		. $a['sqlTables']['group_user'] . " gu,"
		. $a['sqlTables']['group_website'] . " gw "
		. "WHERE usr.user_id = gu.fk_user_id "
		. "AND gu.fk_group_id = gw.fk_group_id "
		. "AND gw.fk_ws_id = '" . $a['Context']['ws_id'] . "' "
		. "GROUP BY usr.user_id"
	);
};

self::$ActionTable['show']['user'] = function (&$a) {
	return array(
		"SELECT "
		. "usr.user_id, usr.user_name, usr.user_login, usr.user_mail, usr.user_subscription_date, "
		. "usr.user_status, usr.user_role_function, usr.user_pref_theme, usr.user_lang, usr.user_avatar_image, "
		. "usr.user_admin_comment, usr.user_last_visit, usr.user_last_ip, usr.user_timezone "
		. "FROM "
		. $a['sqlTables']['user'] . " usr,"
		. $a['sqlTables']['group_user'] . " gu,"
		. $a['sqlTables']['group_website'] . " gw "
		. "WHERE usr.user_id = gu.fk_user_id "
		. "AND gu.fk_group_id = gw.fk_group_id "
		. "AND gw.fk_ws_id = '" . $a['Context']['ws_id'] . "' "
		. (strlen($a['params']['name'] > 0) ? "AND usr.user_name = '" . $a['params']['name'] . "' " : "")
		. (strlen($a['params']['login'] > 0) ? "AND usr.user_login = '" . $a['params']['login'] . "' " : "")
		. (strlen($a['params']['mail'] > 0) ? "AND usr.user_mail = '" . $a['params']['mail'] . "' " : "")
		. "GROUP BY usr.user_id"
	);
};

?>