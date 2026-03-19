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


// Article
self::$CheckTable['add']['article']['0']['d']	= _FIND_DUPLICATE_;
self::$CheckTable['add']['article']['0']['f']	= function ($a) {return array("SELECT arti_id,arti_name FROM " . $a['sqlTables']['article'] . " WHERE arti_name = '" . $a['params']['name'] . "' AND fk_ws_id = '" . $a['Context']['ws_id'] . "';");};
self::$CheckTable['add']['article']['0']['m']	= "CLI_Article_C001";
self::$CheckTable['add']['article']['0']['s']	= "name";
self::$CheckTable['add']['article']['1']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['add']['article']['1']['f']	= function ($a) {return array("SELECT deadline_id FROM " . $a['sqlTables']['deadline'] . " WHERE deadline_name = '" . $a['params']['deadline'] . "' AND fk_ws_id = '" . $a['Context']['ws_id'] . "';");};
self::$CheckTable['add']['article']['1']['c']	= "deadline_id";
self::$CheckTable['add']['article']['1']['v']	= "deadline_id";
self::$CheckTable['add']['article']['1']['m']	= "CLI_Article_C002";
self::$CheckTable['add']['article']['1']['p']	= "deadline";
self::$CheckTable['add']['article']['1']['s']	= "deadline";
self::$CheckTable['add']['article']['2']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['add']['article']['2']['f']	= function ($a) {return array("SELECT config_id FROM " . $a['sqlTables']['article_config'] . " WHERE config_name = '" . $a['params']['config'] . "' AND fk_ws_id = '" . $a['Context']['ws_id'] . "';");};
self::$CheckTable['add']['article']['2']['c']	= "config_id";
self::$CheckTable['add']['article']['2']['v']	= "config_id";
self::$CheckTable['add']['article']['2']['m']	= "CLI_Article_C003";
self::$CheckTable['add']['article']['2']['p']	= "config";
self::$CheckTable['add']['article']['2']['s']	= "config";
self::$CheckTable['add']['article']['3']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['add']['article']['3']['f']	= function ($a) {
	if (strlen($a['params']['creator']) == 0) {
		$a['params']['creator'] = $a['curent_user'];
	}
	return array("SELECT usr.user_id AS user_id, usr.user_login AS user_login FROM " . $a['sqlTables']['user'] . " usr, " . $a['sqlTables']['group_user'] . " gu, " . $a['sqlTables']['group_website'] . " sg WHERE usr.user_login = '" . $a['params']['creator'] . "' AND usr.user_id = gu.fk_user_id AND gu.fk_group_id = sg.fk_group_id AND gu.group_user_initial_group = '1' AND sg.fk_ws_id = '" . $a['Context']['ws_id'] . "';");};
self::$CheckTable['add']['article']['3']['c']	= "user_id";
self::$CheckTable['add']['article']['3']['v']	= "user_id_creator";
self::$CheckTable['add']['article']['3']['m']	= "CLI_Article_C004";
self::$CheckTable['add']['article']['3']['p']	= "user";
self::$CheckTable['add']['article']['3']['s']	= "creator";
self::$CheckTable['add']['article']['4']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['add']['article']['4']['f']	= function ($a) {
	if (strlen($a['params']['validator']) == 0) {
		$a['params']['validator'] = $a['current_user'];
	}
	return array("SELECT usr.user_id AS user_id, usr.user_login AS user_login FROM " . $a['sqlTables']['user'] . " usr, " . $a['sqlTables']['group_user'] . " gu, " . $a['sqlTables']['group_website'] . " sg WHERE usr.user_login = '" . $a['params']['validator'] . "' AND usr.user_id = gu.fk_user_id AND gu.fk_group_id = sg.fk_group_id AND gu.group_user_initial_group = '1' AND sg.fk_ws_id = '" . $a['Context']['ws_id'] . "';");};
self::$CheckTable['add']['article']['4']['c']	= "user_id";
self::$CheckTable['add']['article']['4']['v']	= "user_id_validator";
self::$CheckTable['add']['article']['4']['m']	= "CLI_Article_C005";
self::$CheckTable['add']['article']['4']['p']	= "user";
self::$CheckTable['add']['article']['4']['s']	= "validator";

