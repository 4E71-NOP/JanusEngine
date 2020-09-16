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
//	Gen : 2017-08-15
//	www.multiweb-manager.net

// Vous serrez peut etre obligé de rajouter le préfix de votre compte chez l'hébergeur.
// You may need to insert the 'account prefix' depending on web hosters.
// ex DB = <user>_yourdatabase

$db_['type']			= "mysql";
$db_['host']			= "localhost";
$db_['dal']			= "MYSQLI";
$db_['user_login']		= "texmex_MWMdbuser";
$db_['user_password']	= "spacelion";
$db_['dbprefix']		= "texmex_mwm";
$db_['tabprefix']		= "mt_";

//--------------------------------------------------------------------------------------------
//	Admin_info_debug
$maid_stats_nombre_de_couleurs = 5;

//--------------------------------------------------------------------------------------------
//	Session maximum time
$MWM_session_max_time = (60*60*24);

//--------------------------------------------------------------------------------------------
//	websites-datas/00_Hydre/document/fra_presentation_de_l_equipe_p01.php
$pde_img_aff = 1;
$pde_img_h = 32;																	//height
$pde_img_l = 32;																	//width

?>
