<?php

// d=Directive
//		Directive = 1 : _RETURN_DATA_ONLY_			/ Return the data in (v)ariable. No error message.
//		Directive = 2 : _RETURN__DATA_AND_ERROR_	/ Return the data in (v)ariable. If an error occurs, a message is stored and a flag is set.
//		Directive = 3 : _FIND_DUPLICATE_			/ Test if a duplicate exists. If 1 line is returned it raises an error/flag.
// f=Function
// c=Column
// v=Variable name (destination in $a['params'])
// m=Message Code -> CLI_<entity>_<operation>xxx.
// p=parameter name (for error message)
// s=search parameter used in SQL to find an element
//
// return -1 means "non applicable".
// Always returns an array to support multiple operations.
//

// User
self::$CheckTable['add']['user']['0']['d']	= _FIND_DUPLICATE_;
self::$CheckTable['add']['user']['0']['f']	= function ($a) {return array("SELECT usr.user_id AS user_id, usr.user_login AS user_login FROM " . $a['sqlTables']['user'] . " usr, " . $a['sqlTables']['group_user'] . " gu, " . $a['sqlTables']['group_website'] . " sg WHERE usr.user_login = '" . $a['params']['name'] . "' AND usr.user_id = gu.fk_user_id AND gu.fk_group_id = sg.fk_group_id AND gu.group_user_initial_group = '1' AND sg.fk_ws_id = '" . $a['Context']['ws_id'] . "';");};
self::$CheckTable['add']['user']['0']['m']	= "CLI_User_C001";
self::$CheckTable['add']['user']['0']['s']	= "name";
self::$CheckTable['add']['user']['1']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['add']['user']['1']['f']	= function ($a) {return array("SELECT grp.group_id FROM " . $a['sqlTables']['group'] . " grp , " . $a['sqlTables']['group_website'] . " sg , " . $a['sqlTables']['website'] . " ws WHERE grp.group_name = 'Reader' AND grp.group_id = sg.fk_group_id AND sg.fk_ws_id = ws.ws_id AND ws.ws_id = '" . $a['Context']['ws_id'] . "';");};
self::$CheckTable['add']['user']['1']['c']	= "group_id";
self::$CheckTable['add']['user']['1']['v']	= "reader_id";
self::$CheckTable['add']['user']['1']['m']	= "CLI_User_C002";
self::$CheckTable['add']['user']['1']['p']	= "group";
self::$CheckTable['add']['user']['1']['s']	= "null";
self::$CheckTable['add']['user']['2']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['add']['user']['2']['f']	= function ($a) {return array("SELECT grp.group_id FROM " . $a['sqlTables']['group'] . " grp , " . $a['sqlTables']['group_website'] . " sg , " . $a['sqlTables']['website'] . " ws WHERE grp.group_name = 'Anonymous' AND grp.group_id = sg.fk_group_id AND sg.fk_ws_id = ws.ws_id AND ws.ws_id = '" . $a['Context']['ws_id'] . "';");};
self::$CheckTable['add']['user']['2']['c']	= "group_id";
self::$CheckTable['add']['user']['2']['v']	= "anonymous_id";
self::$CheckTable['add']['user']['2']['m']	= "CLI_User_C003";
self::$CheckTable['add']['user']['2']['p']	= "group";
self::$CheckTable['add']['user']['2']['s']	= "null";


self::$CheckTable['update']['user']				= self::$CheckTable['add']['user'];		// It's a copy not a reference!
self::$CheckTable['update']['user']['0']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['update']['user']['0']['c']	= "user_id";
self::$CheckTable['update']['user']['0']['v']	= "user_id";
self::$CheckTable['update']['user']['0']['m']	= "CLI_User_U001";

self::$CheckTable['update']['user']['1']['m']	= "CLI_User_U002";
self::$CheckTable['update']['user']['2']['p']	= "user";
self::$CheckTable['update']['user']['2']['m']	= "CLI_User_U003";

