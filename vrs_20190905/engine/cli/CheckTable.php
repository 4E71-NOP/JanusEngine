<?php

// d=Directive
//		Directive = 1 : Return the data in a variable. No error message.
//		Directive = 2 : Return the data in a variable. If an error uccurs, a message is stored and a flag is set.
//		Directive = 3 : Test if a duplicate exists. If 1 line is returned it raises an error.
// f=Function
// c=Column
// v=Variable (destination)
// m=Message Code -> CLI_<entity>_<operation>xxx.
// p=parameter name (for error message)
// s=search parameter used in SQL to find an element
//
// return -1 means "non applicable".
// Always returns an array to support multiple operations.
//


// Article
self::$CheckTable['add']['article']['0']['d']	= 3;
self::$CheckTable['add']['article']['0']['f']	= function ($a) { return array ("SELECT arti_id,arti_name FROM ".$a['sqlTables']['article']." WHERE arti_name = '".$a['params']['name']."' AND fk_ws_id = '".$a['Context']['ws_id']."';");};
self::$CheckTable['add']['article']['0']['m']	= "CLI_Article_C001";
self::$CheckTable['add']['article']['0']['s']	= "name";
self::$CheckTable['add']['article']['1']['d']	= 2;
self::$CheckTable['add']['article']['1']['f']	= function ($a) { return array ("SELECT deadline_id FROM ".$a['sqlTables']['deadline']." WHERE deadline_name = '".$a['params']['deadline']."' AND fk_ws_id = '".$a['Context']['ws_id']."';");};
self::$CheckTable['add']['article']['1']['c']	= "deadline_id";
self::$CheckTable['add']['article']['1']['v']	= "deadline_id";
self::$CheckTable['add']['article']['1']['m']	= "CLI_Article_C002";
self::$CheckTable['add']['article']['1']['p']	= "deadline";
self::$CheckTable['add']['article']['1']['s']	= "deadline";
self::$CheckTable['add']['article']['2']['d']	= 2;
self::$CheckTable['add']['article']['2']['f']	= function ($a) { return array ("SELECT config_id FROM ".$a['sqlTables']['article_config']." WHERE config_name = '".$a['params']['config']."' AND fk_ws_id = '".$a['Context']['ws_id']."';");};
self::$CheckTable['add']['article']['2']['c']	= "config_id";
self::$CheckTable['add']['article']['2']['v']	= "config_id";
self::$CheckTable['add']['article']['2']['m']	= "CLI_Article_C003";
self::$CheckTable['add']['article']['2']['p']	= "config";
self::$CheckTable['add']['article']['2']['s']	= "config";
self::$CheckTable['add']['article']['3']['d']	= 2;
self::$CheckTable['add']['article']['3']['f']	= function ($a) { if ( strlen($a['params']['creator']) == 0 ) { $a['params']['creator'] = $a['curent_user']; } return array ("SELECT usr.user_id AS user_id, usr.user_login AS user_login FROM ".$a['sqlTables']['user']." usr, ".$a['sqlTables']['group_user']." gu, ".$a['sqlTables']['group_website']." sg WHERE usr.user_login = '".$a['params']['creator']."' AND usr.user_id = gu.fk_user_id AND gu.fk_group_id = sg.fk_group_id AND gu.group_user_initial_group = '1' AND sg.fk_ws_id = '".$a['Context']['ws_id']."';");};
self::$CheckTable['add']['article']['3']['c']	= "user_id";
self::$CheckTable['add']['article']['3']['v']	= "user_id_creator";
self::$CheckTable['add']['article']['3']['m']	= "CLI_Article_C004";
self::$CheckTable['add']['article']['3']['p']	= "user";
self::$CheckTable['add']['article']['3']['s']	= "creator";
self::$CheckTable['add']['article']['4']['d']	= 2;
self::$CheckTable['add']['article']['4']['f']	= function ($a) { if ( strlen($a['params']['validator']) == 0 ) { $a['params']['validator'] = $a['current_user']; } return array ("SELECT usr.user_id AS user_id, usr.user_login AS user_login FROM ".$a['sqlTables']['user']." usr, ".$a['sqlTables']['group_user']." gu, ".$a['sqlTables']['group_website']." sg WHERE usr.user_login = '".$a['params']['validator']."' AND usr.user_id = gu.fk_user_id AND gu.fk_group_id = sg.fk_group_id AND gu.group_user_initial_group = '1' AND sg.fk_ws_id = '".$a['Context']['ws_id']."';");};
self::$CheckTable['add']['article']['4']['c']	= "user_id";
self::$CheckTable['add']['article']['4']['v']	= "user_id_validator";
self::$CheckTable['add']['article']['4']['m']	= "CLI_Article_C005";
self::$CheckTable['add']['article']['4']['p']	= "user";
self::$CheckTable['add']['article']['4']['s']	= "validator";
self::$CheckTable['add']['article']['5']['d']	= 2;
self::$CheckTable['add']['article']['5']['f']	= function ($a) { return array ("SELECT p.layout_id AS layout_id, p.layout_generic_name AS layout_generic_name FROM ".$a['sqlTables']['layout']." p , ".$a['sqlTables']['layout_theme']." lt WHERE p.layout_generic_name = '".$a['params']['layout_generic_name']."' AND p.layout_id = lt.fk_layout_id AND lt.fk_theme_id = '".$a['Context']['fk_theme_id']."';");};
self::$CheckTable['add']['article']['5']['c']	= "layout_generic_name";
self::$CheckTable['add']['article']['5']['v']	= "layout_generic_name";
self::$CheckTable['add']['article']['5']['m']	= "CLI_Article_C006";
self::$CheckTable['add']['article']['5']['p']	= "layout";
self::$CheckTable['add']['article']['5']['s']	= "layout_generic_name";

self::$CheckTable['update']['article']['0']['d']	= 2;
self::$CheckTable['update']['article']['0']['f']	= function ($a) { return array ("SELECT arti_id,arti_name FROM ".$a['sqlTables']['article']." WHERE arti_name = '".$a['params']['name']."' AND fk_ws_id = '".$a['Context']['ws_id']."';");};
self::$CheckTable['update']['article']['0']['c']	= "arti_id";
self::$CheckTable['update']['article']['0']['v']	= "arti_id";
self::$CheckTable['update']['article']['0']['m']	= "CLI_Article_U001";
self::$CheckTable['update']['article']['0']['p']	= "article";
self::$CheckTable['update']['article']['0']['s']	= "name";
self::$CheckTable['update']['article']['1']['d']	= 2;
self::$CheckTable['update']['article']['1']['f']	= function ($a) { return array ("SELECT deadline_id FROM ".$a['sqlTables']['deadline']." WHERE deadline_name = '".$a['params']['deadline']."' AND fk_ws_id = '".$a['Context']['ws_id']."';");};
self::$CheckTable['update']['article']['1']['c']	= "deadline_id";
self::$CheckTable['update']['article']['1']['v']	= "deadline_id";
self::$CheckTable['update']['article']['1']['m']	= "CLI_Article_U002";
self::$CheckTable['update']['article']['1']['p']	= "deadline";
self::$CheckTable['update']['article']['1']['s']	= "deadline";
self::$CheckTable['update']['article']['2']['d']	= 2;
self::$CheckTable['update']['article']['2']['f']	= function ($a) { return array ("SELECT config_id FROM ".$a['sqlTables']['article_config']." WHERE config_name = '".$a['params']['config']."' AND fk_ws_id = '".$a['Context']['ws_id']."';");};
self::$CheckTable['update']['article']['2']['c']	= "config_id";
self::$CheckTable['update']['article']['2']['v']	= "config_id";
self::$CheckTable['update']['article']['2']['m']	= "CLI_Article_C003";
self::$CheckTable['update']['article']['2']['p']	= "config";
self::$CheckTable['update']['article']['2']['s']	= "config";
self::$CheckTable['update']['article']['3']['d']	= 2;
self::$CheckTable['update']['article']['3']['f']	= function ($a) { return array ("SELECT l.layout_id AS layout_id, l.layout_generic_name AS layout_generic_name FROM ".$a['sqlTables']['layout']." l , ".$a['sqlTables']['layout_theme']." lt WHERE layout_generic_name = '".$a['params']['layout_generic_name']."' AND l.fk_layout_id = lt.fk_layout_id AND lt.theme_id = '".$a['params']['theme_id']."';");};
self::$CheckTable['update']['article']['3']['c']	= "layout_generic_name";
self::$CheckTable['update']['article']['3']['v']	= "layout_generic_name";
self::$CheckTable['update']['article']['3']['m']	= "CLI_Article_C004";
self::$CheckTable['update']['article']['3']['p']	= "layout";
self::$CheckTable['update']['article']['3']['s']	= "layout_generic_name";

