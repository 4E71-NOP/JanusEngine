<?php
// --------------------------------------------------------------------------------------------
//
//	JnsEng - Janus Engine
//	Sous licence Creative common
//	Under Creative Common licence	CC-by-nc-sa (http://creativecommons.org)
//	CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
//	(c)2005-∞ Faust MARIA DE AREVALO faust@multiweb-manager.net
//
// --------------------------------------------------------------------------------------------
// Vous serrez peut etre obligé de rajouter le préfix de votre compte chez l'hébergeur.
// You may need to insert the 'account prefix' depending on web hosters.
// ex DB = <user>_yourdatabase

$fileContent = array(
	"ws_short"			=> "xxx",
	"type"				=> "mysql",
	"charset"			=> "utf8mb4",
	"host"				=> "mysql",
	"port"				=> "",
	"dal"				=> "PDO",				// MYSQLI , PDOMYSQL
	"db_user_login"		=> "JnsEngAdmBDD",
	"db_user_password"	=> "9eBFs>vQX(kt.Ptfr>4x",
	"dbprefix"			=> "JnsEng",
	"tabprefix"			=> "Jt_",
	"SessionMaxAge" 	=> (60*60*24),			// 24 hours by default
	"DebugLevel_SQL"	=> LOGLEVEL_WARNING,	// SDDM
	"DebugLevel_CC"		=> LOGLEVEL_WARNING,	// Command console
	"DebugLevel_PHP"	=> LOGLEVEL_WARNING,	// 
	"DebugLevel_JS"		=> LOGLEVEL_WARNING,	// 
	"execution_context"	=> "render",
	"InsertStatistics"	=> 1,
	"commandLineEngine"	=> array(
		"state"			=>	"enabled"
	)

);

?>
