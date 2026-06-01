<?php
// // @JanusEngine:license-start
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

//	This config file has been generated.
//	Date		:	" . $bts->TimeObj->timestampToDate($bts->TimeObj->getMicrotime()) . "
//	Filename	:	site_" . $infos['n'] . "_config.php
//	
//	
// You may need to insert the 'account prefix' depending on web hosters.
// ex DB = <user>_yourdatabase

\$fileContent = array(
	\"ws_short\"			=> \"JnsEngCore\",
	\"type\"				=> \"" . $bts->CMObj->getConfigurationSubEntry('db', 'type') . "\",	// mysql, pgsql
	\"charset\"				=> \"utf8mb4\",
	\"host\"				=> \"" . $bts->CMObj->getConfigurationSubEntry('db', 'host') . "\",
	\"port\"				=> \"" . $bts->CMObj->getConfigurationSubEntry('db', 'type') . "\",
	\"dal\"					=> \"" . $bts->CMObj->getConfigurationSubEntry('db', 'type') . "\", // PDO, PHP
	\"db_user_login\"		=> \"" . $bts->CMObj->getConfigurationSubEntry('db', 'dataBaseUserLogin') . "\",
	\"db_user_password\"	=> \"" . $bts->CMObj->getConfigurationSubEntry('db', 'dataBaseUserPassword') . "\",
	\"dbprefix\"			=> \"" . $bts->CMObj->getConfigurationSubEntry('db', 'dbprefix') . "\",
	\"tabprefix\"			=> \"" . $bts->CMObj->getConfigurationSubEntry('db', 'tabprefix') . "\",
	\"SessionMaxAge\" 		=> (60 * 60 * 24),			// 24 hours by default
	\"DebugLevel_SQL\"		=> LOGLEVEL_WARNING,	// SDDM
	\"DebugLevel_CC\"		=> LOGLEVEL_WARNING,	// Command console
	\"DebugLevel_PHP\"		=> LOGLEVEL_WARNING,	// 
	\"DebugLevel_JS\"		=> LOGLEVEL_WARNING,	// 
	\"execution_context\"	=> \"render\",
	\"InsertStatistics\"	=> 1,
	\"mail\"				=> array(
		\"host\" 		=> \"" . $bts->CMObj->getConfigurationSubEntry('mail', 'host') . "\",
		\"username\"	=> \"" . $bts->CMObj->getConfigurationSubEntry('mail', 'username') . "\",
		\"password\"	=> \"" . $bts->CMObj->getConfigurationSubEntry('mail', 'password') . "\",
	),
	\"commandLineEngine\"	=> array(
	// Specific to command like engine
	),
	\"functions\" => array(
		\"user_sign_up\" => \"enabled\",
		\"commandLineEngine\"	=> \"enabled\", 
	),
?>
";

		return $Content;
	}
}