self::$CheckTable['delete']['article']['0']['d']	= 2;
self::$CheckTable['delete']['article']['0']['f']	= function ($a) { return array ("SELECT arti_id,arti_name FROM ".$a['sqlTables']['article']." WHERE arti_name = '".$a['params']['name']."' AND fk_ws_id = '".$a['Context']['ws_id']."';");};
self::$CheckTable['delete']['article']['0']['c']	= "arti_id";
self::$CheckTable['delete']['article']['0']['v']	= "arti_id";
self::$CheckTable['delete']['article']['0']['m']	= "CLI_Article_D001";
self::$CheckTable['delete']['article']['0']['p']	= "article";
self::$CheckTable['delete']['article']['0']['s']	= "name";

self::$CheckTable['link']['article']['0']['d']	= 2;
self::$CheckTable['link']['article']['0']['f']	= function ($a) { return array ("SELECT arti_id,arti_name FROM ".$a['sqlTables']['article']." WHERE arti_name = '".$a['params']['name']."' AND fk_ws_id = '".$a['Context']['ws_id']."';");};
self::$CheckTable['link']['article']['0']['c']	= "arti_id";
self::$CheckTable['link']['article']['0']['v']	= "arti_id";
self::$CheckTable['link']['article']['0']['m']	= "CLI_Article_L001";
self::$CheckTable['link']['article']['0']['p']	= "article";
self::$CheckTable['link']['article']['0']['s']	= "name";
self::$CheckTable['link']['article']['1']['d']	= 2;
self::$CheckTable['link']['article']['1']['f']	= function ($a) { return array ("SELECT doc.docu_id AS docu_id, doc.docu_name AS docu_name FROM ".$a['sqlTables']['document']." doc , ".$a['sqlTables']['document_share']." dp WHERE doc.docu_name = '".$a['document']."' AND dp.fk_docu_id = doc.fk_docu_id AND dp.fk_ws_id = '".$a['Context']['ws_id']."';");};
self::$CheckTable['link']['article']['1']['c']	= "docu_id";
self::$CheckTable['link']['article']['1']['v']	= "docu_id";
self::$CheckTable['link']['article']['1']['m']	= "CLI_Article_L002";
self::$CheckTable['link']['article']['1']['p']	= "document";
self::$CheckTable['link']['article']['1']['s']	= "name";



//Category
self::$CheckTable['add']['category']['0']['d']	= 3;
self::$CheckTable['add']['category']['0']['f']	= function ($a) { return array ("SELECT cate_id FROM ".$a['sqlTables']['category']." WHERE fk_ws_id = '".$a['Context']['ws_id']."' AND cate_name = '".$a['params']['name']."';");};
self::$CheckTable['add']['category']['0']['m']	= "CLI_Category_C001";
self::$CheckTable['add']['category']['0']['s']	= "name";
self::$CheckTable['add']['category']['1']['d']	= 1;
self::$CheckTable['add']['category']['1']['f']	= function ($a) { return array ("SELECT cate_id FROM ".$a['sqlTables']['category']." WHERE fk_ws_id = '".$a['Context']['ws_id']."' AND cate_name = '".$a['params']['parent']."';");};
self::$CheckTable['add']['category']['1']['c']	= "cate_id";
self::$CheckTable['add']['category']['1']['v']	= "parent_id";
self::$CheckTable['add']['category']['1']['m']	= "CLI_Category_C002";
self::$CheckTable['add']['category']['1']['p']	= "parent category";
self::$CheckTable['add']['category']['2']['d']	= 2;
self::$CheckTable['add']['category']['2']['f']	= function ($a) { return array ("SELECT deadline_id FROM ".$a['sqlTables']['deadline']." WHERE deadline_name = '".$a['params']['deadline']."' AND fk_ws_id = '".$a['Context']['ws_id']."';");};
self::$CheckTable['add']['category']['2']['c']	= "deadline_id";
self::$CheckTable['add']['category']['2']['v']	= "deadline_id";
self::$CheckTable['add']['category']['2']['m']	= "CLI_Category_C003";
self::$CheckTable['add']['category']['2']['p']	= "deadline";
self::$CheckTable['add']['category']['2']['s']	= "deadline";
self::$CheckTable['add']['category']['3']['d']	= 2;
self::$CheckTable['add']['category']['3']['f']	= function ($a) { return array ("SELECT grp.group_name, grp.group_id FROM ".$a['sqlTables']['group']." grp , ".$a['sqlTables']['group_website']." sg  WHERE sg.fk_ws_id = '".$a['Context']['ws_id']."' AND grp.group_name = '".$a['params']['group_name']."' AND grp.group_id = sg.fk_group_id;");};
self::$CheckTable['add']['category']['3']['c']	= "group_id";
self::$CheckTable['add']['category']['3']['v']	= "group_id";
self::$CheckTable['add']['category']['3']['m']	= "CLI_Category_C004";
self::$CheckTable['add']['category']['3']['p']	= "group";
self::$CheckTable['add']['category']['3']['s']	= "group_name";
self::$CheckTable['add']['category']['4']['d']	= 2;
self::$CheckTable['add']['category']['4']['f']	= function ($a) { return array ("SELECT lang_id FROM ".$a['sqlTables']['language']." WHERE lang_639_3 = '".$a['params']['lang']."';");};
self::$CheckTable['add']['category']['4']['c']	= "lang_id";
self::$CheckTable['add']['category']['4']['v']	= "lang_id";
self::$CheckTable['add']['category']['4']['m']	= "CLI_Category_C005";
self::$CheckTable['add']['category']['4']['p']	= "language";
self::$CheckTable['add']['category']['4']['s']	= "lang";


self::$CheckTable['update']['category']['0']['d']	= 2;
self::$CheckTable['update']['category']['0']['f']	= function ($a) { return array ("SELECT cate_id FROM ".$a['sqlTables']['category']." WHERE fk_ws_id = '".$a['Context']['ws_id']."' AND cate_name = '".$a['params']['name']."';");};
self::$CheckTable['update']['category']['0']['c']	= "cate_id";
self::$CheckTable['update']['category']['0']['v']	= "cate_id";
self::$CheckTable['update']['category']['0']['m']	= "CLI_Category_C001";
self::$CheckTable['update']['category']['0']['p']	= "category";
self::$CheckTable['update']['category']['0']['s']	= "name";


// Checkpoint
self::$CheckTable['set']['checkpoint']['0']['d']	= 4;
self::$CheckTable['set']['checkpoint']['0']['f']	= function ($a) {
	$ret = 0;
	if (strlen($a['params']['name']) > 0 ) { $ret = 1; }
	return $ret;
};
self::$CheckTable['set']['checkpoint']['0']['m']	= "CLI_SetCheckpoint_S001";



// Content (for document)
self::$CheckTable['insert']['content']['0']['d']	= 2;
self::$CheckTable['insert']['content']['0']['f']	= function ($a) { return array ("SELECT docu_id,docu_name FROM ".$a['sqlTables']['document']." WHERE docu_name = '".$a['params']['into']."';");};
self::$CheckTable['insert']['content']['0']['c']	= "docu_id";
self::$CheckTable['insert']['content']['0']['v']	= "docu_id";
self::$CheckTable['insert']['content']['0']['m']	= "CLI_InsertContent_I001";
self::$CheckTable['insert']['content']['0']['p']	= "content";
self::$CheckTable['insert']['content']['0']['s']	= "into";
self::$CheckTable['insert']['content']['1']['d']	= 2;
self::$CheckTable['insert']['content']['1']['f']	= function ($a) { return array ("SELECT usr.user_id AS user_id, usr.user_login AS user_login FROM ".$a['sqlTables']['user']." usr, ".$a['sqlTables']['group_user']." gu, ".$a['sqlTables']['group_website']." sg WHERE usr.user_login = '".$a['params']['creator']."' AND usr.user_id = gu.fk_user_id AND gu.fk_group_id = sg.fk_group_id AND gu.group_user_initial_group = '1' AND sg.fk_ws_id = '".$a['Context']['ws_id']."';");};
self::$CheckTable['insert']['content']['1']['c']	= "user_id";
self::$CheckTable['insert']['content']['1']['v']	= "creator_id";
self::$CheckTable['insert']['content']['1']['m']	= "CLI_InsertContent_I002";
self::$CheckTable['insert']['content']['1']['p']	= "user";
self::$CheckTable['insert']['content']['1']['s']	= "creator";
self::$CheckTable['insert']['content']['2']['d']	= 2;
self::$CheckTable['insert']['content']['2']['f']	= function ($a) { return array ("SELECT usr.user_id AS user_id, usr.user_login AS user_login FROM ".$a['sqlTables']['user']." usr, ".$a['sqlTables']['group_user']." gu, ".$a['sqlTables']['group_website']." sg WHERE usr.user_login = '".$a['params']['validator']."' AND usr.user_id = gu.fk_user_id AND gu.fk_group_id = sg.fk_group_id AND gu.group_user_initial_group = '1' AND sg.fk_ws_id = '".$a['Context']['ws_id']."';");};
self::$CheckTable['insert']['content']['2']['c']	= "user_id";
self::$CheckTable['insert']['content']['2']['v']	= "validator_id";
self::$CheckTable['insert']['content']['2']['m']	= "CLI_InsertContent_I003";
self::$CheckTable['insert']['content']['2']['p']	= "user";
self::$CheckTable['insert']['content']['2']['s']	= "validator";
self::$CheckTable['insert']['content']['3']['d'] 	= 4;
self::$CheckTable['insert']['content']['3']['f'] 	= function ($a) {
	$bts = BaseToolSet::getInstance();
// 	$CMObj = ConfigurationManagement::getInstance();
	switch ( $bts->CMObj->getConfigurationEntry("execution_context") ) {
		case "render" :																																			break;
		case "installation" :			$a['params']['file'] = "websites-data/".$a['Context']['ws_directory']."/document/".$a['params']['file'];				break;
		case "extension_installation":	$a['params']['file'] = "extensions/".$a['Context']['ws_directory']."/_installation/document/".$a['params']['file'];		break;
	}
	$ret = 0;
	if ( file_exists($a['params']['file']) ) { $ret = 1; } // Signal is the minimum required.
	return $ret;
};
self::$CheckTable['insert']['content']['2']['m']	= "CLI_InsertContent_I004";
self::$CheckTable['insert']['content']['3']['p']	= "file";
self::$CheckTable['insert']['content']['3']['s']	= "file";


