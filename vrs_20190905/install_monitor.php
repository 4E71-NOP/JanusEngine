<?php
session_start ();
include_once ("install/install_monitor.php");
if ( session_write_close () === false ){
	$cs = CommonSystem::getInstance ();
	$cs->LMObj->InternalLog ( array ('level' => LOGLEVEL_WARNING, 'msg' => $cs->SMObj->getInfoSessionState()) );
	$cs->LMObj->InternalLog ( array ('level' => LOGLEVEL_WARNING, 'msg' => "session_write_close() returned false. Something went wrong.") );
}
?>
