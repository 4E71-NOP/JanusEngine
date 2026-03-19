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

//menu
self::$CheckTable['add']['menu']['0']['d']	= _FIND_DUPLICATE_;
self::$CheckTable['add']['menu']['0']['f']	= function ($a) {return array("SELECT menu_id FROM " . $a['sqlTables']['menu'] . " WHERE fk_ws_id = '" . $a['Context']['ws_id'] . "' AND menu_name = '" . $a['params']['name'] . "';");};
self::$CheckTable['add']['menu']['0']['m']	= "CLI_menu_C001";
self::$CheckTable['add']['menu']['0']['s']	= "name";
self::$CheckTable['add']['menu']['1']['d']	= _RETURN_DATA_ONLY_;
self::$CheckTable['add']['menu']['1']['f']	= function ($a) {return array("SELECT menu_id FROM " . $a['sqlTables']['menu'] . " WHERE fk_ws_id = '" . $a['Context']['ws_id'] . "' AND menu_name = '" . $a['params']['parent'] . "';");};
self::$CheckTable['add']['menu']['1']['c']	= "menu_id";
self::$CheckTable['add']['menu']['1']['v']	= "parent_id";
self::$CheckTable['add']['menu']['1']['m']	= "CLI_menu_C002";
self::$CheckTable['add']['menu']['1']['p']	= "parent menu";
self::$CheckTable['add']['menu']['2']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['add']['menu']['2']['f']	= function ($a) {return array("SELECT deadline_id FROM " . $a['sqlTables']['deadline'] . " WHERE deadline_name = '" . $a['params']['deadline'] . "' AND fk_ws_id = '" . $a['Context']['ws_id'] . "';");};
self::$CheckTable['add']['menu']['2']['c']	= "deadline_id";
self::$CheckTable['add']['menu']['2']['v']	= "deadline_id";
self::$CheckTable['add']['menu']['2']['m']	= "CLI_menu_C003";
self::$CheckTable['add']['menu']['2']['p']	= "deadline";
self::$CheckTable['add']['menu']['2']['s']	= "deadline";
self::$CheckTable['add']['menu']['3']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['add']['menu']['3']['f']	= function ($a) {return array("SELECT prm.perm_id AS perm_id FROM " . $a['sqlTables']['permission'] . " prm WHERE prm.perm_name = '" . $a['params']['permission'] . "' ;");};
self::$CheckTable['add']['menu']['3']['c']	= "perm_id";
self::$CheckTable['add']['menu']['3']['v']	= "fk_perm_id";
self::$CheckTable['add']['menu']['3']['m']	= "CLI_menu_C004";
self::$CheckTable['add']['menu']['3']['p']	= "permission";
self::$CheckTable['add']['menu']['3']['s']	= "name";
self::$CheckTable['add']['menu']['4']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['add']['menu']['4']['f']	= function ($a) {return array("SELECT lang_id FROM " . $a['sqlTables']['language'] . " WHERE lang_639_3 = '" . $a['params']['lang'] . "';");};
self::$CheckTable['add']['menu']['4']['c']	= "lang_id";
self::$CheckTable['add']['menu']['4']['v']	= "lang_id";
self::$CheckTable['add']['menu']['4']['m']	= "CLI_menu_C005";
self::$CheckTable['add']['menu']['4']['p']	= "language";
self::$CheckTable['add']['menu']['4']['s']	= "lang";


self::$CheckTable['update']['menu']['0']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['update']['menu']['0']['f']	= function ($a) {return array("SELECT menu_id FROM " . $a['sqlTables']['menu'] . " WHERE fk_ws_id = '" . $a['Context']['ws_id'] . "' AND menu_name = '" . $a['params']['name'] . "';");};
self::$CheckTable['update']['menu']['0']['c']	= "menu_id";
self::$CheckTable['update']['menu']['0']['v']	= "menu_id";
self::$CheckTable['update']['menu']['0']['m']	= "CLI_menu_C001";
self::$CheckTable['update']['menu']['0']['p']	= "menu";
self::$CheckTable['update']['menu']['0']['s']	= "name";

?>