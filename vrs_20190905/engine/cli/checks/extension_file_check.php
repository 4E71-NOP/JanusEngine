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

// Extension file
self::$CheckTable['add']['extension_file']['0']['d'] = _FIND_DUPLICATE_;
self::$CheckTable['add']['extension_file']['0']['f'] = function ($a) {return array("SELECT extfil_id FROM " . $a['sqlTables']['extension_file'] . " WHERE extfil_generic_name = '" . $a['params']['generic_name'] . "';");};
self::$CheckTable['add']['extension_file']['0']['m'] = "CLI_extension_file_C001";
self::$CheckTable['add']['extension_file']['0']['s'] = "name";
self::$CheckTable['add']['extension_file']['1']['d'] = _RETURN__DATA_AND_ERROR_;
self::$CheckTable['add']['extension_file']['1']['f'] = function ($a) {return array("SELECT ext_id FROM " . $a['sqlTables']['extension'] . " WHERE ext_name = '" . $a['params']['extension'] . "';");};
self::$CheckTable['add']['extension_file']['1']['c'] = "ext_id";
self::$CheckTable['add']['extension_file']['1']['v'] = "fk_ext_id";
self::$CheckTable['add']['extension_file']['1']['p'] = "extension";
self::$CheckTable['add']['extension_file']['1']['m'] = "CLI_extension_file_C001";
self::$CheckTable['add']['extension_file']['1']['s'] = "extension_file";

self::$CheckTable['delete']['extension_file']['0']['d'] = _RETURN__DATA_AND_ERROR_;
self::$CheckTable['delete']['extension_file']['0']['f'] = function ($a) {return array("SELECT e.extfil_id FROM " . $a['sqlTables']['extension_file'] . " e WHERE e.extfil_name = '" . $a['params']['name'] . "';");};
self::$CheckTable['delete']['extension_file']['0']['c'] = "extfil_id";
self::$CheckTable['delete']['extension_file']['0']['v'] = "extfil_id";
self::$CheckTable['delete']['extension_file']['0']['m'] = "CLI_extension_file_D001";
self::$CheckTable['delete']['extension_file']['0']['p'] = "extension_file";
self::$CheckTable['delete']['extension_file']['0']['s'] = "name";

?>