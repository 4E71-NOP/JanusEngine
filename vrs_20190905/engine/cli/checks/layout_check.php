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

// Layout
self::$CheckTable['add']['layout']['0']['d']	= _FIND_DUPLICATE_;
self::$CheckTable['add']['layout']['0']['f']	= function ($a) {return array("SELECT layout_id,layout_name FROM " . $a['sqlTables']['layout'] . " WHERE layout_name = '" . $a['params']['name'] . "';");};
self::$CheckTable['add']['layout']['0']['m']	= "CLI_Layout_C001";
self::$CheckTable['add']['layout']['0']['s']	= "name";
self::$CheckTable['add']['layout']['0']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['add']['layout']['0']['f']	= function ($a) {return array("SELECT layout_file_id FROM " . $a['sqlTables']['layout_file'] . " WHERE layout_file_name = '" . $a['params']['layout_file'] . "';");};
self::$CheckTable['add']['layout']['0']['c']	= "layout_file_id";
self::$CheckTable['add']['layout']['0']['v']	= "layout_file";
self::$CheckTable['add']['layout']['0']['m']	= "CLI_Layout_C002";
self::$CheckTable['add']['layout']['0']['p']	= "layout_file";
self::$CheckTable['add']['layout']['0']['s']	= "file";

self::$CheckTable['update']['layout']['0']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['update']['layout']['0']['f']	= function ($a) {return array("SELECT layout_id,layout_name FROM " . $a['sqlTables']['layout'] . " WHERE layout_name = '" . $a['params']['name'] . "';");};
self::$CheckTable['update']['layout']['0']['c']	= "layout_id";
self::$CheckTable['update']['layout']['0']['v']	= "layout_id";
self::$CheckTable['update']['layout']['0']['m']	= "CLI_Layout_U001";
self::$CheckTable['update']['layout']['0']['p']	= "layout";
self::$CheckTable['update']['layout']['0']['s']	= "name";

self::$CheckTable['delete']['layout']['0']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['delete']['layout']['0']['f']	= function ($a) {return array("SELECT layout_id,layout_name FROM " . $a['sqlTables']['layout'] . " WHERE layout_name = '" . $a['params']['name'] . "';");};
self::$CheckTable['delete']['layout']['0']['c']	= "layout_id";
self::$CheckTable['delete']['layout']['0']['v']	= "layout_id";
self::$CheckTable['delete']['layout']['0']['m']	= "CLI_Layout_D001";
self::$CheckTable['delete']['layout']['0']['p']	= "layout";
self::$CheckTable['delete']['layout']['0']['s']	= "name";

self::$CheckTable['assign']['layout']['0']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['assign']['layout']['0']['f']	= function ($a) {return array("SELECT layout_id,layout_name FROM " . $a['sqlTables']['layout'] . " WHERE layout_name = '" . $a['params']['name'] . "';");};
self::$CheckTable['assign']['layout']['0']['c']	= "layout_id";
self::$CheckTable['assign']['layout']['0']['v']	= "layout_id";
self::$CheckTable['assign']['layout']['0']['m']	= "CLI_Layout_A001";
self::$CheckTable['assign']['layout']['0']['p']	= "layout";
self::$CheckTable['assign']['layout']['0']['s']	= "name";
self::$CheckTable['assign']['layout']['1']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['assign']['layout']['1']['f']	= function ($a) {return array("SELECT sd.theme_id AS theme_id, sd.theme_name AS theme_name FROM " . $a['sqlTables']['theme_descriptor'] . " sd, " . $a['sqlTables']['theme_website'] . " ss WHERE sd.theme_name = '" . $a['params']['to_theme'] . "' AND sd.theme_id = ss.fk_theme_id AND ss.fk_ws_id = '" . $a['Context']['ws_id'] . "';");};
self::$CheckTable['assign']['layout']['1']['c']	= "theme_id";
self::$CheckTable['assign']['layout']['1']['v']	= "theme_id";
self::$CheckTable['assign']['layout']['1']['m']	= "CLI_Layout_A002";
self::$CheckTable['assign']['layout']['1']['p']	= "layout";
self::$CheckTable['assign']['layout']['1']['s']	= "to_theme";

?>