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

// KeyWord
self::$CheckTable['add']['keyword']['0']['d']	= _FIND_DUPLICATE_;
self::$CheckTable['add']['keyword']['0']['f']	= function ($a) {return array("SELECT keyword_id FROM " . $a['sqlTables']['keyword'] . " WHERE keyword_name = '" . $a['params']['name'] . "' AND fk_ws_id = '" . $a['Context']['ws_id'] . "';");};
self::$CheckTable['add']['keyword']['0']['m']	= "CLI_KeyWord_C001";
self::$CheckTable['add']['keyword']['0']['s']	= "name";
self::$CheckTable['add']['keyword']['1']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['add']['keyword']['1']['f']	= function ($a) {return array("SELECT arti_id,arti_name FROM " . $a['sqlTables']['article'] . " WHERE arti_name = '" . $a['params']['article'] . "' AND fk_ws_id = '" . $a['Context']['ws_id'] . "';");};
self::$CheckTable['add']['keyword']['1']['c']	= "arti_id";
self::$CheckTable['add']['keyword']['1']['v']	= "arti_id";
self::$CheckTable['add']['keyword']['1']['m']	= "CLI_KeyWord_C002";
self::$CheckTable['add']['keyword']['1']['p']	= "article";
self::$CheckTable['add']['keyword']['1']['s']	= "article";


self::$CheckTable['update']['keyword']['0']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['update']['keyword']['0']['f']	= function ($a) {return array("SELECT keyword_id FROM " . $a['sqlTables']['keyword'] . " WHERE keyword_name = '" . $a['params']['name'] . "' AND fk_ws_id = '" . $a['Context']['ws_id'] . "';");};
self::$CheckTable['update']['keyword']['0']['c']	= "keyword_id";
self::$CheckTable['update']['keyword']['0']['v']	= "keyword_id";
self::$CheckTable['update']['keyword']['0']['m']	= "CLI_KeyWord_U002";
self::$CheckTable['update']['keyword']['0']['p']	= "keyword";
self::$CheckTable['update']['keyword']['0']['s']	= "name";
self::$CheckTable['update']['keyword']['1']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['update']['keyword']['1']['f']	= function ($a) {return array("SELECT arti_id,arti_name FROM " . $a['sqlTables']['article'] . " WHERE arti_name = '" . $a['params']['article'] . "' AND fk_ws_id = '" . $a['Context']['ws_id'] . "';");};
self::$CheckTable['update']['keyword']['1']['c']	= "arti_id";
self::$CheckTable['update']['keyword']['1']['v']	= "arti_id";
self::$CheckTable['update']['keyword']['1']['m']	= "CLI_KeyWord_U002";
self::$CheckTable['update']['keyword']['1']['p']	= "article";
self::$CheckTable['update']['keyword']['1']['s']	= "article";

self::$CheckTable['delete']['keyword']['0']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['delete']['keyword']['0']['f']	= function ($a) {return array("SELECT keyword_id FROM " . $a['sqlTables']['keyword'] . " WHERE keyword_name = '" . $a['params']['name'] . "' AND fk_ws_id = '" . $a['Context']['ws_id'] . "';");};
self::$CheckTable['delete']['keyword']['0']['c']	= "keyword_id";
self::$CheckTable['delete']['keyword']['0']['v']	= "keyword_id";
self::$CheckTable['delete']['keyword']['0']['m']	= "CLI_KeyWord_D002";
self::$CheckTable['delete']['keyword']['0']['p']	= "keyword";
self::$CheckTable['delete']['keyword']['0']['s']	= "name";

?>