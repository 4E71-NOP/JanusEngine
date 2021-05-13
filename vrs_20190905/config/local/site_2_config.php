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
//	www.multiweb-manager.net

// Vous serrez peut etre obligé de rajouter le préfix de votre compte chez l'hébergeur.
// You may need to insert the 'account prefix' depending on web hosters.
// ex DB = <user>_yourdatabase

$db_['type']			= "mysql";
$db_['host']			= "localhost";
$db_['dal']				= "MYSQLI";
$db_['user_login']		= "HydreBDD";
$db_['user_password']	= "Celeste";
$db_['dbprefix']		= "Hdr";
$db_['tabprefix']		= "Ht_";

//--------------------------------------------------------------------------------------------
//	Admin_info_debug
$maid_stats_nombre_de_couleurs = 5;

//--------------------------------------------------------------------------------------------
//	Session maximum time
$MWM_session_max_time = (60*60*24);

//--------------------------------------------------------------------------------------------
//	websites-data/00_Hydre/document/fra_layout_de_l_equipe_p01.php
$pde_img_aff = 1;
$pde_img_h = 32;																	//height
$pde_img_l = 32;																	//width

if ( $pv['ObjectMode'] == 1 ) {
	function returnConfig () {
		$tab = array();
		$tab['type']				= "mysql";
		$tab['charset']				= "utf8mb4";
		$tab['host']				= "mysql";
//		$tab['host']				= "localhost";
// 		$tab['dal']					= "PDOMYSQL";
		$tab['dal']					= "MYSQLI";
		$tab['db_user_login']		= "HydreBDD";
		$tab['db_user_password']	= "Celeste";
		$tab['dbprefix']			= "Hdr";
		$tab['tabprefix']			= "Ht_";
		$tab['maid_stats_nombre_de_couleurs'] = 5;
		$tab['SessionMaxAge'] = (60*60*24);
		$tab['pde_img_aff'] = 1;					// DEPRECATED 
		$tab['pde_img_h'] = 32;						// DEPRECATED //height
		$tab['pde_img_l'] = 32;						// DEPRECATED //width
		
		$tab['DebugLevel_SQL']	= LOGLEVEL_WARNING;					// Préparatif_sql.php
		$tab['DebugLevel_CC']	= LOGLEVEL_WARNING;					// Manipulation_<element>.php
		$tab['DebugLevel_PHP']	= LOGLEVEL_WARNING;					// PHP original debug level
		$tab['DebugLevel_JS']	= LOGLEVEL_WARNING;					// JavaScript
		$tab['LogTarget'] = "internal";				// DEPRECATED 'systeme' (apache log), 'echo' (affichage erreur sur l'ecran), 'aucun' (conserve la comptabilité des états)
		
		$tab['contexte_d_execution'] = "render";	// DEPRECATED 
		$tab['execution_context'] 	= "render";
		$tab['mode_operatoire'] = "connexion_directe";	// DEPRECATED 
		$tab['InsertStatistics'] = 1;
		
		$tab['commandLineEngine'] = array(
				"state"		=>	"enabled",
		);
		return $tab;
	}
}

?>
