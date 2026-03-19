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

// Translation
self::$CheckTable['add']['translation']['0']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['add']['translation']['0']['f']	= function ($a) {return array("SELECT lang_id FROM " . $a['sqlTables']['language'] . " WHERE lang_639_3 = '" . $a['params']['lang'] . "'");};
self::$CheckTable['add']['translation']['0']['c']	= "lang_id";
self::$CheckTable['add']['translation']['0']['v']	= "lang_id";
self::$CheckTable['add']['translation']['0']['m']	= "CLI_Translation_C001";
self::$CheckTable['add']['translation']['0']['p']	= "language";
self::$CheckTable['add']['translation']['0']['s']	= "lang";
self::$CheckTable['add']['translation']['1']['d']	= _FIND_DUPLICATE_;
self::$CheckTable['add']['translation']['1']['f']	= function ($a) {return array("SELECT * FROM " . $a['sqlTables']['i18n'] . " WHERE fk_lang_id = '" . $a['params']['lang_id'] . "' AND i18n_package = '" . $a['params']['package'] . "' AND i18n_name = '" . $a['params']['name'] . "';");};
self::$CheckTable['add']['translation']['1']['m']	= "CLI_Translation_C002";
self::$CheckTable['add']['translation']['1']['s']	= "name";

?>