self::$CheckTable['update']['user']['3']['d']	= _RETURN_DATA_ONLY_;
self::$CheckTable['update']['user']['3']['f']	= function ($a) {return array("SELECT t.theme_id, t.theme_name FROM " . $a['sqlTables']['theme_descriptor'] . " t, " . $a['sqlTables']['theme_website'] . " st WHERE t.theme_name = '" . $a['params']['pref_theme'] . "' AND t.theme_id = st.fk_theme_id AND st.theme_state = '1' AND st.fk_ws_id = '" . $a['Context']['ws_id'] . "';");};
self::$CheckTable['update']['user']['3']['c']	= "theme_id";
self::$CheckTable['update']['user']['3']['v']	= "pref_theme_id";
self::$CheckTable['update']['user']['3']['m']	= "CLI_User_U004";
self::$CheckTable['update']['user']['3']['p']	= "theme";
self::$CheckTable['update']['user']['3']['s']	= "pref_theme";

self::$CheckTable['update']['user']['4']['d']	= _RETURN_DATA_ONLY_;
self::$CheckTable['update']['user']['4']['f']	= function ($a) {
	if ($a['params']['lang'] != 0) {
		return array("SELECT lang_id FROM " . $a['sqlTables']['language'] . " WHERE lang_639_3 = '" . $a['params']['lang'] . "';");
	} else {
		return array("SELECT (0);");
	}};
self::$CheckTable['update']['user']['4']['c']	= "lang_id";
self::$CheckTable['update']['user']['4']['v']	= "lang";
self::$CheckTable['update']['user']['4']['m']	= "CLI_User_U005";
self::$CheckTable['update']['user']['4']['p']	= "language";
self::$CheckTable['update']['user']['4']['s']	= "lang";


self::$CheckTable['assign']['user']['0']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['assign']['user']['0']['f']	= function ($a) {return array("SELECT usr.user_id AS user_id, usr.user_login AS user_login FROM " . $a['sqlTables']['user'] . " usr, " . $a['sqlTables']['group_user'] . " gu, " . $a['sqlTables']['group_website'] . " sg WHERE usr.user_login = '" . $a['params']['name'] . "' AND usr.user_id = gu.fk_user_id AND gu.fk_group_id = sg.fk_group_id AND gu.group_user_initial_group = '1' AND sg.fk_ws_id = '" . $a['Context']['ws_id'] . "';");};
self::$CheckTable['assign']['user']['0']['c']	= "user_id";
self::$CheckTable['assign']['user']['0']['v']	= "user_id";
self::$CheckTable['assign']['user']['0']['m']	= "CLI_User_A001";
self::$CheckTable['assign']['user']['0']['p']	= "user";
self::$CheckTable['assign']['user']['0']['s']	= "name";
self::$CheckTable['assign']['user']['1']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['assign']['user']['1']['f']	= function ($a) {return array("SELECT grp.group_id FROM " . $a['sqlTables']['group'] . " grp , " . $a['sqlTables']['group_website'] . " sg , " . $a['sqlTables']['website'] . " ws WHERE grp.group_name = '" . $a['params']['to_group'] . "' AND grp.group_id = sg.fk_group_id AND sg.fk_ws_id = ws.ws_id AND ws.ws_id = '" . $a['Context']['ws_id'] . "';");};
self::$CheckTable['assign']['user']['1']['c']	= "group_id";
self::$CheckTable['assign']['user']['1']['v']	= "group_id";
self::$CheckTable['assign']['user']['1']['m']	= "CLI_User_A002";
self::$CheckTable['assign']['user']['1']['p']	= "group";
self::$CheckTable['assign']['user']['1']['s']	= "to_group";
self::$CheckTable['assign']['user']['2']['d']	= _FIND_DUPLICATE_;
self::$CheckTable['assign']['user']['2']['f']	= function ($a) {return array("SELECT group_user_id, fk_group_id, fk_user_id, group_user_initial_group FROM " . $a['sqlTables']['group_user'] . " WHERE fk_group_id = '" . $a['params']['group_id'] . "' AND fk_user_id = '" . $a['params']['user_id'] . "';");};
self::$CheckTable['assign']['user']['2']['c']	= "group_user_id";
self::$CheckTable['assign']['user']['2']['v']	= "group_user_id";
self::$CheckTable['assign']['user']['2']['m']	= "CLI_User_A003";
self::$CheckTable['assign']['user']['2']['p']	= "link";
self::$CheckTable['assign']['user']['2']['s']	= "user_id";

?>