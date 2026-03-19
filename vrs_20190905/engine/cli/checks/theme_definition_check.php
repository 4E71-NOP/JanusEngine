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

self::$CheckTable['add']['theme_definition']['0']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['add']['theme_definition']['0']['f']	= function ($a) {return array("SELECT td.theme_id, td.theme_name FROM " . $a['sqlTables']['theme_descriptor'] . " td, " . $a['sqlTables']['theme_website'] . " ws WHERE td.theme_name = '" . $a['params']['for_theme'] . "' AND td.theme_id = ws.fk_theme_id AND ws.fk_ws_id = '" . $a['Context']['ws_id'] . "';");};
self::$CheckTable['add']['theme_definition']['0']['c']	= "theme_id";
self::$CheckTable['add']['theme_definition']['0']['v']	= "fk_theme_id";
self::$CheckTable['add']['theme_definition']['0']['m']	= "CLI_Theme_definition_C002";
self::$CheckTable['add']['theme_definition']['0']['p']	= "theme";
self::$CheckTable['add']['theme_definition']['0']['s']	= "name";
self::$CheckTable['add']['theme_definition']['1']['d']	= _FIND_DUPLICATE_;
self::$CheckTable['add']['theme_definition']['1']['f']	= function ($a) {return array("SELECT tdf.def_id, tdf.def_name FROM " . $a['sqlTables']['theme_definition'] . " tdf, " . $a['sqlTables']['theme_descriptor'] . " td, " . $a['sqlTables']['theme_website'] . " tw WHERE tdf.def_name = '" . $a['params']['name'] . "' AND td.theme_name = '" . $a['params']['for_theme'] . "' AND tdf.fk_theme_id = td.theme_id AND td.theme_id = tw.fk_theme_id AND tw.fk_ws_id = '" . $a['Context']['ws_id'] . "';");};
self::$CheckTable['add']['theme_definition']['1']['m']	= "CLI_Theme_definition_C001";
self::$CheckTable['add']['theme_definition']['1']['s']	= "name";
self::$CheckTable['update']['theme_definition']['0']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['update']['theme_definition']['0']['f']	= function ($a) {return array("SELECT tdf.def_id, tdf.def_name FROM " . $a['sqlTables']['theme_definition'] . " tdf, " . $a['sqlTables']['theme_descriptor'] . " td, " . $a['sqlTables']['theme_website'] . " tw WHERE tdf.def_name = '" . $a['params']['name'] . "' AND tdf.fk_theme_id = td.theme_id AND td.theme_id = tw.fk_theme_id AND tdf.fk_theme_id = '" . $a['params']['fk_theme_id'] . "' AND tw.fk_ws_id = '" . $a['Context']['ws_id'] . "';");};
self::$CheckTable['update']['theme_definition']['0']['c']	= "def_id";
self::$CheckTable['update']['theme_definition']['0']['v']	= "def_id";
self::$CheckTable['update']['theme_definition']['0']['m']	= "CLI_Theme_definition_U001";
self::$CheckTable['update']['theme_definition']['0']['p']	= "theme definition";
self::$CheckTable['update']['theme_definition']['0']['s']	= "name";
self::$CheckTable['delete']['theme_definition']['0']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['delete']['theme_definition']['0']['f']	= function ($a) {return array("SELECT tdf.def_id, tdf.def_name FROM " . $a['sqlTables']['theme_definition'] . " tdf, " . $a['sqlTables']['theme_descriptor'] . " td, " . $a['sqlTables']['theme_website'] . " tw WHERE tdf.def_name = '" . $a['params']['name'] . "' AND tdf.fk_theme_id = td.theme_id AND td.theme_id = tw.fk_theme_id AND tdf.fk_theme_id = '" . $a['params']['fk_theme_id'] . "' AND tw.fk_ws_id = '" . $a['Context']['ws_id'] . "';");};
self::$CheckTable['delete']['theme_definition']['0']['c']	= "def_id";
self::$CheckTable['delete']['theme_definition']['0']['v']	= "def_id";
self::$CheckTable['delete']['theme_definition']['0']['m']	= "CLI_Theme_definition_D001";
self::$CheckTable['delete']['theme_definition']['0']['p']	= "theme definition";
self::$CheckTable['delete']['theme_definition']['0']['s']	= "name";

?>