// DeadLine
self::$CheckTable['add']['deadline']['0']['d']	= 3;
self::$CheckTable['add']['deadline']['0']['f']	= function ($a) { return array ("SELECT deadline_id FROM ".$a['sqlTables']['deadline']." WHERE deadline_name = '".$a['params']['name']."' AND fk_ws_id = '".$a['Context']['ws_id']."';");};
self::$CheckTable['add']['deadline']['0']['m']	= "CLI_Bouclage_C001";
self::$CheckTable['add']['deadline']['0']['s']	= "name";
self::$CheckTable['update']['deadline']['0']['d']	= 2;
self::$CheckTable['update']['deadline']['0']['f']	= function ($a) { return array ("SELECT deadline_id FROM ".$a['sqlTables']['deadline']." WHERE deadline_name = '".$a['params']['name']."' AND fk_ws_id = '".$a['Context']['ws_id']."';");};
self::$CheckTable['update']['deadline']['0']['c']	= "deadline_id";
self::$CheckTable['update']['deadline']['0']['v']	= "deadline_id";
self::$CheckTable['update']['deadline']['0']['m']	= "CLI_Bouclage_U001";
self::$CheckTable['update']['deadline']['0']['p']	= "deadline";
self::$CheckTable['update']['deadline']['0']['s']	= "name";
self::$CheckTable['delete']['deadline']['0']['d']	= 2;
self::$CheckTable['delete']['deadline']['0']['f']	= function ($a) { return array ("SELECT deadline_id FROM ".$a['sqlTables']['deadline']." WHERE deadline_name = '".$a['params']['name']."' AND fk_ws_id = '".$a['Context']['ws_id']."';");};
self::$CheckTable['delete']['deadline']['0']['c']	= "deadline_id";
self::$CheckTable['delete']['deadline']['0']['v']	= "deadline_id";
self::$CheckTable['delete']['deadline']['0']['m']	= "CLI_Bouclage_U001";
self::$CheckTable['delete']['deadline']['0']['p']	= "deadline";
self::$CheckTable['delete']['deadline']['0']['s']	= "name";


//Décoration
self::$CheckTable['add']['decoration']['0']['d']	= 3;
self::$CheckTable['add']['decoration']['0']['f']	= function ($a) { return array ("SELECT deco_name FROM ".$a['sqlTables']['decoration']." WHERE deco_name = '".$a['params']['name']."';");};
self::$CheckTable['add']['decoration']['0']['m']	= "CLI_Decoration_C001";
self::$CheckTable['add']['decoration']['0']['s']	= "name";


// Article_config
self::$CheckTable['add']['document_config']['0']['d']	= 3;
self::$CheckTable['add']['document_config']['0']['f']	= function ($a) { return array ("SELECT config_id FROM ".$a['sqlTables']['article_config']." WHERE config_name = '".$a['params']['name']."' AND fk_ws_id = '".$a['Context']['ws_id']."';");};
self::$CheckTable['add']['document_config']['0']['m']	= "CLI_ArticleConfig_C001";
self::$CheckTable['add']['document_config']['0']['s']	= "name";


// Document
self::$CheckTable['add']['document']['0']['d']	= 3;
self::$CheckTable['add']['document']['0']['f']	= function ($a) { return array ("SELECT docu_id,docu_name FROM ".$a['sqlTables']['document']." WHERE docu_name = '".$a['params']['name']."';");};
self::$CheckTable['add']['document']['0']['m']	= "CLI_Document_C001";
self::$CheckTable['add']['document']['0']['s']	= "name";
self::$CheckTable['add']['document']['1']['d']	= 2;
self::$CheckTable['add']['document']['1']['f']	= function ($a) { return array ("SELECT usr.user_login,usr.user_id  FROM ".$a['sqlTables']['user']." usr , ".$a['sqlTables']['group_user']." gu , ".$a['sqlTables']['group_website']." sg WHERE usr.user_login = '".$a['params']['creator']."' AND usr.user_id = gu.fk_user_id AND gu.fk_group_id = sg.fk_group_id AND gu.group_user_initial_group = '1' AND sg.fk_ws_id = '".$a['Context']['ws_id']."';");};
self::$CheckTable['add']['document']['1']['c']	= "user_id";
self::$CheckTable['add']['document']['1']['v']	= "creator_user_id";
self::$CheckTable['add']['document']['1']['m']	= "CLI_Document_C002";
self::$CheckTable['add']['document']['1']['p']	= "user";
self::$CheckTable['add']['document']['1']['s']	= "creator";
self::$CheckTable['add']['document']['2']['d']	= 2;
self::$CheckTable['add']['document']['2']['f']	= function ($a) { return array ("SELECT usr.user_login,usr.user_id  FROM ".$a['sqlTables']['user']." usr , ".$a['sqlTables']['group_user']." gu , ".$a['sqlTables']['group_website']." sg WHERE usr.user_login = '".$a['params']['validator']."' AND usr.user_id = gu.fk_user_id AND gu.fk_group_id = sg.fk_group_id AND sg.fk_ws_id = '".$a['Context']['ws_id']."';");};
self::$CheckTable['add']['document']['2']['c']	= "user_id";
self::$CheckTable['add']['document']['2']['v']	= "validator_user_id";
self::$CheckTable['add']['document']['2']['m']	= "CLI_Document_C003";
self::$CheckTable['add']['document']['2']['p']	= "user";
self::$CheckTable['add']['document']['2']['s']	= "validator";


self::$CheckTable['update']['document']['0']['d']	= 2;
self::$CheckTable['update']['document']['0']['f']	= function ($a) { return array ("SELECT docu_id,docu_name FROM ".$a['sqlTables']['document']." WHERE docu_name = '".$a['params']['name']."';");};
self::$CheckTable['update']['document']['0']['c'] = "docu_id";
self::$CheckTable['update']['document']['0']['v'] = "docu_id";
self::$CheckTable['update']['document']['0']['m'] = "CLI_Document_U001";
self::$CheckTable['update']['document']['0']['p'] = "document";
self::$CheckTable['update']['document']['0']['s'] = "name";
self::$CheckTable['update']['document']['1']['d']	= 2;
self::$CheckTable['update']['document']['1']['f']	= function ($a) { return array ("SELECT usr.user_login,usr.user_id  FROM ".$a['sqlTables']['user']." usr , ".$a['sqlTables']['group_user']." gu , ".$a['sqlTables']['group_website']." sg WHERE usr.user_login = '".$a['params']['validator']."' AND usr.user_id = gu.fk_user_id AND gu.fk_group_id = sg.fk_group_id AND sg.fk_ws_id = '".$a['Context']['ws_id']."';");};
self::$CheckTable['update']['document']['1']['c']	= "validator_user_id";
self::$CheckTable['update']['document']['1']['v']	= "validator_user_id";
self::$CheckTable['update']['document']['1']['m']	= "CLI_Document_U003";
self::$CheckTable['update']['document']['1']['p']	= "user";
self::$CheckTable['update']['document']['1']['s']	= "validator";


self::$CheckTable['delete']['document']['0']['d']	= 2;
self::$CheckTable['delete']['document']['0']['f']	= function ($a) { return array ("SELECT docu_id,docu_name FROM ".$a['sqlTables']['document']." WHERE docu_name = '".$a['params']['name']."';");};
self::$CheckTable['delete']['document']['0']['c'] = "group_id";
self::$CheckTable['delete']['document']['0']['v'] = "group_id";
self::$CheckTable['delete']['document']['0']['m'] = "CLI_Document_U001";
self::$CheckTable['delete']['document']['0']['p'] = "document";
self::$CheckTable['delete']['document']['0']['s'] = "name";


