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

// Tag
self::$CheckTable['add']['tag']['0']['d']	= _FIND_DUPLICATE_;
self::$CheckTable['add']['tag']['0']['f']	= function ($a) {return array("SELECT tag_id,tag_name FROM " . $a['sqlTables']['tag'] . " WHERE tag_name = '" . $a['params']['name'] . "' AND fk_ws_id = '" . $a['Context']['ws_id'] . "';");};
self::$CheckTable['add']['tag']['0']['m']	= "CLI_Tag_C001";
self::$CheckTable['add']['tag']['0']['s']	= "name";

self::$CheckTable['assign']['tag']['0']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['assign']['tag']['0']['f']	= function ($a) {return array("SELECT tag_id,tag_name FROM " . $a['sqlTables']['tag'] . " WHERE tag_name = '" . $a['params']['name'] . "' AND fk_ws_id = '" . $a['Context']['ws_id'] . "';");};
self::$CheckTable['assign']['tag']['0']['c']	= "tag_id";
self::$CheckTable['assign']['tag']['0']['v']	= "tag_id";
self::$CheckTable['assign']['tag']['0']['m']	= "CLI_Tag_A001";
self::$CheckTable['assign']['tag']['0']['p']	= "tag";
self::$CheckTable['assign']['tag']['0']['s']	= "name";
self::$CheckTable['assign']['tag']['1']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['assign']['tag']['1']['f']	= function ($a) {return array("SELECT arti_id,arti_name FROM " . $a['sqlTables']['article'] . " WHERE arti_name = '" . $a['params']['article'] . "' AND fk_ws_id = '" . $a['Context']['ws_id'] . "';");};
self::$CheckTable['assign']['tag']['1']['c']	= "arti_id";
self::$CheckTable['assign']['tag']['1']['v']	= "arti_id";
self::$CheckTable['assign']['tag']['1']['m']	= "CLI_Tag_A002";
self::$CheckTable['assign']['tag']['1']['p']	= "article";
self::$CheckTable['assign']['tag']['1']['s']	= "article";
self::$CheckTable['assign']['tag']['2']['d']	= _FIND_DUPLICATE_;
self::$CheckTable['assign']['tag']['2']['f']	= function ($a) {return array("SELECT fk_tag_id FROM " . $a['sqlTables']['article_tag'] . " WHERE fk_tag_id = '" . $a['params']['tag_id'] . "' AND fk_arti_id = '" . $a['params']['arti_id'] . "';");};
self::$CheckTable['assign']['tag']['2']['m']	= "CLI_Tag_A003";
self::$CheckTable['assign']['tag']['2']['p']	= "link";
self::$CheckTable['assign']['tag']['2']['s']	= "tag_id";

self::$CheckTable['delete']['tag']['0']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['delete']['tag']['0']['f']	= function ($a) {return array("SELECT tag_id,tag_name FROM " . $a['sqlTables']['tag'] . " WHERE BINARY tag_name = '" . $a['params']['name'] . "' AND fk_ws_id = '" . $a['Context']['ws_id'] . "';");};
self::$CheckTable['delete']['tag']['0']['c']	= "tag_id";
self::$CheckTable['delete']['tag']['0']['v']	= "tag_id";
self::$CheckTable['delete']['tag']['0']['m']	= "CLI_Tag_U001";
self::$CheckTable['delete']['tag']['0']['p']	= "tag";
self::$CheckTable['delete']['tag']['0']['s']	= "name";

?>