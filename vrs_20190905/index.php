<?php
session_start ();
// session_name ( "HydrWebsiteSessionId" );
/* Hydre-licence-debut */
// --------------------------------------------------------------------------------------------
//
// Hydre - Le petit moteur de web
// Sous licence Creative Common
// Under Creative Common licence CC-by-nc-sa (http://creativecommons.org)
// CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
// (c)Faust MARIA DE AREVALO faust@club-internet.fr
//
// --------------------------------------------------------------------------------------------
/* Hydre-licence-fin */

include ("engine/utility/Hydr.php");
$R = Hydr::getInstance();
echo ( $R->render() ) ;

if ( session_write_close () === false ){
	$cs = CommonSystem::getInstance ();
	$cs->LMObj->InternalLog ( array ('level' => LOGLEVEL_WARNING, 'msg' => $cs->SMObj->getInfoSessionState()) );
	$cs->LMObj->InternalLog ( array ('level' => LOGLEVEL_WARNING, 'msg' => "session_write_close() returned false. Something went wrong.") );
}
?>