self::$CheckTable['share']['document']['0']['d']	= 2;
self::$CheckTable['share']['document']['0']['f']	= function ($a) { return array ("SELECT docu_id,docu_name FROM ".$a['sqlTables']['document']." WHERE docu_name = '".$a['params']['name']."';");};
self::$CheckTable['share']['document']['0']['c'] 	= "docu_id";
self::$CheckTable['share']['document']['0']['v'] 	= "docu_id";
self::$CheckTable['share']['document']['0']['m'] 	= "CLI_ShareDocument_S001";
self::$CheckTable['share']['document']['0']['p'] 	= "document";
self::$CheckTable['share']['document']['0']['s'] 	= "name";
self::$CheckTable['share']['document']['1']['d']	= 2;
self::$CheckTable['share']['document']['1']['f']	= function ($a) { return array ("SELECT ws_id,ws_name FROM ".$a['sqlTables']['website']." WHERE ws_name = '".$a['params']['with_website']."';");};
self::$CheckTable['share']['document']['1']['c'] 	= "ws_id";
self::$CheckTable['share']['document']['1']['v'] 	= "ws_id";
self::$CheckTable['share']['document']['1']['m'] 	= "CLI_ShareDocument_S002";
self::$CheckTable['share']['document']['1']['p'] 	= "website";
self::$CheckTable['share']['document']['1']['s'] 	= "with_website";
self::$CheckTable['share']['document']['2']['d'] 	= 3;
self::$CheckTable['share']['document']['2']['f'] 	= function ($a) { return array ("SELECT share_id FROM ".$a['sqlTables']['document_share']." WHERE fk_ws_id = '".$a['params']['ws_id']."' AND fk_docu_id = '".$a['params']['docu_id']."';" ); };
self::$CheckTable['share']['document']['2']['m'] 	= "CLI_ShareDocument_S003";
self::$CheckTable['share']['document']['2']['s'] 	= "docu_id";


self::$CheckTable['assign']['document']['0']['d']	= 2;
self::$CheckTable['assign']['document']['0']['f']	= function ($a) { return array ("SELECT docu_id,docu_name FROM ".$a['sqlTables']['document']." WHERE docu_name = '".$a['params']['name']."';");};
self::$CheckTable['assign']['document']['0']['c'] 	= "docu_id";
self::$CheckTable['assign']['document']['0']['v'] 	= "docu_id";
self::$CheckTable['assign']['document']['0']['m'] 	= "CLI_AssignDocument_A001";
self::$CheckTable['assign']['document']['0']['p'] 	= "document";
self::$CheckTable['assign']['document']['0']['s'] 	= "name";
self::$CheckTable['assign']['document']['1']['d']	= 2;
self::$CheckTable['assign']['document']['1']['f']	= function ($a) { return array ("SELECT arti_id,arti_name FROM ".$a['sqlTables']['article']." WHERE arti_name = '".$a['params']['to_article']."' AND fk_ws_id = '".$a['Context']['ws_id']."';");};
self::$CheckTable['assign']['document']['1']['c']	= "arti_id";
self::$CheckTable['assign']['document']['1']['v']	= "arti_id";
self::$CheckTable['assign']['document']['1']['m']	= "CLI_AssignDocument_A002";
self::$CheckTable['assign']['document']['1']['p']	= "article";
self::$CheckTable['assign']['document']['1']['s']	= "to_article";


// Group
self::$CheckTable['add']['group']['0']['d'] = 3;
self::$CheckTable['add']['group']['0']['f'] = function ($a) { return array ( "SELECT grp.group_id FROM ".$a['sqlTables']['group']." grp , ".$a['sqlTables']['group_website']." sg , ".$a['sqlTables']['website']." ws WHERE grp.group_name = '".$a['params']['name']."' AND grp.group_id = sg.fk_group_id AND sg.fk_ws_id = ws.ws_id AND ws.ws_id = '".$a['Context']['ws_id']."';" ); };
self::$CheckTable['add']['group']['0']['m'] = "CLI_group_C001";
self::$CheckTable['add']['group']['0']['s'] = "name";

self::$CheckTable['add']['group']['1']['d'] = 2;
self::$CheckTable['add']['group']['1']['f'] = function ($a) { if ($a['params']['parent'] != 'origin' ) { return array ( "SELECT grp.group_id FROM ".$a['sqlTables']['group']." grp , ".$a['sqlTables']['group_website']." sg , ".$a['sqlTables']['website']." ws WHERE grp.group_name = '".$a['params']['parent']."' AND grp.group_id = sg.fk_group_id AND sg.fk_ws_id = ws.ws_id AND ws.ws_id = '".$a['Context']['ws_id']."';" );} else { return -1; }};
self::$CheckTable['add']['group']['1']['c'] = "group_id";
self::$CheckTable['add']['group']['1']['v'] = "group_parent";
self::$CheckTable['add']['group']['1']['m'] = "CLI_group_C002";
self::$CheckTable['add']['group']['1']['p'] = "parent";
self::$CheckTable['add']['group']['1']['s'] = "parent";

self::$CheckTable['update']['group']['0']['d'] = 2;
self::$CheckTable['update']['group']['0']['f'] = function ($a) { return array ( "SELECT grp.group_id FROM ".$a['sqlTables']['group']." grp , ".$a['sqlTables']['group_website']." sg , ".$a['sqlTables']['website']." ws WHERE grp.group_name = '".$a['params']['name']."' AND grp.group_id = sg.fk_group_id AND sg.fk_ws_id = ws.ws_id AND ws.ws_id = '".$a['Context']['ws_id']."';" ); };
self::$CheckTable['update']['group']['0']['c'] = "group_id";
self::$CheckTable['update']['group']['0']['v'] = "group_id";
self::$CheckTable['update']['group']['0']['m'] = "CLI_group_U001";
self::$CheckTable['update']['group']['1']['p'] = "group";
self::$CheckTable['update']['group']['1']['s'] = "name";

self::$CheckTable['update']['group']['1']['d'] = 2;
self::$CheckTable['update']['group']['1']['f'] = function ($a) { return array ( "SELECT grp.group_id FROM ".$a['sqlTables']['group']." grp , ".$a['sqlTables']['group_website']." sg , ".$a['sqlTables']['website']." ws WHERE grp.group_name = '".$a['params']['name']."' AND grp.group_id = sg.fk_group_id AND sg.fk_ws_id = ws.ws_id AND ws.ws_id = '".$a['Context']['ws_id']."';" ); };
self::$CheckTable['update']['group']['1']['c'] = "group_id";
self::$CheckTable['update']['group']['1']['v'] = "group_id_Parent";
self::$CheckTable['update']['group']['1']['m'] = "CLI_group_U002";
self::$CheckTable['update']['group']['1']['s'] = "name";

self::$CheckTable['delete']['group']['0']['d'] = 2;
self::$CheckTable['delete']['group']['0']['f'] = function ($a) { return array ( "SELECT grp.group_id FROM ".$a['sqlTables']['group']." grp , ".$a['sqlTables']['group_website']." sg , ".$a['sqlTables']['website']." ws WHERE grp.group_name = '".$a['params']['name']."' AND grp.group_id = sg.fk_group_id AND sg.fk_ws_id = ws.ws_id AND ws.ws_id = '".$a['Context']['ws_id']."';" ); };
self::$CheckTable['delete']['group']['0']['c'] = "group_id";
self::$CheckTable['delete']['group']['0']['v'] = "group_id";
self::$CheckTable['delete']['group']['0']['m'] = "CLI_group_D001";
self::$CheckTable['delete']['group']['1']['p'] = "group";
self::$CheckTable['delete']['group']['1']['s'] = "name";


// KeyWord
self::$CheckTable['add']['keyword']['0']['d']	= 3;
self::$CheckTable['add']['keyword']['0']['f']	= function ($a) { return array ("SELECT keyword_id FROM ".$a['sqlTables']['keyword']." WHERE keyword_name = '".$a['params']['name']."' AND fk_ws_id = '".$a['Context']['ws_id']."';");};
self::$CheckTable['add']['keyword']['0']['m']	= "CLI_KeyWord_C001";
self::$CheckTable['add']['keyword']['0']['s']	= "name";
self::$CheckTable['add']['keyword']['1']['d']	= 2;
self::$CheckTable['add']['keyword']['1']['f']	= function ($a) { return array ("SELECT arti_id,arti_name FROM ".$a['sqlTables']['article']." WHERE arti_name = '".$a['params']['article']."' AND fk_ws_id = '".$a['Context']['ws_id']."';");};
self::$CheckTable['add']['keyword']['1']['c']	= "arti_id";
self::$CheckTable['add']['keyword']['1']['v']	= "arti_id";
self::$CheckTable['add']['keyword']['1']['m']	= "CLI_KeyWord_C002";
self::$CheckTable['add']['keyword']['1']['p']	= "article";
self::$CheckTable['add']['keyword']['1']['s']	= "article";


