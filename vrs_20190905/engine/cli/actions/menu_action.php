<?php
//--------------------------------------------------------------------------------
//	menu
//--------------------------------------------------------------------------------
//@formatter:off
self::$ActionTable['add']['menu']		= function (&$a) { return array("INSERT INTO " . $a['sqlTables']['menu']	. " (" . $a['columns'] . ") VALUES (" . $a['values'] . ");"); };
self::$ActionTable['update']['menu']	= function (&$a) { return array("UPDATE " . $a['sqlTables']['menu']			. " SET " . $a['equalities'] . " WHERE menu_id = '"		. $a['params']['menu_id'] . "';"); };
self::$ActionTable['disable']['menu']	= function (&$a) { return array("UPDATE " . $a['sqlTables']['menu']			. " SET menu_state=0		WHERE menu_id = '"			. $a['params']['id'] . "';"); };
self::$ActionTable['delete']['menu']	= function (&$a) { return array("UPDATE " . $a['sqlTables']['menu']			. " SET menu_state=2		WHERE menu_id = '"			. $a['params']['id'] . "';"); };
//@formatter:on

self::$ActionTable['show']['menus']	= function (&$a) { return array(
		"SELECT "
			. "m.menu_name AS 'Name', "
			. "m.menu_title AS 'Title', "
			. "m.menu_desc AS 'Desc', "
			. "dl.deadline_name AS 'Deadline', "
			. "(SELECT m1.menu_name FROM " . $a['sqlTables']['menu'] . " m1 WHERE m1.menu_id = m.menu_parent) AS 'Parent', "
			. "m.menu_position AS 'Pos', "
			. "m.menu_visibility AS 'Visibility', "
			. "perm.perm_name AS 'Permission', "
			. "m.fk_arti_slug AS 'Slug', "
			. "m.fk_arti_ref AS 'Ref article', "
			. "CONCAT(lang.lang_original_name, ' (', lang.lang_639_3, ')') AS 'Language' "
			. "FROM "
			. $a['sqlTables']['menu'] . " m, "
			. $a['sqlTables']['language_website'] . " lw, "
			. $a['sqlTables']['language'] . " lang, "
			. $a['sqlTables']['deadline'] . " dl, "
			. $a['sqlTables']['permission'] . " perm "
			. "WHERE m.menu_type IN (0, 1) "
			. "AND m.menu_state = '1' "
			. "AND m.fk_lang_id = lw.fk_lang_id "
			. "AND lw.fk_ws_id = m.fk_ws_id "
			. "AND lw.fk_lang_id = lang.lang_id "
			. "AND m.fk_deadline_id = dl.deadline_id "
			. "AND m.fk_perm_id = perm.perm_id "
			. "AND m.fk_ws_id = '" . $a['Context']['ws_id'] . "' "
			. "ORDER BY m.fk_lang_id, m.menu_parent, m.menu_position "
	); 
};

?>