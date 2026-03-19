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

// Document
self::$CheckTable['add']['document']['0']['d']	= _FIND_DUPLICATE_;
self::$CheckTable['add']['document']['0']['f']	= function ($a) {return array("SELECT docu_id,docu_name FROM " . $a['sqlTables']['document'] . " WHERE docu_name = '" . $a['params']['name'] . "';");};
self::$CheckTable['add']['document']['0']['m']	= "CLI_Document_C001";
self::$CheckTable['add']['document']['0']['s']	= "name";
self::$CheckTable['add']['document']['1']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['add']['document']['1']['f']	= function ($a) {return array("SELECT usr.user_login,usr.user_id  FROM " . $a['sqlTables']['user'] . " usr , " . $a['sqlTables']['group_user'] . " gu , " . $a['sqlTables']['group_website'] . " sg WHERE usr.user_login = '" . $a['params']['creator'] . "' AND usr.user_id = gu.fk_user_id AND gu.fk_group_id = sg.fk_group_id AND gu.group_user_initial_group = '1' AND sg.fk_ws_id = '" . $a['Context']['ws_id'] . "';");};
self::$CheckTable['add']['document']['1']['c']	= "user_id";
self::$CheckTable['add']['document']['1']['v']	= "creator_user_id";
self::$CheckTable['add']['document']['1']['m']	= "CLI_Document_C002";
self::$CheckTable['add']['document']['1']['p']	= "user";
self::$CheckTable['add']['document']['1']['s']	= "creator";
self::$CheckTable['add']['document']['2']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['add']['document']['2']['f']	= function ($a) {return array("SELECT usr.user_login,usr.user_id  FROM " . $a['sqlTables']['user'] . " usr , " . $a['sqlTables']['group_user'] . " gu , " . $a['sqlTables']['group_website'] . " sg WHERE usr.user_login = '" . $a['params']['validator'] . "' AND usr.user_id = gu.fk_user_id AND gu.fk_group_id = sg.fk_group_id AND sg.fk_ws_id = '" . $a['Context']['ws_id'] . "';");};
self::$CheckTable['add']['document']['2']['c']	= "user_id";
self::$CheckTable['add']['document']['2']['v']	= "validator_user_id";
self::$CheckTable['add']['document']['2']['m']	= "CLI_Document_C003";
self::$CheckTable['add']['document']['2']['p']	= "user";
self::$CheckTable['add']['document']['2']['s']	= "validator";


self::$CheckTable['update']['document']['0']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['update']['document']['0']['f']	= function ($a) {return array("SELECT docu_id,docu_name FROM " . $a['sqlTables']['document'] . " WHERE docu_name = '" . $a['params']['name'] . "';");};
self::$CheckTable['update']['document']['0']['c']	= "docu_id";
self::$CheckTable['update']['document']['0']['v']	= "docu_id";
self::$CheckTable['update']['document']['0']['m']	= "CLI_Document_U001";
self::$CheckTable['update']['document']['0']['p']	= "document";
self::$CheckTable['update']['document']['0']['s']	= "name";
self::$CheckTable['update']['document']['1']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['update']['document']['1']['f']	= function ($a) {return array("SELECT usr.user_login,usr.user_id  FROM " . $a['sqlTables']['user'] . " usr , " . $a['sqlTables']['group_user'] . " gu , " . $a['sqlTables']['group_website'] . " sg WHERE usr.user_login = '" . $a['params']['validator'] . "' AND usr.user_id = gu.fk_user_id AND gu.fk_group_id = sg.fk_group_id AND sg.fk_ws_id = '" . $a['Context']['ws_id'] . "';");};
self::$CheckTable['update']['document']['1']['c']	= "user_id";
self::$CheckTable['update']['document']['1']['v']	= "validator_user_id";
self::$CheckTable['update']['document']['1']['m']	= "CLI_Document_U002";
self::$CheckTable['update']['document']['1']['p']	= "user";
self::$CheckTable['update']['document']['1']['s']	= "validator";


