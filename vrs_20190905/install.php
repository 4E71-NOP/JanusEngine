<?php
session_name ( "HydrWebsiteSessionId" );
session_start ();
include_once ("install/install_init.php");
$R = HydrInstall::getInstance ();
$R->render ();
?>