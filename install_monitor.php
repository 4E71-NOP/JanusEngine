<?php
session_name ( "HydrWebsiteSessionIdMonitor" );
session_start ();
include_once ("current/install/install_monitor.php");
$R = HydrInstallMonitor::getInstance ();
echo ($R->render ());

if ( session_write_close () === false ){
	$bts = BaseToolSet::getInstance();
	$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_WARNING, 'msg' => $bts->SMObj->getInfoSessionState()) );
	$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_WARNING, 'msg' => "session_write_close() returned false. Something went wrong.") );
}
?>
