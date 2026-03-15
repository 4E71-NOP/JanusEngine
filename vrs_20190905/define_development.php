<?php
// --------------------------------------------------------------------------------------------
// THE DEFINE SECTION IS SET HERE AND IT IS FINE.
// If you're slow : Meaning, don't 'define' anyhere else!

/* @var $application String */

// --------------------------------------------------------------------------------------------
// log dedicated to debug and users
// define ("INTERNAL_LOG_LEVEL" , LOGLEVEL_ERROR);

// --------------------------------------------------------------------------------------------
// Logs
define("LOGLEVEL_DEBUG_LVL0",	6); // Byte by byte...
define("LOGLEVEL_BREAKPOINT",	5); // You definitely like to read or you're a crappy developper
define("LOGLEVEL_STATEMENT",	4); // Every statements like "I'm the <class::method> and i recieved this data"
define("LOGLEVEL_INFORMATION",	3); // Moaar
define("LOGLEVEL_WARNING",		2); // More
define("LOGLEVEL_ERROR",		1); // Usual level
define("LOGLEVEL_NO_LOG",		0); // You don't like to read. Or you don't wanna polute your server.

define("SDDM_QUERY_DEFAULT_LOG", 1); // 0 none / 1 log as BREAKPOIINT

$ll = 0;
switch ($application) {
	case 'install':
		$llvsl = LOGLEVEL_WARNING;
		$llvil = LOGLEVEL_WARNING;

		// $llvsl = LOGLEVEL_BREAKPOINT;
		// $llvil = LOGLEVEL_BREAKPOINT;
		break;
	case 'monitor':
		$llvsl = LOGLEVEL_ERROR;
		$llvil = LOGLEVEL_ERROR;

		// $llvsl = LOGLEVEL_WARNING;
		// $llvil = LOGLEVEL_WARNING;

		// $llvsl = LOGLEVEL_BREAKPOINT;
		// $llvil = LOGLEVEL_BREAKPOINT;
		break;
	case 'website':
		$llvsl = LOGLEVEL_WARNING;
		$llvil = LOGLEVEL_WARNING;

		$llvsl = LOGLEVEL_BREAKPOINT;
		$llvil = LOGLEVEL_BREAKPOINT;
		break;
	case 'FileSelector':
		$llvsl = LOGLEVEL_WARNING;
		$llvil = LOGLEVEL_BREAKPOINT;

		$llvsl = LOGLEVEL_BREAKPOINT;
		$llvil = LOGLEVEL_BREAKPOINT;
		break;
	default:
		$llvsl = LOGLEVEL_WARNING;
		$llvil = LOGLEVEL_BREAKPOINT;
		break;
}
define("SYSTEM_LOG_LEVEL", $llvsl);
define("INTERNAL_LOG_LEVEL", $llvil);

define("LOG_CONFIG_DISPLAY_ERROR", 1);
define("LOG_CONFIG_LOG_ERRORS", 'On');
define("LOG_CONFIG_ERROR_LOG", "/var/log/apache2/error.log ");

unset(
	$ll,
	$llvsl,
	$llvil,
);


include('current/define_common.php');

?>