self::$CheckTable['update']['keyword']['0']['d']	= 2;
self::$CheckTable['update']['keyword']['0']['f']	= function ($a) { return array ("SELECT keyword_id FROM ".$a['sqlTables']['keyword']." WHERE keyword_name = '".$a['params']['name']."' AND fk_ws_id = '".$a['Context']['ws_id']."';");};
self::$CheckTable['update']['keyword']['0']['c']	= "keyword_id";
self::$CheckTable['update']['keyword']['0']['v']	= "keyword_id";
self::$CheckTable['update']['keyword']['0']['m']	= "CLI_KeyWord_U002";
self::$CheckTable['update']['keyword']['0']['p']	= "keyword";
self::$CheckTable['update']['keyword']['0']['s']	= "name";
self::$CheckTable['update']['keyword']['1']['d']	= 2;
self::$CheckTable['update']['keyword']['1']['f']	= function ($a) { return array ("SELECT arti_id,arti_name FROM ".$a['sqlTables']['article']." WHERE arti_name = '".$a['params']['article']."' AND fk_ws_id = '".$a['Context']['ws_id']."';");};
self::$CheckTable['update']['keyword']['1']['c']	= "arti_id";
self::$CheckTable['update']['keyword']['1']['v']	= "arti_id";
self::$CheckTable['update']['keyword']['1']['m']	= "CLI_KeyWord_U002";
self::$CheckTable['update']['keyword']['1']['p']	= "article";
self::$CheckTable['update']['keyword']['1']['s']	= "article";

self::$CheckTable['delete']['keyword']['0']['d']	= 2;
self::$CheckTable['delete']['keyword']['0']['f']	= function ($a) { return array ("SELECT keyword_id FROM ".$a['sqlTables']['keyword']." WHERE keyword_name = '".$a['params']['name']."' AND fk_ws_id = '".$a['Context']['ws_id']."';");};
self::$CheckTable['delete']['keyword']['0']['c']	= "keyword_id";
self::$CheckTable['delete']['keyword']['0']['v']	= "keyword_id";
self::$CheckTable['delete']['keyword']['0']['m']	= "CLI_KeyWord_D002";
self::$CheckTable['delete']['keyword']['0']['p']	= "keyword";
self::$CheckTable['delete']['keyword']['0']['s']	= "name";


// Language (is not a entity in itself) 
self::$CheckTable['assign']['language']['0']['d']	= 2;
self::$CheckTable['assign']['language']['0']['f']	= function ($a) { return array ("SELECT ws_id,ws_name FROM ".$a['sqlTables']['website']." WHERE ws_name = '".$a['params']['to_website']."';");};
self::$CheckTable['assign']['language']['0']['c']	= "ws_id";
self::$CheckTable['assign']['language']['0']['v']	= "ws_id";
self::$CheckTable['assign']['language']['0']['m']	= "CLI_AddLang_A001";
self::$CheckTable['assign']['language']['0']['p']	= "site";
self::$CheckTable['assign']['language']['0']['s']	= "to_website";
self::$CheckTable['assign']['language']['1']['d']	= 2;
self::$CheckTable['assign']['language']['1']['f']	= function ($a) { return array ( "SELECT lang_id FROM ".$a['sqlTables']['language']." WHERE lang_639_3 = '".$a['params']['name']."'"); };
self::$CheckTable['assign']['language']['1']['c']	= "lang_id";
self::$CheckTable['assign']['language']['1']['v']	= "lang_id";
self::$CheckTable['assign']['language']['1']['m']	= "CLI_AddLang_A002";
self::$CheckTable['assign']['language']['1']['p']	= "language";
self::$CheckTable['assign']['language']['1']['s']	= "name";

// Log
self::$CheckTable['add']['log']['0']['d']	= 4;
self::$CheckTable['add']['log']['0']['f']	= function ($a) { 
	$ret = 0;
	if (strlen($a['params']['s']) > 0 ) { $ret = 1; } // Signal is the minimum required.
	return $ret;
};
self::$CheckTable['add']['log']['0']['m']	= "CLI_AddLog_A001";


// Layout
self::$CheckTable['add']['layout']['0']['d']	= 3;
self::$CheckTable['add']['layout']['0']['f']	= function ($a) { return array ("SELECT layout_id,layout_name FROM ".$a['sqlTables']['layout']." WHERE layout_name = '".$a['params']['name']."';");};
self::$CheckTable['add']['layout']['0']['m']	= "CLI_Layout_D001";
self::$CheckTable['add']['layout']['0']['s']	= "name";

self::$CheckTable['update']['layout']['0']['d']	= 2;
self::$CheckTable['update']['layout']['0']['f']	= function ($a) { return array ("SELECT layout_id,layout_name FROM ".$a['sqlTables']['layout']." WHERE layout_name = '".$a['params']['name']."';");};
self::$CheckTable['update']['layout']['0']['c']	= "layout_id";
self::$CheckTable['update']['layout']['0']['v']	= "layout_id";
self::$CheckTable['update']['layout']['0']['m']	= "CLI_Layout_U001";
self::$CheckTable['update']['layout']['0']['p']	= "layout";
self::$CheckTable['update']['layout']['0']['s']	= "name";

self::$CheckTable['delete']['layout']['0']['d']	= 2;
self::$CheckTable['delete']['layout']['0']['f']	= function ($a) { return array ("SELECT layout_id,layout_name FROM ".$a['sqlTables']['layout']." WHERE layout_name = '".$a['params']['name']."';");};
self::$CheckTable['delete']['layout']['0']['c']	= "layout_id";
self::$CheckTable['delete']['layout']['0']['v']	= "layout_id";
self::$CheckTable['delete']['layout']['0']['m']	= "CLI_Layout_D001";
self::$CheckTable['delete']['layout']['0']['p']	= "layout";
self::$CheckTable['delete']['layout']['0']['s']	= "name";

self::$CheckTable['assign']['layout']['0']['d']	= 2;
self::$CheckTable['assign']['layout']['0']['f']	= function ($a) { return array ("SELECT layout_id,layout_name FROM ".$a['sqlTables']['layout']." WHERE layout_name = '".$a['params']['name']."';");};
self::$CheckTable['assign']['layout']['0']['c']	= "layout_id";
self::$CheckTable['assign']['layout']['0']['v']	= "layout_id";
self::$CheckTable['assign']['layout']['0']['m']	= "CLI_Layout_A001";
self::$CheckTable['assign']['layout']['0']['p']	= "layout";
self::$CheckTable['assign']['layout']['0']['s']	= "name";
self::$CheckTable['assign']['layout']['1']['d']	= 2;
self::$CheckTable['assign']['layout']['1']['f']	= function ($a) { return array ("SELECT sd.theme_id AS theme_id, sd.theme_name AS theme_name FROM ".$a['sqlTables']['theme_descriptor']." sd, ".$a['sqlTables']['theme_website']." ss WHERE sd.theme_name = '".$a['params']['to_theme']."' AND sd.theme_id = ss.fk_theme_id AND ss.fk_ws_id = '".$a['Context']['ws_id']."';");};
self::$CheckTable['assign']['layout']['1']['c']	= "theme_id";
self::$CheckTable['assign']['layout']['1']['v']	= "theme_id";
self::$CheckTable['assign']['layout']['1']['m']	= "CLI_Layout_A002";
self::$CheckTable['assign']['layout']['1']['p']	= "layout";
self::$CheckTable['assign']['layout']['1']['s']	= "to_theme";


self::$CheckTable['add']['layout_content']['0']['d']	= 2;
self::$CheckTable['add']['layout_content']['0']['f']	= function ($a) { return array ("SELECT layout_id,layout_name FROM ".$a['sqlTables']['layout']." WHERE layout_name = '".$a['params']['to_layout']."';");};
self::$CheckTable['add']['layout_content']['0']['c']	= "layout_id";
self::$CheckTable['add']['layout_content']['0']['v']	= "layout_id";
self::$CheckTable['add']['layout_content']['0']['m']	= "CLI_LayoutContent_C001";
self::$CheckTable['add']['layout_content']['0']['p']	= "layout";
self::$CheckTable['add']['layout_content']['0']['s']	= "to_layout";
// self::$CheckTable['add']['layout_content']['1']['d']	= 2;
// self::$CheckTable['add']['layout_content']['1']['f']	= function ($a) { return array ("SELECT mdl.module_id FROM ".$a['sqlTables']['module']." mdl , ".$a['sqlTables']['module_website']." sm WHERE mdl.module_name = '".$a['params']['module']."' AND mdl.module_id = sm.module_id AND sm.ws_id = '".$a['Context']['ws_id']."';");};
// self::$CheckTable['add']['layout_content']['1']['c']	= "module_id";
// self::$CheckTable['add']['layout_content']['1']['v']	= "module_id";
// self::$CheckTable['add']['layout_content']['1']['m']	= "CLI_LayoutContent_C002";
// self::$CheckTable['add']['layout_content']['1']['p']	= "layout";


