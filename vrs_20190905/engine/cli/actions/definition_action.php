<?php
//--------------------------------------------------------------------------------
//	Definition
//--------------------------------------------------------------------------------
//@formatter:off
self::$ActionTable['add']['definition']			= function (&$a) { return array("INSERT INTO " . $a['sqlTables']['definition']		. " (" . $a['columns'] . ") VALUES (" . $a['values'] . ");"); };
//@formatter:on

// TODO update, delete, show

