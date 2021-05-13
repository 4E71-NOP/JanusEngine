<?php
// --------------------------------------------------------------------------------------------
//
//	MWM - Multi Web Manager
//	Sous licence Creative common
//	Under Creative Common licence	CC-by-nc-sa (http://creativecommons.org)
//	CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
//	(c)2005-∞ Faust MARIA DE AREVALO faust@multiweb-manager.net
//
// --------------------------------------------------------------------------------------------
//	Le nom du site utilisé pour la base de données
//	The name used for the database
//	Gen : 2018-07-01
//	00_Hydre

// Vous serrez peut etre obligé de rajouter le préfix de votre compte chez l'hébergeur.
// You may need to insert the 'account prefix' depending on web hosters.
// ex DB = <user>_yourdatabase

if ( $pv['ObjectMode'] == 1 ) {
	function returnConfig () {
		$tab = array();
		$tab['type']				= "mysql";
		$tab['charset']				= "utf8mb4";
		$tab['host']				= "mysql";
		$tab['dal']					= "MYSQLI";						// MYSQLI , PDOMYSQL
		$tab['db_user_login']		= "HydreBDD";
		$tab['db_user_password']	= "Celeste";
		$tab['dbprefix']			= "Hdr";
		$tab['tabprefix']			= "Ht_";
		$tab['SessionMaxAge'] = (60*60*24);							// 24 hours by default
		
		$tab['DebugLevel_SQL']	= LOGLEVEL_WARNING;					// SDDM
		$tab['DebugLevel_CC']	= LOGLEVEL_WARNING;					// Command console
		$tab['DebugLevel_PHP']	= LOGLEVEL_WARNING;					// 
		$tab['DebugLevel_JS']	= LOGLEVEL_WARNING;					// 

		$tab['execution_context'] 	= "render";
		$tab['InsertStatistics'] = 1;
		$tab['commandLineEngine'] = array(
				"state"		=>	"enabled",
		);
		return $tab;
	}
}

?>