// Module
self::$CheckTable['add']['module']['0']['d']	= 3;
self::$CheckTable['add']['module']['0']['f']	= function ($a) { return array ("SELECT mdl.module_id FROM ".$a['sqlTables']['module']." mdl , ".$a['sqlTables']['module_website']." sm WHERE mdl.module_name = '".$a['params']['name']."' AND mdl.module_id = sm.fk_module_id AND sm.fk_ws_id = '".$a['Context']['ws_id']."';");};
self::$CheckTable['add']['module']['0']['m']	= "CLI_Module_C001";
self::$CheckTable['add']['module']['0']['s']	= "name";
self::$CheckTable['add']['module']['1']['d']	= 2;
self::$CheckTable['add']['module']['1']['f']	= function ($a) { return array ("SELECT grp.group_id AS group_id, grp.group_name AS group_name FROM ".$a['sqlTables']['group']." grp, ".$a['sqlTables']['group_website']." sg WHERE grp.group_name = '".$a['params']['group_who_can_see']."' AND grp.group_id = sg.fk_group_id AND sg.fk_ws_id = '".$a['Context']['ws_id']."';");};
self::$CheckTable['add']['module']['1']['c']	= "group_id";
self::$CheckTable['add']['module']['1']['v']	= "group_allowed_to_see_id";
self::$CheckTable['add']['module']['1']['m']	= "CLI_Module_C002";
self::$CheckTable['add']['module']['1']['p']	= "user";
self::$CheckTable['add']['module']['1']['s']	= "group_who_can_see";
self::$CheckTable['add']['module']['2']['d']	= 2;
self::$CheckTable['add']['module']['2']['f']	= function ($a) { return array ("SELECT grp.group_id AS group_id, grp.group_name AS group_name FROM ".$a['sqlTables']['group']." grp, ".$a['sqlTables']['group_website']." sg WHERE grp.group_name = '".$a['params']['group_who_can_use']."' AND grp.group_id = sg.fk_group_id AND sg.fk_ws_id = '".$a['Context']['ws_id']."';");};
self::$CheckTable['add']['module']['2']['c']	= "group_id";
self::$CheckTable['add']['module']['2']['v']	= "group_allowed_to_use_id";
self::$CheckTable['add']['module']['2']['m']	= "CLI_Module_C003";
self::$CheckTable['add']['module']['2']['p']	= "user";
self::$CheckTable['add']['module']['2']['s']	= "group_who_can_use";

self::$CheckTable['update']['module']['0']['d']	= 3;
self::$CheckTable['update']['module']['0']['f']	= function ($a) { return array ("SELECT mdl.module_id FROM ".$a['sqlTables']['module']." mdl , ".$a['sqlTables']['module_website']." sm WHERE mdl.module_name = '".$a['params']['name']."' AND mdl.module_id = sm.fk_module_id AND sm.fk_ws_id = '".$a['Context']['ws_id']."';");};
self::$CheckTable['update']['module']['0']['m']	= "CLI_Module_U001";
self::$CheckTable['update']['module']['0']['s']	= "name";
self::$CheckTable['update']['module']['1']['d']	= 2;
self::$CheckTable['update']['module']['1']['f']	= function ($a) { return array ("SELECT grp.group_id AS group_id, grp.group_name AS group_name FROM ".$a['sqlTables']['group']." grp, ".$a['sqlTables']['group_website']." sg WHERE grp.group_name = '".$a['params']['group_who_can_see']."' AND grp.group_id = sg.fk_group_id AND sg.fk_ws_id = '".$a['Context']['ws_id']."';");};
self::$CheckTable['update']['module']['1']['c']	= "group_id";
self::$CheckTable['update']['module']['1']['v']	= "group_allowed_to_see_id";
self::$CheckTable['update']['module']['1']['m']	= "CLI_Module_U002";
self::$CheckTable['update']['module']['1']['p']	= "user";
self::$CheckTable['update']['module']['1']['s']	= "group_who_can_see";
self::$CheckTable['update']['module']['2']['d']	= 2;
self::$CheckTable['update']['module']['2']['f']	= function ($a) { return array ("SELECT grp.group_id AS group_id, grp.group_name AS group_name FROM ".$a['sqlTables']['group']." grp, ".$a['sqlTables']['group_website']." sg WHERE grp.group_name = '".$a['params']['group_who_can_use']."' AND grp.group_id = sg.fk_group_id AND sg.fk_ws_id = '".$a['Context']['ws_id']."';");};
self::$CheckTable['update']['module']['2']['c']	= "group_id";
self::$CheckTable['update']['module']['2']['v']	= "group_allowed_to_use_id";
self::$CheckTable['update']['module']['2']['m']	= "CLI_Module_U003";
self::$CheckTable['update']['module']['2']['p']	= "user";
self::$CheckTable['update']['module']['2']['s']	= "group_who_can_use";

self::$CheckTable['delete']['module']['0']['d']	= 2;
self::$CheckTable['delete']['module']['0']['f']	= function ($a) { return array ("SELECT mdl.module_id FROM ".$a['sqlTables']['module']." mdl , ".$a['sqlTables']['module_website']." sm WHERE mdl.module_name = '".$a['params']['name']."' AND mdl.module_id = sm.fk_module_id AND sm.fk_ws_id = '".$a['Context']['ws_id']."';");};
self::$CheckTable['delete']['module']['0']['c']	= "module_id";
self::$CheckTable['delete']['module']['0']['v']	= "module_id";
self::$CheckTable['delete']['module']['0']['m']	= "CLI_Module_D001";
self::$CheckTable['delete']['module']['0']['p']	= "module";
self::$CheckTable['delete']['module']['0']['s']	= "name";


// Tag
// Usage of 'BINARY' because of collation : utf8mb4_general_ci
// https://stackoverflow.com/questions/5629111/how-can-i-make-sql-case-sensitive-string-comparison-on-mysql
// http://mysqlserverteam.com/new-collations-in-mysql-8-0-0/
self::$CheckTable['add']['tag']['0']['d']	= 3;
self::$CheckTable['add']['tag']['0']['f']	= function ($a) { return array ("SELECT tag_id,tag_name FROM ".$a['sqlTables']['tag']." WHERE BINARY tag_name = '".$a['params']['name']."' AND fk_ws_id = '".$a['Context']['ws_id']."';");};
self::$CheckTable['add']['tag']['0']['m']	= "CLI_Tag_C001";
self::$CheckTable['add']['tag']['0']['s']	= "name";

self::$CheckTable['assign']['tag']['0']['d']	= 2;
self::$CheckTable['assign']['tag']['0']['f']	= function ($a) { return array ("SELECT tag_id,tag_name FROM ".$a['sqlTables']['tag']." WHERE BINARY tag_name = '".$a['params']['name']."' AND fk_ws_id = '".$a['Context']['ws_id']."';");};
self::$CheckTable['assign']['tag']['0']['c']	= "tag_id";
self::$CheckTable['assign']['tag']['0']['v']	= "tag_id";
self::$CheckTable['assign']['tag']['0']['m']	= "CLI_Tag_A001";
self::$CheckTable['assign']['tag']['0']['p']	= "tag";
self::$CheckTable['assign']['tag']['0']['s']	= "name";
self::$CheckTable['assign']['tag']['1']['d']	= 2;
self::$CheckTable['assign']['tag']['1']['f']	= function ($a) { return array ("SELECT arti_id,arti_name FROM ".$a['sqlTables']['article']." WHERE arti_name = '".$a['params']['article']."' AND fk_ws_id = '".$a['Context']['ws_id']."';");};
self::$CheckTable['assign']['tag']['1']['c']	= "arti_id";
self::$CheckTable['assign']['tag']['1']['v']	= "arti_id";
self::$CheckTable['assign']['tag']['1']['m']	= "CLI_Tag_A002";
self::$CheckTable['assign']['tag']['1']['p']	= "article";
self::$CheckTable['assign']['tag']['1']['s']	= "article";
self::$CheckTable['assign']['tag']['2']['d']	= 3;
self::$CheckTable['assign']['tag']['2']['f']	= function ($a) { return array ("SELECT fk_tag_id FROM ".$a['sqlTables']['article_tag']." WHERE fk_tag_id = '".$a['params']['tag_id']."' AND fk_arti_id = '".$a['params']['arti_id']."';");};
self::$CheckTable['assign']['tag']['2']['m']	= "CLI_Tag_A003";
self::$CheckTable['assign']['tag']['2']['p']	= "link";
self::$CheckTable['assign']['tag']['2']['s']	= "tag_id";

self::$CheckTable['delete']['tag']['0']['d']	= 2;
self::$CheckTable['delete']['tag']['0']['f']	= function ($a) { return array ("SELECT tag_id,tag_name FROM ".$a['sqlTables']['tag']." WHERE BINARY tag_name = '".$a['params']['name']."' AND fk_ws_id = '".$a['Context']['ws_id']."';");};
self::$CheckTable['delete']['tag']['0']['c']	= "tag_id";
self::$CheckTable['delete']['tag']['0']['v']	= "tag_id";
self::$CheckTable['delete']['tag']['0']['m']	= "CLI_Tag_U001";
self::$CheckTable['delete']['tag']['0']['p']	= "tag";
self::$CheckTable['delete']['tag']['0']['s']	= "name";


