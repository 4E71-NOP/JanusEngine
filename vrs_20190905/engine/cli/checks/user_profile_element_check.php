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

// User_rofile_element
self::$CheckTable['add']['user_profile_element']['0']['d']		= 3;
self::$CheckTable['add']['user_profile_element']['0']['f']		= function ($a) {return array("SELECT upe_id,upe_name FROM " . $a['sqlTables']['user_profile_element'] . " WHERE upe_name = '" . $a['params']['name'] . "' AND fk_ws_id = '" . $a['Context']['ws_id'] . "';");};
self::$CheckTable['add']['user_profile_element']['0']['m']		= "CLI_profile_element_A001";
self::$CheckTable['add']['user_profile_element']['0']['s']		= "name";

self::$CheckTable['update']['user_profile_element']['0']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['update']['user_profile_element']['0']['f']	= function ($a) {return array("SELECT upe_id,upe_name FROM " . $a['sqlTables']['user_profile_element'] . " WHERE upe_name = '" . $a['params']['name'] . "' AND fk_ws_id = '" . $a['Context']['ws_id'] . "';");};
self::$CheckTable['update']['user_profile_element']['0']['c']	= "upe_id";
self::$CheckTable['update']['user_profile_element']['0']['v']	= "upe_id";
self::$CheckTable['update']['user_profile_element']['0']['m']	= "CLI_profile_element_U001";
self::$CheckTable['update']['user_profile_element']['0']['p']	= "profile element";
self::$CheckTable['update']['user_profile_element']['0']['s']	= "name";

self::$CheckTable['delete']['user_profile_element']['0']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['delete']['user_profile_element']['0']['f']	= function ($a) {return array("SELECT upe_id,upe_name FROM " . $a['sqlTables']['user_profile_element'] . " WHERE upe_name = '" . $a['params']['name'] . "' AND fk_ws_id = '" . $a['Context']['ws_id'] . "';");};
self::$CheckTable['delete']['user_profile_element']['0']['c']	= "upe_id";
self::$CheckTable['delete']['user_profile_element']['0']['v']	= "upe_id";
self::$CheckTable['delete']['user_profile_element']['0']['m']	= "CLI_profile_element_D001";
self::$CheckTable['delete']['user_profile_element']['0']['p']	= "profile element";
self::$CheckTable['delete']['user_profile_element']['0']['s']	= "name";

?>