self::$CheckTable['delete']['document']['0']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['delete']['document']['0']['f']	= function ($a) {return array("SELECT docu_id,docu_name FROM " . $a['sqlTables']['document'] . " WHERE docu_name = '" . $a['params']['name'] . "';");};
self::$CheckTable['delete']['document']['0']['c'] = "group_id";
self::$CheckTable['delete']['document']['0']['v'] = "group_id";
self::$CheckTable['delete']['document']['0']['m'] = "CLI_Document_D001";
self::$CheckTable['delete']['document']['0']['p'] = "document";
self::$CheckTable['delete']['document']['0']['s'] = "name";


self::$CheckTable['share']['document']['0']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['share']['document']['0']['f']	= function ($a) {return array("SELECT docu_id,docu_name FROM " . $a['sqlTables']['document'] . " WHERE docu_name = '" . $a['params']['name'] . "';");};
self::$CheckTable['share']['document']['0']['c'] 	= "docu_id";
self::$CheckTable['share']['document']['0']['v'] 	= "docu_id";
self::$CheckTable['share']['document']['0']['m'] 	= "CLI_ShareDocument_S001";
self::$CheckTable['share']['document']['0']['p'] 	= "document";
self::$CheckTable['share']['document']['0']['s'] 	= "name";
self::$CheckTable['share']['document']['1']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['share']['document']['1']['f']	= function ($a) {return array("SELECT ws_id,ws_name FROM " . $a['sqlTables']['website'] . " WHERE ws_name = '" . $a['params']['with_website'] . "';");};
self::$CheckTable['share']['document']['1']['c'] 	= "ws_id";
self::$CheckTable['share']['document']['1']['v'] 	= "ws_id";
self::$CheckTable['share']['document']['1']['m'] 	= "CLI_ShareDocument_S002";
self::$CheckTable['share']['document']['1']['p'] 	= "website";
self::$CheckTable['share']['document']['1']['s'] 	= "with_website";
self::$CheckTable['share']['document']['2']['d'] 	= 3;
self::$CheckTable['share']['document']['2']['f'] 	= function ($a) {return array("SELECT share_id FROM " . $a['sqlTables']['document_share'] . " WHERE fk_ws_id = '" . $a['params']['ws_id'] . "' AND fk_docu_id = '" . $a['params']['docu_id'] . "';");};
self::$CheckTable['share']['document']['2']['m'] 	= "CLI_ShareDocument_S003";
self::$CheckTable['share']['document']['2']['s'] 	= "docu_id";


self::$CheckTable['assign']['document']['0']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['assign']['document']['0']['f']	= function ($a) {return array("SELECT docu_id,docu_name FROM " . $a['sqlTables']['document'] . " WHERE docu_name = '" . $a['params']['name'] . "';");};
self::$CheckTable['assign']['document']['0']['c'] 	= "docu_id";
self::$CheckTable['assign']['document']['0']['v'] 	= "docu_id";
self::$CheckTable['assign']['document']['0']['m'] 	= "CLI_AssignDocument_A001";
self::$CheckTable['assign']['document']['0']['p'] 	= "document";
self::$CheckTable['assign']['document']['0']['s'] 	= "name";
self::$CheckTable['assign']['document']['1']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['assign']['document']['1']['f']	= function ($a) {return array("SELECT arti_id,arti_name FROM " . $a['sqlTables']['article'] . " WHERE arti_name = '" . $a['params']['to_article'] . "' AND fk_ws_id = '" . $a['Context']['ws_id'] . "';");};
self::$CheckTable['assign']['document']['1']['c']	= "arti_id";
self::$CheckTable['assign']['document']['1']['v']	= "arti_id";
self::$CheckTable['assign']['document']['1']['m']	= "CLI_AssignDocument_A002";
self::$CheckTable['assign']['document']['1']['p']	= "article";
self::$CheckTable['assign']['document']['1']['s']	= "to_article";