// Theme
self::$CheckTable['add']['theme']['0']['d']	= 3;
self::$CheckTable['add']['theme']['0']['f']	= function ($a) { return array ("SELECT sd.theme_id, sd.theme_name FROM ".$a['sqlTables']['theme_descriptor']." sd, ".$a['sqlTables']['theme_website']." ss WHERE sd.theme_name = '".$a['params']['name']."' AND sd.theme_id = ss.fk_theme_id AND ss.fk_ws_id = '".$a['Context']['ws_id']."';");};
self::$CheckTable['add']['theme']['0']['m']	= "CLI_Theme_C001";
self::$CheckTable['add']['theme']['0']['s']	= "name";

self::$CheckTable['update']['theme']['0']['d']	= 2;
self::$CheckTable['update']['theme']['0']['f']	= function ($a) { return array ("SELECT sd.theme_id, sd.theme_name FROM ".$a['sqlTables']['theme_descriptor']." sd, ".$a['sqlTables']['theme_website']." ss WHERE sd.theme_name = '".$a['params']['name']."' AND sd.theme_id = ss.fk_theme_id AND ss.fk_ws_id = '".$a['Context']['ws_id']."';");};
self::$CheckTable['update']['theme']['0']['c']	= "theme_id";
self::$CheckTable['update']['theme']['0']['v']	= "theme_id";
self::$CheckTable['update']['theme']['0']['m']	= "CLI_Theme_U001";
self::$CheckTable['update']['theme']['0']['p']	= "theme";
self::$CheckTable['update']['theme']['0']['s']	= "name";
self::$CheckTable['delete']['theme']['0']['d']	= 2;
self::$CheckTable['delete']['theme']['0']['f']	= function ($a) { return array ("SELECT sd.theme_id, sd.theme_name FROM ".$a['sqlTables']['theme_descriptor']." sd, ".$a['sqlTables']['theme_website']." ss WHERE sd.theme_name = '".$a['params']['name']."' AND sd.theme_id = ss.fk_theme_id AND ss.fk_ws_id = '".$a['Context']['ws_id']."';");};
self::$CheckTable['delete']['theme']['0']['c']	= "theme_id";
self::$CheckTable['delete']['theme']['0']['v']	= "theme_id";
self::$CheckTable['delete']['theme']['0']['m']	= "CLI_Theme_D001";
self::$CheckTable['delete']['theme']['0']['p']	= "theme";
self::$CheckTable['delete']['theme']['0']['s']	= "name";


self::$CheckTable['assign']['theme']['0']['d']	= 2;
self::$CheckTable['assign']['theme']['0']['f']	= function ($a) { return array ("SELECT sd.theme_id, sd.theme_name FROM ".$a['sqlTables']['theme_descriptor']." sd, ".$a['sqlTables']['theme_website']." ss WHERE sd.theme_name = '".$a['params']['name']."' AND sd.theme_id = ss.fk_theme_id AND ss.fk_ws_id = '".$a['Context']['ws_id']."';");};
self::$CheckTable['assign']['theme']['0']['c']	= "theme_id";
self::$CheckTable['assign']['theme']['0']['v']	= "theme_id";
self::$CheckTable['assign']['theme']['0']['m']	= "CLI_AssignTheme_A001";
self::$CheckTable['assign']['theme']['0']['p']	= "theme";
self::$CheckTable['assign']['theme']['0']['s']	= "name";
self::$CheckTable['assign']['theme']['1']['d']	= 2;
self::$CheckTable['assign']['theme']['1']['f']	= function ($a) { return array ("SELECT * FROM ".$a['sqlTables']["website"]." WHERE ws_name = '".$a['params']['to_website']."' ;");};
self::$CheckTable['assign']['theme']['1']['c']	= "ws_id";
self::$CheckTable['assign']['theme']['1']['v']	= "ws_id";
self::$CheckTable['assign']['theme']['1']['m']	= "CLI_AssignTheme_A002";
self::$CheckTable['assign']['theme']['1']['p']	= "site";
self::$CheckTable['assign']['theme']['1']['s']	= "to_website";


// Translation
self::$CheckTable['add']['translation']['0']['d']	= 2;
self::$CheckTable['add']['translation']['0']['f']	= function ($a) { return array ( "SELECT lang_id FROM ".$a['sqlTables']['language']." WHERE lang_639_3 = '".$a['params']['lang']."'"); };
self::$CheckTable['add']['translation']['0']['c']	= "lang_id";
self::$CheckTable['add']['translation']['0']['v']	= "lang_id";
self::$CheckTable['add']['translation']['0']['m']	= "CLI_Translation_C001";
self::$CheckTable['add']['translation']['0']['p']	= "language";
self::$CheckTable['add']['translation']['0']['s']	= "lang";
self::$CheckTable['add']['translation']['1']['d']	= 3;
self::$CheckTable['add']['translation']['1']['f']	= function ($a) { return array ("SELECT * FROM ".$a['sqlTables']['i18n']." WHERE fk_lang_id = '".$a['params']['lang_id']."' AND i18n_package = '".$a['params']['package']."' AND i18n_name = '".$a['params']['name']."';");};
self::$CheckTable['add']['translation']['1']['m']	= "CLI_Translation_C002";
self::$CheckTable['add']['translation']['1']['s']	= "name";


// User
self::$CheckTable['add']['user']['0']['d']	= 3;
self::$CheckTable['add']['user']['0']['f']	= function ($a) { return array ("SELECT usr.user_id AS user_id, usr.user_login AS user_login FROM ".$a['sqlTables']['user']." usr, ".$a['sqlTables']['group_user']." gu, ".$a['sqlTables']['group_website']." sg WHERE usr.user_login = '".$a['params']['name']."' AND usr.user_id = gu.fk_user_id AND gu.fk_group_id = sg.fk_group_id AND gu.group_user_initial_group = '1' AND sg.fk_ws_id = '".$a['Context']['ws_id']."';");};
self::$CheckTable['add']['user']['0']['m']	= "CLI_User_C001";
self::$CheckTable['add']['user']['0']['s']	= "name";
self::$CheckTable['add']['user']['1']['d']	= 2;
self::$CheckTable['add']['user']['1']['f']	= function ($a) { return array ( "SELECT grp.group_id FROM ".$a['sqlTables']['group']." grp , ".$a['sqlTables']['group_website']." sg , ".$a['sqlTables']['website']." ws WHERE grp.group_name = 'reader' AND grp.group_id = sg.fk_group_id AND sg.fk_ws_id = ws.ws_id AND ws.ws_id = '".$a['Context']['ws_id']."';" ); };
self::$CheckTable['add']['user']['1']['c']	= "group_id";
self::$CheckTable['add']['user']['1']['v']	= "reader_id";
self::$CheckTable['add']['user']['1']['m']	= "CLI_User_C002";
self::$CheckTable['add']['user']['1']['p']	= "group";
self::$CheckTable['add']['user']['1']['s']	= "null";
self::$CheckTable['add']['user']['2']['d']	= 2;
self::$CheckTable['add']['user']['2']['f']	= function ($a) { return array ( "SELECT grp.group_id FROM ".$a['sqlTables']['group']." grp , ".$a['sqlTables']['group_website']." sg , ".$a['sqlTables']['website']." ws WHERE grp.group_name = 'anonymous' AND grp.group_id = sg.fk_group_id AND sg.fk_ws_id = ws.ws_id AND ws.ws_id = '".$a['Context']['ws_id']."';" ); };
self::$CheckTable['add']['user']['2']['c']	= "group_id";
self::$CheckTable['add']['user']['2']['v']	= "anonymous_id";
self::$CheckTable['add']['user']['2']['m']	= "CLI_User_C003";
self::$CheckTable['add']['user']['2']['p']	= "group";
self::$CheckTable['add']['user']['2']['s']	= "null";


self::$CheckTable['update']['user']				= self::$CheckTable['add']['user'];		// It's a copy not a reference!
self::$CheckTable['update']['user']['0']['d']	= 2;
self::$CheckTable['update']['user']['0']['c']	= "user_id";
self::$CheckTable['update']['user']['0']['v']	= "id";
self::$CheckTable['update']['user']['0']['m']	= "CLI_User_U001";

self::$CheckTable['update']['user']['1']['m']	= "CLI_User_U002";
self::$CheckTable['update']['user']['2']['p']	= "user";
self::$CheckTable['update']['user']['2']['m']	= "CLI_User_U003";

self::$CheckTable['update']['user']['3']['d']	= 1;
self::$CheckTable['update']['user']['3']['f']	= function ($a) { return array ("SELECT t.theme_id, t.theme_name FROM ".$a['sqlTables']['theme_descriptor']." t, ".$a['sqlTables']['theme_website']." st WHERE t.theme_name = '".$a['params']['pref_theme']."' AND t.theme_id = st.fk_theme_id AND st.fk_theme_state = '1' AND st.fk_ws_id = '".$a['Context']['ws_id']."';");};
self::$CheckTable['update']['user']['3']['c']	= "theme_id";
self::$CheckTable['update']['user']['3']['v']	= "pref_theme_id";
self::$CheckTable['update']['user']['3']['m']	= "CLI_User_U004";
self::$CheckTable['update']['user']['3']['p']	= "theme";
self::$CheckTable['update']['user']['3']['s']	= "pref_theme";

