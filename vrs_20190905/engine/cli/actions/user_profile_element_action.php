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

//--------------------------------------------------------------------------------
//	profile_element
//--------------------------------------------------------------------------------
//@formatter:off
self::$ActionTable['add']['user_profile_element']	= function (&$a) { return array("INSERT INTO " . $a['sqlTables']['user_profile_element'] . " (" . $a['columns'] . ") VALUES (" . $a['values'] . ");"); };
self::$ActionTable['delete']['user_profile_element']	= function (&$a) { return array("UPDATE " . $a['sqlTables']['user_profile_element']	. " SET upe_state=0			WHERE upe_id = '"			. $a['params']['id'] . "';"); };
//@formatter:on

?>