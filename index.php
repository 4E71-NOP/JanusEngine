<?php
session_name ( "HydrWebsiteSessionId" );
session_start ();
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

include ("current/engine/utility/Hydr.php");
$R = Hydr::getInstance();
echo ( $R->render() ) ;

if ( session_write_close() === false ){
	$bts = BaseToolSet::getInstance();
	$bts->LMObj->msgLog ( array ('level' => LOGLEVEL_WARNING, 'msg' => $bts->SMObj->getInfoSessionState()) );
	$bts->LMObj->msgLog ( array ('level' => LOGLEVEL_WARNING, 'msg' => "session_write_close() returned false. Something went wrong.") );
}
?>
