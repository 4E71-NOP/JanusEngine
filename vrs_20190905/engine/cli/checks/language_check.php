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

// Language (is not a entity in itself) 
self::$CheckTable['assign']['language']['0']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['assign']['language']['0']['f']	= function ($a) {return array("SELECT ws_id,ws_name FROM " . $a['sqlTables']['website'] . " WHERE ws_name = '" . $a['params']['to_website'] . "';");};
self::$CheckTable['assign']['language']['0']['c']	= "ws_id";
self::$CheckTable['assign']['language']['0']['v']	= "ws_id";
self::$CheckTable['assign']['language']['0']['m']	= "CLI_AddLang_A001";
self::$CheckTable['assign']['language']['0']['p']	= "site";
self::$CheckTable['assign']['language']['0']['s']	= "to_website";
self::$CheckTable['assign']['language']['1']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['assign']['language']['1']['f']	= function ($a) {return array("SELECT lang_id FROM " . $a['sqlTables']['language'] . " WHERE lang_639_3 = '" . $a['params']['name'] . "'");};
self::$CheckTable['assign']['language']['1']['c']	= "lang_id";
self::$CheckTable['assign']['language']['1']['v']	= "lang_id";
self::$CheckTable['assign']['language']['1']['m']	= "CLI_AddLang_A002";
self::$CheckTable['assign']['language']['1']['p']	= "language";
self::$CheckTable['assign']['language']['1']['s']	= "name";

?>
