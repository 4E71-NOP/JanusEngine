<?php
//--------------------------------------------------------------------------------
//	Add
//--------------------------------------------------------------------------------
// Directive 4
self::$ActionTable['set']['checkpoint']		= function (&$a) {
	$bts = BaseToolSet::getInstance();
	$bts->MapperObj->setWhereWeAreAt($a['params']['name']);
	$bts->LMObj->logCheckpoint($a['params']['name']);
};

// Directive 4
self::$ActionTable['set']['variable']		= function (&$a) {
	$bts = BaseToolSet::getInstance();
	$bts->CMObj->setConfigurationEntry($a['params']['name'], $a['params']['value']); 
};

?>