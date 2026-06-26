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
//	
//--------------------------------------------------------------------------------
self::$ActionTable['assign']['language']		= function (&$a) { return array("INSERT INTO " . $a['sqlTables']['language_website'] . " (lang_website_id, fk_ws_id, fk_lang_id) VALUES (" . $a['params']['lang_website_id'] . ", " . $a['params']['ws_id'] . ", " . $a['params']['lang_id'] . ");"); };

?>