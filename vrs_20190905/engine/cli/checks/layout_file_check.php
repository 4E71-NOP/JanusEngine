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

// Layout file
self::$CheckTable['add']['layout_file']['0']['d']	= _FIND_DUPLICATE_;
self::$CheckTable['add']['layout_file']['0']['f']	= function ($a) {return array("SELECT layout_file_id,layout_file_name FROM " . $a['sqlTables']['layout_file'] . " WHERE layout_file_name = '" . $a['params']['name'] . "';");};
self::$CheckTable['add']['layout_file']['0']['m']	= "CLI_layout_file_D001";
self::$CheckTable['add']['layout_file']['0']['s']	= "name";

self::$CheckTable['update']['layout_file']['0']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['update']['layout_file']['0']['f']	= function ($a) {return array("SELECT layout_file_id,layout_file_name FROM " . $a['sqlTables']['layout_file'] . " WHERE layout_file_name = '" . $a['params']['name'] . "';");};
self::$CheckTable['update']['layout_file']['0']['c']	= "layout_file_id";
self::$CheckTable['update']['layout_file']['0']['v']	= "layout_file_id";
self::$CheckTable['update']['layout_file']['0']['m']	= "CLI_layout_file_U001";
self::$CheckTable['update']['layout_file']['0']['p']	= "layout file";
self::$CheckTable['update']['layout_file']['0']['s']	= "name";

self::$CheckTable['delete']['layout_file']['0']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['delete']['layout_file']['0']['f']	= function ($a) {return array("SELECT layout_file_id,layout_file_name FROM " . $a['sqlTables']['layout_file'] . " WHERE layout_file_name = '" . $a['params']['name'] . "';");};
self::$CheckTable['delete']['layout_file']['0']['c']	= "layout_file_id";
self::$CheckTable['delete']['layout_file']['0']['v']	= "layout_file_id";
self::$CheckTable['delete']['layout_file']['0']['m']	= "CLI_layout_file_D001";
self::$CheckTable['delete']['layout_file']['0']['p']	= "layout file";
self::$CheckTable['delete']['layout_file']['0']['s']	= "name";

?>
