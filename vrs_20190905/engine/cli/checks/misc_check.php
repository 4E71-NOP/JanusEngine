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

// Checkpoint
self::$CheckTable['set']['checkpoint']['0']['d']	= _EXECUTE_FUNCTION_;
self::$CheckTable['set']['checkpoint']['0']['f']	= function ($a) {
	$ret = 0;
	if (strlen($a['params']['name']) > 0) {
		$ret = 1;
	}
	return $ret;};
self::$CheckTable['set']['checkpoint']['0']['m']	= "CLI_SetCheckpoint_S001";

// Variable
self::$CheckTable['set']['variable']['0']['d']	= _EXECUTE_FUNCTION_;
self::$CheckTable['set']['variable']['0']['f']	= function ($a) {
	$ret = 0;
	$tab = array("installMonitor", "DebugLevel_SQL", "DebugLevel_CC", "DebugLevel_PHP", "DebugLevel_JS", "LogTarget");
	foreach ($tab as $var) {
		if ($var == $a['params']['name']) {
			$ret = 1;
		}
	}
	return $ret;};
self::$CheckTable['set']['variable']['0']['m']	= "CLI_SetVariable_S001";



?>