// Content (for document)
self::$CheckTable['insert']['content']['0']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['insert']['content']['0']['f']	= function ($a) {return array("SELECT docu_id,docu_name FROM " . $a['sqlTables']['document'] . " WHERE docu_name = '" . $a['params']['into'] . "';");};
self::$CheckTable['insert']['content']['0']['c']	= "docu_id";
self::$CheckTable['insert']['content']['0']['v']	= "docu_id";
self::$CheckTable['insert']['content']['0']['m']	= "CLI_InsertContent_I001";
self::$CheckTable['insert']['content']['0']['p']	= "content";
self::$CheckTable['insert']['content']['0']['s']	= "into";
self::$CheckTable['insert']['content']['1']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['insert']['content']['1']['f']	= function ($a) {return array("SELECT usr.user_id AS user_id, usr.user_login AS user_login FROM " . $a['sqlTables']['user'] . " usr, " . $a['sqlTables']['group_user'] . " gu, " . $a['sqlTables']['group_website'] . " sg WHERE usr.user_login = '" . $a['params']['creator'] . "' AND usr.user_id = gu.fk_user_id AND gu.fk_group_id = sg.fk_group_id AND gu.group_user_initial_group = '1' AND sg.fk_ws_id = '" . $a['Context']['ws_id'] . "';");};
self::$CheckTable['insert']['content']['1']['c']	= "user_id";
self::$CheckTable['insert']['content']['1']['v']	= "creator_id";
self::$CheckTable['insert']['content']['1']['m']	= "CLI_InsertContent_I002";
self::$CheckTable['insert']['content']['1']['p']	= "user";
self::$CheckTable['insert']['content']['1']['s']	= "creator";
self::$CheckTable['insert']['content']['2']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['insert']['content']['2']['f']	= function ($a) {return array("SELECT usr.user_id AS user_id, usr.user_login AS user_login FROM " . $a['sqlTables']['user'] . " usr, " . $a['sqlTables']['group_user'] . " gu, " . $a['sqlTables']['group_website'] . " sg WHERE usr.user_login = '" . $a['params']['validator'] . "' AND usr.user_id = gu.fk_user_id AND gu.fk_group_id = sg.fk_group_id AND gu.group_user_initial_group = '1' AND sg.fk_ws_id = '" . $a['Context']['ws_id'] . "';");};
self::$CheckTable['insert']['content']['2']['c']	= "user_id";
self::$CheckTable['insert']['content']['2']['v']	= "validator_id";
self::$CheckTable['insert']['content']['2']['m']	= "CLI_InsertContent_I003";
self::$CheckTable['insert']['content']['2']['p']	= "user";
self::$CheckTable['insert']['content']['2']['s']	= "validator";
self::$CheckTable['insert']['content']['3']['d'] 	= _EXECUTE_FUNCTION_;
self::$CheckTable['insert']['content']['3']['f'] 	= function ($a) {
	$bts = BaseToolSet::getInstance();
	// $bts->LMObj->setVectorSystemLogLevel(LOGLEVEL_STATEMENT);
	switch ($bts->CMObj->getConfigurationEntry("execution_context")) {
		case "render":
			break;
		case "installation":
			$a['params']['file'] = "websites-data/" . $a['Context']['ws_directory'] . "/document/" . $a['params']['file'];
			break;
		// case "extension_installation":
		// 	$a['params']['file'] = "extensions/" . $a['Context']['ws_directory'] . "/_installation/document/" . $a['params']['file'];
		// 	break;
	}
	// $bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " Processing file : '" . $a['params']['file'] . "'."));
	$ret = 0;
	if (file_exists($a['params']['file'])) {
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " file : '" . $a['params']['file'] . "' exists."));
		$ret = 1;		// Signal is the minimum required.
	} else {
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_ERROR, 'msg' => __METHOD__ . " ***ERROR*** file : '" . $a['params']['file'] . "' not found."));
	}
	// $bts->LMObj->restoreVectorSystemLogLevel();

	return $ret;};
self::$CheckTable['insert']['content']['2']['m']	= "CLI_InsertContent_I004";
self::$CheckTable['insert']['content']['3']['p']	= "file";
self::$CheckTable['insert']['content']['3']['s']	= "file";

?>