self::$CheckTable['update']['user']['4']['d']	= 1;
self::$CheckTable['update']['user']['4']['f']	= function ($a) { if ($a['params']['lang'] != 0 ) { return array ("SELECT lang_id FROM ".$a['sqlTables']['language']." WHERE lang_639_3 = '".$a['params']['lang']."';");} else {	return array ("SELECT (0);");} };
self::$CheckTable['update']['user']['4']['c']	= "lang_id";
self::$CheckTable['update']['user']['4']['v']	= "lang";
self::$CheckTable['update']['user']['4']['m']	= "CLI_User_U005";
self::$CheckTable['update']['user']['4']['p']	= "language";
self::$CheckTable['update']['user']['4']['s']	= "lang";


self::$CheckTable['assign']['user']['0']['d']	= 2;
self::$CheckTable['assign']['user']['0']['f']	= function ($a) { return array ("SELECT usr.user_id AS user_id, usr.user_login AS user_login FROM ".$a['sqlTables']['user']." usr, ".$a['sqlTables']['group_user']." gu, ".$a['sqlTables']['group_website']." sg WHERE usr.user_login = '".$a['params']['name']."' AND usr.user_id = gu.fk_user_id AND gu.fk_group_id = sg.fk_group_id AND gu.group_user_initial_group = '1' AND sg.fk_ws_id = '".$a['Context']['ws_id']."';");};
self::$CheckTable['assign']['user']['0']['c']	= "user_id";
self::$CheckTable['assign']['user']['0']['v']	= "user_id";
self::$CheckTable['assign']['user']['0']['m']	= "CLI_User_A001";
self::$CheckTable['assign']['user']['0']['p']	= "user";
self::$CheckTable['assign']['user']['0']['s']	= "name";
self::$CheckTable['assign']['user']['1']['d']	= 2;
self::$CheckTable['assign']['user']['1']['f']	= function ($a) { return array ( "SELECT grp.group_id FROM ".$a['sqlTables']['group']." grp , ".$a['sqlTables']['group_website']." sg , ".$a['sqlTables']['website']." ws WHERE grp.group_name = '".$a['params']['to_group']."' AND grp.group_id = sg.fk_group_id AND sg.fk_ws_id = ws.ws_id AND ws.ws_id = '".$a['Context']['ws_id']."';" ); };
self::$CheckTable['assign']['user']['1']['c']	= "group_id";
self::$CheckTable['assign']['user']['1']['v']	= "group_id";
self::$CheckTable['assign']['user']['1']['m']	= "CLI_User_A002";
self::$CheckTable['assign']['user']['1']['p']	= "group";
self::$CheckTable['assign']['user']['1']['s']	= "to_group";
self::$CheckTable['assign']['user']['2']['d']	= 3;
self::$CheckTable['assign']['user']['2']['f']	= function ($a) { return array ( "SELECT group_user_id, fk_group_id, fk_user_id, group_user_initial_group FROM ".$a['sqlTables']['group_user']." WHERE fk_group_id = '".$a['group_id']."' AND fk_user_id = '".$a['user_id']."';" ); };
self::$CheckTable['assign']['user']['2']['c']	= "group_user_id";
self::$CheckTable['assign']['user']['2']['v']	= "group_user_id";
self::$CheckTable['assign']['user']['2']['m']	= "CLI_User_A003";
self::$CheckTable['assign']['user']['2']['p']	= "link";
self::$CheckTable['assign']['user']['2']['s']	= "user_id";


// ?? Var ??
// self::$CheckTable['set']['variable']['0']['d']	= 2;
// self::$CheckTable['set']['variable']['0']['f']	= function ($a) { return array ("");};
// self::$CheckTable['set']['variable']['0']['c']	= "_id";
// self::$CheckTable['set']['variable']['0']['v']	= "_id";
// self::$CheckTable['set']['variable']['0']['m']	= "CLI_Variable_S001";
// self::$CheckTable['set']['variable']['0']['p']	= "";


// WebSite
self::$CheckTable['add']['website']['0']['d']	= 3;
self::$CheckTable['add']['website']['0']['f']	= function ($a) { return array ("SELECT ws_id,ws_name FROM ".$a['sqlTables']['website']." WHERE ws_name = '".$a['params']['name']."';");};
self::$CheckTable['add']['website']['0']['m']	= "CLI_Website_C001";
self::$CheckTable['add']['website']['0']['s']	= "name";
self::$CheckTable['add']['website']['1']['d']	= 2;
self::$CheckTable['add']['website']['1']['f']	= function ($a) { return array ( "SELECT lang_id FROM ".$a['sqlTables']['language']." WHERE lang_639_3 = '".$a['params']['lang']."'"); };
self::$CheckTable['add']['website']['1']['c']	= "lang_id";
self::$CheckTable['add']['website']['1']['v']	= "lang_id";
self::$CheckTable['add']['website']['1']['m']	= "CLI_Website_C002";
self::$CheckTable['add']['website']['1']['p']	= "language";
self::$CheckTable['add']['website']['1']['s']	= "lang";

self::$CheckTable['update']['website']['0']['d']	= 2;
// self::$CheckTable['update']['website']['0']['f']	= function ($a) { return array ("SELECT ws_id,ws_nom FROM ".$a['sqlTables']['website']." WHERE ws_name = '".$a['params']['name']."';");};
self::$CheckTable['update']['website']['0']['f']	= &self::$CheckTable['add']['website']['0']['f'];
self::$CheckTable['update']['website']['0']['c']	= "ws_id";
self::$CheckTable['update']['website']['0']['v']	= "ws_id";
self::$CheckTable['update']['website']['0']['m']	= "CLI_Website_U001";
self::$CheckTable['update']['website']['0']['p']	= "site";
self::$CheckTable['update']['website']['0']['s']	= "name";
self::$CheckTable['update']['website']['1']['d']	= 1;
self::$CheckTable['update']['website']['1']['f']	= function ($a) { return array ( "SELECT lang_id FROM ".$a['sqlTables']['language']." WHERE lang_639_3 = '".$a['params']['lang']."';"); };
self::$CheckTable['update']['website']['1']['c']	= "lang_id";
self::$CheckTable['update']['website']['1']['v']	= "lang_id";
self::$CheckTable['update']['website']['1']['m']	= "CLI_Website_U002";
self::$CheckTable['update']['website']['1']['p']	= "language";
self::$CheckTable['update']['website']['1']['s']	= "lang";
self::$CheckTable['update']['website']['2']['d']	= 2;
self::$CheckTable['update']['website']['2']['f']	= function ($a) { return array ("SELECT sd.theme_id, sd.theme_name FROM ".$a['sqlTables']['theme_descriptor']." sd, ".$a['sqlTables']['theme_website']." ss WHERE sd.theme_name = '".$a['params']['theme']."' AND sd.theme_id = ss.fk_theme_id AND ss.fk_ws_id = '".$a['Context']['ws_id']."';");};
self::$CheckTable['update']['website']['2']['c']	= "theme_id";
self::$CheckTable['update']['website']['2']['v']	= "theme_id";
self::$CheckTable['update']['website']['2']['m']	= "CLI_Website_U003";
self::$CheckTable['update']['website']['2']['p']	= "theme";
self::$CheckTable['update']['website']['2']['s']	= "name";


// Variable
self::$CheckTable['set']['variable']['0']['d']	= 4;
self::$CheckTable['set']['variable']['0']['f']	= function ($a) {
		$ret = 0;
		$tab = array("installMonitor","DebugLevel_SQL","DebugLevel_CC","DebugLevel_PHP","DebugLevel_JS","LogTarget");
		foreach ( $tab as $var ) {
			if ( $var == $a['params']['name'] ) { $ret = 1; }
		}
		return $ret;
};
self::$CheckTable['set']['variable']['0']['m']	= "CLI_SetVariable_S001";


// Site Context
self::$CheckTable['website']['context']['0']['d']	= 2;
self::$CheckTable['website']['context']['0']['f']	= function ($a) { return array ("SELECT * FROM ".$a['sqlTables']["website"]." WHERE ws_name = '".$a['params']['name']."' ;");};
self::$CheckTable['website']['context']['0']['c']	= "ws_id";
self::$CheckTable['website']['context']['0']['v']	= "ws_id";
self::$CheckTable['website']['context']['0']['m']	= "CLI_Context_001";
self::$CheckTable['website']['context']['0']['p']	= "site";
self::$CheckTable['website']['context']['0']['s']	= "name";


// self::$CheckTable['']['']['0']['d']	= 2;
// self::$CheckTable['']['']['0']['f']	= function ($a) { return array ("");};
// self::$CheckTable['']['']['0']['c']	= "_id";
// self::$CheckTable['']['']['0']['v']	= "_id";
// self::$CheckTable['']['']['0']['m']	= "CLI__001";
// self::$CheckTable['']['']['0']['p']	= "";



?>