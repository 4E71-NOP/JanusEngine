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

// Group
self::$CheckTable['add']['group']['0']['d'] = _FIND_DUPLICATE_;
self::$CheckTable['add']['group']['0']['f'] = function ($a) {return array("SELECT grp.group_id FROM " . $a['sqlTables']['group'] . " grp , " . $a['sqlTables']['group_website'] . " sg , " . $a['sqlTables']['website'] . " ws WHERE grp.group_name = '" . $a['params']['name'] . "' AND grp.group_id = sg.fk_group_id AND sg.fk_ws_id = ws.ws_id AND ws.ws_id = '" . $a['Context']['ws_id'] . "';");};
self::$CheckTable['add']['group']['0']['m'] = "CLI_group_C001";
self::$CheckTable['add']['group']['0']['s'] = "name";

self::$CheckTable['add']['group']['1']['d'] = _RETURN__DATA_AND_ERROR_;
self::$CheckTable['add']['group']['1']['f'] = function ($a) {
	if ($a['params']['parent'] != 'origin') {
		return array("SELECT grp.group_id FROM " . $a['sqlTables']['group'] . " grp , " . $a['sqlTables']['group_website'] . " sg , " . $a['sqlTables']['website'] . " ws WHERE grp.group_name = '" . $a['params']['parent'] . "' AND grp.group_id = sg.fk_group_id AND sg.fk_ws_id = ws.ws_id AND ws.ws_id = '" . $a['Context']['ws_id'] . "';");
	} else {
		return -1;
	}};
self::$CheckTable['add']['group']['1']['c'] = "group_id";
self::$CheckTable['add']['group']['1']['v'] = "group_parent";
self::$CheckTable['add']['group']['1']['m'] = "CLI_group_C002";
self::$CheckTable['add']['group']['1']['p'] = "parent";
self::$CheckTable['add']['group']['1']['s'] = "parent";

self::$CheckTable['update']['group']['0']['d'] = _RETURN__DATA_AND_ERROR_;
self::$CheckTable['update']['group']['0']['f'] = function ($a) {return array("SELECT grp.group_id FROM " . $a['sqlTables']['group'] . " grp , " . $a['sqlTables']['group_website'] . " sg , " . $a['sqlTables']['website'] . " ws WHERE grp.group_name = '" . $a['params']['name'] . "' AND grp.group_id = sg.fk_group_id AND sg.fk_ws_id = ws.ws_id AND ws.ws_id = '" . $a['Context']['ws_id'] . "';");};
self::$CheckTable['update']['group']['0']['c'] = "group_id";
self::$CheckTable['update']['group']['0']['v'] = "group_id";
self::$CheckTable['update']['group']['0']['m'] = "CLI_group_U001";
self::$CheckTable['update']['group']['0']['p'] = "group";
self::$CheckTable['update']['group']['0']['s'] = "name";

self::$CheckTable['update']['group']['1']['d'] = _RETURN__DATA_AND_ERROR_;
self::$CheckTable['update']['group']['1']['f'] = function ($a) {return array("SELECT grp.group_id FROM " . $a['sqlTables']['group'] . " grp , " . $a['sqlTables']['group_website'] . " sg , " . $a['sqlTables']['website'] . " ws WHERE grp.group_name = '" . $a['params']['name'] . "' AND grp.group_id = sg.fk_group_id AND sg.fk_ws_id = ws.ws_id AND ws.ws_id = '" . $a['Context']['ws_id'] . "';");};
self::$CheckTable['update']['group']['1']['c'] = "group_id";
self::$CheckTable['update']['group']['1']['v'] = "group_id_Parent";
self::$CheckTable['update']['group']['1']['m'] = "CLI_group_U002";
self::$CheckTable['update']['group']['1']['s'] = "name";

self::$CheckTable['delete']['group']['0']['d'] = _RETURN__DATA_AND_ERROR_;
self::$CheckTable['delete']['group']['0']['f'] = function ($a) {return array("SELECT grp.group_id FROM " . $a['sqlTables']['group'] . " grp , " . $a['sqlTables']['group_website'] . " sg , " . $a['sqlTables']['website'] . " ws WHERE grp.group_name = '" . $a['params']['name'] . "' AND grp.group_id = sg.fk_group_id AND sg.fk_ws_id = ws.ws_id AND ws.ws_id = '" . $a['Context']['ws_id'] . "';");};
self::$CheckTable['delete']['group']['0']['c'] = "group_id";
self::$CheckTable['delete']['group']['0']['v'] = "group_id";
self::$CheckTable['delete']['group']['0']['m'] = "CLI_group_D001";
self::$CheckTable['delete']['group']['0']['p'] = "group";
self::$CheckTable['delete']['group']['0']['s'] = "name";

?>