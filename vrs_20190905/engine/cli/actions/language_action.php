<?php
//--------------------------------------------------------------------------------
//	
//--------------------------------------------------------------------------------
self::$ActionTable['assign']['language']		= function (&$a) { return array("INSERT INTO " . $a['sqlTables']['language_website'] . " VALUES ('" . $a['params']['lang_website_id'] . "', '" . $a['params']['ws_id'] . "', '" . $a['params']['lang_id'] . "');"); };

?>