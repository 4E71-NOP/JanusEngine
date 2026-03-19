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

// Theme
self::$CheckTable['add']['theme']['0']['d']	= _FIND_DUPLICATE_;
self::$CheckTable['add']['theme']['0']['f']	= function ($a) {return array("SELECT sd.theme_id, sd.theme_name FROM " . $a['sqlTables']['theme_descriptor'] . " sd, " . $a['sqlTables']['theme_website'] . " ss WHERE sd.theme_name = '" . $a['params']['name'] . "' AND sd.theme_id = ss.fk_theme_id AND ss.fk_ws_id = '" . $a['Context']['ws_id'] . "';");};
self::$CheckTable['add']['theme']['0']['m']	= "CLI_Theme_C001";
self::$CheckTable['add']['theme']['0']['s']	= "name";
self::$CheckTable['update']['theme']['0']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['update']['theme']['0']['f']	= function ($a) {return array("SELECT sd.theme_id, sd.theme_name FROM " . $a['sqlTables']['theme_descriptor'] . " sd, " . $a['sqlTables']['theme_website'] . " ss WHERE sd.theme_name = '" . $a['params']['name'] . "' AND sd.theme_id = ss.fk_theme_id AND ss.fk_ws_id = '" . $a['Context']['ws_id'] . "';");};
self::$CheckTable['update']['theme']['0']['c']	= "theme_id";
self::$CheckTable['update']['theme']['0']['v']	= "theme_id";
self::$CheckTable['update']['theme']['0']['m']	= "CLI_Theme_U001";
self::$CheckTable['update']['theme']['0']['p']	= "theme";
self::$CheckTable['update']['theme']['0']['s']	= "name";
self::$CheckTable['delete']['theme']['0']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['delete']['theme']['0']['f']	= function ($a) {return array("SELECT sd.theme_id, sd.theme_name FROM " . $a['sqlTables']['theme_descriptor'] . " sd, " . $a['sqlTables']['theme_website'] . " ss WHERE sd.theme_name = '" . $a['params']['name'] . "' AND sd.theme_id = ss.fk_theme_id AND ss.fk_ws_id = '" . $a['Context']['ws_id'] . "';");};
self::$CheckTable['delete']['theme']['0']['c']	= "theme_id";
self::$CheckTable['delete']['theme']['0']['v']	= "theme_id";
self::$CheckTable['delete']['theme']['0']['m']	= "CLI_Theme_D001";
self::$CheckTable['delete']['theme']['0']['p']	= "theme";
self::$CheckTable['delete']['theme']['0']['s']	= "name";

self::$CheckTable['assign']['theme']['0']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['assign']['theme']['0']['f']	= function ($a) {return array("SELECT sd.theme_id, sd.theme_name FROM " . $a['sqlTables']['theme_descriptor'] . " sd, " . $a['sqlTables']['theme_website'] . " ss WHERE sd.theme_name = '" . $a['params']['name'] . "' AND sd.theme_id = ss.fk_theme_id AND ss.fk_ws_id = '" . $a['Context']['ws_id'] . "';");};
self::$CheckTable['assign']['theme']['0']['c']	= "theme_id";
self::$CheckTable['assign']['theme']['0']['v']	= "theme_id";
self::$CheckTable['assign']['theme']['0']['m']	= "CLI_AssignTheme_A001";
self::$CheckTable['assign']['theme']['0']['p']	= "theme";
self::$CheckTable['assign']['theme']['0']['s']	= "name";
self::$CheckTable['assign']['theme']['1']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['assign']['theme']['1']['f']	= function ($a) {return array("SELECT * FROM " . $a['sqlTables']["website"] . " WHERE ws_name = '" . $a['params']['to_website'] . "' ;");};
self::$CheckTable['assign']['theme']['1']['c']	= "ws_id";
self::$CheckTable['assign']['theme']['1']['v']	= "ws_id";
self::$CheckTable['assign']['theme']['1']['m']	= "CLI_AssignTheme_A002";
self::$CheckTable['assign']['theme']['1']['p']	= "site";
self::$CheckTable['assign']['theme']['1']['s']	= "to_website";


?>