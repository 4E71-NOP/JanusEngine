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

// Definition
self::$CheckTable['add']['definition']['1']['d']	= _FIND_DUPLICATE_;
self::$CheckTable['add']['definition']['1']['f']	= function ($a) {return array("SELECT def.def_id  FROM " . $a['sqlTables']['definition'] . " def WHERE def.def_name = '" . $a['params']['name'] . "';");};
self::$CheckTable['add']['definition']['1']['m']	= "CLI_Definition_C001";
self::$CheckTable['add']['definition']['1']['s']	= "def_id";

?>