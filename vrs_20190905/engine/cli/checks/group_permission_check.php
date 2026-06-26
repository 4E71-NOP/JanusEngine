<?php
// @JanusEngine:license-start
// --------------------------------------------------------------------------------------------
// Janus Engine 
//
// This file file is part of the Janus-Engine project.
// @see       : https://github.com/4E71-NOP/JanusEngine
//
// @license   : Creative Commons licence CC-by-nc-sa (https://creativecommons.org/licenses/by-nc-sa/4.0/)
// @author    : Faust MARIA DE AREVALO (original founder) <faust@rootwave.com>
// @copyright : 2005 - ∞ Faust MARIA DE AREVALO
//
// @note      : This program is distributed in the hope that it will be useful - WITHOUT ANY WARRANTY; 
//              without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
//
// Check README.md for more details
// --------------------------------------------------------------------------------------------
// @JanusEngine:license-end


// d=Directive
//		Directive = 1 : _RETURN_DATA_ONLY_			/ Return the data in (v)ariable. No error message.
//		Directive = 2 : _RETURN_DATA_AND_ERROR_	/ Return the data in (v)ariable. If an error occurs, a message is stored and a flag is set.
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

self::$CheckTable['assign']['group_permission']['0']['d']	= _RETURN_DATA_AND_ERROR_;
self::$CheckTable['assign']['group_permission']['0']['f']	= function ($a) {return array("SELECT CONCAT('0x', HEX(prm.perm_id)) AS perm_id FROM " . $a['sqlTables']['permission'] . " prm WHERE prm.perm_name = '" . $a['params']['name'] . "' ;");};
self::$CheckTable['assign']['group_permission']['0']['c']	= "perm_id";
self::$CheckTable['assign']['group_permission']['0']['v']	= "perm_id";
self::$CheckTable['assign']['group_permission']['0']['m']	= "CLI_Permission_A001";
self::$CheckTable['assign']['group_permission']['0']['p']	= "permission";
self::$CheckTable['assign']['group_permission']['0']['s']	= "perm_id";
self::$CheckTable['assign']['group_permission']['1']['d']	= _RETURN_DATA_ONLY_;
self::$CheckTable['assign']['group_permission']['1']['f']	= function ($a) {return array("SELECT CONCAT('0x', HEX(grp.group_id)) AS group_id FROM " . $a['sqlTables']['group'] . " grp , " . $a['sqlTables']['group_website'] . " sg , " . $a['sqlTables']['website'] . " ws WHERE grp.group_name = '" . $a['params']['to_group'] . "' AND grp.group_id = sg.fk_group_id AND sg.fk_ws_id = ws.ws_id AND ws.ws_id = " . $a['Context']['ws_id'] . ";");};
self::$CheckTable['assign']['group_permission']['1']['c']	= "group_id";
self::$CheckTable['assign']['group_permission']['1']['v']	= "group_id";
self::$CheckTable['assign']['group_permission']['1']['m']	= "CLI_Permission_A002";
self::$CheckTable['assign']['group_permission']['1']['p']	= "group";
self::$CheckTable['assign']['group_permission']['1']['s']	= "group_id";

?>