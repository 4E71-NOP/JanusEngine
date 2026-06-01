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

// Vous serrez peut etre obligé de rajouter le préfix de votre compte chez l'hébergeur.
// You may need to insert the 'account prefix' depending on web hosters.
// ex DB = <user>_yourdatabase

$fileContent = array(
	"ws_short"			=> "Rw",
	"type"				=> "mysql",
	"charset"			=> "utf8mb4",
	"host"				=> "localhost",
	"port"				=> "",
	"dal"				=> "PDO",				// PDO (MYSQLI is deprecated in PHP >8.2 )
	"db_user_login"		=> "texmex_JnsEngAdmDB",
	"db_user_password"	=> "9eBFs>vQX(kt.Ptfr>4x",
	"dbprefix"			=> "texmex_JnsEng",
	"tabprefix"			=> "Jet_",
	"SessionMaxAge" 	=> (60 * 60 * 24),			// 24 hours by default
	"DebugLevel_SQL"	=> LOGLEVEL_WARNING,	// SDDM
	"DebugLevel_CC"		=> LOGLEVEL_WARNING,	// Command console
	"DebugLevel_PHP"	=> LOGLEVEL_WARNING,	// 
	"DebugLevel_JS"		=> LOGLEVEL_WARNING,	// 
	"execution_context"	=> "render",
	"InsertStatistics"	=> 1,
	"mail"				=> array(
		"host" => "",
		"username" => "",
		"password" => ""
	),
	"commandLineEngine"	=> array(
		// Specific to command like engine
	),
		"functions" => array(
			"user_sign_up"			=> "enabled",
			"commandLineEngine"		=> "enabled",
		),
	);
	