<?php
/* Hydre-licence-debut */
// --------------------------------------------------------------------------------------------
//
// Hydre - Le petit moteur de web
// Sous licence Creative Common
// Under Creative Common licence CC-by-nc-sa (http://creativecommons.org)
// CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
// (c)Faust MARIA DE AREVALO faust@rootwave.net
//
// --------------------------------------------------------------------------------------------
/* Hydre-licence-fin */

if(session_status() !== PHP_SESSION_ACTIVE || session_status() === PHP_SESSION_NONE ) {
	if ( session_start() === false ){
		error_log( "*** WARNING *** session_start() returned false. Something went wrong and it's not a good start.");
		error_log( "Save path is = " . session_save_path());
		session_unset();
		session_destroy();
		session_write_close();
		session_name ( "HydrWebsiteSessionId" );
		setcookie(session_name(), '', ['expires' => 0, 'path' => '/']);
		session_regenerate_id(true);
		session_start();
		error_log( "*** WARNING *** Session status (_DISABLED = 0, _NONE = 1, _ACTIVE = 2) => " . session_status() );
	}
}

include_once ("current/install/install_init.php");
$R = HydrInstall::getInstance ();
echo ($R->render ());

if ( session_write_close () === false ){
	$bts = BaseToolSet::getInstance();
	$bts->LMObj->msgLog ( array ('level' => LOGLEVEL_WARNING, 'msg' => $bts->SMObj->getInfoSessionState()) );
	$bts->LMObj->msgLog ( array ('level' => LOGLEVEL_WARNING, 'msg' => "session_write_close() returned false. Something went wrong.") );
}
?>