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

// Module
self::$CheckTable['add']['module']['0']['d']	= _FIND_DUPLICATE_;
self::$CheckTable['add']['module']['0']['f']	= function ($a) {return array("SELECT mdl.module_id FROM " . $a['sqlTables']['module'] . " mdl , " . $a['sqlTables']['module_website'] . " sm WHERE mdl.module_name = '" . $a['params']['name'] . "' AND mdl.module_id = sm.fk_module_id AND sm.fk_ws_id = '" . $a['Context']['ws_id'] . "';");};
self::$CheckTable['add']['module']['0']['m']	= "CLI_Module_C001";
self::$CheckTable['add']['module']['0']['s']	= "name";

self::$CheckTable['add']['module']['1']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['add']['module']['1']['f']	= function ($a) {return array("SELECT prm.perm_id AS perm_id FROM " . $a['sqlTables']['permission'] . " prm WHERE prm.perm_name = '" . $a['params']['permission'] . "' ;");};
self::$CheckTable['add']['module']['1']['c']	= "perm_id";
self::$CheckTable['add']['module']['1']['v']	= "fk_perm_id";
self::$CheckTable['add']['module']['1']['m']	= "CLI_Module_C004";
self::$CheckTable['add']['module']['1']['p']	= "permission";
self::$CheckTable['add']['module']['1']['s']	= "name";

self::$CheckTable['update']['module']['0']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['update']['module']['0']['f']	= function ($a) {return array("SELECT mdl.module_id FROM " . $a['sqlTables']['module'] . " mdl , " . $a['sqlTables']['module_website'] . " sm WHERE mdl.module_name = '" . $a['params']['name'] . "' AND mdl.module_id = sm.fk_module_id AND sm.fk_ws_id = '" . $a['Context']['ws_id'] . "';");};
self::$CheckTable['update']['module']['0']['c']	= "module_id";
self::$CheckTable['update']['module']['0']['v']	= "module_id";
self::$CheckTable['update']['module']['0']['m']	= "CLI_Module_C001";
self::$CheckTable['update']['module']['0']['p']	= "";
self::$CheckTable['update']['module']['0']['s']	= "name";
self::$CheckTable['update']['module']['1']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['update']['module']['1']['f']	= function ($a) {return array("SELECT prm.perm_id AS perm_id FROM " . $a['sqlTables']['permission'] . " prm WHERE prm.perm_name = '" . $a['params']['permission'] . "' ;");};
self::$CheckTable['update']['module']['1']['c']	= "perm_id";
self::$CheckTable['update']['module']['1']['v']	= "fk_perm_id";
self::$CheckTable['update']['module']['1']['m']	= "CLI_Module_C002";
self::$CheckTable['update']['module']['1']['p']	= "permission";
self::$CheckTable['update']['module']['1']['s']	= "name";

self::$CheckTable['delete']['module']['0']['d']	= _RETURN__DATA_AND_ERROR_;
self::$CheckTable['delete']['module']['0']['f']	= function ($a) {return array("SELECT mdl.module_id FROM " . $a['sqlTables']['module'] . " mdl , " . $a['sqlTables']['module_website'] . " sm WHERE mdl.module_name = '" . $a['params']['name'] . "' AND mdl.module_id = sm.fk_module_id AND sm.fk_ws_id = '" . $a['Context']['ws_id'] . "';");};
self::$CheckTable['delete']['module']['0']['c']	= "module_id";
self::$CheckTable['delete']['module']['0']['v']	= "module_id";
self::$CheckTable['delete']['module']['0']['m']	= "CLI_Module_D001";
self::$CheckTable['delete']['module']['0']['p']	= "module";
self::$CheckTable['delete']['module']['0']['s']	= "name";

?>