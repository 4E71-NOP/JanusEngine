<?php
//--------------------------------------------------------------------------------
//	Add
//--------------------------------------------------------------------------------
//@formatter:off
self::$ActionTable['add']['extension_file']	= function (&$a) { return array("INSERT INTO " . $a['sqlTables']['extension_file']	. " (" . $a['columns'] . ") VALUES (" . $a['values'] . ");"); };

//@formatter:on
