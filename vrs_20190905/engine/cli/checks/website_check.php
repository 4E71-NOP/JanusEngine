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

// WebSite
self::$CheckTable['add']['website']['0']['d']	= _FIND_DUPLICATE_;
self::$CheckTable['add']['website']['0']['f']	= function ($a) {return array("SELECT ws_id,ws_name FROM " . $a['sqlTables']['website'] . " WHERE ws_name = '" . $a['params']['name'] . "';");};
self::$CheckTable['add']['website']['0']['m']	= "CLI_Website_C001";
self::$CheckTable['add']['website']['0']['s']	= "name";
self::$CheckTable['add']['website']['1']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['add']['website']['1']['f']	= function ($a) {return array("SELECT lang_id FROM " . $a['sqlTables']['language'] . " WHERE lang_639_3 = '" . $a['params']['lang'] . "'");};
self::$CheckTable['add']['website']['1']['c']	= "lang_id";
self::$CheckTable['add']['website']['1']['v']	= "lang_id";
self::$CheckTable['add']['website']['1']['m']	= "CLI_Website_C002";
self::$CheckTable['add']['website']['1']['p']	= "language";
self::$CheckTable['add']['website']['1']['s']	= "lang";

self::$CheckTable['update']['website']['0']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['update']['website']['0']['f']	= &self::$CheckTable['add']['website']['0']['f'];
self::$CheckTable['update']['website']['0']['c']	= "ws_id";
self::$CheckTable['update']['website']['0']['v']	= "ws_id";
self::$CheckTable['update']['website']['0']['m']	= "CLI_Website_U001";
self::$CheckTable['update']['website']['0']['p']	= "site";
self::$CheckTable['update']['website']['0']['s']	= "name";

self::$CheckTable['update']['website']['1']['d']	= _RETURN_DATA_ONLY_;
self::$CheckTable['update']['website']['1']['f']	= function ($a) {return array("SELECT lang_id FROM " . $a['sqlTables']['language'] . " WHERE lang_639_3 = '" . $a['params']['lang'] . "';");};
self::$CheckTable['update']['website']['1']['c']	= "lang_id";
self::$CheckTable['update']['website']['1']['v']	= "lang_id";
self::$CheckTable['update']['website']['1']['m']	= "CLI_Website_U002";
self::$CheckTable['update']['website']['1']['p']	= "language";
self::$CheckTable['update']['website']['1']['s']	= "lang";

self::$CheckTable['update']['website']['2']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['update']['website']['2']['f']	= function ($a) {return array("SELECT sd.theme_id, sd.theme_name FROM " . $a['sqlTables']['theme_descriptor'] . " sd, " . $a['sqlTables']['theme_website'] . " ss WHERE sd.theme_name = '" . $a['params']['theme'] . "' AND sd.theme_id = ss.fk_theme_id AND ss.fk_ws_id = '" . $a['Context']['ws_id'] . "';");};
self::$CheckTable['update']['website']['2']['c']	= "fk_theme_id";
self::$CheckTable['update']['website']['2']['v']	= "theme_id";
self::$CheckTable['update']['website']['2']['m']	= "CLI_Website_U003";
self::$CheckTable['update']['website']['2']['p']	= "theme";
self::$CheckTable['update']['website']['2']['s']	= "name";

// Site Context
self::$CheckTable['website']['context']['0']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['website']['context']['0']['f']	= function ($a) {return array("SELECT * FROM " . $a['sqlTables']["website"] . " WHERE ws_name = '" . $a['params']['name'] . "' ;");};
self::$CheckTable['website']['context']['0']['c']	= "ws_id";
self::$CheckTable['website']['context']['0']['v']	= "ws_id";
self::$CheckTable['website']['context']['0']['m']	= "CLI_Context_001";
self::$CheckTable['website']['context']['0']['p']	= "site";
self::$CheckTable['website']['context']['0']['s']	= "name";



?>