self::$CheckTable['update']['article']['0']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['update']['article']['0']['f']	= function ($a) {return array("SELECT arti_id,arti_name FROM " . $a['sqlTables']['article'] . " WHERE arti_name = '" . $a['params']['name'] . "' AND fk_ws_id = '" . $a['Context']['ws_id'] . "';");};
self::$CheckTable['update']['article']['0']['c']	= "arti_id";
self::$CheckTable['update']['article']['0']['v']	= "arti_id";
self::$CheckTable['update']['article']['0']['m']	= "CLI_Article_U001";
self::$CheckTable['update']['article']['0']['p']	= "article";
self::$CheckTable['update']['article']['0']['s']	= "name";
self::$CheckTable['update']['article']['1']['d']	= _RETURN_DATA_ONLY_;
self::$CheckTable['update']['article']['1']['f']	= function ($a) {return array("SELECT deadline_id FROM " . $a['sqlTables']['deadline'] . " WHERE deadline_name = '" . $a['params']['deadline'] . "' AND fk_ws_id = '" . $a['Context']['ws_id'] . "';");};
self::$CheckTable['update']['article']['1']['c']	= "deadline_id";
self::$CheckTable['update']['article']['1']['v']	= "deadline_id";
self::$CheckTable['update']['article']['1']['m']	= "CLI_Article_U002";
self::$CheckTable['update']['article']['1']['p']	= "deadline";
self::$CheckTable['update']['article']['1']['s']	= "deadline";
self::$CheckTable['update']['article']['2']['d']	= _RETURN_DATA_ONLY_;
self::$CheckTable['update']['article']['2']['f']	= function ($a) {return array("SELECT config_id FROM " . $a['sqlTables']['article_config'] . " WHERE config_name = '" . $a['params']['config'] . "' AND fk_ws_id = '" . $a['Context']['ws_id'] . "';");};
self::$CheckTable['update']['article']['2']['c']	= "config_id";
self::$CheckTable['update']['article']['2']['v']	= "config_id";
self::$CheckTable['update']['article']['2']['m']	= "CLI_Article_C003";
self::$CheckTable['update']['article']['2']['p']	= "config";
self::$CheckTable['update']['article']['2']['s']	= "config";

self::$CheckTable['delete']['article']['0']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['delete']['article']['0']['f']	= function ($a) {return array("SELECT arti_id,arti_name FROM " . $a['sqlTables']['article'] . " WHERE arti_name = '" . $a['params']['name'] . "' AND fk_ws_id = '" . $a['Context']['ws_id'] . "';");};
self::$CheckTable['delete']['article']['0']['c']	= "arti_id";
self::$CheckTable['delete']['article']['0']['v']	= "arti_id";
self::$CheckTable['delete']['article']['0']['m']	= "CLI_Article_D001";
self::$CheckTable['delete']['article']['0']['p']	= "article";
self::$CheckTable['delete']['article']['0']['s']	= "name";

self::$CheckTable['link']['article']['0']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['link']['article']['0']['f']	= function ($a) {return array("SELECT arti_id,arti_name FROM " . $a['sqlTables']['article'] . " WHERE arti_name = '" . $a['params']['name'] . "' AND fk_ws_id = '" . $a['Context']['ws_id'] . "';");};
self::$CheckTable['link']['article']['0']['c']	= "arti_id";
self::$CheckTable['link']['article']['0']['v']	= "arti_id";
self::$CheckTable['link']['article']['0']['m']	= "CLI_Article_L001";
self::$CheckTable['link']['article']['0']['p']	= "article";
self::$CheckTable['link']['article']['0']['s']	= "name";
self::$CheckTable['link']['article']['1']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['link']['article']['1']['f']	= function ($a) {return array("SELECT doc.docu_id AS docu_id, doc.docu_name AS docu_name FROM " . $a['sqlTables']['document'] . " doc , " . $a['sqlTables']['document_share'] . " dp WHERE doc.docu_name = '" . $a['document'] . "' AND dp.fk_docu_id = doc.fk_docu_id AND dp.fk_ws_id = '" . $a['Context']['ws_id'] . "';");};
self::$CheckTable['link']['article']['1']['c']	= "docu_id";
self::$CheckTable['link']['article']['1']['v']	= "docu_id";
self::$CheckTable['link']['article']['1']['m']	= "CLI_Article_L002";
self::$CheckTable['link']['article']['1']['p']	= "document";
self::$CheckTable['link']['article']['1']['s']	= "name";

?>