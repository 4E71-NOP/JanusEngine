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

// Extension
self::$CheckTable['add']['extension']['0']['d'] = _FIND_DUPLICATE_;
self::$CheckTable['add']['extension']['0']['f'] = function ($a) {return array("SELECT e.ext_id FROM " . $a['sqlTables']['extension'] . " e WHERE e.ext_name = '" . $a['params']['name'] . "' AND e.fk_ws_id = '" . $a['Context']['ws_id'] . "';");};
self::$CheckTable['add']['extension']['0']['m'] = "CLI_extension_C001";
self::$CheckTable['add']['extension']['0']['s'] = "name";

self::$CheckTable['delete']['extension']['0']['d'] = _RETURN__DATA_AND_ERROR_;
self::$CheckTable['delete']['extension']['0']['f'] = function ($a) {return array("SELECT e.ext_id, e.ext_name FROM " . $a['sqlTables']['extension'] . " e WHERE e.ext_name = '" . $a['params']['name'] . "' AND e.fk_ws_id = '" . $a['Context']['ws_id'] . "';");};
self::$CheckTable['delete']['extension']['0']['c'] = "ext_id";
self::$CheckTable['delete']['extension']['0']['v'] = "fk_ext_id";
self::$CheckTable['delete']['extension']['0']['m'] = "CLI_extension_D001";
self::$CheckTable['delete']['extension']['0']['p'] = "extension";
self::$CheckTable['delete']['extension']['0']['s'] = "name";

?>
